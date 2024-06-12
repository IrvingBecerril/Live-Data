from flask import Flask, jsonify, send_file
import Adafruit_DHT
import time
import os
import json

app = Flask(__name__)

DHT_SENSOR = Adafruit_DHT.DHT11
DHT_PIN = 4

@app.route('/data')
def get_data():
    humidity, temperature = Adafruit_DHT.read_retry(DHT_SENSOR, DHT_PIN)
    if humidity is not None and temperature is not None:
        data = {
            "humidity": humidity,
            "temperature": temperature,
            "time": time.strftime("%Y-%m-%d %H:%M:%S")
        }
        return jsonify(data)
    else:
        return jsonify({"error": "Failed to retrieve data"}), 500

@app.route('/json')
def get_json():
    json_file = '/var/www/html/data.json'
    if os.path.exists(json_file):
        with open(json_file, 'r') as f:
            data = json.load(f)
        return jsonify(data)
    else:
        return jsonify({"error": "JSON file not found"}), 404

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000)
