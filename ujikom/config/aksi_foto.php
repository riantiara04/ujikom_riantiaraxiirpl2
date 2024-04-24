<?php
session_start();
include 'koneksi.php';

if (isset($_POST['tambah'])) {
    $judul_foto = $_POST['judul_foto'];
    $deskripsi_foto = $_POST['deskripsi_foto'];
    $tanggal_unggah = date('Y-m-d');
    $user_id = $_SESSION['user_id'];
    $foto = $_FILES['lokasi_file']['name'];
    $tmp = $_FILES['lokasi_file']['tmp_name'];
    $lokasi = '../asset/img/';
    $namafoto = rand().'-'.$foto;

    move_uploaded_file($tmp, $lokasi.$namafoto);

    $sql = mysqli_query($koneksi, "INSERT INTO foto VALUES('','$judul_foto','$deskripsi_foto','$tanggal_unggah', '$namafoto', '$user_id')");

    echo "<script>
    alert('Data berhasil disimpan!');
    location.href='../admin/foto.php';
    </script>";
}

if (isset($_POST['edit'])) {
    $foto_id = $_POST['foto_id'];
    $judul_foto = $_POST['judul_foto'];
    $deskripsi_foto = $_POST['deskripsi_foto'];
    $tanggal_unggah = date('Y-m-d');
    $user_id = $_SESSION['user_id'];
    $foto = $_FILES['lokasi_file']['name'];
    $tmp = $_FILES['lokasi_file']['tmp_name'];
    $lokasi = '../asset/img/';
    $namafoto = rand().'-'.$foto;

    if ($foto == null) {
        $sql = mysqli_query($koneksi, "UPDATE foto SET judul_foto='$judul_foto', deskripsi_foto='$deskripsi_foto', tanggal_unggah='$tanggal_unggah' WHERE foto_id='$foto_id'"); 
    } else {
        $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE foto_id='$foto_id'");
        $data = mysqli_fetch_array($query);
        if (is_file('../asset/img/'.$data['lokasi_file'])) {
            unlink('../asset/img/'.$data['lokasi_file']);
        }
        move_uploaded_file($tmp, $lokasi.$namafoto);
        $sql = mysqli_query($koneksi, "UPDATE foto SET judul_foto='$judul_foto', deskripsi_foto='$deskripsi_foto', tanggal_unggah='$tanggal_unggah', lokasi_file='$namafoto', WHERE foto_id='$foto_id'"); 
    }
    echo "<script>
    alert('Data berhasil diperbarui!');
    location.href='../admin/foto.php';
    </script>";
}

if (isset($_POST['hapus'])) {
    $foto_id = $_POST['foto_id'];
    $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE foto_id='$foto_id'");
        $data = mysqli_fetch_array($query);
        if (is_file('../asset/img/'.$data['lokasi_file'])) {
            unlink('../asset/img/'.$data['lokasi_file']);
        }

        $sql = mysqli_query($koneksi, "DELETE FROM foto WHERE foto_id='$foto_id'");
        echo "<script>
        alert('Data berhasil diperbarui!');
        location.href='../admin/foto.php';
        </script>";
}