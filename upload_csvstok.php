<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 'admin') {
    header('Location: dashboard-stok-peralatan.php');
    exit;
}

require 'koneksi.php'; // ini bikin $conn pakai mysqli

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file']['tmp_name'];
    $handle = fopen($file, 'r');

    // Skip header row
    fgetcsv($handle, 1000, ',');

    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
        $nama_peralatan = isset($data[0]) ? trim($data[0]) : '';
        $deskripsi      = isset($data[1]) ? trim($data[1]) : '';
        $stok           = isset($data[2]) ? (int)$data[2] : 0;
        $gambar         = isset($data[3]) ? trim($data[3]) : null;
        $id_ruangan     = isset($data[4]) ? (int)$data[4] : null;

        if ($nama_peralatan !== '') {
            // Coba update stok dulu
            $update = $conn->prepare("
                UPDATE stok_peralatan 
                SET deskripsi = ?, stok = stok + ?, gambar = ?, id_ruangan = ?
                WHERE LOWER(TRIM(nama_peralatan)) = LOWER(TRIM(?))
            ");
            $update->bind_param("sisis", $deskripsi, $stok, $gambar, $id_ruangan, $nama_peralatan);
            $update->execute();

            // Kalau tidak ada baris yang diupdate → insert baru
            if ($update->affected_rows === 0) {
                $insert = $conn->prepare("
                    INSERT INTO stok_peralatan (nama_peralatan, deskripsi, stok, gambar, id_ruangan) 
                    VALUES (?, ?, ?, ?, ?)
                ");
                $insert->bind_param("ssisi", $nama_peralatan, $deskripsi, $stok, $gambar, $id_ruangan);
                $insert->execute();
            }
        }
    }

    fclose($handle);
    header('Location: dashboard-stok-peralatan.php?upload=success');
    exit;
}
?>