<?php
/*
Nama File   : jurusan_mb.php
Deskripsi   : Menampilkan daftar mahasiswa jurusan Manajemen Bisnis
              dengan fitur pagination
Dibuat Oleh : Reifandra Kinadi - NIM : [3312501048]
Tanggal     : 10 Oktober 2025
*/

include '../koneksi.php';

session_start();
// Memulai session untuk validasi login

// Validasi login dan role mahasiswa
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'mahasiswa') {
    // Menggunakan session untuk mengirim pesan error ke SweetAlert di bawah
    $_SESSION['auth_error'] = 'Maaf, anda bukan mahasiswa. Silakan login ulang.';
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
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <link rel="stylesheet" href="../styles.css" type="text/css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<style>
html,
body {
    height: 100%;
}

body {
    display: flex;
    flex-direction: column;
}

.container {
    flex: 1;
}
</style>

<body>

    <?php include '../layouts/navbar_mhs.php'; ?>

    <div class="container">
        <h1 class="my-5 pt-5">Jurusan Manajemen Bisnis</h1>

        <?php if (mysqli_num_rows($data) > 0): ?>
        <div class="d-flex flex-wrap justify-content-evenly align-items-start gap-4">

            <?php while ($row = mysqli_fetch_assoc($data)): ?>
            <?php
            // Menentukan foto profil mahasiswa
            $foto = !empty($row['foto_profil'])
                    ? "../asset/profil/" . $row['foto_profil']
                    : "../tim/profil-kosong.jpeg";
          ?>

            <div class="col-md-4 col-lg-3">
                <div class="card shadow-sm border-0 h-100">

                    <div class="ratio ratio-1x1">
                        <img src="<?= $foto ?>" class="card-img-top rounded-2" alt="Foto Mahasiswa"
                            style="object-fit: cover;">
                    </div>

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
                    </div>

                </div>
            </div>

            <?php endwhile; ?>
        </div>

        <?php if ($totalPage > 1): ?>
        <nav class="d-flex justify-content-center mt-5">
            <ul class="pagination">

                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">
                        Sebelumnya
                    </a>
                </li>

                <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
                <?php endfor; ?>

                <li class="page-item <?= ($page >= $totalPage) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">
                        Selanjutnya
                    </a>
                </li>

            </ul>
        </nav>
        <?php endif; ?>

        <?php else: ?>
        <h2>Belum ada mahasiswa</h2>
        <?php endif; ?>
    </div>

    <div class="overflow mt-5">
        <img src="../asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave">
    </div>

    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <script src="../js/bootstrap.bundle.min.js"></script>
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
    </script>
</body>

</html>