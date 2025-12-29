<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$isIndex = ($currentPage === 'index.php');
?>

<link rel="stylesheet" href="custom.css">
<style>
  .navbar .dropdown-menu {
    background-color: #e9e1c9 !important;
    border: 1px solid #d9d2b8;
}
</style>
<nav class="navbar navbar-expand-lg navbar-dark py-3 bg-nav-new shadow fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">PortoPBL</a>

    <button class="navbar-toggler shadow-none" type="button"
      data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto d-flex gap-3 text-center pt-lg-0 pt-4">

        <li class="nav-item">
          <a class="nav-link fw-bold" href="index.php">Beranda</a>
        </li>

        <li class="nav-item">
          <a class="nav-link fw-bold"
             href="<?= $isIndex ? '#tentang' : 'index.php#tentang' ?>">
             Tentang
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link fw-bold"
             href="<?= $isIndex ? '#tim' : 'index.php#tim' ?>">
             Tim
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-bold" href="#" data-bs-toggle="dropdown">
            Jurusan
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="jurusan_if.php">Teknik Informatika</a></li>
            <li><a class="dropdown-item" href="jurusan_mesin.php">Teknik Mesin</a></li>
            <li><a class="dropdown-item" href="jurusan_elektro.php">Teknik Elektro</a></li>
            <li><a class="dropdown-item" href="jurusan_mb.php">Manajemen Bisnis</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link fw-bold" href="projek.php">Projek</a>
        </li>

      </ul>
    </div>
  </div>
</nav>
