@extends('layouts.admin')
@section('page_title', 'Coupons')

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

        .custom-table-scroll {
            overflow-x: auto;
            width: 100%;
        }

        .custom-table-scroll table {
            min-width: 1200px;
        }
    </style>
    <div class="p-4 card">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <h4>Coupons</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCouponModal">
                <i class="fa fa-plus"></i> Add Coupon
            </button>
        </div>
        <div class="table-responsive custom-table-scroll">
            <table class="table mt-3 text-center table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Status</th>
                        <th>Expiry</th>
                        <th>Usage Limit Type</th>
                        <th>User Limit</th>
                        <th>Per User Limit Type</th>
                        <th>Per User Limit</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($coupons as $coupon)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $coupon->code }}</td>
                            <td>{{ ucfirst($coupon->type) }}</td>
                            <td>{{ $coupon->value }}</td>
                            <td>
                                @if ($coupon->status == 'active')
                                    <label class="switch">
                                        <input type="checkbox" class="toggle-status" data-id="{{ $coupon->id }}" checked>
                                        <span class="slider"></span>
                                    </label>
                                @elseif ($coupon->status == 'inactive')
                                    <label class="switch">
                                        <input type="checkbox" class="toggle-status" data-id="{{ $coupon->id }}">
                                        <span class="slider"></span>
                                    </label>
                                @elseif ($coupon->status == 'expired')
                                    <span class="badge bg-danger">Expired</span>
                                @endif
                            </td>
                            <td>{{ $coupon->expiry_date ?? '-' }}</td>
                            <td>{{ ucfirst($coupon->usage_limit_type ?? '-') }}</td>
                            <td>{{ $coupon->user_limit ?? '-' }}</td>
                            <td>{{ ucfirst($coupon->per_user_limit_type ?? '-') }}</td>
                            <td>{{ $coupon->per_user_limit ?? '-' }}</td>

                            <td>
                                <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $coupon->id }}"
                                    data-code="{{ $coupon->code }}" data-type="{{ $coupon->type }}"
                                    data-value="{{ $coupon->value }}"
                                    data-usage_limit_type="{{ $coupon->usage_limit_type }}"
                                    data-user_limit="{{ $coupon->user_limit }}"
                                    data-per_user_limit_type="{{ $coupon->per_user_limit_type }}"
                                    data-per_user_limit="{{ $coupon->per_user_limit }}"
                                    data-expiry="{{ $coupon->expiry_date }}" data-status="{{ $coupon->status }}">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $coupon->id }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="py-4 text-center text-muted">
                                <i class="mb-2 fa fa-box-open fa-2x"></i><br>
                                No coupons found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addCouponModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add Coupon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <input type="hidden" id="coupon_id">

                        <div class="col-md-6">
                            <label class="form-label">Coupon Code&nbsp;<span class="text-danger">*</span></label>
                            <input type="text" id="code" name="code" class="form-control"
                                placeholder="e.g. SAVE10">
                            <span class="text-danger" id="code_error"></span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Discount Type&nbsp;<span class="text-danger">*</span></label>
                            <select name="type" id="type" class="select2">
                                <option value="">Select Discount Type</option>
                                <option value="percentage">Percentage</option>
                                <option value="flat">Flat</option>
                            </select>
                            <span class="text-danger" id="type_error"></span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Discount Value&nbsp;<span class="text-danger">*</span></label>
                            <input type="number" id="value" name="value" class="form-control" placeholder="e.g. 10">
                            <span class="text-danger" id="value_error"></span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Usage Limit Type&nbsp;<span class="text-danger">*</span></label>
                            <select name="usage_limit_type" id="usage_limit_type" class="select2">
                                <option value="">Select Limit Type</option>
                                <option value="limited">Limited</option>
                                <option value="unlimited">Unlimited</option>
                            </select>
                            <span class="text-danger" id="usage_limit_type_error"></span>
                        </div>

                        <div class="col-md-6" style="display: none" id="user_limit_div">
                            <label class="form-label">User Limit&nbsp;<span class="text-danger">*</span></label>
                            <input type="number" id="user_limit" name="user_limit" class="form-control"
                                placeholder="e.g. 100">
                            <span class="text-danger" id="user_limit_error"></span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Per User Limit Type&nbsp;<span class="text-danger">*</span></label>
                            <select name="per_user_limit_type" id="per_user_limit_type" class="select2">
                                <option value="">Select Limit Type</option>
                                <option value="limited">Limited</option>
                                <option value="unlimited">Unlimited</option>
                            </select>
                            <span id="per_user_limit_type_error" class="text-danger"></span>
                        </div>

                        <div class="col-md-6" style="display: none" id="per_user_limit_div">
                            <label class="form-label">Per User Limit&nbsp;<span class="text-danger">*</span></label>
                            <input type="number" id="per_user_limit" name="per_user_limit" class="form-control"
                                placeholder="e.g. 1">
                            <span id="per_user_limit_error" class="text-danger"></span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Expiry Date&nbsp;<span class="text-danger">*</span></label>
                            <input type="date" id="expiry_date" name="expiry_date" class="form-control">
                            <span id="expiry_date_error" class="text-danger"></span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status&nbsp;<span class="text-danger">*</span></label>
                            <select name="status" id="status" class="select2">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <span id="status_error" class="text-danger"></span>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button id="save_btn" type="submit" class="btn btn-primary">
                        Save Coupon
                    </button>
                </div>

            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#usage_limit_type").change(function() {

                let usage_limit_type = $(this).val()
                if (usage_limit_type == 'limited') {
                    $("#user_limit_div").show()
                } else {
                    $("#user_limit_div").hide()
                }
            })

            $("#per_user_limit_type").change(function() {

                let per_user_limit = $(this).val()
                if (per_user_limit == 'limited') {
                    $("#per_user_limit_div").show()
                } else {
                    $("#per_user_limit_div").hide()
                }
            })

            $(document).on('click', '.edit-btn', function() {

                let btn = $(this);

                $('#coupon_id').val(btn.data('id'));
                $('#code').val(btn.data('code'));
                $('#type').val(btn.data('type')).trigger('change');
                $('#value').val(btn.data('value'));
                $('#usage_limit_type').val(btn.data('usage_limit_type')).trigger('change');
                $('#user_limit').val(btn.data('user_limit'));
                $('#per_user_limit_type').val(btn.data('per_user_limit_type')).trigger('change');
                $('#per_user_limit').val(btn.data('per_user_limit'));
                $('#expiry_date').val(btn.data('expiry'));
                $('#status').val(btn.data('status'));

                $('.modal-title').text('Edit Coupon');
                $('#save_btn').text('Update Coupon');

                $('#addCouponModal').modal('show');
            });


            $("#save_btn").click(function() {

                let btn = $(this);

                let id = $("#coupon_id").val();
                let url = id ? "{{ route('coupons.update') }}" : "{{ route('coupons.store') }}";
                let code = $("#code").val()
                let type = $("#type").val()
                let value = $("#value").val()
                let usage_limit_type = $("#usage_limit_type").val()
                let user_limit = $("#user_limit").val()
                let per_user_limit_type = $("#per_user_limit_type").val()
                let per_user_limit = $("#per_user_limit").val()
                let expiry_date = $("#expiry_date").val()
                let status = $("#status").val()

                if (code == '') {
                    $("#code_error").text("Please enter coupon code")
                    $("#code").focus()
                    return false
                } else {
                    $("#code_error").text("")
                }

                if (type == '') {
                    $("#type_error").text("Please select discount type");
                    $("#type").focus();
                    return false;
                } else {
                    $("#type_error").text("");
                }

                if (value == '') {
                    $("#value").focus();
                    $("#value_error").text("Please select discount value");
                    return false;
                } else {
                    $("#value_error").text("");
                }

                if (usage_limit_type == '') {
                    $("#usage_limit_type_error").text("Please select usage limit type");
                    $("#usage_limit_type").focus();
                    return false;
                } else {
                    $("#usage_limit_type_error").text("");
                }

                if ($("#user_limit_div").is(":visible")) {
                    if (user_limit == '') {
                        $("#user_limit_error").text("Please enter user limit");
                        $("#user_limit").focus();
                        return false;
                    } else {
                        $("#user_limit_error").text("");
                    }
                }

                if (per_user_limit_type == '') {
                    $("#per_user_limit_type").focus();
                    $("#per_user_limit_type_error").text("Please select per user limit type");
                    return false;
                } else {
                    $("#per_user_limit_type_error").text("");
                }

                if ($("#per_user_limit_div").is(":visible")) {
                    if (per_user_limit == '') {
                        $("#per_user_limit").focus();
                        $("#per_user_limit_error").text("Please enter per user limit")
                        return false;
                    } else {
                        $("#per_user_limit_error").text("")
                    }
                }

                if (expiry_date == '') {
                    $("#expiry_date").focus();
                    $("#expiry_date_error").text("Please select expiry date")
                    return false;
                } else {
                    $("#expiry_date_error").text("")
                }

                if (status == '') {
                    $("#status").focus();
                    $("#status_error").text("Please select status")
                    return false;
                } else {
                    $("#status_error").text("")
                }

                let data = {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    code: $("#code").val(),
                    type: $("#type").val(),
                    value: $("#value").val(),
                    usage_limit_type: $("#usage_limit_type").val(),
                    user_limit: $("#user_limit").val(),
                    per_user_limit_type: $("#per_user_limit_type").val(),
                    per_user_limit: $("#per_user_limit").val(),
                    expiry_date: $("#expiry_date").val(),
                    status: $("#status").val()
                };

                btn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: url,
                    type: "POST",
                    data: data,
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
                        btn.prop('disabled', false).text('Save');
                        Swal.fire('Error', 'Failed to add category', 'error');
                    }
                });
            })

            $(document).on('change', '.toggle-status', function() {

                let checkbox = $(this);
                let couponId = checkbox.data('id');
                let status = checkbox.is(':checked') ? 'active' : 'inactive';

                $.ajax({
                    url: "{{ route('coupons.toggle-status') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: couponId,
                        status: status
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated',
                                text: response.message,
                                timer: 1200,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Something went wrong!', 'error');
                        checkbox.prop('checked', !checkbox.prop('checked'));
                    }
                });
            });


            $(document).on('click', '.delete-btn', function() {
                let couponId = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This coupon will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ route('coupons.destroy', ':id') }}".replace(':id',
                                couponId),
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                                $('button[data-id="' + couponId + '"]').closest('tr')
                                    .fadeOut(500, function() {
                                        $(this).remove();
                                    });
                            },
                            error: function() {
                                Swal.fire('Error', 'Something went wrong!', 'error');
                            }
                        });

                    }
                });
            });

        })
    </script>
@endsection
