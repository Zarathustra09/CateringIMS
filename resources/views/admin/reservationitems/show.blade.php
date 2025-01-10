@extends('layouts.app')

@section('content')
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h1 class="h3 mb-0">Reservation Details</h1>
                        <span class="badge bg-light text-primary">{{ $reservation->status }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h2 class="h4 text-primary mb-3">{{ $reservation->event_type }}</h2>
                                <p class="text-muted mb-3">{{ $reservation->message }}</p>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="card border-info mb-3">
                                            <div class="card-header bg-info text-white">Start Date</div>
                                            <div class="card-body p-2">
                                                <p class="card-text text-center">
                                                    {{ \Carbon\Carbon::parse($reservation->start_date)->format('F d, Y h:i A') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border-warning mb-3">
                                            <div class="card-header bg-warning text-white">End Date</div>
                                            <div class="card-body p-2">
                                                <p class="card-text text-center">
                                                    {{ \Carbon\Carbon::parse($reservation->end_date)->format('F d, Y h:i A') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assignees Section -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                        <h3 class="h4 mb-0">Assignees</h3>
                        <button class="btn btn-sm btn-success" onclick="createAssignee()">
                            <i class="fas fa-plus me-1"></i>Add Assignee
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="assigneesTable" class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservation->assignees as $assignee)
                                        <tr>
                                            <td>{{ $assignee->user->name }}</td>
                                            <td>
                                                <button class="btn btn-danger btn-sm" onclick="deleteAssignee({{ $assignee->id }})">
                                                    <i class="fas fa-trash me-1"></i>Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Inventory Section -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="h4 mb-0">Inventory</h3>
                        <span class="badge bg-light text-primary">{{ $reservation->inventories->count() }} Items</span>
                        <button class="btn btn-sm btn-success" onclick="addInventory()">
                            <i class="fas fa-plus me-1"></i>Add Inventory
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="inventoryTable" class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservation->inventories as $inventory)
                                        <tr>
                                            <td>{{ $inventory->name }}</td>
                                            <td>{{ $inventory->pivot->quantity }}</td>
                                            <td>{{ $inventory->description }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" onclick="editInventory({{ $inventory->id }}, {{ $inventory->pivot->quantity }})">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </button>
                                                <button class="btn btn-danger btn-sm" onclick="deleteInventory({{ $inventory->id }})">
                                                    <i class="fas fa-trash me-1"></i>Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#assigneesTable').DataTable();
            $('#inventoryTable').DataTable();
        });

        function createAssignee() {
            let employeeOptions = @json($employees).map(employee => `<option value="${employee.id}">${employee.name}</option>`).join('');
            Swal.fire({
                title: 'Add Assignee',
                html: `
                    <select id="swal-input1" class="swal2-input">
                        ${employeeOptions}
                    </select>
                `,
                showCancelButton: true,
                confirmButtonText: 'Add',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    let formData = new FormData();
                    formData.append('reservation_id', '{{ $reservation->id }}');
                    formData.append('user_id', document.getElementById('swal-input1').value);
                    return formData;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    storeAssignee(result.value);
                }
            });
        }

        function storeAssignee(data) {
            $.ajax({
                url: '{{ route("admin.assignee.store") }}',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        title: 'Added!',
                        text: 'Assignee has been added successfully.',
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(response) {
                    console.error(response);
                    Swal.fire({
                        title: 'Error!',
                        text: response.responseJSON?.message || 'There was an error adding the assignee.',
                        icon: 'error'
                    });
                }
            });
        }

        function deleteAssignee(assigneeId) {
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
                        url: '/admin/assignee/' + assigneeId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Assignee has been deleted successfully.',
                                icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        }

        // For inventory

        async function addInventory() {
            let inventories = await fetchInventories();
            let inventoryOptions = inventories.map(inventory => `<option value="${inventory.id}">${inventory.name} (${inventory.quantity} available)</option>`).join('');

            await Swal.fire({
                title: 'Add Inventory Item',
                html: `
                    <select id="inventorySelect" class="swal2-input">
                        ${inventoryOptions}
                    </select>
                    <input id="inventoryQuantity" class="swal2-input" type="number" placeholder="Quantity" min="1">
                `,
                showCancelButton: true,
                confirmButtonText: 'Add',
                preConfirm: () => {
                    const inventoryId = document.getElementById('inventorySelect').value;
                    const quantity = document.getElementById('inventoryQuantity').value;

                    if (!inventoryId || quantity <= 0) {
                        Swal.showValidationMessage('Please select a valid inventory and quantity.');
                    }
                    return { inventoryId, quantity };
                }
            }).then(result => {
                if (result.isConfirmed) {
                    updateInventory('add', result.value);
                }
            });
        }

        function editInventory(id, currentQuantity) {
            Swal.fire({
                title: 'Edit Inventory Quantity',
                html: `
                    <input id="editQuantity" class="swal2-input" type="number" value="${currentQuantity}" min="1">
                `,
                showCancelButton: true,
                confirmButtonText: 'Update',
                preConfirm: () => {
                    const quantity = document.getElementById('editQuantity').value;
                    if (quantity <= 0) {
                        Swal.showValidationMessage('Quantity must be greater than 0.');
                    }
                    return { id, quantity };
                }
            }).then(result => {
                if (result.isConfirmed) {
                    updateInventory('edit', result.value);
                }
            });
        }

        function deleteInventory(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will remove the inventory from the reservation.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
            }).then(result => {
                if (result.isConfirmed) {
                    updateInventory('delete', { id });
                }
            });
        }

        async function fetchInventories() {
            let response = await fetch('{{ route('admin.inventory.list') }}');
            return response.json();
        }

        async function updateInventory(action, data) {
            const urlMap = {
                add: '{{ route('admin.reservationItems.addInventory', $reservation->id) }}',
                edit: '{{ route('admin.reservationItems.editInventory', $reservation->id) }}',
                delete: '{{ route('admin.reservationItems.deleteInventory', $reservation->id) }}'
            };

            try {
                const response = await fetch(urlMap[action], {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();
                if (response.ok) {
                    Swal.fire('Success', result.message, 'success').then(() => location.reload());
                } else {
                    Swal.fire('Error', result.message, 'error');
                }
            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'Something went wrong.', 'error');
            }
        }
    </script>
@endpush
