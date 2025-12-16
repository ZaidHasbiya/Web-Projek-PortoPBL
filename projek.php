<?php

include 'koneksi.php';

$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

$total_query = mysqli_query($koneksi,
    "SELECT COUNT(*) AS total FROM projek");
$total_data = mysqli_fetch_assoc($total_query)['total'];
$total_page = ceil($total_data / $limit);

$query = "SELECT projek.*, users.nama, users.username 
          FROM projek 
          JOIN users ON projek.user_id = users.id 
          ORDER BY projek.judul ASC
          LIMIT $limit OFFSET $offset";

$data = mysqli_query($koneksi, $query);
$result = mysqli_num_rows($data);
?>

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

  <link rel="stylesheet" href="css/bootstrap.min.css">

  <link rel="stylesheet" href="styles.css" type="text/css">
  <link rel="stylesheet" href="custom.css">
</head>

<body>

  <?php include 'layouts/navbar_publik.php'; ?>
  <div class="container">
    <h1 class="my-5 pt-5">Projek</h1>
    <?php if ($result > 0 ):?>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php while($row = mysqli_fetch_assoc($data)) :?>
  <div class="col">
    <div class="card border border-info">
      <img src="asset/uploads/<?= $row['gambar_projek']; ?>" class="card-img-top" alt="Projek Web Portofolio PBL">
      <div class="card-body">
        <h5 class="card-title"><?= $row['judul']; ?></h5>
        <p class="card-text">Deskripsi Projek : <?= $row['deskripsi']; ?></p>
        <p class="card-text">Dibuat Oleh :</p>
        <p class="card-text">Nama Mahasiswa : <?= $row['nama']; ?></p>
        <p class="card-text">NIM : <?= $row['username']; ?></p>
        <a href="lihat_projek.php?projek_id=<?= $row['projek_id']; ?>" class="btn btn-outline-info rounded-pill d-flex justify-content-center strk-btn">Lihat Projek</a>
      </div>
    </div>
  </div>
  <?php endwhile; ?>
  </div>
  <?php if ($total_page > 1): ?>
<nav class="mt-4">
  <ul class="pagination justify-content-center">
    <?php for ($i = 1; $i <= $total_page; $i++): ?>
      <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
        <a class="page-link" href="?page=<?= $i; ?>">
          <?= $i; ?>
        </a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>
<?php endif; ?>
  <?php else : ?>
    <h2>Belum ada projek</h2>
  <?php endif; ?>
  </div>

<div class="overflow-hidden mt-5">
  <img src="asset/wave-new-navy.svg"
       class="img-fluid d-block"
       style="width:100vw"
       alt="wave">
</div>
<section class="bg-footer">
<br><br><br>
</section>

<footer class="w-100 text-center py-3 bg-light">
  &copy; <span>2025</span> Tim Web Portofolio Projek PBL
</footer>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>