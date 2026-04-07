from flask import Flask, request, jsonify, send_from_directory
from flask_cors import CORS  # pour autoriser le HTML à appeler /devices

app = Flask(__name__)
CORS(app)

devices = []

# Route principale : sert index.html
@app.route('/')
def home():
    return send_from_directory('static', 'index.html')  # ton index.html doit être dans le dossier static/

# Route pour recevoir les positions GPS
@app.route('/update', methods=['POST'])
def update():
    data = request.get_json(force=True)
    print("Reçu:", data)   # <-- tu verras le JSON
    lat = data.get("lat")
    lon = data.get("lng")
    devices.append({"lat": lat, "lon": lon})
    return "OK"

# Route pour envoyer les positions au HTML
@app.route('/devices')
def get_devices():
    return jsonify(devices)

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=1001)
