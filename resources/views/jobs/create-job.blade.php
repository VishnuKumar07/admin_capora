@extends('layouts.admin')
@section('page_title', 'Add Job')
@section('content')
    <style>
        :root {
            --card-bg: #ffffff;
            --card-border: rgba(226, 232, 240, 0.95);
            --muted: #6b7280;
            --blue: #3b82f6;
            --danger: #ef4444;
            --shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
            --radius: 12px;
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        .chip {
            cursor: pointer;
        }

        .chip.active {
            background: var(--blue);
            color: #fff;
            border-color: var(--blue);
        }

        .page {
            max-width: 1100px;
            margin: 8px auto;
            padding: 16px;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            padding: 20px;
            box-shadow: var(--shadow);
        }

        .card-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 14px;
        }

        .title {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
        }

        .subtitle {
            display: block;
            color: var(--muted);
            font-size: 13px;
            margin-top: 6px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 10px;
            border: 1px solid rgba(15, 23, 42, 0.06);
            background: #fff;
            cursor: pointer;
            font-size: 14px;
        }

        .btn.primary {
            background: var(--blue);
            color: #fff;
            border-color: transparent;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
        }

        @media (min-width:900px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        .pair-row {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
        }

        @media (min-width:900px) {
            .pair-row {
                grid-template-columns: 1fr 1fr;
                align-items: start;
            }
        }

        .full-row {
            display: block;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-height: 64px;
        }

        label {
            font-weight: 600;
            font-size: 14px;
            color: #0f172a;
        }

        .required:after {
            content: " *";
            color: var(--danger);
            font-weight: 700;
            margin-left: 2px;
            font-size: 13px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="datetime-local"],
        select,
        textarea {
            border: 1px solid #e6edf3;
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 14px;
            background: #fff;
            color: #0f172a;
            box-sizing: border-box;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .input-group {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .input-group .addon {
            background: #f1f5f9;
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid #e6edf3;
            color: var(--muted);
            font-size: 14px;
        }

        .input-group {
            display: flex;
            gap: 10px;
        }

        .input-group input[type="text"] {
            flex: 1;
        }

        .input-group input[name="currency"] {
            max-width: 150px;
            text-align: center;
        }

        .chips {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .chip {
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid rgba(59, 130, 246, 0.12);
            background: rgba(59, 130, 246, 0.04);
            color: var(--blue);
            font-weight: 600;
            font-size: 13px;
            user-select: none;
        }

        .row {
            display: flex;
            gap: 12px;
        }

        .col-6 {
            flex: 1;
            min-width: 0;
        }

        .note {
            font-size: 13px;
            color: var(--muted);
            margin-top: 6px;
        }

        .controls {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 18px;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, rgba(0, 0, 0, 0.03), rgba(0, 0, 0, 0));
            margin: 12px 0 18px;
            border-radius: 2px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            margin: 5px 0 10px 20px;
            font-size: 14px;
            font-weight: 700;
            border-radius: 12px;
            background: #ffffff;
            color: #06457a;
            text-decoration: none;
            border: 1px solid rgba(0, 110, 255, 0.25);
            box-shadow: 0 4px 10px rgba(0, 80, 150, 0.1);
            transition: all .22s ease;
            width: fit-content;
        }

        .back-btn:hover {
            background: #f0f7ff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 110, 255, 0.18);
        }

        .back-btn i {
            font-size: 14px;
        }

        .datetime-wrapper {
            position: relative;
        }

        .datetime-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #3b82f6;
            font-size: 15px;
            pointer-events: none;
        }

        .datetime-wrapper input {
            padding-left: 40px !important;
            cursor: pointer;
            background: #f8fbff;
            border: 1px solid #dbeafe;
            font-weight: 600;
        }

        .datetime-wrapper input:focus {
            background: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .flatpickr-calendar {
            border-radius: 14px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);
            font-family: Inter, system-ui;
        }

        .flatpickr-day.selected,
        .flatpickr-day.today {
            background: #3b82f6 !important;
            color: #fff;
            border-radius: 8px;
        }

        .flatpickr-time {
            border-top: 1px solid #e5e7eb;
        }

        .flatpickr-am-pm {
            background: #eff6ff;
            color: #1d4ed8;
            border-radius: 8px;
            font-weight: 700;
        }

        .flatpickr-months .flatpickr-prev-month,
        .flatpickr-months .flatpickr-next-month {
            color: #3b82f6;
        }

        .field .datetime-wrapper {
            width: 100%;
        }

        .field .datetime-wrapper input {
            width: 100% !important;
            display: block;
        }

        .flatpickr-input {
            width: 100% !important;
        }

        @media (max-width:520px) {
            .card {
                padding: 14px;
            }

            .card-head {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }

            .controls {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
    </head>

    <body>

        <a href="{{ url()->previous() }}" class="back-btn">
            <i class="fa fa-arrow-left"></i> Back
        </a>

        <div class="page">
            <div class="card" role="region" aria-label="Add Job">
                <div class="card-head">
                    <div>
                        <h1 class="title">Add Job</h1>
                        <span class="subtitle">Create a new job posting — fill the details below</span>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="pair-row">
                        <div class="field">
                            <label class="required">Company Name</label>
                            <input type="text" name="company_name" id="company_name" placeholder="Acme Pvt Ltd" />
                            <span class="text-danger" id="company_name_error"></span>
                        </div>

                        <div class="field">
                            <label class="required">Country</label>
                            <select name="country" id="country" class="select2">
                                <option value="">Select country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ old('country') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }} ({{ $country->name_tamil }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="country_error"></span>
                        </div>
                    </div>

                    <div class="pair-row">
                        <div class="field">
                            <label class="required">Job Category</label>
                            <select name="job_category" id="job_category" class="select2">
                                <option value="">Select Job Category</option>
                                @foreach ($jobcategories as $jobcategory)
                                    <option value="{{ $jobcategory->id }}" {{ $jobcategory->id }}>
                                        {{ $jobcategory->name }} ({{ $jobcategory->name_tamil }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="job_category_error"></span>
                        </div>

                        <div class="field">
                            <label class="required">Salary</label>
                            <div class="input-group">
                                <input type="text" id="currency" name="currency" placeholder="e.g. INR">
                                <span id="currency_error" class="text-danger"></span>
                                <input type="text" name="salary" id="salary" placeholder="e.g. 20000 - 30000" />
                                <span id="salary_error" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="pair-row">
                        <div class="field">
                            <label class="required">Interview Date</label>
                            <input type="datetime-local" id="interview_date" name="interview_date" />
                            <span class="text-danger" id="interview_date_error"></span>
                        </div>

                        <div class="field">
                            <label class="required">Interview Location</label>
                            <input type="text" id="interview_location" name="interview_location"
                                placeholder="City / Venue" />
                            <span class="text-danger" id="interview_location_error"></span>
                        </div>
                    </div>

                    <div class="pair-row">
                        <div class="field">
                            <label class="required">Vacancy</label>
                            <input type="number" id="vacancy" name="vacancy" min="1" placeholder="1" />
                            <span class="text-danger" id="vacancy_error"></span>
                        </div>
                        <div class="field">
                            <label class="required">Duty Hours</label>
                            <input type="text" name="duty_hours" id="duty_hours" placeholder="e.g. 9 AM - 6 PM" />
                            <span id="duty_hours_error" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="pair-row">
                        <div class="field">
                            <label class="required">Experience</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" name="experience_min" id="experience_min" min="0"
                                        placeholder="Min yrs" />
                                    <span class="text-danger" id="experience_min_error"></span>
                                </div>
                                <div class="col-6">
                                    <input type="number" name="experience_max" id="experience_max" min="0"
                                        placeholder="Max yrs" />
                                    <span class="text-danger" id="experience_max_error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="required">Food / Accommodation</label>
                            <div class="chips">
                                <span class="chip" data-group="food" data-target="food_accommodation"
                                    data-value="Includes">Includes</span>
                                <span class="chip" data-group="food" data-target="food_accommodation"
                                    data-value="Not included">Not included</span>
                                <span class="chip" data-group="food" data-target="food_accommodation"
                                    data-value="Partial">Partial</span>
                            </div>
                            <span class="text-danger" id="food_accommodation_error"></span>
                            <input type="hidden" id="food_accommodation" name="food_accommodation">
                        </div>
                    </div>

                    <div class="pair-row">
                        <div class="field">
                            <label class="required">OT Available</label>
                            <div class="chips">
                                <span class="chip" data-group="ot" data-target="ot_available"
                                    data-value="Yes">Yes</span>
                                <span class="chip" data-group="ot" data-target="ot_available"
                                    data-value="No">No</span>
                            </div>
                            <span class="text-danger" id="ot_available_error"></span>
                            <input type="hidden" id="ot_available" name="ot_available">
                        </div>

                        <div class="field">
                            <label class="required">Benefits Available</label>
                            <div class="chips">
                                <span class="chip" data-group="benefits" data-target="benefits_available"
                                    data-value="Yes">Yes</span>
                                <span class="chip" data-group="benefits" data-target="benefits_available"
                                    data-value="No">No</span>
                            </div>
                            <span class="text-danger" id="benefits_available_error"></span>
                            <input type="hidden" id="benefits_available" name="benefits_available">
                        </div>
                    </div>

                    <div class="pair-row">
                        <div class="field">
                            <label class="required">Gender</label>
                            <select name="gender" id="gender" class="select2" aria-invalid="false">
                                <option value="">Select Gender</option>
                                <option value="Any">Any</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <span class="text-danger" id="gender_error"></span>
                        </div>
                        <div class="field">
                            <label class="required">This job ends on</label>

                            <div class="datetime-wrapper">
                                <i class="fa fa-calendar-alt"></i>
                                <input type="text" id="job_end_date" name="job_end_date"
                                    placeholder="Select date & time" readonly>
                            </div>

                            <span class="text-danger" id="job_end_date_error"></span>
                        </div>

                    </div>

                    <div class="full-row">
                        <div class="field">
                            <label>Additional Notes</label>
                            <textarea name="notes" id="notes" placeholder="Any special instructions or details"></textarea>
                        </div>
                    </div>

                </div>
                <div class="divider" role="separator" aria-hidden="true"></div>
                <div class="controls">
                    <button type="submit" class="btn primary" id="create_job_btn">Create Job</button>
                </div>

            </div>
        </div>
    </body>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            function setMinDateTime() {
                let now = new Date();

                let year = now.getFullYear();
                let month = String(now.getMonth() + 1).padStart(2, '0');
                let day = String(now.getDate()).padStart(2, '0');
                let hour = String(now.getHours()).padStart(2, '0');
                let minDateTime = `${year}-${month}-${day}T${hour}:00`;
                $("#interview_date").attr("min", minDateTime);
            }

            setMinDateTime();
            setInterval(setMinDateTime, 60000);
            flatpickr("#job_end_date", {
                enableTime: true,
                time_24hr: false,
                dateFormat: "Y-m-d h:i K",
                minuteIncrement: 60,
                enableSeconds: false,
                defaultHour: 7,
                minDate: "today",
                onReady: function(_, __, instance) {
                    if (instance.minuteElement) {
                        instance.minuteElement.value = "00";
                        instance.minuteElement.style.display = "none";
                    }
                    if (instance.secondElement) {
                        instance.secondElement.style.display = "none";
                    }
                },
                onChange: function(dates, _, instance) {
                    if (dates.length) {
                        dates[0].setMinutes(0);
                        instance.setDate(dates[0], false);
                    }
                }
            });

            $(document).on("click", ".chip", function() {
                const group = $(this).data("group");
                const target = $(this).data("target");
                const value = $(this).data("value");
                $(`.chip[data-group="${group}"]`).removeClass("active");
                $(this).addClass("active");
                $("#" + target).val(value);
                $("#" + target + "_error").text("");
            });

            $("#country").change(function() {
                let country_id = $(this).val();
                if (!country_id) {
                    Swal.fire({
                        icon: 'info',
                        title: 'No country selected',
                        text: 'Please choose a country to load its currency.',
                        confirmButtonText: 'OK'
                    });
                    $("#currency").val('');
                    return;
                }

                $.ajax({
                    url: "{{ route('get.currency') }}",
                    method: 'post',
                    data: {
                        country_id: country_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res && res.currency) {
                            $("#currency").val(res.currency);
                        } else {
                            $("#currency").val('');
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
            });

            $("#create_job_btn").click(function() {

                let company_name = $("#company_name").val();
                let country = $("#country").val();
                let job_category = $("#job_category").val();
                let currency = $("#currency").val();
                let salary = $("#salary").val();
                let interview_date = $("#interview_date").val();
                let interview_location = $("#interview_location").val();
                let vacancy = $("#vacancy").val();
                let duty_hours = $("#duty_hours").val();
                let expMinRaw = $("#experience_min").val();
                let expMaxRaw = $("#experience_max").val();
                let food = $("#food_accommodation").val();
                let ot = $("#ot_available").val();
                let ben = $("#benefits_available").val();
                let gender = $("#gender").val();
                let job_end = $("#job_end_date").val();
                let notes = $("#notes").val();
                let expMin = parseFloat(expMinRaw);
                let expMax = parseFloat(expMaxRaw);

                if (company_name == '') {
                    $("#company_name_error").text("Please enter company name");
                    $("#company_name").focus();
                    return
                } else {
                    $("#company_name_error").text("");
                }

                if (country == '') {
                    $("#country_error").text("Please select country");
                    $("#country").focus();
                    return
                } else {
                    $("#country_error").text("");
                }

                if (job_category == '') {
                    $("#job_category_error").text("Please select Job Category");
                    $("#job_category").focus();
                    return
                } else {
                    $("#job_category_error").text("");
                }

                if (currency == '') {
                    $("#currency_error").text("Please enter country currency");
                    $("#currency").focus();
                    return
                } else {
                    $("#currency_error").text("");
                }

                if (salary == '') {
                    $("#salary_error").text("Please enter salary");
                    $("#salary").focus();
                    return
                } else {
                    $("#salary_error").text("");
                }

                if (interview_date == '') {
                    $("#interview_date_error").text("Please choose interview date");
                    $("#interview_date").focus();
                    return
                } else {
                    $("#interview_date_error").text("");
                }

                if (interview_location == '') {
                    $("#interview_location_error").text("Please enter interview location");
                    $("#interview_location").focus();
                    return
                } else {
                    $("#interview_location_error").text("");
                }

                if (vacancy == '') {
                    $("#vacancy_error").text("Please enter vacancy");
                    $("#vacancy").focus();
                    return
                } else {
                    $("#vacancy_error").text("");
                }

                if (duty_hours == '') {
                    $("#duty_hours_error").text("Please enter duty hours");
                    $("#duty_hours").focus();
                    return
                } else {
                    $("#duty_hours_error").text("");
                }

                if (expMinRaw == '') {
                    $("#experience_min_error").text("Please enter minimum experience (yrs)");
                    $("#experience_min").focus();
                    return;
                } else {
                    $("#experience_min_error").text("");
                }

                if (expMaxRaw == '') {
                    $("#experience_max_error").text("Please enter maximum experience (yrs)");
                    $("#experience_max").focus();
                    return;
                } else {
                    $("#experience_max_error").text("");
                }

                if (isNaN(expMin) || expMin < 0) {
                    $("#experience_min_error").text("Minimum experience must be a valid number ≥ 0");
                    $("#experience_min").focus();
                    return;
                } else {
                    $("#experience_min_error").text("")
                }

                if (isNaN(expMax) || expMax < 0) {
                    $("#experience_max_error").text("Maximum experience must be a valid number ≥ 0");
                    $("#experience_max").focus();
                    return;
                } else {
                    $("#experience_max_error").text("");
                }

                if (expMin > expMax) {
                    $("#experience_min_error").text("Minimum experience cannot be greater than maximum");
                    $("#experience_max_error").text("Maximum experience must be at least minimum");
                    $("#experience_min").focus();
                    return;
                } else {
                    $("#experience_min_error").text("")
                }

                if (!food || food.trim() == "") {
                    $("#food_accommodation_error").text("Please select food / accommodation");
                    return;
                } else {
                    $("#food_accommodation_error").text("");
                }

                if (!ot || ot.trim() == "") {
                    $("#ot_available_error").text("Please select OT availability");
                    return;
                } else {
                    $("#ot_available_error").text("");
                }

                if (!ben || ben.trim() == "") {
                    $("#benefits_available_error").text("Please select benefits availability");
                    return;
                } else {
                    $("#benefits_available_error").text("");
                }

                if (!gender || gender.trim() == "") {
                    $("#gender_error").text("Please select gender");
                    $("#gender").focus();
                    return;
                } else {
                    const allowedGenders = ["Any", "Male", "Female"];
                    if (allowedGenders.indexOf(gender) == -1) {
                        $("#gender_error").text("Please select a valid gender option");
                        $("#gender").focus();
                        return;
                    } else {
                        $("#gender_error").text("");
                    }
                }

                if (!job_end || job_end.trim() == "") {
                    $("#job_end_date_error").text("Please choose the job end date");
                    $("#job_end_date").focus();
                    return;
                } else {
                    $("#job_end_date_error").text("");
                }

                $.ajax({
                    url: "{{ route('store.job') }}",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    data: {
                        company_name: company_name,
                        country: country,
                        job_category: job_category,
                        currency: currency,
                        salary: salary,
                        interview_date: interview_date,
                        interview_location: interview_location,
                        vacancy: vacancy,
                        duty_hours: duty_hours,
                        expMinRaw: expMinRaw,
                        expMax: expMax,
                        food: food,
                        ot: ot,
                        ben: ben,
                        gender: gender,
                        job_end: job_end,
                        notes: notes
                    },
                    beforeSend: function() {
                        $("#create_job_btn").prop("disabled", true).text("Creating...");
                    },
                    success: function(res) {
                        $("#create_job_btn").prop("disabled", false).html('Create Job');
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
                        $("#create_job_btn").prop("disabled", false).html(
                            'Create Job');
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
                })
            })
        });
    </script>

@endsection
