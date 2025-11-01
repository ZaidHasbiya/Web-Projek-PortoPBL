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
    alert('Login Berhasil!');

    // Arahkan sesuai role
    if (role === "Mahasiswa") {
      window.location.href = "mahasiswa/index_mahasiswa.html";
    } else if (role === "Dosen") {
      window.location.href = "Dosen/index_dosen.html";
    }
  }
});
