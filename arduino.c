#include "dht.h" 
#include <BH1750.h> 
#include <Wire.h> 
#define DHT_PIN A1 
#define WATER_PIN A2 
#define MOISTURE_PIN A0 
BH1750 lightMeter; 
dht DHT; 
void setup() { 
  Serial.begin(9600); 
  Wire.begin(); 
  lightMeter.begin(); 
  delay(1500); 
} 
void loop() { 
  float lux = lightMeter.readLightLevel(); 
  DHT.read11(DHT_PIN); 
  Serial.print(DHT.temperature); Serial.print(","); 
  Serial.print(DHT.humidity); Serial.print(","); 
  Serial.print(analogRead(WATER_PIN)); Serial.print(","); 
  Serial.print(analogRead(MOISTURE_PIN)); Serial.print(","); 
  Serial.println(lux); 
  delay(5000); 
}

