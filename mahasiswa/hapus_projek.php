<?php
/*
Nama File   : hapus_projek.php
Deskripsi     : Menghapus data projek mahasiswa beserta file gambar
Dibuat Oleh    : Zaid Hasbiya Abrar - NIM : [3312501046]
Tanggal     : 13 November 2025
*/

session_start(); // Memulai session

include '../koneksi.php';

// Validasi login
if (!isset($_SESSION['username'])) {
    echo "<script>
            alert('Silakan login terlebih dahulu!');
            window.location.href = '../login.php';
          </script>";
    exit;
}

// Validasi role: hanya mahasiswa
if ($_SESSION['role'] !== 'mahasiswa') {
    echo "<script>
            alert('Maaf, anda bukan mahasiswa. Silakan login ulang.');
            window.location.href = '../login.php';
          </script>";
    exit;
}

// Mengambil data session
$user_id   = $_SESSION['id'];
$projek_id = $_GET['projek_id'] ?? null;

// Validasi parameter projek_id
if (!$projek_id) {
    echo "<script>
            alert('Projek tidak ditemukan!');
            window.location.href = 'projek_saya.php';
          </script>";
    exit;
}

// Mengambil data projek milik user
$query  = "SELECT * FROM projek 
           WHERE projek_id = '$projek_id' 
           AND user_id = '$user_id'";
$result = mysqli_query($koneksi, $query);
$projek = mysqli_fetch_assoc($result);

// Validasi kepemilikan projek
if (!$projek) {
    echo "<script>
            alert('Projek tidak ditemukan atau bukan milik Anda.');
            window.location.href = 'projek_saya.php';
          </script>";
    exit;
}

// Menghapus file gambar projek jika ada
if (!empty($projek['gambar_projek'])) {
    $filePath = '../asset/uploads/' . $projek['gambar_projek'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// Menghapus data projek dari database
$delete = "DELETE FROM projek 
           WHERE projek_id = '$projek_id' 
           AND user_id = '$user_id'";

if (mysqli_query($koneksi, $delete)) {
    echo "<script>
            alert('Projek berhasil dihapus!');
            window.location.href = 'projek_saya.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal menghapus projek!');
            window.location.href = 'projek_saya.php';
          </script>";
}
?>
