<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Redirecting to Payment</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="text-center">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            <p class="mt-3">
                <a href="{{ route('reservation.index') }}" class="btn btn-primary">Back to Reservation</a>
            </p>
        @else
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <h3 class="mt-3">Redirecting to Payment</h3>
            <p class="text-muted">Please wait while we redirect you to the payment page...</p>

            <form id="payment-form" action="{{ route('payment.checkout') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="total" value="{{ session('total') }}">
                <input type="hidden" name="service" value="{{ session('service_id') }}">
                <input type="hidden" name="description" value="{{ session('description') }}">
                <input type="hidden" name="payment_type" value="{{ session('payment_type') }}">
            </form>

            <script>
                // Automatically submit the payment form
                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById('payment-form').submit();
                });
            </script>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
