@extends('adminlte::page')

@section('title', 'API Documentation - IoT FST Dashboard')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-code mr-2"></i>
                        API Documentation
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">API Documentation</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- API Overview -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>
                        IoT Component Tester REST API
                    </h3>
                    <div class="card-tools">
                        <span class="badge bg-success">v1.0</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="text-muted mb-3">
                                Comprehensive REST API for IoT device integration and component testing management. 
                                All endpoints return JSON responses and support standard HTTP status codes.
                            </p>
                            <div class="alert alert-info">
                                <i class="fas fa-lightbulb mr-2"></i>
                                <strong>Base URL:</strong> <code>{{ url('/api') }}</code>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary">
                                    <i class="fas fa-plug"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">API Status</span>
                                    <span class="info-box-number text-success">
                                        <i class="fas fa-circle text-success"></i> Active
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- API Endpoints -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Available Endpoints
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" onclick="testAllEndpoints()">
                            <i class="fas fa-play mr-1"></i>
                            Test All Endpoints
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- GET /api/logs -->
                    <div class="endpoint-card mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-primary mr-2">GET</span>
                            <code class="endpoint-url">/api/logs</code>
                            <button class="btn btn-outline-success btn-sm ml-auto" onclick="testEndpoint('GET', '/api/logs')">
                                <i class="fas fa-play"></i> Test
                            </button>
                        </div>
                        <p class="text-muted mb-2">Retrieve all component test logs with pagination support</p>
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-arrow-right mr-1"></i>Response Example:</h6>
                                <pre class="bg-light p-2 rounded"><code>[
  {
    "id": 1,
    "tanggal_uji": "2025-09-09T16:45:10.000000Z",
    "komponen_terdeteksi": "Resistor 10kΩ",
    "status": "OK",
    "created_at": "2025-09-09T16:45:10.000000Z",
    "updated_at": "2025-09-09T16:45:10.000000Z"
  }
]</code></pre>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-cog mr-1"></i>Parameters:</h6>
                                <ul class="list-unstyled">
                                    <li><code>None</code> - Returns all logs</li>
                                </ul>
                                <h6><i class="fas fa-check-circle mr-1"></i>Status Codes:</h6>
                                <ul class="list-unstyled">
                                    <li><span class="badge badge-success">200</span> Success</li>
                                    <li><span class="badge badge-danger">500</span> Server Error</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- POST /api/logs -->
                    <div class="endpoint-card mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-success mr-2">POST</span>
                            <code class="endpoint-url">/api/logs</code>
                            <button class="btn btn-outline-success btn-sm ml-auto" onclick="testEndpoint('POST', '/api/logs')">
                                <i class="fas fa-play"></i> Test
                            </button>
                        </div>
                        <p class="text-muted mb-2">Create a new component test log entry</p>
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-arrow-up mr-1"></i>Request Body:</h6>
                                <pre class="bg-light p-2 rounded"><code>{
  "komponen_terdeteksi": "Capacitor 100µF",
  "status": "OK"
}</code></pre>
                                <h6><i class="fas fa-arrow-right mr-1"></i>Response Example:</h6>
                                <pre class="bg-light p-2 rounded"><code>{
  "id": 25,
  "tanggal_uji": "2025-09-09T17:30:00.000000Z",
  "komponen_terdeteksi": "Capacitor 100µF",
  "status": "OK",
  "created_at": "2025-09-09T17:30:00.000000Z",
  "updated_at": "2025-09-09T17:30:00.000000Z"
}</code></pre>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-cog mr-1"></i>Required Fields:</h6>
                                <ul class="list-unstyled">
                                    <li><code>komponen_terdeteksi</code> - Component name (string)</li>
                                    <li><code>status</code> - Test result (OK, FAILED, WARNING)</li>
                                </ul>
                                <h6><i class="fas fa-check-circle mr-1"></i>Status Codes:</h6>
                                <ul class="list-unstyled">
                                    <li><span class="badge badge-success">201</span> Created</li>
                                    <li><span class="badge badge-warning">422</span> Validation Error</li>
                                    <li><span class="badge badge-danger">500</span> Server Error</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- GET /api/logs/{id} -->
                    <div class="endpoint-card mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-info mr-2">GET</span>
                            <code class="endpoint-url">/api/logs/{id}</code>
                            <button class="btn btn-outline-success btn-sm ml-auto" onclick="testEndpoint('GET', '/api/logs/1')">
                                <i class="fas fa-play"></i> Test
                            </button>
                        </div>
                        <p class="text-muted mb-2">Retrieve a specific test log by ID</p>
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-arrow-right mr-1"></i>Response Example:</h6>
                                <pre class="bg-light p-2 rounded"><code>{
  "id": 1,
  "tanggal_uji": "2025-09-09T16:45:10.000000Z",
  "komponen_terdeteksi": "Resistor 10kΩ",
  "status": "OK",
  "created_at": "2025-09-09T16:45:10.000000Z",
  "updated_at": "2025-09-09T16:45:10.000000Z"
}</code></pre>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-cog mr-1"></i>Parameters:</h6>
                                <ul class="list-unstyled">
                                    <li><code>id</code> - Log ID (integer, required)</li>
                                </ul>
                                <h6><i class="fas fa-check-circle mr-1"></i>Status Codes:</h6>
                                <ul class="list-unstyled">
                                    <li><span class="badge badge-success">200</span> Success</li>
                                    <li><span class="badge badge-warning">404</span> Not Found</li>
                                    <li><span class="badge badge-danger">500</span> Server Error</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- PUT /api/logs/{id} -->
                    <div class="endpoint-card mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-warning mr-2">PUT</span>
                            <code class="endpoint-url">/api/logs/{id}</code>
                            <button class="btn btn-outline-success btn-sm ml-auto" onclick="testEndpoint('PUT', '/api/logs/1')">
                                <i class="fas fa-play"></i> Test
                            </button>
                        </div>
                        <p class="text-muted mb-2">Update an existing test log</p>
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-arrow-up mr-1"></i>Request Body:</h6>
                                <pre class="bg-light p-2 rounded"><code>{
  "komponen_terdeteksi": "Updated Component Name",
  "status": "FAILED"
}</code></pre>
                                <h6><i class="fas fa-arrow-right mr-1"></i>Response Example:</h6>
                                <pre class="bg-light p-2 rounded"><code>{
  "id": 1,
  "tanggal_uji": "2025-09-09T16:45:10.000000Z",
  "komponen_terdeteksi": "Updated Component Name",
  "status": "FAILED",
  "created_at": "2025-09-09T16:45:10.000000Z",
  "updated_at": "2025-09-09T17:30:00.000000Z"
}</code></pre>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-cog mr-1"></i>Parameters:</h6>
                                <ul class="list-unstyled">
                                    <li><code>id</code> - Log ID (integer, required)</li>
                                    <li><code>komponen_terdeteksi</code> - Component name</li>
                                    <li><code>status</code> - Test result</li>
                                </ul>
                                <h6><i class="fas fa-check-circle mr-1"></i>Status Codes:</h6>
                                <ul class="list-unstyled">
                                    <li><span class="badge badge-success">200</span> Updated</li>
                                    <li><span class="badge badge-warning">404</span> Not Found</li>
                                    <li><span class="badge badge-warning">422</span> Validation Error</li>
                                    <li><span class="badge badge-danger">500</span> Server Error</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- DELETE /api/logs/{id} -->
                    <div class="endpoint-card mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-danger mr-2">DELETE</span>
                            <code class="endpoint-url">/api/logs/{id}</code>
                            <button class="btn btn-outline-danger btn-sm ml-auto" onclick="confirmDeleteTest(1)">
                                <i class="fas fa-play"></i> Test
                            </button>
                        </div>
                        <p class="text-muted mb-2">Delete a test log permanently</p>
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-arrow-right mr-1"></i>Response Example:</h6>
                                <pre class="bg-light p-2 rounded"><code>{
  "message": "Log deleted successfully"
}</code></pre>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-cog mr-1"></i>Parameters:</h6>
                                <ul class="list-unstyled">
                                    <li><code>id</code> - Log ID (integer, required)</li>
                                </ul>
                                <h6><i class="fas fa-check-circle mr-1"></i>Status Codes:</h6>
                                <ul class="list-unstyled">
                                    <li><span class="badge badge-success">200</span> Deleted</li>
                                    <li><span class="badge badge-warning">404</span> Not Found</li>
                                    <li><span class="badge badge-danger">500</span> Server Error</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- GET /api/logs/status/{status} -->
                    <div class="endpoint-card mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-secondary mr-2">GET</span>
                            <code class="endpoint-url">/api/logs/status/{status}</code>
                            <button class="btn btn-outline-success btn-sm ml-auto" onclick="testEndpoint('GET', '/api/logs/status/OK')">
                                <i class="fas fa-play"></i> Test
                            </button>
                        </div>
                        <p class="text-muted mb-2">Filter test logs by status</p>
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-arrow-right mr-1"></i>Response Example:</h6>
                                <pre class="bg-light p-2 rounded"><code>[
  {
    "id": 1,
    "tanggal_uji": "2025-09-09T16:45:10.000000Z",
    "komponen_terdeteksi": "Resistor 10kΩ",
    "status": "OK",
    "created_at": "2025-09-09T16:45:10.000000Z",
    "updated_at": "2025-09-09T16:45:10.000000Z"
  }
]</code></pre>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-cog mr-1"></i>Parameters:</h6>
                                <ul class="list-unstyled">
                                    <li><code>status</code> - Test status:</li>
                                    <li>&nbsp;&nbsp;• <span class="badge badge-success">OK</span></li>
                                    <li>&nbsp;&nbsp;• <span class="badge badge-danger">FAILED</span></li>
                                    <li>&nbsp;&nbsp;• <span class="badge badge-warning">WARNING</span></li>
                                </ul>
                                <h6><i class="fas fa-check-circle mr-1"></i>Status Codes:</h6>
                                <ul class="list-unstyled">
                                    <li><span class="badge badge-success">200</span> Success</li>
                                    <li><span class="badge badge-danger">500</span> Server Error</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <!-- Testing Console -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-terminal mr-2"></i>
                        API Testing Console
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearConsole()">
                            <i class="fas fa-trash"></i> Clear
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="api-console" class="bg-dark text-light p-3 rounded" style="height: 300px; overflow-y: auto; font-family: monospace; font-size: 12px;">
                        <div class="text-success">IoT FST API Testing Console Ready...</div>
                        <div class="text-muted">Click "Test" buttons above to test endpoints</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
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
                        <button class="btn btn-primary btn-block" onclick="testAllEndpoints()">
                            <i class="fas fa-play-circle mr-2"></i>
                            Test All Endpoints
                        </button>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-success btn-block" onclick="createSampleData()">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Create Sample Test Data
                        </button>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-info btn-block" onclick="exportApiDoc()">
                            <i class="fas fa-download mr-2"></i>
                            Download OpenAPI Spec
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
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .endpoint-card {
            border-left: 4px solid #007bff;
            padding-left: 1rem;
            background-color: #f8f9fa;
            border-radius: 0.375rem;
            padding: 1rem;
        }
        
        .endpoint-url {
            font-size: 1.1em;
            font-weight: 500;
        }
        
        pre code {
            font-size: 0.85em;
            line-height: 1.4;
        }
        
        .badge {
            font-size: 0.8em;
        }
        
        #api-console {
            background-color: #1e1e1e !important;
            color: #d4d4d4 !important;
        }
        
        .console-success { color: #4CAF50 !important; }
        .console-error { color: #f44336 !important; }
        .console-warning { color: #FF9800 !important; }
        .console-info { color: #2196F3 !important; }
    </style>
@stop

@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        let consoleElement;
        
        $(document).ready(function() {
            consoleElement = document.getElementById('api-console');
            logToConsole('API Documentation loaded successfully', 'success');
        });
        
        function logToConsole(message, type = 'info') {
            const timestamp = new Date().toLocaleTimeString();
            const className = `console-${type}`;
            const icon = {
                success: '✓',
                error: '✗',
                warning: '⚠',
                info: 'ℹ'
            }[type] || 'ℹ';
            
            const logEntry = `<div class="${className}">[${timestamp}] ${icon} ${message}</div>`;
            consoleElement.innerHTML += logEntry;
            consoleElement.scrollTop = consoleElement.scrollHeight;
        }
        
        function clearConsole() {
            consoleElement.innerHTML = '<div class="text-success">Console cleared...</div>';
        }
        
        async function testEndpoint(method, url) {
            logToConsole(`Testing ${method} ${url}...`, 'info');
            
            try {
                const options = {
                    method: method,
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                };
                
                // Add sample data for POST requests
                if (method === 'POST') {
                    options.body = JSON.stringify({
                        komponen_terdeteksi: 'API Test Component',
                        status: 'OK'
                    });
                }
                
                // Add sample data for PUT requests  
                if (method === 'PUT') {
                    options.body = JSON.stringify({
                        komponen_terdeteksi: 'Updated API Test Component',
                        status: 'WARNING'
                    });
                }
                
                const response = await fetch(url, options);
                const data = await response.json();
                
                if (response.ok) {
                    logToConsole(`${method} ${url} → ${response.status} ${response.statusText}`, 'success');
                    logToConsole(`Response: ${JSON.stringify(data, null, 2)}`, 'info');
                } else {
                    logToConsole(`${method} ${url} → ${response.status} ${response.statusText}`, 'warning');
                    logToConsole(`Error: ${JSON.stringify(data, null, 2)}`, 'warning');
                }
            } catch (error) {
                logToConsole(`${method} ${url} → Network Error: ${error.message}`, 'error');
            }
        }
        
        async function confirmDeleteTest(id) {
            const result = await Swal.fire({
                title: 'Test DELETE Endpoint?',
                text: 'This will demonstrate the DELETE API endpoint (test mode)',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Test DELETE',
                cancelButtonText: 'Cancel'
            });
            
            if (result.value === true) {
                logToConsole('User confirmed DELETE test', 'info');
                await testEndpoint('DELETE', `/api/logs/${id}`);
            } else {
                logToConsole('DELETE test cancelled', 'info');
            }
        }
        
        async function testAllEndpoints() {
            logToConsole('Starting comprehensive API test...', 'info');
            logToConsole('=' .repeat(50), 'info');
            
            // Test all endpoints in sequence
            await testEndpoint('GET', '/api/logs');
            await new Promise(resolve => setTimeout(resolve, 500));
            
            await testEndpoint('POST', '/api/logs');
            await new Promise(resolve => setTimeout(resolve, 500));
            
            await testEndpoint('GET', '/api/logs/1');
            await new Promise(resolve => setTimeout(resolve, 500));
            
            await testEndpoint('PUT', '/api/logs/1');
            await new Promise(resolve => setTimeout(resolve, 500));
            
            await testEndpoint('GET', '/api/logs/status/OK');
            await new Promise(resolve => setTimeout(resolve, 500));
            
            await testEndpoint('GET', '/api/logs/status/FAILED');
            await new Promise(resolve => setTimeout(resolve, 500));
            
            await testEndpoint('GET', '/api/logs/status/WARNING');
            
            logToConsole('=' .repeat(50), 'info');
            logToConsole('Comprehensive API test completed!', 'success');
        }
        
        async function createSampleData() {
            logToConsole('Creating sample test data...', 'info');
            
            const sampleData = [
                { komponen_terdeteksi: 'Resistor 1kΩ', status: 'OK' },
                { komponen_terdeteksi: 'LED Red 5mm', status: 'OK' },
                { komponen_terdeteksi: 'Capacitor 10µF', status: 'WARNING' },
                { komponen_terdeteksi: 'Transistor BC547', status: 'FAILED' }
            ];
            
            for (let i = 0; i < sampleData.length; i++) {
                await testEndpoint('POST', '/api/logs');
                await new Promise(resolve => setTimeout(resolve, 300));
            }
            
            logToConsole('Sample data creation completed!', 'success');
        }
        
        function exportApiDoc() {
            Swal.fire({
                type: 'info',
                title: 'OpenAPI Specification',
                text: 'OpenAPI spec export feature will be implemented in future updates.',
                confirmButtonText: 'OK'
            });
        }
    </script>
@stop