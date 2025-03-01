@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Welcome Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-primary text-white">
                        <div class="d-flex align-items-center">
                            <div class="card-body">
                                <h4 class="card-title text-white mb-0">Welcome back, {{auth()->user()->name}}!</h4>
{{--                                <p class="mb-2">Your performance today is 72% higher than yesterday</p>--}}
{{--                                <a href="javascript:;" class="btn btn-sm btn-light">View Achievements</a>--}}
                            </div>
                            <div class="px-4 d-none d-md-block">
                                <img src="{{asset('dashboard/assets/img/illustrations/man-with-laptop-light.png')}}"
                                     height="140" alt="View Badge User" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-sm-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title mb-1 text-muted">Total Reservations</h5>
                                    <h2 class="mb-0">{{$countReservation}}</h2>
                                </div>
                                <div class="avatar bg-light-primary p-2">
                                    <img src="{{asset('dashboard/assets/img/icons/unicons/chart-success.png')}}" alt="chart success" width="40" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title mb-1 text-muted">Total Sales</h5>
                                    <h2 class="mb-0">₱{{$totalRevenue}}</h2>
                                </div>
                                <div class="avatar bg-light-success p-2">
                                    <img src="{{asset('dashboard/assets/img/icons/unicons/wallet-info.png')}}" alt="Credit Card" width="40" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title mb-1 text-muted">Total Clients</h5>
                                    <h2 class="mb-0">{{$countClients}}</h2>
                                </div>
                                <div class="avatar bg-light-info p-2">
                                    <img src="{{asset('dashboard/assets/img/icons/unicons/paypal.png')}}" alt="Credit Card" width="40" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Tables -->
            <div class="row">
                <!-- Order Statistics -->
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title m-0">Top Category Events</h5>
                                <small class="text-muted">Most Reservations</small>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="orderStats" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-4">
                                <div class="d-flex flex-column">
                                    <h2 class="mb-1">Top 4</h2>
                                    <span class="text-muted">Category Events</span>
                                </div>
                                <div id="orderStatisticsChart"></div>
                            </div>

                            <div class="order-categories">
                                @foreach($topCategoryEvents as $event)
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="badge bg-label-primary p-2 me-3"><i class="bx bx-category"></i></div>
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <div>
                                                <h6 class="mb-0">{{ $event->name }}</h6>
                                                <small class="text-muted">{{ $event->reservation_count }} Reservations</small>
                                            </div>
                                            <span class="fw-semibold">{{ $event->reservation_count }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="col-lg-8 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title m-0">Recent Transactions</h5>
{{--                            <div class="dropdown">--}}
{{--                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="transactionTime" data-bs-toggle="dropdown">--}}
{{--                                    <i class="bx bx-calendar me-1"></i> Last 30 Days--}}
{{--                                </button>--}}
{{--                                <div class="dropdown-menu dropdown-menu-end">--}}
{{--                                    <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>--}}
{{--                                    <a class="dropdown-item" href="javascript:void(0);">Last Month</a>--}}
{{--                                    <a class="dropdown-item" href="javascript:void(0);">Last Year</a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($recentPayments as $payment)
                                        <tr>

                                            <td>₱{{ number_format($payment->total, 2) }}</td>
                                            <td>{{ $payment->created_at->format('M d, Y') }}</td>
                                            <td><span class="badge bg-label-{{ $payment->status == 'completed' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($payment->status) }}</span></td>
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
        <div class="content-backdrop fade"></div>
    </div>
@endsection


@push('scripts')

   <script>
    const chartOrderStatistics = document.querySelector('#orderStatisticsChart'),
        orderChartConfig = {
            chart: {
                height: 165,
                width: 130,
                type: 'donut'
            },
            labels: @json($eventNames),
            series: @json($reservationCounts),
            colors: [config.colors.primary, config.colors.secondary, config.colors.info, config.colors.success],
            stroke: {
                width: 5,
                colors: cardColor
            },
            dataLabels: {
                enabled: false,
                formatter: function (val, opt) {
                    return parseInt(val) + '%';
                }
            },
            legend: {
                show: false
            },
            grid: {
                padding: {
                    top: 0,
                    bottom: 0,
                    right: 15
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            value: {
                                fontSize: '1.5rem',
                                fontFamily: 'Public Sans',
                                color: headingColor,
                                offsetY: -15,
                                formatter: function (val) {
                                    return parseInt(val) + '%';
                                }
                            },
                            name: {
                                offsetY: 20,
                                fontFamily: 'Public Sans'
                            },
                            total: {
                                show: true,
                                fontSize: '0.8125rem',
                                color: axisColor,
                                label: 'Weekly',
                                formatter: function (w) {
                                    return '38%';
                                }
                            }
                        }
                    }
                }
            }
        };
    if (typeof chartOrderStatistics !== undefined && chartOrderStatistics !== null) {
        const statisticsChart = new ApexCharts(chartOrderStatistics, orderChartConfig);
        statisticsChart.render();
    }
</script>
@endpush
