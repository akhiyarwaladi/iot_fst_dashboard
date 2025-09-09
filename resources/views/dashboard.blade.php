<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronic Component Tester Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .status-OK { color: #198754; }
        .status-FAILED { color: #dc3545; }
        .status-WARNING { color: #ffc107; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Electronic Component Tester Dashboard</h1>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Add New Test Log</h5>
                    </div>
                    <div class="card-body">
                        <form id="addLogForm">
                            <div class="mb-3">
                                <label for="komponen" class="form-label">Komponen Terdeteksi</label>
                                <input type="text" class="form-control" id="komponen" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="OK">OK</option>
                                    <option value="FAILED">FAILED</option>
                                    <option value="WARNING">WARNING</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Log</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Recent Test Logs</h5>
                        <button class="btn btn-secondary btn-sm" onclick="refreshLogs()">Refresh</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="logsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal Uji</th>
                                        <th>Komponen</th>
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
                                            <span class="badge 
                                                @if($log->status == 'OK') bg-success
                                                @elseif($log->status == 'FAILED') bg-danger
                                                @else bg-warning
                                                @endif">
                                                {{ $log->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-danger" onclick="deleteLog({{ $log->id }})">Delete</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>API Endpoints</h5>
                    </div>
                    <div class="card-body">
                        <p>Available API endpoints:</p>
                        <ul>
                            <li><strong>GET /api/logs</strong> - Get all logs</li>
                            <li><strong>POST /api/logs</strong> - Create new log</li>
                            <li><strong>GET /api/logs/{id}</strong> - Get specific log</li>
                            <li><strong>PUT /api/logs/{id}</strong> - Update log</li>
                            <li><strong>DELETE /api/logs/{id}</strong> - Delete log</li>
                            <li><strong>GET /api/logs/status/{status}</strong> - Filter logs by status</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Setup CSRF token for all AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
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
                    alert('Log added successfully!');
                    document.getElementById('addLogForm').reset();
                    location.reload();
                } else {
                    const errorData = await response.json();
                    alert('Error adding log: ' + (errorData.message || 'Unknown error'));
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        });
        
        async function deleteLog(id) {
            if (confirm('Are you sure you want to delete this log?')) {
                try {
                    const response = await fetch(`/api/logs/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    
                    if (response.ok) {
                        alert('Log deleted successfully!');
                        location.reload();
                    } else {
                        alert('Error deleting log');
                    }
                } catch (error) {
                    alert('Error: ' + error.message);
                }
            }
        }
        
        function refreshLogs() {
            location.reload();
        }
    </script>
</body>
</html>