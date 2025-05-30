@extends('layouts.staff.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Staff Details</h4>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">My Details</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Employee ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $user->employee_id }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Phone Number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $user->phone_number }}" readonly>
                    </div>
                </div>
                @if ($user->employeeDetail)
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Position</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $user->employeeDetail->position }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Department</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $user->employeeDetail->department }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Salary</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $user->employeeDetail->salary }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Hired At</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $user->employeeDetail->hired_at }}" readonly>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

