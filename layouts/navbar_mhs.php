<link rel="stylesheet" href="../custom.css">
<nav class="navbar navbar-expand-lg navbar-dark py-3 bg-nav-new shadow fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index_mahasiswa.php">PortoPBL</a>
      <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto d-flex gap-3 text-center pt-lg-0 pt-4">
          <li class="nav-item">
            <a class="nav-link fw-bold h-nav" href="index_mahasiswa.php">Beranda</a>
          </li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdownMenuLink"
            role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Jurusan
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="jurusan_if.php">Teknik Informatika</a></li>
            <li><a class="dropdown-item" href="jurusan_mesin.php">Teknik Mesin</a></li>
            <li><a class="dropdown-item" href="jurusan_elektro.php">Teknik Elektro</a></li>
            <li><a class="dropdown-item" href="jurusan_mb.php">Manajemen Bisnis</a></li>
          </ul>
        </li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdownMenuLink"
            role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Profil
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="profil_saya.php">Profil Saya</a></li>
            <li><a class="dropdown-item" href="edit_profil.php">Edit Profil</a></li>
            <li><a class="dropdown-item" href="projek_saya.php">Projek Saya</a></li>
          </ul>
        </li>
          <li class="nav-item">
            <a class="nav-link fw-bold" href="projek_mhs.php">Projek</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-bold" href="../logout.php">Log Out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>