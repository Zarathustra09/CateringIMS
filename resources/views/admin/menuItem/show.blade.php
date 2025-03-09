@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Menu Items</h2>
                <button type="button" class="btn btn-primary" onclick="createMenuItem()">
                    <span class="tf-icons bx bx-plus"></span>&nbsp; Add Menu Item
                </button>
            </div>
            <div class="card-body">
                <table id="menuItemTable" class="table table-hover table-striped">
                    <thead class="thead-light">
                    <tr>
{{--                        <th>ID</th>--}}
                        <th>Menu</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Is Available</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($menuItems as $menuItem)
                        <tr>
{{--                            <td>{{ $menuItem->id }}</td>--}}
                            <td>{{ $menuItem->menu->name }}</td>
                            <td>{{ $menuItem->name }}</td>
                            <td>{{ $menuItem->description }}</td>
                            <td>{{ $menuItem->price }}</td>
                            <td>{{ $menuItem->is_available ? 'Yes' : 'No' }}</td>
                            <td><img src="{{ asset('storage/' . $menuItem->image) }}" alt="{{ $menuItem->name }}" width="50"></td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editMenuItem({{ $menuItem->id }})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteMenuItem({{ $menuItem->id }})">Delete</button>
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
            $('#menuItemTable').DataTable();
        });

        async function createMenuItem() {
            await Swal.fire({
                title: 'Create Menu Item',
                html: `
          <input id="swal-input1" type="hidden" value="{{ $menu_id }}" readonly>
            <input id="swal-input2" class="swal2-input" placeholder="Name">
            <textarea id="swal-input3" class="swal2-textarea" placeholder="Description"></textarea>
            <input id="swal-input4" class="swal2-input" placeholder="Price">
            <label for="swal-input5">Is Available</label>
            <input type="checkbox" id="swal-input5" class="swal2-checkbox">
            <input type="file" id="swal-input6" class="swal2-file" placeholder="Image">
        `,
                showConfirmButton: true,
                confirmButtonText: 'Create',
                showCloseButton: true,
                preConfirm: () => {
                    const fileInput = document.getElementById('swal-input6');
                    const file = fileInput.files[0];
                    return {
                        menu_id: document.getElementById('swal-input1').value,
                        name: document.getElementById('swal-input2').value,
                        description: document.getElementById('swal-input3').value,
                        price: document.getElementById('swal-input4').value,
                        is_available: document.getElementById('swal-input5').checked,
                        image: file
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    storeMenuItem(result.value);
                }
            });
        }

        function storeMenuItem(data) {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('menu_id', data.menu_id);
            formData.append('name', data.name);
            formData.append('description', data.description);
            formData.append('price', data.price);
            formData.append('is_available', data.is_available);
            formData.append('image', data.image);

            $.ajax({
                url: '{{ route("menu-items.store") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        title: 'Created!',
                        text: 'Menu Item has been created successfully.',
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(response) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error creating the menu item.',
                        icon: 'error'
                    });
                }
            });
        }

        async function editMenuItem(menuItemId) {
            $.get('/menu-items/showSingle/' + menuItemId, function(menuItem) {
                Swal.fire({
                    title: 'Edit Menu Item',
                    html: `
                        <input id="swal-input1" type="hidden" class="swal2-input" value="${menuItem.menu_id}" placeholder="Menu ID">
                        <input id="swal-input2" class="swal2-input" value="${menuItem.name}" placeholder="Name">
                        <textarea id="swal-input3" class="swal2-textarea" placeholder="Description">${menuItem.description}</textarea>
                        <input id="swal-input4" class="swal2-input" value="${menuItem.price}" placeholder="Price">
                        <label for="swal-input5">Is Available</label>
                        <input type="checkbox" id="swal-input5" class="swal2-checkbox" ${menuItem.is_available ? 'checked' : ''}>
                        <input type="file" id="swal-input6" class="swal2-file" placeholder="Image">
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const fileInput = document.getElementById('swal-input6');
                        const file = fileInput.files[0];
                        return {
                            menu_id: document.getElementById('swal-input1').value,
                            name: document.getElementById('swal-input2').value,
                            description: document.getElementById('swal-input3').value,
                            price: document.getElementById('swal-input4').value,
                            is_available: document.getElementById('swal-input5').checked,
                            image: file
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateMenuItem(menuItemId, result.value);
                    }
                });
            });
        }

        function updateMenuItem(menuItemId, data) {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'PUT');
            formData.append('menu_id', data.menu_id);
            formData.append('name', data.name);
            formData.append('description', data.description);
            formData.append('price', data.price);
            formData.append('is_available', data.is_available);
            if (data.image) {
                formData.append('image', data.image);
            }

            $.ajax({
                url: '/menu-items/' + menuItemId,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        title: 'Updated!',
                        text: 'Menu Item has been updated successfully.',
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(response) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error updating the menu item.',
                        icon: 'error'
                    });
                }
            });
        }

        function deleteMenuItem(menuItemId) {
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
                        url: '/menu-items/' + menuItemId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Menu Item has been deleted successfully.',
                                icon: 'success'
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
