<?php
require 'function.php';
require 'cek.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Barang Masuk</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <img src="logo1.jpg" alt="Logo" style="max-height: 30px; margin-left: 10px; margin-right: 1px;">
    <a class="navbar-brand" href="dashboard.php">CV Asal Setia</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search (if needed) -->
            <!-- 
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form> 
            -->
            <!-- Navbar Items (right-aligned) -->
            <div class="navbar-nav ml-auto">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <!-- <a class="dropdown-item" href="#">Settings</a>
                            <a class="dropdown-item" href="#">Activity Log</a> -->
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                        <a class="nav-link" href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Stock Barang
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-arrow-down"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-arrow-up"></i></div>
                            Barang Keluar
                        </a>

                            
                    </div>
                    
                </nav>
            </div>
            <div id="layoutSidenav_content">
            <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Barang Masuk</h1>
                        
                        <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Tambah Data
                            </button>
                            <a href="exportmasuk.php" class="btn btn-info">Export Data</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                            $ambilsemuadatastock = mysqli_query($conn,"select * from masuk m, stock s where s.id_barang = m.id_barang ");
                                            while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                            $idb = $data['id_barang'];
                                            $idm = $data['id_masuk'];
                                            $tanggal = $data['tanggal'];
                                            $namabarang = $data['nama_barang'];
                                            $qty = $data['qty'];
                                            $keterangan = $data['keterangan'];

                                            
                                        ?>

                                        <tr>
                                            <td><?=$tanggal;?></td>
                                            <td><?=$namabarang?></td>
                                            <td><?=$qty;?></td>
                                            <td><?=$keterangan;?></td>
                                            <td>
                                               <!-- Edit and Delete Buttons -->
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idm;?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idm;?>">
                                                Hapus
                                            </button>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit<?=$idm;?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Barang</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Form di dalam Modal -->
                                                            <form method="post" action="index.php">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="idb" value="<?=$idb;?>">
                                                                    
                                                                    <div class="form-group">
                                                                        <label for="deskripsi_edit">Keterangan</label>
                                                                        <input type="text" id="deskripsi_edit" value="<?=$keterangan;?>" name="keterangan" class="form-control" placeholder="pupuk alami merupakan..." required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="deskripsi_edit">Quantity</label>
                                                                        <input type="number" id="deskripsi_edit" value="<?=$qty;?>" name="qty" class="form-control" placeholder="pupuk alami merupakan..." required>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- Modal Footer -->
                                                                <div class="modal-footer">
                                                                    <input type="hidden" name="idb" value="<?=$idb;?>">
                                                                    <input type="hidden" name="idm" value="<?=$idm;?>">
                                                                    <button type="submit" class="btn btn-primary" name="updatebarangmasuk">Edit</button>
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="delete<?=$idm;?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Hapus Barang</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Form di dalam Modal -->
                                                            <form method="post" action="index.php">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="idb" value="<?=$idb;?>">
                                                                    Apakah anda yakin ingin menghapus <?=$namabarang;?>?
                                                                    <input type="hidden" name="kty" value="<?=$qty;?>">
                                                                    <input type="hidden" name="idm" value="<?=$idm;?>">
                                                                </div>
                                                                
                                                                <!-- Modal Footer -->
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-danger" name="hapusbarangmasuk">Hapus</button>
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>



                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Hani 2024</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Barang Masuk</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Form di dalam Modal -->
            <form method="post" action="index.php">
                <div class="modal-body">
                    <select name="barangnya" id="" class="form-control">
                    <?php
                        $ambilsemuadata = mysqli_query($conn,"select * from stock");
                        while($fetcharray = mysqli_fetch_array($ambilsemuadata)){
                            $namabarangnya = $fetcharray['nama_barang'];
                            $idbarangnya = $fetcharray['id_barang'];
                            
                    ?>

                    <option value="<?=$idbarangnya;?>"><?=$namabarangnya;?></option>

                    <?php
                    }
                    ?>
                    </select>
                    <div class="form-group">
                        <label for="qty">Quantity</label>
                        <input type="number" id="qty" name="qty" class="form-control" placeholder="Quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="penerima">Nama Penerima</label>
                        <input type="text" id="penerima" name="penerima" class="form-control" placeholder="pupuk alami" required>
                    </div>
                    
                   
                </div>
                
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="barangmasuk">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

</html>
