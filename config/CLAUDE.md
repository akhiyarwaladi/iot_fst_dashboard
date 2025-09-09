# Config Directory - Application Configuration

## Overview
This directory contains all Laravel configuration files that control various aspects of the IoT Component Tester application, including database connections, AdminLTE settings, caching, and other services.

## Configuration Files

### 🎛️ adminlte.php
**Purpose**: AdminLTE v4 dashboard configuration
**Status**: ✅ Customized for IoT Component Tester

**Key Settings**:
```php
'title' => 'IoT Component Tester',
'logo' => '<b>IoT</b> FST',
'classes_sidebar' => 'sidebar-light-primary elevation-1',  // Modern flat design
```

**Important Configurations**:
- **Branding**: Custom title and logo for IoT FST
- **Theme**: Light theme with minimal elevation for flat design
- **Sidebar**: Light primary theme with modern styling
- **Menu Structure**: Component tester navigation
- **Plugins**: DataTables, SweetAlert2 enabled

**Menu Configuration**:
```php
'menu' => [
    [
        'text' => 'Component Tester',
        'url' => 'admin/dashboard',
        'icon' => 'fas fa-fw fa-microchip',
    ],
    // Additional menu items
]
```

### 🗄️ database.php
**Purpose**: Database connection configurations
**Default**: SQLite for development, MySQL for production

**Current Setup**:
```php
'default' => env('DB_CONNECTION', 'sqlite'),
'connections' => [
    'sqlite' => [
        'driver' => 'sqlite',
        'database' => database_path('database.sqlite'),
    ],
    'mysql' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'database' => env('DB_DATABASE', 'iot_dashboard'),
    ]
]
```

### 🏗️ app.php
**Purpose**: Core application configuration
**Key Settings**:
- **App Name**: Laravel (can be customized)
- **Environment**: Local/Production
- **Debug Mode**: Enabled in development
- **Timezone**: UTC (configurable)
- **Locale**: English (en)

### 🔐 auth.php
**Purpose**: Authentication configuration
**Status**: Default Laravel auth (not currently used)
**Future**: Ready for user authentication if needed

### 📊 cache.php
**Purpose**: Caching configuration
**Default Driver**: File-based caching
**Options**: Redis, Memcached available for production

### 📁 filesystems.php
**Purpose**: File storage configuration
**Default**: Local disk storage
**Cloud Options**: S3, Google Cloud Storage available

### 📮 mail.php
**Purpose**: Email configuration
**Default**: SMTP configuration
**Usage**: Future notifications and alerts

### 📝 logging.php
**Purpose**: Application logging configuration
**Default**: Daily log files in storage/logs/
**Levels**: Emergency, Alert, Critical, Error, Warning, Notice, Info, Debug

### 🔄 queue.php
**Purpose**: Queue configuration for background jobs
**Default**: Sync (immediate execution)
**Options**: Redis, Database queues for production

### 🔒 services.php
**Purpose**: Third-party service configurations
**Usage**: API keys and external service settings

### 🛡️ session.php
**Purpose**: Session management configuration
**Driver**: File-based sessions
**Lifetime**: 120 minutes default

## Environment-Specific Configuration

### 🔧 .env Configuration
Key environment variables used by config files:

```bash
# Application
APP_NAME="IoT Component Tester"
APP_ENV=local
APP_KEY=base64:generated-key
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/database/database.sqlite

# Cache & Sessions
CACHE_DRIVER=file
SESSION_DRIVER=file

# Mail (if needed)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
```

## AdminLTE Customization

### 🎨 Design Configuration
The AdminLTE config has been customized for modern flat design:

**Theme Settings**:
```php
// Light theme with minimal shadows
'classes_sidebar' => 'sidebar-light-primary elevation-1',
'classes_topnav' => 'navbar-white navbar-light',

// Custom branding
'title' => 'IoT Component Tester',
'logo' => '<b>IoT</b> FST',
'logo_img_class' => 'brand-image img-circle elevation-1',
```

**Plugin Configuration**:
```php
'plugins' => [
    'Datatables' => [
        'active' => true,
        'files' => [
            [
                'type' => 'js',
                'asset' => true,
                'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
            ],
            [
                'type' => 'css',
                'asset' => true,
                'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
            ],
        ],
    ],
    'Sweetalert2' => [
        'active' => true,
        'files' => [
            [
                'type' => 'js',
                'asset' => true,
                'location' => '//cdn.jsdelivr.net/npm/sweetalert2@11',
            ],
        ],
    ],
],
```

## Development vs Production

### 🔧 Development Configuration
- **Debug Mode**: Enabled for detailed error messages
- **Database**: SQLite for easy setup
- **Cache**: File-based caching
- **Mail**: Log driver (emails saved to logs)
- **Session**: File-based sessions

### 🚀 Production Configuration
- **Debug Mode**: Disabled for security
- **Database**: MySQL/PostgreSQL for performance
- **Cache**: Redis/Memcached for speed
- **Mail**: SMTP for real email sending
- **Session**: Redis/Database for scalability

## Configuration Best Practices

### 🔐 Security
```php
// Never commit sensitive values to config files
// Use environment variables instead
'api_key' => env('EXTERNAL_API_KEY'),
'secret' => env('APP_SECRET'),
```

### ⚡ Performance
```php
// Cache configuration in production
php artisan config:cache

// Clear configuration cache during development
php artisan config:clear
```

### 🔄 Environment Management
```bash
# Different .env files for different environments
.env                # Development
.env.production     # Production
.env.testing        # Testing
```

## Customizing Configurations

### Adding New Config Files
```bash
# Create new config file
php artisan make:config CustomConfig

# Usage in application
$value = config('custom-config.setting');
```

### Modifying Existing Configs
```php
// In config/app.php - add custom settings
'custom_settings' => [
    'iot_device_timeout' => env('IOT_TIMEOUT', 30),
    'max_test_logs' => env('MAX_LOGS', 1000),
    'enable_realtime' => env('REALTIME_ENABLED', false),
],
```

### Environment-Specific Overrides
```php
// Use different values based on environment
'cache_ttl' => env('APP_ENV') === 'production' ? 3600 : 60,
'log_level' => env('APP_ENV') === 'production' ? 'warning' : 'debug',
```

## Troubleshooting

### 🐛 Common Issues
1. **Config Cache**: Clear with `php artisan config:clear`
2. **Environment Variables**: Check `.env` file exists and is readable
3. **Database Connection**: Verify database file exists for SQLite
4. **AdminLTE Assets**: Ensure vendor assets are published

### 🔍 Debug Commands
```bash
# View current configuration
php artisan config:show

# Check specific config
php artisan tinker
>>> config('adminlte.title')
>>> config('database.default')

# Clear all caches
php artisan optimize:clear
```

## Integration Points

### 🔗 Used By
- **Controllers**: Access via `config()` helper
- **Views**: Available through Laravel blade directives
- **Models**: Database configuration for connections
- **Services**: External API configurations

### 📋 Dependencies
- **Environment Variables**: `.env` file
- **Vendor Packages**: AdminLTE, Laravel framework
- **Storage**: File system for caching and sessions

This config directory ensures the IoT Component Tester runs optimally in both development and production environments with proper AdminLTE integration and modern flat design configuration.