<?php
/**
 * File: edit_mahasiswa.php
 * Fungsi: Mengubah data mahasiswa (nama, NIM, password, jurusan, role)
 * Catatan: Hanya admin yang dapat mengakses halaman ini
 */

session_start();
include '../koneksi.php'; // koneksi ke database

// Fungsi untuk menyiapkan SweetAlert
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
// Cek apakah role user adalah admin
else if($_SESSION['role'] != 'admin'){
    set_alert('error', 'Akses ditolak!', '../login.php');
}
// Cek apakah parameter id ada di URL
else if(!isset($_GET['id'])){
    set_alert('warning', 'ID tidak ditemukan', 'data_mahasiswa.php');
}

// Menangani ID dan pengecekan data
$id = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : '';
$mhs = null;

if (!empty($id)) {
    $qMhs = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id' AND role='mahasiswa'");
    $mhs = mysqli_fetch_assoc($qMhs);
    
    if(!$mhs && !isset($_SESSION['alert'])){
        set_alert('error', 'Data mahasiswa tidak ditemukan', 'data_mahasiswa.php');
    }
}

// Ambil daftar jurusan & role (hanya jika data mahasiswa ditemukan)
$jurusan_list = [];
$role_list = [];
if ($mhs) {
    $jurusan = mysqli_fetch_assoc(mysqli_query($koneksi, "SHOW COLUMNS FROM users LIKE 'jurusan'"));
    $jurusan_list = explode("','", str_replace(["enum('","')"], "", $jurusan['Type']));

    $role = mysqli_fetch_assoc(mysqli_query($koneksi, "SHOW COLUMNS FROM users LIKE 'role'"));
    $role_list = explode("','", str_replace(["enum('","')"], "", $role['Type']));
}

// Proses update data jika tombol update ditekan
if(isset($_POST['update'])){
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password_input = $_POST['password'];
    $jurusan_val = $_POST['jurusan'];
    $role_val = $_POST['role'];

    if (!empty($password_input)) {
        // PASSWORD DIUBAH → HASH
        $password_hash = password_hash($password_input, PASSWORD_DEFAULT);

        $update = mysqli_query($koneksi, 
            "UPDATE users SET 
                nama='$nama', 
                username='$username',
                password='$password_hash',
                jurusan='$jurusan_val',
                role='$role_val'
            WHERE id='$id'"
        );
    } else {
        // PASSWORD TIDAK DIUBAH
        $update = mysqli_query($koneksi, 
            "UPDATE users SET 
                nama='$nama', 
                username='$username',
                jurusan='$jurusan_val',
                role='$role_val'
            WHERE id='$id'"
        );
    }

    // Feedback update
    if($update){
        set_alert('success', 'Data mahasiswa berhasil diperbarui!', 'data_mahasiswa.php');
    } else {
        set_alert('error', 'Gagal memperbarui data!', "edit_mahasiswa.php?id=$id");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Mahasiswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../styles.css" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body style="background-color: #fdf6e3;">

<div class="container my-5">
    <?php if($mhs): ?>
    <div class="card mx-auto" style="max-width: 500px;"> <!-- Kotak tengah -->
        <div class="card-body">
            <h3 class="card-title mb-4 text-center">Ubah Mahasiswa</h3>

            <form method="post">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Mahasiswa</label>
                    <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($mhs['nama']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">NIM</label>
                    <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($mhs['username']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin diubah">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Jurusan</label>
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
                    <label class="form-label fw-semibold">Role</label>
                    <select name="role" class="form-control" required>
                        <?php foreach ($role_list as $r): ?>
                        <option value="<?= $r ?>" <?= $mhs['role'] == $r ? 'selected' : '' ?>>
                            <?= ucfirst($r) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="data_mahasiswa.php" class="btn btn-primary px-4">Kembali</a>
                    <button type="submit" name="update" class="btn btn-success px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>


<script src="../js/bootstrap.bundle.min.js"></script>

<script>
    // Penanganan SweetAlert
    <?php if (isset($_SESSION['alert'])): ?>
    Swal.fire({
        icon: '<?= $_SESSION['alert']['icon'] ?>',
        title: '<?= $_SESSION['alert']['title'] ?>',
        confirmButtonColor: '#1D5D8C',
        showConfirmButton: true
    }).then(() => {
        window.location.href = '<?= $_SESSION['alert']['url'] ?>';
    });
    <?php unset($_SESSION['alert']); endif; ?>
</script>

</body>
</html>