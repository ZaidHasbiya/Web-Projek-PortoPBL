-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2025 at 01:47 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_portopbl`
--

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `komentar_id` int(11) NOT NULL,
  `komentar` varchar(255) NOT NULL,
  `projek_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`komentar_id`, `komentar`, `projek_id`, `user_id`) VALUES
(1, 'mantap', 6, 1),
(2, 'oke', 11, 13),
(3, 'oke', 11, 17),
(4, 'abadi, absen, absolut, adaptasi, administrasi, agresif, akurat, akses, aktual, alami, alamat, aliran, alternatif, aman, ambisi, analisis, analogi, anak, ancaman, anggaran, anjuran, anonim, antrian, aplikasi, apresiasi, arena, argumentasi, arsitektur, atmo', 11, 17),
(5, 'Galaksi berputar sunyi di ruang luas, bintang-bintang menyala lembut, menciptakan harmoni cahaya yang menenangkan hati. Dalam diam kosmos, imajinasi manusia melayang bebas, mencari makna di antara titik-titik terang tak berujung. Keheningan abadi misteri.', 11, 17);

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_portofolio`
--

CREATE TABLE `penilaian_portofolio` (
  `id_penilaian` int(11) NOT NULL,
  `mahasiswa_id` int(11) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `komentar` varchar(255) NOT NULL,
  `nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penilaian_portofolio`
--

INSERT INTO `penilaian_portofolio` (`id_penilaian`, `mahasiswa_id`, `dosen_id`, `komentar`, `nilai`) VALUES
(1, 1, 16, 'oke', 100),
(2, 1, 16, 'oke', 100);

-- --------------------------------------------------------

--
-- Table structure for table `projek`
--

CREATE TABLE `projek` (
  `projek_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `link_repo` varchar(255) NOT NULL,
  `gambar_projek` varchar(255) NOT NULL,
  `tgl_pembuatan` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projek`
--

INSERT INTO `projek` (`projek_id`, `judul`, `deskripsi`, `link`, `link_repo`, `gambar_projek`, `tgl_pembuatan`, `tgl_selesai`, `user_id`) VALUES
(6, 'Web Portofolio Projek PBL (Project Based Learningg)', 'tes', 'https://www.youtube.com/embed/Ak6VTSekGP4?si=pJ4HSd2ggz3qC_g8', 'https://github.com/ZaidHasbiya/Web-Projek-PortoPBL.git', 'poltek.jpeg', '2025-11-13', '2025-11-13', 1),
(11, 'Web Portofolio Projek PBL (Project Based Learning)', 'oke', 'https://www.youtube.com/embed/L-gKceeb61Q?si=reXYD4t7YNArm25u', 'https://github.com/ZaidHasbiya/Web-Projek-PortoPBL.git', '1765844662_RPP.drawio.png', '2025-11-16', '2025-11-16', 1),
(15, 'Web Portofolio Projek PBL (Project Based Learning)', 'Web Portofolio PBL', 'https://www.youtube.com/embed/L-gKceeb61Q?si=reXYD4t7YNArm25u', '', 'RPP.drawio.png', '2025-12-02', '2025-12-02', 1),
(17, 'Web Portofolio Projek PBL (Project Based Learning)', 'Web Portofolio Projek PBL (Project Based Learning)', 'https://www.youtube.com/embed/L-gKceeb61Q?si=reXYD4t7YNArm25u', 'https://github.com/ZaidHasbiya/Web-Projek-PortoPBL.git', '1765845017_poltek.jpeg', '2025-12-16', '2025-12-16', 12);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `deskripsi_diri` varchar(255) DEFAULT NULL,
  `prestasi` varchar(255) DEFAULT NULL,
  `jurusan` enum('teknik mesin','teknik informatika','teknik elektro','manajemen bisnis') DEFAULT NULL,
  `role` enum('mahasiswa','dosen','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `foto_profil`, `deskripsi_diri`, `prestasi`, `jurusan`, `role`) VALUES
(1, 'Zaid Hasbiya Abrar', '3312501046', 'Jiro2127', 'zaid.jpeg', 'Belum Diatur', 'Magang Di Dinas Komunikasi Dan Informatika Kota Batam', 'teknik informatika', 'mahasiswa'),
(3, 'Reifandra Kinadii', '3312501048', 'Jiro2127', NULL, '', '', 'teknik informatika', 'mahasiswa'),
(12, 'Fathur Alfitrah', '3312501047', '123456', NULL, '', '', NULL, 'mahasiswa'),
(13, 'dosen', '331250104', 'dosen123', NULL, '', '', 'teknik informatika', 'dosen'),
(14, 'admin', '331250105', 'admin123', NULL, '', '', 'teknik informatika', 'admin'),
(16, 'dosen', '3312501', 'dosen123', NULL, '', '', 'teknik informatika', 'dosen'),
(17, 'Cyntia', '123456', '123456', NULL, '', '', 'teknik informatika', 'dosen');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`komentar_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `projek_id` (`projek_id`);

--
-- Indexes for table `penilaian_portofolio`
--
ALTER TABLE `penilaian_portofolio`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `penilaian_portofolio_ibfk_1` (`mahasiswa_id`),
  ADD KEY `penilaian_portofolio_ibfk_2` (`dosen_id`);

--
-- Indexes for table `projek`
--
ALTER TABLE `projek`
  ADD PRIMARY KEY (`projek_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `komentar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `penilaian_portofolio`
--
ALTER TABLE `penilaian_portofolio`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `projek`
--
ALTER TABLE `projek`
  MODIFY `projek_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `projek_id` FOREIGN KEY (`projek_id`) REFERENCES `projek` (`projek_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penilaian_portofolio`
--
ALTER TABLE `penilaian_portofolio`
  ADD CONSTRAINT `penilaian_portofolio_ibfk_1` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penilaian_portofolio_ibfk_2` FOREIGN KEY (`dosen_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projek`
--
ALTER TABLE `projek`
  ADD CONSTRAINT `fk_projek_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
