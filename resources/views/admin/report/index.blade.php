@extends('layouts.app')

                        @section('content')
                            <div class="content-wrapper">
                                <div class="container-xxl flex-grow-1 container-p-y">
                                    <!-- Generate Report Section -->


                                    <!-- Stats Cards -->
                                    <div class="row mb-4">
                                        <div class="col-sm-6 col-lg-4 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h5 class="card-title mb-1 text-muted">Total Confirmed Reservations</h5>
                                                            <h2 class="mb-0" id="totalReservations">0</h2>
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
                                                            <h2 class="mb-0" id="totalSales">₱0.00</h2>
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
                                                            <h2 class="mb-0" id="totalClients">0</h2>
                                                        </div>
                                                        <div class="avatar bg-light-info p-2">
                                                            <img src="{{asset('dashboard/assets/img/icons/unicons/paypal.png')}}" alt="Credit Card" width="40" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bar Chart -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                                        <h5 class="card-title mb-0">Weekly Report</h5>
                                                        <div class="d-flex align-items-center">
                                                            <label for="chartReportType" class="form-label me-2 mb-0">Filter By:</label>
                                                            <select class="form-select form-select-sm" id="chartReportType" style="width: auto;">
                                                                <option value="today">Today</option>
                                                                <option value="weekly" selected>Weekly</option>
                                                                <option value="monthly">Monthly</option>
                                                                <option value="semi-annual">Semi-Annual</option>
                                                                <option value="annual">Annual</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <canvas id="reportChart" width="400" height="200"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="card-title mb-4">Generate Report</h4>
                                                    <form id="reportForm">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="reportType" class="form-label">Report Type</label>
                                                            <select class="form-select" id="reportType" name="type" required>
                                                                <option value="today">Today</option>
                                                                <option value="weekly">Weekly</option>
                                                                <option value="monthly">Monthly</option>
                                                                <option value="semi-annual">Semi-Annual</option>
                                                                <option value="annual">Annual</option>
                                                            </select>
                                                        </div>
                                                        <button type="button" id="generateButton" class="btn btn-primary">Generate</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-backdrop fade"></div>
                            </div>

                            <!-- Include Chart.js via CDN -->
                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                            <!-- JavaScript to fetch data and render the chart -->
                            <script>
                                let chartInstance = null;

                                async function fetchReportData(type) {
                                    const response = await fetch(`/report/data/${type}`);
                                    const data = await response.json();
                                    return data;
                                }

                                async function updateStats(type) {
                                    try {
                                        // Show loading indicator for stats cards
                                        document.getElementById('totalReservations').style.opacity = 0.5;
                                        document.getElementById('totalSales').style.opacity = 0.5;
                                        document.getElementById('totalClients').style.opacity = 0.5;

                                        const data = await fetchReportData(type);

                                        // Update the stats cards
                                        document.getElementById('totalReservations').textContent = data.stats.reservations;
                                        document.getElementById('totalSales').textContent = '₱' + parseFloat(data.stats.totalRevenue).toLocaleString('en-US', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        });
                                        document.getElementById('totalClients').textContent = data.stats.clients;

                                        // Remove loading indicator
                                        document.getElementById('totalReservations').style.opacity = 1;
                                        document.getElementById('totalSales').style.opacity = 1;
                                        document.getElementById('totalClients').style.opacity = 1;
                                    } catch (error) {
                                        console.error('Error updating stats:', error);
                                        document.getElementById('totalReservations').style.opacity = 1;
                                        document.getElementById('totalSales').style.opacity = 1;
                                        document.getElementById('totalClients').style.opacity = 1;
                                    }
                                }

                                async function renderChart(type = 'weekly') {
                                    try {
                                        // Show loading indicator
                                        document.getElementById('reportChart').style.opacity = 0.5;

                                        const data = await fetchReportData(type);
                                        const reportData = data.payments;
                                        const labels = reportData.map(payment => new Date(payment.created_at).toLocaleDateString());
                                        const totals = reportData.map(payment => payment.total);

                                        // Update stats cards
                                        updateStats(type);

                                        const ctx = document.getElementById('reportChart').getContext('2d');

                                        // Destroy existing chart if it exists
                                        if (chartInstance) {
                                            chartInstance.destroy();
                                        }

                                        // Update the chart title based on the selected type
                                        const chartTitle = document.querySelector('.card-title');
                                        if (chartTitle) {
                                            chartTitle.textContent = type.charAt(0).toUpperCase() + type.slice(1) + ' Report';
                                        }

                                        // Create new chart
                                        chartInstance = new Chart(ctx, {
                                            type: 'bar',
                                            data: {
                                                labels: labels,
                                                datasets: [{
                                                    label: 'Total Payments',
                                                    data: totals,
                                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                    borderColor: 'rgba(75, 192, 192, 1)',
                                                    borderWidth: 1
                                                }]
                                            },
                                            options: {
                                                responsive: true,
                                                scales: {
                                                    y: {
                                                        beginAtZero: true,
                                                        title: {
                                                            display: true,
                                                            text: 'Amount (₱)'
                                                        }
                                                    },
                                                    x: {
                                                        title: {
                                                            display: true,
                                                            text: 'Date'
                                                        }
                                                    }
                                                },
                                                plugins: {
                                                    tooltip: {
                                                        callbacks: {
                                                            label: function(context) {
                                                                return '₱' + parseFloat(context.raw).toLocaleString('en-US', {
                                                                    minimumFractionDigits: 2,
                                                                    maximumFractionDigits: 2
                                                                });
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        });

                                        // Remove loading indicator
                                        document.getElementById('reportChart').style.opacity = 1;
                                    } catch (error) {
                                        console.error('Error rendering chart:', error);
                                        document.getElementById('reportChart').style.opacity = 1;
                                    }
                                }

                                document.addEventListener('DOMContentLoaded', function() {
                                    // Add event listener to the chart filter
                                    document.getElementById('chartReportType').addEventListener('change', function() {
                                        // Only update the chart and stats, not the report generator
                                        renderChart(this.value);
                                    });

                                    // Add event listener to the report generator
                                    document.getElementById('generateButton').addEventListener('click', function() {
                                        const reportType = document.getElementById('reportType').value;
                                        if (reportType) {
                                            window.location.href = `/report/${reportType}`;
                                        } else {
                                            alert('Please select a report type');
                                        }
                                    });

                                    // Initial chart render
                                    renderChart('weekly');
                                });
                            </script>
                        @endsection
