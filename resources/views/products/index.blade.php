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

        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 26px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background-color: #dc3545;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #28a745;
        }

        input:checked+.slider:before {
            transform: translateX(22px);
        }
    </style>

    <div class="card-panel product-card">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">All Products</h4>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add Product
            </a>
        </div>

        <div class="table-responsive">
            <table class="table text-center align-middle table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Stock Status</th>
                        <th>Product Status</th>
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
                                @if ($product->sale_price)
                                    <span class="text-danger fw-bold">₹{{ number_format($product->sale_price, 2) }}</span>
                                    <del class="text-muted">₹{{ number_format($product->price, 2) }}</del>
                                @else
                                    <span class="fw-bold">₹{{ number_format($product->price, 2) }}</span>
                                @endif
                            </td>
                            <td>
                                {{ $product->stock ?? 0 }}
                            </td>

                            <td>
                                @if ($product->stock > 0)
                                    <span class="badge bg-success">In Stock</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </td>

                            <td>
                                <label class="switch">
                                    <input type="checkbox" class="toggle-status" data-id="{{ $product->id }}"
                                        {{ $product->status == 'active' ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <button class="btn btn-sm btn-outline-danger delete-btn" data-id="{{ $product->id }}">
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
@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('change', '.toggle-status', function() {
                let productId = $(this).data('id');
                let status = $(this).is(':checked') ? 'active' : 'inactive';
                Swal.fire({
                    title: 'Change Status?',
                    text: 'Do you want to update product status?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('product.status.update') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: productId,
                                status: status
                            },
                            success: function() {
                                Swal.fire('Updated!', 'Status updated successfully.',
                                    'success');
                            },
                            error: function() {
                                Swal.fire('Error', 'Unable to update status', 'error');
                            }
                        });
                    } else {
                        $(this).prop('checked', !$(this).prop('checked'));
                    }
                });
            });

            $(document).on('click', '.delete-btn', function() {
                let productId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This product will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('product.delete') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                productId: productId
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Product has been deleted successfully.',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function() {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong while deleting the product.',
                                    'error'
                                );
                            }
                        });

                    }
                });
            });

        })
    </script>
@endsection
