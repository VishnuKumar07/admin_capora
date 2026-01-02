<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')->orderBy('id', 'desc')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create',compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name'        => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'price'       => 'required|numeric|min:0',
                'sale_price'  => 'nullable|numeric|min:0',
                'stock'       => 'required|integer|min:0',
                'size'        => 'required',
                'status'      => 'required|in:active,inactive',
                'gallery'     => 'required|array|min:1',
                'gallery.*'   => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            ],
            [
                'name.required'        => 'Product name is required.',
                'category_id.required' => 'Please select a category.',
                'category_id.exists'   => 'Selected category is invalid.',
                'price.required'       => 'Product price is required.',
                'price.numeric'        => 'Price must be a number.',
                'sale_price.numeric'   => 'Sale price must be a number.',
                'stock.required'       => 'Stock quantity is required.',
                'stock.integer'        => 'Stock must be a valid number.',
                'size.required'        => 'Please select a size.',
                'status.required'      => 'Product status is required.',
                'status.in'            => 'Invalid product status.',
                'gallery.required'     => 'Please upload at least one product image.',
                'gallery.array'        => 'Gallery must be an image array.',
                'gallery.*.image'      => 'Each file must be an image.',
                'gallery.*.mimes'      => 'Images must be jpg, jpeg, png, or webp.',
                'gallery.*.max'        => 'Each image must be less than 2MB.',
            ]
        );

        $slug = Str::slug($request->name);
        $count = Product::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        $galleryImages = [];
        $thumbnailPath = null;

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('products/gallery'), $filename);

                $path = 'products/gallery/' . $filename;
                $galleryImages[] = $path;

                if ($index == 0) {
                    $thumbnailPath = $path;
                }
            }
        }

        $product = Product::create([
            'name'        => $request->name,
            'slug'        => $slug,
            'category_id' => $request->category_id,
            'size'        => $request->size,
            'price'       => $request->price,
            'sale_price'  => $request->sale_price,
            'stock'       => $request->stock,
            'stock_status'=> $request->stock > 0 ? 'in_stock' : 'out_of_stock',
            'description' => $request->description,
            'thumbnail'   => $thumbnailPath,
            'gallery'     => json_encode($galleryImages),
            'status'      => $request->status,
        ]);

        Inventory::create([
            'product_id'    => $product->id,
            'stock'         => $request->stock,
            'status'        => 'active',
            'stock_status'  => $request->stock > 0 ? 'in_stock' : 'out_of_stock',
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id'
        ]);
        $product = Product::find($request->productId);
        if ($product->thumbnail && file_exists(public_path($product->thumbnail))) {
            unlink(public_path($product->thumbnail));
        }
        if ($product->gallery) {
            $images = json_decode($product->gallery, true);
            foreach ($images as $image) {
                if (file_exists(public_path($image))) {
                    unlink(public_path($image));
                }
            }
        }
        if (method_exists($product, 'inventory')) {
            $product->inventory()->delete();
        }
        $product->delete();
        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'status' => 'required|in:active,inactive'
        ]);

        $product = Product::find($request->id);

        $product->status = $request->status;
        $product->save();

        Inventory::where('product_id', $product->id)
            ->update([
                'status' => $request->status,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Product status updated successfully.'
        ]);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'sale_price'  => 'nullable|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'size'        => 'required',
            'status'      => 'required|in:active,inactive',
            'gallery.*'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product = Product::findOrFail($id);

        if ($product->name !== $request->name) {
            $slug = Str::slug($request->name);
            $count = Product::where('slug', 'LIKE', "$slug%")->where('id', '!=', $id)->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }
            $product->slug = $slug;
        }

        if ($request->hasFile('gallery')) {
            if ($product->gallery) {
                foreach (json_decode($product->gallery) as $img) {
                    if (file_exists(public_path($img))) {
                        unlink(public_path($img));
                    }
                }
            }

            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('products/gallery'), $filename);
                $gallery[] = 'products/gallery/' . $filename;
            }

            $product->gallery = json_encode($gallery);
            $product->thumbnail = $gallery[0] ?? null;
        }

        $product->update([
            'name'        => $request->name,
            'category_id' => $request->category_id,
            'price'       => $request->price,
            'sale_price'  => $request->sale_price,
            'stock'       => $request->stock,
            'size'        => $request->size,
            'status'      => $request->status,
            'stock_status'=> $request->stock > 0 ? 'in_stock' : 'out_of_stock',
            'description' => $request->description,
        ]);

        Inventory::updateOrCreate(
            ['product_id' => $product->id],
            [
                'stock' => $request->stock,
                'status' => $request->status
            ]
        );

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }
}
