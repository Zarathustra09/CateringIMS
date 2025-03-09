@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Menus</h2>
                <button type="button" class="btn btn-primary" onclick="createMenu()">
                    <span class="tf-icons bx bx-plus"></span>&nbsp; Add Menu
                </button>
            </div>
            <div class="card-body">
                <table id="menuTable" class="table table-hover table-striped">
                    <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Is Active</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($menus as $menu)
                        <tr>
                            <td>{{ $menu->id }}</td>
                            <td>{{ $menu->name }}</td>
                            <td>{{ $menu->description }}</td>
                            <td>{{ $menu->is_active ? 'Yes' : 'No' }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="viewMenuItems({{ $menu->id }})">Show</button>
                                <button class="btn btn-warning btn-sm" onclick="editMenu({{ $menu->id }})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteMenu({{ $menu->id }})">Delete</button>
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
            $('#menuTable').DataTable();
        });

        async function createMenu() {
            await Swal.fire({
                title: 'Create Menu',
                html: `
                    <input id="swal-input1" class="swal2-input" placeholder="Name">
                    <textarea id="swal-input2" class="swal2-textarea" placeholder="Description"></textarea>
                    <label for="swal-input3">Is Active</label>
                    <input type="checkbox" id="swal-input3" class="swal2-checkbox">
                `,
                showConfirmButton: true,
                confirmButtonText: 'Create',
                showCloseButton: true,
                preConfirm: () => {
                    return {
                        name: document.getElementById('swal-input1').value,
                        description: document.getElementById('swal-input2').value,
                        is_active: document.getElementById('swal-input3').checked
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    storeMenu(result.value);
                }
            });
        }

        function storeMenu(data) {
            $.ajax({
                url: '{{ route("menus.store") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ...data
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Created!',
                        text: 'Menu has been created successfully.',
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(response) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error creating the menu.',
                        icon: 'error'
                    });
                }
            });
        }

        async function editMenu(menuId) {
            $.get('/menus/' + menuId, function(menu) {
                Swal.fire({
                    title: 'Edit Menu',
                    html: `
                        <input id="swal-input1" class="swal2-input" value="${menu.name}" placeholder="Name">
                        <textarea id="swal-input2" class="swal2-textarea" placeholder="Description">${menu.description}</textarea>
                        <label for="swal-input3">Is Active</label>
                        <input type="checkbox" id="swal-input3" class="swal2-checkbox" ${menu.is_active ? 'checked' : ''}>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        return {
                            name: document.getElementById('swal-input1').value,
                            description: document.getElementById('swal-input2').value,
                            is_active: document.getElementById('swal-input3').checked
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/menus/' + menuId,
                            type: 'PUT',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ...result.value
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Updated!',
                                    text: 'Menu has been updated successfully.',
                                    icon: 'success'
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        });
                    }
                });
            });
        }

        function deleteMenu(menuId) {
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
                        url: '/menus/' + menuId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Menu has been deleted successfully.',
                                icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        }

        async function viewMenuItems(menuId) {
            window.location.href = '/menu-items/' + menuId;
        }
    </script>
@endpush
