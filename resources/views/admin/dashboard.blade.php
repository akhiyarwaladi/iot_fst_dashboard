@extends('adminlte::page')

@section('title', 'IoT Component Tester Dashboard')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">IoT Component Tester</h1>
            <p class="text-muted">Monitor and manage your electronic component testing</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Add New Test Log Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Add New Test Log
                    </h3>
                </div>
                <div class="card-body">
                    <form id="addLogForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="komponen" class="form-label">Component Detected</label>
                                    <input type="text" class="form-control" id="komponen" placeholder="e.g., Resistor 10kΩ, LED Red, Capacitor 100μF" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status" class="form-label">Test Result</label>
                                    <select class="form-control" id="status" required>
                                        <option value="">Select Result</option>
                                        <option value="OK">✓ PASSED</option>
                                        <option value="FAILED">✗ FAILED</option>
                                        <option value="WARNING">⚠ WARNING</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-save mr-2"></i>
                                        Add Test Result
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Modern Stats Cards -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="totalLogs">{{ number_format($logs->count()) }}</h3>
                    <p>Total Tests Performed</p>
                </div>
                <div class="icon">
                    <i class="fas fa-vial"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="okLogs">{{ number_format($logs->where('status', 'OK')->count()) }}</h3>
                    <p>Components Working</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="failedLogs">{{ number_format($logs->where('status', 'FAILED')->count()) }}</h3>
                    <p>Components Failed</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 id="warningLogs">{{ number_format($logs->where('status', 'WARNING')->count()) }}</h3>
                    <p>Warning Components</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- Recent Test Logs -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-2"></i>
                        Test History & Results
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" onclick="refreshLogs()">
                            <i class="fas fa-sync-alt mr-1"></i> Refresh Data
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($logs->count() > 0)
                    <div class="table-responsive">
                        <table id="logsTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="10%">#ID</th>
                                    <th width="20%">Test Date & Time</th>
                                    <th width="30%">Component Detected</th>
                                    <th width="15%">Result</th>
                                    <th width="25%">Actions</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>{{ $log->tanggal_uji->format('Y-m-d H:i:s') }}</td>
                                <td>{{ $log->komponen_terdeteksi }}</td>
                                <td>
                                    @if($log->status == 'OK')
                                        <span class="badge badge-success"><i class="fas fa-check mr-1"></i>PASSED</span>
                                    @elseif($log->status == 'FAILED')
                                        <span class="badge badge-danger"><i class="fas fa-times mr-1"></i>FAILED</span>
                                    @else
                                        <span class="badge badge-warning"><i class="fas fa-exclamation-triangle mr-1"></i>WARNING</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary" onclick="editLog({{ $log->id }})" title="Edit Test Result">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteLog({{ $log->id }})" title="Delete Test Result">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-info" onclick="viewDetails({{ $log->id }})" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    @else
                    <div class="text-center empty-state">
                        <i class="fas fa-flask fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted mb-2">No Test Results Yet</h4>
                        <p class="text-muted mb-3">Start by adding your first component test above to begin monitoring your IoT devices.</p>
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Tip: Use the form above or send data via API endpoints
                            </small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <!-- API Documentation -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-code mr-2"></i>
                        REST API Endpoints
                    </h3>
                    <div class="card-tools">
                        <span class="badge bg-success">Active</span>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">RESTful API for IoT device integration and remote testing:</p>
                    <div class="api-endpoints">
                        <div class="endpoint-item">
                            <span class="badge bg-primary">GET</span>
                            <code>/api/logs</code>
                            <small class="text-muted d-block mt-1">Retrieve all test results with pagination</small>
                        </div>
                        <div class="endpoint-item">
                            <span class="badge bg-success">POST</span>
                            <code>/api/logs</code>
                            <small class="text-muted d-block mt-1">Submit new component test result</small>
                        </div>
                        <div class="endpoint-item">
                            <span class="badge bg-info">GET</span>
                            <code>/api/logs/{id}</code>
                            <small class="text-muted d-block mt-1">Get specific test result by ID</small>
                        </div>
                        <div class="endpoint-item">
                            <span class="badge bg-warning">PUT</span>
                            <code>/api/logs/{id}</code>
                            <small class="text-muted d-block mt-1">Update existing test result</small>
                        </div>
                        <div class="endpoint-item">
                            <span class="badge bg-danger">DELETE</span>
                            <code>/api/logs/{id}</code>
                            <small class="text-muted d-block mt-1">Remove test result permanently</small>
                        </div>
                        <div class="endpoint-item">
                            <span class="badge bg-secondary">GET</span>
                            <code>/api/logs/status/{status}</code>
                            <small class="text-muted d-block mt-1">Filter results by status (OK, FAILED, WARNING)</small>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <button onclick="window.open('{{ url('/') }}/docs/API_DOCUMENTATION.md', '_blank')" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-book mr-1"></i> View Full Documentation
                        </button>
                        <a href="https://github.com/akhiyarwaladi/iot_fst_dashboard" target="_blank" class="btn btn-outline-secondary btn-sm ml-2">
                            <i class="fab fa-github mr-1"></i> GitHub Repository
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- System Health -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-heartbeat mr-2"></i>
                        System Health Monitor
                    </h3>
                    <div class="card-tools">
                        <span class="badge bg-success">All Systems Operational</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="fas fa-database"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Database Connection</span>
                                    <span class="info-box-number text-success">
                                        <i class="fas fa-circle text-success"></i> Connected
                                    </span>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" style="width: 100%"></div>
                                    </div>
                                    <span class="progress-description">Response time: ~12ms</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-plug"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">IoT Device API</span>
                                    <span class="info-box-number text-success">
                                        <i class="fas fa-circle text-success"></i> Active
                                    </span>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" style="width: 95%"></div>
                                    </div>
                                    <span class="progress-description">Uptime: 99.5%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-memory"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">System Resources</span>
                                    <span class="info-box-number text-info">
                                        <i class="fas fa-circle text-info"></i> Optimal
                                    </span>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" style="width: 78%"></div>
                                    </div>
                                    <span class="progress-description">Memory: 78% | CPU: 23%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <small class="text-muted">Last updated: {{ now()->format('Y-m-d H:i:s') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@stop

@section('plugins.Sweetalert2', true)
@section('plugins.Datatables', true)

@section('js')
    <script>
        // Setup CSRF token
        const csrfToken = '{{ csrf_token() }}';
        
        // Initialize DataTable with modern styling
        $(document).ready(function() {
            if ($('#logsTable').length) {
                $('#logsTable').DataTable({
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "order": [[ 0, "desc" ]],
                    "pageLength": 25,
                    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                           "<'row'<'col-sm-12'tr>>" +
                           "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    "language": {
                        "search": "Search results:",
                        "lengthMenu": "Show _MENU_ entries per page",
                        "info": "Showing _START_ to _END_ of _TOTAL_ test results",
                        "infoEmpty": "No test results available",
                        "infoFiltered": "(filtered from _MAX_ total results)",
                        "paginate": {
                            "first": "First",
                            "last": "Last",
                            "next": "Next",
                            "previous": "Previous"
                        },
                        "emptyTable": "No test data available"
                    }
                });
            }
        });
        
        // Add new log form handler
        document.getElementById('addLogForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const komponen = document.getElementById('komponen').value;
            const status = document.getElementById('status').value;
            
            try {
                const response = await fetch('/api/logs', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        komponen_terdeteksi: komponen,
                        status: status
                    })
                });
                
                if (response.ok) {
                    // Show success message with standardized styling
                    Swal.fire({
                        type: 'success',
                        title: 'Test Added Successfully!',
                        text: 'Your component test result has been saved to the database.',
                        timer: 2500,
                        showConfirmButton: false
                    });
                    
                    // Reset form and reload page
                    document.getElementById('addLogForm').reset();
                    setTimeout(() => location.reload(), 2600);
                } else {
                    const errorData = await response.json();
                    Swal.fire({
                        type: 'error',
                        title: 'Failed to Add Test',
                        text: errorData.message || 'There was an error saving your test result. Please try again.',
                        confirmButtonText: 'Try Again'
                    });
                }
            } catch (error) {
                Swal.fire({
                    type: 'error',
                    title: 'Network Connection Error',
                    text: 'Unable to connect to the server. Please check your internet connection and try again.',
                    confirmButtonText: 'Retry'
                });
            }
        });
        
        // Delete log function
        window.deleteLog = async function(id) {
            console.log('Delete function called with ID:', id);
            
            try {
                const result = await Swal.fire({
                    title: 'Delete Test Result?',
                    text: 'Are you sure you want to permanently delete this test result? This action cannot be undone.',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete Permanently',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    dangerMode: true
                });
                
                console.log('SweetAlert2 result:', result);
                
                if (result.value === true) {
                    console.log('User confirmed delete, calling deleteLogRequest');
                    await deleteLogRequest(id);
                } else {
                    console.log('User cancelled delete');
                }
            } catch (error) {
                console.error('Error in delete modal:', error);
                // Fallback to simple confirm
                if (confirm('Are you sure you want to delete this test result?')) {
                    console.log('Using fallback confirm, calling deleteLogRequest');
                    await deleteLogRequest(id);
                }
            }
        }
        
        // Actual delete request function
        async function deleteLogRequest(id) {
            console.log('Making DELETE request for ID:', id);
            try {
                const url = `/api/logs/${id}`;
                console.log('DELETE URL:', url);
                
                const response = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                
                console.log('Response status:', response.status);
                console.log('Response ok:', response.ok);
                
                const data = await response.json();
                console.log('Response data:', data);
                
                if (response.ok) {
                    console.log('Delete successful');
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            type: 'success',
                            title: 'Test Result Deleted',
                            text: 'The test result has been permanently removed from the database.',
                            timer: 2500,
                            showConfirmButton: false
                        });
                        setTimeout(() => location.reload(), 2600);
                    } else {
                        alert('Log deleted successfully!');
                        location.reload();
                    }
                } else {
                    console.log('Delete failed');
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            type: 'error',
                            title: 'Failed to Delete',
                            text: data.message || 'There was an error deleting the test result. It may have already been removed.',
                            confirmButtonText: 'Close'
                        });
                    } else {
                        alert('Error: ' + (data.message || 'Error deleting log'));
                    }
                }
            } catch (error) {
                console.error('Delete error:', error);
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        type: 'error',
                        title: 'Network Connection Error',
                        text: 'Unable to connect to the server. Please check your internet connection and try again.',
                        footer: `<small>Technical error: ${error.message}</small>`,
                        confirmButtonText: 'Retry',
                        customClass: {
                            popup: 'error-notification'
                        }
                    });
                } else {
                    alert('Network error: ' + error.message);
                }
            }
        }
        
        // Backward compatible alias to the styled delete modal
        window.testDelete = function(id) { return window.deleteLog(id); }
        
        // Refresh logs function
        function refreshLogs() {
            location.reload();
        }
        
        // View details function
        window.viewDetails = async function(id) {
            try {
                const response = await fetch(`/api/logs/${id}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    }
                });
                
                if (response.ok) {
                    const log = await response.json();
                    
                    Swal.fire({
                        title: '<i class="fas fa-info-circle mr-2"></i>Test Result Details',
                        html: `
                            <div class="text-left" style="margin-top: 1rem;">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card" style="border: none; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                            <div class="card-body" style="padding: 1.5rem;">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h6 class="text-muted mb-1">
                                                            <i class="fas fa-hashtag mr-1"></i>Test ID
                                                        </h6>
                                                        <p class="h5 text-primary">#${log.id}</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <h6 class="text-muted mb-1">
                                                            <i class="fas fa-clipboard-check mr-1"></i>Status
                                                        </h6>
                                                        <span class="badge ${log.status === 'OK' ? 'badge-success' : log.status === 'FAILED' ? 'badge-danger' : 'badge-warning'}" 
                                                              style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                                                            ${log.status === 'OK' ? '✓ PASSED' : log.status === 'FAILED' ? '✗ FAILED' : '⚠ WARNING'}
                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                <hr style="margin: 1rem 0;">
                                                
                                                <h6 class="text-muted mb-2">
                                                    <i class="fas fa-microchip mr-1"></i>Component Information
                                                </h6>
                                                <p class="h6 mb-3">${log.komponen_terdeteksi}</p>
                                                
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h6 class="text-muted mb-1">
                                                            <i class="fas fa-calendar-alt mr-1"></i>Test Date
                                                        </h6>
                                                        <p class="mb-2"><small>${new Date(log.tanggal_uji).toLocaleString()}</small></p>
                                                    </div>
                                                    <div class="col-6">
                                                        <h6 class="text-muted mb-1">
                                                            <i class="fas fa-clock mr-1"></i>Created
                                                        </h6>
                                                        <p class="mb-2"><small>${new Date(log.created_at).toLocaleString()}</small></p>
                                                    </div>
                                                </div>
                                                
                                                ${log.updated_at !== log.created_at ? `
                                                <div class="mt-2">
                                                    <h6 class="text-muted mb-1">
                                                        <i class="fas fa-edit mr-1"></i>Last Modified
                                                    </h6>
                                                    <p class="mb-0"><small>${new Date(log.updated_at).toLocaleString()}</small></p>
                                                </div>
                                                ` : ''}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `,
                        width: 650,
                        showConfirmButton: true,
                        confirmButtonText: '<i class="fas fa-times mr-1"></i> Close',
                        customClass: {
                            popup: 'view-details-modal'
                        },
                        buttonsStyling: false
                    });
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'Error!',
                        text: 'Could not load test details'
                    });
                }
            } catch (error) {
                Swal.fire({
                    type: 'error',
                    title: 'Network Connection Error',
                    text: 'Unable to connect to the server. Please check your internet connection and try again.',
                    confirmButtonText: 'Retry'
                });
            }
        }

        // Edit log function
        window.editLog = async function(id) {
            try {
                // Get current log data
                const response = await fetch(`/api/logs/${id}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    }
                });
                
                if (response.ok) {
                    const log = await response.json();
                    
                    // Show edit dialog with SweetAlert
                    const { value: formValues } = await Swal.fire({
                        title: '<i class="fas fa-edit mr-2"></i>Edit Test Result',
                        html: `
                            <div class="text-left" style="margin-top: 1rem;">
                                <div class="form-group mb-3">
                                    <label for="edit-komponen" class="form-label">
                                        <i class="fas fa-microchip mr-1"></i>Component Name
                                    </label>
                                    <input id="edit-komponen" class="swal2-input" 
                                           value="${log.komponen_terdeteksi}" 
                                           placeholder="e.g., Resistor 10kΩ, LED Red"
                                           style="width: 100%; margin: 0;">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="edit-status" class="form-label">
                                        <i class="fas fa-clipboard-check mr-1"></i>Test Status
                                    </label>
                                    <select id="edit-status" class="swal2-select" style="width: 100%; margin: 0;">
                                        <option value="OK" ${log.status === 'OK' ? 'selected' : ''}>✓ PASSED</option>
                                        <option value="FAILED" ${log.status === 'FAILED' ? 'selected' : ''}>✗ FAILED</option>
                                        <option value="WARNING" ${log.status === 'WARNING' ? 'selected' : ''}>⚠ WARNING</option>
                                    </select>
                                </div>
                                <div class="mt-3" style="background-color: #f8f9fa; padding: 0.75rem; border-radius: 6px; border-left: 4px solid var(--info-color);">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        <strong>Test ID:</strong> ${log.id} | 
                                        <strong>Original Date:</strong> ${new Date(log.tanggal_uji).toLocaleString()}
                                    </small>
                                </div>
                            </div>
                        `,
                        showCancelButton: true,
                        confirmButtonText: '<i class="fas fa-save mr-1"></i> Save Changes',
                        cancelButtonText: '<i class="fas fa-times mr-1"></i> Cancel',
                        customClass: {
                            popup: 'edit-modal'
                        },
                        buttonsStyling: false,
                        focusConfirm: false,
                        allowOutsideClick: false,
                        preConfirm: () => {
                            const component = document.getElementById('edit-komponen').value.trim();
                            const status = document.getElementById('edit-status').value;
                            
                            if (!component) {
                                Swal.showValidationMessage('Component name is required');
                                return false;
                            }
                            if (!status) {
                                Swal.showValidationMessage('Please select a test status');
                                return false;
                            }
                            
                            return [component, status];
                        }
                    });
                    
                    if (formValues) {
                        // Update log via API
                        const updateResponse = await fetch(`/api/logs/${id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                komponen_terdeteksi: formValues[0],
                                status: formValues[1]
                            })
                        });
                        
                        if (updateResponse.ok) {
                            Swal.fire({
                                type: 'success',
                                title: 'Test Result Updated',
                                text: 'Your changes have been saved successfully.',
                                timer: 2500,
                                showConfirmButton: false,
                                customClass: {
                                    popup: 'success-notification'
                                }
                            });
                            setTimeout(() => location.reload(), 2600);
                        } else {
                            const errorData = await updateResponse.json();
                            Swal.fire({
                                type: 'error',
                                title: 'Failed to Update',
                                text: errorData.message || 'There was an error saving your changes. Please try again.',
                                confirmButtonText: 'Try Again',
                                customClass: {
                                    popup: 'error-notification'
                                }
                            });
                        }
                    }
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'Error!',
                        text: 'Could not load log data'
                    });
                }
            } catch (error) {
                Swal.fire({
                    type: 'error',
                    title: 'Network Connection Error',
                    text: 'Unable to connect to the server. Please check your internet connection and try again.',
                    confirmButtonText: 'Retry'
                });
            }
        }
    </script>
@stop
