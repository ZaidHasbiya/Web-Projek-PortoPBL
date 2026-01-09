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

     <!-- Konten Detail Projek -->
    <div class="container py-5 mt-5">

        <div class="mb-5">
            <h1 class="fw-bold mb-1"><?= htmlspecialchars($projek['judul']); ?></h1>
            <span class="badge bg-info text-dark px-3 py-2 rounded-pill">
                📘 Detail Projek Mahasiswa
            </span>
        </div>
        <!-- Media Projek -->
        <div class="row g-4 mb-5 align-items-stretch">

            <?php if (!empty($projek['gambar_projek'])): ?>
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100 overflow-hidden">
                    <div class="ratio ratio-16x9">
                        <img src="asset/uploads/<?= htmlspecialchars($projek['gambar_projek']); ?>"
                            class="w-100 h-100" style="object-fit: cover;" alt="Gambar Projek">
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (!empty($projek['link'])): ?>
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100 overflow-hidden">
                    <div class="ratio ratio-16x9">
                        <iframe src="<?= htmlspecialchars($projek['link']); ?>" title="Video Projek"
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>


        <!-- Deskripsi Projek -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body px-4 py-4">
                <h4 class="fw-semibold mb-3">📄 Deskripsi Projek</h4>
                <p class="mb-0 text-secondary" style="line-height: 1.7;">
                    <?= nl2br(htmlspecialchars($projek['deskripsi'])); ?>
                </p>
            </div>
        </div>

        <!-- Informasi & Repositori Projek -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body px-4 py-4">

                <h5 class="fw-semibold mb-4">📌 Informasi Projek</h5>

                <div class="row gy-2 mb-3">
                    <div class="col-md-6">
                        <p class="mb-1">👤 <strong>Mahasiswa</strong><br><?= $projek['nama']; ?></p>
                        <p class="mb-0">🆔 <strong>NIM</strong><br><?= $projek['username']; ?></p>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1">📅 <strong>Tanggal Dibuat</strong><br>
                            <?= htmlspecialchars($projek['tgl_pembuatan']); ?>
                        </p>
                        <p class="mb-0">✅ <strong>Tanggal Selesai</strong><br>
                            <?= htmlspecialchars($projek['tgl_selesai']); ?>
                        </p>
                    </div>
                </div>

                <?php if (!empty($projek['link_repo'])): ?>
                <hr class="my-3">
                <p class="mb-1 fw-semibold">🔗 Repositori Projek</p>
                <a href="<?= htmlspecialchars($projek['link_repo']); ?>" target="_blank"
                    class="text-decoration-none text-break">
                    <?= htmlspecialchars($projek['link_repo']); ?>
                </a>
                <?php endif; ?>

            </div>
        </div>



        <!-- Komentar -->
        <div class="card shadow-sm border-0">
            <div class="card-body px-4 py-4">
                <h5 class="fw-semibold mb-3">💬 Komentar</h5>

                <?php if (mysqli_num_rows($komentarResult) > 0): ?>
                <?php while ($k = mysqli_fetch_assoc($komentarResult)): ?>
                <div class="border rounded p-3 mb-3 bg-light">
                    <strong><?= htmlspecialchars($k['nama']); ?></strong>
                    <p class="mb-0 mt-1 text-secondary">
                        <?= nl2br(htmlspecialchars($k['komentar'])); ?>
                    </p>
                </div>
                <?php endwhile; ?>
                <?php else: ?>
                <p class="text-muted mb-0">Belum ada komentar.</p>
                <?php endif; ?>
            </div>
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