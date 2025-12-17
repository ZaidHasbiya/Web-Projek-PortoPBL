<?php
session_start();

if(!isset($_SESSION['username'])){
  echo "<script>alert('username tidak sesuai ! silahkan melakukan login'); window.location ='../login.php';</script>";
}

if($_SESSION['role'] != 'admin'){
  echo "<script>alert('Akses ditolak! Halaman ini hanya untuk admin.');window.location='../login.php';</script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        crossorigin="anonymous" />
</head>
<style>
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
</style>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-nav-new shadow fixed-top">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Dashboard Admin</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
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
                        <a class="nav-link text-white" href="index.html">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse"
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
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Data Mahasiswa</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">Data Dosen</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
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
</body>

</html>