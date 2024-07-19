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
  <title>Laporan Barang Masuk</title>
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
    <h2 class="mt-4">Laporan Barang Masuk</h2>
    <div class="data-tables datatable-dark mt-4">
        <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Penerima</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM keluar k, stock s WHERE s.id_barang = k.id_barang");
                    while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                        $tanggal = $data['tanggal'];
                        $namabarang = $data['nama_barang'];
                        $qty = $data['qty'];
                        $penerima = $data['penerima'];
                ?>
                <tr>
                    <td><?= $tanggal; ?></td>
                    <td><?= $namabarang; ?></td>
                    <td><?= $qty; ?></td>
                    <td><?= $penerima; ?></td>
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
                title: 'Laporan Barang Masuk'
            },
            {
                extend: 'csv',
                title: 'Laporan Barang Masuk'
            },
            {
                extend: 'excel',
                title: 'Laporan Barang Masuk'
            },
            {
                extend: 'pdf',
                title: 'Laporan Barang Masuk',
                orientation: 'landscape',
                pageSize: 'A4',
                customize: function(doc) {
                    doc.content[1].table.widths = ['25%', '35%', '15%', '25%'];
                    doc.styles.tableHeader.fontSize = 12;
                    doc.defaultStyle.fontSize = 10;
                    doc.pageMargins = [20, 20, 20, 20];
                }
            },
            {
                extend: 'print',
                title: 'Laporan Barang Masuk'
            }
        ],
        columnDefs: [
            { width: '25%', targets: 0 },
            { width: '35%', targets: 1 },
            { width: '15%', targets: 2 },
            { width: '25%', targets: 3 }
        ],
        fixedColumns: true
    });
});
</script>

</body>
</html>
