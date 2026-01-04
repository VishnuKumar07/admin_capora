@extends('layouts.admin')

@section('page_title', 'Tax (GST)')
@section('page_breadcrumb', 'Settings / Tax')

@section('content')
    <div class="card-panel">

        <div class="mb-4">
            <h5 class="mb-1 fw-bold">Tax (GST) Settings</h5>
            <p class="mb-0 text-muted">
                Configure GST rules applied to product prices and checkout.
            </p>
        </div>

        <div class="p-4 mb-3 border rounded-3 d-flex align-items-center justify-content-between"
            style="background: rgba(255,255,255,.75)">
            <div class="gap-3 d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                    style="width:44px;height:44px;background:linear-gradient(135deg,#7c3aed,#c084fc);color:#fff;">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div>
                    <div class="fw-semibold">Enable GST</div>
                    <div class="text-muted small">
                        Apply Goods and Services Tax to orders
                    </div>
                </div>
            </div>

            <div class="gap-3 d-flex align-items-center">
                <span id="badge_gst_enabled"
                    class="badge {{ ($taxsettings['gst_enabled'] ?? 0) == 1 ? 'bg-success' : 'bg-secondary' }}">
                    {{ ($taxsettings['gst_enabled'] ?? 0) == 1 ? 'Enabled' : 'Disabled' }}
                </span>

                <div class="mb-0 form-check form-switch">
                    <input class="form-check-input tax-toggle" type="checkbox" id="gst_enabled" data-key="gst_enabled"
                        {{ ($taxsettings['gst_enabled'] ?? 0) == 1 ? 'checked' : '' }}>
                </div>
            </div>
        </div>
        <div class="gst-dependent">
            <div class="p-4 mb-3 border rounded-3" style="background: rgba(255,255,255,.75)">
                <div class="mb-2 fw-semibold">GST Type</div>

                <div class="gap-4 d-flex">
                    <div class="form-check">
                        <input class="form-check-input gst-type" type="radio" name="gst_type" id="gst_type_percentage"
                            value="percentage"
                            {{ ($taxsettings['gst_type'] ?? 'percentage') == 'percentage' ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="gst_type_percentage">
                            Percentage (%)
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input gst-type" type="radio" name="gst_type" id="gst_type_flat"
                            value="flat" {{ ($taxsettings['gst_type'] ?? '') == 'flat' ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="gst_type_flat">
                            Flat Amount (₹)
                        </label>
                    </div>
                </div>
            </div>

            <div class="p-4 mb-3 border rounded-3" style="background: rgba(255,255,255,.75)">
                <div class="mb-2 fw-semibold">GST Value</div>

                <input type="number" class="form-control" id="gst_value" value="{{ $taxsettings['gst_value'] ?? '' }}"
                    placeholder="Enter GST value (e.g. 18 or 50)">
                <small id="gst_value_hint" class="text-muted">
                    Percentage (%) or flat amount based on selected GST type
                </small>

            </div>

            <div class="p-4 border rounded-3" style="background: rgba(255,255,255,.75)">
                <div class="mb-2 fw-semibold">GST Number (GSTIN)</div>

                <input type="text" class="form-control" id="gst_number" value="{{ $taxsettings['gst_number'] ?? '' }}"
                    placeholder="Enter GSTIN">
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            <button type="button" id="update_gst_settings" class="px-4 btn btn-primary-gradient">
                <i class="fa fa-save me-1"></i> Update GST Settings
            </button>
        </div>

    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            function updateGstValueHint() {
                let gstType = $('input[name="gst_type"]:checked').val();

                if (gstType == 'percentage') {
                    $('#gst_value_hint').text('Enter value in Percentage (%)');
                } else if (gstType == 'flat') {
                    $('#gst_value_hint').text('Enter amount in ₹');
                }
            }

            updateGstValueHint();

            $('input[name="gst_type"]').on('change', function() {
                updateGstValueHint();
            });

            function toggleGSTDependent() {
                if ($('#gst_enabled').is(':checked')) {
                    $('.gst-dependent').slideDown();
                } else {
                    $('.gst-dependent').slideUp();
                }
            }

            toggleGSTDependent();

            $('#gst_enabled').on('change', function() {

                let enabled = $(this).is(':checked') ? 1 : 0;
                let badge = $('#badge_gst_enabled');

                if (enabled == 1) {
                    badge
                        .removeClass('bg-secondary')
                        .addClass('bg-success')
                        .text('Enabled');
                } else {
                    badge
                        .removeClass('bg-success')
                        .addClass('bg-secondary')
                        .text('Disabled');
                }

                toggleGSTDependent();
            });


            $('#update_gst_settings').on('click', function() {

                let gstEnabled = $('#gst_enabled').is(':checked') ? 1 : 0;
                let gstType = $('input[name="gst_type"]:checked').val();
                let gstValue = $('#gst_value').val();
                let gstNumber = $('#gst_number').val();

                if (gstEnabled == 1) {
                    if (!gstType || gstValue == '') {
                        Swal.fire('Validation Error', 'GST Type and GST Value are required', 'warning');
                        return;
                    }
                }

                $.ajax({
                    url: "{{ route('settings.tax.details.update') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        gst_enabled: gstEnabled,
                        gst_type: gstType,
                        gst_value: gstValue,
                        gst_number: gstNumber
                    },
                    success: function(res) {
                        if (res.status) {
                            Swal.fire('Success', res.message, 'success');
                        } else {
                            Swal.fire('Error', 'Failed to update GST settings', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Something went wrong', 'error');
                    }
                });

            });



        });
    </script>
@endsection
