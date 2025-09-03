<?php
include "koneksi.php";
include "libs/simplexlsx.class.php"; // panggil library

if (isset($_POST['upload-excel'])) {
    if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] == 0) {
        $file_tmp = $_FILES['excel_file']['tmp_name'];

        if ($xlsx = SimpleXLSX::parse($file_tmp)) {
            $inserted = 0;
            $failed = 0;

            // Lewati header (row pertama)
            $rows = $xlsx->rows();
            foreach ($rows as $index => $row) {
                if ($index == 0) continue; // skip header

                $nama_peralatan = mysqli_real_escape_string($conn, $row[0]);
                $deskripsi      = mysqli_real_escape_string($conn, $row[1]);
                $stok           = (int)$row[2];

                $gambar    = NULL;
                $id_ruangan = 0;

                $sql = "INSERT INTO stok_peralatan 
                        (nama_peralatan, deskripsi, stok, gambar, id_ruangan) 
                        VALUES ('$nama_peralatan', '$deskripsi', '$stok', NULL, '$id_ruangan')";

                if (mysqli_query($conn, $sql)) {
                    $inserted++;
                } else {
                    $failed++;
                }
            }

            echo "<script>
                alert('Upload selesai. Sukses: $inserted | Gagal: $failed');
                window.location.href='dashboard-stok-peralatan.php';
            </script>";
        } else {
            echo "<script>alert('Gagal membaca file Excel: " . SimpleXLSX::parseError() . "');</script>";
        }
    } else {
        echo "<script>alert('Upload gagal. Pastikan pilih file Excel.'); window.location.href='dashboard-stok-peralatan.php';</script>";
    }
}
?>