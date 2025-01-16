@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Payroll</h1>
    <form action="{{ route('admin.payroll.update', $payroll->id) }}" method="POST">
        @csrf
        @method('PUT')  <!-- Use PUT method to update -->
        
        <div class="mb-3">
            <label for="user_id" class="form-label">Employee</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="" disabled>Select Employee</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $payroll->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="pay_period_id" class="form-label">Pay Period</label>
            <select name="pay_period_id" id="pay_period_id" class="form-control" required>
                <option value="" disabled>Select Pay Period</option>
                @foreach($payPeriods as $payPeriod)
                    <option value="{{ $payPeriod->id }}" {{ $payPeriod->id == $payroll->pay_period_id ? 'selected' : '' }}>{{ $payPeriod->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label for="gross_salary" class="form-label">Gross Salary</label>
            <input type="number" name="gross_salary" id="gross_salary" class="form-control" value="{{ $payroll->gross_salary }}" required>
        </div>

        <div class="mb-3">
            <label for="deductions" class="form-label">Deductions</label>
            <input type="number" name="deductions" id="deductions" class="form-control" value="{{ $payroll->deductions }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Payroll</button>
    </form>
</div>
@endsection
