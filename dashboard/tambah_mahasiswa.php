<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['username'])){
  echo "<script>alert('username tidak sesuai ! silahkan melakukan login'); window.location ='login.php';</script>";
}

if($_SESSION['role'] != 'admin'){
  echo "<script>alert('Akses ditolak! Halaman ini hanya untuk admin.');window.location='index.php';</script>";
    exit;
}

$q = mysqli_query($koneksi, "SHOW COLUMNS FROM users LIKE 'jurusan'");
$row = mysqli_fetch_assoc($q);

$enum = str_replace(["enum('", "')"], "", $row['Type']);
$jurusan_list = explode("','", $enum);

if(isset($_POST['tambah'])){

  $nama = $_POST['nama'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $jurusan = $_POST['jurusan'];
  $role = 'dosen';

  $cek = mysqli_query($koneksi,"SELECT * FROM users WHERE nama = '$nama' OR username = '$username'");

if(mysqli_num_rows($cek) > 0){
  echo "<script>alert('Nama atau username sudah terdaftar'); window.location = 'data_mahasiswa.php';</script>";
}else{
  $query = "INSERT INTO users (nama, username, password, jurusan, role) VALUES ('$nama', '$username', '$password', '$jurusan', '$role')";
  $data = mysqli_query($koneksi, $query);

  if($data){
    echo "<script>alert('Tambah data mahasiswa berhasil!'); window.location ='data_mahasiswa.php';</script>";
  } else{
    echo "<script>alert('Tambah data mahasiswa gagal!'); window.location ='tambah_mahasiswa.php';</script>";
  }
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tambah Mahasiswa</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css" type="text/css">
</head>

<body>
  <div class="container my-5">
    <h3 class="mb-4">Tambah Mahasiswa</h3>

    <form action="" method="post">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama Mahasiswa</label>
        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Dosen" required>
      </div>
      <div class="mb-3">
        <label for="nik" class="form-label">NIM</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="NIK" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="text" class="form-control" id="password" name="password" placeholder="Password" required>
      </div>
      <div class="mb-3">
        <label for="jurusan" class="form-label">Pilih Jurusan</label>
<select name="jurusan" class="form-control" id="jurusan" required>
    <option value="">-- Pilih Jurusan --</option>

    <?php foreach ($jurusan_list as $j): ?>
        <option value="<?= $j ?>"><?= ucfirst($j) ?></option>
    <?php endforeach; ?>
</select>
      </div>

      <div class="d-flex justify-content-between">
        <a href="data_dosen.php" class="btn btn-primary">Kembali</a>
        <button type="submit" class="btn btn-success" name="tambah">Tambah</button>
      </div>
    </form>
  </div>

  <img src="../asset/wave-info.svg" class="w-100" alt="">
  <footer class="text-center py-3 bg-light mt-5">
    &copy; <span>2025</span> Tim Web Portofolio Projek PBL
  </footer>

  <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
