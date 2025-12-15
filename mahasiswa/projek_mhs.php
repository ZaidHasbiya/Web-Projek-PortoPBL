<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['nama'])){
    echo "<script>alert('Silahkan Melakukan Login Terlebih Dahulu'); window.location.href = 'login.php';</script>";
    exit;
}

if ($_SESSION['role'] !== 'mahasiswa') {
    echo "<script>
            alert('Maaf, anda bukan mahasiswa. Silakan login ulang.');
            window.location.href = 'login.php';
          </script>";
    exit;
}

$user_id = $_SESSION['id'];

$query = "SELECT projek.*, users.nama, users.username 
          FROM projek 
          JOIN users ON projek.user_id = users.id 
          ORDER BY projek.judul ASC";

$data = mysqli_query ($koneksi, $query);
$result = mysqli_num_rows($data);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PortoPBL</title>

  <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
  crossorigin="anonymous"/>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../css/bootstrap.min.css">

  <link rel="stylesheet" href="../styles.css" type="text/css">
</head>

<body>

  <?php include '../layouts/navbar_mhs.php'; ?>
  <div class="container">
    <h1 class="my-5 pt-5">Projek</h1>
    <?php if ($result > 0 ):?>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php while($row = mysqli_fetch_assoc($data)) :?>
  <div class="col">
    <div class="card border border-info">
      <img src="../asset/uploads/<?= $row['gambar_projek']; ?>" class="card-img-top" alt="Projek Web Portofolio PBL">
      <div class="card-body">
        <h5 class="card-title"><?= $row['judul']; ?></h5>
        <p class="card-text">Deskripsi Projek : <?= $row['deskripsi']; ?></p>
        <p class="card-text">Dibuat Oleh :</p>
        <p class="card-text">Nama Mahasiswa : <?= $row['nama']; ?></p>
        <p class="card-text">NIM : <?= $row['username']; ?></p>
        <a href="lihat_projek_mhs.php?projek_id=<?= $row['projek_id']; ?>" class="btn btn-outline-info rounded-pill d-flex justify-content-center strk-btn">Lihat Projek</a>
      </div>
    </div>
  </div>
  <?php endwhile; ?>
  </div>
  <?php else : ?>
    <h2>Belum ada projek</h2>
  <?php endif; ?>
  </div>

<div class="overflow-hidden mt-5">
  <img src="../asset/wave-new-navy.svg"
       class="img-fluid d-block"
       style="width:100vw"
       alt="wave">
</div>

<footer class="w-100 text-center py-3 bg-light">
  &copy; <span>2025</span> Tim Web Portofolio Projek PBL
</footer>

  <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>