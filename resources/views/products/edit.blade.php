@extends('layouts.admin')
@section('page_title', 'Edit Product')

@section('content')
    <style>
        .label-radio {
            cursor: pointer;
        }

        .label-radio input {
            display: none;
        }

        .label-radio span {
            padding: 8px 16px;
            font-size: 13px;
            border-radius: 20px;
            opacity: 0.6;
            transition: 0.3s;
            display: inline-block;
        }

        .label-radio input:checked+span {
            opacity: 1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
    <div class="card-panel">
        <h4 class="mb-4">Edit Product</h4>

        <form id="productForm" method="POST" enctype="multipart/form-data"
            action="{{ route('products.update', $product->id) }}">
            @csrf

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="select2" required>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Price <span class="text-danger">*</span></label>
                    <input type="number" name="price" id="base_price" class="form-control" value="{{ $product->price }}">

                </div>

                <div class="col-md-6">
                    <label class="form-label">Size <span class="text-danger">*</span></label>
                    <input type="text" name="size" class="form-control" value="{{ $product->size }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Product Label <span class="text-danger">*</span></label>
                    <div class="flex-wrap gap-3 mt-1 d-flex">
                        <label class="label-radio">
                            <input type="radio" name="label" value=""
                                {{ empty($product->label) ? 'checked' : '' }}>
                            <span class="badge bg-secondary">None</span>
                        </label>

                        <label class="label-radio">
                            <input type="radio" name="label" value="new"
                                {{ $product->label == 'new' ? 'checked' : '' }}>
                            <span class="badge bg-success">New</span>
                        </label>

                        <label class="label-radio">
                            <input type="radio" name="label" value="trending"
                                {{ $product->label == 'trending' ? 'checked' : '' }}>
                            <span class="badge bg-warning text-dark">Trending</span>
                        </label>

                        <label class="label-radio">
                            <input type="radio" name="label" value="sale"
                                {{ $product->label == 'sale' ? 'checked' : '' }}>
                            <span class="badge bg-danger">Sale</span>
                        </label>

                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Would you like to add a discount? <span class="text-danger">*</span></label>

                    <div class="gap-3 mt-1 d-flex">

                        <label class="label-radio">
                            <input type="radio" name="discount_status" value="0"
                                {{ $product->discount_status == 0 ? 'checked' : '' }}>
                            <span class="badge bg-secondary">No</span>
                        </label>

                        <label class="label-radio">
                            <input type="radio" name="discount_status" value="1"
                                {{ $product->discount_status == 1 ? 'checked' : '' }}>
                            <span class="badge bg-success">Yes</span>
                        </label>

                    </div>
                </div>


                <div class="col-md-6 {{ $product->discount_status == 1 ? '' : 'd-none' }}" id="discount_type_wrapper">
                    <label class="form-label">Discount Type <span class="text-danger">*</span></label>

                    <div class="gap-3 mt-1 d-flex">
                        <label class="label-radio">
                            <input type="radio" name="discount_type" value="percentage"
                                {{ $product->discount_type == 'percentage' ? 'checked' : '' }}>
                            <span class="badge bg-info text-dark">Percentage (%)</span>
                        </label>

                        <label class="label-radio">
                            <input type="radio" name="discount_type" value="amount"
                                {{ $product->discount_type == 'amount' ? 'checked' : '' }}>
                            <span class="badge bg-warning text-dark">Amount (₹)</span>
                        </label>
                    </div>
                </div>

                <div class="col-md-6 {{ $product->discount_status == 1 ? '' : 'd-none' }}" id="discount_value_wrapper">
                    <label class="form-label">Discount Value <span class="text-danger">*</span></label>

                    <div class="input-group">
                        <input type="number" name="discount_value" class="form-control" min="0"
                            value="{{ $product->discount_value }}">
                        <span class="input-group-text" id="discount_symbol">
                            {{ $product->discount_type == 'percentage' ? '%' : '₹' }}
                        </span>
                    </div>
                </div>

                <div class="col-md-12 {{ $product->discount_status == 1 ? '' : 'd-none' }}" id="price_box_wrapper">
                    <label class="form-label">Price Details (Editable)</label>

                    <div class="p-3 border rounded row g-3 bg-light">

                        <div class="col-md-4">
                            <label class="small text-muted">Original Price (MRP) <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" name="mrp" id="mrp_price" class="form-control"
                                    value="{{ $product->mrp }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="small text-muted">You Save <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" name="save_amount" id="save_amount" class="form-control"
                                    value="{{ $product->save_amount }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="small text-muted">Sale Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" name="price" id="sale_price" class="form-control"
                                    value="{{ $product->price }}">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Stock <span class="text-danger">*</span></label>
                    <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Stock Status <span class="text-danger">*</span></label>
                    <select name="stock_status" id="stock_status" class="select2">
                        <option value="in_stock" {{ $product->stock_status == 'in_stock' ? 'selected' : '' }}>
                            In Stock
                        </option>

                        <option value="out_of_stock" {{ $product->stock_status == 'out_of_stock' ? 'selected' : '' }}>
                            Out of Stock
                        </option>
                    </select>
                </div>


                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select">
                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Product Description</label>
                    <textarea name="description" class="form-control">{{ $product->description }}</textarea>
                </div>

                <div class="mt-3 col-12">
                    <label class="form-label">Current Images</label>
                    <div class="flex-wrap gap-2 d-flex">
                        @if ($product->gallery)
                            @foreach (json_decode($product->gallery) as $img)
                                <img src="{{ asset($img) }}" width="90" class="border rounded">
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
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let errorMessages = `{!! implode('<br>', $errors->all()) !!}`;

            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: errorMessages,
                confirmButtonColor: '#e10600'
            });
        });
    </script>
