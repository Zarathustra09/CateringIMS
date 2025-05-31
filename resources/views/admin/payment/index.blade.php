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
                                            <th>Payment Type</th>
                                            <th>Amount Paid</th>
                                            <th>Payment Type</th>
                                            <th>Total</th>
                                            <th>Status</th>
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
                                                <td>
                                                    @if($payment->is_down_payment)
                                                        <span class="badge bg-warning text-dark">Down Payment (50%)</span>
                                                    @else
                                                        <span class="badge bg-info">{{ $payment->amount_paid < $payment->total ? 'Balance Payment' : 'Full Payment' }}</span>
                                                    @endif
                                                </td>
                                                <td>₱{{ number_format($payment->amount_paid, 2) }}</td>
                                                <td>{{$payment->payment_type}}</td>
                                                <td>₱{{ number_format($payment->total, 2) }}</td>
                                                <td>
                                                    @if($payment->status === 'paid')
                                                        <span class="badge bg-success">Paid</span>
                                                    @elseif($payment->status === 'pending')
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ ucfirst($payment->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $payment->created_at->format('M d, Y h:i A') }}</td>
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
                                $('#paymentTable').DataTable({
                                    order: [[7, 'desc']], // Sort by date descending
                                    responsive: true
                                });
                            });
                        </script>
                    @endpush
