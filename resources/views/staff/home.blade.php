@extends('layouts.staff.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-primary text-white">
                        <div class="d-flex align-items-center">
                            <div class="card-body">
                                <h4 class="card-title text-white mb-0">Welcome back, {{ auth()->user()->name }}!</h4>
                            </div>
                            <div class="px-4 d-none d-md-block">
                                <img src="{{ asset('dashboard/assets/img/illustrations/man-with-laptop-light.png') }}" height="140" alt="Welcome Image" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

              <!-- Stats Cards -->
              <div class="row mb-4">
                <!-- Assigned Reservations -->
                <div class="col-sm-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title mb-1 text-muted">Your Assigned Reservations</h5>
                                    <h2 class="mb-0">{{ $countAssignedReservations }}</h2>
                                </div>
                                <div class="avatar bg-light-primary p-2">
                                    <img src="{{ asset('dashboard/assets/img/icons/unicons/chart-success.png') }}" alt="assigned reservations icon" width="40" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Finished Reservations -->
                <div class="col-sm-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title mb-1 text-muted">Finished Reservations</h5>
                                    <h2 class="mb-0">{{ $countFinishedReservations }}</h2>
                                </div>
                                <div class="avatar bg-light-success p-2">
                                    <img src="{{ asset('dashboard/assets/img/icons/unicons/cc-warning.png') }}" alt="finished reservations icon" width="40" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Days as Employee -->
                <div class="col-sm-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title mb-1 text-muted">Days as Employee</h5>
                                    <h2 class="mb-0">{{ $daysAsEmployee }}</h2>
                                </div>
                                <div class="avatar bg-light-info p-2">
                                    <img src="{{ asset('dashboard/assets/img/icons/unicons/1.png') }}" alt="days as employee icon" width="40" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>
@endsection
