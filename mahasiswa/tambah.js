const form = document.getElementById('formProjek');

    form.addEventListener('submit', function(e) {
      e.preventDefault(); // mencegah form langsung dikirim

      Swal.fire({
        title: 'Yakin ingin menambahkan projek?',
        text: "Pastikan semua data sudah benar!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Tambahkan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#198754',
        cancelButtonColor: '#d33'
      }).then((result) => {
        if (result.isConfirmed) {
          // setelah user klik "Ya"
          Swal.fire({
            title: 'Berhasil!',
            text: 'Projek berhasil ditambahkan!',
            icon: 'success',
            confirmButtonColor: '#198754'
          }).then(() => {
            window.location.href = "projek_saya.html";
          });
        }
      });
    });