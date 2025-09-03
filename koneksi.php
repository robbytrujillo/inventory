<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "inventory";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set charset UTF-8 biar aman simpan teks
$conn->set_charset("utf8mb4");
?>