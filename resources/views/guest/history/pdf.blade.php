<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Payment Receipt</title>
            <style>
                @font-face {
                    font-family: 'DejaVu Sans';
                    src: url('{{ public_path('fonts/DejaVuSans.ttf') }}');
                    font-weight: normal;
                    font-style: normal;
                }

                body {
                    font-family: 'DejaVu Sans', sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f9f9f9;
                }

                .container {
                    width: 80%;
                    margin: 0 auto;
                    padding: 30px;
                    background-color: white;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    border-radius: 8px;
                }

                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }

                .header h1 {
                    font-size: 36px;
                    color: #333;
                    margin-bottom: 10px;
                }

                .header p {
                    font-size: 16px;
                    color: #777;
                }

                .table {
                    width: 100%;
                    margin-top: 20px;
                    border-collapse: collapse;
                }

                .table th, .table td {
                    padding: 10px;
                    text-align: left;
                    border: 1px solid #ddd;
                }

                .table th {
                    background-color: #ce1212;
                    color: white;
                }

                .table tr:nth-child(even) {
                    background-color: #f9f9f9;
                }

                .table td {
                    color: #555;
                }

                .footer {
                    margin-top: 30px;
                    text-align: center;
                    font-size: 14px;
                    color: #777;
                }

                .footer p {
                    margin: 0;
                }

                .highlight {
                    font-weight: bold;
                    color: #ce1212;
                }

                .payment-type {
                    display: inline-block;
                    padding: 5px 10px;
                    border-radius: 4px;
                    font-weight: bold;
                    color: white;
                    background-color: #ce1212;
                }

                .balance-box {
                    margin-top: 20px;
                    border: 2px dashed #ce1212;
                    padding: 15px;
                    border-radius: 8px;
                }
            </style>
        </head>
        <body>
        <div class="container">
            <div class="header">
                <img src="{{ public_path('landingpage/assets/img/logoname.jpg') }}" alt="Company Logo" class="logo" style="max-width: 150px; height: auto; margin-bottom: 20px;">

                <h1>Payment Receipt</h1>
                <p>Thank you for your payment!</p>
            </div>

            <table class="table">
                <tr>
                    <th>Invoice ID</th>
                    <td>{{ $payment->external_id ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Payment Type</th>
                    <td>
                        <span class="payment-type">
                            {{ $payment->is_down_payment ? 'Down Payment (50%)' : 'Full Payment' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Amount Paid</th>
                    <td>PHP {{ number_format($payment->amount_paid, 2) }}</td>
                </tr>
                <tr>
                    <th>Total Price</th>
                    <td>PHP {{ number_format($payment->total, 2) }}</td>
                </tr>
                <tr>
                    <th>Payment Status</th>
                    <td class="highlight">{{ ucfirst($payment->status) }}</td>
                </tr>
                <tr>
                    <th>Payment Date</th>
                    <td>{{ $payment->created_at->format('F d, Y h:i A') }}</td>
                </tr>
            </table>

            @if($payment->is_down_payment)
                <div class="balance-box">
                    <h3 style="color: #ce1212; margin-top: 0;">Remaining Balance</h3>
                    <p style="font-size: 18px; font-weight: bold;">PHP {{ number_format($remaining_balance, 2) }}</p>
                    <p style="font-style: italic;">Please settle the remaining balance before your reservation date.</p>
                </div>
            @endif

            <div style="margin-top: 30px;">
                <h3>Reservation Details</h3>
                <table class="table">
                    <tr>
                        <th>Reservation ID</th>
                        <td>{{ $reservation->id }}</td>
                    </tr>
                    <tr>
                        <th>Event Name</th>
                        <td>{{ $reservation->event_name }}</td>
                    </tr>
                    <tr>
                        <th>Service</th>
                        <td>{{ $reservation->service->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Event Start</th>
                        <td>{{ \Carbon\Carbon::parse($reservation->start_date)->format('F d, Y h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Event End</th>
                        <td>{{ \Carbon\Carbon::parse($reservation->end_date)->format('F d, Y h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Reservation Status</th>
                        <td class="highlight">{{ ucfirst($reservation->status) }}</td>
                    </tr>
                </table>
            </div>

            <div class="footer">
                <p>For any questions or concerns, please contact us at support@example.com</p>
                <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
            </div>
        </div>
        </body>
        </html>
