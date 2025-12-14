@extends('layouts.admin')
@section('title', 'My Profile')
@section('content')

    <style>
        .iti {
            width: 100%;
        }

        .container-fluid,
        .content-wrapper,
        .main-content,
        #content-wrapper,
        .page-content {
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }

        .profile-page {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .profile-hero {
            width: 100%;
            margin: 0;
            padding: 35px 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 150px;
            border-radius: 0;
            background: linear-gradient(90deg, rgba(0, 118, 255, 0.12), rgba(0, 210, 255, 0.08));
            border-bottom: 1px solid rgba(0, 118, 255, 0.12);
            box-shadow: 0 10px 40px rgba(0, 80, 150, 0.06);
        }

        .profile-left {
            display: flex;
            align-items: center;
            gap: 30px;
            flex: 1;
        }

        .avatar-lg {
            width: 120px;
            height: 120px;
            border-radius: 18px;
            overflow: hidden;
            background: linear-gradient(135deg, #007bff, #00d4ff);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 48px;
            font-weight: 900;
            color: #fff;
            border: 6px solid white;
            box-shadow: 0 10px 25px rgba(0, 80, 150, 0.12);
        }

        .avatar-lg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-info {
            flex: 1;
            min-width: 0;
        }

        .hero-title {
            font-size: 28px;
            font-weight: 900;
            margin-bottom: 5px;
            color: #06345e;
        }

        .hero-sub {
            font-size: 15px;
            font-weight: 600;
            color: #4e6e85;
            margin-bottom: 10px;
        }

        .hero-meta {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .meta-pill {
            background: #fff;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            color: #06508f;
            border: 1px solid rgba(0, 80, 150, 0.15);
            box-shadow: 0 6px 12px rgba(0, 80, 150, 0.10);
            white-space: nowrap;
        }

        .hero-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: stretch;
            min-width: 230px;
        }

        .hero-btn {
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 16px;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 3px;
            border: none;
            cursor: pointer;
            transition: all 0.25s ease;
            width: 100%;
            user-select: none;
            position: relative;
            overflow: hidden;
        }

        .hero-btn::after {
            content: "";
            position: absolute;
            inset: 0;
            opacity: 0;
            pointer-events: none;
            background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.35), transparent 55%);
            transition: opacity .25s ease;
        }

        .hero-btn:hover::after {
            opacity: 1;
        }

        .hero-btn-main {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .hero-btn-main i {
            width: 22px;
            height: 22px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.18);
            font-size: 11px;
        }

        .hero-btn-title {
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .3px;
        }

        .hero-btn-sub {
            font-size: 11px;
            opacity: .85;
            font-weight: 500;
        }

        .hero-btn.primary,
        .hero-btn:not(.secondary):not(.ghost) {
            background: linear-gradient(135deg, #0084ff, #0066ff);
            color: white;
            box-shadow: 0 6px 16px rgba(0, 110, 255, 0.35);
        }

        .hero-btn.primary:hover,
        .hero-btn:not(.secondary):not(.ghost):hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 22px rgba(0, 110, 255, 0.45);
        }

        .hero-btn.secondary {
            background: #ffffff;
            color: #06508f;
            border: 1px solid rgba(0, 110, 255, 0.22);
            box-shadow: 0 5px 12px rgba(0, 110, 255, 0.12);
        }

        .hero-btn.secondary:hover {
            background: #f4f9ff;
            border-color: rgba(0, 110, 255, 0.4);
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(0, 110, 255, 0.18);
        }

        .hero-btn.ghost {
            background: rgba(255, 255, 255, 0.12);
            color: #06345e;
            border: 1px dashed rgba(6, 80, 143, 0.3);
        }

        .hero-btn.ghost:hover {
            background: rgba(255, 255, 255, 0.32);
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(0, 80, 150, 0.18);
        }

        .profile-main {
            width: 100%;
            box-sizing: border-box;
            overflow-x: hidden;
        }

        .edit-card {
            border-radius: 20px;
            border: 1px solid rgba(0, 118, 255, 0.18);
            box-shadow: 0 16px 35px rgba(0, 80, 150, 0.12);
            background: radial-gradient(circle at top left, rgba(0, 118, 255, 0.06), transparent 60%),
                #ffffff;
            padding: 18px 20px 20px 20px;
        }

        .edit-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .details-title,
        .edit-title {
            font-size: 19px;
            font-weight: 800;
            color: #053663;
        }

        .details-subtitle {
            font-size: 13px;
            color: #6c7a8b;
            font-weight: 500;
        }

        .edit-badge {
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(0, 118, 255, 0.08);
            color: #0050b3;
            font-weight: 700;
            letter-spacing: .4px;
            text-transform: uppercase;
        }

        .edit-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px 20px;
            margin-top: 10px;
        }

        .edit-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .edit-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
            color: #7b8ba0;
        }

        .edit-input-wrapper {
            position: relative;
        }

        .edit-input,
        .edit-select {
            width: 100%;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            padding: 7px 10px;
            font-size: 12px;
            font-weight: 500;
            outline: none;
            background: #f7f9ff;
            transition: all .18s ease;
        }

        .edit-input:focus,
        .edit-select:focus {
            border-color: rgba(0, 118, 255, 0.7);
            box-shadow: 0 0 0 1px rgba(0, 118, 255, 0.4);
            background: #ffffff;
        }

        .edit-input::placeholder {
            color: #b3bccb;
        }

        .edit-actions {
            margin-top: 22px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-save {
            border-radius: 999px;
            padding: 8px 20px;
            font-size: 13px;
            font-weight: 800;
            border: none;
            background: linear-gradient(135deg, #0084ff, #005dff);
            color: #fff;
            box-shadow: 0 10px 24px rgba(0, 110, 255, 0.45);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(0, 110, 255, 0.55);
        }

        .text-danger {
            font-size: 12px;
        }

        #loader {
            display: none;
            width: 40px;
            aspect-ratio: 4;
            background: radial-gradient(circle closest-side, #007bff 90%, #0000) 0 / calc(100% / 3) 100% space;
            clip-path: inset(0 100% 0 0);
            animation: l1 1s steps(4) infinite;
        }

        @keyframes l1 {
            to {
                clip-path: inset(0 -34% 0 0);
            }
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            margin: 15px 20px;
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

        .edit-input[readonly],
        .edit-select[readonly] {
            background: #eef2ff !important;
            border-color: rgba(0, 60, 160, 0.25) !important;
            color: #4a5b75 !important;
            cursor: not-allowed;
        }

        .edit-input[readonly]::placeholder {
            color: #7c89a8 !important;
        }

        @media (max-width: 1199.98px) {
            .profile-hero {
                gap: 80px;
            }

            .edit-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 991.98px) {
            .profile-hero {
                padding: 24px 20px;
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }

            .profile-left {
                width: 100%;
                gap: 18px;
            }

            .hero-actions {
                width: 100%;
                flex-direction: row;
                flex-wrap: wrap;
                align-items: stretch;
                justify-content: flex-start;
            }

            .hero-btn {
                flex: 1;
                min-width: 48%;
            }

            .hero-title {
                font-size: 22px;
            }

            .hero-sub {
                font-size: 14px;
            }

            .hero-meta {
                grid-template-columns: 1fr;
            }

            .profile-main {
                padding: 22px 16px 26px 16px;
            }

            .edit-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 575.98px) {
            .profile-hero {
                padding: 18px 12px;
                gap: 18px;
            }

            .profile-left {
                flex-direction: column;
                align-items: center;
                text-align: center;
                width: 100%;
            }

            .avatar-lg {
                width: 80px;
                height: 80px;
                border-radius: 16px;
                font-size: 32px;
                border-width: 4px;
                margin-bottom: 6px;
            }

            .hero-info {
                width: 100%;
                text-align: center;
            }

            .hero-title {
                font-size: 20px;
            }

            .hero-sub {
                font-size: 13px;
            }

            .hero-meta {
                grid-template-columns: 1fr;
                gap: 8px;
                justify-items: center;
            }

            .meta-pill {
                width: auto;
                text-align: center;
                white-space: normal;
            }

            .hero-actions {
                width: 100%;
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .hero-btn {
                width: 100%;
                min-width: 100%;
            }

            .edit-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="container-fluid">
        <div class="profile-page">

            <a href="{{ route('users') }}" class="back-btn">
                <i class="fa fa-arrow-left"></i> Back
            </a>

            <div class="profile-hero">
                <div class="profile-left">
                    <div class="avatar-lg">
                        {{ strtoupper(substr($userDetails->users->name ?? ($userDetails->users->name ?? 'U'), 0, 1)) }}
                    </div>

                    <div class="hero-info">
                        <div class="hero-title">
                            {{ $userDetails->users->name ?? 'No name set' }}
                        </div>
                        <div class="hero-sub">
                            {{ $userDetails->users->username ?? '—' }}
                        </div>
                        <div class="hero-meta">
                            <div class="meta-pill">
                                Member since:
                                {{ $userDetails->created_at ? $userDetails->created_at->format('M Y') : '—' }}
                            </div>

                            <div class="meta-pill">
                                Username: {{ $userDetails->users->username ?? '—' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hero-actions">
                    <a href="#" class="hero-btn ghost">
                        <div class="hero-btn-main">
                            <i class="fa fa-briefcase"></i>
                            <span class="hero-btn-title">{{ $userDetails->users->name }} Applications</span>
                        </div>
                        <div class="hero-btn-sub">Track jobs applied via RSK Air Travels</div>
                    </a>
                </div>
            </div>

            <div class="mt-3 profile-main">


                <div class="edit-card">
                    <div class="edit-header">
                        <div>
                            <div class="edit-title">Profile Details</div>
                            <div class="details-subtitle">
                                Personal, passport & education information linked to your RSK Air Travels account.
                            </div>
                        </div>
                        <span class="edit-badge">
                            <i class="fa fa-edit"></i> Editable
                        </span>
                    </div>

                    <div class="edit-grid">

                        <div class="edit-field">
                            <label class="edit-label" for="name">Name&nbsp;<span class="text-danger">*</span></label>
                            <div class="edit-input-wrapper">
                                <input type="hidden" id="id" name="id" class="edit-input"
                                    value="{{ old('id', $userDetails->users->id) }}">
                                <input type="text" id="name" name="name" class="edit-input"
                                    value="{{ old('name', $userDetails->users->name) }}" placeholder="Enter your full name">
                            </div>
                            <span class="text-danger" id="name_error"></span>
                        </div>

                        <div class="edit-field">
                            <label class="edit-label" for="username">Username&nbsp;<span
                                    class="text-danger">*</span></label>
                            <div class="edit-input-wrapper">
                                <input type="text" id="username" name="username" class="edit-input" readonly
                                    value="{{ old('username', $userDetails->users->username) }}"
                                    placeholder="Enter a username">
                            </div>
                        </div>

                        <div class="edit-field">
                            <label class="edit-label" for="mobile">Mobile&nbsp;<span class="text-danger">*</span></label>
                            <div class="edit-input-wrapper">
                                <input type="text" id="mobile" name="mobile" class="edit-input"
                                    value="{{ old('mobile', $userDetails->users->mobile) }}"
                                    placeholder="Enter mobile number">
                                <input type="hidden" id="mobile_value" name="mobile_value">
                                <input type="hidden" id="country_code" name="country_code">
                            </div>
                            <span class="text-danger" id="mobile_error"></span>
                        </div>

                        <div class="edit-field">
                            <label class="edit-label" for="email">Email</label>
                            <div class="edit-input-wrapper">
                                <input type="email" id="email" name="email" class="edit-input"
                                    value="{{ old('email', $userDetails->users->email) }}"
                                    placeholder="Enter email address">
                            </div>
                            <span class="text-danger" id="email_error"></span>
                        </div>

                        <div class="edit-field">
                            <label class="edit-label" for="dob">Date of Birth&nbsp;<span
                                    class="text-danger">*</span></label>
                            <div class="edit-input-wrapper">
                                <input type="date" id="dob" name="dob" class="edit-input"
                                    value="{{ old('dob', $userDetails->dob) }}">
                            </div>
                            <span class="text-danger" id="dob_error"></span>
                        </div>

                        <div class="edit-field">
                            <label class="edit-label" for="age">Age&nbsp;<span class="text-danger">*</span></label>
                            <div class="edit-input-wrapper">
                                <input type="number" id="age" name="age" class="edit-input" readonly
                                    min="0" value="{{ old('age', $userDetails->age) }}" placeholder="Enter age">
                            </div>
                            <span class="text-danger" id="age_error"></span>
                        </div>

                        <div class="edit-field">
                            <label class="edit-label" for="gender">Gender&nbsp;<span
                                    class="text-danger">*</span></label>
                            <div class="edit-input-wrapper">
                                <select id="gender" name="gender" class="edit-select select2">
                                    <option value="">Select gender</option>
                                    <option value="Male"
                                        {{ old('gender', $userDetails->gender) == 'Male' ? 'selected' : '' }}>Male
                                    </option>
                                    <option value="Female"
                                        {{ old('gender', $userDetails->gender) == 'Female' ? 'selected' : '' }}>Female
                                    </option>
                                    <option value="Other"
                                        {{ old('gender', $userDetails->gender) == 'Other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                            </div>
                            <span class="text-danger" id="gender_error"></span>
                        </div>

                        <div class="edit-field">
                            <label class="edit-label" for="country_id">Current Country&nbsp;<span
                                    class="text-danger">*</span></label>
                            <div class="edit-input-wrapper">
                                <select id="country_id" name="country_id" class="edit-select select2">
                                    <option value="">Select country</option>
                                    @isset($countries)
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ old('current_location_country_id', $userDetails->current_location_country_id) == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <span class="text-danger" id="country_id_error"></span>
                        </div>

                        <div class="edit-field">
                            <label class="edit-label" for="passport_no">Passport Number&nbsp;<span
                                    class="text-danger">*</span></label>
                            <div class="edit-input-wrapper">
                                <input type="text" id="passport_no" name="passport_no" class="edit-input"
                                    value="{{ old('passport_no', $userDetails->passport_no) }}"
                                    placeholder="Enter passport number">
                            </div>
                            <span class="text-danger" id="passport_no_error"></span>
                        </div>

                        <div class="edit-field">
                            <label class="edit-label" for="jobcategory">Job Category&nbsp;<span
                                    class="text-danger ">*</span></label>
                            <div class="edit-input-wrapper">
                                <select id="jobcategory" name="jobcategory" class="edit-select select2">
                                    <option value="">Select Job Category</option>
                                    @isset($jobcategories)
                                        @foreach ($jobcategories as $jobcategory)
                                            <option value="{{ $jobcategory->id }}"
                                                {{ old('job_category_id', $userDetails->job_category_id) == $jobcategory->id ? 'selected' : '' }}>
                                                {{ $jobcategory->name }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <span class="text-danger" id="jobcategory_error"></span>
                        </div>

                        <div class="edit-field">
                            <label class="edit-label" for="education_id">Education&nbsp;<span
                                    class="text-danger">*</span></label>
                            <div class="edit-input-wrapper">
                                <select id="education_id" name="education_id" class="edit-select select2">
                                    <option value="">Select education</option>
                                    @isset($educations)
                                        @foreach ($educations as $education)
                                            <option value="{{ $education->id }}"
                                                {{ old('education_id', $userDetails->education_id) == $education->id ? 'selected' : '' }}>
                                                {{ $education->name }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <span class="text-danger" id="education_id_error"></span>
                        </div>

                        <div class="edit-field" id="subeducation-wrapper" style="display: none">
                            <label class="edit-label" for="subeducation">Sub Education&nbsp;<span
                                    class="text-danger">*</span></label>
                            <select name="subeducation" id="subeducation" class="mt-2 form-control select2">
                                <option value="">Select Sub Education</option>
                            </select>
                            <span class="text-danger" id="subeducation_error"></span>
                        </div>

                    </div>

                    <div class="edit-actions">
                        <button type="submit" id="update_btn" class="btn-save">
                            <i class="fa fa-save"></i> Update
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            const input = document.querySelector("#mobile");
            let userDialCode = "{{ $userDetails->users->country_code ?? '' }}";
            userDialCode = userDialCode.replace('+', '').trim();
            let userIso2 = "";
            if (userDialCode) {
                const allCountries = window.intlTelInputGlobals.getCountryData();
                const match = allCountries.find(c => c.dialCode == userDialCode);
                if (match) {
                    userIso2 = match.iso2;
                }
            }

            const iti = window.intlTelInput(input, {
                separateDialCode: false,
                initialCountry: userIso2 || "in",
                preferredCountries: ["in", "ae", "qa", "kw", "sa", "sg"],
                nationalMode: true,
                formatOnDisplay: false,
                geoIpLookup: function(callback) {
                    if (userIso2) {
                        callback(userIso2);
                        return;
                    }
                    $.get("https://ipinfo.io/json?token=ee7e9cc4b7d6d3", function(data) {
                        callback(data.country ? data.country.toLowerCase() : "in");
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

            function loadSubEducation(education_id, selectedSubId = null) {
                if (!education_id) {
                    $("#subeducation-wrapper").hide();
                    $("#subeducation").html('<option value="">Select Sub Education</option>');
                    return;
                }

                $("#subeducation").html('<option value="">Loading…</option>');

                $.ajax({
                    url: "{{ route('get.subeducation') }}",
                    type: "GET",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    data: {
                        education_id: education_id
                    },
                    success: function(response) {
                        if (!response || response.length == 0) {
                            $("#subeducation-wrapper").hide()
                            return;
                        }
                        $("#subeducation-wrapper").show();
                        let options = '<option value="">Select Sub Education</option>';

                        $.each(response, function(index, item) {
                            let label = item.name;
                            if (item.name_tamil) {
                                label += ' (' + item.name_tamil + ')';
                            }

                            options += '<option value="' + item.id + '">' + label + '</option>';
                        });
                        $("#subeducation").html(options);
                        if (selectedSubId) {
                            $("#subeducation").val(String(selectedSubId)).trigger('change');
                        } else {
                            $("#subeducation").val('').trigger('change');
                        }
                    },
                    error: function() {
                        $("#subeducation").html('<option value="">Error loading data</option>');
                        $("#subeducation").val('').trigger('change');
                    }
                });
            }

            let initialEducationId = "{{ $userDetails->education_id }}";
            let initialSubEducationId = "{{ $userDetails->sub_education_id ?? '' }}";

            if (initialEducationId) {
                loadSubEducation(initialEducationId, initialSubEducationId);
            }

            $('#education_id').on('change', function() {
                const selectedEducationId = $(this).val();
                loadSubEducation(selectedEducationId, null);
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
                $("#age").val(age);
            });

            $("#update_btn").click(function() {

                let id = $("#id").val()
                let name = $("#name").val();
                let country_code = iti.getSelectedCountryData().dialCode;
                let mobile = $("#mobile").val();
                let email = $("#email").val();
                let dob = $("#dob").val();
                let age = $("#age").val();
                let gender = $("#gender").val();
                let passport_no = $("#passport_no").val();
                let jobcategory = $("#jobcategory").val();
                let country_id = $("#country_id").val();
                let education_id = $("#education_id").val();
                let subeducation = $("#subeducation").val();

                if (!id) {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Unable to edit",
                        confirmButtonColor: "#d33"
                    });
                    return;
                }

                if (name == '') {
                    $("#name_error").text("Please enter user name");
                    $("#name").focus()
                    return
                } else {
                    $("#name_error").text("");
                }

                if (mobile == '') {
                    $("#mobile_error").text("Please enter mobile number");
                    $("#mobile").focus()
                    return
                } else if (mobile.length != 10) {
                    $("#mobile_error").text("Invalid mobile number");
                    $("#mobile").focus()
                    return
                } else {
                    $("#mobile_error").text("");
                }

                if (email != '') {
                    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        $("#email_error").text("Please enter a valid email address");
                        $("#email").focus();
                        return;
                    } else {
                        $("#email_error").text("");
                    }
                }

                if (dob == '') {
                    $("#dob_error").text("Please select date of birth");
                    $("#dob").focus();
                    return;
                } else {
                    $("#dob_error").text("");
                }

                if (age == '') {
                    $("#age_error").text("Please enter age");
                    $("#age").focus();
                    return;
                } else if (isNaN(age) || age <= 0) {
                    $("#age_error").text("Invalid age");
                    $("#age").focus();
                    return;
                } else {
                    $("#age_error").text("");
                }

                if (gender == '' || gender == null) {
                    $("#gender_error").text("Please select gender");
                    $("#gender").focus();
                    return;
                } else {
                    $("#gender_error").text("");
                }

                if (country_id == '' || country_id == null) {
                    $("#country_error").text("Please select country");
                    $("#country_id").focus();
                    return;
                } else {
                    $("#country_error").text("");
                }

                if (passport_no == '') {
                    $("#passport_no_error").text("Please enter passport number");
                    $("#passport_no").focus();
                    return;
                } else {
                    $("#passport_no_error").text("");
                }

                if (jobcategory == '' || jobcategory == null) {
                    $("#jobcategory_error").text("Please select job");
                    $("#jobcategory").focus();
                    return;
                } else {
                    $("#jobcategory_error").text("");
                }

                if (education_id == '' || education_id == null) {
                    $("#education_id_error").text("Please select education");
                    $("#education_id").focus();
                    return;
                } else {
                    $("#education_id_error").text("");
                }

                if ($("#subeducation-wrapper").is(":visible")) {
                    if (subeducation == '' || subeducation == null) {
                        $("#subeducation_error").text("Please select sub education");
                        $("#subeducation").focus();
                        return;
                    } else {
                        $("#subeducation_error").text("");
                    }
                }


                $.ajax({
                    url: "{{ route('update.profile') }}",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    data: {
                        id: id,
                        mobile: mobile,
                        name: name,
                        country_code: country_code,
                        country_id: country_id,
                        dob: dob,
                        email: email,
                        age: age,
                        gender: gender,
                        passport_no: passport_no,
                        jobcategory: jobcategory,
                        education_id: education_id,
                        subeducation: subeducation

                    },
                    beforeSend: function() {
                        $("#update_btn").prop("disabled", true).text("Updating...");
                    },
                    success: function(res) {
                        $("#update_btn").prop("disabled", false).html(
                            '<i class="fa fa-save"></i> Update');

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
                        $("#update_btn").prop("disabled", false).html(
                            '<i class="fa fa-save"></i> Update');
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
