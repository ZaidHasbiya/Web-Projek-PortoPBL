<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['nama'])) {
    echo "<script>
            alert('Silakan login terlebih dahulu!');
            window.location.href = 'login.php';
          </script>";
    exit;
}

if ($_SESSION['role'] !== 'mahasiswa') {
    echo "<script>
            alert('Maaf, anda bukan mahasiswa. Silakan login ulang.');
            window.location.href = 'login.php';
          </script>";
    exit;
}

$user_id = $_SESSION['id'];

if (!isset($_GET['projek_id'])) {
    echo "<script>alert('Projek tidak ditemukan!'); window.location.href='projek_saya.php';</script>";
    exit;
}
$projek_id = $_GET['projek_id'];

$query = "SELECT * FROM projek WHERE projek_id = '$projek_id' AND user_id = '$user_id'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('Projek tidak ditemukan atau bukan milik Anda.'); window.location.href='projek_saya.php';</script>";
    exit;
}

$projek = mysqli_fetch_assoc($result);

$komentarQuery = "SELECT komentar.*, users.nama 
                  FROM komentar 
                  JOIN users ON komentar.user_id = users.id 
                  WHERE komentar.projek_id = '$projek_id' 
                  ORDER BY komentar.komentar_id DESC";
$komentarResult = mysqli_query($koneksi, $komentarQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PortoPBL</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../css/bootstrap.min.css">

  <link rel="stylesheet" href="../styles.css" type="text/css">
</head>

<body>

  <!-- ===== Navbar ===== -->
  <?php include 'layouts/navbar_mhs.php'; ?>
  <div class="container py-5">
   <h1><?= htmlspecialchars($projek['judul']); ?></h1>
    <?php if (!empty($projek['gambar_projek'])): ?>
      <img src="../asset/uploads/<?= htmlspecialchars($projek['gambar_projek']); ?>" class="img-fluid rounded shadow-sm mb-4" alt="Gambar Projek">
    <?php endif; ?>
    <h2>Deskripsi Projek</h2>
    <p><?= nl2br(htmlspecialchars($projek['deskripsi'])); ?></p>

    <?php if (!empty($projek['link'])): ?>
      <h2>Video</h2>
      <iframe width="560" height="315" src="<?= htmlspecialchars($projek['link']); ?>" title="Video Projek" frameborder="0" allowfullscreen></iframe>
    <?php endif; ?>

    <p><strong>Tanggal Dibuat:</strong> <?= htmlspecialchars($projek['tgl_pembuatan']); ?></p>
    <p><strong>Tanggal Selesai:</strong> <?= htmlspecialchars($projek['tgl_selesai']); ?></p>
    <p><strong>Dibuat Oleh:</strong> <?= $_SESSION['nama']; ?></p>
    <p><strong>NIM:</strong> <?= $_SESSION['username']; ?></p>
    <div class="border border-dark p-3 rounded mt-4">
      <h6 class="fw-semibold mb-3">Komentar</h6>
      <div class="mt-4">
         <?php if (mysqli_num_rows($komentarResult) > 0): ?>
    <?php while ($k = mysqli_fetch_assoc($komentarResult)): ?>
      <div class="p-3 bg-light border rounded mb-3">
        <strong><?= htmlspecialchars($k['nama']); ?></strong>
        <p class="mb-0"><?= nl2br(htmlspecialchars($k['komentar'])); ?></p>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
      <p class="text-muted">Belum ada komentar.</p>
  <?php endif; ?>
      </div>
    </div>
  </div>
  <img src="../asset/wave-dark-blue.svg">
  <footer class="text-center py-3 bg-light mt-5">
    &copy; <span>2025</span> Tim Web Portofolio Projek PBL
  </footer>

  <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>