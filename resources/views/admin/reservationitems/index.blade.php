@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Reservation</h2>
             
            </div>
            <div class="card-body">
                <table id="reservationTable" class="table table-hover table-striped">
                    <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Event Type</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Message</th> 
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->id }}</td>
                            <td>{{ $reservation->event_type }}</td>
                            <td>
                                <span class="badge
                                    @if($reservation->status == 'completed') bg-success
                                    @elseif($reservation->status == 'pending') bg-warning
                                    @elseif($reservation->status == 'confirmed') bg-primary
                                    @elseif($reservation->status == 'cancelled') bg-danger
                                    @endif">
                                    {{ $reservation->status }}
                                </span>
                            </td>
                            {{-- <td>{{ $reservation->category->name }}</td> --}}
                            <td>{{ \Carbon\Carbon::parse($reservation->start_date)->format('F d Y h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($reservation->end_date)->format('F d Y h:i A') }}</td>
                            <td>{{ $reservation->message }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="viewReservationItems({{ $reservation->id }})">View</button>
                                <button class="btn btn-warning btn-sm" onclick="editReservationItems({{ $reservation->id }})">Edit</button>
                               
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
        $(document).ready(function() {
            $('#reservationTable').DataTable();
        });
    
    
        function viewReservationItems(reservationId) {
            window.location.href = "{{ route('admin.reservationitems.show', ':id') }}".replace(':id', reservationId);
        }
    
        function editReservationItems(reservationId, reservation = {}, categoryOptions = '') {
            Swal.fire({
    title: 'Edit Reservation',
    html: `
        
        <select id="swal-input3" class="swal2-input" required>
            <option value="pending" ${reservation.status === 'pending' ? 'selected' : ''}>Pending</option>
            <option value="confirmed" ${reservation.status === 'confirm' ? 'selected' : ''}>Confirm</option>
            <option value="cancelled" ${reservation.status === 'cancelled' ? 'selected' : ''}>Cancled</option>
            <option value="completed" ${reservation.status === 'completed' ? 'selected' : ''}>Completed</option>
        </select>
     `,
    showCancelButton: true,
    confirmButtonText: 'Update',
    cancelButtonText: 'Cancel',
    preConfirm: () => {
        const formData = new FormData();
        formData.append('status', document.getElementById('swal-input3').value); // Status

        return formData;
    }
}).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: '/admin/reservation-items/' + reservationId, // URL should be correct
            type: 'POST', // We're using POST with X-HTTP-Method-Override header to simulate PUT
            data: result.value,
            processData: false,
            contentType: false,
            headers: {
                'X-HTTP-Method-Override': 'PUT', // Override to PUT
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                Swal.fire({
                    title: 'Updated!',
                    text: response.success,
                    icon: 'success'
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: xhr.responseJSON?.message || 'An error occurred while updating the reservation.',
                    icon: 'error'
                });
            }
        });
    }
});
        }
    
       
    </script>
    
@endpush
