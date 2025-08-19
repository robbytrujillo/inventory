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
    <title>Dashboard | Ruangan</title>
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
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
        <!-- Navbar Brand-->
        <!-- <a class="navbar-brand ps-3" href="index.php">Inventory IHBS</a> -->
        <img src="./assets/img/inventory-logo.png"
            style="width: 120px; margin-left: 2%; margin-top: 0%; margin-right: 5%" href="index.php">
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>

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
                    <h1 class="mt-4">Ruangan</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-success rounded-pill" data-toggle="modal"
                                data-target="#myModal">
                                <b>Tambah Ruangan</b>
                            </button>
                            <!-- <a href="export-stok-peralatan.php" class="btn btn-info"><b>Export Data</b></a> -->
                        </div>
                        <div class="card-body">

                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Ruangan</th>
                                        <th>Koordinator</th>
                                        <th>Id Unit</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $ambilsemuadataruangan = mysqli_query($conn, "
                                            SELECT r.id_ruangan, r.nama_ruangan, r.koordinator, r.id_unit, u.nama_unit, u.alamat_unit, u.penanggung_jawab 
                                            FROM ruangan r 
                                            JOIN unit u ON r.id_unit = u.id_unit
                                        ");
                                        $i = 1;

                                        while($data=mysqli_fetch_array($ambilsemuadataruangan)) {                                          
                                            $nama_ruangan = $data['nama_ruangan'];
                                            $koordinator  = $data['koordinator'];
                                            $idunit       = $data['id_unit'];   // <-- simpan id_unit ruangan saat ini
                                            $nama_unit    = $data['nama_unit'];
                                            $idruangan    = $data['id_ruangan'];
                                        ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $nama_ruangan; ?></td>
                                        <td><?= $koordinator; ?></td>
                                        <td><?= $nama_unit; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#edit<?= $idruangan; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#delete<?= $idruangan; ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="edit<?= $idruangan; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Ubah Ruangan</h4>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <form method="post">
                                                    <div class="modal-body">
                                                        <label for="nama_ruangan"><b>Nama Ruangan</b></label>
                                                        <br>
                                                        <input type="text" name="nama_ruanganbaru"
                                                            value="<?= $nama_ruangan; ?>" class="form-control"
                                                            placeholder="Nama Unit" required>
                                                        <br>
                                                        <label for="koordinator"><b>Koordinator</b></label>
                                                        <br>
                                                        <input type="text" name="koordinatorbaru"
                                                            value="<?= $koordinator; ?>" placeholder="Koordinator"
                                                            class="form-control" required>
                                                        <br>
                                                        <label for="nama_unit"><b>Nama Unit</b></label>
                                                        <br>

                                                        <select name="id_unitbaru" class="form-control" required>
                                                            <?php
                                                            $ambilunit = mysqli_query($conn, "SELECT * FROM unit");
                                                            while($unit = mysqli_fetch_array($ambilunit)) {
                                                                $id_unit   = $unit['id_unit'];
                                                                $nama_unit_option = $unit['nama_unit'];
                                                                $selected = ($id_unit == $idunit) ? "selected" : "";
                                                                echo "<option value='$id_unit' $selected>$nama_unit_option</option>";
                                                            }
                                                            ?>
                                                        </select>

                                                        <br>
                                                        <!-- <input type="text" name="penanggung_jawabbaru"
                                                            value="<?= $penanggung_jawab; ?>"
                                                            placeholder="Penanggung Jawab" class="form-control"
                                                            required>
                                                        <br> -->
                                                        <input type="hidden" name="idruangan"
                                                            value="<?= $idruangan; ?>">
                                                        <button type="submit" class="btn btn-warning"
                                                            name="updateruangan"><b>Update</b></button>
                                                        <button type="button" class="btn btn-success"
                                                            data-dismiss="modal"><b>Close</b></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="delete<?= $idruangan; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus ruangan?</h4>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <form method="post">
                                                    <div class="modal-body">
                                                        Apakah anda yakin ingin menghapus <b><?= $nama_ruangan; ?></b>?
                                                        <input type="hidden" name="idruangan"
                                                            value="<?= $idruangan; ?>">
                                                        <br>
                                                        <br>
                                                        <button type="submit" class="btn btn-danger"
                                                            name="hapusruangan"><b>Hapus</b></button>
                                                        <button type="button" class="btn btn-success"
                                                            data-dismiss="modal"><b>Close</b></button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Ruangan</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form method="post">
                    <div class="modal-body">
                        <input type="text" name="nama_ruangan" placeholder="Nama Ruangan" class="form-control" required>
                        <br>
                        <input type="text" name="koordinator" placeholder="Koordinator" class="form-control" required>
                        <br>
                        <select name="id_unit" class="form-control" required>
                            <option value="">-- Pilih Unit --</option>
                            <?php
                            $ambilunit = mysqli_query($conn, "SELECT * FROM unit");
                            while($unit = mysqli_fetch_array($ambilunit)) {
                                $id_unit   = $unit['id_unit'];
                                $nama_unit = $unit['nama_unit'];
                                echo "<option value='$id_unit'>$nama_unit</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <button type="submit" class="btn btn-success rounded-pill"
                            name="addnewruangan"><b>Submit</b></button>
                        <button type="button" class="btn btn-danger rounded-pill"
                            data-dismiss="modal"><b>Close</b></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>