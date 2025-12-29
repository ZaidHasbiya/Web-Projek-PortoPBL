<?php
/*
Nama File   : edit_profil.php
Deskripsi   : Mengelola proses pengubahan profil mahasiswa,
             termasuk deskripsi diri, prestasi, dan foto profil
Dibuat Oleh    : Zaid Hasbiya Abrar - NIM : [3312501046]
Tanggal     : 29 November 2025
*/

include '../koneksi.php';

session_start();
// Memulai session untuk validasi login

// Validasi akses: hanya mahasiswa yang boleh mengakses halaman ini
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'mahasiswa') {
    echo "<script>
            alert('Maaf, anda bukan mahasiswa. Silakan login ulang.');
            window.location.href = '../login.php';
          </script>";
    exit;
}

// Mengambil ID user dari session
$user_id = $_SESSION['id'];

// Mengambil data mahasiswa berdasarkan ID
$data = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($data);

// Proses ketika tombol edit ditekan
if (isset($_POST['edit'])) {

    // Mengambil input deskripsi dan prestasi
    $deskripsi = $_POST['deskripsi_diri'];
    $prestasi  = $_POST['prestasi'];

    // Cek apakah user mengunggah foto profil baru
    if (!empty($_FILES['foto_profil']['name'])) {

        // Informasi file upload
        $namaFile = $_FILES['foto_profil']['name'];
        $tmpName  = $_FILES['foto_profil']['tmp_name'];
        $fileSize = $_FILES['foto_profil']['size'];
        $error    = $_FILES['foto_profil']['error'];

        // Validasi error upload
        if ($error !== 0) {
            echo "<script>alert('Terjadi kesalahan saat upload file'); history.back();</script>";
            exit;
        }

        // Validasi ekstensi file
        $extValid = ['jpg', 'jpeg', 'png'];
        $extFile  = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

        if (!in_array($extFile, $extValid)) {
            echo "<script>alert('Format file harus JPG, JPEG, atau PNG'); history.back();</script>";
            exit;
        }

        // Validasi ukuran file (maksimal 20MB)
        if ($fileSize > 20 * 1024 * 1024) {
            echo "<script>alert('Ukuran file maksimal 20 MB'); history.back();</script>";
            exit;
        }

        // Validasi MIME type untuk keamanan tambahan
        $mimeValid = ['image/jpeg', 'image/png'];
        $mimeFile  = mime_content_type($tmpName);

        if (!in_array($mimeFile, $mimeValid)) {
            echo "<script>alert('File bukan gambar yang valid'); history.back();</script>";
            exit;
        }

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

    } else {

        // Update data pengguna tanpa mengubah foto profil
        mysqli_query($koneksi, "UPDATE users SET
            deskripsi_diri = '$deskripsi',
            prestasi = '$prestasi'
            WHERE id = '$user_id'
        ");
    }

    // Notifikasi berhasil dan redirect ke halaman profil
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
    <!-- Metadata halaman -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ubah Profil | PortoPBL</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css" type="text/css">

</head>

<style>
body {
    background-color: #fdf6e3 !important;
    color: #2d3748;
}

h1, h2, h3, label {
    color: #2d3748;
}

.btn-clr {
    background-color: #1D5D8C !important;
    color: #fff !important;
    border-radius: 7px;
    border: none;
}

.btn-clr:hover{
    opacity: .9;
}
</style>


<body>

    <!-- Container utama form -->
    <div class="container my-5">
        <h3 class="mb-4">Ubah Profil</h3>

        <!-- Form edit profil -->
        <form action="#" method="post" enctype="multipart/form-data">

            <!-- Data identitas (read-only) -->
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

            <!-- Upload foto profil -->
            <div class="mb-3">
                <label for="foto_profil" class="form-label">Foto Profil</label>
                <div class="form-text text-danger mb-2">
                    File foto berupa jpg, jpeg, dan png dan tidak melebihi 20Mb
                </div>
                <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept=".jpg,.jpeg,.png">
            </div>

            <!-- Input prestasi -->
            <div class="mb-3">
                <label class="form-label">Catatan Prestasi</label>
                <textarea class="form-control" name="prestasi"
                    rows="3"><?= $user['prestasi'] ?: 'Belum Diatur'; ?></textarea>
            </div>

            <!-- Input deskripsi diri -->
            <div class="mb-3">
                <label class="form-label">Deskripsi Diri</label>
                <textarea class="form-control" name="deskripsi_diri"
                    rows="4"><?= $user['deskripsi_diri'] ?: 'Belum Diatur'; ?></textarea>
            </div>

            <!-- Tombol aksi -->
            <div class="d-flex justify-content-between">
                <a href="profil_saya.php" class="btn btn-clr text-white">
                    Kembali
                </a>
                <button type="submit" name="edit" class="btn btn-success">UBAH</button>
            </div>

        </form>
    </div>

    <!-- Wave -->
    <div class="overflow-hidden mt-5">
        <img src="../asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave">
    </div>

    <!-- Footer -->
    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <!-- Bootstrap JS -->
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>