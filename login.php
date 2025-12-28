<?php
/*
Nama File   : login.php
Deskripsi     : Menangani proses login pengguna (mahasiswa, dosen, admin)
             dan mengarahkan ke halaman sesuai role
Dibuat Oleh    : Fathur Alfitah - NIM : [3312501048]
Dibuat     : 2025
*/

session_start();
include 'koneksi.php';

// Mengambil daftar role dari kolom ENUM pada tabel users
$query_role = mysqli_fetch_assoc(
  mysqli_query($koneksi, "SHOW COLUMNS FROM users LIKE 'role'")
);

// Mengubah tipe ENUM menjadi array role
$role_list = explode(
  "','",
  str_replace(["enum('", "')"], "", $query_role['Type'])
);

// Mengecek apakah tombol login ditekan
if (isset($_POST['login'])) {

  // Mengambil data input dari form login
  $username = $_POST['username'];
  $password = $_POST['password'];
  $role     = $_POST['role'];

  // Query untuk mencocokkan data login dengan database
  $query = mysqli_query(
    $koneksi,
    "SELECT * FROM users 
     WHERE username = '$username' 
     AND password = '$password' 
     AND role = '$role'"
  );

  // Mengambil hasil query
  $data = mysqli_fetch_assoc($query);

  // Jika data ditemukan (login berhasil)
  if ($data) {

    // Menyimpan data pengguna ke dalam session
    $_SESSION['id']       = $data['id'];
    $_SESSION['nama']     = $data['nama'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['role']     = $data['role'];

    // Pengalihan halaman berdasarkan role
    if ($role == 'mahasiswa') {
      echo "<script>alert('Login Berhasil!'); window.location='mahasiswa/index_mahasiswa.php';</script>";
    } elseif ($role == 'dosen') {
      echo "<script>alert('Login Berhasil!'); window.location='Dosen/index_dosen.php';</script>";
      exit;
    } elseif ($role == 'admin') {
      echo "<script>alert('Login Berhasil!'); window.location='dashboard/dashboard.php';</script>";
      exit;
    }

  } else {
    // Jika login gagal
    echo "<script>alert('Login Gagal! Username atau Password'); window.location='login.php';</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Metadata halaman -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PortoPBL | Masuk</title>

    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- CSS internal halaman login -->
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        letter-spacing: 0.2px;
        background:
            linear-gradient(rgba(13, 27, 42, 0.65),
                rgba(13, 27, 42, 0.65)),
            url('asset/poltek.jpeg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    .text-muted {
        font-size: 14px;
        font-weight: 400;
        letter-spacing: 0.3px;
    }

    .form-label {
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 0.4px;
    }

    .form-control,
    .form-select {
        background: rgba(253, 246, 227, 0.85);
        border-radius: 10px;
        border: 1px solid #e6ddc4;
    }


    .btn-primary-custom {
        font-size: 15px;
        font-weight: 600;
        letter-spacing: 0.6px;
        background-color: #1D5D8C;
        border: none;
        border-radius: 30px;
        color: #ffffff;
    }

    .btn-primary-custom:hover {
        background-color: #0b5ed7;
        color: #ffffff;
    }

    .card-body {
        color: #2d3748;
    }

    .login-card {
        border-radius: 20px;
        background-color: rgba(253, 246, 227, 0.75);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.35);
        border: 1px solid rgba(255, 255, 255, 0.45);
    }

    .logo {
        width: 150px;
        transition: transform 0.3s ease;
    }

    .logo:hover {
        transform: scale(1.05);
    }

    .select-wrapper {
        position: relative;
    }

    .custom-select {
        appearance: none;
        padding-right: 40px;
        cursor: pointer;
    }

    .select-arrow {
        position: absolute;
        top: 50%;
        right: 15px;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #555;
        transform: translateY(-50%);
    }
    </style>
</head>

<body>

    <!-- Container utama halaman login -->
    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="col-md-5">

            <!-- Card login -->
            <div class="card login-card shadow border-0">
                <div class="card-body p-4">

                    <!-- Logo aplikasi -->
                    <div class="text-center mb-3">
                        <img src="asset/logoo.png" alt="Logo PortoPBL" class="logo mb-2">
                        <p class="text-muted mb-0">Silakan masuk ke akun anda</p>
                    </div>

                    <!-- Form login -->
                    <form action="" method="POST">

                        <!-- Pilih role -->
                        <div class="mb-3">
                            <label class="form-label">Masuk Sebagai</label>
                            <div class="select-wrapper">
                                <select name="role" class="form-select custom-select" required>
                                    <option value="">Pilih Role</option>
                                    <?php foreach ($role_list as $r): ?>
                                    <option value="<?= $r ?>"><?= ucfirst($r) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="select-arrow"></span>
                            </div>
                        </div>

                        <!-- Input username -->
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control"
                                placeholder="Masukkan Username (NIM atau NIDN)" required>
                        </div>

                        <!-- Input password -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password"
                                required>
                        </div>

                        <!-- Tombol login -->
                        <div class="d-grid mt-4">
                            <button type="submit" name="login" class="btn btn-primary-custom btn-lg">
                                Masuk
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>