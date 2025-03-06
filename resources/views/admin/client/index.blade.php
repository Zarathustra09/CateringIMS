@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Clients</h2>
                <button type="button" class="btn btn-primary" onclick="createClient()">
                    <span class="tf-icons bx bx-plus"></span>&nbsp; Add Client
                </button>
            </div>
            <div class="card-body">
                <table id="clientTable" class="table table-hover table-striped">
                    <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->phone_number }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="viewClient({{ $client->id }})">View</button>
                                <button class="btn btn-warning btn-sm" onclick="editClient({{ $client->id }})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteClient({{ $client->id }})">Delete</button>
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
            $('#clientTable').DataTable();
        });

        async function createClient() {
            await Swal.fire({
                title: 'Create Client',
                html: `
                <input id="swal-input1" class="swal2-input" placeholder="Name">
                <input id="swal-input2" class="swal2-input" placeholder="Email">
                <input id="swal-input3" class="swal2-input" placeholder="Phone Number">
                <input id="swal-input4" class="swal2-input" type="password" placeholder="Password">
                <input id="swal-input5" class="swal2-input" type="password" placeholder="Confirm Password">
            `,
                showConfirmButton: true,
                confirmButtonText: 'Create',
                showCloseButton: true,
                preConfirm: () => {
                    return {
                        name: document.getElementById('swal-input1').value,
                        email: document.getElementById('swal-input2').value,
                        phone_number: document.getElementById('swal-input3').value,
                        password: document.getElementById('swal-input4').value,
                        password_confirmation: document.getElementById('swal-input5').value
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    storeClient(result.value);
                }
            });
        }

        function storeClient(data) {
            $.ajax({
                url: '/admin/client',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ...data
                },
                success: function(response) {
                    Swal.fire('Created!', 'Client has been created successfully.', 'success').then(() => {
                        location.reload();
                    });
                },
                error: function(response) {
                    if (response.status === 422) {
                        let errors = response.responseJSON.errors;
                        let errorMessages = '';
                        for (let field in errors) {
                            errorMessages += `${errors[field].join(', ')}<br>`;
                        }
                        Swal.fire('Error!', errorMessages, 'error');
                    } else {
                        Swal.fire('Error!', 'There was an error creating the client.', 'error');
                    }
                }
            });
        }

        function editClient(clientId) {
            $.get('/admin/client/' + clientId, function(client) {
                Swal.fire({
                    title: 'Edit Client',
                    html: `
                        <input id="swal-input1" class="swal2-input" value="${client.name}" placeholder="Name">
                        <input id="swal-input2" class="swal2-input" value="${client.email}" placeholder="Email">
                        <input id="swal-input3" class="swal2-input" value="${client.phone_number}" placeholder="Phone Number">
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        return {
                            name: document.getElementById('swal-input1').value,
                            email: document.getElementById('swal-input2').value,
                            phone_number: document.getElementById('swal-input3').value
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/client/' + clientId,
                            type: 'PUT',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ...result.value
                            },
                            success: function(response) {
                                Swal.fire('Updated!', response.success, 'success').then(() => {
                                    location.reload();
                                });
                            }
                        });
                    }
                });
            });
        }

        function deleteClient(clientId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/client/' + clientId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', response.success, 'success').then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        }
    </script>
@endpush
