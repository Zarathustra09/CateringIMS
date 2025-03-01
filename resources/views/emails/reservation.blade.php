<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }
        .logo {
            max-width: 200px;
            height: auto;
        }
        h1 {
            color: #2c3e50;
            margin-top: 20px;
            font-size: 24px;
        }
        .details {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        .details-item {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .details-item:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #2c3e50;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            color: #7f8c8d;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="{{ $message->embed($logoPath) }}" alt="Company Logo" class="logo">
        <h1>Reservation Confirmation</h1>
    </div>

    <p>Dear {{ $details['name'] }},</p>

    <p>Thank you for your reservation. We're delighted to confirm your booking with us.</p>

    <div class="details">
        <div class="details-item">
            <span class="label">Event Name:</span> {{ $details['event_name'] }}
        </div>
        <div class="details-item">
            <span class="label">Service:</span> {{ $details['service'] }}
        </div>
        <div class="details-item">
            <span class="label">Total:</span> {{ $details['total'] }}
        </div>
        <div class="details-item">
            <span class="label">Description:</span> {{ $details['description'] }}
        </div>
    </div>

    <p>If you have any questions or need to make changes, please don't hesitate to contact us.</p>

    <div style="text-align: center;">
        <a href="#" class="button" style="color: white">View Reservation</a>
    </div>

    <div class="footer">
        <p>We look forward to serving you!</p>
        <p>&copy; {{ date('Y') }} {{env('APP_NAME')}}. All rights reserved.</p>
    </div>
</div>
</body>
</html>
