@extends('layouts.admin')
@section('page_title', 'Edit Product')

@section('content')
<div class="card-panel">
    <h4 class="mb-4">Edit Product</h4>

    <form id="productForm" method="POST" enctype="multipart/form-data"
          action="{{ route('products.update', $product->id) }}">
        @csrf

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Product Name *</label>
                <input type="text" name="name" class="form-control"
                       value="{{ $product->name }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Category *</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Price *</label>
                <input type="number" name="price" class="form-control"
                       value="{{ $product->price }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Sale Price</label>
                <input type="number" name="sale_price" class="form-control"
                       value="{{ $product->sale_price }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Size</label>
                <input type="text" name="size" class="form-control"
                       value="{{ $product->size }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control"
                       value="{{ $product->stock }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control">{{ $product->description }}</textarea>
            </div>

            <div class="mt-3 col-12">
                <label class="form-label">Current Images</label>
                <div class="flex-wrap gap-2 d-flex">
                    @if($product->gallery)
                        @foreach(json_decode($product->gallery) as $img)
                            <img src="{{ asset($img) }}"
                                 width="90"
                                 class="border rounded">
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="mt-3 col-12">
                <label class="form-label">Replace Images (Optional)</label>
                <input type="file" name="gallery[]" multiple class="form-control">
            </div>

            <div class="mt-4 col-12">
                <button class="btn btn-primary">
                    <i class="fa fa-save"></i> Update Product
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
