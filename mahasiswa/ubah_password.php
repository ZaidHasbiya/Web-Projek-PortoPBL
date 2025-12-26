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

    // Mengambil password lama dari database berdasarkan user ID
    $query = mysqli_query($koneksi, "SELECT password FROM users WHERE id = '$user_id'");
    $data  = mysqli_fetch_assoc($query);

    // Validasi apakah password baru dan konfirmasi sama
    if ($password_baru !== $konfirmasi_password) {
        // Menampilkan pesan jika konfirmasi tidak sesuai
        echo "<script>alert('Konfirmasi password tidak sesuai!');</script>";
    }
    else {
        // Jika sesuai, lakukan update password ke database
        mysqli_query(
            $koneksi,
            "UPDATE users SET password = '$password_baru' WHERE id = '$user_id'"
        );

        // Menampilkan pesan sukses dan redirect ke halaman mahasiswa
        echo "<script>
                alert('Password berhasil diubah!');
                window.location.href = 'index_mahasiswa.php';
              </script>";
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
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../styles.css">
  <link rel="stylesheet" href="../custom.css">
</head>

<body>

  <div class="container my-5">
    <h3 class="mb-4">Ubah Password</h3>
    <!-- Menampilkan Password yang lama -->
    <form action="#" method="post">
      <div class="mb-3">
        <label class="form-label">Password Lama</label>
        <input type="text"
         class="form-control"
         value="<?= htmlspecialchars($data['password']); ?>"
         readonly>

      </div>

      <div class="mb-3">
        <label class="form-label">Password Baru</label>
        <input type="password"
               class="form-control"
               name="password_baru"
               required>
      </div>

      <div class="mb-3">
        <label class="form-label">Konfirmasi Password Baru</label>
        <input type="password"
               class="form-control"
               name="konfirmasi_password"
               required>
      </div>

      <div class="d-flex justify-content-between">
        <a href="index_mahasiswa.php" class="btn btn-clr">Kembali</a>
        <button type="submit"
                name="ubah_password"
                class="btn btn-warning">
          UBAH
        </button>
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