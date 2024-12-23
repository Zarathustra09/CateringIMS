@extends('layouts.guest')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Payment History</h2>
        <table id="payments-table" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Reservation ID</th>
                <th>Checkout Link</th>
                <th>Status</th>
                <th>Total</th>
                <th>Created At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->reservation_id }}</td>
                    <td>{{ $payment->external_id }}</td>
                    <td>{{ $payment->status }}</td>
                    <td>{{ $payment->total }}</td>
                    <td>{{ $payment->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#payments-table').DataTable();
        });
    </script>
@endpush
