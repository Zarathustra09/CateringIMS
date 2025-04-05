<!-- resources/views/pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
                <th>Total Paid</th>
                <td>₱{{ number_format($payment->total, 2) }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($payment->status) }}</td>
            </tr>
            <tr>
                <th>Paid At</th>
                <td>{{ $payment->created_at->format('M d, Y h:i A') }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Powered by <span class="highlight">Jhulian's Catering Services</span></p>
            <p>For inquiries, contact us at <span class="highlight">jhulianscateringservices2003@gmail.com</span></p>
        </div>
    </div>
</body>
</html>
