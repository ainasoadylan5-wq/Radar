from flask import Flask, request, jsonify

app = Flask(__name__)

devices = []

@app.route('/')
def home():
    return "Radar server running"

@app.route('/update', methods=['POST'])
def update():
    data = request.data.decode('utf-8')
    lat, lon = data.split(",")

    devices.append({
        "lat": float(lat),
        "lon": float(lon)
    })

    return "OK"

@app.route('/devices')
def get_devices():
    return jsonify(devices)