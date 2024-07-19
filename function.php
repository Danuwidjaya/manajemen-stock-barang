<?php
session_start();
// Membuat koneksi db
$conn = mysqli_connect("localhost", "root", "", "stockbarang");

// menambah barang baru
if (isset($_POST['addnewbarang'])) {
    $nama_barang = $_POST['nama_barang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    // Corrected SQL query
    $addtotable = mysqli_query($conn, "INSERT INTO stock (nama_barang, deskripsi, stock) VALUES ('$nama_barang', '$deskripsi', '$stock')");

    if ($addtotable) {
        header('Location: index.php');
        exit(); // Make sure to exit after redirecting
    } else {
        echo 'Gagal';
        header('Location: index.php');
        exit(); // Make sure to exit after redirecting
    }   
}


// menambah barang masuk
if (isset($_POST['barangmasuk'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];
    
    $cekstoksekarang = mysqli_query($conn, "select * from stock where id_barang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstoksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganqty = $stocksekarang+$qty;

    $addtomasuk = mysqli_query($conn, "insert into masuk (id_barang, keterangan, qty) values ('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn, "update stock set stock ='$tambahkanstocksekarangdenganqty' where id_barang='$barangnya' ");
    if ($addtomasuk&&$updatestockmasuk) {
        header('Location: masuk.php');
        exit(); // Make sure to exit after redirecting
    } else {
        echo 'Gagal';
        header('Location: masuk.php');
        exit(); // Make sure to exit after redirecting
    }  
}

if (isset($_POST['addbarangkeluar'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];
    
    $cekstoksekarang = mysqli_query($conn, "select * from stock where id_barang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstoksekarang);

    //kalau stock barang cukup
    $stocksekarang = $ambildatanya['stock'];
    if ($stocksekarang >= $qty) {
        $tambahkanstocksekarangdenganqty = $stocksekarang - $qty;

        $addtokeluar = mysqli_query($conn, "insert into keluar (id_barang, penerima, qty) values ('$barangnya','$penerima','$qty')");
        $updatestockmasuk = mysqli_query($conn, "update stock set stock ='$tambahkanstocksekarangdenganqty' where id_barang='$barangnya' ");
        if ($addtokeluar && $updatestockmasuk) {
            header('Location: keluar.php');
            exit(); // Make sure to exit after redirecting
        } else {
            echo 'Gagal';
            header('Location: keluar.php');
            exit(); // Make sure to exit after redirecting
        } 
    } else {
        //kalau stock barang gak cukup
        echo '
        <script>
            alert("Stock saat ini tidak mencukupi");
            window.location.href="keluar.php";
        </script>
        ';
    } 
}


// Update info barang
if (isset($_POST['updatebarang'])) {
    $id_barang = $_POST['idb'];
    $nama_barang = $_POST['nama_barang'];
    $deskripsi = $_POST['deskripsi'];

    $update = mysqli_query($conn, "UPDATE stock SET nama_barang='$nama_barang', deskripsi='$deskripsi' WHERE id_barang='$id_barang'");
    if ($update) {
        header('Location: index.php');
        exit(); // Make sure to exit after redirecting
    } else {
        echo 'Gagal';
        header('Location: index.php');
        exit(); // Make sure to exit after redirecting
    }
}

// Delete barang
if (isset($_POST['hapusbarang'])) {
    $id_barang = $_POST['idb'];

    $delete = mysqli_query($conn, "DELETE FROM stock WHERE id_barang='$id_barang'");
    if ($delete) {
        header('Location: index.php');
        exit(); // Make sure to exit after redirecting
    } else {
        echo 'Gagal menghapus barang';
        header('Location: index.php');
        exit(); // Make sure to exit after redirecting
    }
}

// Edit data barang masuk
if (isset($_POST['updatebarangmasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE id_barang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stocksekarang = $stocknya['stock'];

    $qtysekarang = mysqli_query($conn, "SELECT * FROM masuk WHERE id_masuk='$idm'");
    $qtynya = mysqli_fetch_array($qtysekarang);
    $qtysekarang = $qtynya['qty'];

    if ($qty > $qtysekarang) {
        $selisih = $qty - $qtysekarang;
        $kurangin = $stocksekarang + $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE id_barang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE masuk SET qty='$qty', keterangan='$deskripsi' WHERE id_masuk='$idm'");

        if ($kurangistocknya && $updatenya) {
            header('Location: masuk.php');
            exit(); // Make sure to exit after redirecting
        } else {
            echo 'Gagal menghapus barang';
            header('Location: masuk.php');
            exit(); // Make sure to exit after redirecting
        }
    } else {
        $selisih = $qtysekarang - $qty;
        $kurangin = $stocksekarang - $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE id_barang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE masuk SET qty='$qty', keterangan='$deskripsi' WHERE id_masuk='$idm'");

        if ($kurangistocknya && $updatenya) {
            header('Location: masuk.php');
            exit(); // Make sure to exit after redirecting
        } else {
            echo 'Gagal menghapus barang';
            header('Location: masuk.php');
            exit(); // Make sure to exit after redirecting
        }
    }
}


// menghapus barang masuk

if (isset($_POST['hapusbarangmasuk'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn, "select * from stock where id_barang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok-$qty;

    $update = mysqli_query($conn, "update stock set stock='$selisih' where id_barang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from masuk where id_masuk='$idm'");

    if ($update&&$hapusdata) {
        header('location:masuk.php');
    }else {
        header('location:masuk.php');
    }

}


// 
// Edit data barang keluar
if (isset($_POST['updatebarangkeluar'])) {
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE id_barang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stocksekarang = $stocknya['stock'];

    $qtysekarang = mysqli_query($conn, "SELECT * FROM keluar WHERE id_keluar='$idk'");
    $qtynya = mysqli_fetch_array($qtysekarang);
    $qtysekarang = $qtynya['qty'];

    if ($qty > $qtysekarang) {
        $selisih = $qty - $qtysekarang;
        $kurangin = $stocksekarang - $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE id_barang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE keluar SET qty='$qty', penerima='$penerima' WHERE id_keluar='$idk'");

        if ($kurangistocknya && $updatenya) {
            header('Location: keluar.php');
            exit(); // Make sure to exit after redirecting
        } else {
            echo 'Gagal menghapus barang';
            header('Location: keluar.php');
            exit(); // Make sure to exit after redirecting
        }
    } else {
        $selisih = $qtysekarang - $qty;
        $kurangin = $stocksekarang + $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE id_barang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE keluar SET qty='$qty', penerima='$penerima' WHERE id_keluar='$idk'");

        if ($kurangistocknya && $updatenya) {
            header('Location: keluar.php');
            exit(); // Make sure to exit after redirecting
        } else {
            echo 'Gagal menghapus barang';
            header('Location: keluar.php');
            exit(); // Make sure to exit after redirecting
        }
    }
}


// menghapus barang keluar

if (isset($_POST['hapusbarangkeluar'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn, "select * from stock where id_barang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok+$qty;

    $update = mysqli_query($conn, "update stock set stock='$selisih' where id_barang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from keluar where id_keluar='$idk'");

    if ($update&&$hapusdata) {
        header('location:keluar.php');
    }else {
        header('location:keluar.php');
    }

}




?>
