<?php
include 'koneksi.php';

if(isset($_POST['registrasi'])){
  $nama = $_POST['nama'];
  $nim = $_POST['username'];
  $password = $_POST['password'];
  $role = 'mahasiswa';

  $cek = mysqli_query($koneksi,"SELECT * FROM users WHERE nama = '$nama' AND username = '$nim'");

  if(mysqli_num_rows($cek) > 0){
    echo "<script>alert('Nama atau NIM sudah terdaftar'); window.location='registrasi.php';</script>";
  } else{
    $data = "INSERT INTO users (nama, username, password, role) VALUES ('$nama', '$nim', '$password', '$role')";
    if(mysqli_query($koneksi, $data)){
      echo "<script>alert('Registrasi berhasil! silahkan melakukan login'); window.location='login.php';</script>";
    } else{
      echo "<script>alert('Registrasi gagal! silahkan registrasi ulang'); window.location='registrasi.php';</script>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PortoPBL | Registrasi</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body class="bg-light" style="font-family:'Poppins', sans-serif;">

<!-- ===== NAVBAR ===== -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.html">PortoPBL</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Jurusan
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="jurusan_if.html">Teknik Informatika</a></li>
            <li><a class="dropdown-item" href="jurusan_mesin.html">Teknik Mesin</a></li>
            <li><a class="dropdown-item" href="jurusan_elektro.html">Teknik Elektro</a></li>
            <li><a class="dropdown-item" href="jurusan_mb.html">Manajemen Bisnis</a></li>
          </ul>
        </li>

        <li class="nav-item"><a class="nav-link" href="projek.html">Projek</a></li>
        <li class="nav-item"><a class="nav-link active" href="registrasi.php">Daftar</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- ===== FORM REGISTRASI ===== -->
<div class="container min-vh-100 d-flex align-items-center justify-content-center pt-5">
  <div class="col-md-6 col-lg-4">
    <div class="card shadow border-0 rounded-4">
      <div class="card-body p-4">

        <h4 class="text-center fw-bold mb-4">Registrasi Akun PortoPBL</h4>

        <form method="POST" action="">
          <div class="mb-3">
            <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
          </div>

          <div class="mb-3">
            <input type="text" name="username" class="form-control" placeholder="NIM" required>
          </div>

          <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>

          <div class="d-grid">
            <button type="submit" name="registrasi" class="btn btn-primary btn-lg">
              Daftar Sekarang
            </button>
          </div>
        </form>

        <p class="text-center mt-3 mb-0">
          Sudah punya akun?
          <a href="login.php" class="fw-semibold text-decoration-none">Login di sini</a>
        </p>

      </div>
    </div>
  </div>
</div>

<!-- ===== WAVE ===== -->
<div class="w-100 overflow-hidden">
  <img src="asset/wave-info.svg" class="img-fluid w-100 d-block" alt="wave">
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
