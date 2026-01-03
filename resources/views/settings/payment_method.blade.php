@extends('layouts.admin')

@section('page_title', 'Payment Methods')
@section('page_breadcrumb', 'Settings / Payment Methods')

@section('content')
    <div class="card-panel">

        <div class="mb-4">
            <h5 class="mb-1 fw-bold">Payment Methods</h5>
            <p class="mb-0 text-muted">Enable or disable payment options available at checkout.</p>
        </div>

        {{-- ONLINE PAYMENT --}}
        <div class="p-4 mb-3 border rounded-3 d-flex align-items-center justify-content-between"
            style="background: rgba(255,255,255,.75)">
            <div class="gap-3 d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                    style="width:44px;height:44px;background:linear-gradient(135deg,#2563eb,#60a5fa);color:#fff;">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <div>
                    <div class="fw-semibold">Online Payment</div>
                    <div class="text-muted small">Accept UPI, Cards, Net Banking</div>
                </div>
            </div>

            <div class="gap-3 d-flex align-items-center">
                <span id="badge_payment_online"
                    class="badge {{ $settings['payment_online'] ?? 0 ? 'bg-success' : 'bg-secondary' }}">
                    {{ $settings['payment_online'] ?? 0 ? 'Enabled' : 'Disabled' }}
                </span>

                <div class="mb-0 form-check form-switch">
                    <input class="form-check-input payment-toggle" type="checkbox" id="payment_online"
                        data-key="payment_online" {{ $settings['payment_online'] ?? 0 ? 'checked' : '' }}>
                </div>
            </div>
        </div>

        {{-- CASH ON DELIVERY --}}
        <div class="p-4 mb-4 border rounded-3 d-flex align-items-center justify-content-between"
            style="background: rgba(255,255,255,.75)">
            <div class="gap-3 d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                    style="width:44px;height:44px;background:linear-gradient(135deg,#16a34a,#4ade80);color:#fff;">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
                <div>
                    <div class="fw-semibold">Cash on Delivery</div>
                    <div class="text-muted small">Pay at the time of delivery</div>
                </div>
            </div>

            <div class="gap-3 d-flex align-items-center">
                <span id="badge_payment_cod"
                    class="badge {{ $settings['payment_cod'] ?? 0 ? 'bg-success' : 'bg-secondary' }}">
                    {{ $settings['payment_cod'] ?? 0 ? 'Enabled' : 'Disabled' }}
                </span>

                <div class="mb-0 form-check form-switch">
                    <input class="form-check-input payment-toggle" type="checkbox" id="payment_cod" data-key="payment_cod"
                        {{ $settings['payment_cod'] ?? 0 ? 'checked' : '' }}>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('.payment-toggle').on('change', function() {

                let checkbox = $(this);
                let key = checkbox.data('key');
                let value = checkbox.is(':checked') ? 1 : 0;

                let badge = $('#badge_' + key);
                if (value == 1) {
                    badge.removeClass('bg-secondary')
                        .addClass('bg-success')
                        .text('Enabled');
                } else {
                    badge.removeClass('bg-success')
                        .addClass('bg-secondary')
                        .text('Disabled');
                }

                $.ajax({
                    url: "{{ route('settings.payment.methods.update') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        key: key,
                        value: value
                    },
                    success: function(res) {
                        if (res.status) {
                            Swal.fire('Success', 'Updated Successfully', 'success');
                        } else {
                            Swal.fire('Error', 'Unable to Update', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Something went wrong', 'error');
                        checkbox.prop('checked', !value);
                        let badge = $('#badge_' + key);
                        if (value == 1) {
                            badge.removeClass('bg-success')
                                .addClass('bg-secondary')
                                .text('Disabled');
                        } else {
                            badge.removeClass('bg-secondary')
                                .addClass('bg-success')
                                .text('Enabled');
                        }
                    }

                });
            });
        });
    </script>
@endsection
