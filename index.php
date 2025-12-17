<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PortoPBL</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/bootstrap.min.css">

  <link rel="stylesheet" href="styles.css" type="text/css">
  <link rel="stylesheet" href="custom.css">
</head>

<body>

  <!-- ===== Navbar ===== -->
  <?php include 'layouts/navbar_publik.php'; ?>

  <!-- ===== Jumbotron ===== -->
  <section class="jumbotron text-center">
    <h1 class="display-3 fw-bold text-white">SELAMAT DATANG DI PORTOPBL</h1>
    <h2>Platform Portofolio Digital Mahasiswa</h2>
    <a href="login.php" class="btn btn-outline-light rounded-pill mt-4 text-center" style="width:200px">MASUK</a>
    <img src="asset/wave.svg" alt="Garis pemisah">
  </section>

  <!-- ===== Tentang Section ===== -->
  <section id="tentang" class="mt-5">
    <div class="container">
      <div class="row text-center">
        <div class="col">
          <h1>Tentang PortoPBL</h1><br>
          <h3>
            Sebuah website portofolio sebagai platform bagi mahasiswa untuk mendokumentasikan dan memamerkan proyek-proyek PBL mereka.
            Website ini adalah ruang pribadi untuk membangun portofolio digital berisi deskripsi proyek, tangkapan layar, kode sumber,
            dan video demo. Membantu mahasiswa menampilkan hasil proyek PBL secara digital.
          </h3>
        </div>
      </div>
    </div>
    <img src="asset/wave-new-navy.svg" alt="Garis pemisah">
  </section>

  <!-- ===== Tim Section ===== -->
  <section id="tim">
    <div class="container">
      <div class="row text-center mb-4">
        <div class="col">
          <h1 class="text-white">TIM PROJEK PBL</h1>
        </div>
      </div>

      <div class="row text-center">
        <div class="col-md-4 mb-3">
          <div class="card h-100">
            <img src="tim/zaid-biru.jpg" class="card-img-top" alt="Zaid Hasbiya Abrar">
            <div class="card-body">
              <p class="card-text">3312501046</p>
              <p class="card-text">Zaid Hasbiya Abrar</p>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-3">
          <div class="card h-100">
            <img src="tim/patur-biru.jpg" class="card-img-top" alt="Fathur Alfitrah">
            <div class="card-body">
              <p class="card-text">3312501047</p>
              <p class="card-text">Fathur Alfitrah Dermawan</p>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-3">
          <div class="card h-100">
            <img src="tim/panda-biru.jpg" class="card-img-top" alt="Reifandra Kinadi">
            <div class="card-body">
              <p class="card-text">3312501048</p>
              <p class="card-text">Reifandra Kinadi</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <img src="asset/wave.svg" alt="Garis pemisah bawah">
  </section>

  <footer class="text-center py-3 bg-light mt-5">
    &copy; <span>2025</span> Tim Web Portofolio Projek PBL
  </footer>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
