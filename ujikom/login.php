<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
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
      </nav>

      <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-light" style="background-color: #95745d">
                        <div class="text-center">
                            <h5>Login</h5>
                        </div>
                        <form action="config/aksi_login.php" method="POST">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            <div class="d-grid mt-2">
                                <button class="btn text-light" style="background-color: #58403b" type="submit" name="kirim">MASUK</button>
                            </div>
                        </form>
                        <hr>
                        <p class="text-white">Belum punya akun? <a href="register.php" class="text-white">Daftar</a></p>
                    </div>
                </div>
            </div>
        </div>
      </div>
<script type="text/javascript" src="asset/js/bootstrap.min.js"></script>
</body>
</html>