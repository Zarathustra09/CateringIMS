@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Payments</h4>

        <table id="paymentTable" class="table table-hover">
            <thead>
            <tr>
                <th>User ID</th>
                <th>Reservation ID</th>
                <th>Invoice</th>
                <th>Status</th>
                <th>Total</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->user->name }}</td>
                    <td>{{ $payment->reservation->event_name }}</td>
                    <td>{{ $payment->external_id }}</td>
                    <td>{{ $payment->status }}</td>
                    <td>{{ $payment->total }}</td>
                    <td>{{ $payment->created_at }}</td>
                    <td>
                        <a href="{{ route('admin.reservationitems.show', $payment->reservation_id) }}" class="btn btn-primary">View</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#paymentTable').DataTable();
        });
    </script>
@endpush
