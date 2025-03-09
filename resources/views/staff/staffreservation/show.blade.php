@extends('layouts.staff.app')

@section('content')
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h1 class="h3 mb-0 text-white">Reservation Details</h1>
                    </div>
                    <div class="card-body">
                        <h2 class="h4 text-primary mb-3">{{ $reservation->categoryEvent->name }}</h2>
                        <p class="text-muted mb-3">{{ $reservation->message }}</p>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="card border-info mb-3">
                                    <div class="card-header bg-info text-white">Start Date</div>
                                    <div class="card-body p-2 text-center">
                                        {{ \Carbon\Carbon::parse($reservation->start_date)->format('F d, Y h:i A') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-warning mb-3">
                                    <div class="card-header bg-warning text-white">End Date</div>
                                    <div class="card-body p-2 text-center">
                                        {{ \Carbon\Carbon::parse($reservation->end_date)->format('F d, Y h:i A') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assignees Section (View-Only) -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h3 class="h4 mb-0 text-white">Assignees</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservation->assignees as $assignee)
                                        <tr>
                                            <td>{{ $assignee->user->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Inventory Section (View-Only) -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="h4 mb-0 text-white">Inventory</h3>
                        <span class="badge bg-light text-primary">{{ $reservation->inventories->count() }} Items</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservation->inventories as $inventory)
                                        <tr>
                                            <td>{{ $inventory->name }}</td>
                                            <td>{{ $inventory->pivot->quantity }}</td>
                                            <td>{{ $inventory->description }}</td>
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
