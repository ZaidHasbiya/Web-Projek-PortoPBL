<?php
/*
Nama File   : projek.php
Deskripsi     : Menampilkan daftar projek mahasiswa pada halaman publik
             dengan fitur pagination
Dibuat Oleh    : Zaid Hasbiya Abrar - NIM : [3312501046]
Tanggal     : 7 Oktober 2025
*/

include 'koneksi.php';
// Menghubungkan file koneksi database

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata halaman -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PortoPBL</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" />

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css" type="text/css">
    <link rel="stylesheet" href="custom.css">
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
        <h1 class="my-5 pt-5">Projek</h1>

        <!-- Cek apakah data projek tersedia -->
        <?php if ($result > 0 ): ?>

        <div class="row row-cols-1 row-cols-md-3 g-4">

            <!-- Perulangan data projek -->
            <?php while ($row = mysqli_fetch_assoc($data)) : ?>
            <div class="col">
                <div class="card border border-info">

                    <!-- Gambar projek -->
                    <div class="ratio ratio-16x9 overflow-hidden">
                        <img src="asset/uploads/<?= $row['gambar_projek']; ?>" class="w-100 h-100 object-fit-cover"
                            alt="Projek Web Portofolio PBL">
                    </div>

                    <!-- Informasi projek -->
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['judul']; ?></h5>
                        <p class="card-text">
                            Deskripsi Projek : <?= $row['deskripsi']; ?>
                        </p>
                        <p class="card-text">Dibuat Oleh :</p>
                        <p class="card-text">
                            Nama Mahasiswa : <?= $row['nama']; ?>
                        </p>
                        <p class="card-text">
                            NIM : <?= $row['username']; ?>
                        </p>

                        <!-- Tombol lihat detail projek -->
                        <a href="lihat_projek.php?projek_id=<?= $row['projek_id']; ?>"
                            class="btn btn-outline-info rounded-pill d-flex justify-content-center strk-btn">
                            Lihat Projek
                        </a>
                    </div>

                </div>
            </div>
            <?php endwhile; ?>

        </div>

        <!-- Navigasi pagination -->
        <?php if ($total_page > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_page; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?= $i; ?>">
                        <?= $i; ?>
                    </a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <?php endif; ?>

        <?php else : ?>
        <!-- Jika belum ada projek -->
        <h2>Belum ada projek</h2>
        <?php endif; ?>

    </div>

    <!-- Wave -->
    <div class="overflow mt-5">
        <img src="asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave">
    </div>

    <!-- Footer -->
    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>