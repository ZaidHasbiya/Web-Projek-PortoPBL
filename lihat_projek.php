<?php
/*
Nama File   : lihat_projek.php
Deskripsi     : Menampilkan detail proyek mahasiswa beserta
             komentar pada halaman publik PortoPBL
Dibuat Oleh    : Zaid Hasbiya Abrar - NIM : [3312501046]
Tanggal     : 7 Oktober 2025
*/

session_start();
include 'koneksi.php';

// Fungsi helper untuk menyimpan pesan alert ke session
function set_sweet_alert($icon, $title, $url) {
    $_SESSION['sweet_alert'] = [
        'icon' => $icon,
        'title' => $title,
        'url' => $url
    ];
}

// Mengambil id proyek dari parameter URL
$projek_id = $_GET['projek_id'] ?? null;

// Validasi jika id proyek tidak tersedia
if (!$projek_id) {
    set_sweet_alert('warning', 'Projek tidak ditemukan!', 'projek_mhs.php');
}

if (!isset($_SESSION['sweet_alert'])) {
    // Query untuk mengambil data proyek dan pemiliknya
    $query = "SELECT projek.*, users.nama, users.username 
              FROM projek 
              JOIN users ON projek.user_id = users.id 
              WHERE projek.projek_id = '$projek_id'";
    $result = mysqli_query($koneksi, $query);
    $projek = mysqli_fetch_assoc($result);

    // Validasi jika data proyek tidak ditemukan
    if (!$projek) {
        set_sweet_alert('error', 'Projek tidak ditemukan.', 'projek.php');
    }
}

// Query untuk mengambil komentar proyek (hanya dijalankan jika projek ada)
if (isset($projek) && $projek) {
    $komentarQuery = "SELECT komentar.*, users.nama 
                      FROM komentar 
                      JOIN users ON komentar.user_id = users.id 
                      WHERE komentar.projek_id = '$projek_id' 
                      ORDER BY komentar.komentar_id DESC";
    $komentarResult = mysqli_query($koneksi, $komentarQuery);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PortoPBL</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="styles.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php include 'layouts/navbar_publik.php'; ?>

    <div class="container py-5 mt-5">

        <?php if (isset($projek) && $projek): ?>
        <h1><?= htmlspecialchars($projek['judul']); ?></h1>

        <?php if (!empty($projek['gambar_projek'])): ?>
        <img src="asset/uploads/<?= htmlspecialchars($projek['gambar_projek']); ?>"
            class="img-fluid rounded shadow-sm mb-4" alt="Gambar Projek" />
        <?php endif; ?>

        <h2>Deskripsi Projek</h2>
        <p><?= nl2br(htmlspecialchars($projek['deskripsi'])); ?></p>

        <?php if (!empty($projek['link'])): ?>
        <h2>Video</h2>
        <div class="ratio ratio-16x9">
                <iframe src="<?= htmlspecialchars($projek['link']); ?>" title="Video Projek" allowfullscreen></iframe>
            </div>
        <?php endif; ?>

        <p>
            <strong>Tautan Repositori:</strong><br />
            <a href="<?= htmlspecialchars($projek['link_repo']); ?>" target="_blank"
                class="text-break d-block text-decoration-none">
                <?= htmlspecialchars($projek['link_repo']); ?>
            </a>
        </p>

        <p><strong>Tanggal Dibuat:</strong> <?= htmlspecialchars($projek['tgl_pembuatan']); ?></p>
        <p><strong>Tanggal Selesai:</strong> <?= htmlspecialchars($projek['tgl_selesai']); ?></p>
        <p><strong>Dibuat Oleh:</strong> <?= htmlspecialchars($projek['nama']); ?></p>
        <p><strong>NIM:</strong> <?= htmlspecialchars($projek['username']); ?></p>

        <div class="border border-dark p-3 rounded mt-4">
            <h6 class="fw-semibold mb-3">Komentar</h6>

            <?php if (mysqli_num_rows($komentarResult) > 0): ?>
            <?php while ($k = mysqli_fetch_assoc($komentarResult)): ?>
            <div class="p-3 bg-light border rounded mb-3">
                <strong><?= htmlspecialchars($k['nama']); ?></strong>
                <p class="mb-0"><?= nl2br(htmlspecialchars($k['komentar'])); ?></p>
            </div>
            <?php endwhile; ?>
            <?php else: ?>
            <p class="text-muted">Belum ada komentar.</p>
            <?php endif; ?>

        </div>
        <?php endif; ?>

    </div>

    <div class="overflow-hidden mt-5">
        <img src="asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave" />
    </div>

    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>

    <script src="js/bootstrap.bundle.min.js"></script>

    <script>
    <?php if (isset($_SESSION['sweet_alert'])): ?>
        Swal.fire({
            icon: '<?= $_SESSION['sweet_alert']['icon']; ?>',
            title: '<?= $_SESSION['sweet_alert']['title']; ?>',
            confirmButtonColor: '#0d6efd'
        }).then((result) => {
            window.location.href = '<?= $_SESSION['sweet_alert']['url']; ?>';
        });
    <?php unset($_SESSION['sweet_alert']); ?>
    <?php endif; ?>
    </script>

</body>

</html>