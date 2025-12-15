<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    echo "<script>
            alert('Username tidak sesuai! Silakan login.');
            window.location = 'login.php';
          </script>";
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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous"/>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="../styles.css" type="text/css">
    <link rel="stylesheet" href="../custom.css">
</head>

<body>

    <!-- Navbar -->
    <?php include '../layouts/navbar_dosen.php'; ?>

    <!-- Container Profil -->
    <div class="container my-5 margin-top">
        <div class="row align-items-center">

            <!-- Kolom Kiri: Foto dan Identitas -->
            <div class="col-md-4 text-center">

                <!-- Foto profil -->
                <div class="ratio ratio-1x1 rounded-circle overflow-hidden mx-auto mb-2" style="width: 200px;">
                    <img src="../tim/panda.jpeg" alt="Foto Mahasiswa" class="w-100 h-100" style="object-fit: cover;">
                </div>

                <!-- Nama -->
                <small class="d-block mb-3 text-muted">
                    <?= htmlspecialchars($user['nama']) ?>
                </small>

                <!-- Jurusan -->
                <div class="bg-footer p-2 rounded d-inline-block">
                    <strong class="text-white">
                        Jurusan: <?= htmlspecialchars($user['jurusan'] ?: 'Belum Diatur') ?>
                    </strong>
                </div>

            </div>
                <!-- Kolom kanan: Tentang Mahasiswa -->
    <div class="col-md-8">
      <!-- Tentang Mahasiswa -->
      <div class="bg-footer p-3 rounded mb-4">
        <h5 class="fw-bold text-white">Tentang Dosen</h5>
        <p class="mb-0 text-white">Deskripsi singkat tentang Dosen dapat ditulis di sini.</p>
      </div>

      <!-- Catatan Prestasi -->
      <div class="bg-footer p-3 rounded">
        <h5 class="fw-bold text-white">Catatan Prestasi</h5>
      </div>
    </div>
        </div>
    </div>

<div class="overflow-hidden mt-5">
  <img src="../asset/wave-new-navy.svg"
       class="img-fluid d-block"
       style="width:100vw"
       alt="wave">
</div>
<section class="bg-footer">
<br><br><br>
</section>

<footer class="w-100 text-center py-3 bg-light">
  &copy; <span>2025</span> Tim Web Portofolio Projek PBL
</footer>

    <!-- Bootstrap JS -->
    <script src="../js/bootstrap.bundle.min.js"></script>

</body>
</html>
