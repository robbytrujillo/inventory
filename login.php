<?php 
    require 'function.php';
    require 'koneksi.php';
    

    // cek login
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // cek database
        $cekdatabase = mysqli_query($conn, "SELECT * FROM user where username='$username' and password='password'");
        // hitung jumlah data
        $hitung = mysqli_num_rows($cekdatabase);

        if ($hitung > 0) {
            $_SESSION['log'] = 'True';
            header('location: dashboard-stok-peralatan.php');
        } else {
            header('location: login.php');
        }
    }

    if (!isset($_SESSION['log'])) {
        // 
    } else {
        header('location:dashboard-stok-peralatan.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login | Inventory</title>
        <link rel="icon" type="image/x-icon" href="assets/img/ihbs-logo.png">
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-light">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <br><br>
                    <div class="container mt-5">
                    
                        <div class="row justify-content-center">
                            <div class="col-lg-4">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <img src="./assets/img/inventory-logo.png" style="width: 200px; margin-left: 25%; margin-top: 5%">
                                    <!-- <a href="index.php" class="btn btn-outline-success" style="margin: auto;">Kembali</a> -->
                                    <!-- <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div> -->
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="username" id="inputUsername" type="text" placeholder="username" />
                                                <label class="small mb-1" for="inputUsername">Username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Password" />
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                            </div>
                                            <!-- <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                            </div> -->
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <!-- <div class="form-floating mb-3"> -->
                                                <!-- <a class="small" href="password.html">Forgot Password?</a> -->
                                                <button class="btn btn-success btn-lg btn-block rounded-pill" tabindex="15" style="font-size: medium; margin: auto" name="login">🔐 <b>Log In</b></button>
                                                <a href="index.php" class="btn btn-outline-success btn-lg rounded-pill" style="font-size: medium; margin: auto;"><b>Kembali</b></a>                                   
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small">Copyright &copy; IT Development IHBS 2025 </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                
            </div>
            <!-- <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Inventory IHBS 2025</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div> -->
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
