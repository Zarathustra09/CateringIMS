@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Payroll Details</h1>

    <div class="mb-3">
        <strong>Employee:</strong> {{ $payroll->user->name }}
    </div>
    <div class="mb-3">
        <strong>Paid At:</strong> {{ $payroll->reservation->name }}
    </div>
    <div class="mb-3">
        <strong>Pay Period:</strong> {{ $payroll->payPeriod->name }}
    </div>
    <div class="mb-3">
        <strong>Gross Salary:</strong> {{ $payroll->gross_salary }}
    </div>
    <div class="mb-3">
        <strong>Deductions:</strong> {{ $payroll->deductions }}
    </div>
    <div class="mb-3">
        <strong>Net Salary:</strong> {{ $payroll->net_salary }}
    </div>
    <div class="mb-3">
        <strong>Paid At:</strong> {{ $payroll->paid_at }}
    </div>
    

    <a href="{{ route('admin.payroll.index') }}" class="btn btn-primary">Back to Payroll List</a>
</div>
@endsection
