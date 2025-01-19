@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Attendance Records</h4>

        <button type="button" class="btn btn-primary mb-3" onclick="createAttendance()">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Add Attendance
        </button>

        <table id="attendanceTable" class="table table-hover">
            <thead>
            <tr>
                <th>Employee</th>
                <th>Reservation</th>
                <th>Created At</th>
                <th>Actions</th>
                
            </tr>
            </thead>
            <tbody>
            @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->user->name }}</td>
                    <td>Reservation #{{ $attendance->reservation->event_type }}</td>
                    <td>{{ $attendance->created_at->format('Y-m-d H:i:s') }}</td> <!-- Display timestamp -->
                    <td>
                        {{-- <button class="btn btn-info btn-sm" onclick="viewAttendance({{ $attendance->id }})">View</button> --}}
                        <button class="btn btn-warning btn-sm" onclick="editAttendance({{ $attendance->id }})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteAttendance({{ $attendance->id }})">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#attendanceTable').DataTable();

        // Attach moment.js formatting to the created_at column (optional if needed)
        $('#attendanceTable').on('draw.dt', function () {
            $('[data-timestamp]').each(function () {
                const timestamp = $(this).data('timestamp');
                $(this).text(moment(timestamp).format('YYYY-MM-DD HH:mm:ss'));
            });
        });
    });

    // Create Attendance
    async function createAttendance() {
        await Swal.fire({
            title: 'Create New Attendance',
            html: `
                <select id="swal-user-id" class="swal2-input">
                    <option value="" disabled selected>Select Employee</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <select id="swal-reservation-id" class="swal2-input">
                    <option value="" disabled selected>Select Reservation</option>
                    @foreach($reservations as $reservation)
                        <option value="{{ $reservation->id }}">Reservation #{{ $reservation->event_type }}</option>
                    @endforeach
                </select>
            `,
            showConfirmButton: true,
            confirmButtonText: 'Create',
            showCloseButton: true,
            preConfirm: () => {
                const userId = document.getElementById('swal-user-id').value;
                const reservationId = document.getElementById('swal-reservation-id').value;
                return { user_id: userId, reservation_id: reservationId };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                storeAttendance(result.value);
            }
        });
    }

    function storeAttendance(data) {
        $.ajax({
            url: '/admin/attendance',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: data.user_id,
                reservation_id: data.reservation_id,
            },
            success: function () {
                Swal.fire({
                    title: 'Created!',
                    text: 'Attendance record created successfully.',
                    icon: 'success',
                }).then(() => {
                    location.reload();
                });
            },
            error: function () {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to create the attendance record.',
                    icon: 'error',
                });
            }
        });
    }

    // View Attendance
//     function viewAttendance(id) {
//     $.get('/admin/attendance/' + id, function (attendance) {
//         const date = new Date(attendance.date); // Convert date to JavaScript Date object
//         const formattedDate = date.toLocaleString('en-US', {
//             weekday: 'long',
//             year: 'numeric',
//             month: 'long',
//             day: 'numeric',
//             hour: 'numeric',
//             minute: 'numeric',
//             second: 'numeric',
//             hour12: true
//         });

//         Swal.fire({
//             title: 'Attendance Details',
//             html: `
//                 <p>User: ${attendance.user.name}</p>
//                 <p>Reservation: ${attendance.reservation.event_type}</p>
//                 <p>Date: ${formattedDate}</p>
//             `,
//             icon: 'info',
//         });
//     });
// }


    // Edit Attendance
    function editAttendance(id) {
        $.get('/admin/attendance/' + id, function (attendance) {
            Swal.fire({
                title: 'Edit Attendance',
                html: `
                    <select id="swal-user-id" class="swal2-input">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" ${attendance.user.id == {{ $user->id }} ? 'selected' : ''}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    <select id="swal-reservation-id" class="swal2-input">
                        @foreach($reservations as $reservation)
                            <option value="{{ $reservation->id }}" ${attendance.reservation.id == {{ $reservation->id }} ? 'selected' : ''}>
                               {{ $reservation->event_type }}
                            </option>
                        @endforeach
                    </select>
                `,
                showCancelButton: true,
                confirmButtonText: 'Update',
                preConfirm: () => {
                    const userId = document.getElementById('swal-user-id').value;
                    const reservationId = document.getElementById('swal-reservation-id').value;
                    return { user_id: userId, reservation_id: reservationId };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    updateAttendance(id, result.value);
                }
            });
        }).fail(function () {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to fetch attendance details.',
                icon: 'error',
            });
        });
    }

    function updateAttendance(id, data) {
    $.ajax({
        url: `/admin/attendance/${id}`,
        type: 'PUT',
        data: {
            _token: '{{ csrf_token() }}',
            ...data
        },
        success: function (response) {
            Swal.fire({
                title: 'Updated!',
                text: 'Attendance updated successfully.',
                icon: 'success',
            }).then(() => {
                // Reload the page to reflect the changes
                location.reload();
            });
        },
        error: function (response) {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to update attendance.',
                icon: 'error',
            });
        }
    });
}


    // Delete Attendance
    function deleteAttendance(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    popup: 'my-custom-popup-class',
                    title: 'my-custom-title-class',
                    confirmButton: 'my-custom-confirm-button-class',
                    cancelButton: 'my-custom-cancel-button-class'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/attendance/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: response.success,
                                icon: 'success',
                                customClass: {
                                    popup: 'my-custom-popup-class',
                                    title: 'my-custom-title-class',
                                    confirmButton: 'my-custom-confirm-button-class'
                                }
                            }).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        }

</script>
@endpush
