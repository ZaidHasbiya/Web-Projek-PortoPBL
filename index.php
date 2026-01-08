<!--
Nama File   : index.php
Fungsi     : Halaman utama (landing page) aplikasi PortoPBL
Pembuat    : Tim Web Portofolio Projek PBL
Dibuat     : 2025
Deskripsi  : Menampilkan halaman publik berisi informasi aplikasi,
             deskripsi, tim pengembang, dan navigasi login.
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata dasar halaman -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PortoPBL</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- AOS (Animate On Scroll) CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css" type="text/css">
    <link rel="stylesheet" href="custom.css">

    <!-- Style tambahan khusus -->
    <style>
    .text-justify {
        text-align: justify !important;
    }

    .jumbotron h1,
    .jumbotron h2 {
        color: #e9e1c9 !important;
    }
    #tim h1 {
    color: #e9e1c9 !important;
}

    </style>
</head>

<body>

    <!-- Navbar Publik File terpisah untuk meningkatkan modularitas kode -->
    <?php include 'layouts/navbar_publik.php'; ?>

    <!-- Jumbotron Section Menampilkan judul dan tombol login -->
    <section class="jumbotron text-center">

        <h1 class="display-3 fw-bold" data-aos="fade-up">
            SELAMAT DATANG DI PORTOPBL
        </h1>

        <h2 data-aos="fade-up" data-aos-delay="200">
            Platform Portofolio Digital Mahasiswa
        </h2>

        <a href="login.php" class="btn btn-outline-light rounded-pill mt-4 text-center" style="width:200px"
            data-aos="fade-up" data-aos-delay="400">
            MASUK
        </a>

        <!-- Gambar dekoratif -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -10 1440 320"
            style="width: 100%; display: flex; margin-top: -1 px;">
            <path fill="#fdf6e3" fill-opacity="1"
                d="M0,128L48,117.3C96,107,192,85,288,112C384,139,480,213,576,213.3C672,213,768,139,864,128C960,117,1056,171,1152,197.3C1248,224,1344,224,1392,224L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </section>

    <!-- Section Tentang Menjelaskan fungsi dan tujuan aplikasi-->
    <section id="tentang" class="mt-5">
        <div class="container">
            <div class="row">

                <div class="col text-center">
                    <h1 data-aos="fade-up">Tentang PortoPBL</h1><br>
                </div>

                <div class="col-12">
                    <h3 class="text-justify" data-aos="fade-up" data-aos-delay="200">
                        Sebuah website portofolio sebagai platform bagi mahasiswa
                        untuk mendokumentasikan dan memamerkan proyek-proyek PBL mereka.
                        Website ini adalah ruang pribadi untuk membangun portofolio digital
                        berisi deskripsi proyek, tangkapan layar, kode sumber, dan video demo.
                    </h3>
                </div>

            </div>
        </div>

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -10 1440 320"
            style="width: 100%; display: flex margin-top -5px">
            <path fill="#1D5D8C" fill-opacity="1"
                d="M0,128L48,117.3C96,107,192,85,288,112C384,139,480,213,576,213.3C672,213,768,139,864,128C960,117,1056,171,1152,197.3C1248,224,1344,224,1392,224L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </section>

    <!-- Section Tim Menampilkan anggota tim pengembang -->
    <section id="tim">
        <div class="container">

            <div class="row text-center mb-4">
                <div class="col">
                    <h1 data-aos="fade-up">
                        TIM PROJEK PBL
                    </h1>
                </div>
            </div>

            <div class="row text-center">

                <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100">
                        <img src="tim/zaid-biru.jpg" class="card-img-top" alt="Zaid Hasbiya Abrar" />
                        <div class="card-body">
                            <p class="card-text">3312501046</p>
                            <p class="card-text">Zaid Hasbiya Abrar</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100">
                        <img src="tim/patur-biru.jpg" class="card-img-top" alt="Fathur Alfitrah" />
                        <div class="card-body">
                            <p class="card-text">3312501047</p>
                            <p class="card-text">Fathur Alfitrah Dermawan</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100">
                        <img src="tim/panda-biru.jpg" class="card-img-top" alt="Reifandra Kinadi" />
                        <div class="card-body">
                            <p class="card-text">3312501048</p>
                            <p class="card-text">Reifandra Kinadi</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"
        style="width:100%; display:block; margin-top:-2px; transform: scaleY(-1);">
        <path fill="#1D5D8C" fill-opacity="1" d="M0,128L48,117.3C96,107,192,85,288,112C384,139,480,213,576,213.3C672,213,768,139,864,128C960,117,1056,171,1152,197.3C1248,224,1344,224,1392,224L1440,224L1440,320L1392,320
        C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320
        C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
        </path>
    </svg>

    <!-- Footer -->
    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <!-- Inisialisasi AOS -->
    <script>
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    AOS.init({
        duration: 1000,
        once: true
    });
    </script>

</body>

</html>