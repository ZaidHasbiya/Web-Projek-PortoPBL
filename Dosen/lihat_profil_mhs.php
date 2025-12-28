<?php
/*
Nama File : lihat_profil_mhs.php
Deskripsi :
Halaman ini digunakan oleh dosen untuk melihat detail profil mahasiswa,
daftar proyek mahasiswa, serta memberikan dan melihat penilaian portofolio.
*/

session_start();
include '../koneksi.php';

// Cek login
if (!isset($_SESSION['username'])) {
  echo "<script>alert('Silakan login terlebih dahulu'); window.location ='../login.php';</script>";
  exit;
}

// Cek role dosen
if ($_SESSION['role'] !== 'dosen') {
  echo "<script>alert('Anda tidak memiliki akses!'); window.location.href='../login.php';</script>";
  exit;
}

// Cek ID mahasiswa
if (!isset($_GET['id'])) {
  echo "<script>alert('Mahasiswa tidak ditemukan'); window.location='index_dosen.php';</script>";
  exit;
}

$user_id  = $_GET['id'];
$dosen_id = $_SESSION['id'];

// Ambil data mahasiswa
$query_user  = "SELECT * FROM users WHERE id = '$user_id'";
$result_user = mysqli_query($koneksi, $query_user);
$user        = mysqli_fetch_assoc($result_user);

if (!$user) {
  echo "<script>alert('Mahasiswa tidak ditemukan'); window.location='index_dosen.php';</script>";
  exit;
}

// Foto profil
$foto = !empty($user['foto_profil'])
  ? '../asset/profil/' . $user['foto_profil']
  : '../tim/profil-kosong.jpeg';

// Simpan penilaian
if (isset($_POST['simpan_penilaian'])) {
  $komentar = $_POST['komentar'];
  $nilai    = (int) $_POST['nilai'];

  $insert_penilaian = "
    INSERT INTO penilaian_portofolio 
    (mahasiswa_id, dosen_id, komentar, nilai)
    VALUES ('$user_id', '$dosen_id', '$komentar', '$nilai')
  ";

  if (mysqli_query($koneksi, $insert_penilaian)) {
    echo "<script>alert('Penilaian berhasil disimpan');</script>";
  } else {
    echo "<script>alert('Gagal menyimpan penilaian');</script>";
  }
}

// Ambil projek mahasiswa
$query_projek  = "SELECT * FROM projek WHERE user_id = '$user_id'";
$result_projek = mysqli_query($koneksi, $query_projek);

// Ambil seluruh penilaian
$query_penilaian = "
  SELECT pf.*, u.nama AS nama_dosen
  FROM penilaian_portofolio pf
  JOIN users u ON pf.dosen_id = u.id
  WHERE pf.mahasiswa_id = '$user_id'
  ORDER BY pf.id_penilaian DESC
";
$result_penilaian = mysqli_query($koneksi, $query_penilaian);

// Ambil penilaian dosen yang login
$query_history_penilaian_dosen = "
  SELECT pf.*, u.nama AS nama_dosen
  FROM penilaian_portofolio pf
  JOIN users u ON pf.dosen_id = u.id
  WHERE pf.mahasiswa_id = '$user_id'
  AND pf.dosen_id = '$dosen_id'
  ORDER BY pf.id_penilaian DESC
";
$result_history_penilaian_dosen = mysqli_query($koneksi, $query_history_penilaian_dosen);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PortoPBL</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../custom.css">
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

    <?php include '../layouts/navbar_dosen.php'; ?>

    <div class="container py-4 mt-5 pt-5">
        <div class="row align-items-center">
            <div class="col-md-4 text-center">
                <div class="ratio ratio-1x1 rounded-circle overflow-hidden mx-auto mb-2" style="width:200px;">
                    <img src="<?= $foto ?>" class="w-100 h-100" style="object-fit:cover;">
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

            <div class="col-md-8">
                <div class="bg-footer p-3 rounded mb-4">
                    <h5 class="fw-bold text-white">Tentang Mahasiswa</h5>
                    <p class="text-white mb-0">
                        <?= $user['deskripsi_diri'] ?: 'Belum Ada Deskripsi Apapun' ?>
                    </p>
                </div>

                <div class="bg-footer p-3 rounded">
                    <h5 class="fw-bold text-white">Catatan Prestasi</h5>
                    <p class="text-white">
                        <?= $user['prestasi'] ?: 'Belum Ada Prestasi Apapun' ?>
                    </p>
                </div>
            </div>
        </div>

        <?php if (mysqli_num_rows($result_projek) > 0): ?>
        <?php while ($projek = mysqli_fetch_assoc($result_projek)): ?>
        <div class="bg-footer p-4 rounded mt-4">
            <h5 class="fw-bold text-white text-center mb-3">Proyek</h5>

            <div class="mb-3">
                <label class="form-label text-white fw-semibold">Judul Proyek</label>
                <div class="form-control bg-light">
                    <?= htmlspecialchars($projek['judul']) ?>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label text-white fw-semibold">Deskripsi Proyek</label>
                <div class="form-control bg-light">
                    <?= htmlspecialchars($projek['deskripsi']) ?>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label text-white fw-semibold">Tautan Repositori</label>
                <div class="form-control bg-light">
                    <a href="<?= htmlspecialchars($projek['link_repo']) ?>" target="_blank">
                        <?= htmlspecialchars($projek['link_repo']) ?>
                    </a>
                </div>
            </div>
            <div class="row g-3">

                <!-- Video -->
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

                <!-- Foto -->
                <div class="col-md-6">
                    <div class="bg-light border p-3 text-center rounded">
                        <span class="fw-semibold text-muted">Foto</span><br>
                        <?php if (!empty($projek['gambar_projek'])): ?>
                        <img src="../asset/uploads/<?= htmlspecialchars($projek['gambar_projek']) ?>"
                            class="img-fluid rounded mt-2">
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
        <?php endwhile; ?>
        <?php else: ?>
        <p class="text-center fw-semibold mt-4">
            Mahasiswa belum mengunggah projek apapun.
        </p>
        <?php endif; ?>

        <div class="bg-footer p-4 rounded mt-4">
            <h5 class="fw-bold text-white text-center mb-3">Penilaian Profil Mahasiswa</h5>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label text-white">Komentar</label>
                    <textarea name="komentar" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label text-white">Nilai (0 - 100)</label>
                    <input type="number" name="nilai" class="form-control" min="0" max="100" required>
                </div>

                <button type="submit" name="simpan_penilaian" class="btn btn-light fw-semibold">
                    Simpan Penilaian
                </button>
            </form>
        </div>

    </div>

    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>