<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file']['tmp_name'];
    $handle = fopen($file, 'r');

    // Skip header row
    fgetcsv($handle, 1000, ',');

    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
        $nama_peralatan = $data[0];
        $deskripsi = $data[1];
        $stok = $data[2];
        $gambar = $data[3];
        $id_ruangan = $data[4];

        // Insert data ke database
        $stmt = $pdo->prepare("INSERT INTO stok_peralatan (nama_peralatan, deskripsi, stok, gambar, id_ruangan) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nama_peralatan, $deskripsi, $stok, $gambar, $id_ruangan]);
    }

    fclose($handle);
    header('Location: stok_perlatan.php');
    exit;
}
?>