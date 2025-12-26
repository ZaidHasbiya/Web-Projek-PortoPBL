<?php
/*
Nama File   : jurusan_mesin.php
Deskripsi     : Menampilkan daftar mahasiswa jurusan Teknik Mesin
             dengan fitur pagination pada halaman publik
Dibuat Oleh    : Zaid Hasbiya Abrar - NIM : [3312501046]
Tanggal     : 7 Oktober 2025
*/

include 'koneksi.php';

// Menentukan jumlah data yang ditampilkan per halaman
$limit = 6;

// Mengambil nomor halaman dari parameter URL
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

// Mencegah halaman bernilai kurang dari 1
$page = ($page < 1) ? 1 : $page;

// Menghitung offset data untuk query SQL
$offset = ($page - 1) * $limit;

// Query untuk mengambil data mahasiswa Teknik Mesin
$query = "SELECT * FROM users 
          WHERE jurusan = 'teknik mesin' 
          AND role = 'mahasiswa'
          LIMIT $limit OFFSET $offset";

// Menjalankan query data mahasiswa
$data = mysqli_query($koneksi, $query);

// Query untuk menghitung total mahasiswa Teknik Mesin
$totalQuery = "SELECT COUNT(*) AS total 
               FROM users 
               WHERE jurusan = 'teknik mesin' 
               AND role = 'mahasiswa'";

// Menjalankan query total data
$totalResult = mysqli_query($koneksi, $totalQuery);

// Mengambil hasil total data
$totalRow  = mysqli_fetch_assoc($totalResult);
$totalData = $totalRow['total'];

// Menghitung total halaman pagination
$totalPage = ceil($totalData / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Metadata halaman -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PortoPBL</title>

  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
  />

  <!-- File CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="custom.css" />
</head>

<body>

<!-- Menampilkan navbar publik -->
<?php include 'layouts/navbar_publik.php'; ?>

<div class="container">

  <!-- Judul halaman -->
  <h1 class="my-5 pt-5 text-center">Jurusan Teknik Mesin</h1>

  <!-- Mengecek apakah data mahasiswa tersedia -->
  <?php if (mysqli_num_rows($data) > 0): ?>

    <div class="d-flex flex-wrap justify-content-evenly align-items-start gap-4">

      <!-- Perulangan data mahasiswa -->
      <?php while ($row = mysqli_fetch_assoc($data)): ?>
        <?php
          // Menentukan foto profil mahasiswa
          // Jika tidak ada foto, gunakan foto default
          $foto = !empty($row['foto_profil'])
            ? "asset/profil/" . $row['foto_profil']
            : "tim/profil-kosong.jpeg";
        ?>

        <div class="col-md-4 col-lg-3">
          <div class="card shadow-sm border-0 h-100">

            <!-- Foto mahasiswa -->
            <div class="ratio ratio-1x1">
              <img
                src="<?= $foto ?>"
                class="card-img-top rounded-2"
                alt="Foto Mahasiswa"
                style="object-fit: cover;"
              />
            </div>

            <!-- Informasi mahasiswa -->
            <div class="card-body text-center">
              <p class="mb-1"><strong>Nama:</strong> <?= $row['nama']; ?></p>
              <p class="mb-1"><strong>NIM:</strong> <?= $row['username']; ?></p>
              <p class="mb-3"><strong>Jurusan:</strong> <?= $row['jurusan']; ?></p>

              <!-- Tombol lihat profil -->
              <a
                href="lihat_profil_mhs.php?id=<?= $row['id']; ?>"
                class="btn btn-clr px-4"
              >
                Lihat Profil
              </a>
            </div>

          </div>
        </div>

      <?php endwhile; ?>
    </div>

    <!-- Navigasi pagination -->
    <?php if ($totalPage > 1): ?>
      <nav class="d-flex justify-content-center mt-5">
        <ul class="pagination">

          <!-- Tombol halaman sebelumnya -->
          <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page - 1 ?>">Sebelumnya</a>
          </li>

          <!-- Nomor halaman -->
          <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $i ?>">
                <?= $i ?>
              </a>
            </li>
          <?php endfor; ?>

          <!-- Tombol halaman selanjutnya -->
          <li class="page-item <?= ($page >= $totalPage) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page + 1 ?>">Selanjutnya</a>
          </li>

        </ul>
      </nav>
    <?php endif; ?>

  <?php else: ?>
    <!-- Jika data tidak tersedia -->
    <h2 class="text-center">Belum ada mahasiswa</h2>
  <?php endif; ?>

</div>

<!-- Wave -->
<div class="overflow-hidden mt-5">
  <img
    src="asset/wave-new-navy.svg"
    class="img-fluid d-block"
    style="width:100vw"
    alt="wave"
  />
</div>

<!-- Footer -->
<footer class="w-100 text-center py-3 bg-light">
  &copy; 2025 Tim Web Portofolio Projek PBL
</footer>

<!-- Bootstrap JS -->
<script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>
