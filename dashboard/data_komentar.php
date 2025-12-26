<?php
/**
 * File: data_komentar.php
 * Fungsi: Menampilkan semua komentar dosen untuk projek mahasiswa.
 */

session_start();
include '../koneksi.php';

// Validasi login
if(!isset($_SESSION['username'])){
    echo "<script>alert('Username tidak sesuai! Silahkan login'); window.location ='../login.php';</script>";
    exit;
}

// Validasi role admin
if($_SESSION['role'] != 'admin'){
    echo "<script>alert('Akses ditolak! Halaman ini hanya untuk admin.'); window.location='../login.php';</script>";
    exit;
}

// Query mengambil data komentar beserta nama dosen, mahasiswa, dan judul projek
$query = "SELECT komentar.*, projek.judul, users.nama AS nama_dosen, mhs.nama AS nama_mhs
          FROM komentar
          JOIN projek ON komentar.projek_id = projek.projek_id
          JOIN users ON komentar.user_id = users.id
          JOIN users AS mhs ON projek.user_id = mhs.id
          ORDER BY komentar.komentar_id DESC";

$result = mysqli_query($koneksi, $query);
?>

<style>
/* Styling tabel */
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
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Komentar Dosen - Dasbor Admin</title>

    <!-- Fonts & CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" />
</head>

<style>
/* Navbar & Sidebar Styling */
.bg-nav-new { background: linear-gradient(90deg, #1D5D8C, #2E86C1); }
.bg-nav-new .navbar-brand { font-weight: 700; }
.bg-nav-new .nav-link, .bg-nav-new .navbar-brand, .bg-nav-new .btn-link, .bg-nav-new i { color: #ffffff !important; }

.sb-sidenav { background: linear-gradient(180deg, #0F3C5F, #1D5D8C); color: #ffffff; }
.sb-sidenav .nav-link { color: rgba(255, 255, 255, 0.85); padding: 12px 20px; border-radius: 10px; margin: 4px 10px; transition: all 0.3s ease; }
.sb-sidenav .sb-nav-link-icon i { color: #BFDFFF; transition: 0.3s; }
.sb-sidenav .nav-link:hover { background-color: rgba(255, 255, 255, 0.15); color: #ffffff; }
.sb-sidenav .nav-link.active { background: rgba(255, 255, 255, 0.25); font-weight: 600; }
.sb-sidenav-footer { background-color: rgba(0, 0, 0, 0.25); color: #ffffff; padding: 15px; font-size: 14px; }
</style>

<body class="sb-nav-fixed">
    <!-- Navbar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-nav-new shadow fixed-top">
        <a class="navbar-brand ps-3" href="dashboard.php">Dasbor Admin</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <!-- Sidebar -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link text-white" href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-tachometer-alt"></i></div> Dasbor
                        </a>
                        <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts">
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
                    <?= $_SESSION['nama']; ?>
                </div>
            </nav>
        </div>

        <!-- Content -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Komentar Dosen</h1>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" style="background-color:#ffffff;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Mahasiswa</th>
                                    <th>Dosen</th>
                                    <th>Judul Projek</th>
                                    <th>Komentar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($row['nama_mhs']); ?></td>
                                        <td><?= htmlspecialchars($row['nama_dosen']); ?></td>
                                        <td><?= htmlspecialchars($row['judul']); ?></td>
                                        <td><?= nl2br(htmlspecialchars($row['komentar'])); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a> &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- JS Bootstrap & Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
</body>
</html>
