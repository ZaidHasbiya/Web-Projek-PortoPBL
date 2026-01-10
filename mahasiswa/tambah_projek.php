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
    $_SESSION['projek_error'] = 'Maaf, anda bukan mahasiswa. Silakan login ulang.';
    $_SESSION['redirect_to'] = '../login.php';
    header("Location: ../login.php"); // Atau tetap di halaman ini untuk trigger Swal
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
        $_SESSION['projek_error'] = 'Terjadi kesalahan upload gambar!';
        header("Location: tambah_projek.php");
        exit;
    }

    $ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_ext)) {
        $_SESSION['projek_error'] = 'Format gambar harus JPG, JPEG, atau PNG';
        header("Location: tambah_projek.php");
        exit;
    }

    if ($ukuran > $max_size) {
        $_SESSION['projek_error'] = 'Ukuran gambar maksimal 20 MB';
        header("Location: tambah_projek.php");
        exit;
    }

    if (move_uploaded_file($tmp, $folder . $gambar)) {
        // Simpan ke database
        $query = "INSERT INTO projek 
                  (user_id, judul, deskripsi, link, link_repo, gambar_projek, tgl_pembuatan, tgl_selesai)
                  VALUES
                  ('$user_id', '$judul', '$deskripsi', '$link', '$link_repo', '$gambar', '$tgl_pembuatan', '$tgl_selesai')";

        if (mysqli_query($koneksi, $query)) {
            $_SESSION['projek_success'] = true;
        } else {
            $_SESSION['projek_error'] = 'Gagal menyimpan data ke database';
        }
    } else {
        $_SESSION['projek_error'] = 'Gagal memindahkan file ke folder uploads';
    }
    
    header("Location: tambah_projek.php");
    exit;
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<style>
body {
    background-color: #fdf6e3 !important;
    color: #2d3748;
}

h1,
h2,
h3,
label {
    color: #2d3748;
}

.btn-clr {
    background-color: #1D5D8C !important;
    color: #fff !important;
    border-radius: 7px;
    border: none;
}

.btn-clr:hover {
    opacity: .9;
}
</style>

<body>

    <div class="container my-5 d-flex justify-content-center">
    <div class="card p-4 shadow" style="max-width: 650px; width: 100%;">
        <h3 class="mb-4 text-center">Tambah Projek</h3>

        <form method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label fw-semibold">Judul Projek</label>
                <input type="text" class="form-control" name="judul" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi Projek</label>
                <textarea class="form-control" name="deskripsi" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Tautan Video</label>
                <input type="url" class="form-control" name="link" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Tautan Repositori</label>
                <input type="url" class="form-control" name="link_repo" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Foto Projek</label>
                <input type="file" class="form-control" name="gambar_projek" accept=".jpg,.jpeg,.png" required>
                <small class="text-danger">Format jpg, jpeg, png (maks 20MB)</small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Tanggal Pembuatan</label>
                <input type="date" class="form-control" name="tgl_pembuatan" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Tanggal Selesai</label>
                <input type="date" class="form-control" name="tgl_selesai" required>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="projek_saya.php" class="btn btn-clr text-white px-4">Kembali</a>
                <button type="submit" name="tambah" class="btn btn-success px-4">Tambah</button>
            </div>

        </form>
    </div>
</div>


    <script src="../js/bootstrap.bundle.min.js"></script>

    <?php if (isset($_SESSION['projek_success'])): ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Projek berhasil ditambahkan',
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        window.location.href = 'projek_saya.php';
    });
    </script>
    <?php unset($_SESSION['projek_success']); endif; ?>

    <?php if (isset($_SESSION['projek_error'])): ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '<?= $_SESSION['projek_error']; ?>'
    }).then(() => {
        <?php if (isset($_SESSION['redirect_to'])): ?>
        window.location.href = '<?= $_SESSION['redirect_to']; ?>';
        <?php unset($_SESSION['redirect_to']); endif; ?>
    });
    </script>
    <?php unset($_SESSION['projek_error']); endif; ?>

</body>

</html>