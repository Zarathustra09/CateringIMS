@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Payroll</h1>
    <form action="{{ route('admin.payroll.update', $payroll->id) }}" method="POST">
        @csrf
        @method('PUT')  <!-- Use PUT method to update -->

        <div class="mb-3">
            <label for="user_id" class="form-label">Employee</label>
            <select name="user_id" id="user_id" class="form-control" required disabled>
                <option value="" disabled>Select Employee</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $payroll->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            <input type="hidden" name="user_id" value="{{ $payroll->user_id }}">
        </div>

        <div class="mb-3">
            <label for="pay_period_id" class="form-label">Pay Period</label>
            <select name="pay_period_id" id="pay_period_id" class="form-control" required disabled>
                <option value="" disabled>Select Pay Period</option>
                @foreach($payPeriods as $payPeriod)
                    <option value="{{ $payPeriod->id }}" {{ $payPeriod->id == $payroll->pay_period_id ? 'selected' : '' }}>{{ $payPeriod->name }}</option>
                @endforeach
            </select>
            <input type="hidden" name="pay_period_id" value="{{ $payroll->pay_period_id }}">
        </div>

        <div class="mb-3">
            <label for="gross_salary" class="form-label">Gross Salary</label>
            <input type="number" name="gross_salary" id="gross_salary" class="form-control" value="{{ $payroll->gross_salary }}" required step="0.01">
        </div>

        <div class="mb-3">
            <label for="sss_deductions" class="form-label">SSS Deductions</label>
            <input type="number" name="sss_deductions" id="sss_deductions" class="form-control" value="{{ $payroll->sss_deductions }}" step="0.01">
        </div>

        <div class="mb-3">
            <label for="pag_ibig_deductions" class="form-label">Pag-IBIG Deductions</label>
            <input type="number" name="pag_ibig_deductions" id="pag_ibig_deductions" class="form-control" value="{{ $payroll->pag_ibig_deductions }}" step="0.01">
        </div>

        <div class="mb-3">
            <label for="philhealth_deductions" class="form-label">PhilHealth Deductions</label>
            <input type="number" name="philhealth_deductions" id="philhealth_deductions" class="form-control" value="{{ $payroll->philhealth_deductions }}" step="0.01">
        </div>

        <div class="mb-3">
            <label for="tax" class="form-label">Tax</label>
            <input type="number" name="tax" id="tax" class="form-control" value="{{ $payroll->tax }}" step="0.01">
        </div>

        <div class="mb-3">
            <label for="net_salary" class="form-label">Net Salary</label>
            <input type="number" name="net_salary" id="net_salary" class="form-control" value="{{ $payroll->net_salary }}" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Update Payroll</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Calculate net salary whenever deduction values change
    const grossSalary = document.getElementById('gross_salary');
    const sssDeductions = document.getElementById('sss_deductions');
    const pagIbigDeductions = document.getElementById('pag_ibig_deductions');
    const philhealthDeductions = document.getElementById('philhealth_deductions');
    const tax = document.getElementById('tax');
    const netSalary = document.getElementById('net_salary');

    function calculateNetSalary() {
        const gross = parseFloat(grossSalary.value) || 0;
        const sss = parseFloat(sssDeductions.value) || 0;
        const pagIbig = parseFloat(pagIbigDeductions.value) || 0;
        const philhealth = parseFloat(philhealthDeductions.value) || 0;
        const taxAmount = parseFloat(tax.value) || 0;

        const totalDeductions = sss + pagIbig + philhealth + taxAmount;
        const net = gross - totalDeductions;

        netSalary.value = net.toFixed(2);
    }

    grossSalary.addEventListener('input', calculateNetSalary);
    sssDeductions.addEventListener('input', calculateNetSalary);
    pagIbigDeductions.addEventListener('input', calculateNetSalary);
    philhealthDeductions.addEventListener('input', calculateNetSalary);
    tax.addEventListener('input', calculateNetSalary);

    // Calculate initially
    calculateNetSalary();
});
</script>
@endpush
