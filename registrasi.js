document.getElementById('registrationForm').addEventListener('submit', function(event) {
  event.preventDefault();

  let name = document.getElementById('name').value.trim();
  let nim = document.getElementById('nim').value.trim();
  let password = document.getElementById('password').value.trim();
  let confirmPassword = document.getElementById('confirmPassword').value.trim();

  let valid = true;

  // Validasi Nama
  if (name === '') {
    document.getElementById('nameError').style.display = 'block';
    valid = false;
  } else {
    document.getElementById('nameError').style.display = 'none';
  }

  // Validasi NIM
  if (nim === '') {
    document.getElementById('nimError').style.display = 'block';
    valid = false;
  } else {
    document.getElementById('nimError').style.display = 'none';
  }

  // Validasi Password
  if (password.length < 6) {
    document.getElementById('passwordError').style.display = 'block';
    valid = false;
  } else {
    document.getElementById('passwordError').style.display = 'none';
  }

  // Validasi Konfirmasi Password
  if (confirmPassword !== password || confirmPassword === '') {
    document.getElementById('confirmError').style.display = 'block';
    valid = false;
  } else {
    document.getElementById('confirmError').style.display = 'none';
  }

  if (valid) {
    Swal.fire({
      title: 'Registrasi Berhasil',
      text: 'Silakan login untuk melanjutkan',
      icon: 'success',
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'OK'
    }).then(() => {
      document.getElementById('registrationForm').reset();
      window.location.href = 'login.html';
    });
  } else {
    Swal.fire({
      title: 'Registrasi Gagal',
      text: 'Periksa kembali data yang kamu masukkan.',
      icon: 'error',
      confirmButtonText: 'Coba Lagi',
      confirmButtonColor: '#d33'
    });
  }
});
