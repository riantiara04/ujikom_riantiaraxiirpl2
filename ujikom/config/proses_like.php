<?php
session_start();
include 'koneksi.php';
$foto_id = $_GET['foto_id'];
$user_id = $_SESSION['user_id'];

$ceksuka = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$foto_id' AND user_id='$user_id'");

if (mysqli_num_rows($ceksuka) == 1){
    while($row = mysqli_fetch_array($ceksuka)){
        $like_id = $row['like_id'];
        $query = mysqli_query($koneksi, "DELETE FROM like_foto WHERE like_id='$like_id'");
        echo "<script>
        location.href='../admin/index.php';
        </script>";
    }
} else {
$tanggal_like = date('Y-m-d');
$query = mysqli_query($koneksi,"INSERT INTO like_foto VALUES('','$foto_id','$user_id','$tanggal_like')");

echo "<script>
location.href='../admin/index.php';
</script>";
}
?>