@extends('layouts.app')

                        @section('content')
                        <div class="container">
                            <h1>Create Payroll</h1>
                            <form action="{{ route('admin.payroll.store') }}" method="POST" id="payrollForm">
                                @csrf

                                <!-- Employee Selection -->
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Employee</label>
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        <option value="" disabled selected>Select Employee</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                data-pay-period-id="{{ $user->employeeDetail->pay_period_id ?? '' }}">
                                                {{ $user->name }} -
                                                {{ $user->employeeDetail->payPeriod->name ?? 'No Pay Period' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Hidden field for pay_period_id -->
                                <input type="hidden" name="pay_period_id" id="pay_period_id">

                                <!-- Reservation Selection (Only for Contractual Employees) -->
                                <div class="mb-3" id="reservation_field" style="display: none;">
                                    <label for="reservation_id" class="form-label">Event</label>
                                    <select name="reservation_id" id="reservation_id" class="form-control">
                                        <option value="" disabled selected>Select Reservation</option>
                                        @foreach ($reservations as $reservation)
                                            <option value="{{ $reservation->id }}">
                                                #{{ $reservation->id }} - {{ $reservation->event_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Deductions Fields -->
                                <div class="mb-3">
                                    <label for="sss_deductions" class="form-label">SSS Deductions</label>
                                    <input type="number" name="sss_deductions" id="sss_deductions" class="form-control" step="0.01" value="0">
                                </div>

                                <div class="mb-3">
                                    <label for="pag_ibig_deductions" class="form-label">Pag-IBIG Deductions</label>
                                    <input type="number" name="pag_ibig_deductions" id="pag_ibig_deductions" class="form-control" step="0.01" value="0">
                                </div>

                                <div class="mb-3">
                                    <label for="philhealth_deductions" class="form-label">PhilHealth Deductions</label>
                                    <input type="number" name="philhealth_deductions" id="philhealth_deductions" class="form-control" step="0.01" value="0">
                                </div>

                                <div class="mb-3">
                                    <label for="tax" class="form-label">Tax</label>
                                    <input type="number" name="tax" id="tax" class="form-control" step="0.01" value="0">
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-success">Save</button>
                            </form>

                            <!-- Employees Without Payroll Table -->
                            @if(isset($employeesWithoutPayrollByType) && count($employeesWithoutPayrollByType) > 0)
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
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @endsection

                        @push('scripts')
                        <script>
                        $(document).ready(function () {
                            $('#noPayrollTable').DataTable();
                        });

                        document.addEventListener("DOMContentLoaded", function () {
                            console.log("✅ JavaScript Loaded in create.blade.php");

                            let userDropdown = document.getElementById("user_id");
                            let reservationField = document.getElementById("reservation_field");
                            let payPeriodInput = document.getElementById("pay_period_id");

                            userDropdown.addEventListener("change", function () {
                                let selectedUser = this.options[this.selectedIndex];
                                let payPeriodId = selectedUser.getAttribute("data-pay-period-id");

                                console.log("📌 Selected User ID:", this.value);
                                console.log("📅 Pay Period ID:", payPeriodId);

                                payPeriodInput.value = payPeriodId || ""; // Update hidden field

                                if (payPeriodId == "3") {
                                    reservationField.style.display = "block";
                                    document.getElementById("reservation_id").setAttribute("required", "required");
                                } else {
                                    reservationField.style.display = "none";
                                    document.getElementById("reservation_id").removeAttribute("required");
                                }
                            });

                            // SweetAlert Confirmation on Submit
                            document.getElementById("payrollForm").addEventListener("submit", function (e) {
                                e.preventDefault();

                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You are about to add a new payroll record.",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, Save it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        this.submit();
                                    }
                                });
                            });

                            // Initialize DataTable
                            $('#noPayrollTable').DataTable();
                        });
                        </script>
                        @endpush
