/*
 * ESP32 Serial to API Bridge
 * 
 * Receives component names from Arduino Nano via Serial
 * Sends data to IoT Dashboard API at http://iot.fst.unja.ac.id
 * 
 * Serial Protocol:
 * Arduino Nano sends: "COMPONENT_NAME,STATUS"
 * Example: "Resistor 1kΩ,OK" or "LED Red,FAILED"
 */

#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>

// WiFi Configuration - CHANGE THESE
const char* ssid = "YOUR_WIFI_NAME";
const char* password = "YOUR_WIFI_PASSWORD";

// API Configuration
const char* apiURL = "http://iot.fst.unja.ac.id/api/logs";

// LED for status indication
const int ledPin = 2;

void setup() {
  Serial.begin(115200);
  pinMode(ledPin, OUTPUT);
  
  Serial.println("ESP32 Serial to API Bridge");
  Serial.println("===========================");
  
  connectToWiFi();
  
  Serial.println("Ready to receive data from Arduino Nano");
  Serial.println("Send format: 'ComponentName,Status'");
  Serial.println("Example: 'Resistor 1kΩ,OK'");
}

void loop() {
  if (Serial.available()) {
    String receivedData = Serial.readStringUntil('\n');
    receivedData.trim();
    
    if (receivedData.length() > 0) {
      Serial.println("Received: " + receivedData);
      processReceivedData(receivedData);
    }
  }
  delay(100);
}

void connectToWiFi() {
  WiFi.begin(ssid, password);
  Serial.print("Connecting to WiFi");
  
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
    digitalWrite(ledPin, !digitalRead(ledPin));
  }
  
  Serial.println();
  Serial.println("WiFi connected!");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
  digitalWrite(ledPin, HIGH);
}

void processReceivedData(String data) {
  // Parse data: "ComponentName,Status"
  int commaIndex = data.indexOf(',');
  
  if (commaIndex == -1) {
    Serial.println("Error: Invalid format. Use 'ComponentName,Status'");
    blinkError();
    return;
  }
  
  String component = data.substring(0, commaIndex);
  String status = data.substring(commaIndex + 1);
  
  component.trim();
  status.trim();
  
  // Validate component name and status
  if (component.length() == 0 || status.length() == 0) {
    Serial.println("Error: Component name and status cannot be empty");
    blinkError();
    return;
  }
  
  if (status != "OK" && status != "FAILED" && status != "WARNING") {
    Serial.println("Error: Status must be OK, FAILED, or WARNING");
    blinkError();
    return;
  }
  
  Serial.println("Component: " + component);
  Serial.println("Status: " + status);
  
  // Send to API
  sendToAPI(component, status);
}

void sendToAPI(String component, String status) {
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("WiFi not connected. Reconnecting...");
    connectToWiFi();
    return;
  }
  
  HTTPClient http;
  http.begin(apiURL);
  http.addHeader("Content-Type", "application/json");
  http.addHeader("Accept", "application/json");
  
  // Create JSON payload (only required fields)
  DynamicJsonDocument doc(200);
  doc["komponen_terdeteksi"] = component;
  doc["status"] = status;
  
  String jsonString;
  serializeJson(doc, jsonString);
  
  Serial.println("Sending: " + jsonString);
  
  int httpResponseCode = http.POST(jsonString);
  
  if (httpResponseCode == 201 || httpResponseCode == 200) {
    String response = http.getString();
    Serial.println("✅ Success! Response: " + response);
    blinkSuccess();
  } else {
    Serial.println("❌ Error " + String(httpResponseCode));
    if (http.getString().length() > 0) {
      Serial.println("Response: " + http.getString());
    }
    blinkError();
  }
  
  http.end();
}

void blinkSuccess() {
  // 3 quick blinks for success
  for(int i = 0; i < 3; i++) {
    digitalWrite(ledPin, LOW);
    delay(100);
    digitalWrite(ledPin, HIGH);
    delay(100);
  }
}

void blinkError() {
  // 5 fast blinks for error
  for(int i = 0; i < 5; i++) {
    digitalWrite(ledPin, LOW);
    delay(200);
    digitalWrite(ledPin, HIGH);
    delay(200);
  }
}

/*
 * SETUP INSTRUCTIONS:
 * 
 * 1. Change WiFi credentials above
 * 2. Upload to ESP32
 * 3. Open Serial Monitor (115200 baud)
 * 4. Send test data: "Test Component,OK"
 * 
 * ARDUINO NANO CODE EXAMPLE:
 * 
 * void setup() {
 *   Serial.begin(115200);
 * }
 * 
 * void loop() {
 *   // Read component from sensor
 *   String detectedComponent = readComponent();
 *   String testStatus = testComponent();
 *   
 *   // Send to ESP32
 *   Serial.println(detectedComponent + "," + testStatus);
 *   delay(5000);
 * }
 * 
 * String readComponent() {
 *   // Your component detection logic here
 *   return "Resistor 1kΩ";
 * }
 * 
 * String testComponent() {
 *   // Your component testing logic here
 *   return "OK"; // or "FAILED" or "WARNING"
 * }
 */