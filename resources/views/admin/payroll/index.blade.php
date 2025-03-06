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
                            
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#payrollTable').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                ordering: true,
                columnDefs: [
                    { orderable: false, targets: 7 }
                ]
            });
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
                customClass: {
                    popup: 'my-custom-popup-class',
                    title: 'my-custom-title-class',
                    confirmButton: 'my-custom-confirm-button-class',
                    cancelButton: 'my-custom-cancel-button-class'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/payroll/' + payrollId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: response.success,
                                icon: 'success',
                                customClass: {
                                    popup: 'my-custom-popup-class',
                                    title: 'my-custom-title-class',
                                    confirmButton: 'my-custom-confirm-button-class'
                                }
                            }).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        }

        function editPayroll(payrollId) {
    $.get(`/admin/payroll/${payrollId}`, function (payroll) {
        Swal.fire({
            title: 'Edit Payroll',
            html: `
                <p>Employee: ${payroll.employee_name}</p>
                <p>Pay Period: ${payroll.pay_period}</p>
                <p>Salary: ${payroll.salary}</p>
                <input id="deductions" class="swal2-input" type="number" value="${payroll.deductions}" placeholder="Deductions">
                <input id="net_salary" class="swal2-input" type="number" value="${payroll.net_salary}" placeholder="Net Salary">
            `,  
            showCancelButton: true,
            confirmButtonText: 'Update',
            preConfirm: () => {
                return {
                    deductions: parseFloat(document.getElementById('deductions').value) || 0,
                    net_salary: parseFloat(document.getElementById('net_salary').value) || 0
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/payroll/${payrollId}`,
                    type: 'PATCH', // Use PATCH for partial updates
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), // Get CSRF token from meta tag
                        deductions: result.value.deductions,
                        net_salary: result.value.net_salary
                    },
                    success: function (response) {
                        Swal.fire('Updated!', response.success, 'success').then(() => location.reload());
                    },
                    error: function (xhr) {
                        Swal.fire('Error!', xhr.responseJSON.message || 'Failed to update payroll.', 'error');
                    }
                });
            }
        });
    }).fail(function () {
        Swal.fire('Error!', 'Failed to fetch payroll details.', 'error');
    });
}



    </script>
@endpush
