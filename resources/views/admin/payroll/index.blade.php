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
                            <td>{{ optional($payroll->user)->name ?? 'N/A' }}</td>
                            <td>{{ optional($payroll->payPeriod)->name ?? 'N/A' }}</td>
                            <td>{{ optional($payroll->reservation)->event_name ?? 'N/A' }}</td>
                            <td>
                                @if ($payroll->user && $payroll->user->employeeDetail)
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
                                <form action="{{ route('admin.payroll.destroy', $payroll->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</button>
                                </form>
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
                { orderable: false, targets: 8 } // Disable sorting for the 'Actions' column
            ]
        });
    });
</script>
@endpush
