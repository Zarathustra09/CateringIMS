@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Employee Details</h4>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Employee Details</h5>
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
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Role</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $user->role_id == 0 ? 'Client' : ($user->role_id == 1 ? 'Employee' : 'Admin') }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        @if($user->employeeDetail)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Employee Additional Details</h5>
                    <button class="btn btn-outline-primary btn-sm" id="editEmployeeDetails">
                        <i class="menu-icon tf-icons bx bx-edit"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Position</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $user->employeeDetail->position }}" readonly id="position">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Department</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $user->employeeDetail->department }}" readonly id="department">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Salary</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $user->employeeDetail->salary }}" readonly id="salary">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Pay Period</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $user->employeeDetail->payPeriod->name }}" readonly id="pay_period">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Hired At</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $user->employeeDetail->hired_at }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')

    <script>
        document.getElementById('editEmployeeDetails').addEventListener('click', function() {
            const position = document.getElementById('position').value;
            const department = document.getElementById('department').value;
            const salary = document.getElementById('salary').value;
            const payPeriod = document.getElementById('pay_period').value;

            let payPeriodValue = 1; // Default to Monthly
            if (payPeriod.toLowerCase() === "bi-monthly") {
                payPeriodValue = 2;
            } else if (payPeriod.toLowerCase() === "contractual") {
                payPeriodValue = 3;
            }

            Swal.fire({
                title: 'Edit Employee Details',
                html: `
                    <input type="text" id="swal-position" class="swal2-input" value="${position}" placeholder="Position">
                    <input type="text" id="swal-department" class="swal2-input" value="${department}" placeholder="Department">
                    <input type="text" id="swal-salary" class="swal2-input" value="${salary}" placeholder="Salary">
                    <div style="margin-top: 20px;">
                        <select id="swal-pay-period" class="swal2-input" style="width: 60%; padding: 8px;">
                            <option value="1" ${payPeriodValue == 1 ? 'selected' : ''}>Monthly</option>
                            <option value="2" ${payPeriodValue == 2 ? 'selected' : ''}>Bi-Monthly</option>
                            <option value="3" ${payPeriodValue == 3 ? 'selected' : ''}>Contractual</option>
                        </select>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Save',
                preConfirm: () => {
                    return {
                        position: document.getElementById('swal-position').value,
                        department: document.getElementById('swal-department').value,
                        salary: document.getElementById('swal-salary').value,
                        payPeriod: document.getElementById('swal-pay-period').value
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const updatedDetails = result.value;

                    $.ajax({
                        url: "{{ route('employee.details.update', $user->id) }}",
                        type: "PUT",
                        data: {
                            _token: "{{ csrf_token() }}",
                            position: updatedDetails.position,
                            department: updatedDetails.department,
                            salary: updatedDetails.salary,
                            pay_period: updatedDetails.payPeriod
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Updated!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error', xhr.responseJSON?.message || 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        });
    </script>
    @endpush
@endsection
