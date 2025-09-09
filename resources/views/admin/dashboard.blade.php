@extends('adminlte::page')

@section('title', 'Electronic Component Tester Dashboard')

@section('content_header')
    <h1>Electronic Component Tester Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Add New Test Log Card -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add New Test Log</h3>
                </div>
                <div class="card-body">
                    <form id="addLogForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="komponen">Komponen Terdeteksi</label>
                                    <input type="text" class="form-control" id="komponen" placeholder="Enter component name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" required>
                                        <option value="">Select Status</option>
                                        <option value="OK">OK</option>
                                        <option value="FAILED">FAILED</option>
                                        <option value="WARNING">WARNING</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">Add Log</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Stats Cards -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="totalLogs">{{ $logs->count() }}</h3>
                    <p>Total Tests</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="okLogs">{{ $logs->where('status', 'OK')->count() }}</h3>
                    <p>Passed Tests</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="failedLogs">{{ $logs->where('status', 'FAILED')->count() }}</h3>
                    <p>Failed Tests</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 id="warningLogs">{{ $logs->where('status', 'WARNING')->count() }}</h3>
                    <p>Warning Tests</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- Recent Test Logs -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Test Logs</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" onclick="refreshLogs()">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="logsTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Test Date</th>
                                <th>Component</th>
                                <th>Status</th>
                                <th>Actions</th>
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
                                        <span class="badge badge-success">{{ $log->status }}</span>
                                    @elseif($log->status == 'FAILED')
                                        <span class="badge badge-danger">{{ $log->status }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ $log->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="editLog({{ $log->id }})">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="testDelete({{ $log->id }})">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <!-- API Documentation -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">API Endpoints</h3>
                </div>
                <div class="card-body">
                    <p>Available REST API endpoints for IoT integration:</p>
                    <ul class="list-unstyled">
                        <li><code class="text-primary">GET /api/logs</code> - Get all logs</li>
                        <li><code class="text-success">POST /api/logs</code> - Create new log</li>
                        <li><code class="text-info">GET /api/logs/{id}</code> - Get specific log</li>
                        <li><code class="text-warning">PUT /api/logs/{id}</code> - Update log</li>
                        <li><code class="text-danger">DELETE /api/logs/{id}</code> - Delete log</li>
                        <li><code class="text-secondary">GET /api/logs/status/{status}</code> - Filter by status</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Quick Stats -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">System Status</h3>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue"><i class="fas fa-server"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Database</span>
                            <span class="info-box-number">Connected</span>
                        </div>
                    </div>
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fas fa-wifi"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">API Status</span>
                            <span class="info-box-number">Active</span>
                        </div>
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
        
        // Initialize DataTable
        $(document).ready(function() {
            $('#logsTable').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "order": [[ 0, "desc" ]],
                "pageLength": 10
            });
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