<?php
include '../koneksi.php';
session_start();

if (!isset($_SESSION['nama']) || $_SESSION['role'] !== 'mahasiswa') {
    echo "<script>
            alert('Maaf, anda bukan mahasiswa. Silakan login ulang.');
            window.location.href = 'login.php';
          </script>";
    exit;
}

$user_id = $_SESSION['id'];

if(!isset($_GET['projek_id'])){
  echo "<script>alert('Projek tidak ditemukan!');window.location='projek_saya.php';</script>";
  exit;
}
$projek_id = $_GET['projek_id'];
$query = "SELECT * FROM projek WHERE projek_id = '$projek_id'";
$result = mysqli_query($koneksi, $query);
$projek = mysqli_fetch_assoc($result);

if (!$projek) {
  echo "<script>alert('Data projek tidak ditemukan!');window.location='projek_saya.php';</script>";
  exit;
}

if (isset($_POST['edit'])) {
  $judul = $_POST['judul'];
  $deskripsi = $_POST['deskripsi'];
  $link = $_POST['link'];
  $tgl_pembuatan = $_POST['tgl_pembuatan'];
  $tgl_selesai = $_POST['tgl_selesai'];

  $gambar = $projek['gambar_projek'];
  if (!empty($_FILES['gambar_projek']['name'])) {
      $namaFile = $_FILES['gambar_projek']['name'];
      $tmpName  = $_FILES['gambar_projek']['tmp_name'];

      move_uploaded_file($tmpName, 'asset/uploads/' . $namaFile);

      $gambar = $namaFile;
  }

  $query = "UPDATE projek 
            SET judul = '$judul', 
                deskripsi = '$deskripsi',
                link = '$link',
                tgl_pembuatan = '$tgl_pembuatan',
                tgl_selesai = '$tgl_selesai',
                gambar_projek = '$gambar'
            WHERE projek_id = '$projek_id'";

  if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Projek berhasil diperbarui!');window.location='projek_saya.php';</script>";
  } else {
    echo "<script>alert('Gagal memperbarui projek!');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Projek | PortoPBL</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../styles.css" type="text/css">
</head>

<body>
  <div class="container my-5">
    <h3 class="mb-4">Edit Projek</h3>
    <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="projek_id" value="<?= $projek['projek_id'] ?>">
      <div class="mb-3">
        <label for="judul" class="form-label">Judul Proyek</label>
        <input type="text" class="form-control" id="judul" name="judul" value="<?= ($projek['judul'])?>">
      </div>

      <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi Proyek</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= $projek['deskripsi'] ?></textarea>
      </div>

      <div class="mb-3">
        <label for="video" class="form-label">Link Video</label>
        <input type="url" class="form-control" id="video" name="link" value="<?= $projek['link'] ?>">
      </div>

      <div class="mb-3">
        <label for="gambar_projek" class="form-label">Foto Proyek</label>
        <div class="form-text text-danger mb-2">
          File foto berupa jpg, jpeg, atau png dan tidak melebihi 20Mb
        </div>
        <?php if (!empty($projek['gambar_projek'])): ?>
          <div class="mt-2">
            <img src="asset/uploads/<?= htmlspecialchars($projek['gambar_projek']) ?>" alt="Gambar Projek" width="200">
          </div>
        <?php endif; ?><br>
        <input type="file" class="form-control" id="gambar_projek" name="gambar_projek" accept=".jpg,.jpeg,.png">
      </div>

      <div class="mb-3">
        <label for="tgl_pembuatan" class="form-label">Tanggal Pembuatan</label>
        <input type="date" class="form-control" id="tgl_pembuatan" name="tgl_pembuatan" value="<?= $projek['tgl_pembuatan'] ?>">
      </div>

      <div class="mb-4">
        <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
        <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" value="<?= $projek['tgl_selesai'] ?>">
      </div>

      <div class="d-flex justify-content-between">
        <a href="projek_saya.php" class="btn btn-primary">Kembali</a>
        <button type="submit" class="btn btn-success" name="edit">EDIT</button>
      </div>
    </form>
  </div>

  <img src="../asset/wave-info.svg" class="w-100" alt="">
  <footer class="text-center py-3 bg-light mt-5">
    &copy; <span>2025</span> Tim Web Portofolio Projek PBL
  </footer>

  <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
