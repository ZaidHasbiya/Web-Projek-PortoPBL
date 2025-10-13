document.getElementById('loginBtn').addEventListener('click', function() {

    const nim = document.querySelector('.inputNIM').value.trim();
    const password = document.querySelector('.inputPassword').value.trim();

    if(nim === "" || password === "") {
      alert("Mohon isi NIM dan Password Anda!");
      return;
    }

    alert("Login Berhasil!");

    window.location.href = "../mahasiswa/index_mahasiswa.html";
  });
  
