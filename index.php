<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {
    $data = $_POST['data'];
    file_put_contents("frape.txt", $data . "\n", FILE_APPEND);
    echo "OK";
} else {
    echo "Serveur Render opérationnel - en attente de données POST";
}
?>
