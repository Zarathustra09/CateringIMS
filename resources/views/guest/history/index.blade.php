@extends('layouts.guest')

@section('content')
<div class="container py-4" style="padding-top: 200px; padding-bottom: 200px;">
    <!-- Payment History -->
    <div class="card mb-4">
        <div class="card-header text-center" style="background-color: #ce1212; color: white;">
            <h2 class="h4 mb-0">Payment History</h2>
        </div>
        <div class="card-body">
            <table id="paymentTable" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Invoice ID</th>
                        <th>Total Paid (₱)</th>
                        <th>Status</th>
                        <th>Paid At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                        @php $payment = $payments->firstWhere('reservation_id', $reservation->id); @endphp
                        @if($payment)
                            <tr>
                                <td>{{ $payment->external_id ?? 'N/A' }}</td>
                                <td>{{ number_format($payment->total, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $payment->status === 'paid' ? 'success' : 'danger' }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>{{ $payment->created_at->format('M d, Y h:i A') }}</td>
                                <td>
                                    <a href="{{ route('guest.history.pdf', $payment->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                        <i class="bi bi-printer"></i> PDF
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Reservation History -->
    <div class="card">
        <div class="card-header text-center" style="background-color: #ce1212; color: white;">
            <h2 class="h4 mb-0">Reservation History</h2>
        </div>
        <div class="card-body">
            <table id="reservationTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>Event Name</th>
                        <th>Service</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $res)
                        <tr>
                            <td>{{ $res->id }}</td>
                            <td>{{ $res->event_name ?? 'Reservation #' . $res->id }}</td>
                            <td>{{ $res->service->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $res->status === 'confirmed' || $res->status === 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($res->status) }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($res->start_date ?? $res->reservation_date)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($res->end_date ?? $res->reservation_date)->format('M d, Y') }}</td>
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
            $('#paymentTable').DataTable({
                order: [[ 4, "desc" ]],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search payments..."
                }
            });

            $('#reservationTable').DataTable({
                order: [[ 4, "desc" ]],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search reservations..."
                }
            });
        });
    </script>
@endpush
