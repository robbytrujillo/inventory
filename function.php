<?php 
session_start();

// connect database
$conn = mysqli_connect("localhost", "root", "","inventory");

// menambah peralatan baru
if (isset($_POST['addnewperalatan'])) {
    $nama_peralatan  = $_POST['nama_peralatan'];
    $deskripsi      = $_POST['deskripsi'];
    $stok           = $_POST['stok'];

    // soal gambar
    $allowed_extension = array('png','jpg'); 
    $nama = $_FILES['file']['name']; // mengambil nama gambar
    $dot = explode('.',$nama); 
    $ekstensi = strtolower(end($dot)); // mengambil ektensinya
    $ukuran = $_FILES['file']['size']; // mengambil size filenya
    $file_tmp = $_FILES['file']['tmp_name']; // mengambil lokasi filenya

    // penamaan file -> enkripsi
    $image = md5(uniqid($nama, true) . time()).'.'.$ekstensi; // menggabungkan nama file yang dienkripsi dengan ekstensinya

    $cek = mysqli_query($conn, "SELECT * FROM stok_peralatan WHERE nama_peralatan= '$nama_peralatan'");
    $hitung = mysqli_num_rows($cek);

    if ($hitung < 1) {
        // jika belum ada

        // proses upload gambar
        if (in_array($ekstensi, $allowed_extension) === true) {
            // validasi ukuran filenya
            if ($ukuran < 15000000) {
                move_uploaded_file($file_tmp, 'images/'.$image);

                $addtotable = mysqli_query($conn, "INSERT INTO stok_peralatan (nama_peralatan, deskripsi, stok, gambar) VALUES ('$nama_peralatan', '$deskripsi', '$stok', '$image')");
                if ($addtotable) {
                    header('location: index.php');
                } else {
                    echo "Gagal";
                    header('location: index.php');
                }
            } else {
                //  kalau filenya lebih dari 15mb
                echo '
                    <script>
                        alert("Ukuran terlalu besar");
                        window.location.href="index.php";
                    </script>
            ';
            }
        } else {
            // kalau filenya tidak png / jpg
            echo '
                <script>
                    alert("File harus png/jpg");
                    window.location.href="index.php";
                </script>
            ';
        }

    } else {
        // jika sudah ada
        echo '
            <script>
                alert("Nama perlatan sudah terdaftar");
                window.location.href="index.php";
            </script>
        ';
    }
}

// menambah peralatan masuk
if(isset($_POST['peralatanmasuk'])) {
    $peralatannya = $_POST['peralatannya'];
    $penerima = $_POST['penerima'];
    $jumlah_masuk = $_POST['jumlah_masuk'];

    $cekstoksekarang = mysqli_query($conn, "SELECT * FROM stok_peralatan WHERE id_peralatan='$peralatannya'");
    $ambildatanya = mysqli_fetch_array($cekstoksekarang);
    
    $stoksekarang = $ambildatanya['stok'];
    $tambahkanstoksekarangdenganjumlah = $stoksekarang + $jumlah_masuk;


    $addtomasuk = mysqli_query($conn, "INSERT INTO peralatan_masuk (id_peralatan, keterangan, jumlah_masuk) VALUES ('$peralatannya', '$penerima', '$jumlah_masuk')");
    $updatestokmasuk = mysqli_query($conn, "UPDATE stok_peralatan SET stok='$tambahkanstoksekarangdenganjumlah' WHERE id_peralatan='$peralatannya'");
    
    if ($addtomasuk && $updatestokmasuk) {
        header('location: masuk.php');
    } else {
        echo "gagal";
        header('location: masuk.php');
    }
}

