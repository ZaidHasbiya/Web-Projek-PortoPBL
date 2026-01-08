<?php
/*
Nama File : ubah_password.php
Deskripsi : File ini digunakan untuk mengubah password akun mahasiswa
            yang sedang login pada sistem PortoPBL
Dibuat Oleh    : Zaid Hasbiya Abrar - NIM : [3312501046]
Tanggal     : 24 Desember 2025
*/

// Memanggil file koneksi database
include '../koneksi.php';

// Memulai session
session_start();

// Mengambil ID user dari session
$user_id = $_SESSION['id'];

// Mengecek apakah tombol ubah password ditekan
if (isset($_POST['ubah_password'])) {

    // Menyimpan input password baru
    $password_baru       = $_POST['password_baru'];

    // Menyimpan input konfirmasi password
    $konfirmasi_password = $_POST['konfirmasi_password'];

    // Validasi apakah password baru dan konfirmasi sama
    if ($password_baru !== $konfirmasi_password) {
        // Menyimpan pesan error ke session
        $_SESSION['password_error'] = 'Konfirmasi password tidak sesuai!';
        header("Location: ubah_password.php");
        exit;
    }
    else {
        // Jika sesuai, lakukan update password ke database
        mysqli_query(
            $koneksi,
            "UPDATE users SET password = '$password_baru' WHERE id = '$user_id'"
        );

        // Menyimpan status sukses ke session
        $_SESSION['password_success'] = true;
        header("Location: ubah_password.php");
        exit;
    }
}

// Mengambil kembali data password user untuk ditampilkan di form
$query_user = mysqli_query($koneksi, "SELECT password FROM users WHERE id = '$user_id'");
$data = mysqli_fetch_assoc($query_user);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ubah Password | PortoPBL</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../custom.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="container my-5">
        <h3 class="mb-4">Ubah Password</h3>
        <form action="#" method="post">
            <div class="mb-3">
                <label class="form-label">Password Lama</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($data['password']); ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" class="form-control" name="password_baru" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" name="konfirmasi_password" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="index_mahasiswa.php" class="btn btn-clr">Kembali</a>
                <button type="submit" name="ubah_password" class="btn btn-warning">
                    UBAH
                </button>
            </div>
        </form>
    </div>

    <div class="overflow-hidden mt-5">
        <img src="../asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave">
    </div>

    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <script src="../js/bootstrap.bundle.min.js"></script>

    <?php if (isset($_SESSION['password_success'])): ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Password berhasil diubah',
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        window.location.href = 'index_mahasiswa.php';
    });
    </script>
    <?php unset($_SESSION['password_success']); endif; ?>

    <?php if (isset($_SESSION['password_error'])): ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '<?= $_SESSION['password_error']; ?>'
    });
    </script>
    <?php unset($_SESSION['password_error']); endif; ?>

</body>

</html>