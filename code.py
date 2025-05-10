from flask import Flask, render_template, request 
import requests, json, pandas as pd 
from sklearn.ensemble import RandomForestClassifier 
from sklearn.model_selection import train_test_split 
from sklearn.metrics import accuracy_score 
app = Flask(__name__) 
# Fetch sensor data 
response = requests.get('http://172.20.10.12/CropPrediction/average_data.php') 
if response.status_code == 200: 
    data = json.loads(response.text) 
    avg_vals = { 
        "temperature": float(data["averageTemperature"]), 
        "humidity": float(data["averageHumidity"]), 
        "water_level": float(data["averageWaterLevel"]), 
        "moisture_level": float(data["averageMoistureLevel"]), 
        "light_intensity": float(data["averageLightIntensity"]) 
    } 
@app.route('/') 
def home(): 
    return render_template('home_page.html') 
@app.route('/submit', methods=['POST']) 
def submit(): 
    # Get user input from the form 
    sensor_inputs = { 
        "n": float(request.form['n_val']), 
        "p": float(request.form['p_val']), 
        "k": float(request.form['k_val']), 
        "ph": float(request.form['ph_val']) 
    } 
    # Merge averages and form inputs 
    inputs = list(avg_vals.values()) + list(sensor_inputs.values()) 
    # Predict the crop 
    predicted_crop, accuracy = predict_crop(inputs) 
    # Display correct page based on prediction 
    crop_pages = { 
        "Lettuce": 'Lettuce-display.html', 
        "Cucumber": 'Cucumber-display.html', 
        "Okra": 'Okra-display.html' 
    } 
    return render_template(crop_pages.get(predicted_crop[0], 'Okra
display.html'), crop=predicted_crop[0], acc=accuracy) 
