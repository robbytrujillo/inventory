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
    $kurangkanstoksekarangdenganjumlah = $stoksekarang - $jumlah_keluar;


    $addtokeluar = mysqli_query($conn, "INSERT INTO peralatan_keluar (id_peralatan, penerima, jumlah_keluar) VALUES ('$peralatannya', '$penerima', '$jumlah_keluar')");
    $updatestokkeluar = mysqli_query($conn, "UPDATE stok_peralatan SET stok='$kurangkanstoksekarangdenganjumlah' WHERE id_peralatan='$peralatannya'");
    
    if ($addtokeluar && $updatestokkeluar) {
        header('location: keluar.php');
    } else {
        echo "gagal";
        header('location: keluar.php');
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
    // $nama_peralatan = $_POST['nama_peralatan'];
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
        $kuriangin = $stoksekarang - $selisih;
        $kurangistoknya = mysqli_query($conn, "UPDATE stok_peralatan SET stok='$kuriangin' WHERE id_peralatan='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE peralatan_masuk SET jumlah_masuk='$jumlah_masuk', keterangan='$keterangan' WHERE idm='$idm'");
        if ($kurangistoknya && $updatenya) {
            header('location: masuk.php');
        } else {
            echo "gagal";
            header('location: masuk.php');
        }
    } else {
        if ($jumlah_masuk < $jumlah_masukskrg) {
            $selisih = $jumlah_masukskrg - $jumlah_masuk;
            $kuriangin = $stoksekarang + $selisih;
            $kurangistoknya = mysqli_query($conn, "UPDATE stok_peralatan SET stok='$kuriangin' WHERE id_peralatan='$idb'");
            $updatenya = mysqli_query($conn, "UPDATE peralatan_masuk SET jumlah_masuk='$jumlah_masuk', keterangan='$keterangan' WHERE idm='$idm'");
            if ($kurangistoknya && $updatenya) {
                header('location: masuk.php');
            } else {
                echo "gagal";
                header('location: masuk.php');
            }
    }

    // if ($)
}


?>