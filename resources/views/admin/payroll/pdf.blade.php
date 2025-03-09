<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 100%; padding: 20px; border: 1px solid #000; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { width: 100px; display: block; margin: 0 auto; }
        .title { font-size: 18px; font-weight: bold; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('landingpage/assets/img/logoname.jpg') }}" alt="Company Logo" class="logo">
            <p class="title">Official Payslip</p>
        </div>

        <table>
            <tr>
                <th>Employee Name</th>
                <td>{{ $payroll->user->name }}</td>
            </tr>
            <tr>
                <th>Position</th>
                <td>{{ $payroll->user->employeeDetail->position ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Pay Period</th>
                <td>{{ $payroll->payPeriod->name }}</td>
            </tr>
            <tr>
                <th>Reservation</th>
                <td>{{ optional($payroll->reservation)->event_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Basic Salary</th>
                <td>{{ number_format($payroll->user->employeeDetail->salary ?? 0, 2) }}</td>
            </tr>
            <tr>
                <th>Deductions</th>
                <td>{{ number_format($payroll->deductions, 2) }}</td>
            </tr>
            <tr>
                <th>Net Salary</th>
                <td><strong>{{ number_format($payroll->net_salary, 2) }}</strong></td>
            </tr>
            <tr>
                <th>Payment Date</th>
                <td>{{ \Carbon\Carbon::parse($payroll->paid_at)->setTimezone('Asia/Manila')->format('F d, Y h:i A') }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Thank you for your hard work! If you have any concerns, please contact HR.</p>
            <p>Time Generated: {{ now()->setTimezone('Asia/Manila')->format('F d, Y h:i A') }}</p>
        </div>
    </div>
</body>
</html>
