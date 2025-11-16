<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['username'])){
  echo "<script>alert('username tidak sesuai ! silahkan melakukan login'); window.location ='login.php';</script>";
}

if ($_SESSION['role'] !== 'dosen') {
    echo "<script>
            alert('Maaf, anda bukan dosen. Silakan login ulang.');
            window.location.href = 'login.php';
          </script>";
    exit;
}

$nama = $_SESSION['nama'];

$query = "SELECT * FROM users WHERE nama = '$nama'";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PortoPBL</title>

  <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
  crossorigin="anonymous"/>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../css/bootstrap.min.css">

  <link rel="stylesheet" href="../styles.css" type="text/css">
</head>

<body>

  <?php include '../layouts/navbar_dosen.php'; ?>
<div class="container my-5">
  <!-- Baris utama -->
  <div class="row align-items-center">
    <!-- Kolom kiri: Foto + Jurusan -->
    <div class="col-md-4 text-center">
      <div class="ratio ratio-1x1 rounded-circle overflow-hidden mx-auto mb-2" style="width: 200px;">
        <img src="../tim/panda.jpeg" alt="Foto Mahasiswa" class="w-100 h-100" style="object-fit: cover;">
      </div>
      <small class="d-block mb-3 text-muted">
  <?= htmlspecialchars($user['nama']) ?>
</small>

<div class="bg-info p-2 rounded d-inline-block">
  <strong class="text-white">
    Jurusan: <?= htmlspecialchars($user['jurusan'] ?: 'Belum Diatur') ?>
  </strong>
</div>
</div>
    
  <footer class="text-center py-3 bg-light mt-5">
    &copy; <span>2025</span> Tim Web Portofolio Projek PBL
  </footer>

  <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>