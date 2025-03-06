@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Payments</h2>
            </div>
            <div class="card-body">
                <table id="paymentTable" class="table table-hover table-striped">
                    <thead class="thead-light">
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
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#paymentTable').DataTable();
        });
    </script>
@endpush
