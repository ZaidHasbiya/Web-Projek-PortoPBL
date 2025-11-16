<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['username'])){
  echo "<script>alert('Silakan login terlebih dahulu'); window.location ='login.php';</script>";
  exit;
}

if ($_SESSION['role'] !== 'dosen') {
    echo "<script>alert('Anda tidak memiliki akses!'); window.location.href='login.php';</script>";
    exit;
}

if (!isset($_GET['id'])) {
    echo "<script>alert('Mahasiswa tidak ditemukan'); window.location='index_dosen.php';</script>";
    exit;
}

$user_id = $_GET['id'];

$query_user = "SELECT * FROM users WHERE id = '$user_id'";
$result_user = mysqli_query($koneksi, $query_user);
$user = mysqli_fetch_assoc($result_user);

if (!$user) {
    echo "<script>alert('Mahasiswa tidak ditemukan'); window.location='index_dosen.php';</script>";
    exit;
}

$query_projek = "SELECT * FROM projek WHERE user_id = '$user_id'";
$result_projek = mysqli_query($koneksi, $query_projek);
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

  <link rel="stylesheet" href="css/bootstrap.min.css">

  <link rel="stylesheet" href="styles.css" type="text/css">
</head>

<body>

  <?php include 'layouts/navbar_dosen.php'; ?>
  <div class="container py-4 mt-5 pt-5">
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
    <!-- Kolom kanan: Tentang Mahasiswa -->
   <div class="col-md-8">
      <!-- Tentang Mahasiswa -->
      <div class="bg-info p-3 rounded mb-4">
        <h5 class="fw-bold text-white">Tentang Mahasiswa</h5>
        <p class="mb-0 text-white">Deskripsi singkat tentang mahasiswa dapat ditulis di sini.</p>
      </div>

      <!-- Catatan Prestasi -->
      <div class="bg-info p-3 rounded">
        <h5 class="fw-bold text-white">Catatan Prestasi</h5>
          <p class="text-white">Juara 1 Lomba Web Design</p>
          <p class="text-white">Asisten Praktikum Pemrograman Web</p>
          <p class="text-white">Peserta Kegiatan PBL 2025</p>
      </div>
    </div>
</div>
 </div>
<div class="bg-primary p-4 rounded mt-4">
  <h5 class="fw-bold mb-3 text-center text-white">Proyek</h5>
  <?php if(mysqli_num_rows($result_projek) > 0) : ?>
    <?php while ($projek = mysqli_fetch_assoc($result_projek)): ?>

      <div class="bg-primary bg-opacity-25 p-4 rounded mb-4">

        <div class="mb-3">
          <label class="form-label fw-semibold text-white">Judul Proyek</label>
          <div class="form-control bg-light">
            <?= htmlspecialchars($projek['judul']) ?>
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold text-white">Deskripsi Proyek</label>
          <div class="form-control bg-light" style="min-height: 100px;">
            <?= htmlspecialchars($projek['deskripsi']) ?>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-md-6">
            <div class="bg-light border border-dark-subtle p-3 text-center rounded">
              <span class="fw-semibold text-muted">Video</span>
              <?php if (!empty($projek['link'])): ?>
                <div class="ratio ratio-16x9 mt-2">
                  <iframe src="<?= htmlspecialchars($projek['link']) ?>" allowfullscreen></iframe>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <div class="col-md-6">
            <div class="bg-light border border-dark-subtle p-3 text-center rounded">
              <span class="fw-semibold text-muted">Foto</span>
              <?php if (!empty($projek['gambar_projek'])): ?>
                <img src="uploads/<?= htmlspecialchars($projek['gambar_projek']) ?>" 
                     class="img-fluid rounded mt-2">
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

    <?php endwhile; ?>

  <?php else: ?>
      <p class="text-center text-white fw-semibold">Mahasiswa belum mengunggah projek apapun.</p>
  <?php endif; ?>

</div>

  <img src="asset/wave-dark-blue.svg">
  <footer class="text-center py-3 bg-light mt-5">
    &copy; <span>2025</span> Tim Web Portofolio Projek PBL
  </footer>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>