@endif
@section('scripts')
    <script>
        $(document).ready(function() {
            function calculateFromDiscount() {
                let salePrice = parseFloat($('#sale_price').val());
                let discountType = $('input[name="discount_type"]:checked').val();
                let discountValue = parseFloat($('input[name="discount_value"]').val());

                if (!salePrice || !discountType || !discountValue) return;

                let saveAmount = 0;

                if (discountType == 'percentage') {
                    saveAmount = (salePrice * discountValue) / 100;
                } else {
                    saveAmount = discountValue;
                }

                let mrp = salePrice + saveAmount;

                $('#save_amount').val(saveAmount.toFixed(2));
                $('#mrp_price').val(mrp.toFixed(2));
            }

            function calculateFromMrp() {
                let mrp = parseFloat($('#mrp_price').val());
                let sale = parseFloat($('#sale_price').val());

                if (!mrp || !sale) return;

                let save = mrp - sale;
                if (save < 0) save = 0;

                $('#save_amount').val(save.toFixed(2));
            }

            function calculateFromSave() {
                let sale = parseFloat($('#sale_price').val());
                let save = parseFloat($('#save_amount').val());

                if (!sale || !save) return;

                let mrp = sale + save;
                $('#mrp_price').val(mrp.toFixed(2));
            }

            $('#base_price').on('input', function() {
                let basePrice = parseFloat($(this).val());
                if (!basePrice) return;
                $('#sale_price').val(basePrice);
                calculateFromDiscount();
            });

            $('input[name="discount_status"]').on('change', function() {
                let status = $(this).val();
                if (status == '1') {
                    $('#discount_type_wrapper').removeClass('d-none');
                    $('#discount_value_wrapper').removeClass('d-none');
                    $('#price_box_wrapper').removeClass('d-none');
                    calculateFromDiscount();

                } else {
                    $('#discount_type_wrapper').addClass('d-none');
                    $('#discount_value_wrapper').addClass('d-none');
                    $('#price_box_wrapper').addClass('d-none');
                }
            });

            $('input[name="discount_value"]').on('input', calculateFromDiscount);
            $('input[name="discount_type"]').on('change', calculateFromDiscount);
            $('#sale_price').on('input', calculateFromDiscount);
            $('#mrp_price').on('input', calculateFromMrp);
            $('#save_amount').on('input', calculateFromSave);

            $('input[name="stock"]').on('input', function() {
                let stock = parseInt($(this).val());
                if (stock == 0) {
                    $('#stock_status')
                        .val('out_of_stock')
                        .trigger('change')
                        .prop('disabled', true);
                } else if (stock > 0) {
                    $('#stock_status')
                        .val('in_stock')
                        .trigger('change')
                        .prop('disabled', false);
                }
            });

            $('input[name="stock"]').trigger('input');


        });
    </script>
@endsection
