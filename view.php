<?php 
    require 'function.php';
    require 'cek.php';

     // Dapetkan ID barang yang dipassing di halaman sebelumnya
     $id_peralatan = $_GET['id']; // get id peralatan

     // Get informasi peralatan berdasarkan database
     $get = mysqli_query($conn,  "SELECT * FROM stok_peralatan WHERE id_peralatan='$id_peralatan'");
     $fetch = mysqli_fetch_assoc($get);
 
     // set variable
     $nama_peralatan = $fetch['nama_peralatan'];
     $deskripsi = $fetch['deskripsi'];
     $stok = $fetch['stok'];
     // $gambar = $fetch['gambar'];
 
     // cek ada gambar atau tidak
     $gambar = $fetch['gambar']; // ambil gambar
     if ($gambar == null) {
         // jika tidak ada gambar
         $img = 'No Photo';
     } else {
         // jika ada gambar
         $img = '<img class="card-img-top" src="images/'.$gambar.'" alt="Card image" style="width:100%">';
     }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Menampilkan Peralatan</title> 
    <link rel="stylesheet" href="css/style-image.css">
</head>
<body>
<div class="container mt-4">
    <!-- <h2>Card Image</h2> -->
    <h3>Detail Peralatan</h3>
    <div class="card" style="width:400px">
        <?= $img; ?>
        <!-- <img class="card-img-top" src="img_avatar1.png" alt="Card image" style="width:100%"> -->
        <div class="card-body">
        <h4 class="card-title"><?= $nama_peralatan; ?></h4>
        <p class="card-text"><?= $deskripsi; ?></p>
        <p class="card-text"><?= $stok; ?></p>
        <!-- <a href="#" class="btn btn-primary"><?= $stok; ?></a> -->
        </div>
    </div>
    <br>
</div>
</body>
</html>