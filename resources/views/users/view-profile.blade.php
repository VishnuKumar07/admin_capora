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

        /* SUPER STYLED HERO BUTTONS */
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

        .details-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 22px 24px 24px 24px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.04);
        }

        .details-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .details-title {
            font-size: 18px;
            font-weight: 800;
            color: #06345e;
        }

        .details-subtitle {
            font-size: 13px;
            color: #6c7a8b;
            font-weight: 500;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px 18px;
            margin-top: 8px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .detail-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #7a8899;
        }

        .detail-value {
            font-size: 14px;
            font-weight: 700;
            color: #1b3354;
            padding: 7px 11px;
            border-radius: 999px;
            background: #f4f7ff;
            border: 1px solid rgba(0, 118, 255, 0.14);
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .detail-value.empty {
            color: #a0a8b5;
            font-weight: 500;
            font-style: italic;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
        }

        .status-pill .dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
        }

        .status-pill.completed {
            background: #e9fbf1;
            color: #167a3d;
            border: 1px solid #b7f0cf;
        }

        .status-pill.completed .dot {
            background: #20b25d;
        }

        .status-pill.incomplete {
            background: #fff5e9;
            color: #b06711;
            border: 1px solid #ffd9a9;
        }

        .status-pill.incomplete .dot {
            background: #f0a238;
        }

        .status-pill.pending {
            background: #e9f2ff;
            color: #1352b6;
            border: 1px solid #bed2ff;
        }

        .status-pill.pending .dot {
            background: #2e7bff;
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

        .edit-title {
            font-size: 19px;
            font-weight: 800;
            color: #053663;
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
            grid-template-columns: repeat(2, minmax(0, 1fr));
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

        .modal-dialog.modal-xl {
            max-width: 720px !important;
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
            max-width: 260px;
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

        .btn-cancel {
            border-radius: 999px;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 700;
            border: 1px solid rgba(13, 36, 64, 0.16);
            background: #f2f4fa;
            color: #1f3350;
            cursor: pointer;
            transition: background .18s ease, color .18s ease, transform .18s ease;
        }

        .btn-cancel:hover {
            background: #e3e7f3;
            transform: translateY(-1px);
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


        @keyframes l1 {
            to {
                clip-path: inset(0 -34% 0 0);
            }
        }


        @media (max-width: 1199.98px) {
            .profile-hero {
                gap: 80px;
            }

            .details-grid {
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

            .details-grid {
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

            .details-grid {
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
                <div class="details-card">
                    <div class="details-header">
                        <div>
                            <div class="details-title">Profile Details</div>
                            <div class="details-subtitle">
                                Personal, passport & education information linked to your RSK Air Travels account.
                            </div>
                        </div>
                    </div>

                    <div class="details-grid">

                        <div class="detail-item">
                            <div class="detail-label">Name</div>
                            <div class="detail-value {{ $userDetails->users->name ? '' : 'Not updated' }}">
                                {{ $userDetails->users->name ? $userDetails->users->name : 'Not updated' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Username</div>
                            <div class="detail-value {{ $userDetails->users->username ? '' : 'Not updated' }}">
                                {{ $userDetails->users->username ? $userDetails->users->username : 'Not updated' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Mobile</div>
                            <div class="detail-value {{ $userDetails->users->mobile ? '' : 'Not updated' }}">
                                @if ($userDetails->users->country_code)
                                    +{{ $userDetails->users->country_code }} {{ $userDetails->users->mobile }}
                                @else
                                    {{ $userDetails->users->mobile }}
                                @endif
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Email</div>
                            <div class="detail-value {{ $userDetails->users->email ? '' : 'Not updated' }}">
                                {{ $userDetails->users->email ? $userDetails->users->email : 'Not updated' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Date of Birth</div>
                            <div class="detail-value {{ $userDetails->dob ? '' : 'Not updated' }}">
                                {{ $userDetails->dob ? \Carbon\Carbon::parse($userDetails->dob)->format('d-m-Y') : 'Not updated' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Age</div>
                            <div class="detail-value {{ $userDetails->age ? '' : 'Not updated' }}">
                                {{ $userDetails->age ? $userDetails->age . ' years' : 'Not updated' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Gender</div>
                            <div class="detail-value {{ $userDetails->gender ? '' : 'Not updated' }}">
                                {{ $userDetails->gender ? $userDetails->gender : 'Not updated' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Current Country</div>
                            <div class="detail-value {{ $userDetails->country->name ? '' : 'Not updated' }}">
                                {{ $userDetails->country->name ? $userDetails->country->name : 'Not updated' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Passport Number</div>
                            <div class="detail-value {{ $userDetails->passport_no ? '' : 'Not updated' }}">
                                {{ $userDetails->passport_no ? $userDetails->passport_no : 'Not updated' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Job Category</div>
                            <div class="detail-value {{ $userDetails->jobcategory->name ? '' : 'Not updated' }}">
                                {{ $userDetails->jobcategory->name ? $userDetails->jobcategory->name : 'Not updated' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Education</div>
                            <div class="detail-value {{ $userDetails->education->name ? '' : 'Not updated' }}">
                                {{ $userDetails->education->name ? $userDetails->education->name : 'Not updated' }}
                            </div>
                        </div>

                        @if (!empty($userDetails->subeducation) && !empty($userDetails->subeducation->name))
                            <div class="detail-item">
                                <div class="detail-label">Sub Education</div>
                                <div class="detail-value">
                                    {{ $userDetails->subeducation->name }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
