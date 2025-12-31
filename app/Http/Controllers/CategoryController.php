<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('categories.index', compact('categories'));
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }
        $category->delete();
        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully'
        ]);
    }

    public function statusUpdate(Request $request)
    {
        $category = Category::find($request->id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $category->status = ($category->status == 'Active') ? 'Inactive' : 'Active';
        $category->save();
        return response()->json([
            'status' => true,
            'message' => 'Category status updated successfully',
            'new_status' => $category->status
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'   => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
        ]);

        $slug = Str::slug($request->name);

        $count = Category::where('slug', $slug)
            ->where('id', '!=', $request->id)
            ->count();

        if ($count > 0) {
            $slug = $slug . '-' . time();
        }

        Category::where('id', $request->id)->update([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return response()->json([
            'message' => 'Category updated successfully'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $slug = Str::slug($request->name);

        if (Category::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'status' => 'Active',
        ]);

        return response()->json([
            'message' => 'Category added successfully'
        ]);
    }


}
