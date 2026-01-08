<?php
/*
Nama File   : lihat_profil_mhs.php
Deskripsi     : Menampilkan profil mahasiswa, proyek yang diunggah,
              serta riwayat penilaian portofolio dari dosen
Dibuat Oleh    : Reifandra Kinadi - NIM : [3312501047]
Tanggal     : 10 Oktober 2025
*/

session_start();
// Memulai session untuk mengecek status login

include '../koneksi.php';
// Menghubungkan ke database

// Fungsi SweetAlert redirect
function redirect_alert($icon, $title, $url) {
    $_SESSION['alert'] = [
        'icon' => $icon,
        'title' => $title,
        'url' => $url
    ];
}

// Validasi apakah user sudah login
if (!isset($_SESSION['username'])) {
    redirect_alert('error', 'Silakan login terlebih dahulu', '../login.php');
}

// Validasi role mahasiswa
if (isset($_SESSION['role']) && $_SESSION['role'] !== 'mahasiswa') {
    redirect_alert('error', 'Anda tidak memiliki akses!', '../login.php');
}

// Validasi parameter ID mahasiswa
if (!isset($_GET['id']) && !isset($_SESSION['alert'])) {
    redirect_alert('warning', 'Mahasiswa tidak ditemukan', 'index_mahasiswa.php');
}

// Mengambil ID mahasiswa dari URL
$user_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($user_id) {
    // Query mengambil data mahasiswa
    $query_user = "SELECT * FROM users WHERE id = '$user_id'";
    $result_user = mysqli_query($koneksi, $query_user);
    $user = mysqli_fetch_assoc($result_user);

    // Menentukan foto profil (default jika kosong)
    $foto = !empty($user['foto_profil']) 
            ? '../asset/profil/' . $user['foto_profil'] 
            : '../tim/profil-kosong.jpeg';

    // Validasi data mahasiswa
    if (!$user) {
        redirect_alert('warning', 'Mahasiswa tidak ditemukan', 'index_mahasiswa.php');
    }

    // Query mengambil proyek milik mahasiswa
    $query_projek = "SELECT * FROM projek WHERE user_id = '$user_id'";
    $result_projek = mysqli_query($koneksi, $query_projek);

    //Query mengambil riwayat penilaian portofolio dan menggabungkan tabel penilaian_portofolio dan users (dosen)
    $query_penilaian = "
    SELECT pf.*, u.nama AS nama_dosen
    FROM penilaian_portofolio pf
    JOIN users u ON pf.dosen_id = u.id
    WHERE pf.mahasiswa_id = '$user_id'
    ORDER BY pf.id_penilaian DESC
    ";
    $result_penilaian = mysqli_query($koneksi, $query_penilaian);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PortoPBL</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700;900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <link rel="stylesheet" href="../styles.css" type="text/css">
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

    <?php include '../layouts/navbar_mhs.php'; ?>

    <?php if (isset($user)): ?>
    <div class="container py-4 mt-5 pt-5">
        <div class="row align-items-center">

            <div class="col-md-4 text-center">
                <div class="ratio ratio-1x1 rounded-circle overflow-hidden mx-auto mb-2" style="width: 200px;">
                    <img src="<?= $foto ?>" alt="Foto Mahasiswa" class="w-100 h-100" style="object-fit: cover;">
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
                    <div class="form-control bg-light mt-2">
                        <?= $user['deskripsi_diri'] ?: 'Belum Ada Deskripsi Apapun' ?>
                    </div>
                </div>

                <div class="bg-footer p-3 rounded">
                    <h5 class="fw-bold text-white">Catatan Prestasi</h5>
                    <div class="form-control bg-light mt-2">
                        <?= $user['prestasi'] ?: 'Belum Ada Prestasi Apapun' ?>
                    </div>
                </div>
            </div>

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

                    <div class="form-control bg-light"
                        style="min-height:100px; overflow-wrap:break-word;">
                        <?= nl2br(htmlspecialchars($projek['deskripsi'])) ?>
                    </div>
                </div>


                <div class="mb-4">
                    <label class="form-label fw-semibold text-white">Tautan Repositori</label>
                    <div class="form-control bg-light">
                        <a href="<?= htmlspecialchars($projek['link_repo']); ?>" target="_blank">
                            <?= htmlspecialchars($projek['link_repo']); ?>
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

            <div class="container mt-4 mb-5 px-0">
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
        <?php endif; ?>

    </div>
    <div class="container-fluid px-0" style="margin-top: 5rem;">
        <img src="../asset/wave-new-navy.svg" class="img-fluid d-block"
            style="width: 100%; min-width: 100vw; margin-bottom: -1px;" alt="wave">
    </div>

    <footer class="text-center py-3"
        style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0; position: relative; z-index: 2;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <script src="../js/bootstrap.bundle.min.js"></script>

    <script>
    // SweetAlert Handling
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