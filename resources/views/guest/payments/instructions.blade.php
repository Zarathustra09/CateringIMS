@extends('layouts.guest')

                                            @section('content')
                                                <div class="container my-5">
                                                    <div class="row justify-content-center">
                                                        <div class="col-md-8">
                                                            <div class="card shadow-lg border-0 rounded-3">
                                                                <div class="card-header text-center py-3" style="background-color: #ce1212; color: white;">
                                                                    <h2 class="mb-0 fw-bold">Payment Instructions</h2>
                                                                </div>
                                                                <div class="card-body p-4">
                                                                    <div class="alert alert-warning mb-4">
                                                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                                                        <strong>Testing Mode:</strong> Your payment will be automatically marked as "paid" when you leave this page.
                                                                    </div>

                                                                    <div class="text-center mb-4">
                                                                        <div class="alert alert-success">
                                                                            <h4 class="alert-heading">Your reservation has been created!</h4>
                                                                            <p>Please complete your payment to confirm your reservation.</p>
                                                                        </div>
                                                                    </div>

                                                                    <div class="card bg-light mb-4">
                                                                        <div class="card-body">
                                                                            <div class="d-flex justify-content-between mb-2">
                                                                                <span class="fw-bold">Reference Number:</span>
                                                                                <span class="font-monospace">{{ $referenceNumber }}</span>
                                                                            </div>
                                                                            <div class="d-flex justify-content-between mb-2">
                                                                                <span class="fw-bold">Amount to Pay:</span>
                                                                                <span>₱{{ number_format($amountToPay, 2) }}</span>
                                                                            </div>
                                                                            <div class="d-flex justify-content-between mb-2">
                                                                                <span class="fw-bold">Payment Method:</span>
                                                                                <span>{{ ucfirst($paymentMethod) }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-4">
                                                                        <h4 class="fw-bold mb-3">How to Pay</h4>

                                                                        @if($paymentMethod === 'gcash')
                                                                            <div class="card mb-3">
                                                                                <div class="card-body">
                                                                                    <h5 class="card-title">GCash Payment Instructions</h5>
                                                                                    <ol class="mb-0">
                                                                                        <li>Open your GCash app</li>
                                                                                        <li>Tap on "Send Money"</li>
                                                                                        <li>Select "Send to GCash Account"</li>
                                                                                        <li>Enter mobile number: <strong>09123456789</strong></li>
                                                                                        <li>Enter the amount: <strong>₱{{ number_format($amountToPay, 2) }}</strong></li>
                                                                                        <li>In the message field, enter your reference number: <strong>{{ $referenceNumber }}</strong></li>
                                                                                        <li>Review details and confirm payment</li>
                                                                                        <li>Take a screenshot of your successful payment</li>
                                                                                        <li>Email the screenshot to <a href="mailto:payments@example.com">payments@example.com</a> with your reference number</li>
                                                                                    </ol>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($paymentMethod === 'paymaya')
                                                                            <div class="card mb-3">
                                                                                <div class="card-body">
                                                                                    <h5 class="card-title">PayMaya Payment Instructions</h5>
                                                                                    <ol class="mb-0">
                                                                                        <li>Open your PayMaya app</li>
                                                                                        <li>Tap on "Send Money"</li>
                                                                                        <li>Enter mobile number: <strong>09123456789</strong></li>
                                                                                        <li>Enter the amount: <strong>₱{{ number_format($amountToPay, 2) }}</strong></li>
                                                                                        <li>In the message field, enter your reference number: <strong>{{ $referenceNumber }}</strong></li>
                                                                                        <li>Review details and confirm payment</li>
                                                                                        <li>Take a screenshot of your successful payment</li>
                                                                                        <li>Email the screenshot to <a href="mailto:payments@example.com">payments@example.com</a> with your reference number</li>
                                                                                    </ol>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                    <div class="alert alert-info">
                                                                        <i class="fas fa-info-circle me-2"></i>
                                                                        Your reservation will be confirmed once we verify your payment.
                                                                    </div>

                                                                    <div class="text-center mt-4">
                                                                        <a href="{{ route('payment.index') }}" class="btn btn-lg btn-danger px-5" style="background-color: #ce1212;">
                                                                            View My Reservations
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        // Add event listener for page unload
                                                        window.addEventListener('beforeunload', function() {
                                                            // Make a background fetch request to mark payment as paid
                                                            const referenceNumber = '{{ $referenceNumber }}';
                                                            fetch('{{ route("payment.testing.mark-as-paid") }}', {
                                                                method: 'POST',
                                                                headers: {
                                                                    'Content-Type': 'application/json',
                                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                                    'Accept': 'application/json'
                                                                },
                                                                body: JSON.stringify({
                                                                    reference_number: referenceNumber
                                                                }),
                                                                // Use keepalive to ensure the request completes even if the page is unloaded
                                                                keepalive: true
                                                            });
                                                        });
                                                    });
                                                </script>
                                            @endsection
