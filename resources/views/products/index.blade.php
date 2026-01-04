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

        .table-scroll-x {
            overflow-x: auto;
            overflow-y: hidden;
            width: 100%;
        }

        /* Optional: smoother scrollbar */
        .table-scroll-x::-webkit-scrollbar {
            height: 8px;
        }

        .table-scroll-x::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .table-scroll-x::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .table-scroll-x table {
            min-width: 1200px;
        }
    </style>

    <div class="card-panel product-card">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">All Products</h4>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add Product
            </a>
        </div>

        <div class="table-scroll-x">
            <table class="table mb-0 text-center align-middle table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Size</th>
                        <th>Mrp</th>
                        <th>Price</th>
                        <th>Save Amount</th>
                        <th>Discount Type</th>
                        <th>Discount Value</th>
                        <th>Stock</th>
                        <th>Stock Status</th>
                        <th>Label</th>
                        <th>Product Description</th>
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
                                {{ $product->category->name ?? '-' }}
                            </td>
                            <td>
                                {{ $product->size ?? '-' }}
                            </td>
                            <td>
                                <span class="fw-bold">
                                    {{ $product->mrp !== null ? '₹' . number_format($product->mrp, 2) : '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold">₹{{ number_format($product->price, 2) }}</span>
                            </td>
                            <td>
                                <span class="fw-bold">
                                    {{ $product->save_amount !== null ? '₹' . number_format($product->save_amount, 2) : '-' }}
                                </span>
                            </td>

                            <td>
                                {{ $product->discount_type ? ucfirst($product->discount_type) : '-' }}
                            </td>

                            <td>
                                @if ($product->discount_type == 'percentage' && $product->discount_value)
                                    {{ $product->discount_value }}%
                                @elseif ($product->discount_type == 'amount' && $product->discount_value)
                                    ₹{{ number_format($product->discount_value, 2) }}
                                @else
                                    -
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

                            @php
                                $label = strtolower($product->label ?? 'none');

                                $badgeClasses = [
                                    'none' => 'bg-secondary',
                                    'new' => 'bg-success',
                                    'trending' => 'bg-warning text-dark',
                                    'sale' => 'bg-danger',
                                ];
                            @endphp

                            <td>
                                <span class="badge {{ $badgeClasses[$label] ?? 'bg-secondary' }}">
                                    {{ ucfirst($label) }}
                                </span>
                            </td>
                            <td>
                                {{ $product->description ?? '-' }}
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
                            <td colspan="14" class="text-center text-muted">
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
