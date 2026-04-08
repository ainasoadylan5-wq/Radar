<?php
if (isset($_POST['data'])) {
    $data = $_POST['data'];
    file_put_contents("frape.txt", $data."\n", FILE_APPEND);
}
?>
