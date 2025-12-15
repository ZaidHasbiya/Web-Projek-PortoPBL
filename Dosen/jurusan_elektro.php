<?php
include '../koneksi.php';
session_start();

if (!isset($_SESSION['nama']) || $_SESSION['role'] !== 'dosen') {
    echo "<script>
            alert('Maaf, anda bukan dosen. Silakan login ulang.');
            window.location.href = 'login.php';
          </script>";
    exit;
}

$user_id = $_SESSION['id'];

$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM users
          WHERE jurusan = 'teknik elektro'
          AND role = 'mahasiswa'";

if (!empty($search)) {
    $query .= " AND (
                  nama LIKE '%$search%'
                  OR username LIKE '%$search%'
               )";
}

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

  <link rel="stylesheet" href="../css/bootstrap.min.css">

  <link rel="stylesheet" href="../styles.css" type="text/css">
  <link rel="stylesheet" href="../custom.css">
</head>
<style>

.navbar {
    position: relative;
    z-index: 10;
}
</style>
<body>

  <!-- ===== Navbar ===== -->
<?php include '../layouts/navbar_dosen.php'; ?>
  <div class="container">
    <h1 class="py-5 mt-5">Jurusan Teknik Elektro</h1>
    <form method="GET" class="row mb-4">
  <div class="col-md-6 col-lg-4">
    <input 
      type="text" 
      name="search" 
      class="form-control"
      placeholder="Cari nama / NIM mahasiswa..."
      value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
  </div>
  <div class="col-auto">
    <button type="submit" class="btn btn-clr">
      Cari
    </button>
  </div>
</form>

    <?php if (mysqli_num_rows($data) > 0 ) : ?>
     <div class="d-flex flex-wrap justify-content-evenly align-items-start gap-4">
        <?php while ($row = mysqli_fetch_assoc($data)): ?>
      <!-- Card 1 -->
      <div class="col-md-4 col-lg-3">
        <div class="card shadow-sm border-0 h-100">
          <div class="ratio ratio-1x1">
            <img src="../tim/profil-kosong.jpeg" class="card-img-top rounded-2" alt="Foto Mahasiswa" style="object-fit: cover;">
          </div>
          <div class="card-body text-center">
            <p class="mb-1"><strong>Nama:</strong> <?= $row['nama'] ?></p>
            <p class="mb-1"><strong>NIM:</strong> <?=  $row['username'] ?></p>
            <p class="mb-3"><strong>Jurusan:</strong> <?= $row['jurusan'] ?></p>
            <a href="lihat_profil_mhs.php?id=<?= $row['id'] ?>" class="btn btn-info px-4 btn-clr">Lihat Profil</a>
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