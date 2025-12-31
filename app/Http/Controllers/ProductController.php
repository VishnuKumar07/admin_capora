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
            'product_id' => $product->id,
            'stock'      => $request->stock,
            'status'     => $request->stock > 0 ? 'in_stock' : 'out_of_stock',
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

}
