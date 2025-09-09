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
                    <p>Components w/ Warning</p>
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
                                        <button class="btn btn-sm btn-outline-danger" onclick="testDelete({{ $log->id }})" title="Delete Test Result">
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
                    <div class="text-center py-4">
                        <i class="fas fa-flask fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Test Results Yet</h4>
                        <p class="text-muted">Start by adding your first component test above.</p>
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
                        <div class="endpoint-item mb-2">
                            <span class="badge bg-primary me-2">GET</span>
                            <code>/api/logs</code>
                            <small class="text-muted d-block">Retrieve all test results</small>
                        </div>
                        <div class="endpoint-item mb-2">
                            <span class="badge bg-success me-2">POST</span>
                            <code>/api/logs</code>
                            <small class="text-muted d-block">Submit new test result</small>
                        </div>
                        <div class="endpoint-item mb-2">
                            <span class="badge bg-info me-2">GET</span>
                            <code>/api/logs/{id}</code>
                            <small class="text-muted d-block">Get specific test result</small>
                        </div>
                        <div class="endpoint-item mb-2">
                            <span class="badge bg-warning me-2">PUT</span>
                            <code>/api/logs/{id}</code>
                            <small class="text-muted d-block">Update test result</small>
                        </div>
                        <div class="endpoint-item mb-2">
                            <span class="badge bg-danger me-2">DELETE</span>
                            <code>/api/logs/{id}</code>
                            <small class="text-muted d-block">Remove test result</small>
                        </div>
                        <div class="endpoint-item">
                            <span class="badge bg-secondary me-2">GET</span>
                            <code>/api/logs/status/{status}</code>
                            <small class="text-muted d-block">Filter by test status</small>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <a href="/api-docs" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-book mr-1"></i> View Full Documentation
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
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Log added successfully!',
                        timer: 1500
                    });
                    
                    // Reset form and reload page
                    document.getElementById('addLogForm').reset();
                    setTimeout(() => location.reload(), 1600);
                } else {
                    const errorData = await response.json();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorData.message || 'Error adding log'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Network error: ' + error.message
                });
            }
        });
        
        // Delete log function
        window.deleteLog = async function(id) {
            console.log('Delete function called with ID:', id);
            
            // Check if Swal is loaded
            if (typeof Swal === 'undefined') {
                console.log('SweetAlert2 not loaded, using confirm');
                if (confirm('Are you sure you want to delete this log?')) {
                    deleteLogRequest(id);
                }
                return;
            }
            
            console.log('Using SweetAlert2');
            const result = await Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            });
            
            if (result.isConfirmed) {
                console.log('User confirmed delete');
                deleteLogRequest(id);
            } else {
                console.log('User cancelled delete');
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
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Log has been deleted.',
                            timer: 1500
                        });
                        setTimeout(() => location.reload(), 1600);
                    } else {
                        alert('Log deleted successfully!');
                        location.reload();
                    }
                } else {
                    console.log('Delete failed');
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'Error deleting log'
                        });
                    } else {
                        alert('Error: ' + (data.message || 'Error deleting log'));
                    }
                }
            } catch (error) {
                console.error('Delete error:', error);
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Network error: ' + error.message
                    });
                } else {
                    alert('Network error: ' + error.message);
                }
            }
        }
        
        // Simple test delete function
        window.testDelete = function(id) {
            console.log('Test delete called with ID:', id);
            
            if (confirm('Are you sure you want to delete this log?')) {
                console.log('User confirmed, making DELETE request');
                
                fetch(`/api/logs/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    alert('Log deleted successfully!');
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting log: ' + error.message);
                });
            } else {
                console.log('User cancelled');
            }
        }
        
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
                        title: 'Test Result Details',
                        html: `
                            <div class="text-left">
                                <p><strong>Test ID:</strong> #${log.id}</p>
                                <p><strong>Component:</strong> ${log.komponen_terdeteksi}</p>
                                <p><strong>Test Status:</strong> 
                                    <span class="badge ${log.status === 'OK' ? 'badge-success' : log.status === 'FAILED' ? 'badge-danger' : 'badge-warning'}">
                                        ${log.status}
                                    </span>
                                </p>
                                <p><strong>Test Date:</strong> ${new Date(log.tanggal_uji).toLocaleString()}</p>
                                <p><strong>Created:</strong> ${new Date(log.created_at).toLocaleString()}</p>
                                ${log.updated_at !== log.created_at ? `<p><strong>Last Modified:</strong> ${new Date(log.updated_at).toLocaleString()}</p>` : ''}
                            </div>
                        `,
                        width: 600,
                        showConfirmButton: true,
                        confirmButtonText: 'Close',
                        confirmButtonColor: '#6c757d'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Could not load test details'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Network error: ' + error.message
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
                        title: 'Edit Test Log',
                        html: `
                            <div class="form-group">
                                <label for="edit-komponen">Component:</label>
                                <input id="edit-komponen" class="form-control" value="${log.komponen_terdeteksi}">
                            </div>
                            <div class="form-group">
                                <label for="edit-status">Status:</label>
                                <select id="edit-status" class="form-control">
                                    <option value="OK" ${log.status === 'OK' ? 'selected' : ''}>OK</option>
                                    <option value="FAILED" ${log.status === 'FAILED' ? 'selected' : ''}>FAILED</option>
                                    <option value="WARNING" ${log.status === 'WARNING' ? 'selected' : ''}>WARNING</option>
                                </select>
                            </div>
                        `,
                        focusConfirm: false,
                        preConfirm: () => {
                            return [
                                document.getElementById('edit-komponen').value,
                                document.getElementById('edit-status').value
                            ]
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
                                icon: 'success',
                                title: 'Updated!',
                                text: 'Log has been updated.',
                                timer: 1500
                            });
                            setTimeout(() => location.reload(), 1600);
                        } else {
                            const errorData = await updateResponse.json();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: errorData.message || 'Error updating log'
                            });
                        }
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Could not load log data'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Network error: ' + error.message
                });
            }
        }
    </script>
@stop