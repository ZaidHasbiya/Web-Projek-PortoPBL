<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PortoPBL</title>

  <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
  crossorigin="anonymous"/>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../css/bootstrap.min.css">

  <link rel="stylesheet" href="../styles.css" type="text/css">
</head>

<body>

 <?php include 'layouts/navbar_mhs.php'; ?>
  <div class="container mt-5 pt-5">
  <!-- Baris utama -->
  <div class="row align-items-center">
    <!-- Kolom kiri: Foto + Jurusan -->
    <div class="col-md-4 text-center">
      <div class="ratio ratio-1x1 rounded-circle overflow-hidden mx-auto mb-2" style="width: 200px;">
        <img src="../tim/profil-kosong.jpeg" alt="Foto Mahasiswa" class="w-100 h-100" style="object-fit: cover;">
      </div>
      <small class="d-block mb-3 text-muted">Nama Mahasiswa</small>

      <div class="bg-info p-2 rounded d-inline-block">
        <strong class="text-white">Jurusan: Teknik Informatika</strong>
      </div>
    </div>

    <!-- Kolom kanan: Tentang Mahasiswa -->
    <div class="col-md-8">
      <!-- Tentang Mahasiswa -->
      <div class="bg-info p-3 rounded mb-4">
        <h5 class="fw-bold text-white">Tentang Mahasiswa</h5>
        <p class="mb-0 text-white">Deskripsi singkat tentang mahasiswa dapat ditulis di sini.</p>
      </div>

      <!-- Catatan Prestasi -->
      <div class="bg-info p-3 rounded">
        <h5 class="fw-bold text-white">Catatan Prestasi</h5>
          <p class="text-white">Juara 1 Lomba Web Design</p>
          <p class="text-white">Asisten Praktikum Pemrograman Web</p>
          <p class="text-white">Peserta Kegiatan PBL 2025</p>
      </div>
    </div>
</div>
<div class="bg-info p-4 rounded mt-4">
  <h5 class="fw-bold mb-3 text-center text-white">Proyek</h5>

  <!-- Judul Proyek -->
 <div class="mb-3">
    <label class="form-label fw-semibold text-white">Judul Proyek</label>
    <div class="form-control bg-light">
      Sistem Informasi Portofolio Mahasiswa
    </div>
  </div>

  <!-- Deskripsi Proyek -->
  <div class="mb-4">
    <label class="form-label fw-semibold text-white">Deskripsi Proyek</label>
    <div class="form-control bg-light" style="min-height: 100px;">
      Proyek ini bertujuan untuk mengembangkan sebuah sistem informasi portofolio mahasiswa berbasis web.
      Website ini menampilkan profil mahasiswa, data akademik, catatan prestasi, dan proyek yang telah dikerjakan.
      Sistem ini dibangun menggunakan HTML, CSS, Bootstrap, serta PHP dan MySQL sebagai backend.
      Tujuannya adalah membantu mahasiswa mempresentasikan kemampuan dan pencapaian mereka secara profesional.
    </div>
  </div>

  <!-- Dua kolom sejajar -->
  <div class="row g-3">
    <div class="col-md-6">
      <div class="bg-light border border-dark-subtle p-5 text-center rounded">
        <span class="fw-semibold text-muted">Video</span>
        <div class="ratio ratio-16x9">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/MCVkMmYL-aY?si=m3doQT0OKtydUnms" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
          referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="bg-light border border-dark-subtle p-5 text-center rounded">
        <span class="fw-semibold text-muted">Foto</span>
        <img src="../asset/projek.png" alt="Foto Proyek" class="img-fluid rounded">
      </div>
    </div>
  </div>
</div>
</div>
  <!-- ===== Wave + Footer ===== -->
  <img src="asset/wave-dark-blue.svg" class="w-100" alt="">
  <footer class="text-center py-3 bg-light mt-5">
    &copy; <span>2025</span> Tim Web Portofolio Projek PBL
  </footer>

  <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>