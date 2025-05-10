#include <ESP8266WiFi.h> 
#include <ESP8266HTTPClient.h> 
#define SSID "Seenu" 
#define PASSWORD "07989391" 
#define URL "http://192.168.0.110/CropPrediction/sensor_data.php" 
void setup() { 
Serial.begin(9600); 
WiFi.begin(SSID, PASSWORD); 
while (WiFi.status() != WL_CONNECTED) { 
Serial.print("."); 
delay(500); 
} 
Serial.println("Connected, IP: " + WiFi.localIP().toString()); 
} 
void loop() { 
if (WiFi.status() == WL_CONNECTED && Serial.available()) { 
String data = Serial.readStringUntil('\n'); 
String postData = "Temp=" + data.split(',')[0] + 
"&Humidity=" + data.split(',')[1] + 
"&Water=" + data.split(',')[2] + 
"&Moisture=" + data.split(',')[3] + 
"&Light=" + data.split(',')[4]; 
HTTPClient http; 
http.begin(WiFiClient(), URL); 
http.addHeader("Content-Type", "application/x-www-form-urlencoded"); 
int httpCode = http.POST(postData); 
String response = http.getString(); 
Serial.println("HTTP Code: " + String(httpCode)); 
Serial.println("Response: " + response); 
http.end(); 
} 
delay(5000); 
}
