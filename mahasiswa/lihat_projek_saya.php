<?php
/*
Nama File   : lihat_projek_saya.php
Deskripsi     : Menampilkan detail projek milik mahasiswa yang sedang login
             beserta komentar yang masuk pada projek tersebut
Dibuat Oleh    : Reifandra Kinadi - NIM : [3312501047]
Tanggal     : 10 Oktober 2025
*/

session_start();
// Memulai session untuk autentikasi pengguna

include '../koneksi.php';

// Mengecek apakah user sudah login
if (!isset($_SESSION['username'])) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
          Swal.fire({
              icon: 'warning',
              title: 'Silakan login terlebih dahulu!',
              timer: 2000,
              showConfirmButton: false
          }).then(() => {
              window.location.href = '../login.php';
          });
          </script>";
    exit;
}

// Mengecek apakah role user adalah mahasiswa
if ($_SESSION['role'] !== 'mahasiswa') {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
          Swal.fire({
              icon: 'error',
              title: 'Maaf, anda bukan mahasiswa. Silakan login ulang.',
              timer: 2000,
              showConfirmButton: false
          }).then(() => {
              window.location.href = '../login.php';
          });
          </script>";
    exit;
}

// Menyimpan ID user dari session
$user_id = $_SESSION['id'];

// Validasi parameter projek_id dari URL
if (!isset($_GET['projek_id'])) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
          Swal.fire({
              icon: 'warning',
              title: 'Projek tidak ditemukan!',
              timer: 2000,
              showConfirmButton: false
          }).then(() => {
              window.location.href='projek_saya.php';
          });
          </script>";
    exit;
}

// Mengambil ID projek dari URL
$projek_id = $_GET['projek_id'];

/*
Query untuk mengambil data projek
Memastikan projek adalah milik mahasiswa yang sedang login
*/
$query = "SELECT * FROM projek 
          WHERE projek_id = '$projek_id' 
          AND user_id = '$user_id'";
$result = mysqli_query($koneksi, $query);

// Validasi apakah projek ditemukan
if (mysqli_num_rows($result) == 0) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
          Swal.fire({
              icon: 'error',
              title: 'Projek tidak ditemukan atau bukan milik Anda.',
              timer: 2000,
              showConfirmButton: false
          }).then(() => {
              window.location.href='projek_saya.php';
          });
          </script>";
    exit;
}

// Mengambil data projek
$projek = mysqli_fetch_assoc($result);

/*
Query untuk mengambil komentar pada projek
Menggabungkan tabel komentar dan users
untuk mendapatkan nama pemberi komentar
*/
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
  <!-- Metadata halaman -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PortoPBL</title>

  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700;900&display=swap"
    rel="stylesheet"
  >

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../styles.css" type="text/css">
</head>

<body>

  <!-- Navbar Mahasiswa -->
  <?php include '../layouts/navbar_mhs.php'; ?>

  <!-- Konten Detail Projek -->
  <div class="container py-5 mt-5">

    <!-- Judul Projek -->
    <h1 class="fw-bold mb-4">
      <?= htmlspecialchars($projek['judul']); ?>
    </h1>

    <!-- Gambar Projek -->
    <?php if (!empty($projek['gambar_projek'])): ?>
      <img
        src="../asset/uploads/<?= htmlspecialchars($projek['gambar_projek']); ?>"
        class="img-fluid rounded shadow-sm mb-4"
        alt="Gambar Projek"
      >
    <?php endif; ?>

    <!-- Deskripsi Projek -->
    <div class="fw-semibold">
      <h2>Deskripsi Projek</h2>
      <p><?= nl2br(htmlspecialchars($projek['deskripsi'])); ?></p>
    </div>

    <!-- Video Projek -->
    <div class="mb-4">
      <?php if (!empty($projek['link'])): ?>
        <h4 class="fw-semibold">Video</h4>
        <div class="ratio ratio-16x9">
          <iframe
            src="<?= htmlspecialchars($projek['link']); ?>"
            title="Video Projek"
            allowfullscreen
          ></iframe>
        </div>
      <?php endif; ?>
    </div>

    <!-- Informasi Tambahan Projek -->
    <div class="mb-4">
      <p>
        <strong>Tautan Repositori:</strong><br>
        <a
          href="<?= htmlspecialchars($projek['link_repo']); ?>"
          target="_blank"
          class="text-break d-block text-decoration-none"
        >
          <?= htmlspecialchars($projek['link_repo']); ?>
        </a>
      </p>
      <p><strong>Tanggal Dibuat:</strong> <?= htmlspecialchars($projek['tgl_pembuatan']); ?></p>
      <p><strong>Tanggal Selesai:</strong> <?= htmlspecialchars($projek['tgl_selesai']); ?></p>
      <p><strong>Dibuat Oleh:</strong> <?= $_SESSION['nama']; ?></p>
      <p><strong>NIM:</strong> <?= $_SESSION['username']; ?></p>
    </div>

    <!-- Komentar Projek -->
    <div class="border border-dark p-3 rounded mt-4">
      <h6 class="fw-semibold mb-3">Komentar</h6>

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

  <!-- Wave -->
  <div class="overflow-hidden mt-5">
    <img
      src="../asset/wave-new-navy.svg"
      class="img-fluid d-block"
      style="width:100vw"
      alt="wave"
    >
  </div>

  <!-- Footer -->
  <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>
