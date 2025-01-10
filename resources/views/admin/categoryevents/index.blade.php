@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Event Categories</h4>

        <button type="button" class="btn btn-primary mb-3" onclick="createCategoryEvent()">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Add Event Category
        </button>

        <table id="categoryEventTable" class="table table-hover">
            <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categoryEvents as $event)
                <tr>
                    <td>{{ $event->name }}</td>
                    <td>
                        <button class="btn btn-info btn-sm" onclick="viewCategoryEvent({{ $event->id }})">View</button>
                        <button class="btn btn-warning btn-sm" onclick="editCategoryEvent({{ $event->id }})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteCategoryEvent({{ $event->id }})">Delete</button>
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
            $('#categoryEventTable').DataTable();
        });

        // Create Category Event
        async function createCategoryEvent() {
    await Swal.fire({
        title: 'Create New Category Event',
        html: `
            <input id="swal-input1" class="swal2-input" placeholder="Name">
        `,
        showConfirmButton: true,
        confirmButtonText: 'Create',
        showCloseButton: true,
        preConfirm: () => {
            const name = document.getElementById('swal-input1') ? document.getElementById('swal-input1').value : '';
            return { name }; // Only return the name
        }
    }).then((result) => {
        if (result.isConfirmed) {
            storeCategoryEvent(result.value); // Pass the name only
        }
    });
}

function storeCategoryEvent(data) {
    $.ajax({
        url: '/admin/category-events',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            name: data.name
        },
        success: function(response) {
            Swal.fire({
                title: 'Created!',
                text: 'Category has been created successfully.',
                icon: 'success',
            }).then(() => {
                location.reload();
            });
        },
        error: function(response) {
            let errors = response.responseJSON.errors;
            let errorMessages = '';
            for (let field in errors) {
                errorMessages += `${errors[field].join(', ')}<br>`;
            }
            Swal.fire({
                title: 'Error!',
                html: errorMessages,
                icon: 'error',
            });
        }
    });
}




        // Store Category Event
        function storeCategoryEvent(data) {
            $.ajax({
                url: '/admin/category-events',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: data.name
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Created!',
                        text: 'Category has been created successfully.',
                        icon: 'success',
                        customClass: {
                            popup: 'my-custom-popup-class',
                            title: 'my-custom-title-class',
                            confirmButton: 'my-custom-confirm-button-class'
                        }
                    }).then(() => {
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
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessages,
                            icon: 'error',
                            customClass: {
                                popup: 'my-custom-popup-class',
                                title: 'my-custom-title-class',
                                confirmButton: 'my-custom-cancel-button-class'
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an error creating the category.',
                            icon: 'error',
                            customClass: {
                                popup: 'my-custom-popup-class',
                                title: 'my-custom-title-class',
                                confirmButton: 'my-custom-cancel-button-class'
                            }
                        });
                    }
                }
            });
        }

        // View Category Event
        function viewCategoryEvent(id) {
            $.get('/admin/category-events/' + id, function (categoryEvent) {
                Swal.fire({
                    title: 'Event Category Details',
                    html: `<p>Name: ${categoryEvent.name}</p>`,
                    icon: 'info',
                });
            });
        }

        // Edit Category Event
        function editCategoryEvent(id) {
    $.get('/admin/category-events/' + id, function (categoryEvent) {
        Swal.fire({
            title: 'Edit Category Event',
            html: `
                <input id="swal-input1" class="swal2-input" value="${categoryEvent.name}" placeholder="Name">
            `,
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
                const name = document.getElementById('swal-input1') ? document.getElementById('swal-input1').value : '';
                return { name }; // Only return the name
            }
        }).then((result) => {
            if (result.isConfirmed) {
                updateCategoryEvent(id, result.value); // Pass the name only
            }
        });
    });
}

function updateCategoryEvent(id, data) {
    $.ajax({
        url: '/admin/category-events/' + id,
        type: 'PUT',
        data: {
            _token: '{{ csrf_token() }}',
            name: data.name
        },
        success: function(response) {
            Swal.fire({
                title: 'Updated!',
                text: 'Category event updated successfully.',
                icon: 'success',
            }).then(() => {
                location.reload();
            });
        },
        error: function(response) {
            let errors = response.responseJSON.errors;
            let errorMessages = '';
            for (let field in errors) {
                errorMessages += `${errors[field].join(', ')}<br>`;
            }
            Swal.fire({
                title: 'Error!',
                html: errorMessages,
                icon: 'error',
            });
        }
    });
}


function updateCategoryEvent(id, data) {
    $.ajax({
        url: '/admin/category-events/' + id,
        type: 'PUT',
        data: {
            _token: '{{ csrf_token() }}',
            name: data.name,
            description: data.description
        },
        success: function(response) {
            Swal.fire({
                title: 'Updated!',
                text: 'Category event updated successfully.',
                icon: 'success',
            }).then(() => {
                location.reload();
            });
        },
        error: function(response) {
            let errors = response.responseJSON.errors;
            let errorMessages = '';
            for (let field in errors) {
                errorMessages += `${errors[field].join(', ')}<br>`;
            }
            Swal.fire({
                title: 'Error!',
                html: errorMessages,
                icon: 'error',
            });
        }
    });
}


        // Delete Category Event
        function deleteCategoryEvent(id) {
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
                        url: '/admin/category-events/' + id,
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
