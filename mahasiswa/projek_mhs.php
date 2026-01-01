<?php
/*
Nama File : projek_mhs.php
Deskripsi    : Menampilkan seluruh projek mahasiswa
            dengan fitur pagination
Dibuat Oleh    : Fathur Alfitrah - NIM : [3312501048]
Tanggal     : 10 Oktober 2025
*/

session_start();
// Memulai session

include '../koneksi.php';

// Validasi login
if (!isset($_SESSION['username'])) {
    echo "<script>
            alert('Silahkan Melakukan Login Terlebih Dahulu');
            window.location.href = '../login.php';
          </script>";
    exit;
}

// Validasi role mahasiswa
if ($_SESSION['role'] !== 'mahasiswa') {
    echo "<script>
            alert('Maaf, anda bukan mahasiswa. Silakan login ulang.');
            window.location.href = '../login.php';
          </script>";
    exit;
}

// Konfigurasi pagination
$limit  = 6;
$page   = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page   = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

// Menghitung total data projek
$total_query = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM projek"
);
$total_data = mysqli_fetch_assoc($total_query)['total'];
$total_page = ceil($total_data / $limit);

/*
Query mengambil data projek
digabung dengan data mahasiswa
*/
$query = "
    SELECT projek.*, users.nama, users.username
    FROM projek
    JOIN users ON projek.user_id = users.id
    ORDER BY projek.judul ASC
    LIMIT $limit OFFSET $offset
";
$data   = mysqli_query($koneksi, $query);
$result = mysqli_num_rows($data);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PortoPBL</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" />

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700;900&display=swap"
        rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../styles.css" type="text/css">
</head>

<body>

    <!-- Navbar Mahasiswa -->
    <?php include '../layouts/navbar_mhs.php'; ?>

    <div class="container">
        <h1 class="my-5 pt-5">Projek</h1>

        <?php if ($result > 0): ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">

            <?php while ($row = mysqli_fetch_assoc($data)): ?>
            <div class="col">
                <div class="card border border-info h-100 d-flex flex-column">

                    <!-- Gambar Projek -->
                    <div class="ratio ratio-16x9 overflow-hidden">
                        <img src="../asset/uploads/<?= htmlspecialchars($row['gambar_projek']); ?>"
                            class="w-100 h-100 object-fit-cover" alt="Projek Web Portofolio PBL">
                    </div>

                    <!-- Informasi Projek -->
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['judul']); ?></h5>

                        <p class="card-text">
                            Deskripsi Projek : <?= htmlspecialchars($row['deskripsi']); ?>
                        </p>

                        <p class="card-text mb-1">Dibuat Oleh :</p>
                        <p class="card-text mb-1">
                            Nama Mahasiswa : <?= htmlspecialchars($row['nama']); ?>
                        </p>
                        <p class="card-text">
                            NIM : <?= htmlspecialchars($row['username']); ?>
                        </p>

                        <a href="lihat_projek_mhs.php?projek_id=<?= $row['projek_id']; ?>"
                            class="btn btn-outline-info rounded-pill d-flex justify-content-center">
                            Lihat Projek
                        </a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>

        </div>

        <!-- Pagination -->
        <?php if ($total_page > 1): ?>
        <nav class="d-flex justify-content-center mt-5">
            <ul class="pagination">

                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">
                        <
                    </a>
                </li>

                <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
                <?php endfor; ?>

                <li class="page-item <?= ($page >= $totalPage) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">
                        >
                    </a>
                </li>

            </ul>
        </nav>
        <?php endif; ?>

        <?php else: ?>
        <h2>Belum ada projek</h2>
        <?php endif; ?>
    </div>

    <!-- Wave -->
    <div class="overflow-hidden mt-5">
        <img src="../asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave">
    </div>

    <!-- Footer -->
    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    AOS.init({
        duration: 1000,
        once: true
    });
    </script>
</body>

</html>