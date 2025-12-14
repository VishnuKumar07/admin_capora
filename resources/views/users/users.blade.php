@extends('layouts.admin')
@section('page_title', 'All Users')
@section('content')
    <style>
        .hidden {
            display: none;
        }

        .users-table-wrapper .dataTables_wrapper {
            padding: 10px 16px 0;
        }

        .users-table-wrapper .dataTables_length,
        .users-table-wrapper .dataTables_filter {
            margin-bottom: 8px;
            font-size: 13px;
        }

        .users-table-wrapper .dataTables_length select {
            border-radius: 999px;
            padding: 2px 8px;
            font-size: 13px;
        }

        .users-table-wrapper .dataTables_filter label {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .users-table-wrapper .dataTables_filter input {
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            padding: 4px 10px;
            font-size: 13px;
            outline: none;
            box-shadow: none;
        }

        .users-table-wrapper .dataTables_info,
        .users-table-wrapper .dataTables_paginate {
            padding: 8px 16px 10px;
            font-size: 12px;
        }

        .users-table-wrapper .dataTables_paginate {
            text-align: right;
        }

        .users-table-wrapper .dataTables_paginate .paginate_button {
            border-radius: 999px !important;
            border: 1px solid #e5e7eb !important;
            padding: 3px 10px !important;
            margin: 0 2px !important;
            font-size: 12px;
            background: #fff !important;
        }

        .users-table-wrapper .dataTables_paginate .paginate_button.current {
            background: #2563eb !important;
            color: #fff !important;
            border-color: #2563eb !important;
        }

        .users-table-wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: .5;
        }

        .users-table-wrapper table.dataTable {
            border-collapse: separate;
            border-spacing: 0;
        }

        .users-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .users-card-header-title {
            display: flex;
            flex-direction: column;
        }

        .users-card-header-title h4 {
            margin: 0;
            font-weight: 700;
        }

        .users-card-header-title span {
            font-size: 12px;
            color: #64748b;
        }

        .users-badge-total {
            border-radius: 999px;
            padding: 6px 14px;
            font-size: 12px;
            background: rgba(37, 99, 235, 0.06);
            color: #1d4ed8;
            border: 1px solid rgba(37, 99, 235, 0.18);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .users-badge-total i {
            font-size: 13px;
        }

        .users-table-wrapper {
            border-radius: 14px;
            border: 1px solid rgba(226, 232, 240, 0.9);
            background: #ffffff;
            overflow: visible;
        }

        .users-table {
            margin-bottom: 0;
            font-size: 13px;
            min-width: 1100px;
        }

        .users-table thead {
            background: #f9fafb;
        }

        .users-table thead th {
            border-bottom-width: 1px;
            border-color: #e5e7eb !important;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #6b7280;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .users-table tbody tr {
            transition: background-color 0.15s ease, transform 0.1s ease;
        }

        .users-table tbody tr:hover {
            background: #f1f5f9;
        }

        .users-table tbody td {
            padding-top: 10px;
            padding-bottom: 10px;
            border-color: #eef2f7;
        }

        .users-table th,
        .users-table td {
            white-space: nowrap;
        }

        .user-mini {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            background: radial-gradient(circle at 0 0, var(--accent), var(--primary));
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .user-text-main {
            font-weight: 600;
            color: #0f172a;
        }

        .user-text-sub {
            font-size: 12px;
            color: #6b7280;
        }

        .users-source-pill {
            border-radius: 999px;
            font-size: 11px;
            padding: 4px 9px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .users-source-admin {
            background: rgba(22, 163, 74, 0.08);
            color: #15803d;
            border: 1px solid rgba(22, 163, 74, 0.18);
        }

        .users-source-website {
            background: rgba(59, 130, 246, 0.08);
            color: #1d4ed8;
            border: 1px solid rgba(59, 130, 246, 0.18);
        }

        .users-source-other {
            background: rgba(148, 163, 184, 0.1);
            color: #4b5563;
            border: 1px solid rgba(148, 163, 184, 0.25);
        }

        .users-date-pill {
            border-radius: 999px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 3px 9px;
            font-size: 11px;
            color: #6b7280;
        }

        .users-empty-state {
            padding: 40px 16px;
            text-align: center;
            color: #6b7280;
        }

        .users-empty-state i {
            color: #cbd5f5;
            margin-bottom: 8px;
        }

        .users-table-scroll {
            width: 100%;
            overflow-x: auto;
            overflow-y: visible;
        }

        .users-table-scroll::-webkit-scrollbar {
            height: 6px;
        }

        .users-table-scroll::-webkit-scrollbar-track {
            background: #f3f4f6;
        }

        .users-table-scroll::-webkit-scrollbar-thumb {
            background: #cbd5f5;
            border-radius: 999px;
        }

        .change-pass-user-badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 12px;
            border-radius: 999px;
            background: rgba(59, 130, 246, 0.10);
            color: #1d4ed8;
            border: 1px solid rgba(59, 130, 246, 0.25);
            font-weight: 600;
        }

        .btn-change-password {
            background-color: #22c55e !important;
            color: #fff !important;
            border: 1px solid #16a34a;
        }

        .btn-change-password:hover {
            background-color: #16a34a !important;
        }


        @media (max-width: 768px) {
            .users-card-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <div class="card-panel">
        <div class="users-card-header">
            <div class="users-card-header-title">
                <h4 class="fw-bold">All Users</h4>
                <span>Manage all registered users from admin & website.</span>
            </div>

            <div class="gap-2 d-flex align-items-center">
                <div class="users-badge-total">
                    <i class="fa fa-users"></i>
                    <span>Total Users: {{ $users->count() }}</span>
                </div>

                <a href="{{ route('add.users') }}" class="btn btn-primary-gradient btn-sm d-none d-md-inline-flex">
                    <i class="fa fa-user-plus me-1" style="margin-top: 4px;"></i>&nbsp; Add New User
                </a>
            </div>
        </div>

        <div class="users-table-wrapper">
            @if ($users->isEmpty())
                <div class="users-empty-state">
                    <i class="fa fa-user-slash fa-2x"></i>
                    <div class="mt-1 fw-semibold">No users found</div>
                    <div class="small">Once users are created, they will appear in this list.</div>
                </div>
            @else
                <div class="px-2 my-2 d-flex justify-content-between">
                    <div>
                        <button id="downloadCsvBtn" class="btn btn-success btn-sm">
                            <i class="fa fa-download"></i> Download CSV
                        </button>

                    </div>
                </div>

                <div class="users-table-scroll">
                    <table class="table align-middle users-table" id="usersTable">
                        <thead>
                            <tr>
                                <th style="width: 28px;">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th style="width: 40px;">#</th>
                                <th>User</th>
                                <th>Username</th>
                                <th>Contact</th>
                                <th>Password</th>
                                <th class="hidden">Gender</th>
                                <th class="hidden">Age</th>
                                <th class="hidden">Dob</th>
                                <th class="hidden">Education</th>
                                <th class="hidden">Passport Number</th>
                                <th class="hidden">Current Country</th>
                                <th>Job Category</th>
                                <th>Source</th>
                                <th>Created On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $u)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="select-user" value="{{ $u->users->id }}">
                                    </td>
                                    <td>{{ $users->count() - $loop->index }}</td>

                                    <td>
                                        <div class="user-mini">
                                            <div class="user-avatar">
                                                {{ strtoupper(mb_substr($u->users->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="user-text-main">
                                                    {{ $u->users->name ?? 'Unknown User' }}
                                                </div>
                                                <div class="user-text-sub">
                                                    {{ $u->users->email ?? 'No email added' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="user-text-main">
                                            {{ $u->users->username ?? '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="user-text-main">
                                            @if ($u->users->mobile)
                                                +{{ $u->users->country_code ?? '' }} {{ $u->users->mobile }}
                                            @else
                                                —
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="gap-1 d-flex align-items-center">
                                            <span class="user-text-main sample-pass-text">
                                                {{ $u->users->sample_pass ?? '—' }}
                                            </span>

                                            @if ($u->users->sample_pass)
                                                <button type="button" class="p-0 btn btn-link btn-sm ms-1 copy-pass-btn"
                                                    data-pass="{{ $u->users->sample_pass }}" title="Copy to clipboard">
                                                    <i class="fa fa-copy"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="hidden">
                                        <span class="user-text-main">
                                            {{ $u->gender ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="hidden">
                                        <span class="user-text-main">
                                            {{ $u->age ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="hidden">
                                        <span class="user-text-main">
                                            {{ $u->dob ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="hidden">
                                        <span class="user-text-main">
                                            {{ $u->education->name ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="hidden">
                                        <span class="user-text-main">
                                            {{ $u->passport_no ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="hidden">
                                        <span class="user-text-main">
                                            {{ $u->country->name ?? '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="user-text-main">
                                            {{ $u->jobcategory->name ?? '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $source = $u->users->source ?? 'Unknown';
                                            $sourceClass = 'users-source-other';
                                            if ($source == 'Admin') {
                                                $sourceClass = 'users-source-admin';
                                            } elseif ($source == 'Website') {
                                                $sourceClass = 'users-source-website';
                                            }
                                        @endphp

                                        <span class="users-source-pill {{ $sourceClass }}">
                                            <i class="fa fa-globe"></i>
                                            {{ $source }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="users-date-pill">
                                            {{ $u->created_at ? $u->created_at->format('d M Y, h:i A') : '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="gap-1 d-flex align-items-center">
                                            <a href="{{ route('view.profile', encrypt($u->users->id)) }}"
                                                class="btn btn-primary btn-sm" title="View more">
                                                <i class="fa fa-eye me-1"></i>
                                            </a>
                                            <a href="{{ route('edit.profile', encrypt($u->users->id)) }}"
                                                class="btn btn-warning btn-sm" title="Edit User">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-change-password btn-sm change-pass-btn"
                                                data-bs-toggle="modal" data-bs-target="#changePasswordModal"
                                                data-user-id="{{ $u->users->id }}"
                                                data-user-name="{{ $u->users->name ?? ($u->users->username ?? ($u->users->email ?? 'User')) }}"
                                                title="Change Password">
                                                <i class="fa fa-key"></i>
                                            </button>

                                            <button type="button" class="btn btn-danger btn-sm delete-user-btn"
                                                data-user-id="{{ $u->users->id }}"
                                                data-user-name="{{ $u->users->name ?? ($u->users->username ?? ($u->users->email ?? 'User')) }}"
                                                title="Delete user">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <form id="downloadCsvForm" action="{{ route('users.csv.download') }}" method="POST" target="_blank">
                        @csrf
                        <input type="hidden" name="ids" id="csv_ids">
                        <input type="hidden" name="columns" id="csv_columns">
                        <input type="hidden" name="gender" id="csv_gender">
                        <input type="hidden" name="jobcategory" id="csv_jobcategory">
                    </form>



                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <input type="hidden" name="user_id" id="changePasswordUserId">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">
                        Change Password
                        <small class="d-block text-muted" style="font-size: 12px;">
                            <span id="changePasswordUserName" class="mt-2 change-pass-user-badge"></span>
                        </small>
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3 position-relative">
                        <label for="new_password" class="form-label">New Password&nbsp;<span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" placeholder="Enter new password" name="password" id="new_password"
                                class="form-control">
                            <span class="input-group-text toggle-password" data-target="#new_password"
                                style="cursor:pointer;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        <span id="new_password_error" class="text-danger"></span>
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="confirm_password" class="form-label">Confirm Password&nbsp;<span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" placeholder="Enter confirm password" name="password_confirmation"
                                id="confirm_password" class="form-control">
                            <span class="input-group-text toggle-password" data-target="#confirm_password"
                                style="cursor:pointer;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        <span id="confirm_password_error" class="text-danger"></span>
                    </div>

                    <div class="small text-muted">
                        Password must be at least 6 characters.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="change_password_btn">
                        <i class="fa fa-save me-1"></i> Save Password
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="csvColumnsModal" tabindex="-1" aria-labelledby="csvColumnsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="csvColumnsModalLabel">
                        Select Columns for CSV
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p class="mb-2 small text-muted">
                        Choose which columns you want in the downloaded CSV.
                    </p>
                    <div class="row">
                        <div class="mb-2 col-4">
                            <div class="form-check">
                                <input class="form-check-input csv-column-checkbox" type="checkbox" value="id"
                                    id="col_id" checked>
                                <label class="form-check-label" for="col_id">
                                    ID
                                </label>
                            </div>
                        </div>
                        <div class="mb-2 col-4">
                            <div class="form-check">
                                <input class="form-check-input csv-column-checkbox" type="checkbox" value="name"
                                    id="col_name" checked>
                                <label class="form-check-label" for="col_name">
                                    Name
                                </label>
                            </div>
                        </div>
                        <div class="mb-2 col-4">
                            <div class="form-check">
                                <input class="form-check-input csv-column-checkbox" type="checkbox" value="email"
                                    id="col_email" checked>
                                <label class="form-check-label" for="col_email">
                                    Email
                                </label>
                            </div>
                        </div>
                        <div class="mb-2 col-4">
                            <div class="form-check">
                                <input class="form-check-input csv-column-checkbox" type="checkbox" value="username"
                                    id="col_username" checked>
                                <label class="form-check-label" for="col_username">
                                    Username
                                </label>
                            </div>
                        </div>
                        <div class="mb-2 col-4">
                            <div class="form-check">
                                <input class="form-check-input csv-column-checkbox" type="checkbox" value="mobile"
                                    id="col_mobile" checked>
                                <label class="form-check-label" for="col_mobile">
                                    Mobile
                                </label>
                            </div>
                        </div>
                        <div class="mb-2 col-4">
                            <div class="form-check">
                                <input class="form-check-input csv-column-checkbox" type="checkbox" value="gender"
                                    id="col_gender" checked>
                                <label class="form-check-label" for="col_gender">
                                    Gender
                                </label>
                            </div>
                        </div>
                        <div class="mb-2 col-4">
                            <div class="form-check">
                                <input class="form-check-input csv-column-checkbox" type="checkbox" value="age"
                                    id="col_age" checked>
                                <label class="form-check-label" for="col_age">
                                    Age
                                </label>
                            </div>
                        </div>
                        <div class="mb-2 col-4">
                            <div class="form-check">
                                <input class="form-check-input csv-column-checkbox" type="checkbox" value="dob"
                                    id="col_dob" checked>
                                <label class="form-check-label" for="col_dob">
                                    Dob
                                </label>
                            </div>
                        </div>
                        <div class="mb-2 col-4">
                            <div class="form-check">
                                <input class="form-check-input csv-column-checkbox" type="checkbox" value="education"
                                    id="col_education" checked>
                                <label class="form-check-label" for="col_education">
                                    Education
                                </label>
                            </div>
                        </div>
                        <div class="mb-2 col-4">
                            <div class="form-check">
                                <input class="form-check-input csv-column-checkbox" type="checkbox" value="passport_no"
                                    id="col_passport_no" checked>
                                <label class="form-check-label" for="col_passport_no">
                                    Passport No
                                </label>
                            </div>
                        </div>
                        <div class="mb-2 col-4">
                            <div class="form-check">
                                <input class="form-check-input csv-column-checkbox" type="checkbox"
                                    value="current_country" id="col_current_country" checked>
                                <label class="form-check-label" for="col_current_country">
                                    Current Country
                                </label>
                            </div>
                        </div>
                        <div class="mb-2 col-4">
                            <div class="form-check">
                                <input class="form-check-input csv-column-checkbox" type="checkbox" value="jobcategory"
                                    id="col_jobcategory" checked>
                                <label class="form-check-label" for="col_jobcategory">
                                    Job Category
                                </label>
                            </div>
                        </div>
                        <div class="mb-2 col-4">
                            <div class="form-check">
                                <input class="form-check-input csv-column-checkbox" type="checkbox" value="source"
                                    id="col_source" checked>
                                <label class="form-check-label" for="col_source">
                                    Source
                                </label>
                            </div>
                        </div>
                        <div class="mb-2 col-4">
                            <div class="form-check">
                                <input class="form-check-input csv-column-checkbox" type="checkbox" value="created_at"
                                    id="col_created_at" checked>
                                <label class="form-check-label" for="col_created_at">
                                    Created On
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label" for="csv_gender_filter">Filter by Gender (optional)</label>
                        <select id="csv_gender_filter" class="form-select form-select-sm">
                            <option value="">Use selected users only</option>
                            <option value="Male">Male (all users)</option>
                            <option value="Female">Female (all users)</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label class="form-label" for="csv_jobcategory_filter">Filter by Job Category (optional)</label>
                        <select id="csv_jobcategory_filter" class="form-select form-select-sm">
                            <option value="">Use selected users only / all jobs</option>
                            @foreach ($jobcategories as $jobcategy)
                                <option value="{{ $jobcategy->id }}">{{ $jobcategy->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirmDownloadCsv">
                        <i class="fa fa-download me-1"></i> Download CSV
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                order: [],
                columnDefs: [{
                        orderable: false,
                        targets: 0
                    },
                    {
                        orderable: false,
                        targets: 1
                    },
                    {
                        orderable: false,
                        targets: 4
                    }
                ],
                dom: "<'row mb-2'<'col-sm-6'l><'col-sm-6'f>>" +
                    "rt" +
                    "<'row mt-2'<'col-sm-5'i><'col-sm-7 text-sm-end'p>>"
            });

            $(document).on('click', '.copy-pass-btn', function() {
                const pass = $(this).data('pass');
                if (!pass) return;

                const $btn = $(this);
                const originalIcon = $btn.find('i').attr('class');

                function showCopied() {
                    $btn.find('i').attr('class', 'fa fa-check');
                    $btn.attr('title', 'Copied!');
                    setTimeout(function() {
                        $btn.find('i').attr('class', originalIcon);
                        $btn.attr('title', 'Copy to clipboard');
                    }, 1200);
                }

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(pass).then(showCopied).catch(function() {
                        const temp = $('<input>');
                        $('body').append(temp);
                        temp.val(pass).select();
                        document.execCommand('copy');
                        temp.remove();
                        showCopied();
                    });
                } else {
                    const temp = $('<input>');
                    $('body').append(temp);
                    temp.val(pass).select();
                    document.execCommand('copy');
                    temp.remove();
                    showCopied();
                }
            });

            function updateBulkButtons() {
                $("#selectAll").prop(
                    "checked",
                    $(".select-user").length == $(".select-user:checked").length
                );
            }

            $("#selectAll").on("change", function() {
                $(".select-user").prop("checked", $(this).is(":checked"));
                updateBulkButtons();
            });

            $(document).on("change", ".select-user", function() {
                updateBulkButtons();
            });

            $("#downloadCsvBtn").on("click", function() {
                let ids = $(".select-user:checked")
                    .map(function() {
                        return $(this).val();
                    })
                    .get();

                $("#csv_ids").val(JSON.stringify(ids));
                $('#csvColumnsModal').modal('show');
            });

            $("#confirmDownloadCsv").on("click", function() {
                let selectedColumns = $(".csv-column-checkbox:checked")
                    .map(function() {
                        return $(this).val();
                    })
                    .get();

                if (selectedColumns.length == 0) {
                    Swal.fire({
                        icon: "warning",
                        title: "No Columns Selected",
                        text: "Please select at least one column for the CSV file."
                    });
                    return;
                }

                let genderFilter = $("#csv_gender_filter").val() || "";
                let appliedFilter = $("#csv_jobcategory_filter").val() || "";
                let idsJson = $("#csv_ids").val() || "[]";
                let ids = [];

                try {
                    ids = JSON.parse(idsJson);
                } catch (e) {
                    ids = [];
                }

                if (!genderFilter && !appliedFilter && (!ids || ids.length == 0)) {
                    Swal.fire({
                        icon: "warning",
                        title: "No Users Selected",
                        text: "Please select at least one user or choose a gender / job filter."
                    });
                    return;
                }

                $("#csv_columns").val(JSON.stringify(selectedColumns));
                $("#csv_gender").val(genderFilter);
                $("#csv_jobcategory").val(appliedFilter);

                $('#csvColumnsModal').modal('hide');
                $("#downloadCsvForm").submit();
            });


            $('#changePasswordModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);

                const userId = button.data('user-id');
                const userName = button.data('user-name');
                $('#changePasswordUserId').val(userId);
                $('#changePasswordUserName').text(userName);
                $('#new_password').val('');
                $('#confirm_password').val('');
            });

            $(document).on("click", ".toggle-password", function() {
                let input = $($(this).data("target"));
                let icon = $(this).find("i");

                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                    icon.removeClass("fa-eye").addClass("fa-eye-slash");
                } else {
                    input.attr("type", "password");
                    icon.removeClass("fa-eye-slash").addClass("fa-eye");
                }
            });

            $("#change_password_btn").click(function() {
                let userId = $('#changePasswordUserId').val();
                let new_password = $("#new_password").val()
                let confirm_password = $("#confirm_password").val()
                if (!userId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'User not found',
                        text: 'Unable to update password because no user is selected.',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }

                if (new_password == '') {
                    $("#new_password_error").text("Please enter new password");
                    $("#new_password").focus()
                    return false
                } else if (new_password.length < 6) {
                    $("#new_password_error").text("Password must be atlest 6 characters");
                    $("#new_password").focus()
                    return false
                } else {
                    $("#new_password_error").text("");
                }

                if (confirm_password == '') {
                    $("#confirm_password_error").text("Please enter confirm password");
                    $("#confirm_password").focus()
                    return false
                } else if (confirm_password != new_password) {
                    $("#confirm_password_error").text("Password Mismatch");
                    $("#confirm_password").focus()
                    return false
                } else {
                    $("#confirm_password_error").text("");
                }

                $.ajax({
                    url: "{{ route('change.user.password') }}",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    data: {
                        new_password: new_password,
                        user_id: userId
                    },
                    beforeSend: function() {
                        $("#change_password_btn").prop("disabled", true).text("Updating...");
                    },
                    success: function(res) {
                        $("#change_password_btn").prop("disabled", false).html(
                            '<i class="fa fa-save"></i> Save Password');

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
                            '<i class="fa fa-save"></i> Save Password');

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

            $(document).on("click", ".delete-user-btn", function(e) {
                e.preventDefault();

                let $btn = $(this);
                let userId = $btn.data("user-id");
                let userName = $btn.data("user-name") || "this user";

                if (!userId) {
                    Swal.fire({
                        icon: "error",
                        title: "User not found",
                        text: "Unable to delete because no user is selected.",
                    });
                    return;
                }

                Swal.fire({
                    title: "Are you sure?",
                    html: "You are about to delete <strong>" + userName + "</strong> account.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete",
                    cancelButtonText: "Cancel",
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d"
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    $.ajax({
                        url: "{{ route('delete.user.account') }}",
                        type: "delete",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        data: {
                            user_id: userId,
                        },
                        beforeSend: function() {
                            $btn.prop("disabled", true).html(
                                '<i class="fa fa-spinner fa-spin"></i>');
                        },
                        success: function(res) {
                            $btn.prop("disabled", false).html(
                                '<i class="fa fa-trash"></i>');

                            if (res.status) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Deleted",
                                    text: res.message ||
                                        "User deleted successfully.",
                                }).then(() => {
                                    location.reload()
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: res.message ||
                                        "Something went wrong while deleting user.",
                                });
                            }
                        },
                        error: function(xhr) {
                            $btn.prop("disabled", false).html(
                                '<i class="fa fa-trash"></i>');

                            if (xhr.status == 404) {
                                Swal.fire({
                                    icon: "error",
                                    title: "User Not Found",
                                    text: "The user you are trying to delete does not exist.",
                                });
                                return;
                            }

                            if (xhr.status == 422 && xhr.responseJSON && xhr
                                .responseJSON.errors) {
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
        });
    </script>
@endsection
