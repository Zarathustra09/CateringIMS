@extends('layouts.staff.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Staff Payroll</h4>
            </div>

            <div class="card-body">
                <table id="staffPayrollTable" class="table table-hover table-striped">
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
                                <td>{{ number_format(optional($payroll->user->employeeDetail)->salary, 2) }}</td>
                                <td>{{ number_format($payroll->deductions, 2) }}</td>
                                <td>{{ number_format($payroll->net_salary, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($payroll->paid_at)->setTimezone('Asia/Manila')->format('F d, Y h:i A') }}</td>
                                <td>
                                    <a href="{{ route('admin.payroll.pdf', $payroll->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-file-pdf"></i> Download PDF
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
        $('#staffPayrollTable').DataTable();
    });
</script>
@endpush
