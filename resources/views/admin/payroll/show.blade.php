@extends('layouts.app')

        @section('content')
        <div class="container">
            <h1>Payroll Details</h1>

            <div class="mb-3">
                <strong>Employee:</strong> {{ $payroll->user->name }}
            </div>
            <div class="mb-3">
                <strong>Paid At:</strong> {{ $payroll->reservation->name ?? 'N/A' }}
            </div>
            <div class="mb-3">
                <strong>Pay Period:</strong> {{ $payroll->payPeriod->name }}
            </div>
            <div class="mb-3">
                <strong>Gross Salary:</strong> {{ $payroll->gross_salary }}
            </div>
            <div class="mb-3">
                <strong>SSS Deductions:</strong> {{ $payroll->sss_deductions }}
            </div>
            <div class="mb-3">
                <strong>Pag-IBIG Deductions:</strong> {{ $payroll->pag_ibig_deductions }}
            </div>
            <div class="mb-3">
                <strong>PhilHealth Deductions:</strong> {{ $payroll->philhealth_deductions }}
            </div>
            <div class="mb-3">
                <strong>Tax:</strong> {{ $payroll->tax }}
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
