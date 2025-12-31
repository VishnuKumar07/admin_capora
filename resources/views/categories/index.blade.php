@extends('layouts.admin')
@section('page_title', 'Categories')
@section('content')
    <style>
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
    <div class="card-panel">

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Categories</h4>

            <a href="javascript:void(0)" class="btn btn-primary" id="addCategoryBtn">
                <i class="fa fa-plus"></i> Add Category
            </a>

        </div>

        <div class="table-responsive">
            <table class="table text-center align-middle table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>Status</th>
                        <th style="width: 200px;">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    <label class="switch">
                                        <input type="checkbox" class="status-toggle" data-id="{{ $category->id }}"
                                            {{ $category->status == 'Active' ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="gap-1 d-flex justify-content-center">

                                    <button type="button" class="btn btn-sm btn-warning edit-btn"
                                        data-id="{{ $category->id }}" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    <button type="button" class="btn btn-sm btn-danger delete-btn"
                                        data-id="{{ $category->id }}" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="editCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="edit_category_id">

                    <div class="mb-3">
                        <label class="form-label">Category Name&nbsp;<span class="text-danger">*</span></label>
                        <input type="text" id="edit_category_name" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" id="updateCategoryBtn">Update</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" id="new_category_name" class="form-control" placeholder="Enter category name">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" id="saveCategoryBtn">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            $('#addCategoryBtn').on('click', function() {
                $('#new_category_name').val('');
                $('#addCategoryModal').modal('show');
            });

            $('#saveCategoryBtn').on('click', function() {
                let name = $('#new_category_name').val().trim();

                if (name == '') {
                    Swal.fire('Error', 'Category name is required', 'error');
                    return;
                }

                $.ajax({
                    url: "{{ route('categories.store') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: name
                    },
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Added!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to add category', 'error');
                    }
                });
            });


            $(document).on('click', '.edit-btn', function() {
                let id = $(this).data('id');
                let name = $(this).closest('tr').find('td:nth-child(2)').text().trim();
                $('#edit_category_id').val(id);
                $('#edit_category_name').val(name);

                $('#editCategoryModal').modal('show');
            });

            $('#updateCategoryBtn').on('click', function() {
                let id = $('#edit_category_id').val();
                let name = $('#edit_category_name').val();

                if (name == '') {
                    Swal.fire('Error', 'Category name is required', 'error');
                    return;
                }

                $.ajax({
                    url: "{{ route('categories.update') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        name: name
                    },
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to update category', 'error');
                    }
                });
            });

            $(document).on('change', '.status-toggle', function() {
                let id = $(this).data('id');
                let status = $(this).is(':checked') ? 'Active' : 'Inactive';
                Swal.fire({
                    title: 'Change Status?',
                    text: `Change status to ${status}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ route('categories.statusupdate') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id,
                                status: status
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated!',
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            },
                            error: function() {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong.',
                                    'error'
                                );
                            }
                        });

                    } else {
                        $(this).prop('checked', !$(this).prop('checked'));
                    }
                });
            });

            $(document).on('click', '.delete-btn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This Category will be deleted permanently!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('categories.delete') }}",
                            type: "POST",
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            },
                            data: {
                                id: id
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function() {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong. Please try again.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