// menambah peralatan keluar
if(isset($_POST['addperalatankeluar'])) {
    $peralatannya = $_POST['peralatannya'];
    $penerima = $_POST['penerima'];
    $jumlah_keluar = $_POST['jumlah_keluar'];

    $cekstoksekarang = mysqli_query($conn, "SELECT * FROM stok_peralatan WHERE id_peralatan='$peralatannya'");
    $ambildatanya = mysqli_fetch_array($cekstoksekarang);
    
    $stoksekarang = $ambildatanya['stok'];
    if ($stoksekarang >= $jumlah_keluar) {
        // jika stok cukup
        $kurangkanstoksekarangdenganjumlah = $stoksekarang - $jumlah_keluar;

        $addtokeluar = mysqli_query($conn, "INSERT INTO peralatan_keluar (id_peralatan, penerima, jumlah_keluar) VALUES ('$peralatannya', '$penerima', '$jumlah_keluar')");
        $updatestokkeluar = mysqli_query($conn, "UPDATE stok_peralatan SET stok='$kurangkanstoksekarangdenganjumlah' WHERE id_peralatan='$peralatannya'");
        
        if ($addtokeluar && $updatestokkeluar) {
            header('location: keluar.php');
        } else {
            echo "gagal";
            header('location: keluar.php');
        }
    } else {
        // jika stok tidak cukup
        echo '
        <script>
            alert("Stok saat ini tidak mencukupi");
            window.location.href="keluar.php";
        </script>
        ';
    }
}

// update stok peralatan
if (isset($_POST['updateperalatan'])) {
    $idp = $_POST['idp'];
    $nama_peralatan = $_POST['nama_peralatan'];
    $deskripsi = $_POST['deskripsi'];
    
    // soal gambar
    $allowed_extension = array('png','jpg'); 
    $nama = $_FILES['file']['name']; // mengambil nama gambar
    $dot = explode('.',$nama); 
    $ekstensi = strtolower(end($dot)); // mengambil ektensinya
    $ukuran = $_FILES['file']['size']; // mengambil size filenya
    $file_tmp = $_FILES['file']['tmp_name']; // mengambil lokasi filenya

    // penamaan file -> enkripsi
    $image = md5(uniqid($nama, true) . time()).'.'.$ekstensi; // menggabungkan nama file yang dienkripsi dengan ekstensinya

    if ($ukuran == 0) {
        // jika tidak ingin upload
        $update = mysqli_query($conn, "UPDATE stok_peralatan SET nama_peralatan='$nama_peralatan', deskripsi='$deskripsi' WHERE id_peralatan='$idp'");
        if ($update) {
            header('location: index.php');
        } else {
            echo "gagal";
            header('location: index.php');
        }
    } else {
        // jika ingin upload
        move_uploaded_file($file_tmp, 'images/'.$image);
        $update = mysqli_query($conn, "UPDATE stok_peralatan SET nama_peralatan='$nama_peralatan', deskripsi='$deskripsi', gambar='$image' WHERE id_peralatan='$idp'");
        if ($update) {
            header('location: index.php');
        } else {
            echo "gagal";
            header('location: index.php');
        }
    }
}

// hapus stok peralatan
if (isset($_POST['hapusperalatan'])) {
    $idp = $_POST['idp']; // od peralatan

    $gambar = mysqli_query($conn, "SELECT * FROM WHERE id_peralatan='$idp'");
    $get = mysqli_fetch_array($gambar);
    $img = 'images/'.$get['gambar'];
    unlink($img);

    $hapus = mysqli_query($conn, "DELETE FROM stok_peralatan WHERE id_peralatan='$idp'");
    if ($hapus) {
        header('location: index.php');
    } else {
        echo "gagal";
        header('location: index.php');
    }
}

