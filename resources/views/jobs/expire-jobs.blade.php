@extends('layouts.admin')
@section('page_title', 'Expired Jobs')

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

            .status-pill.expired {
                background: #fee2e2;
                color: #991b1b;
            }

            .expired-reason {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 4px 8px;
                border-radius: 999px;
                font-size: 11px;
                font-weight: 600;
                white-space: nowrap;
            }

            .expired-auto {
                background: #e0f2fe;
                color: #0369a1;
            }

            .expired-forced {
                background: #fde2e2;
                color: #991b1b;
            }

            .expired-reason-full {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 10px 12px;
                border-radius: 12px;
                background: #f8fafc;
                border: 1px dashed #e5e7eb;
            }

            .expired-reason-title {
                font-size: 12px;
                font-weight: 600;
                color: #6b7280;
                white-space: nowrap;
            }

            .flatpickr-minute,
            .flatpickr-time-separator {
                display: none !important;
            }

            .flatpickr-time {
                justify-content: center;
                gap: 12px;
            }
        </style>
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold">Expired Jobs</h4>
                <small class="text-muted">Jobs which are no longer active</small>
            </div>
            <span class="px-3 py-2 badge bg-danger fs-6">
                {{ $expiredJobs->count() }} Expired
            </span>
        </div>

        <div class="row g-4 align-items-stretch">
            @forelse($expiredJobs as $job)
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="shadow-sm job-card h-100">

                        <span class="status-pill expired">
                            <i class="fa fa-times-circle me-1"></i> Expired
                        </span>


                        <div class="job-card-header">
                            <h6>{{ $job->job_code }}</h6>
                            <small>{{ $job->company_name }}</small>
                        </div>

                        <div class="job-card-body">

                            {{-- TOP META (same as active) --}}
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
                                    <span>
                                        {{ $job->experience_min ?? 0 }} - {{ $job->experience_max ?? '∞' }} yrs experience
                                    </span>
                                </div>

                                @if (!empty($job->food_accommodation) && strtolower($job->food_accommodation) !== 'not included')
                                    <div class="job-meta">
                                        <i class="fa fa-utensils text-danger"></i>
                                        <span>Foods : {{ $job->food_accommodation }}</span>
                                    </div>
                                @endif

                                @if (strtolower($job->benefits_available) == 'yes')
                                    <div class="job-meta">
                                        <i class="fa fa-gift text-warning"></i>
                                        <span>Benefits : Yes</span>
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

                                <div>
                                    <small>Gender</small>
                                    <div>
                                        <i class="fa fa-venus-mars me-1 text-primary"></i>
                                        {{ ucfirst($job->gender ?? 'Any') }}
                                    </div>
                                </div>

                                <div>
                                    <small>Interview Date & Time</small>
                                    <div>
                                        {{ $job->interview_date ? \Carbon\Carbon::parse($job->interview_date)->format('d M Y, h:i A') : '-' }}
                                    </div>
                                </div>

                                <div>
                                    <small>Interview Location</small>
                                    <div>
                                        <i class="fa fa-map-marker-alt me-1 text-danger"></i>
                                        {{ $job->interview_location ?? '-' }}
                                    </div>
                                </div>

                                <div>
                                    <small>Job Ended on</small>
                                    <div class="mt-1 text-muted" style="font-size:12px;">
                                        {{ \Carbon\Carbon::parse($job->job_end)->format('d M Y h:i A') }}
                                    </div>
                                </div>

                                <div class="expired-reason-full">
                                    <div class="expired-reason-title">
                                        <i class="fa fa-circle-info me-1"></i> Expired Reason
                                    </div>

                                    @if ($job->expire_status == 'Forced')
                                        <span class="expired-reason expired-forced">
                                            <i class="fa fa-user-slash me-1"></i> Forced
                                        </span>
                                    @else
                                        <span class="expired-reason expired-auto">
                                            <i class="fa fa-clock me-1"></i> Auto
                                        </span>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="job-card-footer">
                            <button class="btn btn-sm btn-success activate-job-btn" data-id="{{ encrypt($job->id) }}">
                                <i class="fa fa-check-circle me-1"></i> Activate
                            </button>
                        </div>

                    </div>
                </div>
            @empty
                <div class="py-5 text-center col-12 text-muted">
                    <i class="mb-2 fa fa-ban fa-2x"></i>
                    <div>No expired jobs found</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).on('click', '.activate-job-btn', function() {

            let jobId = $(this).data('id');

            Swal.fire({
                title: 'Activate Job',
                html: `
            <label class="mb-2 form-label fw-semibold">
                Select New Job End Date & Time
            </label>
            <input type="text" id="new_job_end" class="form-control" placeholder="Select date & time" readonly>
        `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Activate',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#16a34a',

                didOpen: () => {

                    const now = new Date();

                    flatpickr("#new_job_end", {
                        enableTime: true,
                        noCalendar: false,
                        time_24hr: false,
                        dateFormat: "Y-m-d h:i K",
                        enableMinutes: false,
                        minuteIncrement: 60,
                        defaultMinute: 0,
                        minDate: "today",
                        defaultHour: now.getHours() + 1,
                        onReady: function(selectedDates, dateStr, instance) {
                            hideMinutes();
                            forceZeroMinute(instance);
                            applyMinTime(instance);
                        },
                        onChange: function(selectedDates, dateStr, instance) {
                            forceZeroMinute(instance);
                            applyMinTime(instance);
                        }
                    });

                    function applyMinTime(instance) {
                        const selectedDate = instance.selectedDates[0];
                        const today = new Date();

                        if (!selectedDate) return;
                        if (selectedDate.toDateString() == today.toDateString()) {
                            const nextHour = today.getHours() + 1;
                            instance.set('minTime', nextHour + ":00");
                        } else {
                            instance.set('minTime', "01:00");
                        }
                    }

                    function forceZeroMinute(instance) {
                        if (!instance.selectedDates[0]) return;

                        const d = instance.selectedDates[0];
                        d.setMinutes(0, 0);
                        instance.setDate(d, false);
                    }

                    function hideMinutes() {
                        document.querySelectorAll(
                            ".flatpickr-minute, .flatpickr-time-separator"
                        ).forEach(el => el.style.display = "none");
                    }
                },


                preConfirm: () => {
                    const date = document.getElementById('new_job_end').value;
                    if (!date) {
                        Swal.showValidationMessage('Please select expiry date & time');
                    }
                    return date;
                }

            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ route('update.job.status') }}",
                        type: "POST",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        data: {
                            id: jobId,
                            job_end: result.value
                        },
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Activated',
                                text: res.message || 'Job activated successfully',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        },
                        error: function() {
                            Swal.fire('Error', 'Unable to activate job', 'error');
                        }
                    });
                }
            });
        });
    </script>
@endsection
