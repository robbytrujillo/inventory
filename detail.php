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
        $img = '<img src="images/'.$gambar.'" class="zoomable">';
    }

    // generate
    $urlview = 'http://localhost/inventory/view.php?id='.$id_peralatan;
    // $qrcode = 'https://chart.googleapis.com/chart?chs=350x350&cht=qr&chl='.$urlview.'&choe=UTF-8';
    $qrcode = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$urlview.'';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Stok | Detail Peralatan</title>
        <link rel="icon" type="image/x-icon" href="assets/img/ihbs-logo.png">

        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

        <!-- modal -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="css/style-image.css" />
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
            <!-- Navbar Brand-->
            <!-- <a class="navbar-brand ps-3" href="index.php">Inventory IHBS</a> -->
            <img src="./assets/img/inventory-logo.png" style="width: 120px; margin-left: 2%; margin-top: 0%; margin-right: 5%" href="index.php">
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Dashboard</div>
                            <a class="nav-link" href="dashboard-stok-peralatan.php">
                                <div class="sb-nav-link-icon"><i class="fa-regular fa-clipboard"></i></div>
                                Stok Peralatan
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-circle-left"></i></div>
                                Peralatan Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-circle-right"></i></div>
                                Peralatan Keluar
                            </a>
                            <a class="nav-link" href="dashboard-stok-peralatan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-arrow-left"></i></div>
                                Kembali
                            </a>
                            <hr />
                            <a class="nav-link" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-ban"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Detail Peralatan</h1>                     
                            <div class="card mb-4 mt-4">
                                <div class="card-header">
                                    <h2><?= $nama_peralatan; ?></h2>
                                    <?= $img; ?>
                                    <img src="<?= $qrcode; ?>">
                                    
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">Deskripsi</div>
                                        <div class="col-md-9">: <?= $deskripsi; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">Stok</div>
                                        <div class="col-md-9">: <?= $stok; ?></div>
                                    </div>

                                    <br><br>

                                    <h3>Peralatan Masuk</h3>   
                                    <table id="datatablesSimple" class="table table-bordered" id="peralatanmasuk" width="100%" cellspacing="0">                                       
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Keterangan</th>
                                                <th>Jumlah Masuk</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $ambildatamasuk = mysqli_query($conn, "SELECT * FROM peralatan_masuk WHERE id_peralatan = '$id_peralatan'");
                                                $i = 1;

                                                while ($fetch = mysqli_fetch_array($ambildatamasuk)) {
                                                    $tanggal = $fetch['tanggal'];                                           
                                                    $keterangan = $fetch['keterangan'];                                           
                                                    $jumlah_masuk = $fetch['jumlah_masuk'];   
                                            ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $tanggal; ?></td>
                                                    <td><?= $keterangan; ?></td>
                                                    <td><?= $jumlah_masuk; ?></td>
                                                </tr>
                                            
                                            <?php 
                                            };
                                            ?>

                                        </tbody>
                                    </table>

                                    <h3>Peralatan Keluar</h3>   
                                    <table id="datatablesSimple" class="table table-bordered" id="peralatankeluar" width="100%" cellspacing="0">                                       
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Keluar</th>
                                                <th>Penerima</th>
                                                <th>Jumlah Keluar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $ambildatakeluar = mysqli_query($conn, "SELECT * FROM peralatan_keluar WHERE id_peralatan = '$id_peralatan'");
                                                $i = 1;

                                                while ($fetch = mysqli_fetch_array($ambildatakeluar)) {
                                                    $tanggal_keluar = $fetch['tanggal_keluar'];                                           
                                                    $penerima = $fetch['penerima'];                                           
                                                    $jumlah_keluar = $fetch['jumlah_keluar'];   
                                            ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $tanggal_keluar; ?></td>
                                                    <td><?= $penerima; ?></td>
                                                    <td><?= $jumlah_keluar; ?></td>
                                                </tr>
                                            
                                            <?php 
                                            };
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                </main>
                
                <?php 
                include "footer.php";
                ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    
        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Tambah Peralatan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="text" name="nama_peralatan" placeholder="Nama Peralatan" class="form-control" required>
                        <br>
                        <input type="text" name="deskripsi" placeholder="Deskripsi Peralatan" class="form-control" required>
                        <br>
                        <input type="number" name="stok" placeholder="Stok" class="form-control" required>
                        <br>
                        <input type="file" name="file" class="form-control" required>
                        <br>
                        <button type="submit" class="btn btn-success" name="addnewperalatan"><b>Submit</b></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><b>Close</b></button>
                    </div>
                </form>               
            </div>
            </div>
        </div>    
    </body>
</html>
