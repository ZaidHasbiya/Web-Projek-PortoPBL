<link rel="stylesheet" href="../custom.css">
<style>
.navbar .dropdown-menu {
    background-color: #e9e1c9 !important;
    border: 1px solid #d9d2b8;
    z-index: 1050;
}

.logo-custom {
    height: 40px !important;
    width: auto !important;
    object-fit: contain;
    display: inline-block !important;
    transition: all 0.3s ease;
}

.navbar-brand {
    display: flex !important;
    align-items: center !important;
    padding-top: 0;
    padding-bottom: 0;
}
</style>
<nav class="navbar navbar-expand-lg navbar-dark py-3 bg-nav-new shadow fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index_mahasiswa.php">
            <img src="../asset/logoo.png" alt="Logo PortoPBL" class="logo-custom">
            <span class="d-inline-block">PortoPBL</span>
        </a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto d-flex gap-3 text-center pt-lg-0 pt-4">
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="index_dosen.php">Beranda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
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
                    <a class="nav-link dropdown-toggle fw-bold" href="../Dosen/profil_saya.php"
                        id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Profil
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="profil_saya.php">Profil Saya</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="projek.php">Projek</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="../logout.php">Log Out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>