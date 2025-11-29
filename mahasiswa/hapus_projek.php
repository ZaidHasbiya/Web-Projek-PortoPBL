<?php
session_start();

include '../koneksi.php';

if (!isset($_SESSION['nama'])) {
    echo "<script>
            alert('Silakan login terlebih dahulu!');
            window.location.href = 'login.php';
          </script>";
    exit;
}

if ($_SESSION['role'] !== 'mahasiswa') {
    echo "<script>
            alert('Maaf, anda bukan mahasiswa. Silakan login ulang.');
            window.location.href = 'login.php';
          </script>";
    exit;
}

$user_id = $_SESSION['id'];
$projek_id = $_GET['projek_id'];

if (!$projek_id) {
    echo "<script>
            alert('Projek tidak ditemukan!');
            window.location.href = 'projek_saya.php';
          </script>";
    exit;
}

$query = "SELECT * FROM projek WHERE projek_id = '$projek_id' AND user_id = '$user_id'";
$result = mysqli_query($koneksi, $query);
$projek = mysqli_fetch_assoc($result);

if (!$projek) {
    echo "<script>
            alert('Projek tidak ditemukan atau bukan milik Anda.');
            window.location.href = 'projek_saya.php';
          </script>";
    exit;
}

if (!empty($projek['gambar_projek'])) {
    $filePath = '../asset/uploads/' . $projek['gambar_projek'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}
$delete = "DELETE FROM projek WHERE projek_id = '$projek_id' AND user_id = '$user_id'";
if (mysqli_query($koneksi, $delete)) {
    echo "<script>
            alert('Projek berhasil dihapus!');
            window.location.href = 'projek_saya.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal menghapus projek: " . mysqli_error($koneksi) . "');
            window.location.href = 'projek_saya.php';
          </script>";
}
?>
