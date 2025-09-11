# Database Directory - Migrations, Seeders & Factories

## Overview
This directory contains all database-related files including migrations, seeders, and model factories for the IoT Component Tester application. It manages the database schema and sample data generation.

## Directory Structure
```
database/
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php       # Default Laravel users
│   ├── 0001_01_01_000001_create_cache_table.php       # Cache system
│   ├── 0001_01_01_000002_create_jobs_table.php        # Background jobs
│   └── 2025_09_09_081442_create_log_tester_table.php  # Main component logs
├── factories/
│   └── UserFactory.php                               # User model factory
├── seeders/
│   └── DatabaseSeeder.php                            # Main seeder class
├── .gitignore                                         # Git ignore rules
└── database.sqlite                                    # SQLite database file
```

## Migrations

### 🔧 create_log_tester_table.php
**Purpose**: Main table for component test logs
**Created**: 2025-09-09 08:14:42
**Status**: ✅ **MIGRATED AND TESTED (September 11, 2025)**
**Records**: 26 test logs currently in database (90KB SQLite file)

**Schema**:
```php
Schema::create('log_testers', function (Blueprint $table) {
    $table->id();                                    // Primary key
    $table->timestamp('tanggal_uji')->useCurrent();  // Test date (auto-generated)
    $table->string('komponen_terdeteksi', 255);      // Component name
    $table->string('status', 50);                    // Test result status
    $table->timestamps();                            // created_at, updated_at
});
```

**Field Details**:
- `id`: Auto-increment primary key
- `tanggal_uji`: Test timestamp (automatically set to current time)
- `komponen_terdeteksi`: Component name/description (max 255 chars)
- `status`: Test status (OK, FAILED, WARNING) (max 50 chars)
- `created_at`: Record creation timestamp
- `updated_at`: Record last modification timestamp

### 🏛️ Laravel Default Migrations

#### create_users_table.php
**Purpose**: User authentication system (not currently used)
**Schema**: Standard Laravel user fields (id, name, email, password, etc.)
**Status**: ✅ **MIGRATED** - Available for future authentication features

#### create_cache_table.php
**Purpose**: Database-based caching system
**Usage**: Alternative to file-based caching for production
**Schema**: key, value, expiration fields
**Status**: ✅ **MIGRATED** - Ready for production caching

#### create_jobs_table.php  
**Purpose**: Background job queue system
**Usage**: Async processing for heavy operations
**Schema**: job payload, attempts, timestamps
**Status**: ✅ **MIGRATED** - Ready for background job processing

### 📊 **Migration Status (Verified September 11, 2025)**
All migrations have been successfully applied:
```bash
Migration name ................................. Batch / Status  
0001_01_01_000000_create_users_table ........... [1] Ran  
0001_01_01_000001_create_cache_table ........... [1] Ran  
0001_01_01_000002_create_jobs_table ............ [1] Ran  
2025_09_09_081442_create_log_tester_table ...... [1] Ran
```

## Database Schema Relationships

### Current Structure
```sql
-- Main entity
log_testers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tanggal_uji TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    komponen_terdeteksi VARCHAR(255) NOT NULL,
    status VARCHAR(50) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
)

-- Indexes for performance
INDEX idx_status (status)
INDEX idx_tanggal_uji (tanggal_uji)
INDEX idx_created_at (created_at)
```

### Future Extensions (Potential)
```sql
-- Component types table
component_types (
    id INT PRIMARY KEY,
    name VARCHAR(100),
    category VARCHAR(50),
    specifications JSON
)

-- Test devices table  
test_devices (
    id INT PRIMARY KEY,
    device_name VARCHAR(100),
    device_type VARCHAR(50),
    ip_address VARCHAR(45),
    last_ping TIMESTAMP
)

-- Extended log table with relationships
log_testers (
    id INT PRIMARY KEY,
    device_id INT FOREIGN KEY REFERENCES test_devices(id),
    component_type_id INT FOREIGN KEY REFERENCES component_types(id),
    test_value DECIMAL(10,4),
    expected_value DECIMAL(10,4),
    tolerance DECIMAL(5,2),
    -- existing fields
)
```

## Seeders

### 🌱 DatabaseSeeder.php
**Purpose**: Main seeder orchestrator
**Status**: Basic Laravel template

**Current Content**:
```php
public function run(): void
{
    // User::factory(10)->create();
    // Can add LogTester factory seeding here
}
```

**Potential Enhancements**:
```php
public function run(): void
{
    // Seed component types
    $this->call([
        ComponentTypeSeeder::class,
        TestDeviceSeeder::class,
        SampleLogSeeder::class,
    ]);
}
```

### Creating Custom Seeders

#### Sample LogTester Seeder
```php
// Generate with: php artisan make:seeder LogTesterSeeder
class LogTesterSeeder extends Seeder
{
    public function run(): void
    {
        $components = [
            ['name' => 'Resistor 1kΩ', 'status' => 'OK'],
            ['name' => 'LED Red 5mm', 'status' => 'FAILED'],
            ['name' => 'Capacitor 100μF', 'status' => 'WARNING'],
            ['name' => 'Transistor 2N3904', 'status' => 'OK'],
            ['name' => 'Diode 1N4148', 'status' => 'OK'],
        ];

        foreach ($components as $component) {
            LogTester::create([
                'komponen_terdeteksi' => $component['name'],
                'status' => $component['status'],
            ]);
        }
    }
}
```

