document.getElementById('loginForm').addEventListener('submit', function(event) {
  event.preventDefault(); // Mencegah reload halaman

  let nim = document.getElementById('nim').value.trim();
  let password = document.getElementById('password').value.trim();
  let role = document.getElementById('role').value;
  let valid = true;

  // Validasi NIM
  if (nim === "") {
    document.getElementById('nimError').style.display = 'block';
    valid = false;
  } else {
    document.getElementById('nimError').style.display = 'none';
  }

  // Validasi Password
  if (password === "") {
    document.getElementById('passwordError').style.display = 'block';
    valid = false;
  } else {
    document.getElementById('passwordError').style.display = 'none';
  }

  // Jika semua valid
  if (valid) {
    Swal.fire({
      title: 'Login Berhasil!',
      text: `Selamat datang kembali, ${role}!`,
      icon: 'success',
      showConfirmButton: false,
      timer: 1500
    }).then(() => {
      // Tampilkan loading sebelum redirect
      Swal.fire({
        title: 'Memproses...',
        text: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      // Delay sebelum redirect (simulasi loading)
      setTimeout(() => {
        if (role === "Mahasiswa") {
          window.location.href = "mahasiswa/index_mahasiswa.html";
        } else if (role === "Dosen") {
          window.location.href = "Dosen/index_dosen.html";
        }
      }, 2000);
    });
  } else {
    Swal.fire({
      title: 'Login Gagal',
      text: 'Pastikan semua data sudah diisi dengan benar!',
      icon: 'error',
      confirmButtonText: 'Coba Lagi',
      confirmButtonColor: '#d33'
    });
  }
});
