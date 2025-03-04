<?php
include "phpqrcode/qrlib.php"; // Pastikan phpqrcode sudah diunduh

if (isset($_GET['data'])) {
    $data = urldecode($_GET['data']);
    QRcode::png($data);
}
?>
