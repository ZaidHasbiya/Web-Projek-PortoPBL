<?php
include 'koneksi.php';

$query = "SELECT * FROM users WHERE jurusan = 'teknik elektro' AND role='mahasiswa'";
$data = mysqli_query($koneksi, $query);

?>

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
</head>

<body>

  <!-- ===== Navbar ===== -->
  <?php include 'layouts/navbar_publik.php'; ?>

  <div class="container">
    <h1 class="my-5 pt-5">Jurusan Teknik Elektro</h1>
    <?php if (mysqli_num_rows($data) > 0 ) : ?>
     <div class="d-flex flex-wrap justify-content-evenly align-items-start gap-4">
        <?php while ($row = mysqli_fetch_assoc($data)): ?>
      <!-- Card 1 -->
      <div class="col-md-4 col-lg-3">
        <div class="card shadow-sm border-0 h-100">
          <div class="ratio ratio-1x1">
            <img src="tim/profil-kosong.jpeg" class="card-img-top rounded-2" alt="Foto Mahasiswa" style="object-fit: cover;">
          </div>
          <div class="card-body text-center">
            <p class="mb-1"><strong>Nama:</strong> <?= $row['nama']; ?></p>
            <p class="mb-1"><strong>NIM:</strong> <?=  $row['username']; ?></p>
            <p class="mb-3"><strong>Jurusan:</strong> <?= $row['jurusan']; ?></p>

            <a href="lihat_profil_mhs.php?id=<?= $row['id']; ?>" class="btn btn-info px-4">Lihat Profil</a>

          </div>
        </div>
      </div>
      <?php endwhile;?>
      <!-- Card 3 -->
      <?php else: ?>
        <h2>Belum ada mahasiswa</h2>
    </div>
    <?php endif; ?>
  </div>
  <img src="asset/wave-dark-blue.svg">
  <footer class="text-center py-3 bg-light mt-5">
    &copy; <span>2025</span> Tim Web Portofolio Projek PBL
  </footer>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>