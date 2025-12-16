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
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PortoPBL | Login</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f8fafc;
    }
  </style>
</head>
<body>

<div class="container min-vh-100 d-flex align-items-center justify-content-center">
  <div class="col-md-5 col-lg-4">
    <div class="card shadow border-0 rounded-4">
      <div class="card-body p-4">

        <h3 class="text-center fw-bold mb-4">Masuk</h3>

        <form action="" method="POST">
          
          <div class="mb-3">
            <label class="form-label">Masuk Sebagai</label>
            <select name="role" class="form-select" required>
              <option value="">-- Pilih Role --</option>
              <?php foreach($role_list as $r): ?>
                <option value="<?= $r ?>"><?= ucfirst($r) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
          </div>

          <div class="d-grid mt-4">
            <button type="submit" name="login" class="btn btn-footer btn-lg">
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
