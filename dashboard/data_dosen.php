<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['username'])){
  echo "<script>alert('username tidak sesuai ! silahkan melakukan login'); window.location ='login.php';</script>";
}

if($_SESSION['role'] != 'admin'){
  echo "<script>alert('Akses ditolak! Halaman ini hanya untuk admin.');window.location='index.php';</script>";
    exit;
}

$query = "SELECT * FROM users WHERE role='dosen'";
$data = mysqli_query($koneksi, $query);
$result = mysqli_num_rows($data);

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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" />
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="dashboard.php">Dashboard Admin</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion bg-primary" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading"></div>
                            <a class="nav-link text-white" href="dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Data
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
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
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Dosen</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <a href="tambah_dosen.php" class="btn btn-info text-white mb-4">
    <i class="fas fa-plus"></i> Tambah Dosen
  </a>
                    </div>
                    <div class="table-responsive">
                   <table class="table table-bordered text-center">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>NIK</th>
        <th>Jurusan</th>
        <th colspan="3">Aksi</th>
    </tr>

    <?php 
    if ($result > 0) {
        $no = 1;
        while ($row = mysqli_fetch_assoc($data)) :
    ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $row['nama']; ?></td>
        <td><?= $row['username']; ?></td>
        <td><?= !empty($row['jurusan']) ? $row['jurusan'] : 'Belum diatur'; ?></td>

        <td>
            <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalLihat<?= $row['id']; ?>">
                <i class="fas fa-eye"></i> Lihat
            </button>
        </td>

        <td>
            <a href="edit_dosen.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-white">
                <i class="fas fa-edit"></i> Edit
            </a>
        </td>

        <td>
            <a onclick="return confirm('Yakin ingin menghapus?')" href="hapus_dosen.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">
                <i class="fas fa-trash"></i> Hapus
            </a>
        </td>
    </tr>

    <div class="modal fade" id="modalLihat<?= $row['id']; ?>" tabindex="-1" aria-labelledby="modalLihatLabel<?= $row['id']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalLihatLabel<?= $row['id']; ?>">Detail Dosen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p><strong>Nama:</strong> <?= $row['nama']; ?></p>
                    <p><strong>NIK:</strong> <?= $row['username']; ?></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>

            </div>
        </div>
    </div>

    <?php endwhile; } else { ?>

    <tr>
        <td colspan="7" class="text-center text-muted">Tidak ada data dosen</td>
    </tr>

    <?php } ?>
</table>

                    </div>
                    <div class="modal fade" id="modalLihat1" tabindex="-1" aria-labelledby="modalLihatLabel1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalLihatLabel1">Detail Dosen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p><strong>Nama:</strong> Reifandra Kinadi</p>
        <p><strong>NIK:</strong> 3312501046</p>
        <p><strong>Username:</strong> Admin#123</p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>