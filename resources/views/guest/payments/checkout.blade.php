@extends('layouts.guest')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header text-center py-3" style="background-color: #ce1212; color: white;">
                    <h2 class="mb-0 fw-bold">Checkout</h2>
                </div>
                <div class="card-body p-4">
                    <!-- Order Summary -->
                    <div class="mb-4">
                        <h4 class="fw-bold mb-3">Order Summary</h4>
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>{{ $service->name }}</span>
                                    <span>₱{{ number_format($totalAmount, 2) }}</span>
                                </div>

                                @if($isDownPayment)
                                <div class="d-flex justify-content-between mb-2 text-muted">
                                    <span>Down Payment (50%)</span>
                                    <span>₱{{ number_format($amountToPay, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 text-muted">
                                    <span>Remaining Balance</span>
                                    <span>₱{{ number_format($totalAmount - $amountToPay, 2) }}</span>
                                </div>
                                @endif

                                <hr>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Amount to Pay</span>
                                    <span>₱{{ number_format($amountToPay, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <h4 class="fw-bold mb-3">Select Payment Method</h4>
                    @if(isset($isBalancePayment) && $isBalancePayment)
                        <form id="payment-form" action="{{ route('payment.balance.process', $reservationId) }}" method="POST">
                            @csrf
                            @else
                                <form id="payment-form" action="{{ route('payment.checkout.process') }}" method="POST">
                                    @csrf
                                    @endif

                        <div class="row g-3 mb-4">
                            <!-- Cash Option -->
                            <div class="col-md-4">
                                <div class="card h-100 payment-method-card">
                                    <div class="card-body d-flex flex-column align-items-center">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" required>
                                            <label class="form-check-label" for="cash">
                                                <i class="fas fa-money-bill-wave fa-3x mb-3" style="color: #2E8B57;"></i>
                                            </label>
                                        </div>
                                        <h5 class="card-title text-center">Cash</h5>
                                        <p class="card-text text-center text-muted small">Pay in person</p>
                                    </div>
                                </div>
                            </div>

                            <!-- GCash Option -->
                            <div class="col-md-4">
                                <div class="card h-100 payment-method-card">
                                    <div class="card-body d-flex flex-column align-items-center">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="payment_method" id="gcash" value="gcash" required>
                                            <label class="form-check-label" for="gcash">
                                                <img src="{{ asset('images/gcash-logo.png') }}" alt="GCash" style="height: 48px;" class="mb-3">
                                            </label>
                                        </div>
                                        <h5 class="card-title text-center">GCash</h5>
                                        <p class="card-text text-center text-muted small">Pay with GCash</p>
                                    </div>
                                </div>
                            </div>

                            <!-- PayMaya Option -->
                            <div class="col-md-4">
                                <div class="card h-100 payment-method-card">
                                    <div class="card-body d-flex flex-column align-items-center">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="payment_method" id="paymaya" value="paymaya" required>
                                            <label class="form-check-label" for="paymaya">
                                                <img src="{{ asset('images/paymaya-logo.png') }}" alt="PayMaya" style="height: 48px;" class="mb-3">
                                            </label>
                                        </div>
                                        <h5 class="card-title text-center">PayMaya</h5>
                                        <p class="card-text text-center text-muted small">Pay with PayMaya</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-lg btn-danger px-5" style="background-color: #ce1212;">
                                Proceed to Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .payment-method-card {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid #e9ecef;
    }

    .payment-method-card:hover {
        border-color: #ce1212;
        transform: translateY(-5px);
    }

    .form-check-input:checked ~ label img,
    .form-check-input:checked ~ label i {
        transform: scale(1.1);
    }

    .form-check-input:checked + label {
        color: #ce1212;
    }

    .payment-method-card .form-check {
        padding-left: 0;
    }

    .payment-method-card .form-check-input {
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentCards = document.querySelectorAll('.payment-method-card');

    paymentCards.forEach(card => {
        card.addEventListener('click', function() {
            // Find the radio input inside this card and check it
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;

            // Remove selected class from all cards
            paymentCards.forEach(c => c.style.borderColor = '#e9ecef');

            // Add selected class to clicked card
            this.style.borderColor = '#ce1212';
        });
    });
});
</script>
@endsection
