<?php
/**
 * File: projek.php
 * Fungsi: Menampilkan daftar projek mahasiswa untuk dosen, dengan fitur pencarian berdasarkan nama atau username mahasiswa.
 * Pembuat: Zaid Hasbiya Abrar - NIM : [3312501046]
 * Waktu Pembuatan: 26 Desember 2025
 */

session_start(); // Memulai session untuk mengecek status login
include '../koneksi.php'; // Menghubungkan ke database

// Mengecek apakah user sudah login
if(!isset($_SESSION['username'])){
    echo "<script>alert('Silahkan Melakukan Login Terlebih Dahulu'); window.location.href = '../login.php';</script>";
    exit;
}

// Mengecek apakah user memiliki role 'dosen'
if ($_SESSION['role'] !== 'dosen') {
    echo "<script>
            alert('Maaf, anda bukan dosen. Silakan login ulang.');
            window.location.href = '../login.php';
          </script>";
    exit;
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

$data = mysqli_query($koneksi, $query); // Eksekusi query
$result = mysqli_num_rows($data); // Menghitung jumlah projek

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
} else {
    // Query default jika tidak melakukan pencarian
    $query = "SELECT projek.*, users.nama, users.username 
              FROM projek 
              JOIN users ON projek.user_id = users.id 
              ORDER BY projek.judul ASC";

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

    <!-- Google Fonts Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="../styles.css" type="text/css">
    <link rel="stylesheet" href="../custom.css">
</head>

<style>
/* Styling navbar brand */
.navbar-brand img {
    width: 80px;
    height: 80px;
    margin-right: 12px;
}

.navbar-brand {
    font-size: 1.2rem;
}
</style>

<body>

    <!-- ===== Navbar dosen ===== -->
    <?php include '../layouts/navbar_dosen.php'; ?>

    <!-- Container utama projek -->
    <div class="container">

        <!-- Header dan form pencarian -->
        <div class="d-flex justify-content-between align-items-center my-5">
            <h1 class="my-5">Projek</h1>

            <!-- Form pencarian mahasiswa -->
            <form class="d-flex" method="POST">
                <input class="form-control me-2" type="text" placeholder="Cari Mahasiswa" name="keyword">
                <button class="btn btn-clr" type="submit" name="cari">Cari</button>
            </form>
        </div>

        <!-- Menampilkan projek jika ada -->
        <?php if ($result > 0 ): ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while($row = mysqli_fetch_assoc($data)) :?>
            <div class="col">
               <div class="card border border-info h-100 d-flex flex-column">

                    <!-- Gambar projek -->
                    <div class="ratio ratio-16x9 overflow-hidden">
                        <img src="../asset/uploads/<?= htmlspecialchars($row['gambar_projek']); ?>"
                            class="w-100 h-100 object-fit-cover" alt="Projek Web Portofolio PBL">
                    </div>

                    <!-- Konten projek -->
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['judul']; ?></h5>
                        <p class="card-text">Deskripsi Projek : <?= $row['deskripsi']; ?></p>
                        <p class="card-text">Dibuat Oleh :</p>
                        <p class="card-text">Nama Mahasiswa : <?= $row['nama']; ?></p>
                        <p class="card-text">NIM : <?= $row['username']; ?></p>

                        <!-- Tombol untuk melihat projek detail -->
                        <a href="lihat_projek_dosen.php?projek_id=<?= $row['projek_id']; ?>"
                            class="btn btn-outline-info rounded-pill d-flex justify-content-center strk-btn">
                            Lihat Projek
                        </a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <?php if ($total_page > 1): ?>
        <nav class="d-flex justify-content-center mt-5">
            <ul class="pagination">

                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">
                        <
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
                        >
                    </a>
                </li>

            </ul>
        </nav>
        <?php endif; ?>

        <?php else : ?>
        <!-- Pesan jika tidak ada projek -->
        <h2>Belum ada projek</h2>
        <?php endif; ?>
    </div>

    <!-- Wave -->
    <div class="overflow mt-5">
        <img src="../asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave">
    </div>

    <!-- Footer halaman -->
    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <!-- Bootstrap JS -->
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
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
    AOS.init({
        duration: 1000,
        once: true
    });
    </script>
</body>

</html>