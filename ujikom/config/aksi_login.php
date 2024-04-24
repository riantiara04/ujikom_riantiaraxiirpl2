<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

$sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");

$cek = mysqli_num_rows($sql);

if ($cek > 0) {
    $data = mysqli_fetch_array($sql);
    $_SESSION['username'] = $data['username'];
    $_SESSION['user_id'] = $data['user_id'];
    $_SESSION['status'] = 'login';
    echo "<script>
    alert('Login berhasil');
    location.href='../admin/index.php';
    </script>";
} else {
    echo "<script>
    alert('Usename atau Password salah!');
    location.href='../login.php';
    </script>";
}

?>