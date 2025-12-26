<?php
/**
 * File: hapus_dosen.php
 * Fungsi: Menghapus data dosen berdasarkan ID
 * Catatan: Hanya admin yang dapat mengakses halaman ini
 */

session_start();
include '../koneksi.php'; // Koneksi ke database

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

// Cek apakah parameter ID ada di URL
if(!isset($_GET['id'])){
    echo "<script>alert('ID tidak ditemukan'); window.location='data_dosen.php';</script>";
    exit;
}

$id = $_GET['id'];

// Query hapus data dosen berdasarkan ID
$hapus = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id' AND role='dosen'");

// Cek apakah query berhasil
if($hapus){
    echo "<script>alert('Data dosen berhasil dihapus!'); window.location='data_dosen.php';</script>";
}else{
    echo "<script>alert('Gagal menghapus data'); window.location='data_dosen.php';</script>";
}
?>
