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
          WHERE jurusan = 'teknik informatika'
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
.search-box {
    width: 100%;
    max-width: 550px;
    background: #ffffff;
    border-radius: 14px;
    padding: 6px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.search-box input {
    border-radius: 12px 0 0 12px;
    padding: 10px 15px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.search-box input:focus {
    box-shadow: inset 0 0 5px rgba(0,123,255,0.5);
    outline: none;
}

.search-box .btn {
    border-radius: 0 12px 12px 0; 
    background-color: var(--navbar-bg-color, #14446e); 
    color: #fff;
    font-weight: 600;
    transition: all 0.3s ease;
}

.search-box .btn:hover {
    background-color: #1D5D8C; 
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

</style>
<body>

  <!-- ===== Navbar ===== -->
<?php include '../layouts/navbar_dosen.php'; ?>
  <div class="text-center pt-4 mb-4">
  <h1 class="fw-bold display-6 mb-2">Jurusan Teknik Informatika</h1>
</div>

<form method="GET" class="d-flex justify-content-center mb-5">
  <div class="search-box shadow-sm">
    <div class="input-group input-group-lg">
      <input 
        type="text" 
        name="search" 
        class="form-control border-0"
        placeholder="Cari nama atau NIM Mahasiswa"
        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
      <button type="submit" class="btn btn-clr px-4 fw-semibold">
        Cari
      </button>
    </div>
  </div>
</form>


    <?php if (mysqli_num_rows($data) > 0 ) : ?>
     <div class="d-flex flex-wrap justify-content-evenly align-items-start gap-4">
        <?php while ($row = mysqli_fetch_assoc($data)): ?>
          <?php
          $foto = !empty($row['foto_profil']) ? "../asset/profil/" . $row['foto_profil'] : "../tim/profil-kosong.jpeg";
        ?>
      <!-- Card 1 -->
      <div class="col-md-4 col-lg-3">
        <div class="card shadow-sm border-0 h-100">
          <div class="ratio ratio-1x1">
            <img src="<?= $foto ?>" class="card-img-top rounded-2" alt="Foto Mahasiswa" style="object-fit: cover;">
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