@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Payroll</h4>
                <a href="{{ route('admin.payroll.create') }}" class="btn btn-primary">Add Payroll</a>
            </div>

            <div class="card-body">
                {{-- Pending Payroll Cards --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card border-primary shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title text-primary">Bi-Monthly Payrolls</h5>
                                <p class="display-6 fw-bold">{{ $pendingBiMonthly }}</p>
                                <p class="text-muted">Pending payrolls this month</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-success shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title text-success">Monthly Payrolls</h5>
                                <p class="display-6 fw-bold">{{ $pendingMonthly }}</p>
                                <p class="text-muted">Pending payrolls this month</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-danger shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title text-danger">Contractual Payrolls</h5>
                                <p class="display-6 fw-bold">{{ $pendingContractual }}</p>
                                <p class="text-muted">Pending reservations</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payroll Table --}}
                <table id="payrollTable" class="table table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Employee</th>
                            <th>Pay Period</th>
                            <th>Reservation</th>
                            <th>Salary</th>
                            <th>Deductions</th>
                            <th>Net Salary</th>
                            <th>Paid At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payrolls as $payroll)
                            <tr>
                                <td>{{ $payroll->id }}</td>
                                <td>{{ $payroll->user->name }}</td>
                                <td>{{ $payroll->payPeriod->name }}</td>
                                <td>{{ optional($payroll->reservation)->event_name ?? 'N/A' }}</td>
                                <td>
                                    @if ($payroll->user->employeeDetail)
                                        {{ number_format($payroll->user->employeeDetail->salary, 2) }}
                                    @else
                                        Not Available
                                    @endif
                                </td>
                                <td>{{ number_format($payroll->deductions, 2) }}</td>
                                <td>{{ number_format($payroll->net_salary, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($payroll->paid_at)->setTimezone('Asia/Manila')->format('F d, Y h:i A') }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editPayroll({{ $payroll->id }})">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deletePayroll({{ $payroll->id }})">Delete</button>
                                    <a href="{{ route('admin.payroll.pdf', $payroll->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-file-pdf"></i> Download PDF
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Employees Without Payroll Table
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="fw-bold">Employees Without Payroll</h5>
                </div>
                <div class="card-body">
                    <table id="noPayrollTable" class="table table-hover table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Pay Period</th>
                                <th>Salary</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employeesWithoutPayrollByType as $payPeriod => $employees)
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->id }}</td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $payPeriod }}</td>
                                        <td>
                                            {{ optional($employee->employeeDetail)->salary ? number_format($employee->employeeDetail->salary, 2) : 'N/A' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.payroll.create', ['employee_id' => $employee->id, 'pay_period' => $payPeriod]) }}" 
                                               class="btn btn-primary btn-sm">
                                                Add Payroll
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> --}}

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#payrollTable').DataTable();
            $('#noPayrollTable').DataTable();
        });

                function deletePayroll(payrollId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/payroll/${payrollId}`,
                        type: 'POST',  // Laravel requires PATCH/DELETE via POST
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: response.success || "Payroll deleted successfully!",
                                icon: 'success'
                            }).then(() => {
                                location.reload();  // Refresh the page after deletion
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'Failed to delete payroll.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }



        function editPayroll(payrollId) {
    $.get(`/admin/payroll/${payrollId}`)
        .done(function (payroll) {
            Swal.fire({
                title: 'Edit Payroll',
                html: `
                    <div style="text-align: left;">
                        <label><strong>Employee:</strong></label>
                        <p>${payroll.employee_name}</p>

                        <label><strong>Pay Period:</strong></label>
                        <p>${payroll.pay_period}</p>

                        <label><strong>Gross Salary:</strong></label>
                        <p id="grossSalary">${payroll.salary}</p>

                        <label for="deductions"><strong>Deductions:</strong></label>
                        <input id="deductions" class="swal2-input" type="number" value="${payroll.deductions}" placeholder="Deductions">

                        <label><strong>Net Salary:</strong></label>
                        <p id="net_salary">${payroll.net_salary}</p>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Update',
                preConfirm: () => {
                    return {
                        deductions: parseFloat(document.getElementById('deductions').value) || 0
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/payroll/${payrollId}`,
                        type: 'POST',  // Laravel does not support PUT/PATCH directly
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            _method: 'PUT',  // Simulate PUT request
                            deductions: result.value.deductions
                        },
                        success: function (response) {
                            Swal.fire('Updated!', response.success, 'success').then(() => location.reload());
                        },
                        error: function (xhr) {
                            Swal.fire('Error!', xhr.responseJSON?.message || 'Failed to update payroll.', 'error');
                        }
                    });
                }
            });
        })
        .fail(function () {
            Swal.fire('Error!', 'Failed to fetch payroll details.', 'error');
        });
}



    </script>
@endpush

