<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$devicesFile = __DIR__ . "/devices.json";
if (!file_exists($devicesFile)) {
    file_put_contents($devicesFile, json_encode([]));
}

// Palette de couleurs
$colors = ["red", "blue", "green", "orange", "purple", "brown", "pink", "cyan"];

if (strpos($_SERVER['REQUEST_URI'], '/update') !== false) {
    $lat = $_GET['lat'] ?? null;
    $lng = $_GET['lng'] ?? null;

    if ($lat && $lng) {
        $devices = json_decode(file_get_contents($devicesFile), true);

        $ip = $_SERVER['REMOTE_ADDR'];
        $found = false;
        foreach ($devices as &$dev) {
            if ($dev["ip"] === $ip) {
                $dev["lat"] = $lat;
                $dev["lon"] = $lng;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $newId = count($devices) + 1;
            $color = $colors[($newId - 1) % count($colors)];
            $devices[] = ["id" => $newId, "ip" => $ip, "lat" => $lat, "lon" => $lng, "color" => $color];
        }

        file_put_contents($devicesFile, json_encode($devices));
        echo "Position enregistrée";
    } else {
        echo "Paramètres manquants";
    }
    exit;
}

if (strpos($_SERVER['REQUEST_URI'], '/devices') !== false) {
    header("Content-Type: application/json");
    echo file_get_contents($devicesFile);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Radar GPS Privé</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>#map { height: 100vh; }</style>
</head>
<body>
<div id="map"></div>
<script>
var map = L.map('map').setView([-18.8792, 47.5079], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

var markers = {};
function loadDevices() {
    fetch("devices")
    .then(res => res.json())
    .then(data => {
        for (var id in markers) {
            map.removeLayer(markers[id]);
        }
        markers = {};
        data.forEach(d => {
            var marker = L.circleMarker([d.lat, d.lon], {color:d.color, radius:6}).addTo(map);
            marker.bindPopup("Appareil " + d.id);
            markers[d.id] = marker;
        });
    });
}
setInterval(loadDevices, 2000);
</script>
</body>
</html>