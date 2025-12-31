@extends('layouts.admin')
@section('page_title', 'All Products')
@section('content')
    <style>
        .product-card {
            padding: 25px 30px;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }
    </style>

    <div class="card-panel product-card">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">All Products</h4>
            <a href="#" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add Product
            </a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Product</th>

                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <img src="{{ asset($product->thumbnail ?? 'images/no-image.png') }}" width="50"
                                    height="50" class="rounded">
                            </td>

                            <td>
                                <strong>{{ $product->name }}</strong><br>
                                <small class="text-muted">{{ $product->category->name ?? 'N/A' }}</small>
                            </td>

                            <td>
                                ₹{{ number_format($product->price, 2) }}
                            </td>

                            <td>
                                @if ($product->stock > 0)
                                    <span class="badge bg-success">In Stock</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </td>

                            <td>
                                @if ($product->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>

                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                No products found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
