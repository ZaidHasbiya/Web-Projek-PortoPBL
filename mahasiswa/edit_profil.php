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

$data = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($data);

if (isset($_POST['edit'])) {
  $deskripsi = $_POST['deskripsi_diri'];
  $prestasi = $_POST['prestasi'];

    if (!empty($_FILES['foto_profil']['name'])) {
        $namaFile = $_FILES['foto_profil']['name'];
        $tmpName  = $_FILES['foto_profil']['tmp_name'];

        move_uploaded_file($tmpName, '../asset/profil/' . $namaFile);

        mysqli_query($koneksi, "UPDATE users SET foto_profil = '$namaFile', deskripsi_diri = '$deskripsi', prestasi = '$prestasi' WHERE id = '$user_id'");
    }else {
    mysqli_query($koneksi, "UPDATE users SET 
        deskripsi_diri = '$deskripsi',
        prestasi = '$prestasi'
        WHERE id = '$user_id'");
}

    echo "<script>
            alert('Profil berhasil diperbarui!');
            window.location.href = 'profil_saya.php';
          </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ubah Profil | PortoPBL</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../styles.css" type="text/css">
  <link rel="stylesheet" href="../custom.css">
</head>

<body>
  <div class="container my-5">
    <h3 class="mb-4">Ubah Profil</h3>
    <form action="#" method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text" class="form-control" value="<?= $user['nama']; ?>" readonly>
  </div>

  <div class="mb-3">
    <label class="form-label">NIM</label>
    <input type="text" class="form-control" value="<?= $user['username']; ?>" readonly>
  </div>

  <div class="mb-3">
    <label class="form-label">Jurusan</label>
    <input type="text" class="form-control" value="<?= $user['jurusan']; ?>" readonly>
  </div>

  <div class="mb-3">
    <label for="foto_profil" class="form-label">Foto Profil</label>
    <div class="form-text text-danger mb-2">
      File foto berupa jpg, jpeg, dan png dan tidak melebihi 20Mb
    </div>
    <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept=".jpg,.jpeg,.png">
  </div>

  <div class="mb-3">
  <label class="form-label">Catatan Prestasi</label>
  <textarea class="form-control" name="prestasi" rows="3"><?= $user['prestasi'] ?: 'Belum Diatur'; ?></textarea>
</div>

<div class="mb-3">
  <label class="form-label">Deskripsi Diri</label>
  <textarea class="form-control" name="deskripsi_diri" rows="4"><?= $user['deskripsi_diri'] ?: 'Belum Diatur'; ?></textarea>
</div>

  <div class="d-flex justify-content-between">
    <a href="profil_saya.php" class="btn btn-clr">Kembali</a>
    <button type="submit" name="edit" class="btn btn-success">UBAH</button>
  </div>
</form>
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
