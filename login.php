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
      echo "<script>
            alert('Login Berhasil!');
            window.location = 'mahasiswa/index_mahasiswa.php';
          </script>";
    } elseif($role == 'dosen'){
      echo "<script>
            alert('Login Berhasil!');
            window.location = 'Dosen/index_dosen.php';
          </script>";
      exit;
    } elseif($role == 'admin'){
      echo "<script>
            alert('Login Berhasil!');
            window.location = 'dashboard/dashboard.php';
          </script>";
      exit;
    }
  } else {
    echo "<script>
            alert('Login Gagal! Username atau Password');
            window.location = 'login.php';
          </script>";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PortoPBL</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="style_login.css">
</head>
<body>

  <div class="login-form">
    <form action="" method="POST">
      <h3 class="login-title">Login</h3><br>
      
      <label for="role">Masuk Sebagai :</label>
<select name="role" id="role" required>
    <option value="">-- Pilih Role --</option>
    <?php foreach($role_list as $r): ?>
        <option value="<?= $r ?>"><?= ucfirst($r) ?></option>
    <?php endforeach; ?>
</select><br>

      <label for="username">Username :</label>
      <input type="text" name="username" class="inputNIM" placeholder="Masukkan Username Anda" required><br>

      <label for="password">Password :</label>
      <input type="password" name="password" class="inputPassword" placeholder="Masukkan Password Anda" required><br>

      <button type="submit" name="login" class="login-btn" id="loginBtn">Login</button>
    </form>
    <a href="registrasi.php" class="text-center">Belum Punya Akun? Registrasi Disini</a>
  </div>

  <img src="asset/wave-info.svg" alt="">
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>