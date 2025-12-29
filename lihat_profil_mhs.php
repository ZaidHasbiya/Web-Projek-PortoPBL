<?php
/*
Nama File   : lihat_profil_mhs.php
Deskripsi     : Menampilkan detail profil mahasiswa, daftar proyek,
             serta riwayat penilaian portofolio pada halaman publik
Dibuat Oleh    : Zaid Hasbiya Abrar - NIM : [3312501046]
Tanggal     : 7 Oktober 2025
*/

include 'koneksi.php';

// Validasi parameter id mahasiswa
if (!isset($_GET['id'])) {
  echo "<script>alert('Mahasiswa tidak ditemukan'); window.location='index_mahasiswa.php';</script>";
  exit;
}

// Menyimpan id mahasiswa dari URL
$user_id = $_GET['id'];

// Query data mahasiswa
$query_user  = "SELECT * FROM users WHERE id = '$user_id'";
$result_user = mysqli_query($koneksi, $query_user);
$user        = mysqli_fetch_assoc($result_user);

// Jika mahasiswa tidak ditemukan
if (!$user) {
  echo "<script>alert('Mahasiswa tidak ditemukan'); window.location='index_mahasiswa.php';</script>";
  exit;
}

// Menentukan foto profil mahasiswa
$foto = !empty($user['foto_profil'])
  ? 'asset/profil/' . $user['foto_profil']
  : 'tim/profil-kosong.jpeg';

// Query data proyek mahasiswa
$query_projek  = "SELECT * FROM projek WHERE user_id = '$user_id'";
$result_projek = mysqli_query($koneksi, $query_projek);

// Query riwayat penilaian portofolio mahasiswa
$query_penilaian = "
  SELECT pf.*, u.nama AS nama_dosen
  FROM penilaian_portofolio pf
  JOIN users u ON pf.dosen_id = u.id
  WHERE pf.mahasiswa_id = '$user_id'
  ORDER BY pf.id_penilaian DESC
";
$result_penilaian = mysqli_query($koneksi, $query_penilaian);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata halaman -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PortoPBL</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" />

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- File CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="styles.css" />
</head>

<style>
/* Kotak biru */
.bg-footer {
    background-color: #1f4f73;
    /* warna biru kotak */
    border-radius: 6px;
}

/* Judul & label warna cream */
.bg-footer h5,
.bg-footer label,
.bg-footer span,
.bg-footer strong {
    color: #e9e1c9 !important;
}

/* Isi deskripsi warna #2d3748 */
.bg-footer .form-control,
.bg-footer p,
.bg-footer div,
.bg-footer .card-text {
    color: #2d3748 !important;
}

/* Biar area teks tetap putih */
.bg-footer .form-control {
    background-color: #ffffff !important;
}

/* Jangan ganggu warna link */
.bg-footer a {
    color: inherit;
}

.bg-footer .form-control a {
    color: #0d6efd !important;
    /* biru standar bootstrap */
}
</style>

<body>

    <!-- Menampilkan navbar publik -->
    <?php include 'layouts/navbar_publik.php'; ?>

    <div class="container py-4 mt-5 pt-5">

        <!-- Informasi utama mahasiswa -->
        <div class="row align-items-center">

            <!-- Kolom kiri: Foto dan jurusan -->
            <div class="col-md-4 text-center">
                <div class="ratio ratio-1x1 rounded-circle overflow-hidden mx-auto mb-2" style="width: 200px;">
                    <img src="<?= $foto ?>" alt="Foto Mahasiswa" class="w-100 h-100" style="object-fit: cover;" />
                </div>

                <small class="d-block mb-3 text-muted">
                    <?= htmlspecialchars($user['nama']) ?>
                </small>

                <div class="bg-footer p-2 rounded d-inline-block">
                    <strong class="text-white">
                        Jurusan: <?= htmlspecialchars($user['jurusan'] ?: 'Belum Diatur') ?>
                    </strong>
                </div>
            </div>

            <!-- Kolom kanan: Tentang mahasiswa -->
            <div class="col-md-8">

                <!-- Tentang mahasiswa -->
                <div class="bg-footer p-3 rounded mb-4">
                    <h5 class="fw-bold text-white">Tentang Mahasiswa</h5>
                    <p class="mb-0 text-white">
                        <?= $user['deskripsi_diri'] ?: 'Belum Ada Deskripsi Apapun' ?>
                    </p>
                </div>

                <!-- Catatan prestasi -->
                <div class="bg-footer p-3 rounded">
                    <h5 class="fw-bold text-white">Catatan Prestasi</h5>
                    <p class="text-white">
                        <?= $user['prestasi'] ?: 'Belum Ada Prestasi Apapun' ?>
                    </p>
                </div>

            </div>
        </div>

        <!-- Daftar proyek mahasiswa -->
        <?php if (mysqli_num_rows($result_projek) > 0): ?>
        <?php while ($projek = mysqli_fetch_assoc($result_projek)): ?>

        <div class="bg-footer p-4 rounded mt-4">
            <h5 class="fw-bold mb-3 text-center text-white">Proyek</h5>

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

            <div class="mb-4">
                <label class="form-label fw-semibold text-white">Tautan Repositori</label>
                <div class="form-control bg-light">
                    <a href="<?= htmlspecialchars($projek['link_repo']) ?>" target="_blank">
                        <?= htmlspecialchars($projek['link_repo']) ?>
                    </a>
                </div>
            </div>

            <div class="row g-3">

                <!-- Video proyek -->
                <div class="col-md-6">
                    <div class="bg-light border p-3 text-center rounded">
                        <span class="fw-semibold text-muted">Video</span>
                        <?php if (!empty($projek['link'])): ?>
                        <div class="ratio ratio-16x9 mt-2">
                            <iframe src="<?= htmlspecialchars($projek['link']) ?>" allowfullscreen></iframe>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Foto proyek -->
                <div class="col-md-6">
                    <div class="bg-light border p-3 text-center rounded">
                        <span class="fw-semibold text-muted">Foto</span><br />
                        <?php if (!empty($projek['gambar_projek'])): ?>
                        <img src="asset/uploads/<?= htmlspecialchars($projek['gambar_projek']) ?>"
                            class="img-fluid rounded mt-2" />
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

        <?php endwhile; ?>
        <?php else: ?>
        <p class="text-center text-dark fw-semibold">
            Mahasiswa belum mengunggah projek apapun.
        </p>
        <?php endif; ?>

        <!-- Riwayat penilaian portofolio -->
        <div class="container mt-4 mb-5">
            <div class="bg-footer p-4 rounded">
                <h5 class="fw-bold text-white mb-3 text-center">
                    Riwayat Penilaian Portofolio
                </h5>

                <?php if (mysqli_num_rows($result_penilaian) > 0): ?>
                <?php while ($p = mysqli_fetch_assoc($result_penilaian)): ?>

                <div class="bg-light p-3 rounded mb-3">
                    <strong><?= htmlspecialchars($p['nama_dosen']) ?></strong>
                    <span class="badge bg-footer ms-2">
                        Nilai: <?= htmlspecialchars($p['nilai']) ?>
                    </span>

                    <p class="mt-2 mb-1">
                        Komentar: <?= htmlspecialchars($p['komentar']) ?>
                    </p>
                </div>

                <?php endwhile; ?>
                <?php else: ?>
                <p class="text-center text-white">
                    Belum ada penilaian dari dosen.
                </p>
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