<?php
$token = $_GET['token'] ?? 'guest';
$data = json_decode(file_get_contents("php://input"), true);
if ($data) {
    $devices = [];
    if (file_exists("devices.json")) {
        $devices = json_decode(file_get_contents("devices.json"), true);
    }
    $devices[$token] = $data; // associer la position au token
    file_put_contents("devices.json", json_encode($devices));
}
?>
