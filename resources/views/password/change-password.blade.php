@extends('layouts.admin')

@section('page_title', 'Change Password')

@section('content')
    <style>
        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #6b7280;
            cursor: pointer;
            font-size: 14px;
        }

        .password-toggle:hover {
            color: #374151;
        }

        .badge-soft {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            background: rgba(37, 99, 235, 0.06);
            color: #1d4ed8;
            border: 1px solid rgba(37, 99, 235, 0.16);
        }

        .pw-strength-bar {
            height: 5px;
            border-radius: 999px;
            background: #e5e7eb;
            overflow: hidden;
            margin-top: 6px;
        }

        .pw-strength-fill {
            height: 100%;
            width: 0%;
            transition: width 0.25s ease;
            background: linear-gradient(90deg, #ef4444, #f97316, #22c55e);
        }

        .pw-strength-label {
            font-size: 11px;
            margin-top: 4px;
            color: #6b7280;
        }
    </style>

    <div class="card-panel" style="padding: 30px;">
        <div class="mb-3 d-flex align-items-center justify-content-between">
            <div>
                <h4 class="mb-1 fw-bold">Change Password</h4>
                <div class="text-muted small">Update your admin password securely.</div>
            </div>
            <div class="badge-soft">
                <i class="fa fa-shield-halved"></i>
                <span>Use a strong and unique password.</span>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        New Password <span class="text-danger">*</span>
                    </label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Enter a new password">
                        <button type="button" class="password-toggle" data-target="#password">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                    <span class="text-danger" id="password_error"></span>
                </div>
                <div class="mb-2">
                    <label class="form-label fw-semibold">
                        Confirm New Password <span class="text-danger">*</span>
                    </label>
                    <div class="password-wrapper">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            placeholder="Re-enter the password">
                        <button type="button" class="password-toggle" data-target="#password_confirmation">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                    <span class="text-danger" id="password_confirmation_error"></span>
                </div>

                <div class="mt-3">
                    <button type="submit" id="change_password_btn" class="px-4 btn btn-primary-gradient">
                        <i class="fa fa-key"></i> Update Password
                    </button>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="p-3 rounded-3" style="background: #f9fafb; border: 1px solid #e5e7eb;">
                    <h6 class="mb-2 fw-semibold"><i class="fa fa-lock me-2"></i>Password Tips</h6>
                    <ul class="small text-muted ps-3">
                        <li>Minimum <strong>6 characters</strong> required.</li>
                        <li>Avoid common or predictable passwords.</li>
                        <li>Do not reuse old passwords.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $(document).on("click", ".password-toggle", function() {
                const target = $(this).data("target");
                const input = $(target);
                const icon = $(this).find("i");

                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                    icon.removeClass("fa-eye").addClass("fa-eye-slash");
                } else {
                    input.attr("type", "password");
                    icon.removeClass("fa-eye-slash").addClass("fa-eye");
                }
            });

            $("#change_password_btn").on("click", function(e) {
                let password = $("#password").val();
                let confirm = $("#password_confirmation").val();

                if (password == '') {
                    $("#password_error").text("Please enter your password");
                    $("#password").focus();
                    return false;
                } else if (password.length < 6) {
                    $("#password_error").text("Password must be at least 6 characters");
                    $("#password").focus();
                    return false;
                } else {
                    $("#password_error").text("");
                }

                if (confirm == '') {
                    $("#password_confirmation_error").text("Please enter your confirm password");
                    $("#password_confirmation").focus();
                    return false;
                } else {
                    $("#password_confirmation_error").text("");
                }

                if (password != confirm) {
                    $("#password_confirmation_error").text("Password Mismatch");
                    $("#password_confirmation").focus();
                    return false;
                } else {
                    $("#password_confirmation").text("");
                }


                $.ajax({
                    url: "{{ route('update.password') }}",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    data: {
                        password: password,
                    },
                    beforeSend: function() {
                        $("#change_password_btn").prop("disabled", true).text("Updating...");
                    },
                    success: function(res) {
                        $("#change_password_btn").prop("disabled", false).html(
                            '<i class="fa fa-key"></i> Update Password');

                        if (res.status) {
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: res.message,
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Something went wrong while creating user.",
                            });
                        }
                    },
                    error: function(xhr) {
                        $("#change_password_btn").prop("disabled", false).html(
                            '<i class="fa fa-key"></i> Update Password');

                        if (xhr.status == 422) {
                            let errors = xhr.responseJSON.errors;
                            let firstKey = Object.keys(errors)[0];
                            let firstMsg = errors[firstKey][0];

                            Swal.fire({
                                icon: "error",
                                title: "Validation Error",
                                text: firstMsg,
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Unexpected error. Please try again later.",
                            });
                        }
                    }
                });

            });

        });
    </script>
@endsection
