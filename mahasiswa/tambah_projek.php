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

if(isset($_POST['tambah'])){
  $judul = $_POST['judul'];
  $deskripsi = $_POST['deskripsi'];
  $link = $_POST['link'];

if (strpos($link, "youtu.be") !== false) {
    $id = basename($link);
    $link = "https://www.youtube.com/embed/$id";
} else {
    $link = str_replace("watch?v=", "embed/", $link);
}

  $tgl_pembuatan = $_POST['tgl_pembuatan'];
  $tgl_selesai = $_POST['tgl_selesai'];

  $gambar = $_FILES['gambar_projek']['name'];
    $tmp = $_FILES['gambar_projek']['tmp_name'];
    $folder = "asset/uploads/";

    if (file_exists($folder . $gambar)) {
        echo "<script>alert('Gagal! Nama file sudah ada, silakan ganti nama file.'); window.history.back();</script>";
        exit;
    }

    move_uploaded_file($tmp, $folder . $gambar);

    $query = ("INSERT INTO projek (user_id, judul, deskripsi, link, gambar_projek, tgl_pembuatan, tgl_selesai) VALUES ('$user_id', '$judul', '$deskripsi','$link', '$gambar', '$tgl_pembuatan', '$tgl_selesai')");
    $result = mysqli_query($koneksi, $query);

    if($result){
      echo "<script>alert('Projek berhasil ditambahkan!'); window.location='projek_saya.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan projek!'); window.location='tambah_projek.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tambah Projek | PortoPBL</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../styles.css" type="text/css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <div class="container my-5">
    <h3 class="mb-4">Tambah Projek</h3>

    <form action="#" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="judul" class="form-label">Judul Proyek</label>
        <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul Proyek" required>
      </div>

      <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi Proyek</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi Proyek" rows="3" required></textarea>
      </div>

      <div class="mb-3">
        <label for="video" class="form-label">Link Video</label>
        <input type="url" class="form-control" id="video" name="video" placeholder="Link Video" required>
      </div>

      <div class="mb-3">
        <label for="foto" class="form-label">Foto Proyek</label>
        <div class="form-text text-danger mb-2">
          File foto berupa jpg, jpeg, dan png dan tidak melebihi 20Mb
        </div>
        <input type="file" class="form-control" id="foto" name="gambar_projek" accept=".jpg,.jpeg,.png" required>
      </div>

      <div class="mb-3">
        <label for="tgl_pembuatan" class="form-label">Tanggal Pembuatan</label>
        <input type="date" class="form-control" id="tgl_pembuatan" name="tgl_pembuatan" required>
      </div>

      <div class="mb-4">
        <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
        <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" required>
      </div>

      <div class="d-flex justify-content-between">
        <a href="projek_saya.html" class="btn btn-primary">Kembali</a>
        <button type="submit" class="btn btn-success" name="tambah">TAMBAH</button>
      </div>
    </form>
  </div>

  <img src="../asset/wave-dark-blue.svg" class="w-100" alt="">
  <footer class="text-center py-3 bg-light mt-5">
    &copy; <span>2025</span> Tim Web Portofolio Projek PBL
  </footer>

  <script src="../js/bootstrap.bundle.min.js"></script>
  <script src="tambah.js"></script>
</body>
</html>
