<?php
/*
Nama File   : edit_profil.php
Deskripsi   : Mengelola proses pengubahan profil mahasiswa,
<<<<<<< HEAD
             termasuk deskripsi diri, prestasi, dan foto profil
Dibuat Oleh : Zaid Hasbiya Abrar - NIM : [3312501046]
Tanggal     : 29 November 2025
=======
              termasuk deskripsi diri, prestasi, dan foto profil
Dibuat Oleh    : Zaid Hasbiya Abrar - NIM : [3312501046]
Tanggal      : 29 November 2025
>>>>>>> bf556ff (Merubah seluruh desain web)
*/

session_start();
include '../koneksi.php';

// Validasi akses: hanya mahasiswa
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'mahasiswa') {
<<<<<<< HEAD
    $_SESSION['access_denied'] = true;
=======
    $_SESSION['access_denied'] = true; // Set session untuk alert di login.php jika diperlukan
>>>>>>> bf556ff (Merubah seluruh desain web)
    header("Location: ../login.php");
    exit;
}

// Ambil ID user
$user_id = $_SESSION['id'];

// Ambil data user
$data = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($data);

// Proses edit
if (isset($_POST['edit'])) {

    $deskripsi = $_POST['deskripsi_diri'];
    $prestasi  = $_POST['prestasi'];
    $error_msg = '';

    $error_msg = '';

    if (!empty($_FILES['foto_profil']['name'])) {

        $namaFile = $_FILES['foto_profil']['name'];
        $tmpName  = $_FILES['foto_profil']['tmp_name'];
        $fileSize = $_FILES['foto_profil']['size'];
        $error    = $_FILES['foto_profil']['error'];

<<<<<<< HEAD
        if ($error !== 0) $error_msg = 'Terjadi kesalahan saat upload file';
=======
        // Validasi error upload
        if ($error !== 0) {
            $error_msg = 'Terjadi kesalahan saat upload file';
        }
>>>>>>> bf556ff (Merubah seluruh desain web)

        $extValid = ['jpg', 'jpeg', 'png'];
        $extFile  = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
        if (!in_array($extFile, $extValid)) $error_msg = 'Format file harus JPG, JPEG, atau PNG';

<<<<<<< HEAD
        if ($fileSize > 20 * 1024 * 1024) $error_msg = 'Ukuran file maksimal 20 MB';

        $mimeValid = ['image/jpeg', 'image/png'];
        $mimeFile  = mime_content_type($tmpName);
        if (!in_array($mimeFile, $mimeValid)) $error_msg = 'File bukan gambar yang valid';

        if ($error_msg === '') {
            $namaBaru = uniqid('profil_', true) . '.' . $extFile;
            move_uploaded_file($tmpName, '../asset/profil/' . $namaBaru);

            mysqli_query($koneksi, "UPDATE users SET
                foto_profil = '$namaBaru',
                deskripsi_diri = '$deskripsi',
                prestasi = '$prestasi'
                WHERE id = '$user_id'
            ");
        }

    } else {
        if ($error_msg === '') {
            mysqli_query($koneksi, "UPDATE users SET
                deskripsi_diri = '$deskripsi',
                prestasi = '$prestasi'
                WHERE id = '$user_id'
            ");
        }
    }

    // Set session untuk notifikasi
    if ($error_msg !== '') {
        $_SESSION['edit_error'] = $error_msg;
    } else {
        $_SESSION['edit_success'] = true;
    }

    // Redirect agar alert muncul di halaman sama
    header("Location: edit_profil.php");
=======
        if (empty($error_msg) && !in_array($extFile, $extValid)) {
            $error_msg = 'Format file harus JPG, JPEG, atau PNG';
        }

        // Validasi ukuran file (maksimal 20MB)
        if (empty($error_msg) && $fileSize > 20 * 1024 * 1024) {
            $error_msg = 'Ukuran file maksimal 20 MB';
        }

        // Validasi MIME type untuk keamanan tambahan
        if (empty($error_msg)) {
            $mimeValid = ['image/jpeg', 'image/png'];
            $mimeFile  = mime_content_type($tmpName);
            if (!in_array($mimeFile, $mimeValid)) {
                $error_msg = 'File bukan gambar yang valid';
            }
        }

        if (empty($error_msg)) {
            // Generate nama file baru agar tidak bentrok
            $namaBaru = uniqid('profil_', true) . '.' . $extFile;

            // Memindahkan file ke folder profil
            move_uploaded_file($tmpName, '../asset/profil/' . $namaBaru);

            // Update data pengguna beserta foto profil
            mysqli_query($koneksi, "UPDATE users SET
                foto_profil = '$namaBaru',
                deskripsi_diri = '$deskripsi',
                prestasi = '$prestasi'
                WHERE id = '$user_id'
            ");
        }

    } else {
        // Update data pengguna tanpa mengubah foto profil
        mysqli_query($koneksi, "UPDATE users SET
            deskripsi_diri = '$deskripsi',
            prestasi = '$prestasi'
            WHERE id = '$user_id'
        ");
    }

    // Set session untuk notifikasi SweetAlert
    if (!empty($error_msg)) {
        $_SESSION['edit_error'] = $error_msg;
        header("Location: edit_profil.php");
    } else {
        $_SESSION['edit_success'] = true;
        header("Location: edit_profil.php");
    }
>>>>>>> bf556ff (Merubah seluruh desain web)
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ubah Profil | PortoPBL</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<<<<<<< HEAD
    <!-- Bootstrap & CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css" type="text/css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    body { font-family: 'Poppins', sans-serif; background-color: #fdf6e3 !important; color: #2d3748; }
    h1,h2,h3,label { color: #2d3748; }
    .btn-clr { background-color: #1D5D8C !important; color: #fff !important; border-radius: 7px; border: none; }
    .btn-clr:hover { opacity: .9; }
    </style>
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
=======
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css" type="text/css">

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

    <div class="container my-5">
        <h3 class="mb-4">Ubah Profil</h3>

        <form action="#" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" value="<?= $user['nama']; ?>" readonly>
>>>>>>> bf556ff (Merubah seluruh desain web)
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

<<<<<<< HEAD
        <div class="d-flex justify-content-between">
            <a href="profil_saya.php" class="btn btn-clr text-white">Kembali</a>
            <button type="submit" name="edit" class="btn btn-success">UBAH</button>
        </div>

    </form>
</div>

<div class="overflow-hidden mt-5">
    <img src="../asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave">
</div>

<footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
    &copy; <span>2025</span> Tim Web Portofolio Projek PBL
</footer>
=======
            <div class="mb-3">
                <label for="foto_profil" class="form-label">Foto Profil</label>
                <div class="form-text text-danger mb-2">
                    File foto berupa jpg, jpeg, dan png dan tidak melebihi 20Mb
                </div>
                <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept=".jpg,.jpeg,.png">
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan Prestasi</label>
                <textarea class="form-control" name="prestasi"
                    rows="3"><?= $user['prestasi'] ?: 'Belum Diatur'; ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi Diri</label>
                <textarea class="form-control" name="deskripsi_diri"
                    rows="4"><?= $user['deskripsi_diri'] ?: 'Belum Diatur'; ?></textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="profil_saya.php" class="btn btn-clr text-white">
                    Kembali
                </a>
                <button type="submit" name="edit" class="btn btn-success">UBAH</button>
            </div>
>>>>>>> bf556ff (Merubah seluruh desain web)

<script src="../js/bootstrap.bundle.min.js"></script>

<<<<<<< HEAD
<!-- SweetAlert Notifikasi -->
<?php if (isset($_SESSION['edit_success'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Profil Berhasil Diubah!',
    text: 'Perubahan tersimpan',
    timer: 2000,
    showConfirmButton: false
});
</script>
<?php unset($_SESSION['edit_success']); endif; ?>

<?php if (isset($_SESSION['edit_error'])): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal Mengubah Profil',
    text: '<?= $_SESSION['edit_error']; ?>'
});
</script>
<?php unset($_SESSION['edit_error']); endif; ?>

=======
    <div class="overflow-hidden mt-5">
        <img src="../asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave">
    </div>

    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <script src="../js/bootstrap.bundle.min.js"></script>

    <?php if (isset($_SESSION['edit_success'])): ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Profil Berhasil Diubah!',
        text: 'Perubahan tersimpan',
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        window.location.href = 'profil_saya.php';
    });
    </script>
    <?php unset($_SESSION['edit_success']); endif; ?>

    <?php if (isset($_SESSION['edit_error'])): ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal Mengubah Profil',
        text: '<?= $_SESSION['edit_error']; ?>'
    });
    </script>
    <?php unset($_SESSION['edit_error']); endif; ?>

>>>>>>> bf556ff (Merubah seluruh desain web)
</body>
</html>
