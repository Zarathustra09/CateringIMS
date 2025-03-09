@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back"></i> Back to Reservation
            </a>
            <h2 class="mb-0">Attendance Records</h2>
            <button type="button" class="btn btn-primary" onclick="createAttendance()">
                <span class="tf-icons bx bx-plus"></span>&nbsp; Add Attendance
            </button>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="attendanceTable" class="table table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Employee</th>
                            <th>Reservation</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->user->name }}</td>
                                <td>{{ $attendance->reservation->event_name }}</td>
                                <td>{{ $attendance->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
