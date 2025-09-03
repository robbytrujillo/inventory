<?php
include "koneksi.php";

if (isset($_POST['upload_csv'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $file_tmp = $_FILES['csv_file']['tmp_name'];

        // Buka file CSV
        if (($handle = fopen($file_tmp, "r")) !== FALSE) {
            // Lewati baris header
            fgetcsv($handle, 1000, ",");

            $inserted = 0;
            $failed   = 0;

            // Baca isi CSV baris demi baris
            while (($data = fgetcsv($handle, 1000, ",", '"')) !== FALSE) {
                // Pastikan jumlah kolom sesuai (3 kolom: nama, deskripsi, stok)
                if (count($data) < 3) {
                    continue;
                }

                $nama_peralatan = trim(mysqli_real_escape_string($conn, $data[0]));
                $deskripsi      = trim(mysqli_real_escape_string($conn, $data[1]));
                $stok           = (int)trim($data[2]);

                // Default kosong untuk kolom lain
                $gambar     = NULL;
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

            fclose($handle);

            echo "<script>
                alert('Upload selesai. Sukses: $inserted | Gagal: $failed');
                window.location.href='dashboard-stok-peralatan.php';
            </script>";
        } else {
            echo "<script>alert('Gagal membuka file CSV.'); window.location.href='dashboard-stok-peralatan.php';</script>";
        }
    } else {
        echo "<script>alert('Upload gagal. Pastikan pilih file CSV.'); window.location.href='dashboard-stok-peralatan.php';</script>";
    }
}
?>