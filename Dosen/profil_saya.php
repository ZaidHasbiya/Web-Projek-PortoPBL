<?php
/**
 * File: profil_saya.php
 * Fungsi: Menampilkan halaman profil dosen dengan foto, identitas, jurusan, dan catatan prestasi.
 * Pembuat: Zaid Hasbiya Abrar
 * Waktu Pembuatan: 26 Desember 2025
 */

session_start(); // Memulai session untuk mengecek login user
include '../koneksi.php'; // Menghubungkan ke database

// Fungsi SweetAlert redirect (Ditambahkan untuk standarisasi alert)
function redirect_alert($icon, $title, $url) {
    $_SESSION['alert'] = [
        'icon' => $icon,
        'title' => $title,
        'url' => $url
    ];
}

// Mengecek apakah user sudah login
if (!isset($_SESSION['username'])) {
    redirect_alert('warning', 'Username tidak sesuai! Silakan login.', '../login.php');
    header("Location: ../login.php");
    exit;
}

// Mengecek apakah user memiliki role dosen
if ($_SESSION['role'] !== 'dosen') {
    redirect_alert('error', 'Maaf, anda bukan dosen. Silakan login ulang.', '../login.php');
    header("Location: ../login.php");
    exit; // Menghentikan eksekusi script jika bukan dosen
}

$nama = $_SESSION['nama']; // Mengambil nama user dari session

// Query untuk mengambil data user berdasarkan nama
$query = "SELECT * FROM users WHERE nama = '$nama'";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result); // Mengambil hasil query sebagai array associative

// Menentukan foto profil, jika kosong gunakan default
$foto = !empty($user['foto_profil']) 
        ? '../asset/profil/' . $user['foto_profil'] 
        : '../tim/profil-kosong.jpeg';
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <link rel="stylesheet" href="../styles.css" type="text/css">
    <link rel="stylesheet" href="../custom.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<style>
.bg-footer {
    background-color: #1D5D8C !important;
    color: white !important;
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
}

body {
    background: #fdf6e3 !important;
}

.bg-footer h5,
.bg-footer strong {
    color: #e9e1c9 !important;
}

.bg-footer p {
    color: #2d3748 !important;
}
</style>

<body>

    <?php include '../layouts/navbar_dosen.php'; ?>

    <div class="container my-5 mt-5 pt-5">
        <div class="row align-items-center">

            <div class="col-md-4 text-center">

                <div class="ratio ratio-1x1 rounded-circle overflow-hidden mx-auto mb-2" style="width: 200px;">
                    <img src="<?= $foto ?>" alt="Foto Dosen" class="w-100 h-100" style="object-fit: cover;">
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
                    <h5 class="fw-bold text-white">Tentang Dosen</h5>

                    <div class="form-control bg-light mt-2" style="min-height: 90px;">
                        <?= !empty($user['deskripsi_diri']) 
            ? nl2br(htmlspecialchars($user['deskripsi_diri'])) 
            : 'Belum ada deskripsi apapun.' ?>
                    </div>
                </div>


                <div class="bg-footer p-3 rounded">
                    <h5 class="fw-bold text-white">Catatan Prestasi</h5>

                    <div class="form-control bg-light mt-2" style="min-height: 90px;">
                        <?= !empty($user['prestasi']) 
            ? nl2br(htmlspecialchars($user['prestasi'])) 
            : 'Belum ada catatan prestasi.' ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="overflow-hidden mt-5">
        <img src="../asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave">
    </div>

    <section class="bg-footer">
        <br><br><br>
    </section>

    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <script src="../js/bootstrap.bundle.min.js"></script>

    <script>
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