<?php
/*
Nama File    : login.php
Deskripsi    : Menangani proses login pengguna (mahasiswa, dosen, admin)
               dan mengarahkan ke halaman sesuai role dengan SweetAlert
Dibuat Oleh  : Fathur Alfitah - NIM : [3312501048]
Dibuat       : 2025
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
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password_input = $_POST['password']; // JANGAN di-escape
    $role = $_POST['role'];

  // Query untuk mencocokkan data login dengan database
    $query = mysqli_query(
        $koneksi,
        "SELECT * FROM users 
         WHERE username = '$username' 
         AND role = '$role'"
    );

  // Mengambil hasil query
  $data = mysqli_fetch_assoc($query);

  // Jika data ditemukan (login berhasil)
// Jika data ditemukan (login berhasil)
if ($data) {

    // 1️⃣ Cek password hash normal
    if (password_verify($password_input, $data['password'])) {
        // Login sukses
        $_SESSION['id']       = $data['id'];
        $_SESSION['nama']     = $data['nama'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role']     = $data['role'];
        $_SESSION['login_success'] = true;

        // Redirect
        if ($role == 'mahasiswa') {
            $_SESSION['redirect'] = 'mahasiswa/index_mahasiswa.php';
        } elseif ($role == 'dosen') {
            $_SESSION['redirect'] = 'Dosen/index_dosen.php';
        } elseif ($role == 'admin') {
            $_SESSION['redirect'] = 'dashboard/dashboard.php';
        }

    } 
    // 2️⃣ Fallback untuk password lama (plain text)
    else if ($password_input === $data['password']) {

        // Hash password baru
        $newHash = password_hash($password_input, PASSWORD_DEFAULT);
        mysqli_query($koneksi, 
            "UPDATE users SET password='$newHash' WHERE id='{$data['id']}'"
        );

        // Login sukses
        $_SESSION['id']       = $data['id'];
        $_SESSION['nama']     = $data['nama'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role']     = $data['role'];
        $_SESSION['login_success'] = true;

        // Redirect
        if ($role == 'mahasiswa') {
            $_SESSION['redirect'] = 'mahasiswa/index_mahasiswa.php';
        } elseif ($role == 'dosen') {
            $_SESSION['redirect'] = 'Dosen/index_dosen.php';
        } elseif ($role == 'admin') {
            $_SESSION['redirect'] = 'dashboard/dashboard.php';
        }

    } 
    // 3️⃣ Password salah
    else {
        $_SESSION['login_error'] = true;
    }

} else {
    $_SESSION['login_error'] = true;
}

}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PortoPBL | Masuk</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap.min.css">

    <style>
    body {
        font-family: 'Poppins', sans-serif;
        letter-spacing: 0.2px;
        background: linear-gradient(rgba(13, 27, 42, 0.65), rgba(13, 27, 42, 0.65)), url('asset/poltek.jpeg');
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
        cursor: pointer;
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

    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="col-md-5">
            <div class="card login-card shadow border-0">
                <div class="card-body p-4">

                    <div class="text-center mb-3">
                        <a href="index.php">
                            <img src="asset/logoo.png" alt="Logo PortoPBL" class="logo mb-2">
                        </a>
                        <p class="text-muted mb-0">Silakan masuk ke akun anda</p>
                    </div>

                    <form action="" method="POST">
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

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control"
                                placeholder="Masukkan Username (NIM atau NIDN)" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password"
                                required>
                        </div>
                        <div>
                            <p class="text-center mt-3">
                                Belum punya akun?
                                <a href="https://forms.gle/Ei386uWRFVz2UrRs8" target="_blank">
                                 Ajukan pembuatan akun
                                </a>
                            </p>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" name="login" class="btn btn-primary-custom btn-lg">Masuk</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (isset($_SESSION['login_success'])): ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil Masuk!',
        text: 'Selamat datang, <?= $_SESSION['nama'] ?>!',
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        window.location.href = "<?= $_SESSION['redirect']; ?>";
    });
    </script>
    <?php unset($_SESSION['login_success'], $_SESSION['redirect']); endif; ?>

    <?php if (isset($_SESSION['login_error'])): ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal Masuk!',
        text: 'Username, Password, atau Role salah.'
    });
    </script>
    <?php unset($_SESSION['login_error']); endif; ?>

</body>

</html>