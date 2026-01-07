<?php
/*
Nama File   : hapus_projek.php
Deskripsi   : Menghapus data projek mahasiswa beserta file gambar
Dibuat Oleh : Zaid Hasbiya Abrar - NIM : [3312501046]
Tanggal     : 13 November 2025
*/

<<<<<<< HEAD
session_start(); 
include '../koneksi.php';

// Fungsi SweetAlert redirect (Sesuai struktur file lainnya)
=======
session_start(); // Memulai session
include '../koneksi.php';

// Fungsi SweetAlert redirect
>>>>>>> bf556ff (Merubah seluruh desain web)
function redirect_alert($icon, $title, $url) {
    $_SESSION['alert'] = [
        'icon' => $icon,
        'title' => $title,
        'url' => $url
    ];
}

// Validasi login
if (!isset($_SESSION['username'])) {
<<<<<<< HEAD
    header("Location: ../login.php");
=======
    redirect_alert('warning', 'Silakan login terlebih dahulu!', '../login.php');
    echo "<script>window.location.href='../login.php';</script>";
>>>>>>> bf556ff (Merubah seluruh desain web)
    exit;
}

// Validasi role: hanya mahasiswa
if ($_SESSION['role'] !== 'mahasiswa') {
<<<<<<< HEAD
    redirect_alert('error', 'Akses Ditolak!', '../login.php');
} else {
    $user_id   = $_SESSION['id'];
    $projek_id = $_GET['projek_id'] ?? null;
=======
    redirect_alert('error', 'Maaf, anda bukan mahasiswa. Silakan login ulang.', '../login.php');
    echo "<script>window.location.href='../login.php';</script>";
    exit;
}
>>>>>>> bf556ff (Merubah seluruh desain web)

    if (!$projek_id) {
        redirect_alert('warning', 'Projek tidak ditemukan!', 'projek_saya.php');
    } else {
        $query  = "SELECT * FROM projek WHERE projek_id = '$projek_id' AND user_id = '$user_id'";
        $result = mysqli_query($koneksi, $query);
        $projek = mysqli_fetch_assoc($result);

<<<<<<< HEAD
        if (!$projek) {
            redirect_alert('error', 'Projek tidak ditemukan atau bukan milik Anda.', 'projek_saya.php');
        } else {
            if (!empty($projek['gambar_projek'])) {
                $uploadDir = __DIR__ . '/../asset/uploads/';
                $filePath  = $uploadDir . $projek['gambar_projek'];
                if (file_exists($filePath) && is_file($filePath)) {
                    unlink($filePath);
                }
            }

            $delete = "DELETE FROM projek WHERE projek_id = '$projek_id' AND user_id = '$user_id'";
            if (mysqli_query($koneksi, $delete)) {
                redirect_alert('success', 'Projek berhasil dihapus!', 'projek_saya.php');
            } else {
                redirect_alert('error', 'Gagal menghapus projek!', 'projek_saya.php');
            }
        }
    }
}
=======
// Validasi parameter projek_id
if (!$projek_id) {
    redirect_alert('warning', 'Projek tidak ditemukan!', 'projek_saya.php');
    echo "<script>window.location.href='projek_saya.php';</script>";
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
    redirect_alert('error', 'Projek tidak ditemukan atau bukan milik Anda.', 'projek_saya.php');
    echo "<script>window.location.href='projek_saya.php';</script>";
    exit;
}

// Menghapus file gambar projek jika ada
if (!empty($projek['gambar_projek'])) {
    $uploadDir = __DIR__ . '/../asset/uploads/';
    $filePath  = $uploadDir . $projek['gambar_projek'];
    if (file_exists($filePath) && is_file($filePath)) {
        unlink($filePath);
    }
}

// Menghapus data projek dari database
$delete = "DELETE FROM projek 
           WHERE projek_id = '$projek_id' 
           AND user_id = '$user_id'";

if (mysqli_query($koneksi, $delete)) {
    redirect_alert('success', 'Projek berhasil dihapus!', 'projek_saya.php');
} else {
    redirect_alert('error', 'Gagal menghapus projek!', 'projek_saya.php');
}
>>>>>>> bf556ff (Merubah seluruh desain web)
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PortoPBL - Hapus Projek</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<<<<<<< HEAD
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700;900&display=swap" rel="stylesheet">
=======
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700;900&display=swap"
        rel="stylesheet">
>>>>>>> bf556ff (Merubah seluruh desain web)
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css" type="text/css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
<<<<<<< HEAD
        body { font-family: 'Poppins', sans-serif; background-color: #fdf6e3; }
=======
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #fdf6e3;
    }
>>>>>>> bf556ff (Merubah seluruh desain web)
    </style>
</head>

<body>
    <script>
<<<<<<< HEAD
    // SweetAlert Handling (Sesuai struktur file sebelumnya)
=======
    // SweetAlert Handling
>>>>>>> bf556ff (Merubah seluruh desain web)
    <?php if (isset($_SESSION['alert'])): ?>
    Swal.fire({
        icon: '<?= $_SESSION['alert']['icon']; ?>',
        title: '<?= $_SESSION['alert']['title']; ?>',
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        window.location.href = '<?= $_SESSION['alert']['url']; ?>';
    });
    <?php unset($_SESSION['alert']); endif; ?>
    </script>
</body>

</html>