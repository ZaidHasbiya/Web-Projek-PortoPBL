<?php
/*
Nama File   : jurusan_elektro.php
Deskripsi     : Menampilkan daftar mahasiswa jurusan Teknik Elektro
             dengan fitur pagination pada halaman publik
Dibuat Oleh    : Zaid Hasbiya Abrar - NIM : [3312501046]
Tanggal : 7 Oktober 2025
*/

include 'koneksi.php';

// Menentukan jumlah data yang ditampilkan per halaman
$limit = 6;

// Mengambil nomor halaman dari parameter URL
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Mencegah halaman bernilai kurang dari 1
$page = ($page < 1) ? 1 : $page;

// Menghitung offset data untuk query SQL
$offset = ($page - 1) * $limit;

// Query untuk mengambil data mahasiswa Teknik Elektro
$query = "SELECT * FROM users 
          WHERE jurusan = 'teknik elektro' 
          AND role = 'mahasiswa'
          LIMIT $limit OFFSET $offset";

// Menjalankan query data mahasiswa
$data = mysqli_query($koneksi, $query);

// Query untuk menghitung total mahasiswa Teknik Elektro
$totalQuery = "SELECT COUNT(*) AS total 
               FROM users 
               WHERE jurusan = 'teknik elektro' 
               AND role = 'mahasiswa'";

// Menjalankan query total data
$totalResult = mysqli_query($koneksi, $totalQuery);

// Mengambil hasil total data
$totalRow  = mysqli_fetch_assoc($totalResult);
$totalData = $totalRow['total'];

// Menghitung total halaman pagination
$totalPage = ceil($totalData / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata halaman -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PortoPBL</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- File CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="custom.css" />
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

    <!-- Navbar publik -->
    <?php include 'layouts/navbar_publik.php'; ?>

    <div class="container">

        <!-- Judul halaman -->
        <h1 class="my-5 pt-5 text-center">Jurusan Teknik Elektro</h1>

        <!-- Mengecek apakah data mahasiswa tersedia -->
        <?php if (mysqli_num_rows($data) > 0): ?>

        <div class="d-flex flex-wrap justify-content-evenly align-items-start gap-4">

            <!-- Perulangan data mahasiswa -->
            <?php while ($row = mysqli_fetch_assoc($data)): ?>
            <?php
          // Mengecek apakah mahasiswa memiliki foto profil
          // Jika tidak ada, maka digunakan foto default
          $foto = !empty($row['foto_profil'])
            ? "asset/profil/" . $row['foto_profil']
            : "tim/profil-kosong.jpeg";
        ?>

            <div class="col-md-4 col-lg-3">
                <div class="card shadow-sm border-0 h-100">

                    <!-- Foto mahasiswa -->
                    <div class="ratio ratio-1x1">
                        <img src="<?= $foto ?>" class="card-img-top rounded-2" alt="Foto Mahasiswa"
                            style="object-fit: cover;" />
                    </div>

                    <!-- Informasi mahasiswa -->
                    <div class="card-body text-center">
                        <p class="mb-1"><strong>Nama:</strong> <?= $row['nama']; ?></p>
                        <p class="mb-1"><strong>NIM:</strong> <?= $row['username']; ?></p>
                        <p class="mb-3"><strong>Jurusan:</strong> <?= $row['jurusan']; ?></p>

                        <!-- Tombol lihat profil -->
                        <a href="lihat_profil_mhs.php?id=<?= $row['id']; ?>" class="btn btn-clr px-4">
                            Lihat Profil
                        </a>
                    </div>

                </div>
            </div>

            <?php endwhile; ?>
        </div>

        <!-- Navigasi pagination -->
        <?php if ($totalPage > 1): ?>
        <nav class="d-flex justify-content-center mt-5">
            <ul class="pagination">

                <!-- Tombol sebelumnya -->
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">Sebelumnya</a>
                </li>

                <!-- Nomor halaman -->
                <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
                <?php endfor; ?>

                <!-- Tombol selanjutnya -->
                <li class="page-item <?= ($page >= $totalPage) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">Selanjutnya</a>
                </li>

            </ul>
        </nav>
        <?php endif; ?>

        <?php else: ?>
        <!-- Jika data tidak tersedia -->
        <h2 class="text-center">Belum ada mahasiswa</h2>
        <?php endif; ?>

    </div>

    <!-- Wave -->
    <div class="overflow-hidden mt-5">
        <img src="asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave" />
    </div>

    <!-- Footer -->
    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
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