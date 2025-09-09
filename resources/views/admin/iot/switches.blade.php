@extends('adminlte::page')

@section('title', 'Smart Switches Control - IoT FST Dashboard')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-toggle-on mr-2 text-success"></i>
                        Smart Switches Control
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">IoT Management</li>
                        <li class="breadcrumb-item active">Switches</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Active Switches -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="activeSwitches">7</h3>
                    <p>Active Switches</p>
                </div>
                <div class="icon">
                    <i class="fas fa-toggle-on"></i>
                </div>
                <div class="small-box-footer">
                    <span class="text-sm">Currently ON</span>
                </div>
            </div>
        </div>

        <!-- Inactive Switches -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3 id="inactiveSwitches">5</h3>
                    <p>Inactive Switches</p>
                </div>
                <div class="icon">
                    <i class="fas fa-toggle-off"></i>
                </div>
                <div class="small-box-footer">
                    <span class="text-sm">Currently OFF</span>
                </div>
            </div>
        </div>

        <!-- Total Power -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 id="totalPower">2.4kW</h3>
                    <p>Total Power</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <div class="small-box-footer">
                    <span class="text-sm">Current consumption</span>
                </div>
            </div>
        </div>

        <!-- Offline Devices -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="offlineDevices">2</h3>
                    <p>Offline Devices</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="small-box-footer">
                    <span class="text-sm">Need attention</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Switch Control Panel -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-sliders-h mr-2"></i>
                        Device Control Panel
                    </h3>
                    <div class="card-tools">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-success" onclick="turnAllOn()">
                                <i class="fas fa-power-off mr-1"></i>All ON
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary" onclick="turnAllOff()">
                                <i class="fas fa-power-off mr-1"></i>All OFF
                            </button>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary ml-2" onclick="refreshDevices()">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Smart Switch Cards -->
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="switch-card">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="switch-icon mb-3">
                                            <i class="fas fa-lightbulb fa-3x text-warning"></i>
                                        </div>
                                        <h5 class="card-title">Living Room Lights</h5>
                                        <p class="card-text text-muted">Main lighting system</p>
                                        <div class="switch-control mb-3">
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="checkbox" class="custom-control-input" id="switch1" checked onchange="toggleSwitch(1, this.checked)">
                                                <label class="custom-control-label" for="switch1"></label>
                                            </div>
                                        </div>
                                        <div class="switch-info">
                                            <small class="text-success">
                                                <i class="fas fa-circle"></i> Online | 180W
                                            </small>
                                        </div>
                                        <div class="mt-2">
                                            <button class="btn btn-sm btn-outline-info" onclick="deviceDetails(1)">
                                                <i class="fas fa-cog"></i> Settings
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="switch-card">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="switch-icon mb-3">
                                            <i class="fas fa-fan fa-3x text-info"></i>
                                        </div>
                                        <h5 class="card-title">Ceiling Fan</h5>
                                        <p class="card-text text-muted">Bedroom cooling system</p>
                                        <div class="switch-control mb-3">
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="checkbox" class="custom-control-input" id="switch2" onchange="toggleSwitch(2, this.checked)">
                                                <label class="custom-control-label" for="switch2"></label>
                                            </div>
                                        </div>
                                        <div class="switch-info">
                                            <small class="text-secondary">
                                                <i class="fas fa-circle"></i> Offline | 0W
                                            </small>
                                        </div>
                                        <div class="mt-2">
                                            <button class="btn btn-sm btn-outline-info" onclick="deviceDetails(2)">
                                                <i class="fas fa-cog"></i> Settings
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="switch-card">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="switch-icon mb-3">
                                            <i class="fas fa-tv fa-3x text-primary"></i>
                                        </div>
                                        <h5 class="card-title">Entertainment System</h5>
                                        <p class="card-text text-muted">TV & Audio setup</p>
                                        <div class="switch-control mb-3">
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="checkbox" class="custom-control-input" id="switch3" checked onchange="toggleSwitch(3, this.checked)">
                                                <label class="custom-control-label" for="switch3"></label>
                                            </div>
                                        </div>
                                        <div class="switch-info">
                                            <small class="text-success">
                                                <i class="fas fa-circle"></i> Online | 320W
                                            </small>
                                        </div>
                                        <div class="mt-2">
                                            <button class="btn btn-sm btn-outline-info" onclick="deviceDetails(3)">
                                                <i class="fas fa-cog"></i> Settings
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="switch-card">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="switch-icon mb-3">
                                            <i class="fas fa-coffee fa-3x text-brown"></i>
                                        </div>
                                        <h5 class="card-title">Kitchen Appliances</h5>
                                        <p class="card-text text-muted">Coffee maker & microwave</p>
                                        <div class="switch-control mb-3">
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="checkbox" class="custom-control-input" id="switch4" checked onchange="toggleSwitch(4, this.checked)">
                                                <label class="custom-control-label" for="switch4"></label>
                                            </div>
                                        </div>
                                        <div class="switch-info">
                                            <small class="text-success">
                                                <i class="fas fa-circle"></i> Online | 850W
                                            </small>
                                        </div>
                                        <div class="mt-2">
                                            <button class="btn btn-sm btn-outline-info" onclick="deviceDetails(4)">
                                                <i class="fas fa-cog"></i> Settings
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="switch-card">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="switch-icon mb-3">
                                            <i class="fas fa-shield-alt fa-3x text-danger"></i>
                                        </div>
                                        <h5 class="card-title">Security System</h5>
                                        <p class="card-text text-muted">Cameras & alarms</p>
                                        <div class="switch-control mb-3">
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="checkbox" class="custom-control-input" id="switch5" checked onchange="toggleSwitch(5, this.checked)">
                                                <label class="custom-control-label" for="switch5"></label>
                                            </div>
                                        </div>
                                        <div class="switch-info">
                                            <small class="text-success">
                                                <i class="fas fa-circle"></i> Online | 120W
                                            </small>
                                        </div>
                                        <div class="mt-2">
                                            <button class="btn btn-sm btn-outline-info" onclick="deviceDetails(5)">
                                                <i class="fas fa-cog"></i> Settings
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="switch-card">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="switch-icon mb-3">
                                            <i class="fas fa-car fa-3x text-dark"></i>
                                        </div>
                                        <h5 class="card-title">Garage Door</h5>
                                        <p class="card-text text-muted">Automated door control</p>
                                        <div class="switch-control mb-3">
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="checkbox" class="custom-control-input" id="switch6" onchange="toggleSwitch(6, this.checked)">
                                                <label class="custom-control-label" for="switch6"></label>
                                            </div>
                                        </div>
                                        <div class="switch-info">
                                            <small class="text-secondary">
                                                <i class="fas fa-circle"></i> Offline | 0W
                                            </small>
                                        </div>
                                        <div class="mt-2">
                                            <button class="btn btn-sm btn-outline-info" onclick="deviceDetails(6)">
                                                <i class="fas fa-cog"></i> Settings
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Schedule Control -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clock mr-2"></i>
                        Schedule Control
                    </h3>
                </div>
                <div class="card-body">
                    <div class="schedule-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">
                                    <i class="fas fa-lightbulb mr-1 text-warning"></i>
                                    Living Room Lights
                                </h6>
                                <small class="text-muted">Auto ON at 7:00 PM</small>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="schedule1" checked>
                                <label class="custom-control-label" for="schedule1"></label>
                            </div>
                        </div>
                    </div>

                    <div class="schedule-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">
                                    <i class="fas fa-shield-alt mr-1 text-danger"></i>
                                    Security System
                                </h6>
                                <small class="text-muted">Auto ON at 11:00 PM</small>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="schedule2" checked>
                                <label class="custom-control-label" for="schedule2"></label>
                            </div>
                        </div>
                    </div>

                    <div class="schedule-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">
                                    <i class="fas fa-coffee mr-1 text-brown"></i>
                                    Coffee Maker
                                </h6>
                                <small class="text-muted">Auto ON at 6:30 AM</small>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="schedule3">
                                <label class="custom-control-label" for="schedule3"></label>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button class="btn btn-primary btn-sm" onclick="manageSchedules()">
                            <i class="fas fa-plus mr-1"></i>Add Schedule
                        </button>
                    </div>
                </div>
            </div>

            <!-- Power Usage Chart -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-2"></i>
                        Power Consumption
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="powerChart" height="200"></canvas>
                    <div class="mt-3">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="border-right">
                                    <strong class="text-warning">2.4kW</strong>
                                    <br>
                                    <small class="text-muted">Current</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border-right">
                                    <strong class="text-info">18.2kWh</strong>
                                    <br>
                                    <small class="text-muted">Today</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <strong class="text-success">$4.55</strong>
                                <br>
                                <small class="text-muted">Cost</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-rocket mr-2"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <button class="btn btn-outline-primary btn-block" onclick="scenarioControl('home')">
                            <i class="fas fa-home mr-2"></i>Home Mode
                        </button>
                    </div>
                    <div class="mb-2">
                        <button class="btn btn-outline-secondary btn-block" onclick="scenarioControl('away')">
                            <i class="fas fa-plane mr-2"></i>Away Mode
                        </button>
                    </div>
                    <div class="mb-2">
                        <button class="btn btn-outline-info btn-block" onclick="scenarioControl('sleep')">
                            <i class="fas fa-bed mr-2"></i>Sleep Mode
                        </button>
                    </div>
                    <div class="mb-2">
                        <button class="btn btn-outline-warning btn-block" onclick="scenarioControl('party')">
                            <i class="fas fa-music mr-2"></i>Party Mode
                        </button>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-outline-danger btn-block" onclick="scenarioControl('emergency')">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Emergency
                        </button>
                    </div>
                    <div>
                        <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Switch Activity Log -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-2"></i>
                        Recent Switch Activity
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" onclick="exportLogs()">
                            <i class="fas fa-download mr-1"></i>Export Logs
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="activityTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Timestamp</th>
                                    <th>Device</th>
                                    <th>Action</th>
                                    <th>User/Trigger</th>
                                    <th>Power (W)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ now()->format('Y-m-d H:i:s') }}</td>
                                    <td>Living Room Lights</td>
                                    <td><span class="badge badge-success">ON</span></td>
                                    <td>Manual Control</td>
                                    <td>180</td>
                                    <td><i class="fas fa-circle text-success"></i> Success</td>
                                </tr>
                                <tr>
                                    <td>{{ now()->subMinutes(15)->format('Y-m-d H:i:s') }}</td>
                                    <td>Security System</td>
                                    <td><span class="badge badge-warning">Schedule</span></td>
                                    <td>Auto Schedule</td>
                                    <td>120</td>
                                    <td><i class="fas fa-circle text-success"></i> Success</td>
                                </tr>
                                <tr>
                                    <td>{{ now()->subMinutes(32)->format('Y-m-d H:i:s') }}</td>
                                    <td>Ceiling Fan</td>
                                    <td><span class="badge badge-secondary">OFF</span></td>
                                    <td>Voice Command</td>
                                    <td>0</td>
                                    <td><i class="fas fa-circle text-danger"></i> Failed</td>
                                </tr>
                                <tr>
                                    <td>{{ now()->subHour()->format('Y-m-d H:i:s') }}</td>
                                    <td>Kitchen Appliances</td>
                                    <td><span class="badge badge-success">ON</span></td>
                                    <td>Mobile App</td>
                                    <td>850</td>
                                    <td><i class="fas fa-circle text-success"></i> Success</td>
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
        .switch-card {
            transition: transform 0.2s;
        }
        
        .switch-card:hover {
            transform: translateY(-5px);
        }
        
        .switch-card .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .custom-switch-lg .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #28a745;
            border-color: #28a745;
        }
        
        .custom-switch-lg .custom-control-label {
            padding-left: 4rem;
        }
        
        .custom-switch-lg .custom-control-label::before {
            left: -4rem;
            width: 3rem;
            height: 1.5rem;
            border-radius: 1.5rem;
        }
        
        .custom-switch-lg .custom-control-label::after {
            left: calc(-4rem + 2px);
            width: calc(1.5rem - 4px);
            height: calc(1.5rem - 4px);
            border-radius: calc(0.75rem - 1px);
        }
        
        .custom-switch-lg .custom-control-input:checked ~ .custom-control-label::after {
            transform: translateX(1.5rem);
        }
        
        .schedule-item {
            padding: 0.75rem;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            border-left: 4px solid #007bff;
        }
        
        .text-brown {
            color: #8B4513 !important;
        }
        
        .switch-icon {
            margin-bottom: 1rem;
        }
        
        .border-right {
            border-right: 1px solid #dee2e6 !important;
        }
    </style>
