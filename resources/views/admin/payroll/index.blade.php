@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Payroll</h4>

            <a href="{{ route('admin.payroll.create') }}" class="btn btn-primary">Add Payroll</a>
        </div>
        <div class="card-body">
            <table id="payrollTable" class="table table-hover table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Employee</th>
                        <th>Pay Period</th>
                        <th>Reservation</th>
                        <th>Salary</th> <!-- Change this column header to Salary -->
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
                            <td>{{ $payroll->reservation->event_type }}</td>
                            <td>
                                @if ($payroll->user->employeeDetail)
                                    {{ number_format($payroll->user->employeeDetail->salary, 2) }}
                                @else
                                    Not Available
                                @endif
                            </td>
                            <td>{{ number_format($payroll->deductions, 2) }}</td>
                            <td>{{ number_format($payroll->net_salary, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($payroll->paid_at)->format('F d, Y h:i A') }}</td>
                            <td>
                                <a href="{{ route('admin.payroll.edit', $payroll->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="{{ route('admin.payroll.destroy', $payroll->id) }}" class="btn btn-danger btn-sm">Delete</a>
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

    <!-- DataTables Script -->
    <script>
        $(document).ready(function () {
            $('#payrollTable').DataTable({
                responsive: true, // Enables responsive behavior
                paging: true,    // Enables pagination
                searching: true, // Enables search functionality
                ordering: true,  // Enables column sorting
                columnDefs: [
                    { orderable: false, targets: 7 } // Disable sorting for the 'Actions' column
                ]
            });
        });
    </script>
@endpush
