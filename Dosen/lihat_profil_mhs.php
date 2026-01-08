<?php
/*
Nama File : lihat_profil_mhs.php
Deskripsi :
Halaman ini digunakan oleh dosen untuk melihat detail profil mahasiswa,
daftar proyek mahasiswa, serta memberikan dan melihat penilaian portofolio.
*/

session_start();
include '../koneksi.php';

// Fungsi SweetAlert redirect (Ditambahkan untuk standarisasi)
function redirect_alert($icon, $title, $url) {
    $_SESSION['alert'] = [
        'icon' => $icon,
        'title' => $title,
        'url' => $url
    ];
}

// Cek login
if (!isset($_SESSION['username'])) {
    redirect_alert('warning', 'Silakan login terlebih dahulu', '../login.php');
    header("Location: ../login.php");
    exit;
}

// Cek role dosen
if ($_SESSION['role'] !== 'dosen') {
    redirect_alert('error', 'Anda tidak memiliki akses!', '../login.php');
    header("Location: ../login.php");
    exit;
}

// Cek ID mahasiswa
if (!isset($_GET['id'])) {
    redirect_alert('error', 'Mahasiswa tidak ditemukan', 'index_dosen.php');
    header("Location: index_dosen.php");
    exit;
}

$user_id  = $_GET['id'];
$dosen_id = $_SESSION['id'];

// Ambil data mahasiswa
$query_user  = "SELECT * FROM users WHERE id = '$user_id'";
$result_user = mysqli_query($koneksi, $query_user);
$user        = mysqli_fetch_assoc($result_user);

if (!$user) {
    redirect_alert('error', 'Mahasiswa tidak ditemukan', 'index_dosen.php');
    header("Location: index_dosen.php");
    exit;
}

// Foto profil
$foto = !empty($user['foto_profil'])
  ? '../asset/profil/' . $user['foto_profil']
  : '../tim/profil-kosong.jpeg';

// Simpan penilaian
if (isset($_POST['simpan_penilaian'])) {
  $komentar = mysqli_real_escape_string($koneksi, $_POST['komentar']);
  $nilai    = (int) $_POST['nilai'];

  $insert_penilaian = "
    INSERT INTO penilaian_portofolio 
    (mahasiswa_id, dosen_id, komentar, nilai)
    VALUES ('$user_id', '$dosen_id', '$komentar', '$nilai')
  ";

  if (mysqli_query($koneksi, $insert_penilaian)) {
      redirect_alert('success', 'Penilaian berhasil disimpan', "lihat_profil_mhs.php?id=$user_id");
  } else {
      redirect_alert('error', 'Gagal menyimpan penilaian', "lihat_profil_mhs.php?id=$user_id");
  }
  header("Location: lihat_profil_mhs.php?id=$user_id");
  exit;
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../custom.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<style>
.bg-footer {
    background-color: #1f4f73;
    border-radius: 6px;
}
.bg-footer h5,
.bg-footer label,
.bg-footer strong {
    color: #e9e1c9 !important;
}

.bg-footer .form-control,
.bg-footer p,
.bg-footer div,
.bg-footer .card-text {
    color: #2d3748 !important;
}

.bg-footer .form-control {
    background-color: #ffffff !important;
}

.bg-footer a {
    color: inherit;
}

.bg-footer .form-control a {
    color: #0d6efd !important;
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
               <!-- Tentang mahasiswa -->
                <div class="bg-footer p-3 rounded mb-4">
                    <h5 class="fw-bold text-white">Tentang Mahasiswa</h5>
                    <div class="form-control bg-light mt-2">
                        <?= $user['deskripsi_diri'] ?: 'Belum Ada Deskripsi Apapun' ?>
                    </div>
                </div>

                <!-- Catatan prestasi -->
                <div class="bg-footer p-3 rounded">
                    <h5 class="fw-bold text-white">Catatan Prestasi</h5>
                    <div class="form-control bg-light mt-2">
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

            <div class="mb-4">
                <label class="form-label fw-semibold text-white">Deskripsi Proyek</label>
                <div class="form-control bg-light" style="min-height:100px; overflow-wrap:break-word;">
                    <?= nl2br(htmlspecialchars($projek['deskripsi'])) ?>
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
                <div class="col-md-6">
                    <div class="bg-light border p-3 text-center rounded">
                        <span class="fw-semibold" style="color:#000;">Video</span>
                        <?php if (!empty($projek['link'])): ?>
                        <div class="ratio ratio-16x9 mt-2">
                            <iframe src="<?= htmlspecialchars($projek['link']) ?>" allowfullscreen></iframe>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="bg-light border p-3 text-center rounded">
                        <span class="fw-semibold" style="color:#000;">Foto</span>
                        <br>
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
    </div>

    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <script src="../js/bootstrap.bundle.min.js"></script>

    <script>
    // Logic SweetAlert
    <?php if (isset($_SESSION['alert'])): ?>
    Swal.fire({
        icon: '<?= $_SESSION['alert']['icon']; ?>',
        title: '<?= $_SESSION['alert']['title']; ?>',
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        window.location.href = '<?= $_SESSION['alert']['url']; ?>';
    });
    <?php unset($_SESSION['alert']); endif; ?>
    </script>
</body>

</html>