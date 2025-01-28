<?php 
    require 'function.php';
    require 'cek.php';
?>

<html>
<head>
  <title>Export Stok Peralatan</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
<div class="container">
            <img src="./assets/img/inventory-logo.png" style="width: 120px; margin-left: 0%; margin-top: 0%; margin-right: 5%" href="index.php">
			<h4>Stock Peralatan</h4>
            <br>
            <a href="index.php" class="btn btn-success">Kembali</a>
            <br>
            <br>
				<div class="data-tables datatable-dark">
					
					<!-- Masukkan table nya disini, dimulai dari tag TABLE -->
                    <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">                                       
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Peralatan</th>
                                <th>Deskripsi</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $ambilsemuadatastok = mysqli_query($conn, "SELECT * FROM stok_peralatan");
                            $i = 1;

                            while($data=mysqli_fetch_array($ambilsemuadatastok)) {                                          
                                $nama_peralatan = $data['nama_peralatan'];
                                $deskripsi = $data['deskripsi'];
                                $stok = $data['stok'];
                                $idp = $data['id_peralatan'];
                            ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?php echo $nama_peralatan; ?></td>
                                <td><?php echo $deskripsi; ?></td>
                                <td><?php echo $stok; ?></td>
                            </tr>   
                            <?php 
                            };
                            ?>
                        </tbody>
                    </table>
					
				</div>
</div>
	
<script>
$(document).ready(function() {
    $('#mauexport').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy','csv','excel', 'pdf', 'print'
        ]
    } );
} );

</script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

	

</body>

</html>