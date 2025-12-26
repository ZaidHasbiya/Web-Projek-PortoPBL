<?php
/**
 * File: edit_dosen.php
 * Fungsi: Mengubah data dosen (nama, NIDN, password, jurusan, dan role)
 * Catatan: Hanya admin yang bisa mengakses halaman ini
 */

session_start();
include '../koneksi.php'; // koneksi database

// Cek apakah user sudah login
if(!isset($_SESSION['username'])){
    echo "<script>alert('Silakan login dahulu'); window.location='../login.php';</script>";
    exit;
}

// Cek apakah role user adalah admin
if($_SESSION['role'] != 'admin'){
    echo "<script>alert('Akses ditolak!'); window.location='../login.php';</script>";
    exit;
}

// Cek apakah parameter id tersedia di URL
if(!isset($_GET['id'])){
    echo "<script>alert('ID tidak ditemukan'); window.location='data_dosen.php';</script>";
    exit;
}

$id = $_GET['id'];

// Ambil data dosen berdasarkan id
$qDosen = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id' AND role='dosen'");
$dosen = mysqli_fetch_assoc($qDosen);

// Jika dosen tidak ditemukan
if(!$dosen){
    echo "<script>alert('Data dosen tidak ditemukan'); window.location='data_dosen.php';</script>";
    exit;
}

// Ambil daftar jurusan dari kolom enum di database
$jurusan = mysqli_fetch_assoc(mysqli_query($koneksi, "SHOW COLUMNS FROM users LIKE 'jurusan'"));
$jurusan_list = explode("','", str_replace(["enum('","')"], "", $jurusan['Type']));

// Ambil daftar role dari kolom enum di database
$role = mysqli_fetch_assoc(mysqli_query($koneksi, "SHOW COLUMNS FROM users LIKE 'role'"));
$role_list = explode("','", str_replace(["enum('","')"], "", $role['Type']));

// Proses update data jika tombol update ditekan
if(isset($_POST['update'])){
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $jurusan = $_POST['jurusan'];
    $role = $_POST['role'];

    // Query update
    $update = mysqli_query($koneksi, 
        "UPDATE users SET 
            nama='$nama', 
            username='$username',
            password='$password',
            jurusan='$jurusan',
            role='$role'
        WHERE id='$id'"
    );

    // Feedback update
    if($update){
        echo "<script>alert('Data dosen berhasil diperbarui!'); window.location='data_dosen.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!'); window.location='edit_dosen.php?id=$id';</script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ubah Dosen</title>
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap & Custom CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../styles.css" type="text/css">
</head>
<body>

<div class="container my-5">
    <h3 class="mb-4">Ubah Dosen</h3>

    <form method="post">
        <!-- Input Nama Dosen -->
        <div class="mb-3">
            <label>Nama Dosen</label>
            <input type="text" class="form-control" name="nama" value="<?= $dosen['nama']; ?>" required>
        </div>

        <!-- Input NIDN -->
        <div class="mb-3">
            <label>NIDN</label>
            <input type="text" class="form-control" name="username" value="<?= $dosen['username']; ?>" required>
        </div>

        <!-- Input Password -->
        <div class="mb-3">
            <label>Password</label>
            <input type="text" class="form-control" name="password" value="<?= $dosen['password']; ?>" required>
        </div>

        <!-- Pilih Jurusan -->
        <div class="mb-3">
            <label>Jurusan</label>
            <select name="jurusan" class="form-control" required>
                <option value="">-- Pilih Jurusan --</option>
                <?php foreach($jurusan_list as $j): ?>
                    <option value="<?= $j ?>" <?= ($dosen['jurusan'] == $j ? 'selected' : '') ?>>
                        <?= ucfirst($j) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Pilih Role -->
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <?php foreach ($role_list as $r): ?>
                    <option value="<?= $r ?>" <?= $dosen['role']==$r ? 'selected' : '' ?>>
                        <?= ucfirst($r) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Tombol aksi -->
        <div class="d-flex justify-content-between">
            <a href="data_dosen.php" class="btn btn-primary">Kembali</a>
            <button type="submit" name="update" class="btn btn-success">Ubah</button>
        </div>
    </form>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
