@extends('layouts.admin')
@section('title', 'Contact Enquiries')

@section('content')

    <style>
        :root {
            --primary: #dc2626;
            --primary-light: #fee2e2;
            --primary-dark: #7f1d1d;
            --bg-light: #fff5f5;
            --card-bg: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #6b7280;
            --border-light: #fecaca;
        }


        .page-content {
            padding: 22px 26px;
            background: var(--bg-light);
            min-height: calc(100vh - 70px);
        }

        .page-header-card {
            background: linear-gradient(135deg, #fff1f2, #ffe4e6);
            border-radius: 14px;
            padding: 20px 26px;
            margin-bottom: 20px;
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.15);
        }


        .page-header-card h4 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .page-header-card small {
            font-size: 13px;
            color: var(--text-muted);
        }

        .badge.rounded-pill {
            background: linear-gradient(135deg, #dc2626, #fb7185);
            padding: 8px 16px;
            font-size: 12px;
            font-weight: 600;
            color: #fff;
        }

        .data-card {
            border-radius: 14px;
            border: none;
            background: var(--card-bg);
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.07);
        }

        .data-card .card-body {
            padding: 20px 22px;
        }

        table.dataTable {
            margin-top: 12px !important;
            margin-bottom: 14px !important;
            border-collapse: separate !important;
            border-spacing: 0;
        }

        table.dataTable thead th {
            background: #f1f5f9;
            color: var(--text-dark);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .35px;
            text-transform: uppercase;
            padding: 12px 14px !important;
            border-bottom: 1px solid var(--border-light) !important;
        }

        table.dataTable tbody td {
            font-size: 13px;
            color: var(--text-dark);
            padding: 14px 14px !important;
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
        }

        table.dataTable tbody tr {
            transition: background .2s ease;
        }

        table.dataTable tbody tr:hover {
            background: #fff1f2;
        }

        .msg-text {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--text-muted);
        }

        .date-badge {
            background: #fee2e2;
            color: #7f1d1d;
            font-size: 11px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 999px;
        }


        .dataTables_wrapper {
            padding-top: 4px;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 14px;
        }

        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            font-size: 13px;
            color: var(--text-dark);
        }

        .dataTables_wrapper .dataTables_length select {
            border-radius: 20px;
            padding: 4px 8px;
            font-size: 13px;
            border: 1px solid var(--border-light);
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 20px;
            padding: 7px 14px;
            height: 36px;
            font-size: 13px;
            border: 1px solid var(--border-light);
        }

        .dataTables_wrapper .dataTables_info {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 12px;
        }

        .dataTables_wrapper .dataTables_paginate {
            margin-top: 12px;
        }

        .dataTables_wrapper .paginate_button {
            border-radius: 50% !important;
            padding: 4px 10px !important;
            margin: 0 3px;
            font-size: 13px;
            border: 1px solid var(--border-light) !important;
        }

        .dataTables_wrapper .paginate_button.current {
            background: var(--primary) !important;
            color: #fff !important;
            border-color: var(--primary) !important;
        }

        @media (max-width: 768px) {
            .page-content {
                padding: 16px;
            }

            .page-header-card {
                padding: 16px;
            }

            .data-card .card-body {
                padding: 16px;
            }

            table.dataTable thead th,
            table.dataTable tbody td {
                padding: 12px !important;
            }
        }
    </style>

    <div class="mb-4 page-header-card d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1 fw-bold">Contact Enquiries</h4>
            <small class="text-muted">Manage all enquiries submitted from website</small>
        </div>

        <span class="px-4 py-2 badge rounded-pill bg-primary">
            Total Enquiries: {{ $contactDetails->count() }}
        </span>
    </div>

    <div class="card data-card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table align-middle" id="enquiryTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Message</th>
                            <th>Created On</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($contactDetails as $key => $enquiry)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="fw-semibold">{{ $enquiry->name ?? '' }}</td>
                                <td>{{ $enquiry->email ?? '' }}</td>
                                <td>{{ $enquiry->mobile ?? '' }}</td>
                                <td>{{ $enquiry->message ?? '' }}</td>
                                <td>
                                    <span class="date-badge">
                                        {{ $enquiry->created_at->format('d M Y, h:i A') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#enquiryTable').DataTable({
                pageLength: 25,
                lengthMenu: [10, 25, 50, 100],
                order: [
                    [5, 'desc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: [4]
                }],
                language: {
                    search: "Search",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ enquiries",
                    emptyTable: "No enquiries found",
                    paginate: {
                        previous: "‹",
                        next: "›"
                    }
                }
            });

        });
    </script>
@endsection
