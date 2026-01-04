@extends('layouts.admin')
@section('page_title', 'Add Product')
@section('content')

    <div class="card-panel">
        <style>
            .card-panel {
                padding: 30px;
            }

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
            }

            .label-radio input:checked+span {
                opacity: 1;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }
        </style>
        <h4 class="mb-4">Add New Product</h4>

        <form id="productForm" enctype="multipart/form-data">

            @csrf

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" placeholder="Enter product name" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="select2" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Price <span class="text-danger">*</span></label>
                    <input type="number" name="price" placeholder="Enter price" class="form-control" required>
                </div>


                <div class="col-md-6">
                    <label class="form-label">Size <span class="text-danger">*</span></label>
                    <input type="text" name="size" class="form-control" placeholder="e.g. S, M, L, XL">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Product Label <span class="text-danger">*</span></label>

                    <div class="flex-wrap gap-3 mt-1 d-flex">

                        <label class="label-radio">
                            <input type="radio" name="label" value="" checked>
                            <span class="badge bg-secondary">None</span>
                        </label>

                        <label class="label-radio">
                            <input type="radio" name="label" value="new">
                            <span class="badge bg-success">New</span>
                        </label>

                        <label class="label-radio">
                            <input type="radio" name="label" value="trending">
                            <span class="badge bg-warning text-dark">Trending</span>
                        </label>

                        <label class="label-radio">
                            <input type="radio" name="label" value="sale">
                            <span class="badge bg-danger">Sale</span>
                        </label>

                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Would you like to add a discount? <span class="text-danger">*</span></label>

                    <div class="gap-3 mt-1 d-flex">

                        <label class="label-radio">
                            <input type="radio" name="has_discount" value="no" checked>
                            <span class="badge bg-secondary">No</span>
                        </label>

                        <label class="label-radio">
                            <input type="radio" name="has_discount" value="yes">
                            <span class="badge bg-success">Yes</span>
                        </label>

                    </div>
                </div>

                <div class="col-md-6 d-none" id="discount_type_wrapper">
                    <label class="form-label">Discount Type <span class="text-danger">*</span></label>

                    <div class="gap-3 mt-1 d-flex">

                        <label class="label-radio">
                            <input type="radio" name="discount_type" value="percentage">
                            <span class="badge bg-info text-dark">Percentage (%)</span>
                        </label>

                        <label class="label-radio">
                            <input type="radio" name="discount_type" value="amount">
                            <span class="badge bg-warning text-dark">Amount (₹)</span>
                        </label>

                    </div>
                </div>

                <div class="col-md-6 d-none" id="discount_value_wrapper">
                    <label class="form-label">Discount Value</label>

                    <div class="input-group">
                        <input type="number" id="discount_value" class="form-control" min="1">
                        <span class="input-group-text" id="discount_symbol">%</span>
                    </div>

                    <small class="text-muted" id="discount_hint"></small>
                </div>

                <div class="col-md-12 d-none" id="price_box_wrapper">
                    <label class="form-label">Price Details (Editable)</label>

                    <div class="p-3 border rounded row g-3 bg-light">

                        <div class="col-md-4">
                            <label class="small text-muted">Original Price (MRP) <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" id="mrp" class="form-control" min="0">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="small text-muted">You Save <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" id="save_amount" class="form-control" min="0">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="small text-muted">Sale Price <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" id="sale_price" class="form-control" min="0">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 d-none" id="price_preview_wrapper">
                    <label class="form-label">Price Preview</label>

                    <div class="p-3 border rounded bg-light">
                        <p class="mb-1">
                            <strong>Original Price:</strong>
                            ₹<span id="preview_original">0</span>
                        </p>

                        <p class="mb-1 text-success">
                            <strong>You Save:</strong>
                            ₹<span id="preview_save">0</span>
                        </p>

                        <p class="mb-0">
                            <strong>Sale Price:</strong>
                            <del class="text-muted me-2">₹<span id="preview_old">0</span></del>
                            <span class="fw-bold text-danger">
                                ₹<span id="preview_sale">0</span>
                            </span>
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Stock <span class="text-danger">*</span></label>
                    <input type="number" placeholder="Enter stock" name="stock" id="stock" class="form-control"
                        min="0" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Stock Status <span class="text-danger">*</span></label>
                    <select name="stock_status" id="stock_status" class="select2">
                        <option value="in_stock">In Stock</option>
                        <option value="out_of_stock">Out of Stock</option>
                    </select>
                </div>


                <div class="col-md-6">
                    <label class="form-label">Status&nbsp;<span class="text-danger">*</span></label>
                    <select name="status" class="select2">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Product Description</label>
                    <textarea name="description" placeholder="Enter description" class="form-control"></textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Product Images (Multiple) <span class="text-danger">*</span></label>
                    <input type="file" name="gallery[]" class="form-control" multiple accept="image/*">
                </div>

                <div class="mt-3 col-12">
                    <label class="form-label">Image Preview</label>
                    <div id="image-preview" class="flex-wrap gap-2 mt-2 d-flex"></div>
                </div>


                <div class="mt-3 col-12">
                    <button type="button" id="submitProduct" class="btn btn-primary">
                        <i class="fa fa-save"></i> Save Product
                    </button>

                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        let selectedFiles = [];

        $(document).on('change', 'input[name="gallery[]"]', function(e) {
            const input = this;
            const files = Array.from(e.target.files);

            files.forEach(file => {
                if (!file.type.startsWith('image/')) return;

                selectedFiles.push(file);

                const reader = new FileReader();
                reader.onload = function(e) {
                    const index = selectedFiles.length - 1;

                    $('#image-preview').append(`
                    <div class="image-box" data-index="${index}" style="position:relative;display:inline-block;margin:6px;">
                        <img src="${e.target.result}"
                             style="width:120px;height:120px;border-radius:6px;object-fit:cover;border:1px solid #ddd;">
                        <button type="button"
                            class="remove-image"
                            data-index="${index}"
                            style="
                                position:absolute;
                                top:4px;
                                right:4px;
                                background:red;
                                color:white;
                                border:none;
                                border-radius:50%;
                                width:22px;
                                height:22px;
                                font-size:14px;
                                cursor:pointer;">
                            ×
                        </button>
                    </div>
                `);
                };
                reader.readAsDataURL(file);
            });
            input.value = '';
        });

        $(document).on('click', '.remove-image', function() {
            const index = $(this).data('index');

            selectedFiles.splice(index, 1);

            $('#image-preview').html('');
            selectedFiles.forEach((file, i) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview').append(`
                    <div class="image-box" data-index="${i}" style="position:relative;display:inline-block;margin:6px;">
                        <img src="${e.target.result}"
                             style="width:120px;height:120px;border-radius:6px;object-fit:cover;border:1px solid #ddd;">
                        <button type="button"
                            class="remove-image"
                            data-index="${i}"
                            style="position:absolute;top:4px;right:4px;background:red;color:white;border:none;border-radius:50%;width:22px;height:22px;">
                            ×
                        </button>
                    </div>
                `);
                };
                reader.readAsDataURL(file);
            });

            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            document.querySelector('input[name="gallery[]"]').files = dataTransfer.files;
        });

        $('#stock').on('input', function() {
            let stock = parseInt($(this).val());

            if (stock == 0) {
                $('#stock_status')
                    .val('out_of_stock')
                    .prop('disabled', true)
                    .trigger('change');
            } else {
                $('#stock_status')
                    .prop('disabled', false)
                    .val('in_stock')
                    .trigger('change');
            }
        });


        $('input[name="has_discount"]').on('change', function() {

            if ($(this).val() == 'yes') {

                $('#discount_type_wrapper').removeClass('d-none');

            } else {

                $('#discount_type_wrapper').addClass('d-none');
                $('#discount_value_wrapper').addClass('d-none');
                $('#price_box_wrapper').addClass('d-none');
                $('#price_preview_wrapper').addClass('d-none');

                $('input[name="discount_type"]').prop('checked', false);
                $('#discount_value').val('');

                $('#mrp').val('');
                $('#save_amount').val('');
                $('#sale_price').val('');

            }
        });


        $('input[name="discount_type"]').on('change', function() {
            let type = $(this).val();

            $('#discount_value_wrapper').removeClass('d-none');

            if (type == 'percentage') {
                $('#discount_symbol').text('%');
                $('#discount_hint').text('Displayed as 15% OFF');
            } else {
                $('#discount_symbol').text('₹');
                $('#discount_hint').text('Displayed as ₹200 OFF');
            }
        });

        function showPriceBox() {
            $('#price_box_wrapper').removeClass('d-none');
        }

        function calculateFromDiscount() {

            let salePrice = parseFloat($('input[name="price"]').val());
            let discountType = $('input[name="discount_type"]:checked').val();
            let discountValue = parseFloat($('#discount_value').val());

            if (!salePrice || !discountType || !discountValue) return;

            let saveAmount = discountType == 'percentage' ?
                (salePrice * discountValue) / 100 :
                discountValue;

            let mrp = salePrice + saveAmount;

            $('#sale_price').val(salePrice.toFixed(2));
            $('#save_amount').val(saveAmount.toFixed(2));
            $('#mrp').val(mrp.toFixed(2));

            showPriceBox();
        }


        function calculateFromSale() {
            let sale = parseFloat($('#sale_price').val());
            let save = parseFloat($('#save_amount').val()) || 0;

            $('#mrp').val((sale + save).toFixed(2));
            showPriceBox();
        }

        function calculateFromSave() {
            let sale = parseFloat($('#sale_price').val());
            let save = parseFloat($('#save_amount').val());

            if (!sale) return;

            $('#mrp').val((sale + save).toFixed(2));
            showPriceBox();
        }

        function calculateFromMrp() {
            let mrp = parseFloat($('#mrp').val());
            let sale = parseFloat($('#sale_price').val());

            if (!mrp || !sale) return;

            let save = mrp - sale;
            if (save < 0) save = 0;

            $('#save_amount').val(save.toFixed(2));
            showPriceBox();
        }

        $('input[name="price"]').on('input', calculateFromDiscount);
        $('#discount_value').on('input', calculateFromDiscount);
        $('input[name="discount_type"]').on('change', calculateFromDiscount);

        $('#sale_price').on('input', calculateFromSale);
        $('#save_amount').on('input', calculateFromSave);
        $('#mrp').on('input', calculateFromMrp);

        $('#submitProduct').on('click', function() {

            let formData = new FormData();

            formData.append('_token', '{{ csrf_token() }}');
            formData.append('name', $('input[name="name"]').val());
            formData.append('category_id', $('select[name="category_id"]').val());
            formData.append('size', $('input[name="size"]').val());
            formData.append('stock', $('input[name="stock"]').val());
            formData.append('stock_status', $('select[name="stock_status"]').val());
            formData.append('description', $('textarea[name="description"]').val());
            formData.append('status', $('select[name="status"]').val());
            formData.append('label', $('input[name="label"]:checked').val());

            let hasDiscount = $('input[name="has_discount"]:checked').val();

            let basePrice = $('input[name="price"]').val();
            let salePrice = $('#sale_price').val();
            let mrp = $('#mrp').val();
            let saveAmount = $('#save_amount').val();

            formData.append('price', salePrice !== '' ? salePrice : basePrice);

            if (hasDiscount == 'yes') {

                formData.append('discount_status', 1);

                formData.append(
                    'discount_type',
                    $('input[name="discount_type"]:checked').val()
                );

                formData.append(
                    'discount_value',
                    $('#discount_value').val()
                );

                formData.append('mrp', mrp);
                formData.append('save_amount', saveAmount);

            } else {

                formData.append('discount_status', 0);

                formData.append('discount_type', '');
                formData.append('discount_value', '');
                formData.append('mrp', '');
                formData.append('save_amount', '');
            }

            selectedFiles.forEach(file => {
                formData.append('gallery[]', file);
            });

            let btn = $(this);
            btn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: "{{ route('products.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Product added successfully'
                    }).then(() => {
                        window.location.href = "{{ route('products.index') }}";
                    });
                },
                error: function(xhr) {

                    btn.prop('disabled', false).html('<i class="fa fa-save"></i> Save Product');

                    if (xhr.status == 422 && xhr.responseJSON && xhr.responseJSON.errors) {

                        const errors = xhr.responseJSON.errors;

                        const firstKey = Object.keys(errors)[0];
                        const firstMessage = errors[firstKey][0];

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: firstMessage,
                            confirmButtonColor: '#e10600'
                        });

                        return;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong!',
                        confirmButtonColor: '#e10600'
                    });
                }


            });
        });
    </script>
@endsection
