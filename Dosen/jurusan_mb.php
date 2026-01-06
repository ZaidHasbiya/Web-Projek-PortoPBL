<?php
/*
Nama File : jurusan_mb.php
Deskripsi : Halaman dosen untuk menampilkan daftar mahasiswa
            jurusan Manajemen Bisnis dengan fitur pencarian
            dan pagination.
Dibuat Oleh    :  - NIM : []
Tanggal     : 29 November 2025
*/

// Menghubungkan file koneksi database
include '../koneksi.php';

// Memulai session
session_start();

// Fungsi SweetAlert redirect (Sesuai struktur file lainnya)
function redirect_alert($icon, $title, $url) {
    $_SESSION['alert'] = [
        'icon' => $icon,
        'title' => $title,
        'url' => $url
    ];
}

// Validasi login dan role dosen
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['role'] !== 'dosen') {
    // Jika bukan dosen, arahkan menggunakan SweetAlert
    redirect_alert('error', 'Maaf, anda bukan dosen. Silakan login ulang.', '../login.php');
}

// Menyimpan ID dosen dari session
$user_id = $_SESSION['id'];

// Menangkap keyword pencarian dan mengamankannya
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

// Menentukan jumlah data per halaman
$limit = 6;

// Menentukan halaman saat ini
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page  = ($page < 1) ? 1 : $page;

// Menghitung offset pagination
$offset = ($page - 1) * $limit;

// Query dasar mengambil mahasiswa jurusan Manajemen Bisnis
$query = "SELECT * FROM users
          WHERE jurusan = 'manajemen bisnis'
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

// Query untuk menghitung total data (pagination)
$totalQuery = "SELECT COUNT(*) AS total FROM users
               WHERE jurusan = 'manajemen bisnis'
               AND role = 'mahasiswa'";

// Jika ada pencarian, tambahkan kondisi ke query total
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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../custom.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<style>
/* Mengatur agar navbar berada di atas elemen lain */
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

    <?php include '../layouts/navbar_dosen.php'; ?>

    <div class="text-center pt-4 mb-4">
        <h1 class="fw-bold display-6 mb-2">Jurusan Manajemen Bisnis</h1>
    </div>

    <form method="GET" class="d-flex justify-content-center mb-5">
        <div class="search-box shadow-sm">
            <div class="input-group input-group-lg">
                <input type="text" name="search" class="form-control border-0"
                    placeholder="Cari nama atau NIM Mahasiswa" value="<?= htmlspecialchars($search) ?>">

                <button type="submit" class="btn btn-clr px-4 fw-semibold">
                    Cari
                </button>
            </div>
        </div>
    </form>

    <div class="container">
        <?php if (mysqli_num_rows($data) > 0 ) : ?>
        <div class="row g-4 justify-content-center">

            <?php while ($row = mysqli_fetch_assoc($data)): ?>
            <?php
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
                        <p class="mb-1"><strong>Nama:</strong> <?= htmlspecialchars($row['nama']) ?></p>
                        <p class="mb-1"><strong>NIM:</strong> <?= htmlspecialchars($row['username']) ?></p>
                        <p class="mb-3"><strong>Jurusan:</strong> <?= htmlspecialchars($row['jurusan']) ?></p>
                        <a href="lihat_profil_mhs.php?id=<?= $row['id'] ?>" class="btn btn-info px-4 btn-clr">
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
                    <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">Sebelumnya</a>
                </li>

                <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>">
                        <?= $i ?>
                    </a>
                </li>
                <?php endfor; ?>

                <li class="page-item <?= ($page >= $totalPage) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">Selanjutnya</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>

        <?php else: ?>
        <h2 class="text-center text-muted">
            <?= !empty($search) ? 'Mahasiswa belum ada atau terdaftar' : 'Belum ada mahasiswa'; ?>
        </h2>
        <?php endif; ?>
    </div>

    <div class="overflow-hidden mt-5">
        <img src="../asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave">
    </div>

    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
    // SweetAlert Handling
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

    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
            this.style.transition = '0.3s';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    </script>
</body>

</html>