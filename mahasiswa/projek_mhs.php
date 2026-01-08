<?php
/*
Nama File : projek_mhs.php
Deskripsi   : Menampilkan seluruh projek mahasiswa
Dibuat Oleh: Fathur Alfitrah - NIM : [3312501047]
Tanggal     : 10 Oktober 2025
*/

session_start();
include '../koneksi.php';

// Fungsi redirect dengan SweetAlert
function redirect_alert($icon, $title, $url) {
    $_SESSION['alert'] = [
        'icon' => $icon,
        'title' => $title,
        'url' => $url
    ];
    header("Location: projek_mhs.php");
    exit;
}

// Fungsi redirect dengan SweetAlert
function redirect_alert($icon, $title, $url) {
    $_SESSION['alert'] = [
        'icon' => $icon,
        'title' => $title,
        'url' => $url
    ];
    header("Location: projek_mhs.php");
    exit;
}

// Validasi login
if (!isset($_SESSION['username'])) {
    redirect_alert('error', 'Silahkan login terlebih dahulu!', '../login.php');
    redirect_alert('error', 'Silahkan login terlebih dahulu!', '../login.php');
}

// Validasi role mahasiswa
if ($_SESSION['role'] !== 'mahasiswa') {
    redirect_alert('error', 'Maaf, anda bukan mahasiswa. Silakan login ulang.', '../login.php');
    redirect_alert('error', 'Maaf, anda bukan mahasiswa. Silakan login ulang.', '../login.php');
}

// Pagination
// Pagination
$limit  = 6;
$page   = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page   = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

// Total projek
$total_query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM projek");
$total_data  = mysqli_fetch_assoc($total_query)['total'];
$total_page  = ceil($total_data / $limit);
// Total projek
$total_query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM projek");
$total_data  = mysqli_fetch_assoc($total_query)['total'];
$total_page  = ceil($total_data / $limit);

// Data projek
$query  = "
// Data projek
$query  = "
    SELECT projek.*, users.nama, users.username
    FROM projek
    JOIN users ON projek.user_id = users.id
    ORDER BY projek.judul ASC
    LIMIT $limit OFFSET $offset
";
$data   = mysqli_query($koneksi, $query);
$result = mysqli_num_rows($data);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PortoPBL</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700;900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <link rel="stylesheet" href="../styles.css" type="text/css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<<<<<<< HEAD
=======

<style>
.card-text {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

</style>

>>>>>>> a096997 (Finalisasi produk)
<body>

    <?php include '../layouts/navbar_mhs.php'; ?>

<div class="container">
    <h1 class="my-5 pt-5">Projek</h1>

    <?php if ($result > 0): ?>
    <div class="row row-cols-1 row-cols-md-3 g-4">

        <?php while ($row = mysqli_fetch_assoc($data)): ?>
        <div class="col">
            <div class="card border border-info h-100 d-flex flex-column">

                    <div class="ratio ratio-16x9 overflow-hidden">
                        <img src="../asset/uploads/<?= htmlspecialchars($row['gambar_projek']); ?>"
                            class="w-100 h-100 object-fit-cover" alt="Projek Web Portofolio PBL">
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($row['judul']); ?></h5>
                        <p class="card-text">Deskripsi Projek : <?= htmlspecialchars($row['deskripsi']); ?></p>
                        <p class="card-text mb-1">Dibuat Oleh :</p>
                        <p class="card-text mb-1">Nama Mahasiswa : <?= htmlspecialchars($row['nama']); ?></p>
                        <p class="card-text">NIM : <?= htmlspecialchars($row['username']); ?></p>

<<<<<<< HEAD
                    <a href="lihat_projek_mhs.php?projek_id=<?= $row['projek_id']; ?>"
                        class="btn btn-outline-info rounded-pill d-flex justify-content-center">
                        Lihat Projek
                    </a>
=======
                        <a href="lihat_projek_mhs.php?projek_id=<?= $row['projek_id']; ?>"
                            class="btn btn-outline-info rounded-pill d-flex justify-content-center mt-auto">
                            Lihat Projek
                        </a>

                    </div>
>>>>>>> a096997 (Finalisasi produk)
                </div>
            </div>
        </div>
        <?php endwhile; ?>

    </div>

        <?php if ($total_page > 1): ?>
        <nav class="d-flex justify-content-center mt-5">
            <?php if ($total_page > 1): ?>
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


            </ul>
        </nav>
        <?php endif; ?>


        <?php else: ?>
        <div class="text-center my-5">
            <i class="fas fa-folder-open fa-3x text-info mb-3"></i>
            <p class="fs-5 text-muted">Belum ada projek yang tersedia.</p>
        </div>
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
    // Notifikasi login/role menggunakan SweetAlert
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

    // Animasi hover card
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
