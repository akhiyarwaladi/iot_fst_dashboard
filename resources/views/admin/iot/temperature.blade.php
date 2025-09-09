@extends('adminlte::page')

@section('title', 'Temperature Monitoring - IoT FST Dashboard')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-thermometer-half mr-2 text-danger"></i>
                        Temperature Monitoring
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">IoT Management</li>
                        <li class="breadcrumb-item active">Temperature</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Current Temperature -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="currentTemp">28.5°C</h3>
                    <p>Current Temperature</p>
                </div>
                <div class="icon">
                    <i class="fas fa-thermometer-half"></i>
                </div>
                <div class="small-box-footer">
                    <span class="text-sm">Last updated: <span id="lastUpdate">Just now</span></span>
                </div>
            </div>
        </div>

        <!-- Average Temperature -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 id="avgTemp">26.8°C</h3>
                    <p>24h Average</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="small-box-footer">
                    <span class="text-sm">Calculated from 288 readings</span>
                </div>
            </div>
        </div>

        <!-- Max Temperature -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="maxTemp">32.1°C</h3>
                    <p>Today's Maximum</p>
                </div>
                <div class="icon">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <div class="small-box-footer">
                    <span class="text-sm">Recorded at 14:30</span>
                </div>
            </div>
        </div>

        <!-- Min Temperature -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="minTemp">22.3°C</h3>
                    <p>Today's Minimum</p>
                </div>
                <div class="icon">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <div class="small-box-footer">
                    <span class="text-sm">Recorded at 05:45</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Temperature Chart -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-area mr-2"></i>
                        Temperature Trends (24 Hours)
                    </h3>
                    <div class="card-tools">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary active" onclick="changeTimeRange('24h')">24h</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="changeTimeRange('7d')">7d</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="changeTimeRange('30d')">30d</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary ml-2" onclick="refreshChart()">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="temperatureChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Temperature Alerts -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Temperature Alerts
                    </h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-thermometer-three-quarters mr-1"></i>High Temperature Warning</h6>
                        <p class="mb-2">Temperature above 30°C detected at Sensor #2</p>
                        <small class="text-muted">2 minutes ago</small>
                    </div>
                    
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle mr-1"></i>Normal Range Restored</h6>
                        <p class="mb-2">All sensors back within normal operating range</p>
                        <small class="text-muted">15 minutes ago</small>
                    </div>
                    
                    <div class="text-center mt-3">
                        <button class="btn btn-outline-primary btn-sm" onclick="configureAlerts()">
                            <i class="fas fa-cog mr-1"></i>Configure Alerts
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sensor Status -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-microchip mr-2"></i>
                        Temperature Sensors
                    </h3>
                </div>
                <div class="card-body">
                    <div class="sensor-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">DHT22 Sensor #1</h6>
                                <small class="text-muted">Indoor - Living Room</small>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-success">28.5°C</span>
                                <br>
                                <small class="text-success">Online</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="sensor-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">DS18B20 #2</h6>
                                <small class="text-muted">Outdoor - Garden</small>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-warning">31.2°C</span>
                                <br>
                                <small class="text-success">Online</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="sensor-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">BME280 #3</h6>
                                <small class="text-muted">Basement - Storage</small>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-info">24.1°C</span>
                                <br>
                                <small class="text-success">Online</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="sensor-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">LM35 #4</h6>
                                <small class="text-muted">Server Room</small>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-secondary">--</span>
                                <br>
                                <small class="text-danger">Offline</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- Temperature History Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-2"></i>
                        Recent Temperature Readings
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" onclick="exportData()">
                            <i class="fas fa-download mr-1"></i>Export Data
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="temperatureTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Timestamp</th>
                                    <th>Sensor</th>
                                    <th>Location</th>
                                    <th>Temperature (°C)</th>
                                    <th>Humidity (%)</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ now()->format('Y-m-d H:i:s') }}</td>
                                    <td>DHT22 #1</td>
                                    <td>Living Room</td>
                                    <td><span class="badge badge-success">28.5</span></td>
                                    <td>65%</td>
                                    <td><i class="fas fa-circle text-success"></i> Normal</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info" onclick="viewDetails(1)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ now()->subMinutes(5)->format('Y-m-d H:i:s') }}</td>
                                    <td>DS18B20 #2</td>
                                    <td>Garden</td>
                                    <td><span class="badge badge-warning">31.2</span></td>
                                    <td>--</td>
                                    <td><i class="fas fa-circle text-warning"></i> High</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info" onclick="viewDetails(2)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ now()->subMinutes(10)->format('Y-m-d H:i:s') }}</td>
                                    <td>BME280 #3</td>
                                    <td>Basement</td>
                                    <td><span class="badge badge-info">24.1</span></td>
                                    <td>72%</td>
                                    <td><i class="fas fa-circle text-info"></i> Low</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info" onclick="viewDetails(3)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ now()->subMinutes(15)->format('Y-m-d H:i:s') }}</td>
                                    <td>LM35 #4</td>
                                    <td>Server Room</td>
                                    <td><span class="badge badge-secondary">--</span></td>
                                    <td>--</td>
                                    <td><i class="fas fa-circle text-danger"></i> Offline</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-warning" onclick="troubleshoot(4)">
                                            <i class="fas fa-wrench"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .sensor-item {
            padding: 0.75rem;
            background-color: #f8f9fa;
            border-radius: 0.375rem;
            border-left: 4px solid #007bff;
        }
        
        .sensor-item:hover {
            background-color: #e9ecef;
            transition: background-color 0.2s;
        }
        
        .badge {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
        }
        
        .alert {
            border-radius: 0.5rem;
            border: none;
        }
        
        .small-box {
            border-radius: 0.5rem;
        }
        
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            border-radius: 0.5rem;
        }
    </style>
