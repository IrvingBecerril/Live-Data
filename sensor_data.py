import adafruit_dht
import board
import time
import json
import sys
import os

# Use GPIO4 (Pin 7) as the data pin
dhtDevice = adafruit_dht.DHT11(board.D4)

def read_sensor():
    try:
        temperature = dhtDevice.temperature
        humidity = dhtDevice.humidity
        if humidity is not None and temperature is not None:
            return {
                "h": humidity,  # shorter key for humidity
                "t": temperature,  # shorter key for temperature
                "ts": time.strftime("%Y-%m-%d %H:%M:%S")  # timestamp
            }
    except RuntimeError as error:
        # Catch and print runtime errors
        print(f"RuntimeError: {error.args[0]}")
        time.sleep(2.0)
    except Exception as error:
        dhtDevice.exit()
        raise error
    return None

def main():
    # Initial read to check if the sensor is responsive
    print("Initializing sensor...")
    data = None
    while data is None:
        data = read_sensor()
        if data is None:
            print("Failed to get initial reading, retrying...")
            time.sleep(2)
    print("Sensor initialized successfully.")
    
    # Main loop for regular readings
    while True:
        data = read_sensor()
        if data:
            print(f"Temp: {data['t']:.1f}C  Humidity: {data['h']:.1f}%")
            
            # Read existing data from JSON file
            if os.path.exists('/var/www/html/data.json'):
                with open('/var/www/html/data.json', 'r') as f:
                    try:
                        existing_data = json.load(f)
                        # Ensure the existing data is a list
                        if isinstance(existing_data, list):
                            records = existing_data
                        else:
                            records = [existing_data]
                    except json.JSONDecodeError:
                        records = []
            else:
                records = []

            # Append new data
            records.append(data)
            
            # Write updated records to JSON file without indentation
            with open('/var/www/html/data.json', 'w') as f:
                json.dump(records, f)
                
        time.sleep(15)  # Wait 15 seconds before the next read attempt

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print("Program interrupted by user")
    except Exception as e:
        print(f"An error occurred: {e}")
    finally:
        dhtDevice.exit()
        sys.exit()
