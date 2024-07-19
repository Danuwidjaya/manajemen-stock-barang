<?php
//import koneksi ke database
require 'function.php';
require 'cek.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Stock Barang</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <style>
    table.dataTable {
      width: 100% !important;
    }
    table.dataTable thead th, table.dataTable tbody td {
      white-space: nowrap;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
</head>
<body>
<div class="container">
    <h2 class="mt-4">Laporan Stock Barang</h2>
    <div class="data-tables datatable-dark mt-4">
        <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Deskripsi</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM stock");
                    $i = 1;
                    while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                        $namabarang = $data['nama_barang'];
                        $deskripsi = $data['deskripsi'];
                        $stock = $data['stock'];
                ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $namabarang; ?></td>
                    <td><?= $deskripsi; ?></td>
                    <td><?= $stock; ?></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#mauexport').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                title: 'Laporan Stock Barang'
            },
            {
                extend: 'csv',
                title: 'Laporan Stock Barang'
            },
            {
                extend: 'excel',
                title: 'Laporan Stock Barang'
            },
            {
                extend: 'pdf',
                title: 'Laporan Stock Barang',
                orientation: 'landscape',
                pageSize: 'A4',
                customize: function(doc) {
                    doc.content[1].table.widths = ['5%', '30%', '50%', '15%'];
                    doc.styles.tableHeader.fontSize = 12;
                    doc.defaultStyle.fontSize = 10;
                    doc.pageMargins = [20, 20, 20, 20];
                }
            },
            {
                extend: 'print',
                title: 'Laporan Stock Barang'
            }
        ],
        columnDefs: [
            { width: '5%', targets: 0 },
            { width: '30%', targets: 1 },
            { width: '50%', targets: 2 },
            { width: '15%', targets: 3 }
        ],
        fixedColumns: true
    });
});
</script>

</body>
</html>
