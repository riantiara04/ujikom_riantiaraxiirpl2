<?php
session_start();
$user_id = $_SESSION['user_id'];
include '../config/koneksi.php';
if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum Login!');
    location.href='../index.php';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="../asset/css/bootstrap.min.css">
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
              <a href="home.php" class="nav-link">Beranda</a>
              <a href="foto.php" class="nav-link">Foto</a>
            </div>
            <a href="../config/aksi_logout.php" class="btn btn-outline-light m-1">Keluar</a>
          </div>
        </div>
      </nav>

      
      <div class="container">
        <div class="row">
          <div class="col-xs-8">
            <div class="card mt-2">
              <div class="card-header text-light" style="background-color:#95745d">Tambah Foto</div>
              <div class="card-body text-light" style="background-color:#95745d">
                <form action="../config/aksi_foto.php" method="POST" enctype="multipart/form-data">
                  <label class="form-label">Judul Foto</label>
                  <input type="text" name="judul_foto" class="form-control" required>
                  <label class="form-label">Deskripsi</label>
                  <textarea class="form-control" name="deskripsi_foto" required></textarea>
                  <label class="form-label">File</label>
                  <input type="file" class="form-control" name="lokasi_file" required>
                  <button type="submit" class="btn mt-2 text-light" style="background-color: #58403b" name="tambah">Tambah Foto</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-xs-8">
            <div class="card mt-2">
                <div class="card-header text-light" style="background-color:#95745d">Data Galeri Foto</div>
                <div class="card-body">
                    <table class="table">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Judul Foto</th>
                                <th>Deskripsi</th>
                                <th>Tanggal</th>
                                <th width="150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            $user_id = $_SESSION['user_id'];
                            $sql = mysqli_query($koneksi, "SELECT * FROM foto WHERE user_id = '$user_id'");
                            while($data = mysqli_fetch_array($sql)){
                            ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><img src="../asset/img/<?php echo $data['lokasi_file'] ?>" width="100"></td>
                                <td><?php echo $data['judul_foto'] ?></td>
                                <td><?php echo $data['deskripsi_foto'] ?></td>
                                <td><?php echo $data['tanggal_unggah'] ?></td>
                                <td>
                                  <button type="button" class="btn text-light" style="background-color: #58403b" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['foto_id'] ?>">
                                    Edit
                                  </button>

                                  <div class="modal fade" id="edit<?php echo $data['foto_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                          <form action="../config/aksi_foto.php" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="foto_id" value="<?php echo $data['foto_id'] ?>">
                                            <label class="form-label">Judul Foto</label>
                                            <input type="text" name="judul_foto" value="<?php echo $data['judul_foto'] ?>" class="form-control" required>
                                            <label class="form-label">Deskripsi</label>
                                            <textarea class="form-control" name="deskripsi_foto" required><?php echo $data['deskripsi_foto'] ?></textarea>
                                            </select>
                                            <label class="form-label">Foto</label>
                                            <div class="row">
                                              <div class="col-md-4">
                                                <img src="../asset/img/<?php echo $data['lokasi_file'] ?>" width="100">
                                              </div>
                                              <div class="col-md-8">
                                                <label class="form-label">Ganti File</label>
                                                <input type="file" class="form-control" name="lokasi_file">
                                              </div>
                                            </div>
                                            
                                        </div>
                                        <div class="modal-footer">
                                          <button type="submit" name="edit" class="btn text-light" style="background-color: #58403b">Edit Data</button>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <button type="button" class="btn text-light" style="background-color: #A4856B" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['foto_id'] ?>">
                                    Hapus
                                  </button>

                                  <div class="modal fade" id="hapus<?php echo $data['foto_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                          <form action="../config/aksi_foto.php" method="POST">
                                            <input type="hidden" name="foto_id" value="<?php echo $data['foto_id'] ?>">
                                            Apakah anda yakin akan menghapus data <strong>  <?php echo $data['judul_foto'] ?> </strong> ?

                                        </div>
                                        <div class="modal-footer">
                                          <button type="submit" name="hapus" class="btn text-light" style="background-color: #58403b">Hapus Data</button>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                </td>
                            </tr>
                               <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
      </div>
<script type="text/javascript" src="../asset/js/bootstrap.min.js"></script>
</body>
</html>