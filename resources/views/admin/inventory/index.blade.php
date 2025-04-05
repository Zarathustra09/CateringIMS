@extends('layouts.app')

@section('content')
    <!-- Only show the warning message if there are inventories with quantity <= 10 -->
    @php
        $lowStockItems = $inventories->where('quantity', '<=', 10);
    @endphp

    @if($lowStockItems->count() > 0)
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="alert alert-warning" role="alert">
                <strong>Warning:</strong> The following inventory items have a quantity less than or equal to 10:
                <ul>
                    @foreach($lowStockItems as $inventory)
                        <li>{{ $inventory->name }} ({{ $inventory->quantity }})</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Inventories</h2>
                <button type="button" class="btn btn-primary" onclick="createInventory()">
                    <span class="tf-icons bx bx-plus"></span>&nbsp; Add Inventory
                </button>
            </div>
            <div class="card-body">
                <table id="inventoryTable" class="table table-hover table-striped">
                    <thead class="thead-light">
                    <tr>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($inventories as $inventory)
                        <tr>
                            <td>{{ $inventory->category->name }}</td>
                            <td>{{ $inventory->name }}</td>
                            <td>{{ $inventory->quantity }}</td>
                            <td>{{ $inventory->description }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="viewInventory({{ $inventory->id }})">View</button>
                                <button class="btn btn-warning btn-sm" onclick="editInventory({{ $inventory->id }})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteInventory({{ $inventory->id }})">Delete</button>
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
            $('#inventoryTable').DataTable();
        });

        async function createInventory() {
            let categories = await fetchCategories();
            let categoryOptions = categories.map(category => `<option value="${category.id}">${category.name}</option>`).join('');

            await Swal.fire({
                title: 'Create Inventory',
                html: `
                    <select id="swal-input1" class="swal2-input">
                        ${categoryOptions}
                    </select>
                    <input id="swal-input2" class="swal2-input" placeholder="Name">
                    <input id="swal-input3" class="swal2-input" placeholder="Quantity">
                    <input id="swal-input4" class="swal2-input" placeholder="Description">
                `,
                showConfirmButton: true,
                confirmButtonText: 'Create',
                showCloseButton: true,
                customClass: {
                    container: 'my-custom-container-class',
                    popup: 'my-custom-popup-class',
                    header: 'my-custom-header-class',
                    title: 'my-custom-title-class',
                    closeButton: 'my-custom-close-button-class',
                    icon: 'my-custom-icon-class',
                    htmlContainer: 'my-custom-html-container-class',
                    input: 'my-custom-input-class',
                    inputLabel: 'my-custom-input-label-class',
                    actions: 'my-custom-actions-class',
                    confirmButton: 'my-custom-confirm-button-class',
                    cancelButton: 'my-custom-cancel-button-class'
                },
                preConfirm: () => {
                    return {
                        category_id: document.getElementById('swal-input1').value,
                        name: document.getElementById('swal-input2').value,
                        quantity: document.getElementById('swal-input3').value,
                        description: document.getElementById('swal-input4').value
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    storeInventory(result.value);
                }
            });
        }

        function storeInventory(data) {
            $.ajax({
                url: '/admin/inventory',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ...data
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Created!',
                        text: 'Inventory has been created successfully.',
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
                            text: 'There was an error creating the inventory.',
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

        async function editInventory(inventoryId) {
            let categories = await fetchCategories();
            let categoryOptions = categories.map(category => `<option value="${category.id}">${category.name}</option>`).join('');

            $.get('/admin/inventory/' + inventoryId, function(inventory) {
                let selectedCategoryOptions = categories.map(category => {
                    return `<option value="${category.id}" ${category.id === inventory.category_id ? 'selected' : ''}>${category.name}</option>`;
                }).join('');

                Swal.fire({
                    title: 'Edit Inventory',
                    html: `
                        <select id="swal-input1" class="swal2-input">
                            ${selectedCategoryOptions}
                        </select>
                        <input id="swal-input2" class="swal2-input" value="${inventory.name}" placeholder="Name">
                        <input id="swal-input3" class="swal2-input" value="${inventory.quantity}" placeholder="Quantity">
                        <input id="swal-input4" class="swal2-input" value="${inventory.description}" placeholder="Description">
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        container: 'my-custom-container-class',
                        popup: 'my-custom-popup-class',
                        header: 'my-custom-header-class',
                        title: 'my-custom-title-class',
                        closeButton: 'my-custom-close-button-class',
                        icon: 'my-custom-icon-class',
                        htmlContainer: 'my-custom-html-container-class',
                        input: 'my-custom-input-class',
                        inputLabel: 'my-custom-input-label-class',
                        actions: 'my-custom-actions-class',
                        confirmButton: 'my-custom-confirm-button-class',
                        cancelButton: 'my-custom-cancel-button-class'
                    },
                    preConfirm: () => {
                        return {
                            category_id: document.getElementById('swal-input1').value,
                            name: document.getElementById('swal-input2').value,
                            quantity: document.getElementById('swal-input3').value,
                            description: document.getElementById('swal-input4').value
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/inventory/' + inventoryId,
                            type: 'PUT',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ...result.value
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Updated!',
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
            });
        }

        function deleteInventory(inventoryId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    container: 'my-custom-container-class',
                    popup: 'my-custom-popup-class',
                    header: 'my-custom-header-class',
                    title: 'my-custom-title-class',
                    closeButton: 'my-custom-close-button-class',
                    icon: 'my-custom-icon-class',
                    htmlContainer: 'my-custom-html-container-class',
                    input: 'my-custom-input-class',
                    inputLabel: 'my-custom-input-label-class',
                    actions: 'my-custom-actions-class',
                    confirmButton: 'my-custom-confirm-button-class',
                    cancelButton: 'my-custom-cancel-button-class'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/inventory/' + inventoryId,
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

        async function fetchCategories() {
            let response = await fetch('{{ route('admin.category.list') }}');
            return await response.json();
        }

        async function viewInventory(inventoryId) {
            $.get('/admin/inventory/' + inventoryId, function(inventory) {
                if (inventory && inventory.category) {
                    Swal.fire({
                        title: 'Inventory Details',
                        html: `<p>Category: ${inventory.category.name}</p>
                               <p>Name: ${inventory.name}</p>
                               <p>Quantity: ${inventory.quantity}</p>
                               <p>Description: ${inventory.description}</p>`,
                        icon: 'info',
                        customClass: {
                            container: 'my-custom-container-class',
                            popup: 'my-custom-popup-class',
                            header: 'my-custom-header-class',
                            title: 'my-custom-title-class',
                            closeButton: 'my-custom-close-button-class',
                            icon: 'my-custom-icon-class',
                            htmlContainer: 'my-custom-html-container-class',
                            input: 'my-custom-input-class',
                            inputLabel: 'my-custom-input-label-class',
                            actions: 'my-custom-actions-class',
                            confirmButton: 'my-custom-confirm-button-class',
                            cancelButton: 'my-custom-cancel-button-class'
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Inventory details could not be loaded.',
                        icon: 'error',
                        customClass: {
                            container: 'my-custom-container-class',
                            popup: 'my-custom-popup-class',
                            header: 'my-custom-header-class',
                            title: 'my-custom-title-class',
                            closeButton: 'my-custom-close-button-class',
                            icon: 'my-custom-icon-class',
                            htmlContainer: 'my-custom-html-container-class',
                            input: 'my-custom-input-class',
                            inputLabel: 'my-custom-input-label-class',
                            actions: 'my-custom-actions-class',
                            confirmButton: 'my-custom-confirm-button-class',
                            cancelButton: 'my-custom-cancel-button-class'
                        }
                    });
                }
            }).fail(function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to fetch inventory details.',
                    icon: 'error',
                    customClass: {
                        container: 'my-custom-container-class',
                        popup: 'my-custom-popup-class',
                        header: 'my-custom-header-class',
                        title: 'my-custom-title-class',
                        closeButton: 'my-custom-close-button-class',
                        icon: 'my-custom-icon-class',
                        htmlContainer: 'my-custom-html-container-class',
                        input: 'my-custom-input-class',
                        inputLabel: 'my-custom-input-label-class',
                        actions: 'my-custom-actions-class',
                        confirmButton: 'my-custom-confirm-button-class',
                        cancelButton: 'my-custom-cancel-button-class'
                    }
                });
            });
        }
    </script>
@endpush
