<?php
/*
Nama File   : jurusan_mb.php
Deskripsi   : Menampilkan daftar mahasiswa jurusan Manajemen Bisnis
<<<<<<< HEAD
              dengan fitur pagination
=======
              dengan fitur pagination dan SweetAlert
>>>>>>> bf556ff (Merubah seluruh desain web)
Dibuat Oleh : Reifandra Kinadi - NIM : [3312501048]
Tanggal     : 10 Oktober 2025
*/

include '../koneksi.php';
session_start();

// Fungsi SweetAlert redirect jika akses ditolak
function redirect_alert($icon, $title, $url) {
    $_SESSION['alert'] = [
        'icon' => $icon,
        'title' => $title,
        'url' => $url
    ];
}

// Validasi login dan role mahasiswa
<<<<<<< HEAD
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'mahasiswa') {
    // Menggunakan session untuk mengirim pesan error ke SweetAlert di bawah
    $_SESSION['auth_error'] = 'Maaf, anda bukan mahasiswa. Silakan login ulang.';
=======
if (!isset($_SESSION['username'])) {
    redirect_alert('error', 'Silakan login terlebih dahulu!', '../login.php');
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if ($_SESSION['role'] !== 'mahasiswa') {
    redirect_alert('error', 'Maaf, anda bukan mahasiswa. Silakan login ulang.', '../login.php');
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
>>>>>>> bf556ff (Merubah seluruh desain web)
}

// Mengambil ID user dari session
$user_id = $_SESSION['id'];

// Konfigurasi pagination
$limit  = 6;
$page   = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page   = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

// Query mengambil data mahasiswa jurusan Manajemen Bisnis
$query = "SELECT * FROM users 
          WHERE jurusan = 'manajemen bisnis' 
          AND role = 'mahasiswa'
          LIMIT $limit OFFSET $offset";

$data = mysqli_query($koneksi, $query);

// Query menghitung total mahasiswa
$totalQuery = "SELECT COUNT(*) AS total 
               FROM users 
               WHERE jurusan = 'manajemen bisnis' 
               AND role = 'mahasiswa'";

$totalResult = mysqli_query($koneksi, $totalQuery);
$totalRow    = mysqli_fetch_assoc($totalResult);
$totalData   = $totalRow['total'];
$totalPage   = ceil($totalData / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PortoPBL</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700;900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrap.min.css">
<<<<<<< HEAD

=======
>>>>>>> bf556ff (Merubah seluruh desain web)
    <link rel="stylesheet" href="../styles.css" type="text/css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<style>
html, body { height: 100%; }
body { display: flex; flex-direction: column; }
.container { flex: 1; }
.card { transition: transform 0.3s ease; }
</style>

<body>

    <?php include '../layouts/navbar_mhs.php'; ?>

    <div class="container">
        <h1 class="my-5 pt-5">Jurusan Manajemen Bisnis</h1>

        <?php if (mysqli_num_rows($data) > 0): ?>
        <div class="d-flex flex-wrap justify-content-evenly align-items-start gap-4">

            <?php while ($row = mysqli_fetch_assoc($data)): ?>
            <?php
            $foto = !empty($row['foto_profil'])
                    ? "../asset/profil/" . $row['foto_profil']
                    : "../tim/profil-kosong.jpeg";
            ?>
            <div class="col-md-4 col-lg-3">
                <div class="card shadow-sm border-0 h-100">
<<<<<<< HEAD

=======
>>>>>>> bf556ff (Merubah seluruh desain web)
                    <div class="ratio ratio-1x1">
                        <img src="<?= $foto ?>" class="card-img-top rounded-2" alt="Foto Mahasiswa" style="object-fit: cover;">
                    </div>
<<<<<<< HEAD

                    <div class="card-body text-center">
                        <p class="mb-1">
                            <strong>Nama:</strong> <?= $row['nama']; ?>
                        </p>
                        <p class="mb-1">
                            <strong>NIM:</strong> <?= $row['username']; ?>
                        </p>
                        <p class="mb-3">
                            <strong>Jurusan:</strong> <?= $row['jurusan']; ?>
                        </p>

                        <a href="lihat_profil_mhs.php?id=<?= $row['id']; ?>" class="btn btn-clr px-4">
                            Lihat Profil
                        </a>
=======
                    <div class="card-body text-center">
                        <p class="mb-1"><strong>Nama:</strong> <?= htmlspecialchars($row['nama']); ?></p>
                        <p class="mb-1"><strong>NIM:</strong> <?= htmlspecialchars($row['username']); ?></p>
                        <p class="mb-3"><strong>Jurusan:</strong> <?= htmlspecialchars($row['jurusan']); ?></p>
                        <a href="lihat_profil_mhs.php?id=<?= $row['id']; ?>" class="btn btn-clr px-4">Lihat Profil</a>
>>>>>>> bf556ff (Merubah seluruh desain web)
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <?php if ($totalPage > 1): ?>
        <nav class="d-flex justify-content-center mt-5">
            <ul class="pagination">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">Sebelumnya</a>
                </li>
                <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>
                <li class="page-item <?= ($page >= $totalPage) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">Selanjutnya</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>

        <?php else: ?>
        <div class="text-center py-5">
            <h2>Belum ada mahasiswa</h2>
        </div>
        <?php endif; ?>
    </div>

    <div class="overflow mt-5">
        <img src="../asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave">
    </div>

    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <script src="../js/bootstrap.bundle.min.js"></script>
<<<<<<< HEAD
    <script>
    // Logic SweetAlert untuk validasi akses
    <?php if (isset($_SESSION['auth_error'])): ?>
        Swal.fire({
            icon: 'error',
            title: 'Akses Ditolak',
            text: '<?= $_SESSION['auth_error']; ?>',
            confirmButtonColor: '#3085d6'
        }).then((result) => {
            window.location.href = '../login.php';
        });
        <?php unset($_SESSION['auth_error']); ?>
    <?php endif; ?>

=======

    <script>
    // SweetAlert Login & Role Validation
    <?php if (isset($_SESSION['alert'])): ?>
    Swal.fire({
        icon: '<?= $_SESSION['alert']['icon']; ?>',
        title: '<?= $_SESSION['alert']['title']; ?>',
        showConfirmButton: true,
        confirmButtonColor: '#3085d6'
    }).then(() => {
        window.location.href = '<?= $_SESSION['alert']['url']; ?>';
    });
    <?php unset($_SESSION['alert']); endif; ?>

    // Smooth Scrolling
>>>>>>> bf556ff (Merubah seluruh desain web)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
<<<<<<< HEAD

    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
            this.style.transition = 'transform 0.3s ease';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
=======

    // Card Hover Effect
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', function() { this.style.transform = 'translateY(-8px)'; });
        card.addEventListener('mouseleave', function() { this.style.transform = 'translateY(0)'; });
>>>>>>> bf556ff (Merubah seluruh desain web)
    });
    </script>
</body>
</html>
