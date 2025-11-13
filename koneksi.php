<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'test_portopbl';

$koneksi = mysqli_connect($host, $user, $password, $database);

if ($koneksi->connect_error){
    die("Koneksi Gagal: ". $koneksi->connect_error);
}
?>