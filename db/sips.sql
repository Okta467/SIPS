-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2024 at 06:14 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sips`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_disposisi_surat_masuk`
--

CREATE TABLE `tbl_disposisi_surat_masuk` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_surat_masuk` int(10) UNSIGNED NOT NULL,
  `instruksi` varchar(1000) NOT NULL,
  `tgl_penyelesaian` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jabatan`
--

CREATE TABLE `tbl_jabatan` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_jabatan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jabatan`
--

INSERT INTO `tbl_jabatan` (`id`, `nama_jabatan`, `created_at`, `updated_at`) VALUES
(1, 'Kepala Sekolah', '2024-05-20 12:45:34', NULL),
(2, 'Wakil Kepala Sekolah', '2024-05-20 12:45:34', NULL),
(3, 'Bendahara', '2024-05-20 12:45:34', NULL),
(4, 'Tata Usaha/Administrasi', '2024-05-20 12:45:34', NULL),
(5, 'Wali Kelas', '2024-05-20 12:45:34', NULL),
(6, 'Piket', '2024-05-20 12:45:34', NULL),
(7, 'Bimbingan Konseling', '2024-05-20 12:45:34', NULL),
(8, 'Penjaga Sekolah', '2024-05-20 12:45:34', NULL),
(9, 'Kebersihan', '2024-05-20 12:45:34', '2024-05-20 12:53:45'),
(10, 'Tenaga Administrasi Sekolah', '2024-05-20 12:45:34', NULL),
(11, 'Perpustakaan', '2024-05-20 12:45:34', NULL),
(12, 'Operator', '2024-05-20 12:45:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jurusan_pendidikan`
--

CREATE TABLE `tbl_jurusan_pendidikan` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_pendidikan` int(10) UNSIGNED DEFAULT NULL,
  `nama_jurusan` varchar(128) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jurusan_pendidikan`
--