// Mengubah data peralatan masuk
if (isset($_POST['updateperalatanmasuk'])) {
    $idp = $_POST['idp'];
    $idm = $_POST['idm'];
    $keterangan = $_POST['keterangan'];
    $jumlah_masuk = $_POST['jumlah_masuk'];

    $lihatstok = mysqli_query($conn, "SELECT * FROM stok_peralatan WHERE id_peralatan='$idp;'");
    $stoknya = mysqli_fetch_array($lihatstok);
    $stoksekarang = $stoknya['stok'];

    $jumlah_masukskrg = mysqli_query($conn, "SELECT * FROM peralatan_masuk where id_masuk='$idm'");
    $jumlah_masuknya = mysqli_fetch_array($jumlah_masukskrg);
    $jumlah_masukskrg = $jumlah_masuknya['jumlah_masuk'];

    if ($jumlah_masuk > $jumlah_masukskrg) {
        $selisih = $jumlah_masuk - $jumlah_masukskrg;
        $kurangin = $stoksekarang + $selisih;
        $kurangistoknya = mysqli_query($conn, "UPDATE stok_peralatan SET stok='$kurangin' WHERE id_peralatan='$idp'");
        $updatenya = mysqli_query($conn, "UPDATE peralatan_masuk SET jumlah_masuk='$jumlah_masuk', keterangan='$keterangan' WHERE id_masuk='$idm'");
        if ($kurangistoknya && $updatenya) {
            header('location: masuk.php');
        } else {
            echo "gagal";
            header('location: masuk.php');
        }
    } else {
            $selisih = $jumlah_masukskrg - $jumlah_masuk;
            $kurangin = $stoksekarang - $selisih;
            $kurangistoknya = mysqli_query($conn, "UPDATE stok_peralatan SET stok='$kurangin' WHERE id_peralatan='$idp'");
            $updatenya = mysqli_query($conn, "UPDATE peralatan_masuk SET jumlah_masuk='$jumlah_masuk', keterangan='$keterangan' WHERE id_masuk='$idm'");
            if ($kurangistoknya && $updatenya) {
                header('location: masuk.php');
            } else {
                echo "gagal";
                header('location: masuk.php');
            }
    }

}

// Menghapus peralatan masuk
if (isset($_POST['hapusperalatanmasuk'])) {
    $idp = $_POST['idp'];
    $jumlah_masuk = $_POST['jumlah_masuk'];
    $idm = $_POST['idm'];

    $getdatastok = mysqli_query($conn, "SELECT * FROM stok_peralatan WHERE id_peralatan='$idp'");
    $data = mysqli_fetch_array($getdatastok);
    $stok = $data['stok'];

    $selisih = $stok - $jumlah_masuk;

    $update = mysqli_query($conn, "UPDATE stok_peralatan SET stok='$selisih' WHERE id_peralatan='$idp'");
    $hapusdata = mysqli_query($conn, "DELETE FROM peralatan_masuk WHERE id_masuk='$idm'");

    if ($update && $hapusdata) {
        header('location: masuk.php');
    } else {
        header('location: masuk.php');
    }
}

