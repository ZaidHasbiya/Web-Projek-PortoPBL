<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['nama'])) {
  echo "<script>
          alert('Silakan login terlebih dahulu!');
          window.location.href = 'login.php';
        </script>";
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

$query = "SELECT projek.*, users.nama, users.username FROM projek JOIN users ON projek.user_id = users.id WHERE user_id = '$user_id'";
$result = mysqli_query($koneksi, $query);
$jumlah_projek = mysqli_num_rows($result);

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
  <div class="container mt-5 pt-5">
    <div class="d-flex justify-content-between align-items-center my-5">
  <h1 class="m-0">Projek Saya</h1>
  <a href="tambah_projek.php" class="btn btn-info text-white">
    <i class="fas fa-plus"></i> Tambah Projek
  </a>
</div>

<?php if ($jumlah_projek > 0): ?>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="col">
          <div class="card border border-info">
            <img src="../asset/uploads/<?= htmlspecialchars($row['gambar_projek']); ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($row['judul']); ?></h5>
              <p class="card-text">Deskripsi Projek : <?= htmlspecialchars($row['deskripsi']); ?></p>
              <p class="card-text">Dibuat Oleh : <?= ($row['nama']); ?></p>
              <p class="card-text">NIM : <?= ($row['username']); ?></p>

              <div class="d-flex justify-content-center gap-2 mb-2">
                <a href="edit_projek.php?projek_id=<?= $row['projek_id']; ?>" class="btn btn-warning btn-sm d-flex align-items-center gap-1">
                  <i class="fas fa-edit"></i> Edit
                </a>
                <a href="hapus_projek.php?projek_id=<?= $row['projek_id']; ?>" class="btn btn-danger btn-sm d-flex align-items-center gap-1" onclick="return confirm('Yakin ingin menghapus projek ini?');">
                  <i class="fas fa-trash-alt"></i> Hapus
                </a>
              </div>
              <a href="lihat_projek_mhs.php?projek_id=<?= $row['projek_id']; ?>" class="btn btn-outline-info rounded-pill d-flex justify-content-center">Lihat Projek</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="text-center my-5">
      <i class="fas fa-folder-open fa-3x text-info mb-3"></i>
      <p class="fs-5 text-muted">Belum ada projek yang kamu buat.</p>
    </div>
  <?php endif; ?>
  </div>
  <img src="../asset/wave-dark-blue.svg">
  <footer class="text-center py-3 bg-light mt-5">
    &copy; <span>2025</span> Tim Web Portofolio Projek PBL
  </footer>

  <script src="../js/bootstrap.bundle.min.js"></script>
  <script src="../script.js"></script>
</body>

</html>