<?php
session_start();
include 'koneksi.php';

$query_role = mysqli_fetch_assoc(mysqli_query($koneksi, "SHOW COLUMNS FROM users LIKE 'role'"));
$role_list = explode("','", str_replace(["enum('","')"], "", $query_role['Type']));

if(isset($_POST['login'])){
  $username = $_POST['username'];
  $password = $_POST['password'];
  $role = $_POST['role'];

  $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND role = '$role'");
  $data = mysqli_fetch_assoc($query);

  if($data) {
    $_SESSION['id'] = $data['id'];
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];

    if($role == 'mahasiswa'){
      echo "<script>alert('Login Berhasil!'); window.location='mahasiswa/index_mahasiswa.php';</script>";
    } elseif($role == 'dosen'){
      echo "<script>alert('Login Berhasil!'); window.location='Dosen/index_dosen.php';</script>";
      exit;
    } elseif($role == 'admin'){
      echo "<script>alert('Login Berhasil!'); window.location='dashboard/dashboard.php';</script>";
      exit;
    }
  } else {
    echo "<script>alert('Login Gagal! Username atau Password'); window.location='login.php';</script>";
  }
}
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PortoPBL | Masuk</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

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
        font-size: 14.5px;
        font-weight: 400;
    }

    .btn-primary-custom {
        font-size: 15px;
        font-weight: 600;
        letter-spacing: 0.6px;
    }

    .login-card {
        border-radius: 20px;
        background-color: rgba(251, 254, 255, 0.7);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .logo {
        width: 150px;
        max-width: 100%;
        height: auto;
        transition: transform 0.3s ease;
    }

    .logo:hover {
        transform: scale(1.05);
    }


    .btn-primary-custom {
        background-color: #0d6efd;
        border: none;
        border-radius: 30px;
        font-weight: 600;
        color: #ffffff;
    }

    .btn-primary-custom:hover {
        background-color: #0b5ed7;
        color: #ffffff;
    }


    .form-control,
    .form-select {
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.8);
    }

    .card-body label,
    .card-body p {
        color: #0d1b2a;
        font-weight: 500;
    }

    .select-wrapper {
        position: relative;
    }

    .custom-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        padding-right: 40px;
        cursor: pointer;
    }

    .select-arrow {
        position: absolute;
        top: 50%;
        right: 15px;
        width: 0;
        height: 0;
        pointer-events: none;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #555;
        transform: translateY(-50%);
        transition: transform 0.3s ease;
    }

    .custom-select:focus+.select-arrow {
        transform: translateY(-50%) rotate(180deg);
    }
    </style>
</head>

<body>

    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="col-md-5 col-lg-5">

            <div class="card login-card shadow border-0">
                <div class="card-body p-4">

                    <!-- Logo -->
                    <div class="text-center mb-3">
                        <img src="asset/logoo.png" alt="Logo PortoPBL" class="logo mb-2">
                        <p class="text-muted mb-0">Silakan masuk ke akun anda</p>
                    </div>

                    <form action="" method="POST">

                        <div class="mb-3">
                            <label class="form-label">Masuk Sebagai</label>

                            <div class="select-wrapper">
                                <select name="role" class="form-select custom-select" required>
                                    <option value="">Pilih Role</option>
                                    <?php foreach($role_list as $r): ?>
                                    <option value="<?= $r ?>"><?= ucfirst($r) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="select-arrow"></span>
                            </div>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Masukkan Username (NIM atau NIDN)"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password"
                                required>
                        </div>

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

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>