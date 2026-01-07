<?php
/**
 * File: data_mahasiswa.php
 * Fungsi: Menampilkan daftar mahasiswa beserta opsi tambah, edit, hapus, dan lihat detail.
 */

session_start();
include '../koneksi.php';

// Fungsi pembantu SweetAlert Session
function set_alert($icon, $title, $url) {
    $_SESSION['alert'] = [
        'icon' => $icon,
        'title' => $title,
        'url' => $url
    ];
}

// Validasi login
if(!isset($_SESSION['username'])){
    set_alert('warning', 'Username tidak sesuai! Silahkan login', '../login.php');
}

// Validasi role admin (hanya dijalankan jika session alert belum ada dari validasi login)
if(!isset($_SESSION['alert']) && $_SESSION['role'] != 'admin'){
    set_alert('error', 'Akses ditolak! Halaman ini hanya untuk admin.', '../login.php');
}

// Query data mahasiswa
$query = "SELECT * FROM users WHERE role='mahasiswa'";
$data = mysqli_query($koneksi, $query);
$result = mysqli_num_rows($data);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Data Mahasiswa - Dasbor Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
/* Navbar & Sidebar Styling */
.bg-nav-new {
    background: linear-gradient(90deg, #1D5D8C, #2E86C1);
}

.bg-nav-new .navbar-brand {
    font-weight: 700;
}

.bg-nav-new .nav-link,
.bg-nav-new .navbar-brand,
.bg-nav-new .btn-link,
.bg-nav-new i {
    color: #ffffff !important;
}

.sb-sidenav {
    background: linear-gradient(180deg, #0F3C5F, #1D5D8C);
    color: #ffffff;
}

.sb-sidenav .nav-link {
    color: rgba(255, 255, 255, 0.85);
    padding: 12px 20px;
    border-radius: 10px;
    margin: 4px 10px;
    transition: all 0.3s ease;
}

.sb-sidenav .sb-nav-link-icon i {
    color: #BFDFFF;
    transition: 0.3s;
}

.sb-sidenav .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.15);
    color: #ffffff;
}

.sb-sidenav .nav-link.active {
    background: rgba(255, 255, 255, 0.25);
    font-weight: 600;
}

.sb-sidenav-footer {
    background-color: rgba(0, 0, 0, 0.25);
    color: #ffffff;
    padding: 15px;
    font-size: 14px;
}

table thead tr {
    background-color: #f8f9fa;
    font-weight: 600;
    font-size: 15px;
    text-align: center;
}

table tbody td {
    text-align: justify;
    vertical-align: top;
}

/* ===============================
   WARNA CREAM GLOBAL
================================ */
:root {
    --cream: #fdf6e3;
}

/* ===== NAVBAR TEXT ===== */
.bg-nav-new .navbar-brand,
.bg-nav-new .nav-link,
.bg-nav-new .btn-link,
.bg-nav-new i {
    color: var(--cream) !important;
}

/* ===== SIDEBAR TEXT ===== */
.sb-sidenav,
.sb-sidenav .nav-link,
.sb-sidenav .sb-nav-link-icon i,
.sb-sidenav-footer,
.sb-sidenav-footer .small {
    color: var(--cream) !important;
}

/* Hover tetap cream */
.sb-sidenav .nav-link:hover,
.sb-sidenav .nav-link:hover i {
    color: var(--cream) !important;
}

/* Active */
.sb-sidenav .nav-link.active {
    color: var(--cream) !important;
}

/* Nested menu */
.sb-sidenav-menu-nested .nav-link {
    color: var(--cream) !important;
}

/* ===== CARD DASHBOARD ===== */
.card.bg-primary,
.card.bg-warning {
    color: var(--cream) !important;
}

.card.bg-primary .card-body,
.card.bg-warning .card-body,
.card.bg-primary .card-footer,
.card.bg-warning .card-footer,
.card.bg-primary a,
.card.bg-warning a,
.card.bg-primary i,
.card.bg-warning i {
    color: var(--cream) !important;
}

/* ===============================
   CONTENT AREA
================================ */

body,
#layoutSidenav_content {
    background-color: #fdf6e3 !important;
}

h1.mt-4 {
    color: #2d3748 !important;
}

/* Card text fix */
.card,
.card-body,
.card-footer,
.card p {
    color: #2d3748 !important;
}

/* ===============================
   TABLE STYLE 
================================ */
/* Wrapper table */
.table-responsive {
    background: white;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
}

/* Table base */
table.table {
    border-collapse: collapse;
    width: 100%;
    background-color: #ffffff;
}

