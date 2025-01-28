<?php 
session_start();

// connect database
$conn = mysqli_connect("localhost", "root", "","inventory");

// menambah peralatan baru
if (isset($_POST['addnewperalatan'])) {
    $nama_peralatan  = $_POST['nama_peralatan'];
    $deskripsi      = $_POST['deskripsi'];
    $stok           = $_POST['stok'];

    $addtotable = mysqli_query($conn, "INSERT INTO stok_peralatan (nama_peralatan, deskripsi, stok) VALUES ('$nama_peralatan', '$deskripsi', '$stok')");
    if ($addtotable) {
        header('location: index.php');
    } else {
        echo "gagal";
        header('location: index.php');
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

    $update = mysqli_query($conn, "UPDATE stok_peralatan SET nama_peralatan='$nama_peralatan', deskripsi='$deskripsi' WHERE id_peralatan='$idp'");
    if ($update) {
        header('location: index.php');
    } else {
        echo "gagal";
        header('location: index.php');
    }
}

// hapus stok peralatan
if (isset($_POST['hapusperalatan'])) {
    $idp = $_POST['idp'];

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
    $jumlah_keluar = $_POST['jumlah_keluar'];

    $lihatstok = mysqli_query($conn, "SELECT * FROM stok_peralatan WHERE id_peralatan='$idp;'");
    $stoknya = mysqli_fetch_array($lihatstok);
    $stoksekarang = $stoknya['stok'];

    $jumlah_keluarskrg = mysqli_query($conn, "SELECT * FROM peralatan_keluar where id_keluar='$idk'");
    $jumlah_keluarnya = mysqli_fetch_array($jumlah_keluarskrg);
    $jumlah_keluarskrg = $jumlah_keluarnya['jumlah_keluar'];

    if ($jumlah_keluar > $jumlah_keluarskrg) {
        $selisih = $jumlah_keluar - $jumlah_keluarskrg;
        $kurangin = $stoksekarang - $selisih;
        $kurangistoknya = mysqli_query($conn, "UPDATE stok_peralatan SET stok='$kurangin' WHERE id_peralatan='$idp'");
        $updatenya = mysqli_query($conn, "UPDATE peralatan_keluar SET jumlah_keluar='$jumlah_keluar', penerima='$penerima' WHERE id_keluar='$idk'");
        if ($kurangistoknya && $updatenya) {
            header('location: keluar.php');
        } else {
            echo "gagal";
            header('location: keluar.php');
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



?>