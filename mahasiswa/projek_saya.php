<?php
/*
Nama File        : projek_saya.php
Deskripsi   : Menampilkan daftar projek milik mahasiswa yang sedang login
              dengan fitur pagination serta aksi tambah, edit, hapus, dan lihat
Dibuat Oleh    : Fathur Alfitrah - NIM : [3312501048]
Tanggal     : 10 Oktober 2025
*/

session_start();
// Memulai session pengguna

include '../koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    echo "<script>
            alert('Silakan login terlebih dahulu!');
            window.location.href = '../login.php';
          </script>";
    exit;
}

// Cek apakah role user adalah mahasiswa
if ($_SESSION['role'] !== 'mahasiswa') {
    echo "<script>
            alert('Maaf, anda bukan mahasiswa. Silakan login ulang.');
            window.location.href = '../login.php';
          </script>";
    exit;
}

// Mengambil ID user dari session
$user_id = $_SESSION['id'];

// Konfigurasi pagination
$limit = 6; // jumlah data per halaman
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page  = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

// Menghitung total projek milik mahasiswa
$total_query = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM projek WHERE user_id = '$user_id'"
);
$total_data = mysqli_fetch_assoc($total_query)['total'];
$total_page = ceil($total_data / $limit);

/*
Query untuk mengambil data projek mahasiswa
digabung dengan tabel users
*/
$query = "
    SELECT projek.*, users.nama, users.username
    FROM projek
    JOIN users ON projek.user_id = users.id
    WHERE user_id = '$user_id'
    LIMIT $limit OFFSET $offset
";
$result = mysqli_query($koneksi, $query);
$jumlah_projek = mysqli_num_rows($result);
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700;900&display=swap"
        rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../styles.css" type="text/css">
</head>

<body>

    <!-- Navbar Mahasiswa -->
    <?php include '../layouts/navbar_mhs.php'; ?>

    <div class="container mt-5 pt-5">

        <!-- Judul halaman dan tombol tambah projek -->
        <div class="d-flex justify-content-between align-items-center my-5">
            <h1 class="m-0">Projek Saya</h1>
            <a href="tambah_projek.php" class="btn btn-clr text-white">
                <i class="fas fa-plus"></i> Tambah Projek
            </a>
        </div>

        <?php if ($jumlah_projek > 0): ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">

            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="col">
                <div class="card border border-info h-100 d-flex flex-column">

                    <!-- Gambar projek -->
                    <div class="ratio ratio-16x9 overflow-hidden">
                        <img src="../asset/uploads/<?= htmlspecialchars($row['gambar_projek']); ?>"
                            class="w-100 h-100 object-fit-cover" alt="Projek Web Portofolio PBL">
                    </div>

                    <!-- Informasi projek -->
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($row['judul']); ?></h5>

                        <p class="card-text">
                            Deskripsi Projek : <?= htmlspecialchars($row['deskripsi']); ?>
                        </p>

                        <p class="card-text mb-1">Dibuat Oleh :</p>
                        <p class="card-text mb-1">
                            Nama Mahasiswa : <?= htmlspecialchars($row['nama']); ?>
                        </p>
                        <p class="card-text">
                            NIM : <?= htmlspecialchars($row['username']); ?>
                        </p>

                        <!-- Tombol aksi -->
                        <div class="mt-auto">
                            <div class="d-flex justify-content-center gap-2 mb-2">
                                <a href="edit_projek.php?projek_id=<?= $row['projek_id']; ?>"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Ubah
                                </a>

                                <a href="hapus_projek.php?projek_id=<?= $row['projek_id']; ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus projek ini?');">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </a>
                            </div>

                            <a href="lihat_projek_saya.php?projek_id=<?= $row['projek_id']; ?>"
                                class="btn btn-outline-info w-100 rounded-pill">
                                Lihat Projek
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>

        </div>

        <!-- Pagination -->
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

        <?php else: ?>
        <!-- Tampilan jika belum ada projek -->
        <div class="text-center my-5">
            <i class="fas fa-folder-open fa-3x text-info mb-3"></i>
            <p class="fs-5 text-muted">Belum ada projek yang kamu buat.</p>
        </div>
        <?php endif; ?>

    </div>

    <!-- Wave -->
    <div class="overflow-hidden mt-5">
        <img src="../asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave">
    </div>

    <!-- Footer -->
   <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../script.js"></script>
</body>

</html>