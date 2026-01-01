<?php
/*
Nama File : jurusan_mesin.php
Deskripsi : Halaman dosen untuk menampilkan daftar mahasiswa
            jurusan Teknik Mesin, dilengkapi dengan fitur
            pencarian data mahasiswa dan pagination.
Dibuat Oleh    :  - NIM : []
Tanggal     : 29 November 2025
*/

// Menghubungkan file koneksi database
include '../koneksi.php';

// Memulai session
session_start();

// Validasi login dan role pengguna (harus dosen)
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'dosen') {
    // Jika bukan dosen, tampilkan pesan dan arahkan ke halaman login
    echo "<script>
            alert('Maaf, anda bukan dosen. Silakan login ulang.');
            window.location.href = '../login.php';
          </script>";
    exit;
}

// Menyimpan ID dosen dari session
$user_id = $_SESSION['id'];

// Menangkap keyword pencarian (jika ada)
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Menentukan jumlah data per halaman
$limit = 6;

// Menentukan halaman aktif
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page  = ($page < 1) ? 1 : $page;

// Menghitung offset untuk pagination
$offset = ($page - 1) * $limit;

// Query dasar untuk mengambil data mahasiswa jurusan Teknik Mesin
$query = "SELECT * FROM users
          WHERE jurusan = 'teknik mesin'
          AND role = 'mahasiswa'";

// Jika ada pencarian, tambahkan filter nama atau NIM
if (!empty($search)) {
    $query .= " AND (
                  nama LIKE '%$search%'
                  OR username LIKE '%$search%'
               )";
}

// Menambahkan LIMIT dan OFFSET ke query
$query .= " LIMIT $limit OFFSET $offset";

// Menjalankan query data mahasiswa
$data = mysqli_query($koneksi, $query);

// Query untuk menghitung total data mahasiswa (pagination)
$totalQuery = "SELECT COUNT(*) AS total FROM users
               WHERE jurusan = 'teknik mesin'
               AND role = 'mahasiswa'";

// Jika ada pencarian, tambahkan kondisi pencarian
if (!empty($search)) {
    $totalQuery .= " AND (
                        nama LIKE '%$search%'
                        OR username LIKE '%$search%'
                     )";
}

// Menjalankan query total data
$totalResult = mysqli_query($koneksi, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);

// Mengambil total data mahasiswa
$totalData = $totalRow['total'];

// Menghitung jumlah halaman
$totalPage = ceil($totalData / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PortoPBL</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../custom.css">
</head>

<style>
/* Mengatur posisi navbar agar selalu berada di atas elemen lain */
.navbar {
    position: relative;
    z-index: 10;
}

/* Styling kotak pencarian */
.search-box {
    width: 100%;
    max-width: 550px;
    background: #ffffff;
    border-radius: 14px;
    padding: 6px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>

<body>

    <!-- ===== Navbar Dosen ===== -->
    <?php include '../layouts/navbar_dosen.php'; ?>

    <!-- ===== Judul Halaman ===== -->
    <div class="text-center pt-4 mb-4">
        <h1 class="fw-bold display-6 mb-2">Jurusan Teknik Mesin</h1>
    </div>

    <!-- ===== Form Pencarian Mahasiswa ===== -->
    <form method="GET" class="d-flex justify-content-center mb-5">
        <div class="search-box shadow-sm">
            <div class="input-group input-group-lg">
                <!-- Input keyword pencarian -->
                <input type="text" name="search" class="form-control border-0"
                    placeholder="Cari nama atau NIM Mahasiswa" value="<?= htmlspecialchars($search) ?>">

                <!-- Tombol pencarian -->
                <button type="submit" class="btn btn-clr px-4 fw-semibold">
                    Cari
                </button>
            </div>
        </div>
    </form>

    <?php if (mysqli_num_rows($data) > 0 ) : ?>
    <!-- ===== Daftar Mahasiswa ===== -->
    <div class="d-flex flex-wrap justify-content-evenly align-items-start gap-4">

        <?php while ($row = mysqli_fetch_assoc($data)): ?>
        <?php
        // Menentukan foto profil mahasiswa (default jika kosong)
        $foto = !empty($row['foto_profil']) 
                ? "../asset/profil/" . $row['foto_profil'] 
                : "../tim/profil-kosong.jpeg";
      ?>

        <!-- Card Mahasiswa -->
        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="ratio ratio-1x1">
                    <img src="<?= $foto ?>" class="card-img-top rounded-2" alt="Foto Mahasiswa"
                        style="object-fit: cover;">
                </div>
                <div class="card-body text-center">
                    <p class="mb-1"><strong>Nama:</strong> <?= $row['nama'] ?></p>
                    <p class="mb-1"><strong>NIM:</strong> <?= $row['username'] ?></p>
                    <p class="mb-3"><strong>Jurusan:</strong> <?= $row['jurusan'] ?></p>
                    <a href="lihat_profil_mhs.php?id=<?= $row['id'] ?>" class="btn btn-info px-4 btn-clr">
                        Lihat Profil
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>

    </div>

    <!-- ===== Pagination ===== -->
    <?php if ($totalPage > 1): ?>
    <nav class="d-flex justify-content-center mt-5">
        <ul class="pagination">

            <!-- Tombol Sebelumnya -->
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">Sebelumnya</a>
            </li>

            <!-- Nomor Halaman -->
            <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>">
                    <?= $i ?>
                </a>
            </li>
            <?php endfor; ?>

            <!-- Tombol Selanjutnya -->
            <li class="page-item <?= ($page >= $totalPage) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">Selanjutnya</a>
            </li>

        </ul>
    </nav>
    <?php endif; ?>

    <?php else: ?>

    <!-- Pesan jika data mahasiswa tidak tersedia -->
    <?php if (!empty($search)): ?>
    <h2 class="text-center text-muted">
        Mahasiswa belum ada atau terdaftar
    </h2>
    <?php else: ?>
    <h2 class="text-center text-muted">
        Belum ada mahasiswa
    </h2>
    <?php endif; ?>

    <?php endif; ?>

    <!-- Wave -->
    <div class="overflow-hidden mt-5">
        <img src="../asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave">
    </div>

    <!-- Footer -->
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