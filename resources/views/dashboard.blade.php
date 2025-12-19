@extends('layouts.admin')
@section('page_title', 'Dashboard')

@section('content')
    <div class="container-fluid">

        <style>
            .stat-card {
                background: #fff;
                border-radius: 16px;
                padding: 22px;
                box-shadow: 0 12px 30px rgba(15, 23, 42, .08);
                transition: .2s ease;
                height: 100%;
                min-height: 120px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .stat-card:hover {
                transform: translateY(-4px);
            }

            .stat-icon {
                width: 54px;
                height: 54px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 22px;
                color: #fff;
            }

            .bg-blue {
                background: linear-gradient(135deg, #2563eb, #1e40af);
            }

            .bg-green {
                background: linear-gradient(135deg, #16a34a, #15803d);
            }

            .bg-orange {
                background: linear-gradient(135deg, #f97316, #ea580c);
            }

            .bg-red {
                background: linear-gradient(135deg, #dc2626, #b91c1c);
            }

            .table-card {
                background: #fff;
                border-radius: 16px;
                padding: 18px;
                box-shadow: 0 10px 26px rgba(15, 23, 42, .08);
            }

            .cursor-pointer {
                cursor: pointer;
            }

            .stat-card:hover {
                box-shadow: 0 16px 36px rgba(15, 23, 42, .12);
            }

            .super-calendar {
                height: 420px;
            }

            .calendar-grid {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                gap: 10px;
            }

            .calendar-week {
                text-align: center;
                font-size: 13px;
                font-weight: 600;
                color: #64748b;
            }

            .calendar-day {
                height: 46px;
                border-radius: 12px;
                background: #f8fafc;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
                cursor: pointer;
                transition: .2s ease;
                position: relative;
            }

            .calendar-day:hover {
                background: #e0f2fe;
            }

            .calendar-day.today {
                background: linear-gradient(135deg, #2563eb, #1e40af);
                color: #fff;
            }

            .calendar-day.has-event::after {
                content: '';
                width: 6px;
                height: 6px;
                background: #22c55e;
                border-radius: 50%;
                position: absolute;
                bottom: 6px;
            }
        </style>
        <div class="mb-4">
            <h3 class="fw-bold">Dashboard</h3>
            <small class="text-muted">Overview of your admin panel</small>
        </div>
        <div class="mb-4 row g-4">

            <div class="col-xl-3 col-md-6">
                <a href="{{ route('applied.users') }}" class="text-decoration-none text-dark">
                    <div class="stat-card d-flex justify-content-between">
                        <div>
                            <small class="text-muted">Today Applied Candidates</small>
                            <h3 class="mt-1 fw-bold">{{ $todayjobApplicationCount ?? 0 }}</h3>
                        </div>
                        <div class="stat-icon bg-orange">
                            <i class="fa fa-file-alt"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-md-6">
                <a href="{{ route('users') }}" class="text-decoration-none text-dark">
                    <div class="cursor-pointer stat-card d-flex justify-content-between">
                        <div>
                            <small class="text-muted">Total Users</small>
                            <h3 class="mt-1 fw-bold">{{ $users ?? '0' }}</h3>
                        </div>
                        <div class="stat-icon bg-blue">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-md-6">
                <a href="{{ route('active.jobs') }}" class="text-decoration-none text-dark">
                    <div class="stat-card d-flex justify-content-between">
                        <div>
                            <small class="text-muted">Active Jobs</small>
                            <h3 class="mt-1 fw-bold">{{ $activeJobs ?? '0' }}</h3>
                        </div>
                        <div class="stat-icon bg-green">
                            <i class="fa fa-briefcase"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-md-6">
                <a href="{{ route('expire.jobs') }}" class="text-decoration-none text-dark">
                    <div class="stat-card d-flex justify-content-between">
                        <div>
                            <small class="text-muted">Expired Jobs</small>
                            <h3 class="mt-1 fw-bold">{{ $expireJobs ?? '0' }}</h3>
                        </div>
                        <div class="stat-icon bg-red">
                            <i class="fa fa-ban"></i>
                        </div>
                    </div>
                </a>
            </div>

        </div>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="table-card super-calendar">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="fa fa-calendar-alt text-primary me-2"></i>
                            Calendar
                        </h5>

                        <div class="calendar-controls">
                            <button class="btn btn-sm btn-light" id="prevMonth">
                                <i class="fa fa-chevron-left"></i>
                            </button>
                            <span class="mx-2 fw-semibold" id="calendarMonth"></span>
                            <button class="btn btn-sm btn-light" id="nextMonth">
                                <i class="fa fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                    <div class="calendar-grid">
                        <div class="calendar-week">Sun</div>
                        <div class="calendar-week">Mon</div>
                        <div class="calendar-week">Tue</div>
                        <div class="calendar-week">Wed</div>
                        <div class="calendar-week">Thu</div>
                        <div class="calendar-week">Fri</div>
                        <div class="calendar-week">Sat</div>
                    </div>

                    <div class="calendar-grid" id="calendarDays"></div>
                </div>
            </div>

            <div class="col-lg-6"></div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>
        const calendarDays = document.getElementById("calendarDays");
        const calendarMonth = document.getElementById("calendarMonth");

        let date = new Date();

        function renderCalendar() {
            calendarDays.innerHTML = "";

            const year = date.getFullYear();
            const month = date.getMonth();

            calendarMonth.innerText = date.toLocaleString('default', {
                month: 'long',
                year: 'numeric'
            });

            const firstDay = new Date(year, month, 1).getDay();
            const lastDate = new Date(year, month + 1, 0).getDate();

            for (let i = 0; i < firstDay; i++) {
                calendarDays.innerHTML += `<div></div>`;
            }

            for (let day = 1; day <= lastDate; day++) {
                let todayClass = '';
                let eventClass = '';

                const today = new Date();
                if (
                    day === today.getDate() &&
                    month === today.getMonth() &&
                    year === today.getFullYear()
                ) {
                    todayClass = 'today';
                }



                calendarDays.innerHTML += `
                <div class="calendar-day ${todayClass} ${eventClass}">
                    ${day}
                </div>
            `;
            }
        }

        document.getElementById("prevMonth").onclick = () => {
            date.setMonth(date.getMonth() - 1);
            renderCalendar();
        };

        document.getElementById("nextMonth").onclick = () => {
            date.setMonth(date.getMonth() + 1);
            renderCalendar();
        };

        renderCalendar();
    </script>
@endsection
