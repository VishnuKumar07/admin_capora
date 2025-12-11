@extends('layouts.admin')
@section('page_title', 'Deleted Users')
@section('content')
    <style>
        /* Layout & utility fixes to improve alignment and spacing */
        .hidden {
            display: none;
        }

        .card-panel {
            padding: 18px;
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
            padding: 6px 10px;
            font-size: 13px;
        }

        .users-table-wrapper .dataTables_filter label {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .users-table-wrapper .dataTables_filter input {
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            padding: 6px 10px;
            font-size: 13px;
            outline: none;
            box-shadow: none;
        }

        .users-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .users-card-header-title h4 {
            margin: 0 0 4px 0;
            font-weight: 700;
            font-size: 1.125rem;
        }

        .users-card-header-title span {
            display: block;
            color: #6b7280;
            font-size: 13px;
        }

        .users-badge-total {
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 13px;
            background: rgba(239, 68, 68, 0.06);
            color: #dc2626;
            border: 1px solid rgba(220, 38, 38, 0.12);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .users-table-wrapper {
            border-radius: 12px;
            border: 1px solid rgba(226, 232, 240, 0.9);
            background: #ffffff;
            overflow: visible;
        }

        /* Make table full width but allow horizontal scroll on small screens */
        .users-table {
            width: 100%;
            margin-bottom: 0;
            font-size: 13px;
            min-width: 1000px;
            border-collapse: separate;
        }

        .users-table thead {
            background: #f9fafb;
        }

        .users-table th,
        .users-table td {
            vertical-align: middle;
            padding: 10px 12px;
        }

        .user-mini {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 999px;
            background: linear-gradient(45deg, #ef4444, #b91c1c);
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
            color: #111827;
        }

        .user-text-sub {
            font-size: 13px;
            color: #6b7280;
        }

        .users-date-pill {
            border-radius: 999px;
            background: #fff5f5;
            border: 1px solid #fee2e2;
            padding: 4px 10px;
            font-size: 12px;
            color: #9f1239;
            display: inline-block;
        }

        .users-table-scroll {
            width: 100%;
            max-height: 420px;
            /* adjust height as per your screen */
            overflow-y: auto;
            overflow-x: auto;
            padding-bottom: 8px;
            position: relative;
        }

        /* Scrollbar styling */
        .users-table-scroll::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .users-table-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }


        /* action buttons */
        .btn-restore {
            background-color: #10b981 !important;
            color: #fff !important;
            border: 1px solid #059669;
        }

        .btn-perm-delete {
            background-color: #ef4444 !important;
            color: #fff !important;
            border: 1px solid #b91c1c;
        }

        /* Empty state centered and spaced */
        .users-empty-state {
            text-align: center;
            padding: 36px 20px;
            color: #6b7280;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .users-empty-state i {
            color: #ef4444;
        }

        /* Narrow columns */
        .col-checkbox {
            width: 34px;
        }

        .col-index {
            width: 48px;
            text-align: center;
        }

        .col-actions {
            white-space: nowrap;
            width: 140px;
        }


        .deleted-by-pill {
            display: inline-block;
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }


        @media (max-width: 768px) {
            .users-card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .users-card-header .gap-2 {
                width: 100%;
                display: flex;
                justify-content: flex-start;
                gap: 8px;
                margin-top: 8px;
            }

            .users-table {
                min-width: 900px;
            }

            .users-badge-total {
                padding: 6px 10px;
                font-size: 12px;
            }

            .col-actions {
                width: auto;
            }
        }
    </style>

    <div class="card-panel">
        <div class="users-card-header">
            <div class="users-card-header-title">
                <h4 class="fw-bold">Deleted Users</h4>
                <span>List of users removed (soft-deleted). You can restore or permanently delete records.</span>
            </div>

            <div class="gap-2 d-flex align-items-center">
                <div class="users-badge-total">
                    <i class="fa fa-user-slash" aria-hidden="true"></i>
                    <span>Total Deleted: {{ $deletedUsers->count() }}</span>
                </div>

                <a href="{{ route('users') }}" class="btn btn-outline-secondary btn-sm d-none d-md-inline-flex ms-2">
                    <i class="fa fa-arrow-left me-1" style="margin-top:4px"></i>&nbsp; Back to All Users
                </a>
            </div>
        </div>

        <div class="users-table-wrapper">
            @if ($deletedUsers->isEmpty())
                <div class="users-empty-state">
                    <i class="fa fa-user-times fa-2x" aria-hidden="true"></i>
                    <div class="mt-1 fw-semibold">No deleted users</div>
                    <div class="small">Users deleted recently will appear here. You can restore them if needed.</div>
                </div>
            @else
                <div class="px-3 py-2 d-flex justify-content-between align-items-center">


                    <div class="small text-muted">Showing {{ $deletedUsers->count() }} deleted users</div>
                </div>

                <div class="users-table-scroll">
                    <table class="table align-middle users-table" id="deletedUsersTable">
                        <thead>
                            <tr>
                                <th class="col-index">#</th>
                                <th>User</th>
                                <th>Username</th>
                                <th>Contact</th>
                                <th>Password</th>
                                <th>Deleted by</th>
                                <th>Deleted On</th>
                                <th class="col-actions">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($deletedUsers as $u)
                                <tr>
                                    <td class="col-index">{{ $deletedUsers->count() - $loop->index }}</td>
                                    <td>
                                        <div class="user-mini">
                                            <div class="user-avatar">{{ strtoupper(mb_substr($u->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="user-text-main">{{ $u->name ?? 'Unknown User' }}</div>
                                                <div class="user-text-sub">{{ $u->email ?? 'No email added' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="user-text-main">{{ $u->username ?? '—' }}</span></td>
                                    <td>
                                        <div class="user-text-main">
                                            @if ($u->mobile)
                                                +{{ $u->country_code ?? '' }} {{ $u->mobile }}
                                            @else
                                                —
                                            @endif
                                        </div>
                                    </td>
                                    <td><span class="user-text-main">{{ $u->sample_pass ?? '—' }}</span></td>
                                    <td>
                                        @if ($u->deleted_by)
                                            <span class="deleted-by-pill">{{ $u->deleted_by }}</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        <span class="users-date-pill">
                                            {{ $u->deleted_at ? $u->deleted_at->format('d M Y, h:i A') : '—' }}
                                        </span>
                                    </td>
                                    <td class="col-actions">
                                        <div class="gap-1 d-flex">
                                            <form action="{{ route('user.restore', $u->id) }}" method="POST"
                                                class="d-inline restore-form">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-restore btn-sm restore-btn"
                                                    title="Restore">
                                                    <i class="fa fa-undo"></i>&nbsp;&nbsp;Restore
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.querySelectorAll('.restore-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Restore Account?",
                    text: "Are you sure you want to restore this user account?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#10b981",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Restore",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

@endsection
