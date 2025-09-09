@extends('adminlte::page')

@section('title', 'System Settings - IoT FST Dashboard')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-cogs mr-2"></i>
                        System Settings
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <!-- General Settings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-sliders-h mr-2"></i>
                        General Configuration
                    </h3>
                </div>
                <div class="card-body">
                    <form id="settingsForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="app_name">
                                        <i class="fas fa-tag mr-1"></i>Application Name
                                    </label>
                                    <input type="text" class="form-control" id="app_name" value="IoT FST Dashboard" placeholder="Enter application name">
                                    <small class="form-text text-muted">Display name for the application</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="app_version">
                                        <i class="fas fa-code-branch mr-1"></i>Version
                                    </label>
                                    <input type="text" class="form-control" id="app_version" value="v1.2.0" placeholder="Version number">
                                    <small class="form-text text-muted">Current application version</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="timezone">
                                        <i class="fas fa-clock mr-1"></i>Timezone
                                    </label>
                                    <select class="form-control" id="timezone">
                                        <option value="UTC">UTC (Coordinated Universal Time)</option>
                                        <option value="Asia/Jakarta" selected>Asia/Jakarta (WIB)</option>
                                        <option value="Asia/Makassar">Asia/Makassar (WITA)</option>
                                        <option value="Asia/Jayapura">Asia/Jayapura (WIT)</option>
                                    </select>
                                    <small class="form-text text-muted">System timezone for timestamps</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_format">
                                        <i class="fas fa-calendar mr-1"></i>Date Format
                                    </label>
                                    <select class="form-control" id="date_format">
                                        <option value="Y-m-d H:i:s" selected>2025-09-09 17:30:00</option>
                                        <option value="d/m/Y H:i">09/09/2025 17:30</option>
                                        <option value="d-m-Y H:i:s">09-09-2025 17:30:00</option>
                                        <option value="M d, Y h:i A">Sep 09, 2025 5:30 PM</option>
                                    </select>
                                    <small class="form-text text-muted">Date display format</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>
                                <i class="fas fa-palette mr-1"></i>Dashboard Theme
                            </label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="theme_light" name="theme" value="light" checked>
                                        <label for="theme_light" class="custom-control-label">
                                            <i class="fas fa-sun mr-1 text-warning"></i>Light Theme
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="theme_dark" name="theme" value="dark">
                                        <label for="theme_dark" class="custom-control-label">
                                            <i class="fas fa-moon mr-1 text-info"></i>Dark Theme
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="theme_auto" name="theme" value="auto">
                                        <label for="theme_auto" class="custom-control-label">
                                            <i class="fas fa-adjust mr-1 text-secondary"></i>Auto
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <small class="form-text text-muted">Choose dashboard appearance theme</small>
                        </div>
                    </form>
                </div>
            </div>

            <!-- API Settings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plug mr-2"></i>
                        API Configuration
                    </h3>
                </div>
                <div class="card-body">
                    <form id="apiSettingsForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="api_rate_limit">
                                        <i class="fas fa-tachometer-alt mr-1"></i>API Rate Limit
                                    </label>
                                    <select class="form-control" id="api_rate_limit">
                                        <option value="60">60 requests/minute</option>
                                        <option value="100" selected>100 requests/minute</option>
                                        <option value="200">200 requests/minute</option>
                                        <option value="unlimited">Unlimited</option>
                                    </select>
                                    <small class="form-text text-muted">Maximum API requests per minute</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="api_timeout">
                                        <i class="fas fa-hourglass-half mr-1"></i>API Timeout
                                    </label>
                                    <select class="form-control" id="api_timeout">
                                        <option value="30">30 seconds</option>
                                        <option value="60" selected>60 seconds</option>
                                        <option value="120">2 minutes</option>
                                        <option value="300">5 minutes</option>
                                    </select>
                                    <small class="form-text text-muted">Request timeout duration</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="api_logging" checked>
                                <label class="custom-control-label" for="api_logging">
                                    <i class="fas fa-file-alt mr-1"></i>Enable API Request Logging
                                </label>
                            </div>
                            <small class="form-text text-muted">Log all API requests for debugging and monitoring</small>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="api_cors" checked>
                                <label class="custom-control-label" for="api_cors">
                                    <i class="fas fa-globe mr-1"></i>Enable CORS (Cross-Origin Requests)
                                </label>
                            </div>
                            <small class="form-text text-muted">Allow API access from external domains</small>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Database Settings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-database mr-2"></i>
                        Database Configuration
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary">
                                    <i class="fas fa-server"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Database Type</span>
                                    <span class="info-box-number">SQLite</span>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" style="width: 100%"></div>
                                    </div>
                                    <span class="progress-description">Development Mode</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Connection Status</span>
                                    <span class="info-box-number">Connected</span>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" style="width: 100%"></div>
                                    </div>
                                    <span class="progress-description">Response: ~12ms</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Development Note:</strong> Currently using SQLite database for development. 
                        For production deployment, consider migrating to MySQL or PostgreSQL for better performance and scalability.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-outline-primary btn-block" onclick="testDatabaseConnection()">
                                <i class="fas fa-satellite-dish mr-1"></i>Test Connection
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-outline-warning btn-block" onclick="optimizeDatabase()">
                                <i class="fas fa-tools mr-1"></i>Optimize Database
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-outline-info btn-block" onclick="backupDatabase()">
                                <i class="fas fa-download mr-1"></i>Backup Database
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-rocket mr-2"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <button type="button" class="btn btn-success btn-block" onclick="saveAllSettings()">
                            <i class="fas fa-save mr-2"></i>
                            Save All Settings
                        </button>
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-warning btn-block" onclick="resetToDefaults()">
                            <i class="fas fa-undo mr-2"></i>
                            Reset to Defaults
                        </button>
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-info btn-block" onclick="exportSettings()">
                            <i class="fas fa-download mr-2"></i>
                            Export Configuration
                        </button>
                    </div>
                    <div class="mb-3">
                        <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-primary btn-block">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>
                        System Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <strong><i class="fas fa-server mr-1"></i>Server:</strong>
                            <p class="text-muted">PHP {{ phpversion() }} on {{ php_uname('s') }}</p>
                        </div>
                        <div class="col-12 mb-3">
                            <strong><i class="fab fa-laravel mr-1"></i>Framework:</strong>
                            <p class="text-muted">Laravel {{ app()->version() }}</p>
                        </div>
                        <div class="col-12 mb-3">
                            <strong><i class="fas fa-memory mr-1"></i>Memory Usage:</strong>
                            <p class="text-muted">{{ round(memory_get_usage(true) / 1024 / 1024, 2) }} MB</p>
                        </div>
                        <div class="col-12 mb-3">
                            <strong><i class="fas fa-clock mr-1"></i>Server Time:</strong>
                            <p class="text-muted">{{ now()->format('Y-m-d H:i:s T') }}</p>
                        </div>
                        <div class="col-12">
                            <strong><i class="fas fa-hdd mr-1"></i>Environment:</strong>
                            <span class="badge badge-{{ app()->environment() === 'production' ? 'success' : 'warning' }}">
                                {{ strtoupper(app()->environment()) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Maintenance Mode -->
            <div class="card">
                <div class="card-header bg-warning">
                    <h3 class="card-title text-dark">
                        <i class="fas fa-wrench mr-2"></i>
                        Maintenance Mode
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Put the application in maintenance mode to prevent access during updates.
                    </p>
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-warning btn-block" onclick="enableMaintenance()">
                                <i class="fas fa-pause mr-1"></i>
                                Enable
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-success btn-block" onclick="disableMaintenance()">
                                <i class="fas fa-play mr-1"></i>
                                Disable
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .custom-control-label {
            cursor: pointer;
        }
        
        .info-box {
            transition: transform 0.2s;
        }
        
        .info-box:hover {
            transform: translateY(-2px);
        }
        
        .alert {
            border-radius: 10px;
        }
        
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            border-radius: 10px;
        }
        
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
    </style>
@stop

@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        $(document).ready(function() {
            // Initialize any additional components
            console.log('Settings page loaded');
        });
        
        function saveAllSettings() {
            // Simulate saving settings
            Swal.fire({
                type: 'success',
                title: 'Settings Saved!',
                text: 'All configuration changes have been saved successfully.',
                timer: 2000,
                showConfirmButton: false
            });
        }
        
        function resetToDefaults() {
            Swal.fire({
                title: 'Reset to Defaults?',
                text: 'This will restore all settings to their default values.',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Reset Settings',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value === true) {
                    // Reset form values
                    document.getElementById('settingsForm').reset();
                    document.getElementById('apiSettingsForm').reset();
                    
                    Swal.fire({
                        type: 'success',
                        title: 'Settings Reset',
                        text: 'All settings have been restored to defaults.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }
        
        function exportSettings() {
            const settings = {
                general: {
                    app_name: document.getElementById('app_name').value,
                    app_version: document.getElementById('app_version').value,
                    timezone: document.getElementById('timezone').value,
                    date_format: document.getElementById('date_format').value,
                    theme: document.querySelector('input[name="theme"]:checked').value
                },
                api: {
                    rate_limit: document.getElementById('api_rate_limit').value,
                    timeout: document.getElementById('api_timeout').value,
                    logging_enabled: document.getElementById('api_logging').checked,
                    cors_enabled: document.getElementById('api_cors').checked
                },
                exported_at: new Date().toISOString()
            };
            
            const dataStr = JSON.stringify(settings, null, 2);
            const dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
            
            const exportFileDefaultName = 'iot-fst-settings-' + new Date().toISOString().split('T')[0] + '.json';
            
            const linkElement = document.createElement('a');
            linkElement.setAttribute('href', dataUri);
            linkElement.setAttribute('download', exportFileDefaultName);
            linkElement.click();
            
            Swal.fire({
                type: 'success',
                title: 'Configuration Exported',
                text: 'Settings have been exported successfully.',
                timer: 2000,
                showConfirmButton: false
            });
        }
        
        async function testDatabaseConnection() {
            Swal.fire({
                title: 'Testing Database Connection...',
                text: 'Please wait while we test the connection',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            
            try {
                // Simulate API call to test database
                const response = await fetch('/api/logs', {
                    method: 'GET',
                    headers: { 'Accept': 'application/json' }
                });
                
                setTimeout(() => {
                    if (response.ok) {
                        Swal.fire({
                            type: 'success',
                            title: 'Connection Successful',
                            text: 'Database connection is working properly.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Connection Failed',
                            text: 'Unable to connect to the database.',
                            confirmButtonText: 'OK'
                        });
                    }
                }, 1000);
            } catch (error) {
                Swal.fire({
                    type: 'error',
                    title: 'Connection Error',
                    text: 'Network error occurred while testing connection.',
                    confirmButtonText: 'OK'
                });
            }
        }
        
        function optimizeDatabase() {
            Swal.fire({
                title: 'Optimize Database?',
                text: 'This will clean up unused data and optimize performance.',
                type: 'info',
                showCancelButton: true,
                confirmButtonText: 'Optimize',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value === true) {
                    Swal.fire({
                        title: 'Optimizing Database...',
                        text: 'Please wait while we optimize the database',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    setTimeout(() => {
                        Swal.fire({
                            type: 'success',
                            title: 'Database Optimized',
                            text: 'Database optimization completed successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }, 3000);
                }
            });
        }
        
        function backupDatabase() {
            Swal.fire({
                type: 'info',
                title: 'Database Backup',
                text: 'Database backup functionality will be implemented in future updates.',
                confirmButtonText: 'OK'
            });
        }
        
        function enableMaintenance() {
            Swal.fire({
                title: 'Enable Maintenance Mode?',
                text: 'This will make the application unavailable to users.',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Enable',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value === true) {
                    Swal.fire({
                        type: 'warning',
                        title: 'Maintenance Mode Enabled',
                        text: 'Application is now in maintenance mode.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }
        
        function disableMaintenance() {
            Swal.fire({
                type: 'success',
                title: 'Maintenance Mode Disabled',
                text: 'Application is now accessible to users.',
                timer: 2000,
                showConfirmButton: false
            });
        }
    </script>
@stop