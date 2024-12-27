@extends('layouts.guest')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header bg-white border-bottom">
                <h2 class="h4 mb-0">Payment History</h2>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <label class="me-2 mb-0">Show</label>
                            <select class="form-select form-select-sm w-auto">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <label class="ms-2 mb-0">entries</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-md-end">
                            <input type="search" class="form-control form-control-sm w-auto" placeholder="Search...">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                        <tr>
                            <th class="align-middle">ID</th>
                            <th class="align-middle">Reservation ID</th>
                            <th class="align-middle">Invoice ID</th>
                            <th class="align-middle">Status</th>
                            <th class="align-middle">Total</th>
                            <th class="align-middle">Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="align-middle">1</td>
                            <td class="align-middle">#4</td>
                            <td class="align-middle font-monospace">invoice-ZboEp</td>
                            <td class="align-middle">
                                <span class="badge bg-success">Paid</span>
                            </td>
                            <td class="align-middle">₱5,000.00</td>
                            <td class="align-middle">Dec 27, 2024 03:42 AM</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row align-items-center mt-3">
                    <div class="col-md-6">
                        <p class="mb-0">Showing 1 to 1 of 1 entries</p>
                    </div>
                    <div class="col-md-6">
                        <nav class="float-md-end">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#">Previous</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item disabled">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .table th {
                background-color: #f8f9fa;
                font-weight: 600;
            }
            .badge {
                font-weight: 500;
                padding: 0.5em 0.75em;
            }
            .table td {
                padding: 0.75rem;
            }
            .form-select, .form-control {
                border: 1px solid #dee2e6;
            }
            .pagination {
                margin: 0;
            }
            .page-link {
                padding: 0.375rem 0.75rem;
            }
        </style>
    @endpush
@endsection
