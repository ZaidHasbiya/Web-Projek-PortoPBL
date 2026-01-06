<?php
/**
 * File: dashboard.php
 * Fungsi: Menampilkan dashboard admin dengan menu navigasi, sidebar, dan card statistik.
 * Pembuat: Zaid Hasbiya Abrar
 * Waktu Pembuatan: 26 Desember 2025
 */

session_start(); // Memulai session

// Fungsi pembantu SweetAlert Session
function set_alert($icon, $title, $url) {
    $_SESSION['alert'] = [
        'icon' => $icon,
        'title' => $title,
        'url' => $url
    ];
}

// Mengecek apakah user sudah login
if(!isset($_SESSION['username'])){
    set_alert('warning', 'Username tidak sesuai! Silahkan login', '../login.php');
}

// Mengecek apakah user memiliki role 'admin'
if(!isset($_SESSION['alert']) && $_SESSION['role'] != 'admin'){
    set_alert('error', 'Akses ditolak! Halaman ini hanya untuk admin.', '../login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Dashboard Admin Portofolio PBL" />
    <meta name="author" content="Zaid Hasbiya Abrar" />
    <title>Dasbor - SB Admin</title>

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

:root {
    --nav-height: 56px;
}

.bg-nav-new {
    background: linear-gradient(90deg, #1D5D8C, #2E86C1);
}

.bg-nav-new .navbar-brand,
.bg-nav-new .nav-link,
.bg-nav-new .btn-link,
.bg-nav-new i {
    font-weight: 700;
}

#layoutSidenav_nav {
    padding-top: var(--nav-height);
}

.sb-sidenav {
    background: linear-gradient(180deg, #0F3C5F, #1D5D8C);
    padding-top: 0 !important;
}

.sb-sidenav-menu-heading {
    display: none;
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

.sb-sidenav .nav-link:hover i {
    color: #ffffff;
}

.sb-sidenav .nav-link.active {
    background: rgba(255, 255, 255, 0.25);
    font-weight: 600;
}

.sb-sidenav-menu-nested .nav-link {
    background-color: rgba(0, 0, 0, 0.15);
    margin-left: 20px;
    font-size: 14px;
}

.sb-sidenav-collapse-arrow i {
    color: #ffffff;
}

.sb-sidenav-footer {
    background-color: rgba(0, 0, 0, 0.25);
    color: #ffffff;
    padding: 15px;
    font-size: 14px;
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
</style>

<body class="sb-nav-fixed">

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-nav-new shadow fixed-top">
        <a class="navbar-brand ps-3" href="dashboard.php">Dasbor Admin</a>

        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i
                class="fas fa-bars"></i></button>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>
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
                        <div class="sb-sidenav-menu-heading"></div>

                        <a class="nav-link text-white" href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-tachometer-alt"></i></div>
                            Dasbor
                        </a>

                        <a class="nav-link collapsed text-white" href="dashboard.php" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Data
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>

                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
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
                    <?= $_SESSION['nama'] ?>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dasbor</h1>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Data Mahasiswa</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="data_mahasiswa.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">Data Dosen</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="data_dosen.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <script>
    // Script SweetAlert untuk pengecekan session
    <?php if (isset($_SESSION['alert'])): ?>
    Swal.fire({
        icon: '<?= $_SESSION['alert']['icon'] ?>',
        title: '<?= $_SESSION['alert']['title'] ?>',
        confirmButtonColor: '#1D5D8C',
    }).then((result) => {
        window.location.href = '<?= $_SESSION['alert']['url'] ?>';
    });
    <?php unset($_SESSION['alert']); endif; ?>
    </script>
</body>

</html>