// Mengubah data peralatan keluar
if (isset($_POST['updateperalatankeluar'])) {
    $idp = $_POST['idp'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $jumlah_keluar = $_POST['jumlah_keluar']; // jumlah baru inputan user 

    // mengambil stok peralatan saat ini
    $lihatstok = mysqli_query($conn, "SELECT * FROM stok_peralatan WHERE id_peralatan='$idp;'");
    $stoknya = mysqli_fetch_array($lihatstok);
    $stoksekarang = $stoknya['stok'];

    // jumlah peralatan keluar saat ini
    $jumlah_keluarskrg = mysqli_query($conn, "SELECT * FROM peralatan_keluar where id_keluar='$idk'");
    $jumlah_keluarnya = mysqli_fetch_array($jumlah_keluarskrg);
    $jumlah_keluarskrg = $jumlah_keluarnya['jumlah_keluar'];

    if ($jumlah_keluar > $jumlah_keluarskrg) {
        $selisih = $jumlah_keluar - $jumlah_keluarskrg;
        $kurangin = $stoksekarang - $selisih;

        if ($selisih <= $stoksekarang) {
            // stok cukup, keluarkan stok -> update table peralatan_keluar, stok_peralatan
            $kurangistoknya = mysqli_query($conn, "UPDATE stok_peralatan SET stok='$kurangin' WHERE id_peralatan='$idp'");
            $updatenya = mysqli_query($conn, "UPDATE peralatan_keluar SET jumlah_keluar='$jumlah_keluar', penerima='$penerima' WHERE id_keluar='$idk'");
            if ($kurangistoknya && $updatenya) {
                header('location: keluar.php');
            } else {
                echo "gagal";
                header('location: keluar.php');
            }
        } else {
            echo '
                <script>
                    alert("Stok tidak mencukupi");
                    window.location.href = "keluar.php";
                </script>
            ';
        }

        
    } else {
            $selisih = $jumlah_keluarskrg - $jumlah_keluar;
            $kurangin = $stoksekarang + $selisih;
            $kurangistoknya = mysqli_query($conn, "UPDATE stok_peralatan SET stok='$kurangin' WHERE id_peralatan='$idp'");
            $updatenya = mysqli_query($conn, "UPDATE peralatan_keluar SET jumlah_keluar='$jumlah_keluar', penerima='$penerima' WHERE id_keluar='$idk'");
            if ($kurangistoknya && $updatenya) {
                header('location: keluar.php');
            } else {
                echo "gagal";
                header('location: keluar.php');
            }
    }

}

// Menghapus peralatan keluar
if (isset($_POST['hapusperalatankeluar'])) {
    $idp = $_POST['idp'];
    $jumlah_keluar = $_POST['jumlah_keluar'];
    $idk = $_POST['idk'];

    $getdatastok = mysqli_query($conn, "SELECT * FROM stok_peralatan WHERE id_peralatan='$idp'");
    $data = mysqli_fetch_array($getdatastok);
    $stok = $data['stok'];

    $selisih = $stok + $jumlah_keluar;

    $update = mysqli_query($conn, "UPDATE stok_peralatan SET stok='$selisih' WHERE id_peralatan='$idp'");
    $hapusdata = mysqli_query($conn, "DELETE FROM peralatan_keluar WHERE id_keluar='$idk'");

    if ($update && $hapusdata) {
        header('location: keluar.php');
    } else {
        header('location: keluar.php');
    }
}

// Menambah user baru
if (isset($_POST['addnewuser'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $queryinsert = mysqli_query($conn, "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')");
    
    if ($queryinsert) {
        // if berhasil
        header('location: user.php');
    } else {
        // if gagal
        header('location: user.php');
    }
}

// Update Data User
if (isset($_POST['updateuser'])) {
    $usernamebaru = $_POST['usernamebaru'];
    $emailbaru = $_POST['emailbaru'];
    $passwordbaru = $_POST['passwordbaru'];
    $idu = $_POST['idu'];

    $queryupdate = mysqli_query($conn, "UPDATE user SET username= '$usernamebaru', email= '$emailbaru', password= '$passwordbaru' WHERE iduser='$idu'");

    if ($queryupdate) {
        // if update berhasil
        header('location: user.php');
    } else {
        // if update gagal
        header('location: user.php' );
    }
}

// Menghapus data user
if (isset($_POST['hapususer'])) {
    $idu = $_POST['idu'];

    $querydelete = mysqli_query($conn, "DELETE FROM user WHERE iduser='$idu'");

    if ($queryudelete) {
        // if update berhasil
        header('location: user.php');
    } else {
        // if update gagal
        header('location: user.php' );
    }
}

// Meminjam peralatan
if (isset($_POST['pinjam'])) {
    $id_peralatan = $_POST['peralatannya']; // mengambil id_peralatan dari form
    $jumlah_peminjaman = $_POST['jumlah_peminjaman']; // mengambil jumlah_peminjaman
    $peminjam = $_POST['peminjam']; // mengambil nama penerima

    // ambil stok sekarang
    $stok_saat_ini = mysqli_query($conn, "SELECT * FROM stok_peralatan WHERE id_peralatan = '$id_peralatan'");
    $stoknya = mysqli_fetch_assoc($stok_saat_ini);
    $stok = $stoknya['stok']; // ini valuenya

    // kurangi stoknya
    $new_stok = $stok - $jumlah_peminjaman;

    // mulai query insert
    $insertpinjam = mysqli_query($conn, "INSERT INTO peminjaman (id_peralatan, jumlah_peminjaman, peminjam) VALUES ('$id_peralatan','$jumlah_peminjaman','$peminjam')");

    // mengurangi stok di table stok peralatan
    $kurangistok = mysqli_query($conn, "UPDATE stok_peralatan SET stok = '$new_stok' WHERE id_peralatan = '$id_peralatan'");
    
    if ($insertpinjam && $kurangistok) {
        // jika berhasil
        echo '
            <script>
                alert("Berhasil");
                window.location.href = "peminjaman.php";
            </script>
        ';
    } else {
        // jika gagal
        echo '
        <script>
            alert("Gagal");
            window.location.href = "peminjaman.php";
        </script>
    ';
    }
}

// menyelesaikan pinjaman
if (isset($_POST['peralatankembali'])) {
    $id_pinjam = $_POST['id_pinjam'];
    $id_peralatan = $_POST['id_peralatan'];

    //ekseskusi
    $update_status = mysqli_query($conn, "UPDATE peminjaman SET status = 'Kembali' WHERE id_peminjaman = '$id_pinjam'");

    // kembalikan stoknya
    // ambil stok sekarang
    $stok_saat_ini = mysqli_query($conn, "SELECT * FROM stok_peralatan WHERE id_peralatan = '$id_peralatan'");
    $stoknya = mysqli_fetch_array($stok_saat_ini);
    $stok = $stoknya['stok']; // ini valuenya

    // ambil jumlah_peminjaman sekarang
    $stok_saat_ini1 = mysqli_query($conn, "SELECT * FROM peminjaman WHERE id_peminjaman = '$id_pinjam'");
    $stoknya1 = mysqli_fetch_array($stok_saat_ini1);
    $stok1 = $stoknya1['jumlah_peminjaman']; // ini valuenya

    // kurangi stoknya
    // $new_stok = $stok1 - $jumlah_peminjaman;
    $new_stok = $stok1 + $stok;

    // kembalikan stoknya
    $kembalikan_stok = mysqli_query($conn, "UPDATE stok_peralatan SET stok='$new_stok' WHERE id_peralatan = '$id_peralatan'");

    if ($update_status && $kembalikan_stok) {
        // jika berhasil
        echo '
            <script>
                alert("Berhasil");
                window.location.href = "peminjaman.php";
            </script>
        ';
    } else {
        // jika gagal
        echo '
        <script>
            alert("Gagal");
            window.location.href = "peminjaman.php";
        </script>
    ';
    }

    // Unit
    // Menambah unit baru
if (isset($_POST['addnewunit'])) {
    $nama_unit = $_POST['nama_unit'];
    $alamat_unit = $_POST['alamat_unit'];
    $penanggung_jawab = $_POST['penanggung_jawab'];

    $queryinsertunit = mysqli_query($conn, "INSERT INTO unit (nama_unit, alamat_unit, penanggung_jawab) VALUES ('$nama_unit', '$alamat_unit', '$penanggung_jawab')");
    
    if ($queryinsertunit) {
        // if berhasil
        header('location: unit.php');
    } else {
        // if gagal
        header('location: unit.php');
    }
}

// Update Data Unit
if (isset($_POST['updateunit'])) {
    $nama_unit = $_POST['nama_unit'];
    $alamat_unit = $_POST['alamat_unit'];
    $penanggung_jawab = $_POST['penanggung_jawab'];
    $idunit = $_POST['idunit'];

    $queryupdateunit = mysqli_query($conn, "UPDATE unit SET nama_unit= '$nama_unitbaru', alamat_unit= '$alamat_unitbaru', penanggung_jawab= '$penanggung_jawabbaru' WHERE id_unit='$idunit'");

    if ($queryupdateunit) {
        // if update berhasil
        header('location: unit.php');
    } else {
        // if update gagal
        header('location: unit.php' );
    }
}

// Menghapus data unit
if (isset($_POST['hapusunit'])) {
    $idunit = $_POST['idunit'];

    $querydeleteunit = mysqli_query($conn, "DELETE FROM unit WHERE id_unit='$idunit'");

    if ($queryudeleteunit) {
        // if update berhasil
        header('location: unit.php');
    } else {
        // if update gagal
        header('location: unit.php' );
    }
}
}
?>