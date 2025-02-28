@extends('layouts.guest')

@section('content')
    <div class="container py-4" style="padding-top: 200px; padding-bottom: 200px;">
        <div class="card mb-4">
            <div class="card-header text-center" style="background-color: #ce1212; color: white;">
                <h2 class="h4 mb-0">Payment History</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="payments-table" class="table table-bordered table-hover">
                        <thead class="table-light">
                        <tr>
                            <th class="align-middle">ID</th>
                            <th class="align-middle">Reservation ID</th>
                            <th class="align-middle">Invoice ID</th>
                            <th class="align-middle">Status</th>
                            <th class="align-middle">Total</th>
                            <th class="align-middle">Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td class="align-middle">{{ $payment->id }}</td>
                                <td class="align-middle">{{ $payment->reservation_id }}</td>
                                <td class="align-middle font-monospace">{{ $payment->external_id }}</td>
                                <td class="align-middle">
                                    <span class="badge bg-{{ $payment->status == 'paid' ? 'success' : 'danger' }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="align-middle">₱{{ number_format($payment->total, 2) }}</td>
                                <td class="align-middle">{{ $payment->created_at->format('M d, Y h:i A') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($payments->isEmpty())
            <div class="text-center py-4">
                <p class="text-gray-500">No payment history available.</p>
            </div>
        @endif

        <!-- Reservation History -->
        <div class="card">
            <div class="card-header text-center" style="background-color: #ce1212; color: white;">
                <h2 class="h4 mb-0">Reservation History</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="reservations-table" class="table table-bordered table-hover">
                        <thead class="table-light">
                        <tr>
                            <th class="align-middle">Reservation ID</th>
                            <th class="align-middle">Event Name</th>
                            <th class="align-middle">Event Type</th>
                            <th class="align-middle">Start Date</th>
                            <th class="align-middle">End Date</th>
                            <th class="align-middle">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reservations as $reservation)
                            <tr>
                                <td class="align-middle">{{ $reservation->id }}</td>
                                <td class="align-middle">{{ $reservation->event_name }}</td>
                                <td class="align-middle">{{ $reservation->event_type }}</td>
                                <td class="align-middle">{{ \Carbon\Carbon::parse($reservation->start_date)->format('M d, Y') }}</td>
                                <td class="align-middle">{{ \Carbon\Carbon::parse($reservation->end_date)->format('M d, Y') }}</td>
                                <td class="align-middle">
                                    <span class="badge bg-{{ $reservation->status == 'confirmed' ? 'success' : 'warning' }}">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($reservations->isEmpty())
            <div class="text-center py-4">
                <p class="text-gray-500">No reservations found.</p>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#payments-table').DataTable();
                $('#reservations-table').DataTable();
            });
        </script>
    @endpush
@endsection
