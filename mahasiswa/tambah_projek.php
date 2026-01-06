<?php
/*
Nama File        : tambah_projek.php
Deskripsi        : Menambahkan projek mahasiswa, validasi input, upload gambar, dan simpan ke database
Dibuat Oleh      : Zaid Hasbiya Abrar - NIM : [3312501046]
Tanggal          : 10 Oktober 2025
*/

include '../koneksi.php';
session_start();

// Cek login & role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'mahasiswa') {
    $_SESSION['access_denied'] = true;
    header("Location: ../login.php");
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

    // Konversi link YouTube ke embed
    if (strpos($link, "youtu.be") !== false) {
        $id = basename($link);
        $link = "https://www.youtube.com/embed/$id";
    } else {
        $link = str_replace("watch?v=", "embed/", $link);
    }

    // Upload gambar
    $gambar = time() . '_' . basename($_FILES['gambar_projek']['name']);
    $tmp = $_FILES['gambar_projek']['tmp_name'];
    $ukuran = $_FILES['gambar_projek']['size'];
    $error = $_FILES['gambar_projek']['error'];

    $folder = "../asset/uploads/";
    $max_size = 20 * 1024 * 1024;
    $allowed_ext = ['jpg', 'jpeg', 'png'];

    $error_msg = '';

    if ($error !== 0) $error_msg = 'Terjadi kesalahan upload gambar!';
    $ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_ext)) $error_msg = 'Format gambar harus JPG, JPEG, atau PNG';
    if ($ukuran > $max_size) $error_msg = 'Ukuran gambar maksimal 20 MB';

    if ($error_msg === '') move_uploaded_file($tmp, $folder . $gambar);

    // Simpan ke database
    if ($error_msg === '') {
        $query = "INSERT INTO projek 
                  (user_id, judul, deskripsi, link, link_repo, gambar_projek, tgl_pembuatan, tgl_selesai)
                  VALUES
                  ('$user_id', '$judul', '$deskripsi', '$link', '$link_repo', '$gambar', '$tgl_pembuatan', '$tgl_selesai')";
        if (mysqli_query($koneksi, $query)) {
            $_SESSION['projek_success'] = true;
        } else {
            $error_msg = 'Gagal menambahkan projek ke database';
        }
    }

    if ($error_msg !== '') $_SESSION['projek_error'] = $error_msg;

    header("Location: tambah_projek.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Projek | PortoPBL</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../styles.css">

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body { background-color: #fdf6e3 !important; color: #2d3748; font-family: 'Poppins', sans-serif; }
h1,h2,h3,label { color: #2d3748; }
.btn-clr { background-color: #1D5D8C !important; color: #fff !important; border-radius: 7px; border: none; }
.btn-clr:hover { opacity: .9; }
</style>
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
            <a href="projek_saya.php" class="btn btn-clr text-white">Kembali</a>
            <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
        </div>

    </form>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 Notifikasi -->
<?php if (isset($_SESSION['projek_success'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Projek Berhasil Ditambahkan!',
    timer: 2000,
    showConfirmButton: false
}).then(() => { window.location.href = 'projek_saya.php'; });
</script>
<?php unset($_SESSION['projek_success']); endif; ?>

<?php if (isset($_SESSION['projek_error'])): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal Menambahkan Projek',
    text: '<?= $_SESSION['projek_error']; ?>'
});
</script>
<?php unset($_SESSION['projek_error']); endif; ?>

</body>
</html>
