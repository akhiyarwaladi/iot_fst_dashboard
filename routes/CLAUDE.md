# Routes Directory - API and Web Routes

## Overview
This directory contains all route definitions for the IoT Component Tester application, including REST API endpoints for IoT device integration and web routes for the dashboard interface.

## Route Files

### 🌐 api.php
**Purpose**: REST API routes for IoT device integration
**Prefix**: `/api`
**Status**: ✅ All endpoints tested and working

**Current Routes**:
```php
Route::prefix('logs')->group(function () {
    Route::get('/', [LogTesterController::class, 'index']);           // GET /api/logs
    Route::post('/', [LogTesterController::class, 'store']);          // POST /api/logs
    Route::get('/{id}', [LogTesterController::class, 'show']);        // GET /api/logs/{id}
    Route::put('/{id}', [LogTesterController::class, 'update']);      // PUT /api/logs/{id}
    Route::delete('/{id}', [LogTesterController::class, 'destroy']);  // DELETE /api/logs/{id}
    Route::get('/status/{status}', [LogTesterController::class, 'getByStatus']); // GET /api/logs/status/{status}
});
```

**Route Details**:

#### 📊 GET /api/logs
- **Controller**: `LogTesterController@index`
- **Purpose**: Retrieve all component test logs
- **Response**: JSON array of log objects
- **Features**: Ordered by newest first
- **Status**: ✅ Working (200 OK)

#### ➕ POST /api/logs  
- **Controller**: `LogTesterController@store`
- **Purpose**: Create new component test log
- **Request**: JSON with `komponen_terdeteksi` and `status`
- **Response**: Created log object with ID
- **Validation**: Required fields, max lengths
- **Status**: ✅ Working (201 Created)

#### 🔍 GET /api/logs/{id}
- **Controller**: `LogTesterController@show`
- **Purpose**: Retrieve specific log by ID
- **Parameters**: `id` - Log identifier
- **Response**: Single log object
- **Error**: 404 if not found
- **Status**: ✅ Working (200 OK)

#### ✏️ PUT /api/logs/{id}
- **Controller**: `LogTesterController@update`  
- **Purpose**: Update existing log
- **Parameters**: `id` - Log identifier
- **Request**: JSON with fields to update
- **Response**: Updated log object
- **Status**: ✅ Working (200 OK)

#### 🗑️ DELETE /api/logs/{id}
- **Controller**: `LogTesterController@destroy`
- **Purpose**: Delete log by ID
- **Parameters**: `id` - Log identifier
- **Response**: Success message
- **Status**: ✅ Working (200 OK)

#### 🔎 GET /api/logs/status/{status}
- **Controller**: `LogTesterController@getByStatus`
- **Purpose**: Filter logs by test status
- **Parameters**: `status` - OK, FAILED, or WARNING
- **Response**: JSON array of filtered logs
- **Status**: ✅ Working (200 OK)

### 🌍 web.php
**Purpose**: Web routes for dashboard and UI
**Middleware**: Web middleware group (sessions, CSRF, etc.)

**Current Routes**:
```php
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [WebController::class, 'dashboard']);
Route::get('/admin/dashboard', [AdminController::class, 'index']);
```

**Route Details**:

#### 🏠 GET /
- **Purpose**: Application landing page
- **View**: `welcome.blade.php`
- **Status**: Default Laravel welcome

#### 📊 GET /dashboard  
- **Controller**: `WebController@dashboard`
- **Purpose**: Basic dashboard view
- **View**: `dashboard.blade.php`
- **Features**: Bootstrap-based interface

#### 🖥️ GET /admin/dashboard
- **Controller**: `AdminController@index`
- **Purpose**: Modern AdminLTE dashboard
- **View**: `admin/dashboard.blade.php`
- **Features**: AdminLTE v4 flat design, full functionality
- **Status**: ✅ Primary dashboard interface

### 🖥️ console.php
**Purpose**: Artisan console commands
**Status**: Default Laravel console route definitions

## API Route Testing

### ✅ Complete Test Results
All API endpoints have been thoroughly tested:

| Method | Endpoint | Status | Response Code | Functionality |
|--------|----------|---------|---------------|--------------|
| GET | `/api/logs` | ✅ Working | 200 | Returns all logs |
| POST | `/api/logs` | ✅ Working | 201 | Creates new log |
| GET | `/api/logs/{id}` | ✅ Working | 200 | Returns specific log |
| PUT | `/api/logs/{id}` | ✅ Working | 200 | Updates log |
| DELETE | `/api/logs/{id}` | ✅ Working | 200 | Deletes log |
| GET | `/api/logs/status/{status}` | ✅ Working | 200 | Filters by status |

### 🔒 Error Handling
- **404 Not Found**: Invalid log ID
- **422 Validation Error**: Missing or invalid fields
- **500 Internal Error**: Server-side errors

## Route Middleware

### 🛡️ API Routes
```php
// api.php routes automatically get:
Route::middleware('api')->group(function () {
    // API routes here
});
```

**API Middleware Features**:
- ✅ JSON response formatting
- ✅ Rate limiting (configurable)
- ✅ CORS handling
- ✅ Content-Type validation

### 🌐 Web Routes
```php
// web.php routes automatically get:
Route::middleware('web')->group(function () {
    // Web routes here
});
```

**Web Middleware Features**:
- ✅ Session management
- ✅ CSRF protection
- ✅ Cookie encryption
- ✅ View error handling

