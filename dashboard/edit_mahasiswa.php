<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['username'])){
  echo "<script>alert('Silakan login dahulu'); window.location='login.php';</script>";
}

if($_SESSION['role'] != 'admin'){
  echo "<script>alert('Akses ditolak!'); window.location='index.php';</script>";
  exit;
}

if(!isset($_GET['id'])){
    echo "<script>alert('ID tidak ditemukan'); window.location='data_mahasiswa.php';</script>";
    exit;
}

$id = $_GET['id'];

$qMhs = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id' AND role='mahasiswa'");
$mhs = mysqli_fetch_assoc($qMhs);

if(!$mhs){
    echo "<script>alert('Data mahasiswa tidak ditemukan'); window.location='data_mahasiswa.php';</script>";
    exit;
}

$jurusan = mysqli_fetch_assoc(mysqli_query($koneksi, "SHOW COLUMNS FROM users LIKE 'jurusan'"));
$jurusan_list = explode("','", str_replace(["enum('","')"], "", $jurusan['Type']));

$role = mysqli_fetch_assoc(mysqli_query($koneksi, "SHOW COLUMNS FROM users LIKE 'role'"));
$role_list = explode("','", str_replace(["enum('","')"], "", $role['Type']));


if(isset($_POST['update'])){

    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $jurusan = $_POST['jurusan'];
    $role = $_POST['role'];

    $update = mysqli_query($koneksi, 
        "UPDATE users SET 
            nama='$nama', 
            username='$username',
            password='$password',
            jurusan='$jurusan',
            role='$role'
        WHERE id='$id'"
    );

    if($update){
        echo "<script>alert('Data mahasiswa berhasil diperbarui!'); window.location='data_mahasiswa.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!'); window.location='edit_mahasiswa.php?id=$id';</script>";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Dosen</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../styles.css" type="text/css">
</head>
<body>

<div class="container my-5">
    <h3 class="mb-4">Edit Mahasiswa</h3>

    <form method="post">
        <div class="mb-3">
            <label>Nama Mahasiswa</label>
            <input type="text" class="form-control" name="nama" value="<?= $mhs['nama']; ?>" required>
        </div>

        <div class="mb-3">
            <label>NIM</label>
            <input type="text" class="form-control" name="username" value="<?= $mhs['username']; ?>" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="text" class="form-control" name="password" value="<?= $mhs['password']; ?>" required>
        </div>

        <div class="mb-3">
            <label>Jurusan</label>
            <select name="jurusan" class="form-control" required>
                <option value="">-- Pilih Jurusan --</option>

                <?php foreach($jurusan_list as $j): ?>
                    <option value="<?= $j ?>" <?= ($mhs['jurusan'] == $j ? 'selected' : '') ?>>
                        <?= ucfirst($j) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Role</label>
           <select name="role" class="form-control" required>
    <?php foreach ($role_list as $r): ?>
        <option value="<?= $r ?>" <?= $mhs['role']==$r ? 'selected' : '' ?>>
            <?= ucfirst($r) ?>
        </option>
    <?php endforeach; ?>
</select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="data_mahasiswa.php" class="btn btn-primary">Kembali</a>
            <button type="submit" name="update" class="btn btn-success">Update</button>
        </div>
    </form>
</div>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
