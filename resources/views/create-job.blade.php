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

        html,
        body {
            height: 100%;
            margin: 0;
            background: #f8fafc;
            color: #0f172a;
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
            /* mobile fallback */
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

        .input-group input[name="salary_currency"] {
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
                            <input type="text" name="company_name" placeholder="Acme Pvt Ltd" />
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
                        </div>

                        <div class="field">
                            <label class="required">Salary</label>
                            <div class="input-group">
                                <input type="text" id="salary_currency" name="salary_currency" placeholder="e.g. INR">
                                <input type="text" name="salary" placeholder="e.g. 20000 - 30000" />
                            </div>

                        </div>
                    </div>

                    <div class="pair-row">
                        <div class="field">
                            <label class="required">Interview Date</label>
                            <input type="datetime-local" name="interview_date" />
                        </div>

                        <div class="field">
                            <label class="required">Interview Location</label>
                            <input type="text" name="interview_location" placeholder="City / Venue" />
                        </div>
                    </div>

                    <div class="pair-row">

                        <div class="field">
                            <label class="required">Vacancy</label>
                            <input type="number" name="vacancy" min="1" placeholder="1" />
                        </div>

                        <div class="field">
                            <label class="required">Duty Hours</label>
                            <input type="text" name="duty_hours" placeholder="e.g. 9 AM - 6 PM" />
                        </div>


                    </div>

                    <div class="pair-row">


                        <div class="field">
                            <label class="required">Experience</label>
                            <div class="row">
                                <div class="col-6"><input type="number" name="experience_min" min="0"
                                        placeholder="Min yrs" /></div>
                                <div class="col-6"><input type="number" name="experience_max" min="0"
                                        placeholder="Max yrs" /></div>
                            </div>
                            <span class="note">Enter experience range in years (e.g., 1 to 3).</span>
                        </div>

                        <div class="field">
                            <label>Food / Accommodation</label>
                            <div class="chips" aria-hidden="true">
                                <span class="chip">Includes</span>
                                <span class="chip">Not included</span>
                                <span class="chip">Partial</span>
                            </div>
                            <span class="note">Choose whether food/accommodation is provided.</span>
                        </div>
                        <input type="hidden" name="food_accommodation" id="food_accommodation">

                    </div>

                    <div class="pair-row">

                        <div class="field">
                            <label class="required">Gender</label>
                            <select name="gender" class="select2">
                                <option value="">Select Gender</option>
                                <option value="Any">Any</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="field">
                            <label class="required">This job ends on</label>
                            <input type="datetime-local" name="job_end_date" />
                        </div>

                    </div>
                    <div class="full-row">
                        <div class="field">
                            <label>Additional Notes</label>
                            <textarea name="notes" placeholder="Any special instructions or details"></textarea>
                        </div>
                    </div>

                </div>
                <div class="divider" role="separator" aria-hidden="true"></div>
                <div class="controls">
                    <button type="button" class="btn">Cancel</button>
                    <button type="submit" class="btn primary">Create Job</button>
                </div>

            </div>
        </div>
    </body>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $(".chip").click(function() {
                $(".chip").removeClass("active");
                $(this).addClass("active");
                $("#food_accommodation").val($(this).text().trim());
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
                    $("#salary_currency").val('');
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
                            $("#salary_currency").val(res.currency);
                        } else {
                            $("#salary_currency").val('');
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
