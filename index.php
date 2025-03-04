<?php
include "koneksi.php"; // Koneksi database
include "phpqrcode/qrlib.php"; // Pastikan path benar
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index | Inventory</title>
    <link rel="icon" type="image/x-icon" href="assets/img/ihbs-logo.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .qr-code {
            text-align: center;
        }
        .qr-code img {
            max-width: 150px;
            margin-top: 10px;
        }
        .search-box {
            max-width: 400px;
            margin: auto;
        }
        .error-message {
            max-width: 600px;
            margin: 20px auto;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- <h2 class="text-success">📦 Sistem Inventaris Sekolah</h2> -->
        <img src="./assets/img/inventory-logo.png" style="width: 150px; margin-left: 0%; margin-top: 0%">
        <a href="login.php" class="btn btn-outline-success rounded-pill">🔐 <b>Login</b></a>
    </div>

   

    <form method="GET" class="search-box">
        <div class="input-group mb-4">
            <input type="text" name="nama_ruangan" class="form-control" placeholder="🔍 Cari ruangan..." required>
            <div class="input-group-append">
                <button class="btn btn-success" type="submit">Cari</button>
            </div>
        </div>
    </form>

    <div class="row">
    <!-- Bagian Daftar Peralatan -->
    <div class="col-md-9">
        <div class="row">
            <?php
            if (isset($_GET['nama_ruangan'])) {
                $nama_ruangan = $_GET['nama_ruangan'];

                $sql = "SELECT r.nama_ruangan, s.nama_peralatan, s.stok 
                        FROM stok_peralatan s
                        JOIN ruangan r ON s.id_ruangan = r.id_ruangan
                        WHERE r.nama_ruangan = ?";

                if (!$stmt = $conn->prepare($sql)) {
                    echo "<div class='alert alert-danger error-message'>Query Error: " . $conn->error . "</div>";
                    exit;
                }

                $stmt->bind_param("s", $nama_ruangan);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $qr_data = "Ruangan: $nama_ruangan\n\nDaftar Barang:\n";

                    echo "<div class='col-12'>
                            <div class='alert alert-success'><strong>Ruangan $nama_ruangan </strong> ditemukan, berikut adalah data peralatannya:</div>
                          </div>";

                    while ($row = $result->fetch_assoc()) {
                        // echo "Berikut adalah perlatan yang ada di ruangan $nama_ruangan";
                        echo "<div class='col-md-4 mb-4'>
                                <div class='card'>
                                    <div class='card-body text-center'>
                                        <h5 class='card-title'>{$row['nama_peralatan']}</h5>
                                        <p class='card-text'><strong>Stok: </strong>{$row['stok']}</p>
                                    </div>
                                </div>
                              </div>";

                        // Tambahkan data barang ke dalam QR Code
                        $qr_data .= "- {$row['nama_peralatan']} (Stok: {$row['stok']})\n\n";
                    }

                    // Buat folder qrcodes jika belum ada
                    if (!file_exists("qrcodes")) {
                        mkdir("qrcodes", 0777, true);
                    }

                    // Buat QR Code
                    $qr_filename = "qrcodes/" . md5($nama_ruangan) . ".png";
                    QRcode::png($qr_data, $qr_filename, QR_ECLEVEL_L, 5);
                } else {
                    echo "<div class='col-12'><div class='alert alert-danger'>Ruangan tidak ditemukan.</div></div>";
                }

                $stmt->close();
            }
            ?>
        </div>
    </div>

    <!-- Bagian QR Code -->
    <?php if (isset($qr_filename)) : ?>
        <div class="col-md-3 text-center">
            <div class="card p-4">
                <h5>QR Code Ruangan:</h5>
                <img id="qrImage" src="<?= $qr_filename ?>" alt="QR Code Ruangan">
                <button class="btn btn-success mt-3" onclick="printQRCode()">🖨 Cetak QR Code</button>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- <script>
function printQRCode() {
    var qrWindow = window.open('', '_blank');
    qrWindow.document.write('<html><head><title>Cetak QR Code</title></head><body>');
    qrWindow.document.write('<img src="' + document.getElementById('qrImage').src + '" style="width:300px;">');
    qrWindow.document.write('<script>window.onload = function() { window.print(); window.close(); }<' + '/script>');
    qrWindow.document.write('</body></html>');
    qrWindow.document.close();
}
</script> -->


    <div class="row">
        <div class="col-md-4 bg-white">
            <div class="card bg-light mb-3 shadow-sm rounded-lg border-0">
                <div class="card-body">
                    <!-- <h5 class="card-title">Data Perijinan</h5> -->
                    <img src="assets/img/ruang.svg" style="height: 320px" class="cover img-fluid">
                    <h5 class="card-text text-center mt-3 mb-3">Melihat data ruangan</h5>
                    <div class="d-flex justify-content-center">
                        <a href="data-perijinan.php" class="btn btn-outline-success btn-block font-weight-bold rounded-pill">Lihat Data</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light mb-3 shadow-sm rounded-lg border-0">
                <div class="card-body">
                    <!-- <h5 class="card-title">Data Kedatangan</h5> -->
                    <img src="assets/img/unit.svg" style="height: 320px" class="cover img-fluid">
                    <h5 class="card-text text-center mt-3 mb-3">Melihat data unit</h5>
                    <div class="d-flex justify-content-center">
                        <a href="data-kedatangan.php" class="btn btn-outline-success btn-block font-weight-bold rounded-pill">Lihat Data</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light mb-3 shadow-sm rounded-lg border-0">
                <div class="card-body">
                    <!-- <h5 class="card-title">Perijinan Laptop</h5> -->
                    <img src="assets/img/taking-notes.svg" style="height: 320px" class="cover img-fluid">
                    <h5 class="card-text text-center mt-3 mb-3">Melihat Stok Peralatan</h5>
                    <div class="d-flex justify-content-center">
                        <a href="form-perijinan-laptop.php" class="btn btn-outline-success btn-block font-weight-bold rounded-pill">Lihat Data</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php  
    include "footer.php";
?>
</div>

<script>
function printQRCode() {
    var qrWindow = window.open('', '_blank');
    qrWindow.document.write('<html><head><title>Cetak QR Code</title></head><body>');
    qrWindow.document.write('<img src="' + document.getElementById('qrImage').src + '" style="width:750px;">');
    qrWindow.document.write('<script>window.onload = function() { window.print(); window.close(); }<' + '/script>');
    qrWindow.document.write('</body></html>');
    qrWindow.document.close();
}
</script>

</body>
</html>