/* Table header */
table thead th {
    background-color: #1D5D8C !important;
    color: #fdf6e3 !important;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
    padding: 14px;
    border: 1px solid #dee2e6 !important;
}

/* Table body cell */
table tbody td {
    text-align: center !important;
    vertical-align: middle !important;
    padding: 14px;
    color: #2d3748 !important;
    border: 1px solid #e2e8f0 !important;
    font-size: 14px;
}

/* Zebra strip */
table tbody tr:nth-child(even) {
    background-color: #f8fafc;
}

/* Hover effect */
table tbody tr:hover {
    background-color: #edf2f7;
    transition: 0.2s ease;
}

/* Kolom panjang (komentar / judul) tetap rapi */
table td {
    word-break: break-word;
}

/* Button di tabel */
table .btn {
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 13px;
}

/* Datatables search & pagination */
.dataTable-top label,
.dataTable-bottom {
    color: #2d3748 !important;
}

.dataTable-input {
    border-radius: 8px;
    border: 1px solid #cbd5e0;
    padding: 6px 10px;
}

/* Pagination button */
.dataTable-pagination a {
    border-radius: 6px !important;
}

.table-responsive {
    margin-bottom: 40px !important;
}
</style>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-nav-new shadow fixed-top">
        <a class="navbar-brand ps-3" href="dashboard.php">Dasbor Admin</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i
                class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link text-white" href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-tachometer-alt"></i></div> Dasbor
                        </a>
                        <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div> Data
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link text-white" href="data_mahasiswa.php">Data Mahasiswa</a>
                                <a class="nav-link text-white" href="data_dosen.php">Data Dosen</a>
                                <a class="nav-link text-white" href="data_komentar.php">Komentar Dosen</a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?= htmlspecialchars($_SESSION['nama'] ?? 'Admin'); ?>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Data Mahasiswa</h1>
                    <a href="tambah_mahasiswa.php" class="btn btn-info text-white mb-4"><i class="fas fa-plus"></i>
                        Tambah Mahasiswa</a>

                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Jurusan</th>
                                    <th colspan="3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result > 0): 
                                    $no = 1;
                                    while($row = mysqli_fetch_assoc($data)): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['nama']); ?></td>
                                    <td><?= htmlspecialchars($row['username']); ?></td>
                                    <td><?= !empty($row['jurusan']) ? htmlspecialchars($row['jurusan']) : 'Belum diatur'; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal"
                                            data-bs-target="#modalLihat<?= $row['id']; ?>">
                                            <i class="fas fa-eye"></i> Lihat
                                        </button>
                                    </td>
                                    <td>
                                        <a href="edit_mahasiswa.php?id=<?= $row['id']; ?>"
                                            class="btn btn-warning btn-sm text-white">
                                            <i class="fas fa-edit"></i> Ubah
                                        </a>
                                    </td>
                                    <td>
                                        <button onclick="confirmDelete(<?= $row['id']; ?>)"
                                            class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalLihat<?= $row['id']; ?>" tabindex="-1"
                                    aria-labelledby="modalLihatLabel<?= $row['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLihatLabel<?= $row['id']; ?>">Detail
                                                    Mahasiswa</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Nama:</strong> <?= htmlspecialchars($row['nama']); ?></p>
                                                <p><strong>NIM:</strong> <?= htmlspecialchars($row['username']); ?></p>
                                                <p><strong>Jurusan:</strong>
                                                    <?= !empty($row['jurusan']) ? htmlspecialchars($row['jurusan']) : 'Belum diatur'; ?>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endwhile; else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Tidak ada data mahasiswa</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>

            <footer style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div>Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#" style="color: #5a5a5a;">Privacy Policy</a>
                            &middot;
                            <a href="#" style="color: #5a5a5a;">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>

    <script>
    // Penanganan SweetAlert untuk validasi akses
    <?php if (isset($_SESSION['alert'])): ?>
    Swal.fire({
        icon: '<?= $_SESSION['alert']['icon'] ?>',
        title: '<?= $_SESSION['alert']['title'] ?>',
        confirmButtonColor: '#1D5D8C',
        showConfirmButton: true
    }).then(() => {
        window.location.href = '<?= $_SESSION['alert']['url'] ?>';
    });
    <?php unset($_SESSION['alert']); endif; ?>

    // Fungsi konfirmasi hapus
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data mahasiswa akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'hapus_mahasiswa.php?id=' + id;
            }
        });
    }
    </script>
</body>

</html>