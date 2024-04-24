<?php
session_start();
include 'config/koneksi.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kirimkomentar'])) {
    $foto_id = $_POST['foto_id'];
    $isi_komentar = $_POST['isi_komentar'];
    $tanggal_komentar = date('Y-m-d');

    // Simpan komentar ke dalam database
    $query = "INSERT INTO komentar_foto (foto_id, user_id, isi_komentar, tanggal_komentar) VALUES ('$foto_id', NULL, '$isi_komentar', '$tanggal_komentar')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Redirect ke halaman yang sesuai
        header("Location: index.php");
        exit(); // Penting untuk menghentikan eksekusi skrip setelah melakukan redirect
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}

// Handle like submission
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['foto_id'])) {
    $foto_id = $_GET['foto_id'];

    // Cek apakah pengguna telah menyukai foto tersebut sebelumnya berdasarkan cookie
    if(isset($COOKIE['liked'.$foto_id])) {
        // Jika pengguna telah menyukai foto tersebut sebelumnya, hapus like dari database
        $query = "DELETE FROM like_foto WHERE foto_id='$foto_id' AND user_id IS NULL";
        setcookie('liked_'.$foto_id, '', time() - 5, '/'); // Hapus cookie
    } else {
        // Cek apakah pengguna telah menyukai foto tersebut sebelumnya berdasarkan data yang tersimpan di database
        $cek_like = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$foto_id' AND user_id IS NULL");
        if (mysqli_num_rows($cek_like) > 0) {
            // Jika pengguna telah menyukai foto tersebut sebelumnya, hapus like dari database
            $query = "DELETE FROM like_foto WHERE foto_id='$foto_id' AND user_id IS NULL";
        } else {
            // Jika pengguna belum menyukai foto tersebut, simpan like ke dalam database
            $query = "INSERT INTO like_foto (foto_id, user_id, tanggal_like) VALUES ('$foto_id', NULL, NOW())";
        }
        // Set cookie untuk menandai bahwa pengguna telah menyukai foto tersebut
        setcookie('liked_'.$foto_id, '1', time() + 5, '/'); // Set cookie untuk 1 jam
    }

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Redirect ke halaman yang sesuai
        header("Location: index.php");
        exit(); // Penting untuk menghentikan eksekusi skrip setelah melakukan redirect
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #95745d">
        <div class="container">
          <a class="navbar-brand text-light" href="index.php">Galeri Foto</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
            <div class="navbar-nav me-auto">
            </div>
            <a href="register.php" class="btn btn-outline-light m-1">Daftar</a>
            <a href="login.php" class="btn btn-outline-light m-1">Masuk</a>
            </div>
          </div>
        </div>
      </nav>

      <div class="container mt-3">
    <div class="row">
            <?php
            $query = mysqli_query($koneksi, "SELECT * FROM foto INNER JOIN user ON foto.user_id=user.user_id");
            while($data= mysqli_fetch_array($query)){
            ?>
             <div class="col-md-3 mt-2">
            <a type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['foto_id'] ?>">

                <div class="card">
                <img style="height: 12rem;" src="asset/img/<?php echo $data['lokasi_file'] ?>" class="card-img-top" title="<?php echo $data['judul_foto'] ?>">
                <div class="card-footer text-center"> 
                    <?php 
                    $foto_id = $data['foto_id'];
                    $ceksuka = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$foto_id'");
                    ?>
                    <?php
                        // Cek apakah pengguna telah menyukai foto tersebut sebelumnya
                        $cek_like = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$foto_id' AND user_id IS NULL");
                        if (mysqli_num_rows($cek_like) > 0) {
                            // Jika pengguna telah menyukai foto tersebut sebelumnya, tampilkan ikon hati solid
                            $heart_icon = '<i class="fa-solid fa-heart"></i>';
                        } else {
                            // Jika pengguna belum menyukai foto tersebut, tampilkan ikon hati regular
                            $heart_icon = '<i class="fa-regular fa-heart"></i>';
                        }
                        ?>

                        <a href="index.php?foto_id=<?php echo $data['foto_id'] ?>"><?php echo $heart_icon ?></a>
                    <?php 
                    $like = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$foto_id'");
                    echo mysqli_num_rows($like). ' Suka';
                    ?>
                    <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['foto_id'] ?>" style="margin-left: 5px;"><i class="fa-regular fa-comment"></i></a>
                    <?php
                    $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentar_foto WHERE foto_id='$foto_id'");
                    echo mysqli_num_rows($jmlkomen). ' Komentar';
                    ?>
                </div>
            </div>
            </div>
                </a>


            <!-- Modal -->
            <div class="modal fade" id="komentar<?php echo $data['foto_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-4">
                      <img src="asset/img/<?php echo $data['lokasi_file'] ?>" class="card-img-top" title="<?php echo $data['judul_foto'] ?>">
                      </div>
                      <div class="col-md-4">
                        <div class="m-2">
                          <div class="overflow-auto">
                            <div class="sticky-top">
                              <strong><?php echo $data['judul_foto'] ?></strong><br>
                              <span class="badge bg-secondary"><?php echo $data['nama_lengkap'] ?></span>
                              <span class="badge bg-secondary"><?php echo $data['tanggal_unggah'] ?></span>
                            </div>
                            <hr>
                            <p align="left">
                              <?php echo $data['deskripsi_foto']?>
                            </p>
                            <hr>
                            <div class="overflow-auto" style="max-height: 150px;">
                                                <?php 
                                                    $foto_id = $data['foto_id'];
                                                    $komentar = mysqli_query($koneksi, "SELECT * FROM komentar_foto LEFT JOIN user ON komentar_foto.user_id=user.user_id WHERE komentar_foto.foto_id='$foto_id'");
                                                    while($row = mysqli_fetch_array($komentar)) {
                                                        $nama_lengkap = $row['nama_lengkap'] ? $row['nama_lengkap'] : "Anonim";
                                                ?>
                                                    <p align="left">
                                                        <strong><?php echo $nama_lengkap ?></strong>
                                                        <?php echo $row['isi_komentar']; ?>
                                                    </p>
                                                <?php } ?>
                                                </div>

                                                <hr>
                                                <div class="sticky-bottom mb-2">
                                                    <form action="" method="POST">
                                                        <input type="hidden" name="foto_id" value="<?php echo $data['foto_id'] ?>">
                                                        <div class="input-group">
                                                            <input type="text" name="isi_komentar" class="form-control" placeholder="Tambah Komentar" required>
                                                            <div class="input-group-prepend">
                                                                <button type="submit" name="kirimkomentar" class="btn btn-outline-primary">Kirim</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           <?php } ?>

           <!-- Footer -->
          <footer class="d-flex justify-content-center boredr-top mt-3 fixed-bottom text-light" style="background-color: #95745d">
              <p>&copy; UJIKOM XII RPL-2 | RIANTIARA</p>
          </footer>

          </div>
        </div>
      </div>

    
<script type="text/javascript" src="asset/js/bootstrap.min.js"></script>
</body>
</html>
