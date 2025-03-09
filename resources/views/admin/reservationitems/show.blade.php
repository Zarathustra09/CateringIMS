@extends('layouts.app')

@section('content')
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h1 class="h3 mb-0 text-white">Reservation Details</h1>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-light text-primary">{{ $reservation->status }}</span>
                            <button class="btn btn-light btn-sm ms-2" onclick="editStatus()" title="Edit Status">
                                <i class="bx bx-edit"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h2 class="h4 text-primary mb-3">{{ $reservation->categoryEvent->name }}</h2>
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

                                <!-- ✅ Mark Attendance Button -->
                                <a href="{{ route('admin.reservation.attendance', $reservation->id) }}" class="btn btn-success">
                                    <i class="fas fa-user-check me-1"></i> Mark Attendance
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assignees Section -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                        <h3 class="h4 mb-0 text-white">Assignees</h3>
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
                        <h3 class="h4 mb-0 text-white">Inventory</h3>
                        <span class="badge bg-light text-primary">{{ $reservation->inventories->count() }} Items</span>
                        <button class="btn btn-sm btn-success" onclick="addInventory()">
                            <i class="fas fa-plus me-1"></i>Add Inventory
                        </button>
                    </div>
                    <div class="card-body">
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
