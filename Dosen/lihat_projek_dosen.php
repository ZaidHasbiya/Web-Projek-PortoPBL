<?php
/*
Nama File  : lihat_projek_dosen.php
Deskripsi  :
File ini digunakan oleh dosen untuk melihat detail projek mahasiswa,
menampilkan deskripsi, gambar, video, serta memberikan dan melihat
komentar dosen terhadap projek mahasiswa.
Dibuat Oleh    :  - NIM : []
Tanggal     : 
*/

session_start();
include '../koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
  echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='../login.php';</script>";
  exit;
}

// Cek apakah user memiliki role dosen

if ($_SESSION['role'] !== 'dosen') {
  echo "<script>alert('Hanya dosen yang dapat memberikan komentar!'); window.location.href='../login.php';</script>";
  exit;
}

$user_id   = $_SESSION['id'];           // ID dosen
$projek_id = $_GET['projek_id'];        // ID projek

// Cek apakah ID projek tersedia

if (!$projek_id) {
  echo "<script>alert('Projek tidak ditemukan!'); window.location.href='projek_mhs.php';</script>";
  exit;
}

// Mengambil data projek beserta data mahasiswa pembuat projek
$query = "SELECT projek.*, users.nama, users.username 
          FROM projek 
          JOIN users ON projek.user_id = users.id 
          WHERE projek.projek_id = '$projek_id'";
$result = mysqli_query($koneksi, $query);
$projek = mysqli_fetch_assoc($result);

// Jika data projek tidak ditemukan
if (!$projek) {
  echo "<script>alert('Projek tidak ditemukan.'); window.location.href='projek_mhs.php';</script>";
  exit;
}

// Proses penyimpanan komentar dosen

if (isset($_POST['komentar'])) {
  $komentar = $_POST['komentar'];

  $insert = "INSERT INTO komentar (projek_id, user_id, komentar) 
             VALUES ('$projek_id', '$user_id', '$komentar')";
  mysqli_query($koneksi, $insert);

  echo "<script>
          alert('Komentar berhasil dikirim!');
          window.location.href='lihat_projek_dosen.php?projek_id=$projek_id';
        </script>";
  exit;
}

// Mengambil daftar komentar pada projek
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
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../styles.css" type="text/css">
</head>

<body>

<?php include '../layouts/navbar_dosen.php'; ?>

<div class="container py-5 mt-5">

  <h1 class="fw-bold mb-4"><?= htmlspecialchars($projek['judul']); ?></h1>

  <?php if (!empty($projek['gambar_projek'])): ?>
    <div class="mb-4">
      <img src="../asset/uploads/<?= htmlspecialchars($projek['gambar_projek']); ?>" 
           class="img-fluid rounded shadow" 
           alt="Gambar Projek">
    </div>
  <?php endif; ?>

  <div class="mb-4">
    <h4 class="fw-semibold">Deskripsi Projek</h4>
    <p class="text-muted">
      <?= nl2br(htmlspecialchars($projek['deskripsi'])); ?>
    </p>
  </div>

  <?php if (!empty($projek['link'])): ?>
    <div class="mb-4">
      <h4 class="fw-semibold">Video</h4>
      <div class="ratio ratio-16x9">
        <iframe src="<?= htmlspecialchars($projek['link']); ?>" 
                title="Video Projek" allowfullscreen></iframe>
      </div>
    </div>
  <?php endif; ?>

  <div class="mb-4">
    <p>
      <strong>Tautan Repositori:</strong><br>
      <a href="<?= htmlspecialchars($projek['link_repo']); ?>" 
         target="_blank" 
         class="text-break d-block text-decoration-none">
        <?= htmlspecialchars($projek['link_repo']); ?>
      </a>
    </p>
    <p><strong>Tanggal Dibuat:</strong> <?= htmlspecialchars($projek['tgl_pembuatan']); ?></p>
    <p><strong>Tanggal Selesai:</strong> <?= htmlspecialchars($projek['tgl_selesai']); ?></p>
    <p><strong>Dibuat Oleh:</strong> <?= htmlspecialchars($projek['nama']); ?></p>
    <p><strong>NIM:</strong> <?= htmlspecialchars($projek['username']); ?></p>
  </div>

  <!-- Form Komentar -->
  <form action="" method="POST" class="border p-3 rounded shadow-sm mb-4">
    <h5 class="fw-semibold mb-3">Tulis Komentar</h5>

    <div class="mb-3">
      <textarea name="komentar" 
                class="form-control" 
                rows="3" 
                placeholder="Tulis komentar di sini..." 
                required></textarea>
    </div>

    <button type="submit" class="btn btn-clr">
      Kirim Komentar
    </button>
  </form>

  <!-- Daftar Komentar -->
  <div class="border p-3 rounded shadow-sm mb-5">
    <h5 class="fw-semibold mb-3">Komentar Dosen</h5>

    <?php if (mysqli_num_rows($komentarResult) > 0): ?>
      <?php while ($k = mysqli_fetch_assoc($komentarResult)): ?>
        <div class="p-3 bg-light border rounded mb-3">
          <strong><?= htmlspecialchars($k['nama']); ?></strong>
          <p class="mb-0">
            <?= nl2br(htmlspecialchars($k['komentar'])); ?>
          </p>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-muted">Belum ada komentar.</p>
    <?php endif; ?>
  </div>

</div>
 <div>
        <img src="../asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave">
    </div>
<footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
