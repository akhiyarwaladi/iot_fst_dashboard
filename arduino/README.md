# ESP32 Arduino Code for IoT Component Tester

Simple Arduino code untuk ESP32 yang terintegrasi dengan IoT FST Dashboard API di `http://iot.fst.unja.ac.id`.

## 📁 Files Overview

### `esp32_serial_to_api.ino`
**Serial Bridge untuk Arduino Nano**:
- Menerima data nama komponen dari Arduino Nano via Serial
- Format: `"NamaKomponen,Status"`
- Mengirim data ke API secara otomatis
- LED status indicator
- Error handling dan reconnection

## 🚀 Quick Start Guide

### Step 1: Setup Arduino IDE
1. Download Arduino IDE dari [arduino.cc](https://www.arduino.cc/en/software)
2. Install ESP32 board support:
   - File → Preferences
   - Additional Boards Manager URLs: `https://espressif.github.io/arduino-esp32/package_esp32_index.json`
   - Tools → Board → Boards Manager → Search "ESP32" → Install

### Step 2: Install Library
```
Tools → Manage Libraries → Search and Install:
- ArduinoJson by Benoit Blanchon (version 6.x)
```

### Step 3: Hardware Setup

#### Basic Wiring (ESP32 + Arduino Nano):
```
ESP32          Arduino Nano
GPIO2    →     (Built-in LED status)
RX2      →     TX (Pin 1)
TX2      →     RX (Pin 0)  
5V       →     VIN
GND      →     GND
```

### Step 4: Upload Code

#### Setup ESP32:
1. Open `esp32_serial_to_api.ino`
2. Change WiFi credentials:
   ```cpp
   const char* ssid = "YOUR_WIFI_NAME";
   const char* password = "YOUR_WIFI_PASSWORD";
   ```
3. Select Board: `ESP32 Dev Module`
4. Upload code
5. Open Serial Monitor (115200 baud)

## 📊 API Integration

### API Endpoint
```
POST http://iot.fst.unja.ac.id/api/logs
Content-Type: application/json
```

### Request Format
```json
{
  "komponen_terdeteksi": "Resistor 1kΩ",
  "status": "OK"
}
```

### Status Values
- `"OK"` - Komponen berfungsi normal
- `"FAILED"` - Komponen rusak/tidak berfungsi
- `"WARNING"` - Komponen berfungsi tapi ada masalah

## 🔄 Serial Communication Protocol

### Format Data dari Arduino Nano ke ESP32:
```
ComponentName,Status\n
```

### Contoh:
```
Resistor 1kΩ,OK
LED Red 5mm,FAILED
Capacitor 100µF,WARNING
```

## 💻 Arduino Nano Example Code

```cpp
void setup() {
  Serial.begin(115200);
}

void loop() {
  // Baca komponen dari sensor
  String componentName = readComponent();
  String testResult = testComponent();
  
  // Kirim ke ESP32
  Serial.println(componentName + "," + testResult);
  delay(5000); // Kirim setiap 5 detik
}

String readComponent() {
  // Logic pembacaan komponen di sini
  return "Resistor 1kΩ";
}

String testComponent() {
  // Logic testing komponen di sini
  // Return: "OK", "FAILED", atau "WARNING"
  return "OK";
}
```

## 📈 Serial Monitor Output

```
ESP32 Serial to API Bridge
===========================
Connecting to WiFi...
WiFi connected!
IP address: 192.168.1.100
Ready to receive data from Arduino Nano
Send format: 'ComponentName,Status'
Example: 'Resistor 1kΩ,OK'

Received: Resistor 1kΩ,OK
Component: Resistor 1kΩ
Status: OK
Sending: {"komponen_terdeteksi":"Resistor 1kΩ","status":"OK"}
✅ Success! Response: {"id":1,"tanggal_uji":"2025-09-09T17:30:00.000000Z",...}
```

## 🔍 LED Status Indicators (GPIO2)

- **Solid ON**: WiFi connected, system ready
- **3 quick blinks**: Data sent successfully to API
- **5 fast blinks**: Error (network/API error)
- **Alternating blinks**: Connecting to WiFi

## ❌ Troubleshooting

### Common Issues:

#### 1. WiFi Connection Failed
- Check SSID and password
- Ensure WiFi signal strength
- Try different WiFi network

#### 2. API Connection Error
```
❌ Error 422
Response: {"message":"The komponen terdeteksi field is required."}
```
**Solution**: Check data format, ensure comma separator

#### 3. Serial Communication Issues
- Check baud rate (115200)
- Verify TX/RX connections
- Test with Serial Monitor first

### Testing Commands:

#### Test via Serial Monitor:
```
Test Component,OK
Resistor 1kΩ,FAILED
LED Red,WARNING
```

#### Test API manually:
```bash
curl -X POST "http://iot.fst.unja.ac.id/api/logs" \
  -H "Content-Type: application/json" \
  -d '{"komponen_terdeteksi":"Test Resistor","status":"OK"}'
```

## 🎯 Usage Examples

### Example 1: Resistor Testing
Arduino Nano detects 1kΩ resistor → Sends `"Resistor 1kΩ,OK"`

### Example 2: LED Testing  
Arduino Nano detects failed LED → Sends `"LED Red 5mm,FAILED"`

### Example 3: Capacitor Warning
Arduino Nano detects capacitor with issues → Sends `"Capacitor 100µF,WARNING"`

## 📞 Support

For issues:
1. Check Serial Monitor output (115200 baud)
2. Verify WiFi connection
3. Test API endpoint manually
4. Check wiring connections
5. Ensure correct data format

---

**Ready to use!** 🔧⚡ Your ESP32 and Arduino Nano are now connected to the IoT Dashboard!