INSERT INTO `tbl_jurusan_pendidikan` (`id`, `id_pendidikan`, `nama_jurusan`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Tidak Ada', '2024-05-11 19:22:50', NULL),
(2, 4, 'IPA', '2024-05-11 19:22:50', '2024-05-13 14:09:23'),
(3, 4, 'IPS', '2024-05-11 19:22:50', '2024-05-13 14:09:34'),
(4, 9, 'Sistem Informasi', '2024-05-11 19:22:50', '2024-05-13 14:09:58'),
(5, 9, 'Psikologi', '2024-05-11 19:22:50', '2024-05-13 14:10:04'),
(8, 4, 'Lainnya', '2024-05-13 14:13:00', NULL),
(9, 5, 'Lainnya', '2024-05-13 14:13:01', NULL),
(10, 6, 'Lainnya', '2024-05-13 14:13:01', NULL),
(11, 7, 'Lainnya', '2024-05-13 14:13:01', NULL),
(12, 8, 'Lainnya', '2024-05-13 14:13:01', NULL),
(13, 9, 'Lainnya', '2024-05-13 14:13:01', NULL),
(14, 10, 'Lainnya', '2024-05-13 14:13:01', NULL),
(15, 11, 'Lainnya', '2024-05-13 14:13:01', NULL),
(16, 9, 'Teknik Elektro', '2024-05-13 16:37:09', NULL),
(28, 8, 'Some \\&quot;\'  string &amp;amp; to Sanitize &amp;lt; !$@%', '2024-05-13 18:05:45', '2024-05-13 18:12:16'),
(29, 9, 'Pendidikan Agama Islam', '2024-05-17 05:11:41', NULL),
(30, 9, 'Hukum', '2024-05-19 18:35:55', NULL),
(32, 9, 'Psikologi', '2024-05-23 04:32:24', NULL),
(33, 9, 'Bahasa Indonesia', '2024-05-23 10:55:19', NULL),
(34, 9, 'Fisika', '2024-05-23 16:27:45', NULL),
(35, 9, 'Matematika', '2024-05-25 17:35:34', NULL),
(36, 9, 'Geografi', '2024-05-26 09:59:36', NULL),
(37, 10, 'Sistem Informasi', '2024-06-10 15:56:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kode_surat`
--

CREATE TABLE `tbl_kode_surat` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_kode` varchar(255) NOT NULL,
  `keterangan` varchar(1000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pangkat_golongan`
--

CREATE TABLE `tbl_pangkat_golongan` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_pangkat_golongan` varchar(128) NOT NULL,
  `tipe` enum('pns','pppk','gtt','honor') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_pangkat_golongan`
--

INSERT INTO `tbl_pangkat_golongan` (`id`, `nama_pangkat_golongan`, `tipe`, `created_at`, `updated_at`) VALUES
(1, 'Golongan Ia (Juru Muda)', 'pns', '2024-05-15 17:21:54', NULL),
(2, 'Golongan Ib (Juru Muda Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(3, 'Golongan Ic (Juru)', 'pns', '2024-05-15 17:21:54', NULL),
(4, 'Golongan Id (Juru Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(5, 'Golongan IIa (Pengatur muda)', 'pns', '2024-05-15 17:21:54', NULL),
(6, 'Golongan IIb (Pengatur Muda Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(7, 'Golongan IIc (Pengatur)', 'pns', '2024-05-15 17:21:54', NULL),
(8, 'Golongan IId (Pengatur tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(9, 'Golongan IIIa (Penata Muda)', 'pns', '2024-05-15 17:21:54', NULL),
(10, 'Golongan IIIb (Penata Muda Tingkat 1)', 'pns', '2024-05-15 17:21:54', NULL),
(11, 'Golongan IIIc (Penata)', 'pns', '2024-05-15 17:21:54', NULL),
(12, 'Golongan IIId (Penata Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(13, 'Golongan IVa (Pembina)', 'pns', '2024-05-15 17:21:54', NULL),
(14, 'Golongan IVb (Pembina Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(15, 'Golongan IVc (Pembina Muda)', 'pns', '2024-05-15 17:21:54', NULL),
(16, 'Golongan IVd (Pembina Madya)', 'pns', '2024-05-15 17:21:54', NULL),
(17, 'Golongan IVe (Pembina Utama)', 'pns', '2024-05-15 17:21:54', NULL),
(18, 'Tidak ada', NULL, '2024-05-15 18:23:14', '2024-05-20 11:50:30'),
(19, 'PPPK', 'pppk', '2024-05-20 11:36:07', NULL),
(20, 'GTT', 'gtt', '2024-05-20 11:36:07', NULL),
(21, 'Honor', 'honor', '2024-05-20 11:49:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pegawai`
--

CREATE TABLE `tbl_pegawai` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_jabatan` int(10) UNSIGNED DEFAULT NULL,
  `id_pangkat_golongan` int(10) UNSIGNED DEFAULT NULL,
  `id_pendidikan` int(10) UNSIGNED DEFAULT NULL,
  `id_jurusan_pendidikan` int(10) UNSIGNED DEFAULT NULL,
  `nik` varchar(16) NOT NULL,
  `nama_pegawai` varchar(128) NOT NULL,
  `jk` enum('l','p') NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tmp_lahir` varchar(64) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `tmt` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pendidikan`
--

CREATE TABLE `tbl_pendidikan` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_pendidikan` varchar(16) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_pendidikan`
--

INSERT INTO `tbl_pendidikan` (`id`, `nama_pendidikan`, `created_at`, `updated_at`) VALUES
(1, 'tidak_sekolah', '2024-05-11 19:21:02', '2024-05-13 16:25:34'),
(2, 'SD', '2024-05-11 19:21:03', NULL),
(3, 'SMP', '2024-05-11 19:21:03', NULL),
(4, 'SLTA', '2024-05-11 19:21:03', NULL),
(5, 'DI', '2024-05-11 19:21:03', NULL),
(6, 'DII', '2024-05-11 19:21:03', NULL),
(7, 'DIII', '2024-05-11 19:21:03', NULL),
(8, 'DIV', '2024-05-11 19:21:03', NULL),
(9, 'S1', '2024-05-11 19:21:03', NULL),
(10, 'S2', '2024-05-11 19:21:03', NULL),
(11, 'S3', '2024-05-11 19:21:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `hak_akses` enum('admin','masyarakat','kepala_desa') NOT NULL,
  `status_aktif` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 = aktif, 0 = tidak aktif',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pengguna`
--

INSERT INTO `tbl_pengguna` (`id`, `username`, `password`, `hak_akses`, `status_aktif`, `created_at`, `last_login`) VALUES
(9, 'admin', '$2y$10$r6i9ouw57cTTevcboVpfxuaaeGE.LqvH0ivtFunGnpjhus3jtxu1q', 'admin', 1, '2024-06-10 14:42:24', '2024-07-11 06:41:18'),
(25, '196506121990022003', '$2y$10$r6i9ouw57cTTevcboVpfxuaaeGE.LqvH0ivtFunGnpjhus3jtxu1q', 'kepala_desa', 1, '2024-06-24 18:29:06', '2024-07-11 06:41:24'),
(35, '1989986520190220', '$2y$10$LrNrbSt9hTDGlwWP8vEpj.axs3qGn0aWFd4UYcjL.w5q79LY3Ouiy', 'kepala_desa', 1, '2024-06-27 14:46:25', '2024-07-11 06:41:06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_surat_keluar`
--

CREATE TABLE `tbl_surat_keluar` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_kode_surat` int(10) UNSIGNED NOT NULL,
  `pengirim_surat` int(10) UNSIGNED DEFAULT NULL,
  `penerima_surat` int(10) UNSIGNED DEFAULT NULL,
  `no_surat` varchar(128) NOT NULL,
  `tgl_surat` date NOT NULL,
  `perihal_indeks` varchar(255) NOT NULL,
  `isi_surat` varchar(5000) NOT NULL,
  `jml_lampiran` int(10) UNSIGNED NOT NULL,
  `jml_lembar` int(10) UNSIGNED NOT NULL,
  `catatan` varchar(1000) NOT NULL,
  `file_sk` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_surat_masuk`
--

CREATE TABLE `tbl_surat_masuk` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_kode_surat` int(10) UNSIGNED NOT NULL,
  `pengirim_surat` int(10) UNSIGNED DEFAULT NULL,
  `no_surat` varchar(128) NOT NULL,
  `tgl_surat` date NOT NULL,
  `perihal_indeks` varchar(255) NOT NULL,
  `isi_surat` varchar(5000) NOT NULL,
  `jml_lampiran` int(10) UNSIGNED NOT NULL,
  `file_sm` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tujuan_disposisi_surat_masuk`
--

CREATE TABLE `tbl_tujuan_disposisi_surat_masuk` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_disposisi_surat_masuk` int(10) UNSIGNED NOT NULL,
  `id_jabatan` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_disposisi_surat_masuk`
--
ALTER TABLE `tbl_disposisi_surat_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_surat_masuk` (`id_surat_masuk`);

--
-- Indexes for table `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_jurusan_pendidikan`
--
ALTER TABLE `tbl_jurusan_pendidikan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pendidikan` (`id_pendidikan`);

--
-- Indexes for table `tbl_kode_surat`
--
ALTER TABLE `tbl_kode_surat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pangkat_golongan`
--
ALTER TABLE `tbl_pangkat_golongan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pegawai`
--
ALTER TABLE `tbl_pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD KEY `id_jabatan` (`id_jabatan`),
  ADD KEY `id_jurusan_pendidikan` (`id_jurusan_pendidikan`),
  ADD KEY `id_pangkat_golongan` (`id_pangkat_golongan`),
  ADD KEY `id_pendidikan` (`id_pendidikan`);

--
-- Indexes for table `tbl_pendidikan`
--
ALTER TABLE `tbl_pendidikan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tbl_surat_keluar`
--
ALTER TABLE `tbl_surat_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_surat_masuk`
--
ALTER TABLE `tbl_surat_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tujuan_disposisi_surat_masuk`
--
ALTER TABLE `tbl_tujuan_disposisi_surat_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_disposisi_surat_masuk` (`id_disposisi_surat_masuk`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_disposisi_surat_masuk`
--
ALTER TABLE `tbl_disposisi_surat_masuk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_jurusan_pendidikan`
--
ALTER TABLE `tbl_jurusan_pendidikan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_kode_surat`
--
ALTER TABLE `tbl_kode_surat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pangkat_golongan`
--
ALTER TABLE `tbl_pangkat_golongan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_pegawai`
--
ALTER TABLE `tbl_pegawai`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pendidikan`
--
ALTER TABLE `tbl_pendidikan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tbl_surat_keluar`
--
ALTER TABLE `tbl_surat_keluar`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_surat_masuk`
--
ALTER TABLE `tbl_surat_masuk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_tujuan_disposisi_surat_masuk`
--
ALTER TABLE `tbl_tujuan_disposisi_surat_masuk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_disposisi_surat_masuk`
--
ALTER TABLE `tbl_disposisi_surat_masuk`
  ADD CONSTRAINT `tbl_disposisi_surat_masuk_ibfk_1` FOREIGN KEY (`id_surat_masuk`) REFERENCES `tbl_surat_masuk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_jurusan_pendidikan`
--
ALTER TABLE `tbl_jurusan_pendidikan`
  ADD CONSTRAINT `tbl_jurusan_pendidikan_ibfk_1` FOREIGN KEY (`id_pendidikan`) REFERENCES `tbl_pendidikan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_pegawai`
--
ALTER TABLE `tbl_pegawai`
  ADD CONSTRAINT `tbl_pegawai_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `tbl_jabatan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_tujuan_disposisi_surat_masuk`
--
ALTER TABLE `tbl_tujuan_disposisi_surat_masuk`
  ADD CONSTRAINT `tbl_tujuan_disposisi_surat_masuk_ibfk_1` FOREIGN KEY (`id_disposisi_surat_masuk`) REFERENCES `tbl_disposisi_surat_masuk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_tujuan_disposisi_surat_masuk_ibfk_2` FOREIGN KEY (`id_jabatan`) REFERENCES `tbl_jabatan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
