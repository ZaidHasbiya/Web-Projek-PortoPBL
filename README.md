**Project Overview**

PortoPBL — Platform Portofolio Projek PBL adalah aplikasi web sederhana untuk membantu mahasiswa mendokumentasikan, menampilkan, dan membagikan proyek PBL (Project-Based Learning). Aplikasi ini dibuat oleh Tim Web Portofolio Projek PBL (2025) sebagai alat pamer portofolio digital yang memuat deskripsi proyek, gambar/video demo, tautan repositori, dan riwayat penilaian dosen.

**Fitur Utama**
- **Publik:** Halaman landing, daftar projek, daftar mahasiswa per jurusan, dan detail profil mahasiswa.
- **Autentikasi:** Login untuk peran berbeda (Admin/Dosen/Mahasiswa).
- **Manajemen Projek:** Mahasiswa dapat menambah, mengubah, dan menghapus projek mereka.
- **Dosen:** dosen dapat mencari portofolio mahasiswa berdasarkan NIM dan nama mahasiswa serta melihat dan menilai portofolio mahasiswa.
- **Admin:** Admin dapat mengelola data mahasiswa/dosen.
- **Pagination & Media:** Daftar bersifat paginasi; mendukung gambar dan video untuk tiap projek.

**Teknologi**
- **Backend:** PHP (plain PHP dengan file-page architecture).  
- **Database:** MySQL (dikelola melalui XAMPP / MariaDB).  
- **Frontend / Styling:** Bootstrap 5, AOS (Animate On Scroll), custom CSS.  
- **Server lokal yang direkomendasikan:** XAMPP (Apache + MySQL).

**Prasyarat**
- XAMPP (atau stack LAMP/WAMP setara) terpasang.  
- PHP 7.4+ (atau versi PHP yang tersedia pada XAMPP terkini).  
- MySQL / MariaDB berjalan.

**Instalasi & Menjalankan Lokal**
1. Salin folder proyek ke direktori web server (contoh XAMPP):

```bash
# contoh: letakkan di htdocs
COPY project_folder TO C:\xampp\htdocs\WEB-PORTOPBL
```

2. Import database contoh:

```sql
-- Gunakan phpMyAdmin atau mysql client
-- Import file: database/test_portopbl.sql
```

3. Konfigurasi koneksi database: buka file [koneksi.php](koneksi.php) dan sesuaikan kredensial MySQL (host, username, password, nama_database).

4. Jalankan XAMPP (Apache + MySQL) lalu akses aplikasi di: http://localhost/WEB-PORTOPBL

**Konfigurasi Penting**
- `koneksi.php`: file ini berisi parameter koneksi database. Pastikan user MySQL memiliki hak akses ke database yang diimpor.
- Direktori unggahan projek: `asset/uploads/` — pastikan folder ini dapat ditulisi (permission) agar pengguna dapat mengunggah gambar.

**Struktur File Ringkas**
- **Root:** [index.php](index.php), [login.php](login.php), [logout.php](logout.php), [koneksi.php](koneksi.php), [projek.php](projek.php), [lihat_profil_mhs.php](lihat_profil_mhs.php)  
- **Folder `dashboard/`:** Panel admin — [dashboard.php](dashboard/dashboard.php), pengelolaan `data_mahasiswa.php`, `data_dosen.php`, `data_komentar.php`.  
- **Folder `mahasiswa/`:** Halaman khusus mahasiswa — `tambah_projek.php`, `projek_saya.php`, `edit_profil.php`, `ubah_password.php`, dll.  
- **Folder `Dosen/`:** Halaman khusus dosen — `index_dosen.php`, `lihat_projek_dosen.php`, `profil_saya.php`.  
- **Asset & Media:** `asset/profil/` (foto profil), `asset/uploads/` (gambar projek), `tim/` (foto tim), `css/`, `js/`.

Untuk daftar lengkap file, lihat struktur proyek di root folder.

**Alur Pengguna (Ringkas)**
- Pengunjung publik dapat melihat halaman landing ([index.php](index.php)), daftar projek publik ([projek.php](projek.php)), daftar mahasiswa per jurusan (mis. [jurusan_if.php](jurusan_if.php)), dan dapat melihat portofolio dari masing masing mahasiswa
- Mahasiswa login lalu dapat menambah dan mengelola projek di `mahasiswa/`.
- Dosen dapat mencari Mahasiswa Berdasarkan NIM atau Nama mahasiswa dan melakukan penilaian pada portofolio mahasiswa.
- Admin dapat mengelola data mahasiswa dan dosen di dasbor admin 

**Catatan Database & Tabel Penting**
- File SQL contoh: [database/test_portopbl.sql](database/test_portopbl.sql).  
- Tabel utama: `users` (menyimpan data mahasiswa/dosen/admin), `projek` (detail projek), `penilaian_portofolio` (riwayat penilaian oleh dosen), serta tabel pendukung lainnya.

**Keamanan & Rekomendasi**
- Validasi input & sanitasi: banyak halaman sudah menggunakan `htmlspecialchars()` untuk output; pastikan input juga divalidasi di server.
- Jangan gunakan kredensial database default di lingkungan produksi.  
- Batasi ukuran dan tipe file yang diunggah, dan simpan nama file secara aman untuk menghindari path traversal.

**Pengembangan Lanjutan (Saran)**
- Tambahkan prepared statements / parameterized queries (mysqli_prepare / PDO) untuk mencegah SQL Injection.  
- Implementasikan manajemen sesi yang lebih kuat (session_regenerate_id setelah login, cek timeout).  
- Pisahkan konfigurasi ke `.env` atau file konfigurasi terpisah di luar webroot.

**Kontribusi**
- Untuk kontribusi, buat issue atau fork dan PR. Sertakan deskripsi perubahan dan langkah pengujian singkat.

**Kontak & Tim**
- Tim Pengembang: Zaid Hasbiya Abrar (3312501046), Fathur Alfitrah Dermawan (3312501047), Reifandra Kinadi (3312501048).  
- Tahun pembuatan: 2025.

**License**
- Lisensi tidak ditentukan dalam repo; untuk penggunaan umum, pertimbangkan menambahkan `LICENSE` (mis. MIT) jika ingin membuka sumber.

---

File yang direferensikan dalam README ini dapat dilihat langsung di root proyek, contoh: [index.php](index.php), [koneksi.php](koneksi.php), dan folder [dashboard/](dashboard/) serta [mahasiswa/](mahasiswa/).
"# Web-Projek-PortoPBL" 
