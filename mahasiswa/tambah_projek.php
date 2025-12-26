<?php
/*
Nama File        : tambah_projek.php
Deskripsi   : File ini digunakan untuk menambahkan data projek mahasiswa,
              termasuk upload gambar, validasi input, dan penyimpanan ke database
Dibuat Oleh    : Zaid Hasbiya Abrar - NIM : [3312501046]
Tanggal     : 10 Oktober 2025
*/

include '../koneksi.php';

// memulai session
session_start();

// Cek login
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'mahasiswa') {
    echo "<script>
            alert('Maaf, anda bukan mahasiswa. Silakan login ulang.');
            window.location.href = '../login.php';
          </script>";
    exit;
}

$user_id = $_SESSION['id'];

// Proses tambah projek
if (isset($_POST['tambah'])) {

    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $link = $_POST['link'];
    $link_repo = $_POST['link_repo'];
    $tgl_pembuatan = $_POST['tgl_pembuatan'];
    $tgl_selesai = $_POST['tgl_selesai'];

    // Ubah link YouTube ke format embed
    if (strpos($link, "youtu.be") !== false) {
        $id = basename($link);
        $link = "https://www.youtube.com/embed/$id";
    } else {
        $link = str_replace("watch?v=", "embed/", $link);
    }

    // Konfigurasi upload gambar
    $gambar = time() . '_' . basename($_FILES['gambar_projek']['name']);
    $tmp = $_FILES['gambar_projek']['tmp_name'];
    $ukuran = $_FILES['gambar_projek']['size'];
    $error = $_FILES['gambar_projek']['error'];

    $folder = "../asset/uploads/";
    $max_size = 20 * 1024 * 1024;
    $allowed_ext = ['jpg', 'jpeg', 'png'];

    if ($error !== 0) {
        echo "<script>alert('Terjadi kesalahan upload gambar!');history.back();</script>";
        exit;
    }

    $ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_ext)) {
        echo "<script>alert('Format gambar harus JPG, JPEG, atau PNG');history.back();</script>";
        exit;
    }

    if ($ukuran > $max_size) {
        echo "<script>alert('Ukuran gambar maksimal 20 MB');history.back();</script>";
        exit;
    }

    move_uploaded_file($tmp, $folder . $gambar);

    // Simpan ke database
    $query = "INSERT INTO projek 
              (user_id, judul, deskripsi, link, link_repo, gambar_projek, tgl_pembuatan, tgl_selesai)
              VALUES
              ('$user_id', '$judul', '$deskripsi', '$link', '$link_repo', '$gambar', '$tgl_pembuatan', '$tgl_selesai')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Projek berhasil ditambahkan');window.location='projek_saya.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan projek');history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tambah Projek | PortoPBL</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../styles.css">
</head>

<body>

<div class="container my-5">
  <h3 class="mb-4">Tambah Projek</h3>

  <form method="post" enctype="multipart/form-data">

    <div class="mb-3">
      <label class="form-label">Judul Projek</label>
      <input type="text" class="form-control" name="judul" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Deskripsi Projek</label>
      <textarea class="form-control" name="deskripsi" rows="3" required></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Tautan Video</label>
      <input type="url" class="form-control" name="link" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Tautan Repositori</label>
      <input type="url" class="form-control" name="link_repo" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Foto Projek</label>
      <input type="file" class="form-control" name="gambar_projek" accept=".jpg,.jpeg,.png" required>
      <small class="text-danger">Format jpg, jpeg, png (maks 20MB)</small>
    </div>

    <div class="mb-3">
      <label class="form-label">Tanggal Pembuatan</label>
      <input type="date" class="form-control" name="tgl_pembuatan" required>
    </div>

    <div class="mb-4">
      <label class="form-label">Tanggal Selesai</label>
      <input type="date" class="form-control" name="tgl_selesai" required>
    </div>

    <div class="d-flex justify-content-between">
      <a href="projek_saya.php" class="btn btn-secondary">Kembali</a>
      <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
    </div>

  </form>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
