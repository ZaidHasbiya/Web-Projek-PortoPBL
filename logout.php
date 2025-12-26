<?php
/*
Nama File   : logout.php
Deskripsi     : Mengakhiri sesi pengguna dan mengarahkan kembali
             ke halaman login
Dibuat Oleh    : Zaid Hasbiya Abrar - NIM : [3312501046]
Tanggal     : 13 November 2025
*/

session_start(); 
// Memulai session agar session yang aktif bisa dihapus

session_unset(); 
// Menghapus semua variabel session yang tersimpan

session_destroy(); 
// Menghancurkan session secara keseluruhan

// Menampilkan pesan logout berhasil dan mengarahkan ke halaman login
echo "<script>
  alert('Anda berhasil logout.');
  window.location = 'login.php';
</script>";

exit;
// Menghentikan eksekusi script setelah logout
?>