@stop

@section('plugins.Sweetalert2', true)
@section('plugins.Datatables', true)

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let powerChart;
        
        $(document).ready(function() {
            // Initialize DataTable
            $('#activityTable').DataTable({
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                order: [[ 0, "desc" ]],
                pageLength: 10
            });
            
            // Initialize power consumption chart
            initPowerChart();
            
            // Start real-time updates
            startRealTimeUpdates();
        });
        
        function initPowerChart() {
            const ctx = document.getElementById('powerChart').getContext('2d');
            
            powerChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Lights', 'Entertainment', 'Kitchen', 'Security', 'Other'],
                    datasets: [{
                        data: [180, 320, 850, 120, 200],
                        backgroundColor: [
                            '#ffc107', // warning
                            '#007bff', // primary
                            '#8B4513', // brown
                            '#dc3545', // danger
                            '#6c757d'  // secondary
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }
        
        function toggleSwitch(switchId, isOn) {
            const switchName = getSwitchName(switchId);
            const action = isOn ? 'ON' : 'OFF';
            
            Swal.fire({
                title: `Turn ${action} ${switchName}?`,
                text: `This will ${action.toLowerCase()} the ${switchName.toLowerCase()}`,
                type: 'question',
                showCancelButton: true,
                confirmButtonText: `Yes, turn ${action}`,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value === true) {
                    // Simulate API call
                    simulateToggle(switchId, isOn, switchName, action);
                } else {
                    // Revert switch state
                    document.getElementById(`switch${switchId}`).checked = !isOn;
                }
            });
        }
        
        function simulateToggle(switchId, isOn, switchName, action) {
            Swal.fire({
                title: `Turning ${action} ${switchName}...`,
                text: 'Please wait while we process your request',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            
            setTimeout(() => {
                Swal.fire({
                    type: 'success',
                    title: `${switchName} turned ${action}`,
                    text: `${switchName} is now ${action.toLowerCase()}`,
                    timer: 1500,
                    showConfirmButton: false
                });
                
                // Update statistics
                updateStatistics();
                updatePowerChart();
            }, 1500);
        }
        
        function getSwitchName(switchId) {
            const names = {
                1: 'Living Room Lights',
                2: 'Ceiling Fan',
                3: 'Entertainment System',
                4: 'Kitchen Appliances',
                5: 'Security System',
                6: 'Garage Door'
            };
            return names[switchId] || 'Unknown Device';
        }
        
        function turnAllOn() {
            Swal.fire({
                title: 'Turn ON All Devices?',
                text: 'This will activate all available smart switches',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, turn all ON',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value === true) {
                    // Turn on all switches
                    for (let i = 1; i <= 6; i++) {
                        const switchElement = document.getElementById(`switch${i}`);
                        if (switchElement && !switchElement.disabled) {
                            switchElement.checked = true;
                        }
                    }
                    
                    Swal.fire({
                        type: 'success',
                        title: 'All Devices Activated',
                        text: 'All available smart switches have been turned ON',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    updateStatistics();
                    updatePowerChart();
                }
            });
        }
        
        function turnAllOff() {
            Swal.fire({
                title: 'Turn OFF All Devices?',
                text: 'This will deactivate all smart switches',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, turn all OFF',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value === true) {
                    // Turn off all switches
                    for (let i = 1; i <= 6; i++) {
                        const switchElement = document.getElementById(`switch${i}`);
                        if (switchElement) {
                            switchElement.checked = false;
                        }
                    }
                    
                    Swal.fire({
                        type: 'success',
                        title: 'All Devices Deactivated',
                        text: 'All smart switches have been turned OFF',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    updateStatistics();
                    updatePowerChart();
                }
            });
        }
        
        function updateStatistics() {
            // Count active switches
            let activeCount = 0;
            let totalPower = 0;
            const powerRatings = [180, 95, 320, 850, 120, 150]; // Watts for each device
            
            for (let i = 1; i <= 6; i++) {
                const switchElement = document.getElementById(`switch${i}`);
                if (switchElement && switchElement.checked) {
                    activeCount++;
                    totalPower += powerRatings[i-1];
                }
            }
            
            document.getElementById('activeSwitches').textContent = activeCount;
            document.getElementById('inactiveSwitches').textContent = 6 - activeCount;
            document.getElementById('totalPower').textContent = (totalPower / 1000).toFixed(1) + 'kW';
        }
        
        function updatePowerChart() {
            // Update chart with current power consumption
            const powerData = [];
            const powerRatings = [180, 320, 850, 120, 200];
            
            for (let i = 0; i < 5; i++) {
                const switchElement = document.getElementById(`switch${i+1}`);
                if (switchElement && switchElement.checked) {
                    powerData.push(powerRatings[i]);
                } else {
                    powerData.push(0);
                }
            }
            
            powerChart.data.datasets[0].data = powerData;
            powerChart.update();
        }
        
        function refreshDevices() {
            Swal.fire({
                title: 'Refreshing Device Status...',
                text: 'Checking all smart switch connections',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            
            setTimeout(() => {
                Swal.fire({
                    type: 'success',
                    title: 'Devices Refreshed',
                    text: 'All device statuses have been updated',
                    timer: 1500,
                    showConfirmButton: false
                });
            }, 2000);
        }
        
        function deviceDetails(deviceId) {
            const deviceName = getSwitchName(deviceId);
            
            Swal.fire({
                title: `${deviceName} Settings`,
                html: `
                    <div class="text-left">
                        <h6>Device Information</h6>
                        <p><strong>Name:</strong> ${deviceName}</p>
                        <p><strong>Status:</strong> <span class="badge badge-success">Online</span></p>
                        <p><strong>Type:</strong> Smart Switch</p>
                        <p><strong>Power Rating:</strong> 180W</p>
                        <p><strong>Uptime:</strong> 5 days, 12 hours</p>
                        <hr>
                        <h6>Schedule Settings</h6>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="autoSchedule">
                            <label class="form-check-label" for="autoSchedule">
                                Enable automatic scheduling
                            </label>
                        </div>
                    </div>
                `,
                width: 600,
                confirmButtonText: 'Save Settings',
                showCancelButton: true,
                cancelButtonText: 'Close'
            });
        }
        
        function manageSchedules() {
            Swal.fire({
                title: 'Add New Schedule',
                html: `
                    <div class="text-left">
                        <div class="form-group mb-3">
                            <label>Device:</label>
                            <select class="form-control" id="scheduleDevice">
                                <option value="1">Living Room Lights</option>
                                <option value="2">Ceiling Fan</option>
                                <option value="3">Entertainment System</option>
                                <option value="4">Kitchen Appliances</option>
                                <option value="5">Security System</option>
                                <option value="6">Garage Door</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Action:</label>
                            <select class="form-control" id="scheduleAction">
                                <option value="on">Turn ON</option>
                                <option value="off">Turn OFF</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Time:</label>
                            <input type="time" class="form-control" id="scheduleTime">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="scheduleRepeat" checked>
                            <label class="form-check-label" for="scheduleRepeat">
                                Repeat daily
                            </label>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Add Schedule',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const device = document.getElementById('scheduleDevice').value;
                    const action = document.getElementById('scheduleAction').value;
                    const time = document.getElementById('scheduleTime').value;
                    const repeat = document.getElementById('scheduleRepeat').checked;
                    
                    if (!time) {
                        Swal.showValidationMessage('Please select a time');
                        return false;
                    }
                    
                    return { device, action, time, repeat };
                }
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        type: 'success',
                        title: 'Schedule Added',
                        text: 'New schedule has been created successfully',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        }
        
        function scenarioControl(scenario) {
            const scenarios = {
                home: 'Home Mode - Normal operation',
                away: 'Away Mode - Security active, lights off',
                sleep: 'Sleep Mode - Minimal lighting, quiet operation',
                party: 'Party Mode - All entertainment systems on',
                emergency: 'Emergency Mode - All lights on, security alert'
            };
            
            Swal.fire({
                title: `Activate ${scenarios[scenario]}?`,
                text: 'This will adjust all switches according to the selected scenario',
                type: scenario === 'emergency' ? 'warning' : 'info',
                showCancelButton: true,
                confirmButtonText: 'Activate',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value === true) {
                    activateScenario(scenario);
                }
            });
        }
        
        function activateScenario(scenario) {
            // Simulate scenario activation
            const switchSettings = {
                home: [true, false, true, true, true, false],
                away: [false, false, false, false, true, false],
                sleep: [false, false, false, false, true, false],
                party: [true, false, true, false, false, false],
                emergency: [true, true, true, true, true, true]
            };
            
            const settings = switchSettings[scenario];
            settings.forEach((state, index) => {
                const switchElement = document.getElementById(`switch${index + 1}`);
                if (switchElement) {
                    switchElement.checked = state;
                }
            });
            
            Swal.fire({
                type: 'success',
                title: 'Scenario Activated',
                text: `All devices have been configured for ${scenario} mode`,
                timer: 2000,
                showConfirmButton: false
            });
            
            updateStatistics();
            updatePowerChart();
        }
        
        function exportLogs() {
            Swal.fire({
                type: 'info',
                title: 'Export Started',
                text: 'Switch activity logs are being exported...',
                timer: 2000,
                showConfirmButton: false
            });
        }
        
        function startRealTimeUpdates() {
            // Update timestamps every minute
            setInterval(() => {
                updateStatistics();
            }, 60000);
        }
    </script>
@stop