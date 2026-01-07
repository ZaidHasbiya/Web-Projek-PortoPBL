<?php
/**
 * File: tambah_mahasiswa.php
 * Fungsi: Menambahkan data mahasiswa baru ke database
 * Catatan: Hanya admin yang dapat mengakses halaman ini
 */

session_start();
include '../koneksi.php'; // Koneksi ke database

// Fungsi pembantu SweetAlert
function set_alert($icon, $title, $url) {
    $_SESSION['alert'] = [
        'icon' => $icon,
        'title' => $title,
        'url' => $url
    ];
}

// Cek apakah user sudah login
if(!isset($_SESSION['username'])){
    set_alert('warning', 'Silakan login dahulu', '../login.php');
}

// Cek apakah user adalah admin (hanya jika sudah login)
if(isset($_SESSION['role']) && $_SESSION['role'] != 'admin'){
    set_alert('error', 'Akses ditolak!', '../login.php');
}

// Ambil daftar jurusan dari enum di kolom 'jurusan'
$q = mysqli_query($koneksi, "SHOW COLUMNS FROM users LIKE 'jurusan'");
$row = mysqli_fetch_assoc($q);

$enum = str_replace(["enum('", "')"], "", $row['Type']); // Hapus bagian enum
$jurusan_list = explode("','", $enum); // Pecah string menjadi array jurusan

// Proses saat form dikirim
if(isset($_POST['tambah'])){

    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']); // Nama mahasiswa
    $username = mysqli_real_escape_string($koneksi, $_POST['username']); // NIM mahasiswa
    $password = $_POST['password']; // Password
    $jurusan = $_POST['jurusan']; // Jurusan
    $role = 'mahasiswa'; // Role otomatis mahasiswa

    // Cek apakah username sudah ada di database
    $cek = mysqli_query($koneksi,"SELECT * FROM users WHERE username = '$username'");
    
    if(mysqli_num_rows($cek) > 0){
        set_alert('error', 'Nama atau username sudah terdaftar', 'data_mahasiswa.php');
    } else {
        // Insert data mahasiswa baru ke database
        $query = "INSERT INTO users (nama, username, password, jurusan, role) 
                  VALUES ('$nama', '$username', '$password', '$jurusan', '$role')";
        $data = mysqli_query($koneksi, $query);

        if($data){
            set_alert('success', 'Tambah data mahasiswa berhasil!', 'data_mahasiswa.php');
        } else{
            set_alert('error', 'Tambah data mahasiswa gagal!', 'tambah_mahasiswa.php');
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="css/styles.css" type="text/css">
</head>

<body style="background-color: #fdf6e3;">
    <div class="container my-5">
        <h3 class="mb-4">Tambah Mahasiswa</h3>

        <form action="" method="post">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Mahasiswa</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Mahasiswa" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">NIM</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="NIM" required>
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
                <a href="data_mahasiswa.php" class="btn btn-primary">Kembali</a>
                <button type="submit" class="btn btn-success" name="tambah">Tambah</button>
            </div>
        </form>
    </div>

    <img src="../asset/wave-new-navy.svg" class="w-100" alt="wave">
    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
    // Logika SweetAlert dari Session
    <?php if (isset($_SESSION['alert'])): ?>
    Swal.fire({
        icon: '<?= $_SESSION['alert']['icon'] ?>',
        title: '<?= $_SESSION['alert']['title'] ?>',
        timer: 2000,
        showConfirmButton: true
    }).then(() => {
        window.location.href = '<?= $_SESSION['alert']['url'] ?>';
    });
    <?php unset($_SESSION['alert']); endif; ?>
    </script>
</body>

</html>