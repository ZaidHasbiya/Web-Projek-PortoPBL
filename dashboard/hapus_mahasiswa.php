<?php
/**
 * File: hapus_mahasiswa.php
 * Fungsi: Menghapus data mahasiswa berdasarkan ID
 * Catatan: Hanya admin yang dapat mengakses halaman ini
 */

session_start();
include '../koneksi.php'; // Koneksi ke database

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
// Cek apakah parameter ID ada di URL
else if(!isset($_GET['id'])){
    set_alert('warning', 'ID tidak ditemukan', 'data_mahasiswa.php');
} else {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Query hapus data mahasiswa berdasarkan ID
    $hapus = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id' AND role='mahasiswa'");

    // Cek apakah query berhasil
    if($hapus){
        set_alert('success', 'Data mahasiswa berhasil dihapus!', 'data_mahasiswa.php');
    } else {
        set_alert('error', 'Gagal menghapus data', 'data_mahasiswa.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Hapus...</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #fdf6e3;
    }
    </style>
</head>

<body>
    <script>
    <?php if (isset($_SESSION['alert'])): ?>
    Swal.fire({
        icon: '<?= $_SESSION['alert']['icon'] ?>',
        title: '<?= $_SESSION['alert']['title'] ?>',
        showConfirmButton: true,
        confirmButtonColor: '#1D5D8C'
    }).then(() => {
        window.location.href = '<?= $_SESSION['alert']['url'] ?>';
    });
    <?php unset($_SESSION['alert']); endif; ?>
    </script>
</body>

</html>