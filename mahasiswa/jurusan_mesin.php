<?php
/*
Nama File   : jurusan_mesin.php
Deskripsi   : Menampilkan daftar mahasiswa jurusan Teknik Mesin dengan sistem pagination
Dibuat Oleh : Reifandra Kinadi - NIM : [3312501048]
Tanggal     : 10 Oktober 2025
*/

session_start();
include '../koneksi.php';

<<<<<<< HEAD
// Fungsi SweetAlert redirect
function redirect_alert($icon, $title, $url) {
    $_SESSION['alert'] = [
        'icon' => $icon,
        'title' => $title,
        'url' => $url
    ];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Validasi login dan role mahasiswa
if (!isset($_SESSION['username'])) {
    // Karena ini file utama, kita arahkan ke login jika belum login
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['role'] !== 'mahasiswa') {
    // Jika role bukan mahasiswa, gunakan SweetAlert untuk memberitahu
    $_SESSION['alert'] = [
        'icon' => 'error',
        'title' => 'Akses Ditolak!',
        'url' => '../login.php'
    ];
}
=======
session_start();
// Memulai session untuk validasi login

// Validasi login dan role mahasiswa menggunakan SweetAlert
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'mahasiswa') {
    $_SESSION['alert'] = [
        'icon' => 'error',
        'title' => 'Maaf, anda bukan mahasiswa. Silakan login ulang.',
        'url' => '../login.php'
    ];
}

// Mengambil ID user dari session
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
>>>>>>> bf556ff (Merubah seluruh desain web)

// Konfigurasi pagination
$limit  = 6;
$page   = isset($_GET['page']) ? (int)$GET['page'] : 1;
$page   = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

// Query mengambil data mahasiswa jurusan Teknik Mesin
$query = "SELECT * FROM users 
          WHERE jurusan = 'teknik mesin' 
          AND role = 'mahasiswa'
          LIMIT $limit OFFSET $offset";
$data = mysqli_query($koneksi, $query);

// Query menghitung total data mahasiswa
$totalQuery = "SELECT COUNT(*) AS total 
               FROM users 
               WHERE jurusan = 'teknik mesin' 
               AND role = 'mahasiswa'";
$totalResult = mysqli_query($koneksi, $totalQuery);
$totalRow    = mysqli_fetch_assoc($totalResult);
$totalData   = $totalRow['total'];
$totalPage   = ceil($totalData / $limit);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PortoPBL - Jurusan Teknik Mesin</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <link rel="stylesheet" href="../styles.css" type="text/css">
<<<<<<< HEAD
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        html, body { height: 100%; }
        body { display: flex; flex-direction: column; }
        .content-wrapper { flex: 1; }
        .card { transition: transform 0.3s ease; }
        .card:hover { transform: translateY(-8px); }
    </style>
=======

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
>>>>>>> bf556ff (Merubah seluruh desain web)
</head>

<body>

    <?php include '../layouts/navbar_mhs.php'; ?>

<<<<<<< HEAD
    <div class="container content-wrapper py-4 mt-5">
        <h1 class="my-5 pt-3 fw-bold">Jurusan Teknik Mesin</h1>
=======
    <div class="container">
        <h1 class="my-5 pt-5">Jurusan Teknik Mesin</h1>
>>>>>>> bf556ff (Merubah seluruh desain web)

        <?php if (mysqli_num_rows($data) > 0): ?>
        <div class="row g-4">
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
                        <img src="<?= $foto ?>" class="card-img-top rounded-top" alt="Foto Mahasiswa" style="object-fit: cover;">
                    </div>

                    <div class="card-body text-center">
                        <p class="mb-1 text-truncate"><strong>Nama:</strong> <?= htmlspecialchars($row['nama']); ?></p>
                        <p class="mb-1"><strong>NIM:</strong> <?= htmlspecialchars($row['username']); ?></p>
                        <p class="mb-3"><strong>Jurusan:</strong> <?= htmlspecialchars($row['jurusan']); ?></p>

<<<<<<< HEAD
                        <a href="lihat_profil_mhs.php?id=<?= $row['id']; ?>" class="btn btn-clr px-4 w-100">
=======
                        <a href="lihat_profil_mhs.php?id=<?= $row['id']; ?>" class="btn btn-clr px-4">
>>>>>>> bf556ff (Merubah seluruh desain web)
                            Lihat Profil
                        </a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <?php if ($totalPage > 1): ?>
        <nav class="d-flex justify-content-center mt-5">
            <ul class="pagination shadow-sm">
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
        <div class="alert alert-info text-center py-5 shadow-sm">
            <i class="fa-solid fa-user-slash fa-3x mb-3 text-muted"></i>
            <h3>Belum ada mahasiswa di jurusan ini.</h3>
        </div>
        <?php endif; ?>
    </div>

<<<<<<< HEAD
    <div class="overflow-hidden mt-5">
=======
    <div class="overflow mt-5">
>>>>>>> bf556ff (Merubah seluruh desain web)
        <img src="../asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave">
    </div>

    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <script src="../js/bootstrap.bundle.min.js"></script>
<<<<<<< HEAD

    <script>
    // SweetAlert2 Logic
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
=======

    <script>
    // SweetAlert2 Logic
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

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
            this.style.transition = 'transform 0.3s ease';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
>>>>>>> bf556ff (Merubah seluruh desain web)
    </script>
</body>
</html>