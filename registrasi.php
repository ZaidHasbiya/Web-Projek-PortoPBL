<?php
include 'koneksi.php';

if(isset($_POST['registrasi'])){
$nama = $_POST['nama'];
$nim = $_POST['username'];
$password = $_POST['password'];
$role = 'mahasiswa';

$cek = mysqli_query($koneksi,"SELECT * FROM users WHERE nama = '$nama' AND username = '$nim'");

if(mysqli_num_rows($cek) > 0){
  echo "<script>alert('Nama atau NIM sudah terdaftar'); window.location = 'registrasi.php';</script>";
} else{
  $data = "INSERT INTO users (nama, username, password, role) VALUES ('$nama', '$nim', '$password', '$role')";
  if(mysqli_query($koneksi, $data)){
    echo "<script>alert('Registrasi berhasil! silahkan melakukan login'); window.location = 'login.php';</script>";
  }else{
    echo "<script>alert('Registrasi berhasil! silahkan registrasi ulang !'); window.location = 'registrasi.php';</script>";
  }
}
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PortoPBL</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style_registrasi.css">
    
  </head>
<body>
    <header class="navbar">
        <a class="navbar-brand fw-bold text-white" href="index.html">PortoPBL</a>
        <nav class="nav-links">
            <a href="index.html">Home</a>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdownMenuLink"
            role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Jurusan
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="jurusan_if.html">Teknik Informatika</a></li>
            <li><a class="dropdown-item" href="jurusan_mesin.html">Teknik Mesin</a></li>
            <li><a class="dropdown-item" href="jurusan_elektro.html">Teknik Elektro</a></li>
            <li><a class="dropdown-item" href="jurusan_mb.html">Manajemen Bisnis</a></li>
          </ul>
        </li>
            <a href="projek.html">Projek</a>
            <a href="registrasi.php">Daftar</a>
        </nav>
    </header>

    <div class="registrasi-form">
   <form method="POST" action="">
        <h3 class="login-title">Registrasi Akun PortoPBL</h3><br>
        <br>
        <input type="text" class="fullname" placeholder="Nama Lengkap" name="nama">
        <input type="text" class="inputnim" placeholder="NIM" name="username">
        <input type="password" class="password" placeholder="Password" name="password">
        <button type="submit" class="registrasi-btn" name="registrasi">Daftar Sekarang</button>
    </form>
    <a href="login.php">Sudah Punya Akun? Login Disini</a>
    </div><br><br>
    <img src="asset/wave-info.svg">

</body>
</html>