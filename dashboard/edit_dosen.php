<?php
/**
 * File: edit_dosen.php
 * Fungsi: Mengubah data dosen (nama, NIDN, password, jurusan, dan role)
 * Catatan: Hanya admin yang bisa mengakses halaman ini
 */

session_start();
include '../koneksi.php'; // koneksi database

// Fungsi pembantu untuk SweetAlert
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
// Cek apakah parameter id tersedia di URL
else if(!isset($_GET['id'])){
    set_alert('warning', 'ID tidak ditemukan', 'data_dosen.php');
}

$id = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : '';
$dosen = null;

if (!empty($id)) {
    // Ambil data dosen berdasarkan id
    $qDosen = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id' AND role='dosen'");
    $dosen = mysqli_fetch_assoc($qDosen);

    // Jika dosen tidak ditemukan
    if(!$dosen && !isset($_SESSION['alert'])){
        set_alert('error', 'Data dosen tidak ditemukan', 'data_dosen.php');
    }
}

// Ambil daftar jurusan & role (Hanya jika data dosen ada)
$jurusan_list = [];
$role_list = [];
if ($dosen) {
    $jurusan = mysqli_fetch_assoc(mysqli_query($koneksi, "SHOW COLUMNS FROM users LIKE 'jurusan'"));
    $jurusan_list = explode("','", str_replace(["enum('","')"], "", $jurusan['Type']));

    $role = mysqli_fetch_assoc(mysqli_query($koneksi, "SHOW COLUMNS FROM users LIKE 'role'"));
    $role_list = explode("','", str_replace(["enum('","')"], "", $role['Type']));
}

// Proses update data jika tombol update ditekan
if(isset($_POST['update'])){
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $jurusan_val = $_POST['jurusan'];
    $role_val = $_POST['role'];

    // Query update
    $update = mysqli_query($koneksi, 
        "UPDATE users SET 
            nama='$nama', 
            username='$username',
            password='$password',
            jurusan='$jurusan_val',
            role='$role_val'
        WHERE id='$id'"
    );

    // Feedback update
    if($update){
        set_alert('success', 'Data dosen berhasil diperbarui!', 'data_dosen.php');
    } else {
        set_alert('error', 'Gagal memperbarui data!', "edit_dosen.php?id=$id");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Dosen</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../styles.css" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body style="background-color: #fdf6e3;">

<div class="container my-5">
    <?php if ($dosen): ?>
    <h3 class="mb-4">Ubah Dosen</h3>

    <form method="post">
        <div class="mb-3">
            <label class="form-label fw-bold">Nama Dosen</label>
            <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($dosen['nama']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">NIDN</label>
            <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($dosen['username']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Password</label>
            <input type="text" class="form-control" name="password" value="<?= htmlspecialchars($dosen['password']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Jurusan</label>
            <select name="jurusan" class="form-control" required>
                <option value="">-- Pilih Jurusan --</option>
                <?php foreach($jurusan_list as $j): ?>
                    <option value="<?= $j ?>" <?= ($dosen['jurusan'] == $j ? 'selected' : '') ?>>
                        <?= ucfirst($j) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Role</label>
            <select name="role" class="form-control" required>
                <?php foreach ($role_list as $r): ?>
                    <option value="<?= $r ?>" <?= $dosen['role']==$r ? 'selected' : '' ?>>
                        <?= ucfirst($r) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="data_dosen.php" class="btn btn-primary px-4">Kembali</a>
            <button type="submit" name="update" class="btn btn-success px-4">Simpan Perubahan</button>
        </div>
    </form>
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