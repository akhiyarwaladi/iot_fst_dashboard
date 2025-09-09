# 🔧 IoT Component Tester API Documentation

## 📋 Table of Contents
- [API Overview](#api-overview)
- [Quick Start](#quick-start)
- [Authentication](#authentication)
- [Base URL & Headers](#base-url--headers)
- [API Endpoints](#api-endpoints)
- [Data Models](#data-models)
- [Error Handling](#error-handling)
- [Code Examples](#code-examples)
- [Testing Guide](#testing-guide)
- [Performance & Best Practices](#performance--best-practices)

---

## 🚀 API Overview

**IoT Component Tester API** menyediakan endpoint RESTful untuk mengelola hasil pengujian komponen elektronik dari perangkat IoT. API ini mendukung operasi CRUD lengkap dan integrasi real-time dengan peralatan testing.

### Key Features
- ✅ **RESTful Design** - Menggunakan HTTP methods dan status codes standar
- ✅ **JSON API** - Semua request dan response menggunakan format JSON
- ✅ **Real-time Integration** - Dioptimalkan untuk submission dari IoT device
- ✅ **Comprehensive Filtering** - Filter hasil berdasarkan status dan kriteria lain
- ✅ **Validation** - Built-in request validation dan error handling
- ✅ **Laravel Framework** - Backend PHP yang secure dan scalable

### API Specifications
- **Version**: `1.1.0`
- **Protocol**: `HTTP/HTTPS`
- **Data Format**: `JSON`
- **Base URL**: `http://localhost:8000/api`
- **Content-Type**: `application/json`
- **Character Encoding**: `UTF-8`

---

## ⚡ Quick Start

### 1. Test Koneksi API
```bash
curl -X GET "http://localhost:8000/api/logs" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json"
```

### 2. Buat Log Pengujian Pertama
```bash
curl -X POST "http://localhost:8000/api/logs" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "komponen_terdeteksi": "Resistor 1kΩ",
    "status": "OK"
  }'
```

### 3. Expected Response
```json
{
  "id": 1,
  "tanggal_uji": "2025-09-09T13:00:00.000000Z",
  "komponen_terdeteksi": "Resistor 1kΩ",
  "status": "OK",
  "created_at": "2025-09-09T13:00:00.000000Z",
  "updated_at": "2025-09-09T13:00:00.000000Z"
}
```

---

## 🔐 Authentication

**Current Status**: Tidak memerlukan authentication
> ⚠️ **Development Notice**: API ini saat ini dalam mode development tanpa authentication. Untuk deployment production, implementasikan API keys atau OAuth 2.0.

**Future Authentication**:
```http
Authorization: Bearer your-api-token-here
```

---

## 🌐 Base URL & Headers

### Base URL
```
Development: http://localhost:8000/api
Production:  https://your-domain.com/api
```

### Required Headers
```http
Accept: application/json
Content-Type: application/json
```

### Optional Headers
```http
X-Requested-With: XMLHttpRequest
User-Agent: YourApp/1.0 (IoT Device)
```

---

## 🛠️ API Endpoints

### 📊 **Logs Management**

#### 1. Get All Test Logs
Mengambil semua log pengujian komponen dengan optional filtering.

```http
GET /logs
```

**Query Parameters** (Optional):
- `limit` - Jumlah hasil (default: semua)
- `offset` - Skip jumlah hasil
- `sort` - Field untuk sorting (`id`, `tanggal_uji`, `status`)
- `order` - Urutan sort (`asc`, `desc`)

**Response (200 OK)**:
```json
[
  {
    "id": 1,
    "tanggal_uji": "2025-09-09T13:00:00.000000Z",
    "komponen_terdeteksi": "Resistor 1kΩ",
    "status": "OK",
    "created_at": "2025-09-09T13:00:00.000000Z",
    "updated_at": "2025-09-09T13:00:00.000000Z"
  }
]
```

**Status Codes:**
- `200 OK` - Berhasil mengambil data
- `500 Internal Server Error` - Kesalahan server

---

#### 2. Create New Test Log
Submit hasil pengujian komponen baru.

```http
POST /logs
```

**Request Body**:
```json
{
  "komponen_terdeteksi": "Nama Komponen",
  "status": "OK|FAILED|WARNING"
}
```

**Field Validation**:
| Field | Type | Required | Max Length | Allowed Values |
|-------|------|----------|------------|----------------|
| `komponen_terdeteksi` | string | ✅ Yes | 255 chars | Nama komponen apapun |
| `status` | string | ✅ Yes | 50 chars | OK, FAILED, WARNING |

**Response (201 Created)**:
```json
{
  "id": 2,
  "tanggal_uji": "2025-09-09T13:05:00.000000Z",
  "komponen_terdeteksi": "LED Red 5mm",
  "status": "FAILED",
  "created_at": "2025-09-09T13:05:00.000000Z",
  "updated_at": "2025-09-09T13:05:00.000000Z"
}
```

**Status Codes:**
- `201 Created` - Berhasil membuat data baru
- `422 Unprocessable Entity` - Validasi gagal
- `500 Internal Server Error` - Kesalahan server

**Validation Error Example**:
```json
{
  "message": "The komponen terdeteksi field is required.",
  "errors": {
    "komponen_terdeteksi": [
      "The komponen terdeteksi field is required."
    ],
    "status": [
      "The status field is required."
    ]
  }
}
```

---

#### 3. Get Specific Test Log
Mengambil single test log berdasarkan ID.

```http
GET /logs/{id}
```

**Path Parameters**:
- `id` (integer, required) - Log ID

**Response (200 OK)**:
```json
{
  "id": 1,
  "tanggal_uji": "2025-09-09T13:00:00.000000Z",
  "komponen_terdeteksi": "Resistor 1kΩ",
  "status": "OK",
  "created_at": "2025-09-09T13:00:00.000000Z",
  "updated_at": "2025-09-09T13:00:00.000000Z"
}
```

**Status Codes:**
- `200 OK` - Berhasil mengambil data
- `404 Not Found` - Data tidak ditemukan
- `500 Internal Server Error` - Kesalahan server

---

#### 4. Update Test Log
Modify existing test log.

```http
PUT /logs/{id}
```

**Path Parameters**:
- `id` (integer, required) - Log ID

**Request Body** (Semua field optional):
```json
{
  "komponen_terdeteksi": "Updated Component Name",
  "status": "WARNING"
}
```

**Response (200 OK)**:
```json
{
  "id": 1,
  "tanggal_uji": "2025-09-09T13:00:00.000000Z",
  "komponen_terdeteksi": "Updated Component Name",
  "status": "WARNING",
  "created_at": "2025-09-09T13:00:00.000000Z",
  "updated_at": "2025-09-09T13:10:00.000000Z"
}
```

**Status Codes:**
- `200 OK` - Berhasil mengupdate data
- `404 Not Found` - Data tidak ditemukan
- `422 Unprocessable Entity` - Validasi gagal
- `500 Internal Server Error` - Kesalahan server

---

#### 5. Delete Test Log
Hapus test log dari sistem.

```http
DELETE /logs/{id}
```

**Path Parameters**:
- `id` (integer, required) - Log ID

**Response (200 OK)**:
```json
{
  "message": "Log deleted successfully"
}
```

**Status Codes:**
- `200 OK` - Berhasil menghapus data
- `404 Not Found` - Data tidak ditemukan
- `500 Internal Server Error` - Kesalahan server

---

#### 6. Filter Logs by Status
Get logs yang difilter berdasarkan test status.

```http
GET /logs/status/{status}
```

**Path Parameters**:
- `status` (string, required) - Test status (OK, FAILED, WARNING)

**Response (200 OK)**:
```json
[
  {
    "id": 1,
    "tanggal_uji": "2025-09-09T13:00:00.000000Z",
    "komponen_terdeteksi": "Resistor 1kΩ",
    "status": "OK",
    "created_at": "2025-09-09T13:00:00.000000Z",
    "updated_at": "2025-09-09T13:00:00.000000Z"
  }
]
```

**Status Codes:**
- `200 OK` - Berhasil mengambil data (bisa array kosong jika tidak ada data)
- `500 Internal Server Error` - Kesalahan server

---

## 📋 Data Models

### LogTester Model
Struktur data lengkap untuk component test logs.

```typescript
interface LogTester {
  id: number;                    // Auto-increment primary key
  tanggal_uji: string;          // ISO 8601 datetime (auto-generated)
  komponen_terdeteksi: string;  // Component name/description (max: 255)
  status: "OK" | "FAILED" | "WARNING";  // Test result status (max: 50)
  created_at: string;           // ISO 8601 datetime
  updated_at: string;           // ISO 8601 datetime
}
```

**Field Details**:
- `tanggal_uji`: Otomatis diset ke current timestamp saat dibuat
- `status`: Nilai yang disarankan adalah "OK", "FAILED", "WARNING"
- Semua datetime fields dalam UTC dengan timezone information

---

## ❌ Error Handling

### HTTP Status Codes
| Code | Description | Usage |
|------|-------------|-------|
| **200** | OK | Successful GET, PUT, DELETE |
| **201** | Created | Successful POST |
| **400** | Bad Request | Invalid request format |
| **404** | Not Found | Resource not found |
| **422** | Unprocessable Entity | Validation failed |
| **500** | Internal Server Error | Server error |

### Error Response Format
Semua error response mengikuti struktur ini:

```json
{
  "message": "Human-readable error description",
  "errors": {
    "field_name": [
      "Specific validation error message"
    ]
  },
  "exception": "Exception class (development only)",
  "file": "File path (development only)",
  "line": 42
}
```

### Common Error Examples

#### 404 - Resource Not Found
```json
{
  "message": "No query results for model [App\\Models\\LogTester] 999",
  "exception": "Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException"
}
```

#### 422 - Validation Error
```json
{
  "message": "The komponen terdeteksi field is required.",
  "errors": {
    "komponen_terdeteksi": [
      "The komponen terdeteksi field is required."
    ],
    "status": [
      "The status field must be one of: OK, FAILED, WARNING."
    ]
  }
}
```

---

## 💻 Code Examples

### JavaScript (Fetch API)
```javascript
class IoTComponentAPI {
  constructor(baseURL = 'http://localhost:8000/api') {
    this.baseURL = baseURL;
  }

  async createLog(component, status) {
    const response = await fetch(`${this.baseURL}/logs`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        komponen_terdeteksi: component,
        status: status
      })
    });
    
    if (!response.ok) {
      throw new Error(`HTTP ${response.status}: ${response.statusText}`);
    }
    
    return await response.json();
  }

  async getAllLogs() {
    const response = await fetch(`${this.baseURL}/logs`, {
      headers: {
        'Accept': 'application/json',
      }
    });
    return await response.json();
  }

  async getLogsByStatus(status) {
    const response = await fetch(`${this.baseURL}/logs/status/${status}`, {
      headers: {
        'Accept': 'application/json',
      }
    });
    return await response.json();
  }

  async updateLog(id, data) {
    const response = await fetch(`${this.baseURL}/logs/${id}`, {
      method: 'PUT',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data)
    });
    return await response.json();
  }

  async deleteLog(id) {
    const response = await fetch(`${this.baseURL}/logs/${id}`, {
      method: 'DELETE',
      headers: {
        'Accept': 'application/json',
      }
    });
    return await response.json();
  }
}

// Usage Example
const api = new IoTComponentAPI();

// Create new test result
api.createLog('Resistor 10kΩ', 'OK')
  .then(result => console.log('Created:', result))
  .catch(error => console.error('Error:', error));

// Get all failed tests
api.getLogsByStatus('FAILED')
  .then(logs => console.log(`Found ${logs.length} failed tests`));
```

### Python Requests
```python
import requests
import json
from datetime import datetime

class IoTComponentAPI:
    def __init__(self, base_url='http://localhost:8000/api'):
        self.base_url = base_url
        self.headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    
    def create_log(self, component, status):
        """Create a new test log"""
        data = {
            'komponen_terdeteksi': component,
            'status': status
        }
        
        response = requests.post(
            f'{self.base_url}/logs',
            headers=self.headers,
            json=data
        )
        
        response.raise_for_status()
        return response.json()
    
    def get_all_logs(self):
        """Get all test logs"""
        response = requests.get(
            f'{self.base_url}/logs',
            headers={'Accept': 'application/json'}
        )
        response.raise_for_status()
        return response.json()
    
    def get_logs_by_status(self, status):
        """Get logs filtered by status"""
        response = requests.get(
            f'{self.base_url}/logs/status/{status}',
            headers={'Accept': 'application/json'}
        )
        response.raise_for_status()
        return response.json()

    def update_log(self, log_id, data):
        """Update existing log"""
        response = requests.put(
            f'{self.base_url}/logs/{log_id}',
            headers=self.headers,
            json=data
        )
        response.raise_for_status()
        return response.json()

    def delete_log(self, log_id):
        """Delete log by ID"""
        response = requests.delete(
            f'{self.base_url}/logs/{log_id}',
            headers={'Accept': 'application/json'}
        )
        response.raise_for_status()
        return response.json()

# Usage example
api = IoTComponentAPI()

try:
    # Create new test result
    result = api.create_log('Capacitor 100µF', 'WARNING')
    print(f"Created log with ID: {result['id']}")
    
    # Update the log
    updated = api.update_log(result['id'], {'status': 'OK'})
    print(f"Updated status to: {updated['status']}")
    
    # Get all failed tests
    failed_tests = api.get_logs_by_status('FAILED')
    print(f"Found {len(failed_tests)} failed tests")
    
except requests.RequestException as e:
    print(f"API Error: {e}")
```

### Arduino/ESP32 (C++)
```cpp
#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>

class IoTComponentAPI {
private:
  String baseURL;
  
public:
  IoTComponentAPI(String url = "http://192.168.1.100:8000/api") {
    baseURL = url;
  }
  
  bool createLog(String component, String status) {
    HTTPClient http;
    http.begin(baseURL + "/logs");
    http.addHeader("Content-Type", "application/json");
    http.addHeader("Accept", "application/json");
    
    // Create JSON payload
    DynamicJsonDocument doc(256);
    doc["komponen_terdeteksi"] = component;
    doc["status"] = status;
    
    String payload;
    serializeJson(doc, payload);
    
    // Send request
    int httpResponseCode = http.POST(payload);
    bool success = (httpResponseCode == 201);
    
    if (success) {
      String response = http.getString();
      Serial.println("✅ Log created: " + response);
    } else {
      Serial.println("❌ Error " + String(httpResponseCode) + ": " + http.getString());
    }
    
    http.end();
    return success;
  }
  
  String getAllLogs() {
    HTTPClient http;
    http.begin(baseURL + "/logs");
    http.addHeader("Accept", "application/json");
    
    int httpResponseCode = http.GET();
    String response = "";
    
    if (httpResponseCode == 200) {
      response = http.getString();
      Serial.println("📊 Logs retrieved: " + String(response.length()) + " characters");
    } else {
      Serial.println("❌ Error getting logs: " + String(httpResponseCode));
    }
    
    http.end();
    return response;
  }
  
  bool updateLog(int logId, String component, String status) {
    HTTPClient http;
    http.begin(baseURL + "/logs/" + String(logId));
    http.addHeader("Content-Type", "application/json");
    http.addHeader("Accept", "application/json");
    
    // Create JSON payload
    DynamicJsonDocument doc(256);
    if (component.length() > 0) doc["komponen_terdeteksi"] = component;
    if (status.length() > 0) doc["status"] = status;
    
    String payload;
    serializeJson(doc, payload);
    
    // Send PUT request
    int httpResponseCode = http.PUT(payload);
    bool success = (httpResponseCode == 200);
    
    if (success) {
      Serial.println("✅ Log updated successfully");
    } else {
      Serial.println("❌ Update failed: " + String(httpResponseCode));
    }
    
    http.end();
    return success;
  }
};

// Usage
IoTComponentAPI api;

void setup() {
  Serial.begin(115200);
  
  // WiFi connection setup
  WiFi.begin("YOUR_WIFI_SSID", "YOUR_WIFI_PASSWORD");
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("WiFi connected!");
  
  // Test component and send result
  bool testPassed = testResistor();
  String status = testPassed ? "OK" : "FAILED";
  
  if (api.createLog("Resistor 1kΩ", status)) {
    Serial.println("Test result sent successfully");
  }
}

bool testResistor() {
  // Your component testing logic here
  // Read analog values, measure resistance, etc.
  int measuredValue = analogRead(A0);
  
  // Example logic: assume OK if reading is within range
  return (measuredValue > 100 && measuredValue < 900);
}

void loop() {
  // Main loop for continuous testing
  delay(30000); // Test every 30 seconds
}
```

---

## 🧪 Testing Guide

### Manual Testing dengan cURL

#### Complete Test Sequence
```bash
#!/bin/bash
API_BASE="http://localhost:8000/api"

echo "🧪 Starting API Tests..."

# 1. Create test logs
echo "📝 Creating test logs..."
curl -X POST "$API_BASE/logs" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"komponen_terdeteksi": "Resistor 1kΩ", "status": "OK"}' \
  -w "\nStatus: %{http_code}\n\n"

curl -X POST "$API_BASE/logs" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"komponen_terdeteksi": "LED Red 5mm", "status": "FAILED"}' \
  -w "\nStatus: %{http_code}\n\n"

curl -X POST "$API_BASE/logs" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"komponen_terdeteksi": "Capacitor 100μF", "status": "WARNING"}' \
  -w "\nStatus: %{http_code}\n\n"

# 2. Get all logs
echo "📋 Getting all logs..."
curl -X GET "$API_BASE/logs" \
  -H "Accept: application/json" \
  -w "\nStatus: %{http_code}\n\n"

# 3. Get specific log
echo "🔍 Getting specific log (ID: 1)..."
curl -X GET "$API_BASE/logs/1" \
  -H "Accept: application/json" \
  -w "\nStatus: %{http_code}\n\n"

# 4. Filter by status
echo "🔎 Filtering by status..."
curl -X GET "$API_BASE/logs/status/FAILED" \
  -H "Accept: application/json" \
  -w "\nStatus: %{http_code}\n\n"

curl -X GET "$API_BASE/logs/status/OK" \
  -H "Accept: application/json" \
  -w "\nStatus: %{http_code}\n\n"

# 5. Update log
echo "✏️ Updating log..."
curl -X PUT "$API_BASE/logs/1" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"status": "WARNING", "komponen_terdeteksi": "Resistor 1kΩ (Updated)"}' \
  -w "\nStatus: %{http_code}\n\n"

# 6. Test error cases
echo "❌ Testing error cases..."
echo "- Non-existent ID:"
curl -X GET "$API_BASE/logs/999" \
  -H "Accept: application/json" \
  -w "\nStatus: %{http_code}\n\n"

echo "- Missing required field:"
curl -X POST "$API_BASE/logs" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"status": "OK"}' \
  -w "\nStatus: %{http_code}\n\n"

# 7. Delete log
echo "🗑️ Deleting log..."
curl -X DELETE "$API_BASE/logs/2" \
  -H "Accept: application/json" \
  -w "\nStatus: %{http_code}\n\n"

echo "✅ API Tests completed!"
```

### Expected Test Results
- ✅ **POST /api/logs**: 201 Created
- ✅ **GET /api/logs**: 200 OK dengan array
- ✅ **GET /api/logs/{id}**: 200 OK dengan object
- ✅ **PUT /api/logs/{id}**: 200 OK dengan updated object
- ✅ **DELETE /api/logs/{id}**: 200 OK dengan success message
- ✅ **GET /api/logs/status/{status}**: 200 OK dengan filtered array
- ✅ **Error cases**: 404 Not Found, 422 Validation Error

---

## ⚡ Performance & Best Practices

### 🔧 Rate Limiting
```php
// Recommendation untuk production
Route::middleware(['throttle:60,1'])->group(function () {
    // API routes - 60 requests per minute
});
```

### 📊 Pagination (Future Enhancement)
```php
// Untuk large datasets
Route::get('/logs', function(Request $request) {
    $logs = LogTester::orderBy('id', 'desc')
                    ->paginate($request->get('per_page', 25));
    return response()->json($logs);
});
```

### 🚀 Caching Recommendations
```php
// Cache untuk data yang jarang berubah
$stats = Cache::remember('component_stats', 300, function () {
    return [
        'total_tests' => LogTester::count(),
        'passed_tests' => LogTester::where('status', 'OK')->count(),
        'failed_tests' => LogTester::where('status', 'FAILED')->count(),
    ];
});
```

### 🔒 Security Best Practices

#### Input Validation
- Semua input divalidasi menggunakan Laravel validation rules
- XSS protection melalui automatic escaping
- SQL injection protection melalui Eloquent ORM

#### API Security Headers
```http
Content-Type: application/json
X-Content-Type-Options: nosniff
X-Frame-Options: DENY
X-XSS-Protection: 1; mode=block
```

---

## 📞 Support & Integration Help

### 🔧 Integration Checklist
1. ✅ Test koneksi dengan `GET /api/logs`
2. ✅ Implement error handling untuk network failures
3. ✅ Validate data sebelum sending ke API
4. ✅ Handle rate limiting dengan exponential backoff
5. ✅ Log API responses untuk debugging
6. ✅ Implement retry mechanism untuk failed requests

### 🐛 Troubleshooting Common Issues

#### Connection Issues
```bash
# Test koneksi dasar
ping your-api-server.com

# Test HTTP connectivity
curl -I http://localhost:8000/api/logs
```

#### JSON Format Issues
```javascript
// Correct JSON format
{
  "komponen_terdeteksi": "Resistor 1kΩ",
  "status": "OK"
}

// Common mistakes to avoid:
// - Missing quotes on property names
// - Trailing commas
// - Invalid escape characters
```

#### Status Code Handling
```javascript
// Proper error handling
if (response.status === 422) {
  // Validation error - check response.errors
  console.log('Validation failed:', response.errors);
} else if (response.status === 404) {
  // Resource not found
  console.log('Resource not found');
} else if (response.status >= 500) {
  // Server error - retry with backoff
  console.log('Server error, retrying...');
}
```

---

## 📈 Future Enhancements

### 🚀 Planned Features
1. **Authentication dengan API tokens**
2. **Pagination untuk large datasets**
3. **Rate limiting yang configurable**
4. **Real-time notifications dengan WebSocket**
5. **Bulk operations (create/update/delete multiple records)**
6. **Advanced filtering dan sorting**
7. **Export data ke CSV/Excel**
8. **API versioning (v1, v2, etc.)**
9. **GraphQL endpoint sebagai alternatif**
10. **Webhook notifications untuk external systems**

### 📊 Analytics Endpoints (Planned)
```http
GET /api/analytics/summary          # Overall statistics
GET /api/analytics/trends           # Historical trends
GET /api/analytics/components       # Component-specific stats
GET /api/export/{format}           # Data export (CSV, Excel, PDF)
```

---

**📞 Support & Feedback**
Untuk pertanyaan, bug reports, atau feature requests, silakan buat issue di project repository atau hubungi tim development.

**Last Updated**: September 9, 2025 | **Version**: 1.1.0 | **Status**: ✅ All Endpoints Tested & Working