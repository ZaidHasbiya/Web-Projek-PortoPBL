<?php
/*
Nama File   : lihat_projek.php
Deskripsi     : Menampilkan detail proyek mahasiswa beserta
             komentar pada halaman publik PortoPBL
Dibuat Oleh    : Zaid Hasbiya Abrar - NIM : [3312501046]
Tanggal     : 7 Oktober 2025
*/

include 'koneksi.php';

// Mengambil id proyek dari parameter URL
$projek_id = $_GET['projek_id'] ?? null;

// Validasi jika id proyek tidak tersedia
if (!$projek_id) {
  echo "<script>alert('Projek tidak ditemukan!'); window.location.href='projek_mhs.php';</script>";
  exit;
}

// Query untuk mengambil data proyek dan pemiliknya
$query = "SELECT projek.*, users.nama, users.username 
          FROM projek 
          JOIN users ON projek.user_id = users.id 
          WHERE projek.projek_id = '$projek_id'";
$result = mysqli_query($koneksi, $query);
$projek = mysqli_fetch_assoc($result);

// Validasi jika data proyek tidak ditemukan
if (!$projek) {
  echo "<script>alert('Projek tidak ditemukan.'); window.location.href='projek.php';</script>";
  exit;
}

// Query untuk mengambil komentar proyek
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
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- File CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="styles.css" />
</head>

<body>

    <!-- Menampilkan navbar publik -->
    <?php include 'layouts/navbar_publik.php'; ?>

    <div class="container py-5 mt-5">

        <!-- Judul proyek -->
        <h1><?= htmlspecialchars($projek['judul']); ?></h1>

        <!-- Gambar proyek -->
        <?php if (!empty($projek['gambar_projek'])): ?>
        <img src="asset/uploads/<?= htmlspecialchars($projek['gambar_projek']); ?>"
            class="img-fluid rounded shadow-sm mb-4" alt="Gambar Projek" />
        <?php endif; ?>

        <!-- Deskripsi proyek -->
        <h2>Deskripsi Projek</h2>
        <p><?= nl2br(htmlspecialchars($projek['deskripsi'])); ?></p>

        <!-- Video proyek -->
        <?php if (!empty($projek['link'])): ?>
        <h2>Video</h2>
        <div class="ratio ratio-16x9">
                <iframe src="<?= htmlspecialchars($projek['link']); ?>" title="Video Projek" allowfullscreen></iframe>
            </div>
        <?php endif; ?>

        <!-- Informasi tambahan proyek -->
        <p>
            <strong>Tautan Repositori:</strong><br />
            <a href="<?= htmlspecialchars($projek['link_repo']); ?>" target="_blank"
                class="text-break d-block text-decoration-none">
                <?= htmlspecialchars($projek['link_repo']); ?>
            </a>
        </p>

        <p><strong>Tanggal Dibuat:</strong> <?= htmlspecialchars($projek['tgl_pembuatan']); ?></p>
        <p><strong>Tanggal Selesai:</strong> <?= htmlspecialchars($projek['tgl_selesai']); ?></p>
        <p><strong>Dibuat Oleh:</strong> <?= htmlspecialchars($projek['nama']); ?></p>
        <p><strong>NIM:</strong> <?= htmlspecialchars($projek['username']); ?></p>

        <!-- Komentar proyek -->
        <div class="border border-dark p-3 rounded mt-4">
            <h6 class="fw-semibold mb-3">Komentar</h6>

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

    <!-- Wave -->
    <div class="overflow-hidden mt-5">
        <img src="asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave" />
    </div>

    <!-- Footer -->
    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>