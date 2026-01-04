<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - CAPORA FASION</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DIN+Medium&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


    <style>
        :root {
            --primary: #dc2626;
            --accent: #fb7185;
            --dark: #111827;
            --nav-bg: #ffffff;
            --panel-bg: #fef2f2;
            --muted: #6b7280;
            --border-soft: #fecaca;
            --danger: #dc2626;
            --success: #16a34a;
            --warning: #f59e0b;
        }


        * {
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: radial-gradient(circle at top, #e0f2fe 0, #f8fafc 40%, #eff6ff 100%);
            margin: 0;
            padding: 0;
            color: #0f172a;
        }

        a {
            text-decoration: none;
        }

        .dash-topbar {
            height: 72px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(148, 163, 184, .18);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .dash-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dash-brand img {
            height: 44px;
        }

        .dash-brand-title {
            font-weight: 800;
            font-size: 18px;
            color: #0f172a;
            letter-spacing: 0.06em;
        }

        .dash-brand-subtitle {
            font-size: 11px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .16em;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-pill {
            padding: 6px 12px;
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, .3);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: var(--muted);
            background: rgba(255, 255, 255, .9);
        }

        .topbar-pill span.badge-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: #dc2626;
            box-shadow: 0 0 0 6px rgba(220, 38, 38, 0.25);
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, .25);
            background: rgba(255, 255, 255, 0.96);
        }

        .user-chip .user-meta {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .user-chip .user-name {
            font-size: 13px;
            font-weight: 600;
        }

        .user-chip .user-role {
            font-size: 11px;
            color: var(--muted);
        }

        .profile-thumb {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            background: radial-gradient(circle at 0 0, var(--accent), var(--primary));
            color: #fff;
            font-weight: 700;
            font-size: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-menu-btn {
            border: 0;
            background: transparent;
            font-size: 22px;
            color: #0f172a;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
        }

        .mobile-menu-btn:hover {
            background: rgba(148, 163, 184, .18);
        }

        .container-fluid {
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin: 0 !important;
        }

        .dash-container {
            display: flex;
            min-height: calc(100vh - 72px);
        }

        .dash-sidebar {
            width: 250px;
            background: linear-gradient(180deg, #7f1d1d, #450a0a 140px);
            color: #e2e8f0;
            padding: 18px 16px 18px 16px;
            border-right: 1px solid rgba(148, 163, 184, .28);
            position: sticky;
            top: 72px;
            flex-shrink: 0;
            height: calc(100vh - 72px);
        }

        .sidebar-inner {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .sidebar-section-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .18em;
            color: #94a3b8;
            padding: 0 10px;
            margin-bottom: 8px;
        }

        .dash-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .dash-menu li {
            margin-bottom: 4px;
        }

        .dash-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 11px;
            border-radius: 10px;
            color: #e2e8f0;
            font-size: 13px;
            font-weight: 500;
        }

        .dash-menu a .icon {
            width: 22px;
            height: 22px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(148, 163, 184, .16);
            font-size: 12px;
        }

        .dash-menu a .label {
            flex: 1;
        }

        .dash-menu a .badge-pill {
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 999px;
            background: rgba(15, 23, 42, .8);
            color: #e2e8f0;
        }

        .dash-menu a.active,
        .dash-menu a:hover {
            background: linear-gradient(135deg, #dc2626, #fb7185);
            color: #ffffff;
        }

        .dash-menu a.active .icon,
        .dash-menu a:hover .icon {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .sidebar-scroll {
            flex: 1 1 auto;
            overflow-y: auto;
            padding-right: 4px;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 0;
            height: 0;
        }

        .sidebar-scroll>div {
            margin-bottom: 24px;
        }

        .sidebar-footer {
            flex-shrink: 0;
            border-top: 1px solid rgba(148, 163, 184, .4);
            padding-top: 12px;
            font-size: 11px;
            color: #94a3b8;
        }

        .sidebar-footer .version-pill {
            border-radius: 999px;
            padding: 4px 9px;
            border: 1px solid rgba(148, 163, 184, .5);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 6px;
            background: rgba(15, 23, 42, .85);
            color: #e2e8f0;
        }

        .dash-main-wrapper {
            flex: 1;
            padding: 20px 26px;
            display: flex;
            flex-direction: column;
            min-height: calc(100vh - 72px);
            overflow-x: hidden;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .page-title {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: .03em;
        }

        .page-breadcrumb {
            font-size: 12px;
            color: var(--muted);
        }

        .page-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-soft {
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, .45);
            padding: 7px 13px;
            font-size: 12px;
            background: rgba(255, 255, 255, .9);
            color: #0f172a;
        }

        .btn-primary-gradient {
            border-radius: 999px;
            border: none;
            padding: 7px 14px;
            font-size: 12px;
            font-weight: 600;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #0f172a;
            box-shadow: 0 18px 35px rgba(37, 99, 235, 0.25);
        }

        .card-panel {
            background: linear-gradient(145deg, #ffffff, #fff1f2);
            border-radius: 18px;
            border: 1px solid #fecaca;
            box-shadow: 0 14px 34px rgba(220, 38, 38, 0.15);
        }

        .footer-note {
            font-size: 11px;
            color: var(--muted);
            text-align: center;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid rgba(148, 163, 184, .25);
        }

        .dash-main-wrapper {
            flex: 1;
            padding: 20px 26px;
            display: flex;
            flex-direction: column;
            min-height: calc(100vh - 72px);
        }

        main.content {
            flex: 1;
        }

        .mobile-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 995;
            background: rgba(15, 23, 42, .45);
        }

        .dash-sidebar.mobile-open {
            display: block !important;
            position: fixed;
            left: 0;
            top: 72px;
            height: calc(100vh - 72px);
            z-index: 1000;
            transform: translateX(0);
            transition: transform .25s ease;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .dash-sidebar.offcanvas {
            transform: translateX(-100%);
            transition: transform .25s ease;
            display: none;
        }

        .select2-container {
            width: 100% !important;
            font-size: 14px;
            box-sizing: border-box;
        }

        .select2-container--default .select2-selection--single {
            height: 40px;
            border-radius: 12px;
            border: 1px solid #dde3f0;
            background-color: #f8fbff;
            display: flex;
            align-items: center;
            padding: 0 40px 0 12px;
            box-shadow: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
            box-sizing: border-box;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #333;
            padding: 0;
            line-height: normal;
            font-size: 14px;
            margin-top: 1px;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #9ca3af;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            position: absolute;
            right: 10px;
            top: 0;
            width: 22px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #7b7b7b transparent transparent transparent;
            border-width: 5px 4px 0 4px;
            margin-left: -4px;
            margin-top: -2px;
        }

        .select2-container--default.select2-container--open .select2-selection--single,
        .select2-container--default .select2-selection--single:focus-within {
            border-color: #0081ff;
            box-shadow: 0 0 0 3px rgba(0, 129, 255, 0.15);
            background-color: #ffffff;
        }

        .select2-container--default .select2-results>.select2-results__options {
            font-size: 14px;
        }

        .select2-container--default .select2-results__option {
            padding: 8px 10px;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #0081ff;
            color: white;
        }

        .select2-container--default .select2-dropdown {
            border-radius: 12px;
            border: 1px solid #dde3f0;
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.12);
            overflow: hidden;
        }

        .select2-invalid .select2-selection {
            border: 1px solid #dc3545 !important;
        }

        .select2-valid .select2-selection {
            border: 1px solid #198754 !important;
        }


        .card-panel {
            padding: 30px;
        }

        @media (max-width: 991px) {
            #mobile_menu_btn {
                display: inline-flex !important;
            }

            .dash-brand-extra {
                display: none;
            }

            .dash-sidebar {
                width: 260px;
            }

            .dash-main-wrapper {
                padding: 16px;
            }
        }

        @media (min-width: 992px) {
            .dash-sidebar {
                display: block !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <header class="dash-topbar">
        <div class="dash-brand">
            <button id="mobile_menu_btn" style="display: none" class="mobile-menu-btn" type="button"
                aria-label="Open menu" aria-controls="sidebar" aria-expanded="false">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>

            <img src="{{ asset('images/logo.png') }}" alt="RSK" />
            <div class="dash-brand-extra">
                <div class="dash-brand-title">CAPORA FASION</div>
                <div class="dash-brand-subtitle">Admin Console</div>
            </div>
        </div>

        <div class="topbar-right">
            <div class="topbar-pill">
                <span class="badge-status"></span>
                <span>Admin Panel Live</span>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="dash-container">
            <aside id="sidebar" class="dash-sidebar offcanvas" role="navigation" aria-label="Main menu">
                <div class="sidebar-inner">

                    <div class="sidebar-scroll">
                        <div>
                            <div class="sidebar-section-title">Overview</div>
                            <ul class="dash-menu">
                                <li>
                                    <a href="{{ route('dashboard') }}"
                                        class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                        <span class="icon"><i class="fa fa-chart-line"></i></span>
                                        <span class="label">Dashboard</span>
                                    </a>

                                </li>
                            </ul>
                        </div>
                        <div>
                            <div class="sidebar-section-title">Catalog</div>
                            <ul class="dash-menu">
                                <li>
                                    <a href="{{ route('products.index') }}"
                                        class="{{ request()->routeIs('products.index*') ? 'active' : '' }}">
                                        <span class="icon"><i class="fa-solid fa-boxes-stacked"></i></span>
                                        <span class="label">All Product</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('products.create') }}"
                                        class="{{ request()->routeIs('products.create*') ? 'active' : '' }}">
                                        <span class="icon"><i class="fa-solid fa-square-plus"></i></span>
                                        <span class="label">Add Product</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('categories.index') }}"
                                        class="{{ request()->routeIs('categories.index*') ? 'active' : '' }}">
                                        <span class="icon"><i class="fa-solid fa-layer-group"></i></span>
                                        <span class="label">Categories</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <div>
                            <div class="sidebar-section-title">Orders</div>
                            <ul class="dash-menu">
                                <li>
                                    <a href="#">
                                        <span class="icon"><i class="fa-solid fa-bag-shopping"></i></span>
                                        <span class="label">All Orders</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="icon"><i class="fa-solid fa-circle-check"></i></span>
                                        <span class="label">Completed Orders</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="icon"><i class="fa-solid fa-rotate-left"></i></span>
                                        <span class="label">Returns</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <div class="sidebar-section-title">Customers</div>
                            <ul class="dash-menu">
                                <li>
                                    <a href="#">
                                        <span class="icon"><i class="fa-solid fa-users"></i></span>
                                        <span class="label">Customers</span>
                                    </a>
                                </li>

                            </ul>
                        </div>

                        <div>
                            <div class="sidebar-section-title">Marketing</div>
                            <ul class="dash-menu">
                                <li>
                                    <a href="{{ route('coupons.index') }}"
                                        class="{{ request()->routeIs('coupons.index') ? 'active' : '' }}">
                                        <span class="icon"><i class="fa-solid fa-tags"></i></span>
                                        <span class="label">Coupons</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="#">
                                        <span class="icon"><i class="fa-solid fa-images"></i></span>
                                        <span class="label">Banners</span>
                                    </a>
                                </li> --}}
                            </ul>
                        </div>

                        <div>
                            <div class="sidebar-section-title">Reports</div>
                            <ul class="dash-menu">
                                <li>
                                    <a href="{{ route('inventories.index') }}"
                                        class="{{ request()->routeIs('inventories.index*') ? 'active' : '' }}">
                                        <span class="icon"><i class="fa-solid fa-warehouse"></i></span>
                                        <span class="label">Inventory Report</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="icon"><i class="fa-solid fa-dollar-sign"></i></span>
                                        <span class="label">Sales Report</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <div class="sidebar-section-title">Password</div>
                            <ul class="dash-menu">
                                <li>
                                    <a href="{{ route('change.password') }}"
                                        class="{{ request()->routeIs('change.password') ? 'active' : '' }}">
                                        <span class="icon"><i class="fa fa-key"></i></span>
                                        <span class="label">Change Password</span>
                                    </a>
                                </li>
                            </ul>
                        </div>


                        <div>
                            <div class="sidebar-section-title">System</div>
                            <ul class="dash-menu">
                                <li>
                                    <a href="{{ route('settings.company') }}"
                                        class="{{ request()->routeIs('settings.company') ? 'active' : '' }}">
                                        <span class="icon"><i class="fa-solid fa-building"></i></span>
                                        <span class="label">Company Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('settings.payment.methods') }}"
                                        class="{{ request()->routeIs('settings.payment.methods') ? 'active' : '' }}">
                                        <span class="icon"><i class="fa-solid fa-credit-card"></i></span>
                                        <span class="label">Payment Methods Settings</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('settings.tax') }}"
                                        class="{{ request()->routeIs('settings.tax') ? 'active' : '' }}">
                                        <span class="icon"><i class="fa-solid fa-receipt"></i></span>
                                        <span class="label">Tax (GST) Settings</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" id="logout_btn">
                                        <span class="icon"><i class="fa fa-right-from-bracket"></i></span>
                                        <span class="label">Logout</span>
                                    </a>
                                    <form id="logout_form" action="{{ route('logout') }}" method="POST"
                                        style="display:none;"> @csrf </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="sidebar-footer">
                        <div>Signed in as <strong>{{ auth()->user()->username }}</strong></div>
                        <div class="version-pill">
                            <i class="fa fa-rocket"></i>
                            <span>KEPORA Admin v1.0</span>
                        </div>
                    </div>

                </div>
            </aside>


            <div class="dash-main-wrapper">
                <main class="content">
                    @hasSection('page_header')
                        <div class="page-header">
                            <div>
                                <div class="page-title">@yield('page_title')</div>
                                <div class="page-breadcrumb">@yield('page_breadcrumb')</div>
                            </div>
                            <div class="page-actions">
                                @yield('page_actions')
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </main>

                <div class="footer-note">
                    &copy; {{ date('Y') }} CAPORA FASION. Admin panel for managing users, bookings & site
                    content.
                </div>
            </div>

        </div>
    </div>

    <div id="mobile_backdrop" class="mobile-backdrop" tabindex="-1" aria-hidden="true"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.select2').each(function() {
                let $this = $(this);

                let options = {
                    width: '100%'
                };

                let $modalParent = $this.closest('.modal');
                if ($modalParent.length) {
                    options.dropdownParent = $modalParent;
                }
                $this.select2(options);
            });
            $(document).on("click", "#logout_btn", function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Logout?",
                    text: "You will be logged out of your admin account.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Logout",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#logout_form").submit();
                    }
                });
            });


            $(function() {
                const $btn = $('#mobile_menu_btn');
                const $sidebar = $('#sidebar');
                const $backdrop = $('#mobile_backdrop');
                const $firstLink = $('.dash-menu a').first();

                $btn.attr('aria-controls', 'sidebar').attr('aria-expanded', 'false');

                function openSidebar() {
                    $sidebar.addClass('mobile-open').removeClass('offcanvas').show();
                    $backdrop.show();
                    $('body').css('overflow', 'hidden');
                    $btn.attr('aria-expanded', 'true');
                    setTimeout(() => {
                        if ($firstLink.length) $firstLink.focus();
                    }, 150);
                }

                function closeSidebar() {
                    $sidebar.removeClass('mobile-open').addClass('offcanvas').hide();
                    $backdrop.hide();
                    $('body').css('overflow', '');
                    $btn.attr('aria-expanded', 'false');
                }

                $btn.on('click', function(e) {
                    e.preventDefault();
                    if ($(window).width() <= 991) {
                        if ($sidebar.hasClass('mobile-open')) closeSidebar();
                        else openSidebar();
                    }
                });

                $backdrop.on('click', closeSidebar);

                $(document).on('click', '.dash-menu a', function() {
                    if ($(window).width() <= 991) {
                        setTimeout(closeSidebar, 120);
                    }
                });

                $(document).on('keydown', function(e) {
                    if (e.key == 'Escape' || e.keyCode == 27) {
                        if ($sidebar.hasClass('mobile-open')) closeSidebar();
                    }
                });

                $(window).on('resize', function() {
                    if ($(window).width() >= 992) {
                        $sidebar.removeClass('mobile-open offcanvas').show();
                        $backdrop.hide();
                        $('body').css('overflow', '');
                        $btn.attr('aria-expanded', 'false');
                    } else {
                        $sidebar.addClass('offcanvas').hide();
                    }
                }).trigger('resize');
            });

            const $sidebarScroll = $('.sidebar-scroll');
            const $activeItem = $sidebarScroll.find('.dash-menu a.active').first();

            if ($activeItem.length) {
                const sidebarHeight = $sidebarScroll.height();
                const itemTop = $activeItem.position().top;
                const itemBottom = itemTop + $activeItem.outerHeight();
                if (itemBottom > sidebarHeight || itemTop < 0) {
                    const targetScroll = itemTop - 60;
                    $sidebarScroll.animate({
                        scrollTop: targetScroll
                    }, 300);
                }
            }
        })
    </script>

    @yield('scripts')
</body>

</html>
