<?php
/*
Nama File        : projek_saya.php
Deskripsi        : Menampilkan daftar projek milik mahasiswa
Dibuat Oleh      : Fathur Alfitrah - NIM : [3312501047]
Tanggal          : 10 Oktober 2025
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
    header("Location: projek_saya.php");
    exit;
}

// Cek login
if (!isset($_SESSION['username'])) {
    redirect_alert('error', 'Silakan login terlebih dahulu!', '../login.php');
}

// Cek role
if ($_SESSION['role'] !== 'mahasiswa') {
    redirect_alert('error', 'Maaf, anda bukan mahasiswa. Silakan login ulang.', '../login.php');
}

// Mengambil ID user dari session
$user_id = $_SESSION['id'];

// Pagination
$limit = 6;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page  = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

// Total projek
$total_query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM projek WHERE user_id = '$user_id'");
$total_data = mysqli_fetch_assoc($total_query)['total'];
$total_page = ceil($total_data / $limit);

// Data projek
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
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>PortoPBL</title>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" />

<!-- Google Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700;900&display=swap" rel="stylesheet">

<!-- Bootstrap -->
<link rel="stylesheet" href="../css/bootstrap.min.css">

<!-- Custom CSS -->
<link rel="stylesheet" href="../styles.css" type="text/css">

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<!-- Navbar Mahasiswa -->
<?php include '../layouts/navbar_mhs.php'; ?>

<div class="container mt-5 pt-5">

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

                    <div class="mt-auto">
                        <div class="d-flex justify-content-center gap-2 mb-2">
                            <a href="edit_projek.php?projek_id=<?= $row['projek_id']; ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Ubah
                            </a>

                            <a href="hapus_projek.php?projek_id=<?= $row['projek_id']; ?>" 
                               class="btn btn-danger btn-sm btn-hapus">
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

    <?php if ($total_page > 1): ?>
    <nav class="d-flex justify-content-center mt-5">
        <ul class="pagination">

            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>"><</a>
            </li>

            <?php for ($i = 1; $i <= $total_page; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>

            <li class="page-item <?= ($page >= $total_page) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?>">></a>
            </li>

        </ul>
    </nav>
    <?php endif; ?>

    <?php else: ?>
    <div class="text-center my-5">
        <i class="fas fa-folder-open fa-3x text-info mb-3"></i>
        <p class="fs-5 text-muted">Belum ada projek yang kamu buat.</p>
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
<script src="../script.js"></script>

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

// Konfirmasi hapus projek dengan SweetAlert
document.querySelectorAll('.btn-hapus').forEach(btn => {
    btn.addEventListener('click', function(e){
        e.preventDefault();
        const href = this.getAttribute('href');
        Swal.fire({
            title: 'Yakin ingin menghapus projek ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if(result.isConfirmed){
                window.location.href = href;
            }
        });
    });
});
</script>

</body>
</html>
