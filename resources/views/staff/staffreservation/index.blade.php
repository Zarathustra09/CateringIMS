@extends('layouts.staff.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Reservations</h4>
            </div>
            <div class="card-body">
                <!-- FullCalendar Container -->
                <div id="calendar"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: {!! json_encode($reservations->map(function ($res) {
                    return [
                        'id' => $res->id,
                        'title' => $res->categoryEvent->name . ' (' . $res->status . ')', 
                        'start' => $res->start_date,
                        'end' => $res->end_date,
                        'extendedProps' => [
                            'status' => $res->status,
                            'message' => $res->message
                        ]
                    ];
                })) !!},
                eventClick: function(info) {
                    var reservationId = info.event.id;
                    window.location.href = `/staff/reservation/${reservationId}`;
                }
            });

            calendar.render();
        });
    </script>
@endpush
