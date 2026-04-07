<?php
$token = $_GET['token'] ?? 'guest';
?>
<!DOCTYPE html>
<html>
<head><title>Invitation Radar</title></head>
<body>
<h3>Partage de position activé</h3>
<script>
function sendPosition(position) {
  fetch('save.php?token=<?php echo $token; ?>', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({
      lat: position.coords.latitude,
      lon: position.coords.longitude,
      accuracy: position.coords.accuracy // précision en mètres
    })
  });
}

// Utiliser watchPosition pour un suivi continu et plus précis
if (navigator.geolocation) {
  navigator.geolocation.watchPosition(
    sendPosition,
    (error) => console.error(error),
    { enableHighAccuracy: true, maximumAge: 0, timeout: 5000 }
  );
} else {
  alert("GPS non supporté");
}
</script>
</body>
</html>
