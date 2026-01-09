<?php
/*
Nama File  : lihat_projek_dosen.php
Deskripsi  :
File ini digunakan oleh dosen untuk melihat detail projek mahasiswa,
menampilkan deskripsi, gambar, video, serta memberikan dan melihat
komentar dosen terhadap projek mahasiswa.
*/

session_start();
include '../koneksi.php';

// Fungsi SweetAlert redirect (Ditambahkan untuk standarisasi alert)
function redirect_alert($icon, $title, $url) {
    $_SESSION['alert'] = [
        'icon' => $icon,
        'title' => $title,
        'url' => $url
    ];
}

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    redirect_alert('warning', 'Silakan login terlebih dahulu!', '../login.php');
    header("Location: ../login.php");
    exit;
}

// Cek apakah user memiliki role dosen
if ($_SESSION['role'] !== 'dosen') {
    redirect_alert('error', 'Hanya dosen yang dapat memberikan komentar!', '../login.php');
    header("Location: ../login.php");
    exit;
}

$user_id   = $_SESSION['id'];           // ID dosen
$projek_id = isset($_GET['projek_id']) ? $_GET['projek_id'] : null;        // ID projek

// Cek apakah ID projek tersedia
if (!$projek_id) {
    redirect_alert('warning', 'Projek tidak ditemukan!', 'projek_mhs.php');
    header("Location: projek_mhs.php");
    exit;
}

// Mengambil data projek beserta data mahasiswa pembuat projek
$query = "SELECT projek.*, users.nama, users.username 
          FROM projek 
          JOIN users ON projek.user_id = users.id 
          WHERE projek.projek_id = '$projek_id'";
$result = mysqli_query($koneksi, $query);
$projek = mysqli_fetch_assoc($result);

// Jika data projek tidak ditemukan
if (!$projek) {
    redirect_alert('error', 'Projek tidak ditemukan.', 'projek_mhs.php');
    header("Location: projek_mhs.php");
    exit;
}

// Proses penyimpanan komentar dosen
if (isset($_POST['komentar'])) {
  $komentar = mysqli_real_escape_string($koneksi, $_POST['komentar']);

  $insert = "INSERT INTO komentar (projek_id, user_id, komentar) 
             VALUES ('$projek_id', '$user_id', '$komentar')";
  
  if(mysqli_query($koneksi, $insert)) {
      redirect_alert('success', 'Komentar berhasil dikirim!', 'lihat_projek_dosen.php?projek_id=' . $projek_id);
  } else {
      redirect_alert('error', 'Gagal mengirim komentar!', 'lihat_projek_dosen.php?projek_id=' . $projek_id);
  }
  header("Location: lihat_projek_dosen.php?projek_id=" . $projek_id);
  exit;
}

// Mengambil daftar komentar pada projek
$komentarQuery = "SELECT komentar.*, users.nama 
                  FROM komentar 
                  JOIN users ON komentar.user_id = users.id 
                  WHERE komentar.projek_id = '$projek_id' 
                  ORDER BY komentar.komentar_id DESC";
