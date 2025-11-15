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
    echo "<script>alert('ID tidak ditemukan'); window.location='data_dosen.php';</script>";
    exit;
}

$id = $_GET['id'];

$hapus = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id' AND role='dosen'");

if($hapus){
    echo "<script>alert('Data dosen berhasil dihapus!'); window.location='data_dosen.php';</script>";
}else{
    echo "<script>alert('Gagal menghapus data'); window.location='data_dosen.php';</script>";
}
