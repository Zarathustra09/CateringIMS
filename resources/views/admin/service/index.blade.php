@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Services</h4>

        <button type="button" class="btn btn-primary mb-3" onclick="createService()">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Add Service
        </button>

        <table id="serviceTable" class="table table-hover">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($services as $service)
                <tr>
                    <td>{{ $service->name }}</td>
                    <td>{{ $service->description }}</td>
                    <td>₱{{ $service->price }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editService({{ $service->id }})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteService({{ $service->id }})">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')

    <script>
        $(document).ready(function() {
            $('#serviceTable').DataTable();
        });

        async function createService() {
            await Swal.fire({
                title: 'Create Service',
                html: `
                <input id="swal-input1" class="swal2-input" placeholder="Name">
                <input id="swal-input2" class="swal2-input" placeholder="Description">
                <input id="swal-input3" class="swal2-input" placeholder="Price">
            `,
                showConfirmButton: true,
                confirmButtonText: 'Create',
                showCloseButton: true,
                preConfirm: () => {
                    return {
                        name: document.getElementById('swal-input1').value,
                        description: document.getElementById('swal-input2').value,
                        price: document.getElementById('swal-input3').value
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    storeService(result.value);
                }
            });
        }

        function storeService(data) {
            $.ajax({
                url: '/admin/service',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ...data
                },
                success: function(response) {
                    Swal.fire('Created!', 'Service has been created successfully.', 'success').then(() => {
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
                        Swal.fire('Error!', 'There was an error creating the service.', 'error');
                    }
                }
            });
        }

        function editService(serviceId) {
            $.get('/admin/service/' + serviceId, function(service) {
                Swal.fire({
                    title: 'Edit Service',
                    html: `
                        <input id="swal-input1" class="swal2-input" value="${service.name}" placeholder="Name">
                        <input id="swal-input2" class="swal2-input" value="${service.description}" placeholder="Description">
                        <input id="swal-input3" class="swal2-input" value="${service.price}" placeholder="Price">
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        return {
                            name: document.getElementById('swal-input1').value,
                            description: document.getElementById('swal-input2').value,
                            price: document.getElementById('swal-input3').value
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/service/' + serviceId,
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

        function deleteService(serviceId) {
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
                        url: '/admin/service/' + serviceId,
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
