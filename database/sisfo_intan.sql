-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 06, 2025 at 01:05 PM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sisfo_intan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_absensi`
--

CREATE TABLE `tb_absensi` (
  `id` int NOT NULL,
  `id_peserta` tinyint NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `status_masuk` enum('Hadir','Terlambat','Izin','Tanpa Keterangan') COLLATE utf8mb4_general_ci DEFAULT 'Tanpa Keterangan',
  `jam_keluar` time DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_absensi`
--

INSERT INTO `tb_absensi` (`id`, `id_peserta`, `tanggal`, `jam_masuk`, `status_masuk`, `jam_keluar`, `keterangan`) VALUES
(79, 29, '2025-01-06', '10:01:35', 'Terlambat', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_bidang`
--

CREATE TABLE `tb_bidang` (
  `id_bidang` tinyint NOT NULL,
  `nama_bidang` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_bidang`
--

INSERT INTO `tb_bidang` (`id_bidang`, `nama_bidang`, `status`) VALUES
(4, 'SP', 'Aktif'),
(5, 'Kesekretariatan', 'Aktif'),
(6, 'Penyiaran', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tb_laporan`
--

CREATE TABLE `tb_laporan` (
  `id_laporan` tinyint NOT NULL,
  `id_user` tinyint NOT NULL,
  `nama_file` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `file_penilaian` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `penilaian_dosen` text COLLATE utf8mb4_general_ci NOT NULL,
  `Sertifikat` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_laporan`
--

INSERT INTO `tb_laporan` (`id_laporan`, `id_user`, `nama_file`, `file_penilaian`, `penilaian_dosen`, `Sertifikat`, `keterangan`, `status`) VALUES
(19, 13, '211c8162cf09f8c912e17c84a07b1d3a.pdf', '1734405219_penilaian.pdf', '0', '1734405219_sertifikat.pdf', '-', 'disetujui'),
(20, 12, '3fc96fa61baf56fa67b17f7f210183b2.pdf', '1736137867_penilaian.pdf', '1736139342_penilaian.pdf', '1736137867_sertifikat.pdf', '-', 'disetujui');

-- --------------------------------------------------------

--
-- Table structure for table `tb_magang`
--

CREATE TABLE `tb_magang` (
  `id_pm` tinyint NOT NULL,
  `id_user` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `no_tel` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `institute` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ps` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_berakhir` date NOT NULL,
  `bidang` tinyint NOT NULL,
  `cv` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `surat_pengantar` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_magang`
--

INSERT INTO `tb_magang` (`id_pm`, `id_user`, `nama`, `alamat`, `no_tel`, `email`, `institute`, `ps`, `tanggal_mulai`, `tanggal_berakhir`, `bidang`, `cv`, `surat_pengantar`, `foto`, `status`, `keterangan`) VALUES
(29, '13', 'ANAK UNP', 'PADANG', '098', 'hana@pratiwi.com', 'UNIVERSITAS NEGERI PADANG', '-', '2024-12-17', '2025-12-31', 4, '1734405114.pdf', '1734405114.pdf', '1734405114.jpg', 'selesai', '1734405156.pdf'),
(30, '12', 'Intan', 'rambatan', '1234546576', 'intan@gmail.com', 'UNIVERSITAS ISLAM NEGERI MAHMUD YUNUS BATUSANGKAR', 'MANAJEMEN INFORMATIKA', '2025-01-06', '2025-01-30', 5, '1736136046.pdf', '1736136046.pdf', '1736136046.jpg', 'aktif', '1736136071.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `level` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_date` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `sekolah_asal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jurusan` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `level`, `created_date`, `sekolah_asal`, `jurusan`) VALUES
(5, 'admin', '$2y$10$XFtVAjObKRNurftVkLCK/ebDsxd8NoZc.rP8vWmQZmXqEWwQbVP4W', 'admin', '2020-08-15 09:59:43.000000', '0', ''),
(12, 'intan', '$2y$10$RYfe3..7SUGP6nCUPkxn.Ol8HQYmFarRDaCsiXVVLKvrHqK.CD5QW', 'user', '2024-12-02 05:45:04.690214', '0', ''),
(13, 'hana', '$2y$10$XFtVAjObKRNurftVkLCK/ebDsxd8NoZc.rP8vWmQZmXqEWwQbVP4W', 'user', '2024-12-02 06:54:48.520092', '0', ''),
(14, 'Tika', '$2y$10$ftJeA8V.IsVWwGv76lpYdeiwvKb2VOJO5xBqq.RgxhqiG4zNO6j2C', 'user', '2024-12-03 04:22:48.859194', '0', ''),
(15, 'dika', '$2y$10$NA7vZBv9WKfzlWi9NqKKBO2RtVs.0lNVibX7I3gsxgS8nmDVRwtXq', 'user', '2024-12-03 04:31:48.436601', '0', ''),
(16, 'nita', '$2y$10$P6zPMPRZir44yLZn9BrbRuNI3nmQev2gNIuUj06MhHFQER5OFDkAu', 'user', '2024-12-03 14:41:23.305625', '0', ''),
(17, 'dosen', '$2y$10$XFtVAjObKRNurftVkLCK/ebDsxd8NoZc.rP8vWmQZmXqEWwQbVP4W', 'pendamping', '2025-01-06 02:24:14.000000', 'UNIVERSITAS ISLAM NEGERI MAHMUD YUNUS BATUSANGKAR', 'MANAJEMEN INFORMATIKA'),
(18, 'iswandi', '$2y$10$YszxDn28MwZIX8QRSVMsbu8oGW8Q3mcGyb9S7/VluGbbTkJlFBgCK', 'pendamping', '2025-01-06 13:03:30.079083', 'UNIVERSITAS ISLAM NEGERI MAHMUD YUNUS BATUSANGKAR', 'MANAJEMEN INFORMATIKA');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_peserta` (`id_peserta`);

--
-- Indexes for table `tb_bidang`
--
ALTER TABLE `tb_bidang`
  ADD PRIMARY KEY (`id_bidang`);

--
-- Indexes for table `tb_laporan`
--
ALTER TABLE `tb_laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indexes for table `tb_magang`
--
ALTER TABLE `tb_magang`
  ADD PRIMARY KEY (`id_pm`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `tb_bidang`
--
ALTER TABLE `tb_bidang`
  MODIFY `id_bidang` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_laporan`
--
ALTER TABLE `tb_laporan`
  MODIFY `id_laporan` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tb_magang`
--
ALTER TABLE `tb_magang`
  MODIFY `id_pm` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  ADD CONSTRAINT `tb_absensi_ibfk_1` FOREIGN KEY (`id_peserta`) REFERENCES `tb_magang` (`id_pm`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
