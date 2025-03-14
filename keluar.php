<?php 
    require 'function.php';
    require 'cek.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Peralatan Keluar | Inventory</title>

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
                                <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                                Unit
                            </a>
                            <a class="nav-link" href="ruangan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-store-alt"></i></div>
                                Ruangan
                            </a>
                            <!-- <a class="nav-link" href="user.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                                User
                            </a> -->
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
                        <h1 class="mt-4">Peralatan Keluar</h1>                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-success mb-3 rounded-pill" data-toggle="modal" data-target="#myModal">
                                    <!-- <i class="far fa-plus-square"></i>  -->
                                    <b>Tambah Peralatan Keluar</b>
                                </button>
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
                                            <th>Jumlah Keluar</th>
                                            <th>Penerima</th>
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
                                                $ambilsemuadatastok = mysqli_query($conn, "SELECT * FROM peralatan_keluar k, stok_peralatan s WHERE s.id_peralatan = k.id_peralatan AND tanggal_keluar BETWEEN '$tgl_mulai' AND  DATE_ADD('$tgl_selesai', INTERVAL 1 DAY) ORDER BY id_keluar DESC");
                                            } else {
                                                $ambilsemuadatastok = mysqli_query($conn, "SELECT * FROM peralatan_leluar k, stok_peralatan s WHERE s.id_peralatan = k.id_peralatan ORDER BY id_keluar DESC");
                                            }
                                        }          
                                        else {
                                        $ambilsemuadatastok = mysqli_query($conn, "SELECT * FROM peralatan_keluar k, stok_peralatan s WHERE s.id_peralatan = k.id_peralatan ORDER BY id_keluar DESC");
                                        }
                                        
                                        $i = 1;

                                        while($data=mysqli_fetch_array($ambilsemuadatastok)) {
                                            $idk = $data['id_keluar'];
                                            $idp = $data['id_peralatan'];
                                            $tanggal = $data['tanggal_keluar'];
                                            $nama_peralatan = $data['nama_peralatan'];
                                            $jumlah_keluar = $data['jumlah_keluar'];
                                            $penerima = $data['penerima'];

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
                                            <td><?= $tanggal; ?></td>
                                            <td><?= $img; ?></td>
                                            <td><?= $nama_peralatan; ?></td>
                                            <td><?= $jumlah_keluar; ?></td>
                                            <td><?= $penerima; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $idk; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idk; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit<?= $idk; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Ubah Peralatan</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <!-- <input type="text" name="nama_peralatan" value="<?= $nama_peralatan; ?>" class="form-control" required>
                                                            <br> -->
                                                            <label><b>Jumlah Keluar</b></label>
                                                            <br>
                                                            <input type="number" name="jumlah_keluar" value="<?= $jumlah_keluar; ?>" class="form-control" required>
                                                            <br>
                                                            <label><b>Penerima</b></label>
                                                            <br>
                                                            <input type="text" name="penerima" value="<?= $penerima; ?>" class="form-control" required>
                                                            <br>
                                                            <input type="hidden" name="idp" value="<?= $idp; ?>">
                                                            <input type="hidden" name="idk" value="<?= $idk; ?>">
                                                            <button type="submit" class="btn btn-warning" name="updateperalatankeluar"><b>Update</b></button>
                                                            <button type="button" class="btn btn-success" data-dismiss="modal"><b>Close</b></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="delete<?= $idk; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Peralatan?</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menghapus <b><?= $nama_peralatan; ?></b>?
                                                            <input type="hidden" name="idp" value="<?= $idp; ?>">
                                                            <input type="hidden" name="jumlah_keluar" value="<?= $jumlah_keluar; ?>">
                                                            <input type="hidden" name="idk" value="<?= $idk; ?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-danger" name="hapusperalatankeluar"><b>Hapus</b></button>
                                                            <button type="button" class="btn btn-success" data-dismiss="modal"><b>Close</b></button>
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
                <h4 class="modal-title">Tambah Peralatan Keluar</h4>
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
                        <input type="number" name="jumlah_keluar" placeholder="Jumlah Keluar" class="form-control" required>
                        <br>
                        <input type="text" name="penerima" placeholder="Penerima" class="form-control" required>
                        <br>
                        <button type="submit" class="btn btn-success" name="addperalatankeluar"><b>Submit</b></button>
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
