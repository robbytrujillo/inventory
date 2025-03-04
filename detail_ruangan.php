<?php
include "koneksi.php";

if (!isset($_GET['id'])) {
    echo "Ruangan tidak ditemukan!";
    exit;
}

$id_ruangan = $_GET['id'];
$sql = "SELECT r.nama_ruangan, r.koordinator, u.nama_unit, s.nama_peralatan, rp.jumlah
        FROM ruangan r
        JOIN unit u ON r.id_unit = u.id_unit
        JOIN ruangan_peralatan rp ON r.id_ruangan = rp.id_ruangan
        JOIN stok_peralatan s ON rp.id_peralatan = s.id_peralatan
        WHERE r.id_ruangan = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_ruangan);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Ruangan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Detail Ruangan</h2>

    <?php if ($result->num_rows > 0): 
        $row = $result->fetch_assoc();
    ?>
        <p><strong>Nama Unit:</strong> <?= htmlspecialchars($row['nama_unit']) ?></p>
        <p><strong>Nama Ruangan:</strong> <?= htmlspecialchars($row['nama_ruangan']) ?></p>
        <p><strong>Koordinator:</strong> <?= htmlspecialchars($row['koordinator']) ?></p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Peralatan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php
                do {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['nama_peralatan']) . "</td>
                            <td>" . htmlspecialchars($row['jumlah']) . "</td>
                          </tr>";
                } while ($row = $result->fetch_assoc());
                ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">Tidak ada peralatan di ruangan ini.</div>
    <?php endif; ?>
</div>

</body>
</html>
