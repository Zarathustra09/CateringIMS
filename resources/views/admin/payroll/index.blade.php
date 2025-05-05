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
                                            <th>Gross Salary</th>
                                            <th>SSS</th>
                                            <th>Pag-IBIG</th>
                                            <th>PhilHealth</th>
                                            <th>Tax</th>
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
                                                <td>{{ number_format($payroll->gross_salary, 2) }}</td>
                                                <td>{{ number_format($payroll->sss_deductions, 2) }}</td>
                                                <td>{{ number_format($payroll->pag_ibig_deductions, 2) }}</td>
                                                <td>{{ number_format($payroll->philhealth_deductions, 2) }}</td>
                                                <td>{{ number_format($payroll->tax, 2) }}</td>
                                                <td>{{ number_format($payroll->net_salary, 2) }}</td>
                                                <td>{{ \Carbon\Carbon::parse($payroll->paid_at)->setTimezone('Asia/Manila')->format('F d, Y h:i A') }}</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm" onclick="editPayroll({{ $payroll->id }})">Edit</button>
                                                    <button class="btn btn-danger btn-sm" onclick="deletePayroll({{ $payroll->id }})">Delete</button>
                                                    <a href="{{ route('admin.payroll.pdf', $payroll->id) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-file-pdf"></i> PDF
                                                    </a>
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
                            $('#payrollTable').DataTable();
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
                                        type: 'POST',
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
                                                location.reload();
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
                                     title: '<h4 class="text-primary">Edit Payroll Details</h4>',
                                     html: `
                                         <div class="card border-0">
                                             <div class="card-body">
                                                 <div class="row mb-3">
                                                     <div class="col-md-6">
                                                         <div class="form-group">
                                                             <label class="form-label fw-bold">Employee</label>
                                                             <div class="form-control-plaintext">${payroll.employee_name}</div>
                                                         </div>
                                                     </div>
                                                     <div class="col-md-6">
                                                         <div class="form-group">
                                                             <label class="form-label fw-bold">Pay Period</label>
                                                             <div class="form-control-plaintext">${payroll.pay_period}</div>
                                                         </div>
                                                     </div>
                                                 </div>

                                                 <div class="row mb-4">
                                                     <div class="col-12">
                                                         <div class="form-group">
                                                             <label class="form-label fw-bold">Gross Salary</label>
                                                             <div class="form-control-plaintext">₱ ${payroll.salary}</div>
                                                         </div>
                                                     </div>
                                                 </div>

                                                 <hr class="mb-4">
                                                 <h5 class="mb-3">Deductions</h5>

                                                 <div class="row mb-3">
                                                     <div class="col-md-6">
                                                         <div class="form-group">
                                                             <label for="sss_deductions" class="form-label">SSS Deductions</label>
                                                             <div class="input-group">
                                                                 <span class="input-group-text">₱</span>
                                                                 <input id="sss_deductions" class="form-control" type="number" value="${payroll.sss_deductions}" step="0.01">
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="col-md-6">
                                                         <div class="form-group">
                                                             <label for="pag_ibig_deductions" class="form-label">Pag-IBIG Deductions</label>
                                                             <div class="input-group">
                                                                 <span class="input-group-text">₱</span>
                                                                 <input id="pag_ibig_deductions" class="form-control" type="number" value="${payroll.pag_ibig_deductions}" step="0.01">
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>

                                                 <div class="row mb-3">
                                                     <div class="col-md-6">
                                                         <div class="form-group">
                                                             <label for="philhealth_deductions" class="form-label">PhilHealth Deductions</label>
                                                             <div class="input-group">
                                                                 <span class="input-group-text">₱</span>
                                                                 <input id="philhealth_deductions" class="form-control" type="number" value="${payroll.philhealth_deductions}" step="0.01">
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="col-md-6">
                                                         <div class="form-group">
                                                             <label for="tax" class="form-label">Tax</label>
                                                             <div class="input-group">
                                                                 <span class="input-group-text">₱</span>
                                                                 <input id="tax" class="form-control" type="number" value="${payroll.tax}" step="0.01">
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>

                                                 <hr class="mt-4">
                                                 <div class="row mt-3">
                                                     <div class="col-12">
                                                         <div class="form-group">
                                                             <label class="form-label fw-bold">Net Salary</label>
                                                             <div class="form-control-plaintext text-success fw-bold fs-5">₱ ${payroll.net_salary}</div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     `,
                                     showCancelButton: true,
                                     confirmButtonText: '<i class="fas fa-save me-1"></i> Save Changes',
                                     cancelButtonText: '<i class="fas fa-times me-1"></i> Cancel',
                                     confirmButtonColor: '#3085d6',
                                     cancelButtonColor: '#6c757d',
                                     customClass: {
                                         confirmButton: 'btn btn-primary',
                                         cancelButton: 'btn btn-secondary'
                                     },
                                     buttonsStyling: true,
                                     width: '700px',
                                     preConfirm: () => {
                                         return {
                                             sss_deductions: parseFloat(document.getElementById('sss_deductions').value) || 0,
                                             pag_ibig_deductions: parseFloat(document.getElementById('pag_ibig_deductions').value) || 0,
                                             philhealth_deductions: parseFloat(document.getElementById('philhealth_deductions').value) || 0,
                                             tax: parseFloat(document.getElementById('tax').value) || 0,
                                         };
                                     }
                                 }).then((result) => {
                                     if (result.isConfirmed) {
                                         $.ajax({
                                             url: `/admin/payroll/${payrollId}`,
                                             type: 'POST',
                                             data: {
                                                 _token: $('meta[name="csrf-token"]').attr('content'),
                                                 _method: 'PUT',
                                                 sss_deductions: result.value.sss_deductions,
                                                 pag_ibig_deductions: result.value.pag_ibig_deductions,
                                                 philhealth_deductions: result.value.philhealth_deductions,
                                                 tax: result.value.tax
                                             },
                                             success: function (response) {
                                                 Swal.fire({
                                                     title: 'Success!',
                                                     text: 'Payroll has been updated successfully.',
                                                     icon: 'success',
                                                     confirmButtonColor: '#3085d6'
                                                 }).then(() => location.reload());
                                             },
                                             error: function (xhr) {
                                                 Swal.fire({
                                                     title: 'Error!',
                                                     text: xhr.responseJSON?.message || 'Failed to update payroll.',
                                                     icon: 'error',
                                                     confirmButtonColor: '#3085d6'
                                                 });
                                             }
                                         });
                                     }
                                 });
                             })
                             .fail(function () {
                                 Swal.fire({
                                     title: 'Error!',
                                     text: 'Failed to fetch payroll details.',
                                     icon: 'error',
                                     confirmButtonColor: '#3085d6'
                                 });
                             });
                     }
                    </script>
                @endpush
