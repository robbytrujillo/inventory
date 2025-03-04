<?php
include "koneksi.php"; // Koneksi database
include "phpqrcode/qrlib.php"; // Pastikan path benar
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventaris Sekolah</title>
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
    </style>
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success">📦 Sistem Inventaris Sekolah</h2>
        <a href="login.php" class="btn btn-outline-success">🔐 Login</a>
    </div>

    <form method="GET">
        <div class="input-group mb-4">
            <input type="text" name="nama_ruangan" class="form-control" placeholder="🔍 Cari ruangan..." required>
            <div class="input-group-append">
                <button class="btn btn-success" type="submit">Cari</button>
            </div>
        </div>
    </form>

    <?php
    if (isset($_GET['nama_ruangan'])) {
        $nama_ruangan = $_GET['nama_ruangan'];

        // Query untuk mencari ruangan dan barang di dalamnya
        // $sql = "SELECT r.nama_ruangan, s.nama_peralatan, s.stok 
        //         FROM ruangan r
        //         JOIN stok_peralatan s ON r.id_ruangan = s.id_ruangan
        //         WHERE r.nama_ruangan = ?";
        // $sql = "SELECT r.nama_ruangan, s.nama_peralatan, s.stok 
        // FROM ruangan r
        // JOIN stok_peralatan s ON r.id_ruangan = s.id_ruangan
        // WHERE r.nama_ruangan = ?";
        $sql = "SELECT r.nama_ruangan, s.nama_peralatan, s.stok 
        FROM stok_peralatan s
        JOIN ruangan r ON s.id_peralatan = r.id_peralatan
        WHERE r.nama_ruangan = ?";



        if (!$stmt = $conn->prepare($sql)) {
            die("<div class='alert alert-danger'>Query Error: " . $conn->error . "</div>");
        }

        $stmt->bind_param("s", $nama_ruangan);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $qr_data = "Ruangan: $nama_ruangan\n\nDaftar Barang:\n";

            echo "<div class='alert alert-success'><strong>Ruangan ditemukan: </strong> $nama_ruangan</div>";

            echo "<div class='card p-4'>
                    <h4 class='card-title text-center'>$nama_ruangan</h4>
                    <div class='table-responsive'>
                        <table class='table table-bordered'>
                            <thead class='thead-dark'>
                                <tr>
                                    <th>Nama Peralatan</th>
                                    <th>Jumlah Stok</th>
                                </tr>
                            </thead>
                            <tbody>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['nama_peralatan']}</td>
                        <td>{$row['stok']}</td>
                      </tr>";

                // Tambahkan data barang ke dalam QR Code
                $qr_data .= "- {$row['nama_peralatan']} (Stok: {$row['stok']})\n";
            }

            echo "        </tbody>
                        </table>
                    </div>";

            // Buat folder qrcodes jika belum ada
            if (!file_exists("qrcodes")) {
                mkdir("qrcodes", 0777, true);
            }

            // Buat QR Code
            $qr_filename = "qrcodes/" . md5($nama_ruangan) . ".png";
            QRcode::png($qr_data, $qr_filename, QR_ECLEVEL_L, 5);

            echo "  <div class='qr-code'>
                        <h5>QR Code Ruangan:</h5>
                        <img src='$qr_filename' alt='QR Code Ruangan'>
                    </div>
                </div>";

        } else {
            echo "<div class='alert alert-danger'>Ruangan tidak ditemukan.</div>";
        }

        $stmt->close();
    }
    ?>
</div>

</body>
</html>
