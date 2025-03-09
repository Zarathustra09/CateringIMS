@extends('layouts.guest')

@section('content')
    <div class="container mt-5" style="margin-bottom: 120px;">
        <div class="card mb-4">
            <div class="card-header text-center" style="background-color: #ce1212; color: white;">
                <h2 class="mb-0">Create Reservation</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('reservation.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ request('service_id') }}">

                            <!-- Event Name -->
                            <div class="mb-3">
                                <label for="event_name" class="form-label" style="color: black;">Event Name</label>
                                <input type="text" class="form-control" id="event_name" name="event_name" required>
                            </div>

                            <!-- Event Type Dropdown -->
                            <div class="mb-3">
                                <label for="event_type" class="form-label" style="color: black;">Event Type</label>
                                <select class="form-control" id="event_type" name="event_type" required>
                                    <option value="">Select Event Type</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Start Date -->
                            <div class="mb-3">
                                <label for="start_date" class="form-label" style="color: black;">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>

                            <!-- End Date -->
                            <div class="mb-3">
                                <label for="end_date" class="form-label" style="color: black;">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>

                            <!-- Message -->
                            <div class="mb-3">
                                <label for="message" class="form-label" style="color: black;">Message</label>
                                <textarea class="form-control" id="message" name="message"></textarea>
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-light">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: function(fetchInfo, successCallback, failureCallback) {
                        fetch('{{ route('api.reservation.index') }}', {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                var events = data.map(function(res) {
                                    return {
                                        title: 'Occupied',
                                        start: res.start_date,
                                        end: res.end_date,
                                        extendedProps: {
                                            status: res.status,
                                            message: res.message
                                        }
                                    };
                                });
                                successCallback(events);
                            })
                            .catch(error => {
                                console.error('Error fetching reservations:', error);
                                failureCallback(error);
                            });
                    }
                });

                calendar.render();
            });
        </script>
    @endpush
@endsection