@stop

@section('plugins.Sweetalert2', true)
@section('plugins.Datatables', true)

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let temperatureChart;
        
        $(document).ready(function() {
            // Initialize DataTable
            $('#temperatureTable').DataTable({
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                order: [[ 0, "desc" ]],
                pageLength: 10
            });
            
            // Initialize temperature chart
            initTemperatureChart();
            
            // Start real-time updates
            startRealTimeUpdates();
        });
        
        function initTemperatureChart() {
            const ctx = document.getElementById('temperatureChart').getContext('2d');
            
            // Sample data for last 24 hours
            const labels = [];
            const data = [];
            const now = new Date();
            
            for (let i = 23; i >= 0; i--) {
                const time = new Date(now.getTime() - (i * 60 * 60 * 1000));
                labels.push(time.getHours() + ':00');
                data.push(Math.random() * 10 + 25); // Random temp between 25-35°C
            }
            
            temperatureChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Temperature (°C)',
                        data: data,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Optimal Range',
                        data: Array(24).fill(27),
                        borderColor: 'rgb(255, 205, 86)',
                        backgroundColor: 'rgba(255, 205, 86, 0.1)',
                        borderDash: [5, 5],
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 20,
                            max: 40,
                            title: {
                                display: true,
                                text: 'Temperature (°C)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Time'
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Temperature Monitoring - Last 24 Hours'
                        },
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });
        }
        
        function changeTimeRange(range) {
            // Update chart based on time range
            document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            let title = '';
            switch(range) {
                case '24h':
                    title = 'Temperature Monitoring - Last 24 Hours';
                    break;
                case '7d':
                    title = 'Temperature Monitoring - Last 7 Days';
                    break;
                case '30d':
                    title = 'Temperature Monitoring - Last 30 Days';
                    break;
            }
            
            temperatureChart.options.plugins.title.text = title;
            temperatureChart.update();
            
            Swal.fire({
                type: 'info',
                title: 'Time Range Updated',
                text: `Chart updated to show ${range} data`,
                timer: 1500,
                showConfirmButton: false
            });
        }
        
        function refreshChart() {
            // Simulate data refresh
            temperatureChart.data.datasets[0].data = temperatureChart.data.datasets[0].data.map(() => 
                Math.random() * 10 + 25
            );
            temperatureChart.update();
            
            Swal.fire({
                type: 'success',
                title: 'Data Refreshed',
                text: 'Temperature chart updated with latest data',
                timer: 1500,
                showConfirmButton: false
            });
        }
        
        function startRealTimeUpdates() {
            setInterval(() => {
                // Update current temperature
                const currentTemp = (Math.random() * 10 + 25).toFixed(1);
                document.getElementById('currentTemp').textContent = currentTemp + '°C';
                document.getElementById('lastUpdate').textContent = 'Just now';
                
                // Update chart with new data point
                const newData = parseFloat(currentTemp);
                temperatureChart.data.datasets[0].data.push(newData);
                temperatureChart.data.datasets[0].data.shift();
                
                const now = new Date();
                temperatureChart.data.labels.push(now.getHours() + ':' + String(now.getMinutes()).padStart(2, '0'));
                temperatureChart.data.labels.shift();
                
                temperatureChart.update('none');
            }, 30000); // Update every 30 seconds
        }
        
        function configureAlerts() {
            Swal.fire({
                title: 'Temperature Alert Configuration',
                html: `
                    <div class="text-left">
                        <div class="form-group mb-3">
                            <label>High Temperature Threshold (°C):</label>
                            <input type="number" class="form-control" id="highTemp" value="30" step="0.1">
                        </div>
                        <div class="form-group mb-3">
                            <label>Low Temperature Threshold (°C):</label>
                            <input type="number" class="form-control" id="lowTemp" value="20" step="0.1">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="emailAlerts" checked>
                            <label class="form-check-label" for="emailAlerts">
                                Send email alerts
                            </label>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Save Settings',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    return {
                        high: document.getElementById('highTemp').value,
                        low: document.getElementById('lowTemp').value,
                        email: document.getElementById('emailAlerts').checked
                    }
                }
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        type: 'success',
                        title: 'Alerts Configured',
                        text: `Thresholds set: High=${result.value.high}°C, Low=${result.value.low}°C`,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }
        
        function exportData() {
            Swal.fire({
                title: 'Export Temperature Data',
                text: 'Choose export format:',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'CSV Format',
                denyButtonText: 'JSON Format',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Simulate CSV export
                    Swal.fire({
                        type: 'success',
                        title: 'CSV Export Started',
                        text: 'Temperature data is being exported to CSV file...',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else if (result.isDenied) {
                    // Simulate JSON export
                    Swal.fire({
                        type: 'success',
                        title: 'JSON Export Started',
                        text: 'Temperature data is being exported to JSON file...',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }
        
        function viewDetails(sensorId) {
            Swal.fire({
                title: `Sensor #${sensorId} Details`,
                html: `
                    <div class="text-left">
                        <p><strong>Sensor Type:</strong> DHT22</p>
                        <p><strong>Location:</strong> Living Room</p>
                        <p><strong>Current Temperature:</strong> 28.5°C</p>
                        <p><strong>Current Humidity:</strong> 65%</p>
                        <p><strong>Last Update:</strong> Just now</p>
                        <p><strong>Status:</strong> <span class="badge badge-success">Online</span></p>
                        <p><strong>Uptime:</strong> 15 days, 8 hours</p>
                    </div>
                `,
                confirmButtonText: 'Close'
            });
        }
        
        function troubleshoot(sensorId) {
            Swal.fire({
                title: 'Sensor Troubleshooting',
                text: `Attempting to reconnect to Sensor #${sensorId}...`,
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            
            setTimeout(() => {
                Swal.fire({
                    type: 'warning',
                    title: 'Connection Failed',
                    text: 'Unable to restore connection. Please check sensor hardware and wiring.',
                    confirmButtonText: 'OK'
                });
            }, 3000);
        }
    </script>
@stop