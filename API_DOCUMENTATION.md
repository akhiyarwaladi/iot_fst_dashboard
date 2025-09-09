# API Documentation - Electronic Component Tester

## Overview
REST API untuk Electronic Component Tester IoT Dashboard. API ini menyediakan endpoint untuk mengelola log pengujian komponen elektronik.

**Base URL:** `http://localhost:8000/api`

**Content-Type:** `application/json`

**Response Format:** JSON

---

## Authentication
Saat ini API belum menggunakan authentication. Semua endpoint dapat diakses tanpa token.

---

## Endpoints

### 1. Get All Logs
Mengambil semua data log pengujian, diurutkan berdasarkan tanggal terbaru.

**Endpoint:** `GET /logs`

**Response:**
```json
[
  {
    "id": 7,
    "tanggal_uji": "2025-09-09T19:11:52.000000Z",
    "komponen_terdeteksi": "Diode 1N4148",
    "status": "WARNING",
    "created_at": "2025-09-09T12:11:52.000000Z",
    "updated_at": "2025-09-09T12:11:52.000000Z"
  },
  {
    "id": 5,
    "tanggal_uji": "2025-09-09T19:11:39.000000Z",
    "komponen_terdeteksi": "Resistor 1K (Updated)",
    "status": "OK",
    "created_at": "2025-09-09T12:11:39.000000Z",
    "updated_at": "2025-09-09T12:12:09.000000Z"
  }
]
```

**Status Codes:**
- `200 OK` - Berhasil mengambil data
- `500 Internal Server Error` - Kesalahan server

---

### 2. Create New Log
Membuat log pengujian baru.

**Endpoint:** `POST /logs`

**Request Body:**
```json
{
  "komponen_terdeteksi": "Resistor 1K",
  "status": "OK"
}
```

**Parameters:**
- `komponen_terdeteksi` (string, required) - Nama komponen yang terdeteksi, maksimal 255 karakter
- `status` (string, required) - Status pengujian, maksimal 50 karakter. Nilai yang disarankan: "OK", "FAILED", "WARNING"

**Response:**
```json
{
  "komponen_terdeteksi": "Resistor 1K",
  "status": "OK",
  "updated_at": "2025-09-09T12:11:39.000000Z",
  "created_at": "2025-09-09T12:11:39.000000Z",
  "id": 5
}
```

**Status Codes:**
- `201 Created` - Berhasil membuat data baru
- `422 Unprocessable Entity` - Validasi gagal
- `500 Internal Server Error` - Kesalahan server

**Validation Errors:**
```json
{
  "message": "The komponen terdeteksi field is required.",
  "errors": {
    "komponen_terdeteksi": [
      "The komponen terdeteksi field is required."
    ]
  }
}
```

---

### 3. Get Specific Log
Mengambil data log berdasarkan ID.

**Endpoint:** `GET /logs/{id}`

**Parameters:**
- `id` (integer, required) - ID log yang ingin diambil

**Response:**
```json
{
  "id": 5,
  "tanggal_uji": "2025-09-09T19:11:39.000000Z",
  "komponen_terdeteksi": "Resistor 1K",
  "status": "OK",
  "created_at": "2025-09-09T12:11:39.000000Z",
  "updated_at": "2025-09-09T12:11:39.000000Z"
}
```

**Status Codes:**
- `200 OK` - Berhasil mengambil data
- `404 Not Found` - Data tidak ditemukan
- `500 Internal Server Error` - Kesalahan server

---

### 4. Update Log
Mengupdate data log yang sudah ada.

**Endpoint:** `PUT /logs/{id}`

**Parameters:**
- `id` (integer, required) - ID log yang ingin diupdate

**Request Body:**
```json
{
  "komponen_terdeteksi": "Resistor 1K (Updated)",
  "status": "OK"
}
```

**Parameters:**
- `komponen_terdeteksi` (string, optional) - Nama komponen, maksimal 255 karakter
- `status` (string, optional) - Status pengujian, maksimal 50 karakter

**Response:**
```json
{
  "id": 5,
  "tanggal_uji": "2025-09-09T19:11:39.000000Z",
  "komponen_terdeteksi": "Resistor 1K (Updated)",
  "status": "OK",
  "created_at": "2025-09-09T12:11:39.000000Z",
  "updated_at": "2025-09-09T12:12:09.000000Z"
}
```

**Status Codes:**
- `200 OK` - Berhasil mengupdate data
- `404 Not Found` - Data tidak ditemukan
- `422 Unprocessable Entity` - Validasi gagal
- `500 Internal Server Error` - Kesalahan server

---

### 5. Delete Log
Menghapus data log berdasarkan ID.

**Endpoint:** `DELETE /logs/{id}`

**Parameters:**
- `id` (integer, required) - ID log yang ingin dihapus

**Response:**
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

### 6. Filter Logs by Status
Mengambil data log berdasarkan status tertentu.

**Endpoint:** `GET /logs/status/{status}`

**Parameters:**
- `status` (string, required) - Status yang ingin difilter. Contoh: "OK", "FAILED", "WARNING"