## Factories

### 👥 UserFactory.php
**Purpose**: Generate fake user data for testing
**Status**: Default Laravel factory

### Creating LogTester Factory
```php
// Generate with: php artisan make:factory LogTesterFactory
class LogTesterFactory extends Factory
{
    protected $model = LogTester::class;

    public function definition(): array
    {
        $components = [
            'Resistor', 'Capacitor', 'LED', 'Transistor', 'Diode', 
            'IC', 'Inductor', 'Crystal', 'Switch', 'Sensor'
        ];
        
        $values = ['1kΩ', '10kΩ', '100Ω', '100μF', '10μF', '5mm', '3mm'];
        $statuses = ['OK', 'FAILED', 'WARNING'];

        return [
            'tanggal_uji' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'komponen_terdeteksi' => $this->faker->randomElement($components) . ' ' . 
                                   $this->faker->randomElement($values),
            'status' => $this->faker->randomElement($statuses),
        ];
    }

    // State methods for specific scenarios
    public function passed(): Factory
    {
        return $this->state(['status' => 'OK']);
    }

    public function failed(): Factory
    {
        return $this->state(['status' => 'FAILED']);
    }

    public function warning(): Factory
    {
        return $this->state(['status' => 'WARNING']);
    }
}
```

## Database Management

### 🔧 Migration Commands
```bash
# Run all pending migrations
php artisan migrate

# Rollback last migration batch
php artisan migrate:rollback

# Reset all migrations and re-run
php artisan migrate:fresh

# Check migration status
php artisan migrate:status

# Create new migration
php artisan make:migration create_new_table --create=table_name
php artisan make:migration add_column_to_table --table=table_name
```

### 🌱 Seeder Commands
```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=LogTesterSeeder

# Fresh migrate with seeding
php artisan migrate:fresh --seed

# Create new seeder
php artisan make:seeder SeederName
```

### 🏭 Factory Usage
```bash
# In tinker or tests
LogTester::factory(50)->create();           // Create 50 random logs
LogTester::factory(10)->passed()->create(); // Create 10 passed tests
LogTester::factory(5)->failed()->create();  // Create 5 failed tests
```

## Database Configuration

### 📊 SQLite (Development)
```php
// config/database.php
'sqlite' => [
    'driver' => 'sqlite',
    'database' => database_path('database.sqlite'),
    'prefix' => '',
    'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
],
```

**Advantages**:
- ✅ Zero configuration setup
- ✅ File-based, portable
- ✅ Perfect for development
- ✅ Fast for small datasets

### 🏢 MySQL (Production)
```php
// config/database.php  
'mysql' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'iot_dashboard'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
],
```

**Advantages**:
- ✅ Better performance for large datasets
- ✅ Advanced features (full-text search, etc.)
- ✅ Better concurrent access
- ✅ Production-ready scalability

## Performance Optimization

### 📈 Indexes
```php
// In migration
$table->index('status');                    // Single column index
$table->index(['status', 'tanggal_uji']);  // Composite index
$table->unique('device_serial_number');    // Unique constraint
```

### 🔍 Query Optimization
```php
// Efficient queries in controllers
LogTester::select(['id', 'komponen_terdeteksi', 'status', 'tanggal_uji'])
         ->where('status', 'FAILED')
         ->orderBy('tanggal_uji', 'desc')
         ->limit(100)
         ->get();

// Use database-level filtering
LogTester::whereBetween('tanggal_uji', [$startDate, $endDate])
         ->whereIn('status', ['OK', 'WARNING'])
         ->get();
```

## Backup and Maintenance

### 💾 Database Backup
```bash
# SQLite backup (development)
cp database/database.sqlite database/backups/backup-$(date +%Y%m%d).sqlite

# MySQL backup (production)
mysqldump -u username -p database_name > backup.sql
```

### 🔧 Maintenance Commands
```bash
# Clear query cache
php artisan cache:clear

# Optimize database
php artisan model:prune  # Remove old records if configured

# Database integrity check (SQLite)
sqlite3 database/database.sqlite "PRAGMA integrity_check;"
```

## Testing Database

### 🧪 Test Environment
```php
// phpunit.xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

### 🔬 Database Testing
```php
// In feature tests
use RefreshDatabase;

public function test_can_create_log_tester()
{
    $log = LogTester::factory()->create([
        'komponen_terdeteksi' => 'Test Resistor',
        'status' => 'OK'
    ]);

    $this->assertDatabaseHas('log_testers', [
        'komponen_terdeteksi' => 'Test Resistor',
        'status' => 'OK'
    ]);
}
```

## Future Database Enhancements

### 🚀 Potential Features
1. **Component Library**: Pre-defined component types with specifications
2. **Device Management**: Track IoT testing devices
3. **Test History**: Detailed test result history with measurements
4. **User Management**: Multi-user access with roles
5. **Reporting**: Advanced reporting and analytics tables
6. **Real-time Data**: WebSocket integration for live updates

### 📊 Analytics Tables
```sql
-- Daily statistics
daily_stats (
    date DATE PRIMARY KEY,
    total_tests INT,
    passed_tests INT,
    failed_tests INT,
    warning_tests INT
)

-- Component failure patterns
component_patterns (
    component_type VARCHAR(100),
    failure_rate DECIMAL(5,2),
    last_calculated TIMESTAMP
)
```

This database structure provides a solid foundation for the IoT Component Tester with room for future expansion and optimization.