## Route Groups and Organization

### 🔗 API Route Grouping
```php
// Current organization
Route::prefix('logs')->group(function () {
    // All log-related routes
});

// Future expansion possibilities
Route::prefix('devices')->group(function () {
    Route::get('/', [DeviceController::class, 'index']);
    Route::post('/', [DeviceController::class, 'store']);
    // Device management routes
});

Route::prefix('reports')->group(function () {
    Route::get('/daily', [ReportController::class, 'daily']);
    Route::get('/weekly', [ReportController::class, 'weekly']);
    // Reporting routes
});
```

### 📊 Web Route Organization
```php
// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index']);
    Route::get('/settings', [AdminController::class, 'settings']);
    // Admin-specific routes
});

// Public routes
Route::get('/', function () {
    return view('welcome');
});
Route::get('/about', [WebController::class, 'about']);
```

## Adding New Routes

### 🔧 Adding API Endpoints
1. **Add route to `api.php`**:
```php
Route::get('/api/logs/export', [LogTesterController::class, 'export']);
```

2. **Add controller method**:
```php
public function export()
{
    $logs = LogTester::all();
    return response()->json($logs);
}
```

3. **Test the endpoint**:
```bash
curl -X GET "http://localhost:8000/api/logs/export" \
  -H "Accept: application/json"
```

### 🌐 Adding Web Routes  
1. **Add route to `web.php`**:
```php
Route::get('/reports', [WebController::class, 'reports']);
```

2. **Add controller method**:
```php
public function reports()
{
    $logs = LogTester::all();
    return view('reports', compact('logs'));
}
```

3. **Create view file**: `resources/views/reports.blade.php`

## Route Caching and Performance

### ⚡ Route Optimization
```bash
# Cache routes for production
php artisan route:cache

# Clear route cache
php artisan route:clear

# List all routes
php artisan route:list

# List API routes only
php artisan route:list --name=api
```

### 📊 Route Performance
```php
// Efficient route definitions
Route::get('/api/logs/{id}', [LogTesterController::class, 'show'])
     ->where('id', '[0-9]+')  // Constrain parameter to numbers
     ->name('api.logs.show'); // Named route for reverse lookups
```

## Security Considerations

### 🔐 API Security
```php
// Rate limiting
Route::middleware(['throttle:60,1'])->group(function () {
    // Limited to 60 requests per minute
});

// CORS configuration (in config/cors.php)
'paths' => ['api/*'],
'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE'],
'allowed_origins' => ['http://localhost:3000', 'https://your-domain.com'],
```

### 🛡️ Web Security
```php
// CSRF protection (automatic for web routes)
Route::post('/contact', [ContactController::class, 'store'])
     ->middleware('csrf');

// Authentication (if needed in future)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
});
```

## Route Documentation

### 📋 API Route Documentation
For comprehensive API documentation, see:
- **Main API Docs**: `API_DOCUMENTATION.md` in project root
- **Interactive Testing**: Use Postman collection
- **OpenAPI Spec**: Available for API documentation tools

### 🗺️ Route Mapping
```bash
# View all available routes
php artisan route:list

# Filter by specific patterns
php artisan route:list --name=admin
php artisan route:list --path=api
```

## Testing Routes

### 🧪 Automated Testing
```php
// In tests/Feature/ApiTest.php
public function test_can_get_all_logs()
{
    $response = $this->getJson('/api/logs');
    $response->assertStatus(200);
}

public function test_can_create_log()
{
    $data = [
        'komponen_terdeteksi' => 'Test Component',
        'status' => 'OK'
    ];
    
    $response = $this->postJson('/api/logs', $data);
    $response->assertStatus(201);
}
```

### 🔍 Manual Testing  
```bash
# Test API endpoints
curl -X GET "http://localhost:8000/api/logs"
curl -X POST "http://localhost:8000/api/logs" -H "Content-Type: application/json" -d '{"komponen_terdeteksi":"Test","status":"OK"}'

# Test web routes
curl -X GET "http://localhost:8000/admin/dashboard"
```

## Future Route Extensions

### 🚀 Planned API Extensions
```php
// Device management
Route::prefix('devices')->group(function () {
    Route::get('/', [DeviceController::class, 'index']);
    Route::post('/register', [DeviceController::class, 'register']);
    Route::get('/{id}/status', [DeviceController::class, 'status']);
});

// Analytics and reporting
Route::prefix('analytics')->group(function () {
    Route::get('/summary', [AnalyticsController::class, 'summary']);
    Route::get('/trends', [AnalyticsController::class, 'trends']);
    Route::get('/export/{format}', [AnalyticsController::class, 'export']);
});

// Real-time features
Route::prefix('realtime')->group(function () {
    Route::get('/status', [RealtimeController::class, 'status']);
    Route::post('/broadcast', [RealtimeController::class, 'broadcast']);
});
```

### 📊 Enhanced Web Routes
```php
// User management (when authentication is added)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/settings', [SettingsController::class, 'index']);
    Route::get('/reports', [ReportController::class, 'index']);
});

// Public API documentation
Route::get('/api/docs', [DocsController::class, 'api']);
Route::get('/api/playground', [DocsController::class, 'playground']);
```

This routes directory provides a clean, RESTful API interface for IoT devices and a comprehensive web interface for dashboard management, with room for future expansion and enhanced functionality.