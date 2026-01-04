@extends('layouts.admin')

@section('page_title', 'Company Settings')
@section('page_breadcrumb', 'Settings / Company')

@section('content')
    <div class="card-panel">

        <div class="mb-4">
            <h5 class="mb-1 fw-bold">Company Settings</h5>
            <p class="mb-0 text-muted">
                Manage your company details used in invoices, emails, and legal documents.
            </p>
        </div>

        <form id="company_settings_form" enctype="multipart/form-data">

            <div class="p-4 mb-3 border rounded-3" style="background: rgba(255,255,255,.75)">
                <div class="mb-3 fw-semibold">Basic Information</div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Company Name&nbsp;<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="company_name"
                            value="{{ $companysettings['company_name'] ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Company Email&nbsp;<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="company_email"
                            value="{{ $companysettings['company_email'] ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Company Phone&nbsp;<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="company_phone"
                            value="{{ $companysettings['company_phone'] ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="p-4 mb-3 border rounded-3" style="background: rgba(255,255,255,.75)">
                <div class="mb-3 fw-semibold">Address</div>

                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Address&nbsp;<span class="text-danger">*</span></label>
                        <textarea class="form-control" name="company_address" rows="2">{{ $companysettings['company_address'] ?? '' }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">City&nbsp;<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="company_city"
                            value="{{ $companysettings['company_city'] ?? '' }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">State&nbsp;<span class="text-danger">*</span></label>
                        <select class="select2" name="company_state" readonly>
                            <option value="Tamil Nadu" selected>Tamil Nadu</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Pincode&nbsp;<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="company_pincode"
                            value="{{ $companysettings['company_pincode'] ?? '' }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Country&nbsp;<span class="text-danger">*</span></label>
                        <select class="select2" name="company_country" readonly>
                            <option value="India" selected>India</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="p-4 mb-4 border rounded-3" style="background: rgba(255,255,255,.75)">
                <div class="mb-3 fw-semibold">Company Logo&nbsp;<span class="text-danger">*</span></div>

                <div class="gap-4 d-flex align-items-center">
                    <img src="{{ asset($companysettings['company_logo'] ?? '') }}" alt="Logo" class="border rounded"
                        style="height:80px">
                    <input type="file" class="w-auto form-control" name="company_logo">
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="px-4 btn btn-primary-gradient">
                    <i class="fa fa-save me-1"></i> Update Company Settings
                </button>
            </div>

        </form>

    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            $('#company_settings_form').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('settings.company.update') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.status) {
                            Swal.fire('Success', res.message, 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Error', 'Update failed', 'error');
                        }
                    },
                    error: function(xhr) {

                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            Swal.fire('Validation Error', xhr.responseJSON.error, 'warning');
                            return;
                        }
                        if (xhr.status == 422 && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            let firstError = Object.values(errors)[0][0];

                            Swal.fire('Validation Error', firstError, 'warning');
                            return;
                        }
                        Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                    }

                });
            });

        });
    </script>
@endsection
