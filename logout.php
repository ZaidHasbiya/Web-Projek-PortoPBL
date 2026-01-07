<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Logout</title>
  <!-- Load SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <Style>
    body{
      font-family: 'poppins', sans-serif;
    }
  </style>
</head>
<body>

<script>
Swal.fire({
    icon: 'success',
    title: 'Logout Berhasil!',
    text: 'Sampai jumpa!',
    timer: 2000,
    showConfirmButton: false
}).then(() => {
    window.location.href = 'login.php';
});
</script>

</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> bf556ff (Merubah seluruh desain web)
