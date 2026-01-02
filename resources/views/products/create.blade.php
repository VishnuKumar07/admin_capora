@extends('layouts.admin')
@section('page_title', 'Add Product')
@section('content')

    <div class="card-panel">
        <style>
            .card-panel {
                padding: 30px;
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

                <div class="col-md-4">
                    <label class="form-label">Price <span class="text-danger">*</span></label>
                    <input type="number" name="price" placeholder="Enter price" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Sale Price</label>
                    <input type="number" name="sale_price" placeholder="Enter sale price" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Size <span class="text-danger">*</span></label>
                    <input type="text" name="size" class="form-control" placeholder="e.g. S, M, L, XL">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Stock <span class="text-danger">*</span></label>
                    <input type="number" placeholder="Enter stock" name="stock" id="stock" class="form-control" min="0" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Stock Status</label>
                    <select name="stock_status" id="stock_status" class="select2">
                        <option value="in_stock">In Stock</option>
                        <option value="out_of_stock">Out of Stock</option>
                    </select>
                </div>


                <div class="col-md-4">
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
                    <label class="form-label">Product Images (Multiple)</label>
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

        $('#submitProduct').on('click', function() {

            let formData = new FormData();

            formData.append('_token', '{{ csrf_token() }}');
            formData.append('name', $('input[name="name"]').val());
            formData.append('category_id', $('select[name="category_id"]').val());
            formData.append('price', $('input[name="price"]').val());
            formData.append('sale_price', $('input[name="sale_price"]').val());
            formData.append('size', $('input[name="size"]').val());
            formData.append('stock', $('input[name="stock"]').val());
            formData.append('stock_status', $('select[name="stock_status"]').val());
            formData.append('description', $('textarea[name="description"]').val());
            formData.append('status', $('select[name="status"]').val());

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
                success: function(response) {
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
                    let msg = 'Something went wrong!';
                    if (xhr.responseJSON?.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire('Error', msg, 'error');
                }
            });
        });
    </script>

@endsection
