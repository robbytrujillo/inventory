<?php 
session_start();

// connect database
$conn = mysqli_connect("localhost", "root", "","inventory");

// menambah peralatan baru
if (isset($_POST['addnewperalatan'])) {
    $nama_peralatan  = $_POST['nama_peralatan'];
    $deskripsi      = $_POST['deskripsi'];
    $stok           = $_POST['stok'];

    $addtotable = mysqli_query($conn, "insert into stok_peralatan (nama_peralatan, deskripsi, stok) values ('$nama_peralatan', '$deskripsi', '$stok')");
    if ($addtotable) {
        header('location: index.php');
    } else {
        echo "gagal";
        header('location: index.php');
    }
}


?>