**Response:**
```json
[
  {
    "id": 5,
    "tanggal_uji": "2025-09-09T19:11:39.000000Z",
    "komponen_terdeteksi": "Resistor 1K (Updated)",
    "status": "OK",
    "created_at": "2025-09-09T12:11:39.000000Z",
    "updated_at": "2025-09-09T12:12:09.000000Z"
  }
]
```

**Status Codes:**
- `200 OK` - Berhasil mengambil data (bisa array kosong jika tidak ada data)
- `500 Internal Server Error` - Kesalahan server

---

## Data Model

### LogTester Model
```json
{
  "id": "integer (auto-increment primary key)",
  "tanggal_uji": "datetime (auto-generated, timezone aware)",
  "komponen_terdeteksi": "string (max: 255 characters)",
  "status": "string (max: 50 characters)",
  "created_at": "datetime",
  "updated_at": "datetime"
}
```

**Field Descriptions:**
- `id` - Primary key, auto-increment
- `tanggal_uji` - Tanggal dan waktu pengujian, otomatis terisi saat data dibuat
- `komponen_terdeteksi` - Nama komponen elektronik yang terdeteksi
- `status` - Status hasil pengujian (OK, FAILED, WARNING, dll)
- `created_at` - Timestamp saat data dibuat
- `updated_at` - Timestamp saat data terakhir diupdate

---

## Status Codes Reference

| Status Code | Description |
|-------------|-------------|
| 200 OK | Request berhasil |
| 201 Created | Data berhasil dibuat |
| 404 Not Found | Resource tidak ditemukan |
| 422 Unprocessable Entity | Validasi request gagal |
| 500 Internal Server Error | Kesalahan server |

---

## Example Usage

### cURL Examples

#### Create a new log:
```bash
curl -X POST "http://localhost:8000/api/logs" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "komponen_terdeteksi": "Resistor 1K",
    "status": "OK"
  }'
```

#### Get all logs:
```bash
curl -X GET "http://localhost:8000/api/logs" \
  -H "Accept: application/json"
```

#### Get specific log:
```bash
curl -X GET "http://localhost:8000/api/logs/5" \
  -H "Accept: application/json"
```

#### Update a log:
```bash
curl -X PUT "http://localhost:8000/api/logs/5" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "komponen_terdeteksi": "Resistor 1K (Updated)",
    "status": "OK"
  }'
```

#### Delete a log:
```bash
curl -X DELETE "http://localhost:8000/api/logs/5" \
  -H "Accept: application/json"
```

#### Filter by status:
```bash
curl -X GET "http://localhost:8000/api/logs/status/OK" \
  -H "Accept: application/json"
```

---

### JavaScript (Fetch API) Examples

#### Create a new log:
```javascript
fetch('http://localhost:8000/api/logs', {
  method: 'POST',
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    komponen_terdeteksi: 'Resistor 1K',
    status: 'OK'
  })
})
.then(response => response.json())
.then(data => console.log(data));
```

#### Get all logs:
```javascript
fetch('http://localhost:8000/api/logs', {
  method: 'GET',
  headers: {
    'Accept': 'application/json',
  }
})
.then(response => response.json())
.then(data => console.log(data));
```

---

### Arduino/ESP32 Example

```cpp
#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>

void sendTestResult(String component, String status) {
  HTTPClient http;
  http.begin("http://192.168.1.100:8000/api/logs");
  http.addHeader("Content-Type", "application/json");
  
  // Create JSON payload
  DynamicJsonDocument doc(200);
  doc["komponen_terdeteksi"] = component;
  doc["status"] = status;
  
  String payload;
  serializeJson(doc, payload);
  
  // Send POST request
  int httpResponseCode = http.POST(payload);
  
  if (httpResponseCode > 0) {
    String response = http.getString();
    Serial.println("Response: " + response);
  } else {
    Serial.println("Error: " + String(httpResponseCode));
  }
  
  http.end();
}

// Usage
void setup() {
  Serial.begin(115200);
  // WiFi setup...
  
  // Send test result
  sendTestResult("Resistor 1K", "OK");
}
```

---

## Error Handling

### Common Error Responses

#### 404 Not Found
```json
{
  "message": "No query results for model [App\\Models\\LogTester] 999"
}
```

#### 422 Validation Error
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

## Rate Limiting
Saat ini tidak ada rate limiting yang diterapkan. Untuk production, disarankan untuk menambahkan rate limiting.

---

## Security Considerations
1. **No Authentication**: API saat ini tidak memerlukan authentication
2. **CORS**: Pastikan CORS dikonfigurasi sesuai kebutuhan
3. **Input Validation**: Semua input sudah divalidasi oleh Laravel
4. **SQL Injection**: Laravel ORM melindungi dari SQL injection

---

## Future Enhancements
1. Authentication dengan API tokens
2. Pagination untuk endpoint GET
3. Rate limiting
4. Caching untuk performa
5. Real-time notifications dengan WebSocket
6. Bulk operations (create/update/delete multiple records)
7. Advanced filtering dan sorting
8. Export data ke CSV/Excel
9. API versioning

---

## Support
Untuk pertanyaan atau masalah terkait API, silakan buat issue di repository GitHub atau hubungi tim development.

**Last Updated:** September 9, 2025
**Version:** 1.0.0