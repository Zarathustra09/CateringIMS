@extends('layouts.guest')

@section('content')
    <div class="container py-4" style="padding-top: 200px; padding-bottom: 200px;">
        <!-- Payment History -->
        <div class="card mb-4">
            <div class="card-header text-center" style="background-color: #ce1212; color: white;">
                <h2 class="h4 mb-0">Payment History</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="paymentTable" class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Event Name</th>
                            <th>Payment Type</th>
                            <th>Amount Paid (₱)</th>
                            <th>Total (₱)</th>
                            <th>Status</th>
                            <th>Paid At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->external_id ?? 'N/A' }}</td>
                                <td>{{ $payment->reservation->event_name }}</td>
                                <td>
                                    @if($payment->is_down_payment)
                                        <span class="badge bg-warning">Down Payment (50%)</span>
                                    @else
                                        <span class="badge bg-info">{{ $payment->amount_paid < $payment->total ? 'Balance Payment' : 'Full Payment' }}</span>
                                    @endif
                                </td>
                                <td>{{ number_format($payment->amount_paid, 2) }}</td>
                                <td>{{ number_format($payment->total, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $payment->status === 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>{{ $payment->created_at->format('M d, Y h:i A') }}</td>
                                <td>
                                    <a href="{{ route('guest.history.pdf', $payment->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i> Receipt
                                    </a>
                                </td>
                            </tr>

                            @if($payment->is_down_payment && $payment->status === 'paid' && $payment->reservation->status === 'partially_paid')
                                <tr>
                                    <td colspan="8" class="border-0 pt-0">
                                        <div class="alert alert-warning d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Remaining Balance:</strong> ₱{{ number_format($payment->total - $payment->amount_paid, 2) }}
                                            </div>
                                            <a href="{{ route('payment.balance', $payment->reservation_id) }}"
                                               class="btn btn-warning">Pay Remaining Balance</a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Reservation History -->
        <div class="card">
            <div class="card-header text-center" style="background-color: #ce1212; color: white;">
                <h2 class="h4 mb-0">Reservation History</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
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
                                <td>{{ $res->event_name }}</td>
                                <td>{{ $res->service->name }}</td>
                                <td>
                                    @if($res->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($res->status == 'confirmed')
                                        <span class="badge bg-success">Confirmed</span>
                                    @elseif($res->status == 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @elseif($res->status == 'completed')
                                        <span class="badge bg-info">Completed</span>
                                    @elseif($res->status == 'partially_paid')
                                        <span class="badge bg-primary">Partially Paid</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($res->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $res->start_date->format('M d, Y h:i A') }}</td>
                                <td>{{ $res->end_date->format('M d, Y h:i A') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#paymentTable').DataTable({
                order: [[6, 'desc']], // Sort by paid date, newest first
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search payments...",
                    emptyTable: "No payment records found"
                }
            });

            $('#reservationTable').DataTable({
                order: [[4, 'desc']], // Sort by start date, newest first
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search reservations...",
                    emptyTable: "No reservation records found"
                }
            });
        });
    </script>
@endpush
