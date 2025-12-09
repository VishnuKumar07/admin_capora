@extends('layouts.admin')
@section('page_title', 'Add New User')
@section('content')
    <style>
        .iti {
            width: 100%;
        }

        input[readonly] {
            background-color: #f1f3f5 !important;
            cursor: not-allowed;
        }
    </style>
    <div class="card-panel">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Add New User</h4>
            <a href="{{ route('users') }}" class="px-3 py-2 btn btn-primary-gradient">
                <i class="fa fa-users"></i> All Users
            </a>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Name&nbsp;<span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" placeholder="Enter user name" class="form-control">
                <span class="text-danger" id="name_error"></span>
            </div>

            <div class="col-md-6">
                <label for="mobile" class="form-label">Mobile / WhatsApp Number
                    <span class="text-danger">*</span></label>
                <input id="mobile" type="text" class="form-control contact-input" />
                <input type="hidden" id="mobile_value" name="mobile_value">
                <input type="hidden" id="country_code" name="country_code">
                <span class="text-danger" id="mobile_error"></span>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" placeholder="Enter user email" id="email" name="email" class="form-control">
                <span class="text-danger" id="email_error"></span>
            </div>

            <div class="col-md-6">
                <label for="country" class="form-label">Country (Current Location)
                    <span class="text-danger">*</span></label>
                <select id="country" name="country" class="form-control select2">
                    <option value="">Select Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}
                            @if (!empty($country->name_tamil))
                                ({{ $country->name_tamil }})
                            @endif
                        </option>
                    @endforeach
                </select>
                <span class="text-danger" id="country_error"></span>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    Date of Birth&nbsp;<span class="text-danger">*</span>
                </label>
                <input type="date" name="dob" id="dob" class="form-control">
                <span class="text-danger" id="dob_error"></span>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    Age&nbsp;<span class="text-danger">*</span>
                </label>
                <input type="text" name="age" id="age" class="form-control" readonly
                    placeholder="Choose the Date of birth">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Passport Number&nbsp;<span class="text-danger">*</span></label>
                <input type="text" id="passport_no" name="passport_no" class="form-control"
                    placeholder="Enter your passport number">
                <span class="text-danger" id="passport_no_error"></span>

            </div>

            <div class="col-md-6">
                <label for="apply_for" class="form-label">Apply For
                    <span class="text-danger">*</span></label>
                <select name="apply_for" id="apply_for" class="form-control select2">
                    <option value="">Select Job</option>
                    @foreach ($jobs as $job)
                        <option value="{{ $job->id }}">{{ $job->name }}
                            @if (!empty($job->name_tamil))
                                ({{ $job->name_tamil }})
                            @endif
                        </option>
                    @endforeach
                </select>
                <span class="text-danger" id="apply_for_error"></span>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Password&nbsp;<span class="text-danger">*</span></label>
                <input type="password" name="password" id="password" class="form-control"
                    placeholder="Enter user password">
                <span class="text-danger" id="password_error"></span>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Confirm Password&nbsp;<span class="text-danger">*</span></label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                    placeholder="Enter user confirm password">
                <span class="text-danger" id="confirm_password_error"></span>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Gender&nbsp;<span class="text-danger">*</span></label>
                <select name="gender" id="gender" class="form-control select2" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <span class="text-danger" id="gender_error"></span>
            </div>


            <div class="col-md-6">
                <label for="education" class="form-label">Education
                    <span class="text-danger">*</span></label>
                <select name="education" id="education" class="form-control select2">
                    <option value="">Select Education</option>
                    @foreach ($educations as $education)
                        <option value="{{ $education->id }}">
                            {{ $education->name }}
                            @if (!empty($education->name_tamil))
                                ({{ $education->name_tamil }})
                            @endif
                        </option>
                    @endforeach
                </select>
                <span class="text-danger" id="education_error"></span>
            </div>

            <div class="col-md-6" id="subeducation-wrapper" style="display: none">
                <label for="subeducation">Sub Education&nbsp;<span class="text-danger">*</span></label>
                <select name="subeducation" id="subeducation" class="mt-2 form-control select2">
                    <option value="">Select Sub Education</option>
                </select>
                <span class="text-danger" id="subeducation_error"></span>
            </div>

        </div>

        <button type="submit" id="add_user_btn" class="px-4 py-2 mt-4 btn btn-primary-gradient">
            <i class="fa fa-save"></i> Add User
        </button>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            const input = document.querySelector("#mobile");
            const iti = window.intlTelInput(input, {
                separateDialCode: true,
                initialCountry: "auto",
                preferredCountries: ["in", "ae", "qa", "kw", "sa", "sg"],
                geoIpLookup: function(callback) {
                    $.get("https://ipinfo.io/json?token=ee7e9cc4b7d6d3", function(data) {
                        callback(data.country);
                    }).fail(function() {
                        callback("in");
                    });
                },
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
            });

            $("#mobile").on("countrychange", function() {
                const countryData = iti.getSelectedCountryData();
                let country_code = countryData.dialCode;
                $("#mobile_value").val(country_code);
                $("#country_code").val(country_code);
                console.log("Country code:", country_code);
            });

            $(document).on('input', '#name', function() {
                this.value = this.value.replace(/[^A-Za-z\s]/g, '');
            });

            $(document).on('input', '#mobile', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 10) {
                    this.value = this.value.substring(0, 10);
                }
            });

            $("#dob").on("change", function() {
                let dob = new Date($(this).val());
                let today = new Date();
                if (!$(this).val()) {
                    $("#age").val("");
                    return;
                }
                let age = today.getFullYear() - dob.getFullYear();
                let monthDiff = today.getMonth() - dob.getMonth();
                if (monthDiff < 0 || (monthDiff == 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                $("#age").val(age + ' Years');
            });

            $("#education").change(function() {
                let education = $(this).val();
                $("#subeducation").html('<option value="">Select Sub Education</option>');
                $("#subeducation-wrapper").hide();
                if (!education) {
                    return;
                }
                $.ajax({
                    url: "{{ route('get.subeducation') }}",
                    type: "GET",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    data: {
                        education_id: education
                    },
                    success: function(response) {
                        if (response.length == 0) {
                            $("#subeducation-wrapper").hide();
                            return;
                        }
                        $("#subeducation-wrapper").show();
                        let options = '<option value="">Select Sub Education</option>';
                        $.each(response, function(index, item) {
                            let label = item.name;
                            if (item.name_tamil) {
                                label += ' (' + item.name_tamil + ')';
                            }
                            options += '<option value="' + item.id + '">' + label +
                                '</option>';
                        });

                        $("#subeducation").html(options).trigger('change');
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading sub education:", error);
                    }
                });
            });


            $("#add_user_btn").click(function() {
                let name = $("#name").val();
                let mobile = $("#mobile").val();
                let email = $("#email").val();
                let country_id = $("#country").val();
                let dob = $("#dob").val();
                let age = $("#age").val();
                age = age.replace(/[^0-9]/g, '');
                let passport_no = $("#passport_no").val();
                let apply_for = $("#apply_for").val();
                let password = $("#password").val();
                let confirm_password = $("#confirm_password").val();
                let gender = $("#gender").val();
                let education = $("#education").val();
                let subeducation = $("#subeducation").val();
                let subeducationOptionsCount = $("#subeducation option").length;
                const countryData = iti.getSelectedCountryData();
                let country_code = countryData.dialCode;

                if (name == '') {
                    $("#name_error").text("Please enetr user name");
                    $("#name").focus()
                    return false
                } else {
                    $("#name_error").text("")
                }

                if (mobile == '') {
                    $("#mobile_error").text("Please enter user mobile number");
                    $("#mobile").focus()
                    return false
                } else if (mobile.length != 10) {
                    $("#mobile_error").text("Invalid mobile number");
                    $("#mobile").focus()
                    return false
                } else {
                    $("#mobile_error").text("")
                }

                if (email !== '') {
                    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailPattern.test(email)) {
                        $("#email_error").text("Enter a valid email address");
                        $("#email").focus();
                        return false;
                    } else {
                        $("#email_error").text("");
                    }
                } else {
                    $("#email_error").text("");
                }

                if (country_id == '') {
                    $("#country_error").text("Please choose user country")
                    $("#country").focus()
                    return false
                } else {
                    $("#country_error").text("")
                }

                if (dob == '') {
                    $("#dob_error").text("Please select date of birth");
                    $("#dob").focus();
                    return false;
                } else {
                    $("#dob_error").text("");
                }

                if (passport_no == "") {
                    $("#passport_no_error").text("Please enter user passport number");
                    $("#passport_no").focus();
                    return false;
                } else {
                    $("#passport_no_error").text("");
                }

                if (apply_for == "") {
                    $("#apply_for_error").text("Please choose a job to apply for");
                    $("#apply_for").focus();
                    return false;
                } else {
                    $("#apply_for_error").text("");
                }

                if (password == "") {
                    $("#password_error").text("Please enter a user password");
                    $("#password").focus();
                    return false;
                } else if (password.length < 6) {
                    $("#password_error").text("Password must be at least 6 characters");
                    $("#password").focus();
                    return false;
                } else {
                    $("#password_error").text("");
                }

                if (confirm_password == "") {
                    $("#confirm_password_error").text("Please re-enter the password");
                    $("#confirm_password").focus();
                    return false;
                } else if (password !== confirm_password) {
                    $("#confirm_password_error").text("Passwords do not match");
                    $("#confirm_password").focus();
                    return false;
                } else {
                    $("#confirm_password_error").text("");
                }

                if (gender == "") {
                    $("#gender_error").text("Please select gender");
                    $("#gender").focus();
                    return false;
                } else {
                    $("#gender_error").text("");
                }

                if (education == "") {
                    $("#education_error").text("Please select education");
                    $("#education").focus();
                    return false;
                } else {
                    $("#education_error").text("");
                }

                if (subeducationOptionsCount > 1 && (subeducation == "" || subeducation == null)) {
                    $("#subeducation_error").text("Please select sub education");
                    $("#subeducation").focus();
                    return false;
                } else {
                    $("#subeducation_error").text("");
                }

                $.ajax({
                    url: "{{ route('create.user') }}",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    data: {
                        name: name,
                        mobile: mobile,
                        email: email,
                        country_id: country_id,
                        country_code: country_code,
                        dob: dob,
                        age: age,
                        passport_no: passport_no,
                        apply_for: apply_for,
                        password: password,
                        gender: gender,
                        education: education,
                        subeducation: subeducation
                    },
                    beforeSend: function() {
                        $("#add_user_btn").prop("disabled", true).text("Saving...");
                    },
                    success: function(res) {
                        $("#add_user_btn").prop("disabled", false).html(
                            '<i class="fa fa-save"></i> Add User');

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
                        $("#add_user_btn").prop("disabled", false).html(
                            '<i class="fa fa-save"></i> Add User');

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

            })


        });
    </script>

@endsection
