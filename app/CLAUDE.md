# App Directory - Laravel Application Logic

## Overview
This directory contains the core Laravel application logic including Models, Controllers, and Service Providers. This is the heart of the IoT Component Tester application business logic.

## Directory Structure
```
app/
├── Http/
│   └── Controllers/
│       ├── Admin/
│       │   └── AdminController.php     # Admin dashboard controller
│       ├── Controller.php              # Base controller class
│       ├── LogTesterController.php     # Main API controller for test logs
│       └── WebController.php          # Web route controller
├── Models/
│   ├── LogTester.php                  # Component test log model
│   └── User.php                       # User model (default Laravel)
└── Providers/
    └── AppServiceProvider.php         # Application service provider
```

## Controllers

### 🔧 LogTesterController.php
**Purpose**: Main API controller for managing component test logs
**Endpoints**: All REST API operations for `/api/logs`

**Key Methods**:
- `index()` - GET /api/logs (get all logs)
- `store()` - POST /api/logs (create new log)
- `show($id)` - GET /api/logs/{id} (get specific log)
- `update($id)` - PUT /api/logs/{id} (update log)
- `destroy($id)` - DELETE /api/logs/{id} (delete log)
- `getByStatus($status)` - GET /api/logs/status/{status} (filter by status)

**Features**:
- ✅ JSON API responses
- ✅ Request validation
- ✅ Error handling
- ✅ Resource ordering (newest first)
- ✅ Status filtering

**Usage Example**:
```php
// This controller handles all API requests for component testing
// All methods return JSON responses
// Validation is handled automatically by Laravel
```

### 🖥️ WebController.php
**Purpose**: Handles web routes for the dashboard interface
**Routes**: Web pages (non-API)

**Key Methods**:
- `dashboard()` - Main dashboard view
- Other web-related methods

### 👤 AdminController.php
**Purpose**: Admin-specific dashboard functionality
**Location**: `app/Http/Controllers/Admin/`

**Key Methods**:
- `index()` - Admin dashboard view
- Admin-specific operations

### 🏛️ Controller.php
**Purpose**: Base controller class that all controllers extend
**Features**: Common controller functionality and middleware

## Models

### 📊 LogTester.php
**Purpose**: Eloquent model for component test logs
**Database Table**: `log_testers`

**Model Properties**:
```php
protected $fillable = [
    'komponen_terdeteksi',  // Component name
    'status'                // Test status (OK, FAILED, WARNING)
];

protected $casts = [
    'tanggal_uji' => 'datetime'  // Auto-cast to Carbon datetime
];
```

**Key Features**:
- ✅ Mass assignable fields defined
- ✅ Automatic timestamps (created_at, updated_at)
- ✅ DateTime casting for tanggal_uji field
- ✅ Eloquent ORM relationships ready

**Database Schema**:
- `id` - Primary key (auto-increment)
- `tanggal_uji` - Test timestamp (auto-generated)
- `komponen_terdeteksi` - Component name (string, 255 max)
- `status` - Test result (string, 50 max)
- `created_at` - Laravel timestamp
- `updated_at` - Laravel timestamp

**Usage Examples**:
```php
// Create new test log
LogTester::create([
    'komponen_terdeteksi' => 'Resistor 1kΩ',
    'status' => 'OK'
]);

// Get all logs ordered by newest
LogTester::orderBy('id', 'desc')->get();

// Filter by status
LogTester::where('status', 'FAILED')->get();
```

### 👤 User.php
**Purpose**: Default Laravel user model for authentication
**Status**: Standard Laravel user model (not currently used in this project)

## Providers

### ⚙️ AppServiceProvider.php
**Purpose**: Application service provider for bootstrapping services
**Key Methods**:
- `register()` - Register application services
- `boot()` - Bootstrap services after all providers registered

**Usage**: Configure application-wide services, bindings, and bootstrapping

## Key Features

### 🔒 Security Features
- **CSRF Protection**: Enabled for web routes
- **Mass Assignment Protection**: Fillable fields defined in models
- **SQL Injection Protection**: Eloquent ORM provides automatic protection
- **Input Validation**: Request validation in controllers

### 📊 Data Management
- **Eloquent ORM**: All database operations use Eloquent
- **Automatic Timestamps**: Laravel manages created_at/updated_at
- **Data Casting**: Automatic type casting for datetime fields
- **Query Builder**: Efficient database queries

### 🔄 API Design
- **RESTful Controllers**: Follow REST conventions
- **JSON Responses**: All API responses in JSON format
- **HTTP Status Codes**: Proper status codes (200, 201, 404, 422, etc.)
- **Error Handling**: Comprehensive error responses

## Development Notes

### 🛠️ Adding New Controllers
1. Use `php artisan make:controller ControllerName`
2. Extend base `Controller` class
3. Add to appropriate routes file
4. Follow existing naming conventions

### 📋 Adding New Models
1. Use `php artisan make:model ModelName -m` (includes migration)
2. Define fillable fields
3. Add relationships if needed
4. Set up casts for data types

### 🔧 Modifying Existing Logic

#### LogTesterController Modifications:
```php
// To add new validation rules:
$request->validate([
    'komponen_terdeteksi' => 'required|string|max:255',
    'status' => 'required|string|max:50|in:OK,FAILED,WARNING',
    // Add new validation rules here
]);

// To add new filtering methods:
public function getByDateRange($startDate, $endDate) {
    $logs = LogTester::whereBetween('tanggal_uji', [$startDate, $endDate])
                     ->orderBy('id', 'desc')
                     ->get();
    return response()->json($logs);
}
```

#### LogTester Model Modifications:
```php
// To add new fillable fields:
protected $fillable = [
    'komponen_terdeteksi',
    'status',
    'new_field_name'  // Add here
];

// To add new casts:
protected $casts = [
    'tanggal_uji' => 'datetime',
    'new_boolean_field' => 'boolean'
];

// To add model relationships:
public function relatedModel() {
    return $this->belongsTo(RelatedModel::class);
}
```

## Testing

### Unit Tests Location
- Tests for controllers: `tests/Feature/`
- Tests for models: `tests/Unit/`

### Testing Commands
```bash
# Run all tests
php artisan test

# Test specific class
php artisan test --filter=LogTesterControllerTest

# Test with coverage
php artisan test --coverage
```

## Performance Considerations

### Database Optimization
- Index on frequently queried fields (status, tanggal_uji)
- Use eager loading for relationships
- Paginate large result sets

### Controller Optimization
- Cache frequently accessed data
- Use database transactions for multiple operations
- Validate input efficiently

## Common Operations

### Creating New API Endpoints
1. Add method to LogTesterController
2. Add route in `routes/api.php`
3. Test with API client (Postman/cURL)
4. Update API documentation

### Adding Business Logic
1. Keep controllers thin - move complex logic to services
2. Use model observers for automatic actions
3. Implement caching where appropriate
4. Add proper error handling

## Dependencies
- **Laravel Framework**: Core framework functionality
- **Eloquent ORM**: Database operations
- **Carbon**: DateTime manipulation
- **Validation**: Input validation

## Integration Points
- **Routes**: Connected to `routes/api.php` and `routes/web.php`
- **Database**: Connected to `database/migrations/`
- **Views**: Admin controller connects to `resources/views/admin/`
- **Config**: Uses configuration from `config/` directory

This app directory structure follows Laravel best practices and is designed for scalability and maintainability.