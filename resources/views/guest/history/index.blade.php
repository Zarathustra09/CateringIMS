@extends('layouts.guest')

@section('content')
    <div class="container py-4" style="padding-top: 200px; padding-bottom: 200px;">
        <!-- Reservation History -->
        <div class="card">
            <div class="card-header text-center" style="background-color: #ce1212; color: white;">
                <h2 class="h4 mb-0">Reservation History</h2>
            </div>
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: [
                        @foreach($reservations as $reservation)
                            @php
                                $payment = $payments->firstWhere('reservation_id', $reservation->id);
                            @endphp
                        {
                            id: "{{ $reservation->id }}",
                            title: "{{ $reservation->event_name }}",
                            start: "{{ $reservation->start_date }}",
                            end: "{{ $reservation->end_date }}",
                            status: "{{ $reservation->status }}",
                            reservationtype: "{{ $reservation->message }}",
                            formatted_start_date: "{{ \Carbon\Carbon::parse($reservation->start_date)->format('M d, Y h:i A') }}",
                            formatted_end_date: "{{ $reservation->end_date ? \Carbon\Carbon::parse($reservation->end_date)->format('M d, Y h:i A') : 'N/A' }}",
                            invoice_id: "{{ $payment->external_id ?? 'N/A' }}",
                            total_paid: "{{ $payment ? number_format($payment->total, 2) : '0.00' }}",
                            payment_status: "{{ $payment->status ?? 'Unpaid' }}",
                            created_at: "{{ $payment ? $payment->created_at->format('M d, Y h:i A') : 'N/A' }}"
                        },
                        @endforeach
                    ],
                    eventClick: function(info) {
                        Swal.fire({
                            title: '<h3">Reservation Info</h3>',
                            width: '80%',
                            html: `
                                <div class="container text-left mx-auto">
                                    <div class="row">
                                        <div class="col-6">
                                            <h3 class="fw-bold">Reservation Details</h3>
                                            <p><strong>Reservation ID:</strong> ${info.event.id}</p>
                                            <p><strong>Event Name:</strong> ${info.event.title}</p>
                                            <p><strong>Reservation Type:</strong> ${info.event.extendedProps.reservationtype}</p>
                                            <p><strong>Start Date:</strong> ${info.event.extendedProps.formatted_start_date}</p>
                                            <p><strong>End Date:</strong> ${info.event.extendedProps.formatted_end_date}</p>
                                            <p><strong>Status:</strong> ${info.event.extendedProps.status}</p>
                                        </div>
                                        <div class="col-6">
                                            <h3 class="fw-bold">Payment Details</h3>
                                            <p><strong>Invoice ID:</strong> ${info.event.extendedProps.invoice_id}</p>
                                            <p><strong>Total Paid:</strong> ₱${info.event.extendedProps.total_paid}</p>
                                            <p><strong>Payment Status:</strong> 
                                                <span class="badge bg-${info.event.extendedProps.payment_status === 'paid' ? 'success' : 'danger'}">
                                                    ${info.event.extendedProps.payment_status}
                                                </span>
                                            </p>
                                            <p><strong>Payment Date:</strong> ${info.event.extendedProps.created_at}</p>
                                        </div>
                                    </div>
                                </div>
                            `,
                            icon: 'info',
                            confirmButtonText: 'Close'
                        });
                    }
                });

                calendar.render();
            });
        </script>

    @endpush
@endsection
