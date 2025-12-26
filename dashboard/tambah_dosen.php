<?php
/**
 * File: tambah_dosen.php
 * Fungsi: Menambahkan data dosen baru ke database
 * Catatan: Hanya admin yang dapat mengakses halaman ini
 */

session_start();
include '../koneksi.php'; // Koneksi ke database

// Cek apakah user sudah login
if(!isset($_SESSION['username'])){
    echo "<script>alert('Silakan login dahulu'); window.location='../login.php';</script>";
    exit;
}

// Cek apakah user adalah admin
if($_SESSION['role'] != 'admin'){
    echo "<script>alert('Akses ditolak!'); window.location='../login.php';</script>";
    exit;
}

// Ambil daftar jurusan dari enum di kolom 'jurusan'
$jurusan = mysqli_fetch_assoc(mysqli_query($koneksi, "SHOW COLUMNS FROM users LIKE 'jurusan'"));
$jurusan_list = explode("','", str_replace(["enum('","')"], "", $jurusan['Type']));

// Ambil daftar role dari enum di kolom 'role'
$role = mysqli_fetch_assoc(mysqli_query($koneksi, "SHOW COLUMNS FROM users LIKE 'role'"));
$role_list = explode("','", str_replace(["enum('","')"], "", $role['Type']));

// Proses saat form dikirim
if(isset($_POST['tambah'])){

    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $jurusan = $_POST['jurusan'];
    $role = 'dosen'; // Default role adalah dosen

    // Cek apakah username sudah ada di database
    $cek = mysqli_query($koneksi,"SELECT * FROM users WHERE username = '$username'");
    
    if(mysqli_num_rows($cek) > 0){
        // Jika username sudah ada
        echo "<script>alert('Nama atau username sudah terdaftar'); window.location = 'data_dosen.php';</script>";
    } else {
        // Insert data dosen baru ke database
        $query = "INSERT INTO users (nama, username, password, jurusan, role) 
                  VALUES ('$nama', '$username', '$password', '$jurusan', '$role')";
        $data = mysqli_query($koneksi, $query);

        if($data){
            echo "<script>alert('Tambah data dosen berhasil!'); window.location ='data_dosen.php';</script>";
        } else{
            echo "<script>alert('Tambah data dosen gagal!'); window.location ='tambah_dosen.php';</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tambah Dosen</title>

  <!-- Font Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="css/styles.css" type="text/css">
</head>

<body>
  <div class="container my-5">
    <h3 class="mb-4">Tambah Dosen</h3>

    <!-- Form tambah dosen -->
    <form action="" method="post">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama Dosen</label>
        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Dosen" required>
      </div>
      <div class="mb-3">
        <label for="username" class="form-label">NIDN</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="NIDN" required>
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
      <div class="mb-3">
        <label for="role" class="form-label">Pilih Role</label>
        <select name="role" class="form-control" id="role" required>
          <option value="">-- Pilih Role --</option>
          <?php foreach ($role_list as $r): ?>
              <option value="<?= $r ?>"><?= ucfirst($r) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="d-flex justify-content-between">
        <a href="data_dosen.php" class="btn btn-primary">Kembali</a>
        <button type="submit" class="btn btn-success" name="tambah">Tambah</button>
      </div>
    </form>
  </div>

  <!-- Footer -->
  <img src="../asset/wave-info.svg" class="w-100" alt="">
  <footer class="text-center py-3 bg-light mt-5">
    &copy; <span>2025</span> Tim Web Portofolio Projek PBL
  </footer>

  <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
