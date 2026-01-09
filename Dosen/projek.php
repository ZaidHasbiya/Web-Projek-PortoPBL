<?php
/**
 * File: projek.php
 * Fungsi: Menampilkan daftar projek mahasiswa untuk dosen, dengan fitur pencarian berdasarkan nama atau username mahasiswa.
 * Pembuat: Zaid Hasbiya Abrar - NIM : [3312501046]
 * Waktu Pembuatan: 26 Desember 2025
 */

session_start(); // Memulai session untuk mengecek status login
include '../koneksi.php'; // Menghubungkan ke database

// Fungsi SweetAlert redirect (Sesuai struktur file lainnya)
function redirect_alert($icon, $title, $url) {
    $_SESSION['alert'] = [
        'icon' => $icon,
        'title' => $title,
        'url' => $url
    ];
}

// Mengecek apakah user sudah login
if(!isset($_SESSION['username'])){
    header("Location: ../login.php");
    exit;
}

// Mengecek apakah user memiliki role 'dosen'
if ($_SESSION['role'] !== 'dosen') {
    redirect_alert('error', 'Akses Ditolak!', '../login.php');
}

// Jumlah data yang ditampilkan per halaman
$limit = 6;

// Menentukan halaman aktif dari parameter URL
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = ($page < 1) ? 1 : $page;

// Menghitung offset data untuk pagination
$offset = ($page - 1) * $limit;

// Query untuk menghitung total jumlah projek
$total_query = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM projek"
);

// Mengambil total data projek
$total_data = mysqli_fetch_assoc($total_query)['total'];

// Menghitung total halaman
$total_page = ceil($total_data / $limit);

// Query untuk mengambil data projek beserta data mahasiswa pembuatnya
$query = "SELECT projek.*, users.nama, users.username 
          FROM projek 
          JOIN users ON projek.user_id = users.id 
          ORDER BY projek.judul ASC
          LIMIT $limit OFFSET $offset";

// Menjalankan query data projek
$data = mysqli_query($koneksi, $query);

// Menghitung jumlah data yang ditampilkan
$result = mysqli_num_rows($data);

// Jika form pencarian dikirim
if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($koneksi, $_POST['keyword']); // Mengamankan input dari SQL injection

    // Query pencarian berdasarkan nama atau username mahasiswa
    $query = "SELECT projek.*, users.nama, users.username 
              FROM projek
              JOIN users ON projek.user_id = users.id
              WHERE users.nama LIKE '%$keyword%'
                 OR users.username LIKE '%$keyword%'
              ORDER BY projek.projek_id DESC";

    $data = mysqli_query($koneksi, $query);
    $result = mysqli_num_rows($data);
}
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
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <link rel="stylesheet" href="../styles.css" type="text/css">
    <link rel="stylesheet" href="../custom.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<style>
.card-text {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;

    line-clamp: 3;
    overflow: hidden;
}
</style>

<body>

    <?php include '../layouts/navbar_dosen.php'; ?>

    <div class="container">

        <div class="d-flex justify-content-between align-items-center my-5">
            <h1 class="my-5">Projek</h1>

            <form class="d-flex" method="POST">
                <input class="form-control me-2" type="text" placeholder="Cari Mahasiswa" name="keyword">
                <button class="btn btn-clr" type="submit" name="cari">Cari</button>
            </form>
        </div>

        <?php if ($result > 0 ): ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while($row = mysqli_fetch_assoc($data)) :?>
            <div class="col">
                <div class="card border border-info h-100 d-flex flex-column">

                    <div class="ratio ratio-16x9 overflow-hidden">
                        <img src="../asset/uploads/<?= htmlspecialchars($row['gambar_projek']); ?>"
                            class="w-100 h-100 object-fit-cover" alt="Projek Web Portofolio PBL">
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= $row['judul']; ?></h5>
                        <p class="card-text">Deskripsi Projek : <?= $row['deskripsi']; ?></p>
                        <p class="card-text">Dibuat Oleh :</p>
                        <p class="card-text">Nama Mahasiswa : <?= $row['nama']; ?></p>
                        <p class="card-text">NIM : <?= $row['username']; ?></p>

                        <a href="lihat_projek_dosen.php?projek_id=<?= $row['projek_id']; ?>"
                            class="btn btn-outline-info rounded-pill d-flex justify-content-center mt-auto">
                            Lihat Projek
                        </a>

                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <?php if ($total_page > 1 && !isset($_POST['cari'])): ?>
        <nav class="d-flex justify-content-center mt-5">
            <ul class="pagination">

                <!-- Prev -->
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">Sebelumnya</a>
                </li>

                <?php
        $start = max(1, $page - 2);
        $end   = min($total_page, $page + 2);

        for ($i = $start; $i <= $end; $i++):
        ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>

                <!-- Next -->
                <li class="page-item <?= ($page >= $total_page) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">Selanjutnya</a>
                </li>

            </ul>
        </nav>
        <?php endif; ?>


        <?php else : ?>
        <h2>Belum ada projek</h2>
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
    // SweetAlert Handling (Sesuai struktur file lainnya)
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
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    </script>
</body>

</html>