$komentarResult = mysqli_query($koneksi, $komentarQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PortoPBL</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css" type="text/css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php include '../layouts/navbar_dosen.php'; ?>

    <div class="container py-5 mt-5">

        <div class="mb-5">
            <h1 class="fw-bold mb-1"><?= htmlspecialchars($projek['judul']); ?></h1>
            <span class="badge bg-info text-dark px-3 py-2 rounded-pill">
                📘 Detail Projek Mahasiswa
            </span>
        </div>

        <!-- Media Projek -->
        <div class="row g-4 mb-5 align-items-stretch">

            <?php if (!empty($projek['gambar_projek'])): ?>
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100 overflow-hidden">
                    <div class="ratio ratio-16x9">
                        <img src="../asset/uploads/<?= htmlspecialchars($projek['gambar_projek']); ?>"
                            class="w-100 h-100" style="object-fit: cover;" alt="Gambar Projek">
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (!empty($projek['link'])): ?>
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100 overflow-hidden">
                    <div class="ratio ratio-16x9">
                        <iframe src="<?= htmlspecialchars($projek['link']); ?>" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>

        <!-- Deskripsi -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body px-4 py-4">
                <h4 class="fw-semibold mb-3">📄 Deskripsi Projek</h4>
                <p class="mb-0 text-secondary" style="line-height: 1.7;">
                    <?= nl2br(htmlspecialchars($projek['deskripsi'])); ?>
                </p>
            </div>
        </div>

        <!-- Informasi Projek -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body px-4 py-4">

                <h5 class="fw-semibold mb-4">📌 Informasi Projek</h5>

                <div class="row gy-2 mb-3">
                    <div class="col-md-6">
                        <p class="mb-1">👤 <strong>Mahasiswa</strong><br><?= $projek['nama']; ?></p>
                        <p class="mb-0">🆔 <strong>NIM</strong><br><?= $projek['username']; ?></p>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1">📅 <strong>Tanggal Dibuat</strong><br><?= $projek['tgl_pembuatan']; ?></p>
                        <p class="mb-0">✅ <strong>Tanggal Selesai</strong><br><?= $projek['tgl_selesai']; ?></p>
                    </div>
                </div>

                <?php if (!empty($projek['link_repo'])): ?>
                <hr class="my-3">
                <p class="mb-1 fw-semibold">🔗 Repositori Projek</p>
                <a href="<?= htmlspecialchars($projek['link_repo']); ?>" target="_blank"
                    class="text-decoration-none text-break">
                    <?= htmlspecialchars($projek['link_repo']); ?>
                </a>
                <?php endif; ?>

            </div>
        </div>

        <!-- Form Komentar Dosen -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body px-4 py-4">
                <h5 class="fw-semibold mb-3">✍️ Tambahkan Komentar</h5>

                <form method="POST">
                    <div class="mb-3">
                        <textarea name="komentar" class="form-control" rows="3" placeholder="Tulis komentar di sini..."
                            required></textarea>
                    </div>
                    <button type="submit" class="btn btn-clr">Kirim Komentar</button>
                </form>
            </div>
        </div>

        <!-- Daftar Komentar -->
        <div class="card shadow-sm border-0">
            <div class="card-body px-4 py-4">
                <h5 class="fw-semibold mb-3">💬 Komentar</h5>

                <?php if (mysqli_num_rows($komentarResult) > 0): ?>
                <?php while ($k = mysqli_fetch_assoc($komentarResult)): ?>
                <div class="border rounded p-3 mb-3 bg-light">
                    <strong><?= htmlspecialchars($k['nama']); ?></strong>
                    <p class="mb-0 mt-1 text-secondary">
                        <?= nl2br(htmlspecialchars($k['komentar'])); ?>
                    </p>
                </div>
                <?php endwhile; ?>
                <?php else: ?>
                <p class="text-muted mb-0">Belum ada komentar.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <img src="../asset/wave-new-navy.svg" class="img-fluid d-block" style="width:100vw" alt="wave">
    </div>
    <footer class="text-center py-3" style="background-color: #e9e1c9; color: #5a5a5a; padding: 25px 0;">
        &copy; <span>2025</span> Tim Web Portofolio Projek PBL
    </footer>
    <script src="../js/bootstrap.bundle.min.js"></script>

    <script>
    // SweetAlert Handling Logic
    <?php if (isset($_SESSION['alert'])): ?>
    Swal.fire({
        icon: '<?= $_SESSION['alert']['icon']; ?>',
        title: '<?= $_SESSION['alert']['title']; ?>',
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        window.location.href = '<?= $_SESSION['alert']['url']; ?>';
    });
    <?php unset($_SESSION['alert']); endif; ?>
    </script>

</body>

</html>