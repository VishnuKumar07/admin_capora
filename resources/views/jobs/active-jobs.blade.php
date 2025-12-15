@extends('layouts.admin')
@section('page_title', 'Active Jobs')

@section('content')
    <div class="container-fluid">

        <style>
            .job-card {
                background: #ffffff;
                border-radius: 14px;
                overflow: hidden;
                position: relative;
                height: 100%;
                display: flex;
                flex-direction: column;
                transition: transform .2s ease, box-shadow .2s ease;
            }

            .job-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 14px 30px rgba(15, 23, 42, 0.12);
            }

            .job-card-header {
                padding: 14px;
                background: linear-gradient(135deg, #2563eb, #1e40af);
            }

            .job-card-header h6 {
                color: #fff;
                margin-bottom: 2px;
                font-size: 15px;
            }

            .job-card-header small {
                color: rgba(255, 255, 255, .75);
                font-size: 12px;
            }

            .status-pill {
                position: absolute;
                top: 10px;
                right: 10px;
                padding: 5px 12px;
                font-size: 11px;
                border-radius: 999px;
                font-weight: 600;
                background: #dcfce7;
                color: #166534;
            }

            .job-card-body {
                padding: 14px;
                flex: 1;
            }

            .job-meta {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 6px;
                font-size: 13px;
                font-weight: 600;
            }

            .job-meta i {
                width: 18px;
                text-align: center;
            }

            .job-info-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
                margin-top: 8px;
            }

            .job-info-grid small {
                color: #6b7280;
                font-size: 11px;
            }

            .job-info-grid div {
                font-size: 13px;
                font-weight: 600;
            }

            .job-card-footer {
                padding: 10px 14px;
                background: #f9fafb;
                border-top: 1px solid #e5e7eb;
                display: flex;
                justify-content: flex-end;
                gap: 6px;
            }

            .job-card-footer .btn {
                border-radius: 999px;
                font-size: 12px;
            }

            .job-end-badge {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 5px 8px;
                border-radius: 999px;
                font-size: 11px;
                font-weight: 600;
                white-space: nowrap;
            }

            .job-end-open {
                background: #dcfce7;
                color: #166534;
            }

            .job-end-warning {
                background: #fef3c7;
                color: #92400e;
            }

            .job-end-danger {
                background: #fee2e2;
                color: #991b1b;
            }

            .job-meta-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 8px 14px;
                margin-bottom: 12px;
            }

            .job-meta {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 14px;
                font-weight: 600;
                white-space: nowrap;
            }

            .job-meta i {
                width: 18px;
                text-align: center;
                font-size: 14px;
            }

            .job-meta-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 8px 14px;
                margin-bottom: 12px;
            }

            .job-meta {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 14px;
                font-weight: 600;
                white-space: nowrap;
            }

            .job-meta i {
                width: 18px;
                text-align: center;
                font-size: 14px;
            }
        </style>

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold">Active Jobs</h4>
                <small class="text-muted">Jobs currently available for candidates</small>
            </div>
            <span class="px-3 py-2 badge bg-success fs-6">
                {{ $activeJobs->count() }} Active
            </span>
        </div>

        <div class="row g-4 align-items-stretch">

            @forelse($activeJobs as $job)
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="shadow-sm job-card h-100">

                        <span class="status-pill">
                            <i class="fa fa-check-circle me-1"></i> Active
                        </span>

                        <div class="job-card-header">
                            <h6>{{ $job->job_code }}</h6>
                            <small>{{ $job->company_name }}</small>
                        </div>

                        <div class="job-card-body">
                            <div class="job-meta-grid">
                                <div class="job-meta">
                                    <i class="fa fa-globe text-primary"></i>
                                    <span>{{ $job->country->name ?? '-' }}</span>
                                </div>

                                <div class="job-meta">
                                    <i class="fa fa-money-bill-wave text-success"></i>
                                    <span>
                                        {{ $job->currency }} {{ $job->salary }}
                                        @if (strtolower($job->ot_available) == 'yes')
                                            <span class="badge bg-success-subtle text-success ms-1">+ OT</span>
                                        @endif
                                    </span>
                                </div>

                                <div class="job-meta">
                                    <i class="fa fa-users text-info"></i>
                                    <span>{{ $job->vacancy }} Vacancies</span>
                                </div>

                                <div class="job-meta">
                                    <i class="fa fa-briefcase text-warning"></i>
                                    <span>{{ $job->experience_min ?? 0 }} - {{ $job->experience_max ?? '∞' }} yrs
                                        experience</span>
                                </div>

                                @if (!empty($job->food_accommodation) && strtolower($job->food_accommodation) !== 'not included')
                                    <div class="job-meta">
                                        <i class="fa fa-utensils text-danger"></i>
                                        <span>
                                            Foods : {{ $job->food_accommodation }}
                                        </span>
                                    </div>
                                @endif

                                @if (strtolower($job->benefits_available) == 'yes')
                                    <div class="job-meta">
                                        <i class="fa fa-gift text-warning"></i>
                                        <span>
                                            Benefits : {{ $job->benefits_available }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <hr class="my-2">

                            <div class="job-info-grid">

                                <div>
                                    <small>Category</small>
                                    <div>{{ $job->jobCategory->name ?? '-' }}</div>
                                </div>

                                <div>
                                    <small>Duty Hours</small>
                                    <div>{{ $job->duty_hours ?? '-' }}</div>
                                </div>

                                @if (!empty($job->gender))
                                    <div>
                                        <small>Gender</small>
                                        <div>
                                            <i class="fa fa-venus-mars me-1 text-primary"></i>
                                            {{ ucfirst($job->gender) }}
                                        </div>
                                    </div>
                                @endif

                                <div>
                                    <small>Interview Date & Time</small>
                                    @if ($job->interview_date)
                                        <div>
                                            {{ \Carbon\Carbon::parse($job->interview_date)->format('d M Y, h:i A') }}
                                        </div>
                                    @else
                                        <div>-</div>
                                    @endif
                                </div>

                                <div>
                                    <small>Interview Location</small>
                                    @if (!empty($job->interview_location))
                                        <div>
                                            <i class="fa fa-map-marker-alt me-1 text-danger"></i>
                                            {{ $job->interview_location }}
                                        </div>
                                    @else
                                        <div>-</div>
                                    @endif
                                </div>

                                <div>
                                    <small>Job End</small>

                                    @if (!$job->job_end)
                                        <span class="job-end-badge job-end-open">
                                            <i class="fa fa-unlock"></i> Open
                                        </span>
                                    @else
                                        @php
                                            $end = \Carbon\Carbon::parse($job->job_end);
                                        @endphp

                                        @if ($end->isPast())
                                            <span class="job-end-badge job-end-danger">
                                                <i class="fa fa-times-circle"></i> Expired
                                            </span>
                                        @elseif ($end->diffInDays(now()) <= 7)
                                            <span class="job-end-badge job-end-warning">
                                                <i class="fa fa-clock"></i> Ending Soon
                                            </span>
                                        @else
                                            <span class="job-end-badge job-end-open">
                                                <i class="fa fa-calendar"></i> Active
                                            </span>
                                        @endif

                                        <div class="mt-1 text-muted" style="font-size: 12px;">
                                            {{ $end->format('d M Y, h:i A') }}
                                        </div>
                                    @endif
                                </div>
                                @if (!empty($job->notes))
                                    <div>
                                        <small>Notes</small>
                                        <div>{{ $job->notes ?? '-' }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="job-card-footer">
                            <button class="btn btn-sm btn-outline-warning edit-job-btn" data-id="{{ encrypt($job->id) }}"
                                data-company="{{ $job->company_name }}" data-salary="{{ $job->salary }}"
                                data-vacancy="{{ $job->vacancy }}" data-currency="{{ $job->currency }}"
                                data-expmin="{{ $job->experience_min }}" data-expmax="{{ $job->experience_max }}"
                                data-country="{{ $job->country_id }}" data-category="{{ $job->job_category_id }}"
                                data-dutyhours="{{ $job->duty_hours }}" data-interviewdate="{{ $job->interview_date }}"
                                data-interviewlocation="{{ $job->interview_location }}"
                                data-food="{{ $job->food_accommodation }}" data-ot="{{ $job->ot_available }}"
                                data-benefits="{{ $job->benefits_available }}" data-gender="{{ $job->gender }}"
                                data-notes="{{ $job->notes }}" data-jobEnds="{{ $job->job_end }}">
                                <i class="fa fa-edit"></i> Edit
                            </button>

                            @if ($job->status !== 'Expired')
                                <button class="btn btn-sm btn-outline-dark expire-job-btn"
                                    data-id="{{ encrypt($job->id) }}">
                                    <i class="fa fa-ban"></i> Expire
                                </button>
                            @endif

                            <button class="btn btn-sm btn-outline-danger delete-job-btn" data-id="{{ encrypt($job->id) }}">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </div>

                    </div>
                </div>
            @empty
                <div class="py-5 text-center col-12 text-muted">
                    <i class="mb-2 fa fa-briefcase fa-2x"></i>
                    <div>No active jobs found</div>
                </div>
            @endforelse

        </div>
    </div>

    <div class="modal fade" id="editJobModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="border-0 modal-content rounded-4">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="edit_job_id">

                    <div class="row g-3">

                        <div class="col-12 col-md-3">
                            <label class="form-label">
                                Company Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="edit_company_name"
                                placeholder="Enter company name">
                            <span class="text-danger" id="edit_company_name_error"></span>
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label">Country <span class="text-danger">*</span></label>
                            <select class="form-select select2" id="edit_country_id">
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="edit_country_id_error"></span>
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold">
                                Job Category <span class="text-danger">*</span>
                            </label>
                            <select class="form-select select2" id="edit_job_category_id">
                                <option value="">Select Job Category</option>
                                @foreach ($jobcategories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="edit_job_category_id_error"></span>
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label">Currency <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_currency"
                                placeholder="Ex: USD, INR, SAR">
                            <span class="text-danger" id="edit_currency_error"></span>
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label">Salary <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_salary">
                            <span class="text-danger" id="edit_salary_error"></span>
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label">Vacancy <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_vacancy">
                            <span class="text-danger" id="edit_vacancy_error"></span>
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold">
                                Duty Hours <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="edit_duty_hours"
                                placeholder="e.g. 8 Hours / Day">
                            <span class="text-danger" id="edit_duty_hours_error"></span>
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold">
                                Interview Date & Time <span class="text-danger">*</span>
                            </label>
                            <input type="datetime-local" class="form-control" id="edit_interview_date">
                            <span class="text-danger" id="edit_interview_date_error"></span>
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold">
                                Interview Location <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="edit_interview_location"
                                placeholder="e.g. RSK Air Travels, Chennai">
                            <span class="text-danger" id="edit_interview_location_error"></span>
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold d-block">
                                Experience (Years) <span class="text-danger">*</span>
                            </label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" class="form-control" id="edit_experience_min"
                                        placeholder="Min">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control" id="edit_experience_max"
                                        placeholder="Max">
                                </div>
                            </div>
                            <span class="text-danger" id="edit_experience_min_error"></span>
                            <span class="text-danger" id="edit_experience_max_error"></span>
                        </div>


                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold">
                                Food Accommodation <span class="text-danger">*</span>
                            </label>
                            <select class="form-select select2" id="edit_food_accommodation" required>
                                <option value="">Select Food Accommodation</option>
                                <option value="Includes">Includes</option>
                                <option value="Partial">Partial</option>
                                <option value="Not Included">Not Included</option>
                            </select>
                            <span class="text-danger" id="edit_food_accommodation_error"></span>
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold">
                                OT Available <span class="text-danger">*</span>
                            </label>
                            <select class="form-select select2" id="edit_ot_available" required>
                                <option value="">Select OT Availability</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <span class="text-danger" id="edit_ot_available_error"></span>
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold">
                                Benefits Available <span class="text-danger">*</span>
                            </label>
                            <select class="form-select select2" id="edit_benefits_available" required>
                                <option value="">Select Benefits</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <span class="text-danger" id="edit_benefits_available_error"></span>
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold">
                                Gender <span class="text-danger">*</span>
                            </label>
                            <select class="form-select select2" id="edit_gender" required>
                                <option value="">Select Gender</option>
                                <option value="Any">Any</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <span class="text-danger" id="edit_gender_error"></span>
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold">
                                Jobs Ends on <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="job_end_date" class="form-control">
                            <span class="text-danger" id="job_end_date_error"></span>
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold">
                                Notes
                            </label>
                            <input type="text" class="form-control" id="edit_notes"
                                placeholder="Enter any additional notes or remarks about this job...">
                        </div>
                    </div>

                </div>


                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" id="updateJobBtn">
                        <i class="fa fa-save me-1"></i> Update Job
                    </button>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {


            $(document).on('click', '.expire-job-btn', function() {

                let jobId = $(this).data('id');

                Swal.fire({
                    title: 'Mark job as expired?',
                    text: "This job will be closed instantly!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, expire job',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#111827',
                    cancelButtonColor: '#6b7280',
                    reverseButtons: true
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ route('expire.job') }}",
                            type: "POST",
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            },
                            data: {
                                id: jobId
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Expired!',
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
                                    'Unable to expire the job. Try again.',
                                    'error'
                                );
                            }
                        });

                    }
                });
            });

            $(document).on('click', '.edit-job-btn', function() {

                let countryId = $(this).data('country');
                let categoryId = $(this).data('category');
                let foodValue = $(this).data('food');
                let otValue = $(this).data('ot');
                let benefitsValue = $(this).data('benefits');
                let genderValue = $(this).data('gender');

                $('#edit_job_id').val($(this).data('id'));
                $('#edit_company_name').val($(this).data('company'));
                $('#edit_salary').val($(this).data('salary'));
                $('#edit_vacancy').val($(this).data('vacancy'));

                $('#edit_experience_min').val($(this).data('expmin'));
                $('#edit_experience_max').val($(this).data('expmax'));
                $('#edit_duty_hours').val($(this).data('dutyhours'));
                $('#edit_notes').val($(this).data('notes'));
                $('#edit_currency').val($(this).data('currency'));

                let interviewDate = $(this).data('interviewdate');
                if (interviewDate) {
                    $('#edit_interview_date').val(interviewDate.replace(' ', 'T').substring(0, 16));
                } else {
                    $('#edit_interview_date').val('');
                }

                let jobEndDate = $(this).data('jobends');
                if (jobEndDate) {
                    jobEndPicker.setDate(jobEndDate, true);
                } else {
                    jobEndPicker.clear();
                }

                $('#edit_interview_location').val($(this).data('interviewlocation'));
                $('#editJobModal').modal('show');
                $('#editJobModal').off('shown.bs.modal').on('shown.bs.modal', function() {

                    $('#edit_country_id')
                        .val(countryId)
                        .trigger('change');

                    $('#edit_job_category_id')
                        .val(categoryId)
                        .trigger('change');

                    $('#edit_food_accommodation')
                        .val(foodValue)
                        .trigger('change');

                    $('#edit_ot_available')
                        .val(otValue)
                        .trigger('change');

                    $('#edit_benefits_available')
                        .val(benefitsValue)
                        .trigger('change');


                    $('#edit_gender')
                        .val(genderValue)
                        .trigger('change');
                });
            });

            let jobEndPicker = flatpickr("#job_end_date", {
                enableTime: true,
                time_24hr: false,
                dateFormat: "Y-m-d h:00 K",
                minuteIncrement: 60,
                enableSeconds: false,
                defaultHour: 7,
                minDate: "today",

                onReady: function(_, __, instance) {
                    if (instance.minuteElement) {
                        instance.minuteElement.style.display = "none";
                    }
                },

                onChange: function(selectedDates, _, instance) {
                    if (selectedDates.length) {
                        selectedDates[0].setMinutes(0);
                        selectedDates[0].setSeconds(0);
                        instance.setDate(selectedDates[0], false);
                    }
                }
            });

            $(document).on('click', '#updateJobBtn', function() {

                let isValid = true;

                function setError(id, message) {
                    $('#' + id + '_error').text(message);
                    isValid = false;
                }

                function clearError(id) {
                    $('#' + id + '_error').text('');
                }

                let company = $('#edit_company_name').val().trim();
                if (company == '') {
                    setError('edit_company_name', 'Please enter the company name');
                } else {
                    clearError('edit_company_name');
                }


                if (!$('#edit_country_id').val()) {
                    setError('edit_country_id', 'Please select country');
                } else {
                    clearError('edit_country_id');
                }


                if (!$('#edit_job_category_id').val()) {
                    setError('edit_job_category_id', 'Please select job category');
                } else {
                    clearError('edit_job_category_id');
                }

                if ($('#edit_currency').val().trim() == '') {
                    setError('edit_currency', 'Please enter currency');
                } else {
                    clearError('edit_currency');
                }


                if ($('#edit_salary').val().trim() == '') {
                    setError('edit_salary', 'Please enter salary');
                } else {
                    clearError('edit_salary');
                }

                if (!$('#edit_vacancy').val()) {
                    setError('edit_vacancy', 'Please enter vacancy');
                } else {
                    clearError('edit_vacancy');
                }

                if ($('#edit_duty_hours').val().trim() == '') {
                    setError('edit_duty_hours', 'Please enter duty hours');
                } else {
                    clearError('edit_duty_hours');
                }

                if (!$('#edit_interview_date').val()) {
                    setError('edit_interview_date', 'Please select interview date');
                } else {
                    clearError('edit_interview_date');
                }

                if ($('#edit_interview_location').val().trim() == '') {
                    setError('edit_interview_location', 'Please enter interview location');
                } else {
                    clearError('edit_interview_location');
                }

                if ($('#edit_experience_min').val() == '') {
                    setError('edit_experience_min', 'Enter min experience');
                } else {
                    clearError('edit_experience_min');
                }

                if ($('#edit_experience_max').val() == '') {
                    setError('edit_experience_max', 'Enterm max experience');
                } else {
                    clearError('edit_experience_max');
                }

                if (!$('#edit_food_accommodation').val()) {
                    setError('edit_food_accommodation', 'Select food accommodation');
                } else {
                    clearError('edit_food_accommodation');
                }

                if (!$('#edit_ot_available').val()) {
                    setError('edit_ot_available', 'Select OT availability');
                } else {
                    clearError('edit_ot_available');
                }

                if (!$('#edit_benefits_available').val()) {
                    setError('edit_benefits_available', 'Select benefits');
                } else {
                    clearError('edit_benefits_available');
                }

                if (!$('#edit_gender').val()) {
                    setError('edit_gender', 'Select gender');
                } else {
                    clearError('edit_gender');
                }

                if (!$('#job_end_date').val()) {
                    setError('job_end_date', 'Please select job end date');
                } else {
                    clearError('job_end_date');
                }

                if (!isValid) {
                    return;
                }

                $('#updateJobBtn').prop('disabled', true).text('Updating...');

                let formData = {
                    id: $('#edit_job_id').val(),
                    company_name: $('#edit_company_name').val(),
                    country_id: $('#edit_country_id').val(),
                    job_category_id: $('#edit_job_category_id').val(),
                    currency: $('#edit_currency').val(),
                    salary: $('#edit_salary').val(),
                    vacancy: $('#edit_vacancy').val(),
                    duty_hours: $('#edit_duty_hours').val(),
                    interview_date: $('#edit_interview_date').val(),
                    interview_location: $('#edit_interview_location').val(),
                    experience_min: $('#edit_experience_min').val(),
                    experience_max: $('#edit_experience_max').val(),
                    food_accommodation: $('#edit_food_accommodation').val(),
                    ot_available: $('#edit_ot_available').val(),
                    benefits_available: $('#edit_benefits_available').val(),
                    gender: $('#edit_gender').val(),
                    job_end: $('#job_end_date').val(),
                    notes: $('#edit_notes').val(),

                };

                $.ajax({
                    url: "{{ route('update.job') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: res.message ?? 'Job updated successfully',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
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
                    },
                    complete: function() {
                        $('#updateJobBtn').prop('disabled', false).html(
                            '<i class="fa fa-save me-1"></i> Update Job'
                        );
                    }
                });
            });


            $(document).on('click', '.delete-job-btn', function() {
                let jobId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This job will be deleted permanently!",
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
                            url: "{{ route('delete.job') }}",
                            type: "POST",
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            },
                            data: {
                                id: jobId
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
        })
    </script>
@endsection
