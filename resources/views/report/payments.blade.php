<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
        }
        .container {
            width: 100%;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin-bottom: 5px;
        }
        .summary {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
        }
        .total-row {
            font-weight: bold;
        }
        .currency::before {
            content: "PHP ";
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Payment Report</h1>
        <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
    </div>

    <div class="summary">
        <p><strong>Total Payments:</strong> {{ count($payments) }}</p>
        <p><strong>Total Amount:</strong> PHP {{ number_format($payments->sum('total'), 2) }}</p>
    </div>

    <table>
        <thead>
        <tr>
            <th>Date</th>
            <th>User</th>
            <th>Reservation</th>
            <th>Status</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->created_at->format('Y-m-d H:i:s') }}</td>
                <td>{{ $payment->user->name ?? 'N/A' }}</td>
                <td>{{ $payment->reservation->id ?? 'N/A' }}</td>
                <td>{{ $payment->status }}</td>
                <td>PHP {{ number_format($payment->total, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr class="total-row">
            <td colspan="4">Total</td>
            <td>PHP {{ number_format($payments->sum('total'), 2) }}</td>
        </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>This is an automatically generated report. Please contact administration for any queries.</p>
    </div>
</div>
</body>
</html>
