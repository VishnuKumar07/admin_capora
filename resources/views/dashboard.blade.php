@extends('layouts.admin')

@section('page_title', 'E-commerce Dashboard')

@section('content')
    <div class="container-fluid">

        <style>
            /* ===== Ecommerce Dashboard Theme (Red) ===== */

            .stat-card {
                background: linear-gradient(145deg, #ffffff, #fff1f2);
                border-radius: 16px;
                padding: 22px;
                box-shadow: 0 12px 30px rgba(220, 38, 38, .12);
                transition: .25s ease;
                height: 100%;
                min-height: 120px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                border: 1px solid #fecaca;
            }

            .stat-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 18px 40px rgba(220, 38, 38, .18);
            }

            .stat-icon {
                width: 56px;
                height: 56px;
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 22px;
                color: #fff;
            }

            .bg-red {
                background: linear-gradient(135deg, #dc2626, #b91c1c);
            }

            .bg-pink {
                background: linear-gradient(135deg, #fb7185, #e11d48);
            }

            .bg-green {
                background: linear-gradient(135deg, #16a34a, #15803d);
            }

            .bg-orange {
                background: linear-gradient(135deg, #f97316, #ea580c);
            }

            .table-card {
                background: #ffffff;
                border-radius: 16px;
                padding: 18px;
                border: 1px solid #fecaca;
                box-shadow: 0 10px 26px rgba(220, 38, 38, .12);
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
                color: #6b7280;
            }

            .calendar-day {
                height: 46px;
                border-radius: 12px;
                background: #fef2f2;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
                cursor: pointer;
                transition: .2s ease;
                position: relative;
            }

            .calendar-day:hover {
                background: #ffe4e6;
            }

            .calendar-day.today {
                background: linear-gradient(135deg, #dc2626, #fb7185);
                color: #fff;
            }

            .calendar-day.has-event::after {
                content: '';
                width: 6px;
                height: 6px;
                background: #16a34a;
                border-radius: 50%;
                position: absolute;
                bottom: 6px;
            }
        </style>

        <!-- Page Header -->
        <div class="mb-4">
            <h3 class="fw-bold">E-commerce Dashboard</h3>
            <small class="text-muted">Overview of your online store</small>
        </div>

        <!-- Stats -->
        <div class="mb-4 row g-4">

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div>
                        <small class="text-muted">Today Orders</small>
                        <h3 class="mt-1 fw-bold">12</h3>
                    </div>
                    <div class="stat-icon bg-red">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div>
                        <small class="text-muted">Total Customers</small>
                        <h3 class="mt-1 fw-bold">1,245</h3>
                    </div>
                    <div class="stat-icon bg-pink">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div>
                        <small class="text-muted">Active Products</small>
                        <h3 class="mt-1 fw-bold">320</h3>
                    </div>
                    <div class="stat-icon bg-green">
                        <i class="fa fa-box"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div>
                        <small class="text-muted">Out of Stock</small>
                        <h3 class="mt-1 fw-bold">18</h3>
                    </div>
                    <div class="stat-icon bg-orange">
                        <i class="fa fa-triangle-exclamation"></i>
                    </div>
                </div>
            </div>

        </div>

        <!-- Calendar -->
        <div class="row g-4">
            <div class="col-lg-6">

                <!-- Recent Orders (Men's Clothing) -->
                <div class="mb-4 table-card">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="fa fa-shirt text-danger me-2"></i>
                            Recent Orders
                        </h5>
                        <a href="#" class="btn btn-sm btn-light">View All</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Product</th>
                                    <th>Size</th>
                                    <th>Status</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#MC1023</td>
                                    <td>Men Cotton Shirt</td>
                                    <td>M</td>
                                    <td><span class="badge bg-success">Delivered</span></td>
                                    <td class="text-end">₹1,499</td>
                                </tr>
                                <tr>
                                    <td>#MC1022</td>
                                    <td>Casual T-Shirt</td>
                                    <td>L</td>
                                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                                    <td class="text-end">₹799</td>
                                </tr>
                                <tr>
                                    <td>#MC1021</td>
                                    <td>Slim Fit Jeans</td>
                                    <td>32</td>
                                    <td><span class="badge bg-danger">Cancelled</span></td>
                                    <td class="text-end">₹1,999</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Low Stock Alerts (By Size) -->
                <div class="table-card">
                    <div class="mb-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fa fa-triangle-exclamation text-warning me-2"></i>
                            Low Stock Alerts (By Size)
                        </h5>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Formal Shirt – Size M
                            <span class="badge bg-danger">2 left</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Denim Jeans – Size 32
                            <span class="badge bg-warning text-dark">4 left</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Polo T-Shirt – Size XL
                            <span class="badge bg-danger">1 left</span>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="col-lg-6">
                <div class="table-card super-calendar">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="fa fa-calendar-alt text-danger me-2"></i>
                            Order Calendar
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

                const today = new Date();
                if (
                    day === today.getDate() &&
                    month === today.getMonth() &&
                    year === today.getFullYear()
                ) {
                    todayClass = 'today';
                }

                calendarDays.innerHTML += `
                <div class="calendar-day ${todayClass}">
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
