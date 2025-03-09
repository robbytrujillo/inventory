<?php 
    require 'function.php';
    require 'cek.php';

    // get data
    // ambil data total
    $get1 = mysqli_query($conn, "SELECT * FROM peminjaman");
    $count1 = mysqli_num_rows($get1); // menghitung seluruh kolom

    // ambil data peminjaman yang statusnya dipinjam
    $get2 = mysqli_query($conn, "SELECT * FROM peminjaman WHERE status='Dipinjam'");
    $count2 = mysqli_num_rows($get2); // menghitung seluruh kolom yang statusnya dipinjam

    // ambil data peminjaman yang statusnya Kembali
    $get3 = mysqli_query($conn, "SELECT * FROM peminjaman WHERE status='Kembali'");
    $count3 = mysqli_num_rows($get3); // menghitung seluruh kolom yang statusnya dipinjam

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Peminjaman Peralatan | Inventory</title>
        <link rel="icon" type="image/x-icon" href="assets/img/ihbs-logo.png">

        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

        <link rel="stylesheet" href="css/style-image.css">
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
            <!-- Navbar Brand-->
            <!-- <a class="navbar-brand ps-3" href="index.php">Inventory IHBS</a> -->
            <img src="./assets/img/inventory-logo.png" style="width: 120px; margin-left: 2%; margin-top: 0%; margin-right: 5%" href="index.php">
            <!-- <img src="./assets/img/inventory-logo.png" style="width: 200px; margin-left: 25%; margin-top: 5%"> -->
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
                            <a class="nav-link" href="peminjaman.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-hand-holding-usd"></i></div>
                                Peminjaman Peralatan
                            </a>
                            <a class="nav-link" href="unit.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-university"></i></div>
                                Unit
                            </a>
                            <a class="nav-link" href="ruangan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-store-alt"></i></div>
                                Ruangan
                            </a>
                            <a class="nav-link" href="user.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                                User
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
                        <h1 class="mt-4">Peminjaman Peralatan</h1>                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-success mb-3 rounded-pill" data-toggle="modal" data-target="#myModal">
                                    <!-- <i class="far fa-plus-square"></i>  -->
                                    <b>Tambah Peminjaman</b>
                                </button>
                                <div class="row mb-3">
                                    <div class="col ">
                                        <div class="card bg-primary text-white p-3"><h3>Total Data: <?= $count1; ?></h3></div>
                                    </div>
                                    <div class="col">
                                        <div class="card bg-warning text-white p-3"><h3>Total Dipinjam: <?= $count2; ?></h3></div>
                                    </div>
                                    <div class="col">
                                        <div class="card bg-danger text-white p-3"><h3>Total Kembali: <?= $count3; ?></h3></div>
                                    </div>
                                </div>
                                <div class="row">
                                   <div class="col">
                                        <form method="POST" class="form-inline">
                                            <input type="date" name="tgl_mulai" class="form-control col-md-2 mb-3">
                                            <input type="date" name="tgl_selesai" class="form-control col-md-2 mb-3 ml-3">
                                            <button type="submit" class="btn btn-info mb-3 ml-3 rounded-pill" name="filter_tgl">Filter</button>
                                        </form>
                                   </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Gambar</th>
                                            <th>Nama Peralatan</th>
                                            <th>Jumlah Peminjaman</th>
                                            <th>Kepada</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                            <!-- <th>Start date</th>
                                            <th>Salary</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        if (isset($_POST['filter_tgl'])) {
                                            $tgl_mulai = $_POST['tgl_mulai'];
                                            $tgl_selesai = $_POST['tgl_selesai'];

                                            if ($tgl_mulai != null || $tgl_selesai != null) {
                                                $ambilsemuadatastok = mysqli_query($conn, "SELECT * FROM peminjaman p, stok_peralatan s WHERE s.id_peralatan = p.id_peralatan AND tanggal_pinjam BETWEEN '$tgl_mulai' AND  DATE_ADD('$tgl_selesai', INTERVAL 1 DAY) ORDER BY id_peminjaman DESC");
                                            } else {
                                                $ambilsemuadatastok = mysqli_query($conn, "SELECT * FROM peralatan_keluar p, stok_peralatan s WHERE s.id_peralatan = p.id_peralatan ORDER BY id_peminjaman DESC");
                                            }
                                        }          
                                        else {
                                        $ambilsemuadatastok = mysqli_query($conn, "SELECT * FROM peminjaman p, stok_peralatan s WHERE s.id_peralatan = p.id_peralatan ORDER BY id_peminjaman DESC");
                                        }
                                        
                                        $i = 1;

                                        while($data=mysqli_fetch_array($ambilsemuadatastok)) {
                                            $idk = $data['id_peminjaman'];
                                            $idp = $data['id_peralatan'];
                                            $tanggal_pinjam = $data['tanggal_pinjam'];
                                            $nama_peralatan = $data['nama_peralatan'];
                                            $jumlah_peminjaman = $data['jumlah_peminjaman'];
                                            $peminjam = $data['peminjam'];
                                            $status = $data['status'];

                                             // cek ada gambar atau tidak
                                             $gambar = $data['gambar']; // ambil gambar
                                             if ($gambar == null) {
                                                 // jika tidak ada gambar
                                                 $img = 'No Photo';
                                             } else {
                                                 // jika ada gambar
                                                 $img = '<img src="images/'.$gambar.'" class="zoomable">';
                                             }
                                        ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $tanggal_pinjam; ?></td>
                                            <td><?= $img; ?></td>
                                            <td><?= $nama_peralatan; ?></td>
                                            <td><?= $jumlah_peminjaman; ?></td>
                                            <td><?= $peminjam; ?></td>
                                            <td><?= $status; ?></td>
                                            <td>
                                                <?php 
                                                    // cek status
                                                    if ($status == 'Dipinjam') {
                                                        echo '<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit'.$idk.'">
                                                                <i class="fas fa-edit">Selesai</i>
                                                             </button>';
                                                    } else {
                                                        // jika statusnya bukan dipinjam (kembali);
                                                        echo 'Barang telah kembali';
                                                    }
                                                ?>
                                                
                                                
                                            </td>
                                        </tr>

                                        <!-- Selesaikan Modal -->
                                        <div class="modal fade" id="edit<?= $idk; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Selesaikan</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <label class="mb-2">Apakah peralatan ini sudah selesai dipinjam?</label>
                                                            <br>
                                                            <input type="hidden" name="id_peralatan" value="<?= $idp; ?>">
                                                            <input type="hidden" name="id_pinjam" value="<?= $idk; ?>">
                                                            <button type="submit" class="btn btn-success" name="peralatankembali"><b>Iya</b></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <?php 
                                        };
                                        ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                       
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; IT Development Inventory IHBS 2025</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
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
                <h4 class="modal-title">Tambah Peminjaman Peralatan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <form method="post">
                    <div class="modal-body">
                    <select name="peralatannya" class="form-control">
                            <?php  
                                $ambilsemuadatanya = mysqli_query($conn, "SELECT * FROM stok_peralatan");
                                while($fetcharray = mysqli_fetch_array($ambilsemuadatanya)) {
                                    $nama_peralatannya = $fetcharray['nama_peralatan'];
                                    $id_peralatannya = $fetcharray['id_peralatan'];
                            ?>
                            <option value="<?=$id_peralatannya;?>"><?=$nama_peralatannya;?></option>    
                            <?php
                                }
                            ?>
                        </select>
                        <!-- <input type="text" name="nama_peralatan" placeholder="Nama Peralatan" class="form-control" required> -->
                        <br>
                        <input type="number" name="jumlah_peminjaman" placeholder="Jumlah Peminjaman" class="form-control" required>
                        <br>
                        <input type="text" name="peminjam" placeholder="Peminjam" class="form-control" required>
                        <br>
                        <button type="submit" class="btn btn-success" name="pinjam"><b>Submit</b></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><b>Close</b></button>
                    </div>
                </form>

                <!-- Modal footer -->
                <!-- <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div> -->
                
            </div>
            </div>
        </div>
    
    </body>
</html>
