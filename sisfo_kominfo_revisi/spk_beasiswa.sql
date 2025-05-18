-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Jul 2024 pada 16.22
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 8.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_beasiswa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `atribut`
--

CREATE TABLE `atribut` (
  `id_atribut` int(11) NOT NULL,
  `nama_kriteria` varchar(100) NOT NULL,
  `tipe_atribut` enum('cost','benefit') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `atribut`
--

INSERT INTO `atribut` (`id_atribut`, `nama_kriteria`, `tipe_atribut`) VALUES
(4, 'Penghasilan Orang Tua', 'cost'),
(5, 'IPK', 'benefit'),
(6, 'Prestasi', 'benefit'),
(8, 'Surat keterangan Tidak Mampu', 'benefit'),
(9, 'Tanggungan Orang Tua', 'cost');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bobot`
--

CREATE TABLE `bobot` (
  `id_bobot` int(11) NOT NULL,
  `tingkat_kepentingan` varchar(100) NOT NULL,
  `nilai_bobot` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `bobot`
--

INSERT INTO `bobot` (`id_bobot`, `tingkat_kepentingan`, `nilai_bobot`) VALUES
(4, 'Rendah', 2),
(5, 'Cukup', 3),
(6, 'Tinggi', 4),
(7, 'Sangat Tinggi', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil`
--

CREATE TABLE `hasil` (
  `id_hasil` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `nis` int(50) NOT NULL,
  `nilai` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `hasil`
--

INSERT INTO `hasil` (`id_hasil`, `tanggal`, `nis`, `nilai`) VALUES
(1, '2024-07-27 00:00:00', 2016141484, '19'),
(2, '2024-07-27 00:00:00', 2147483647, '20.25'),
(3, '2024-07-27 00:00:00', 2016141281, '19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `klasifikasi`
--

CREATE TABLE `klasifikasi` (
  `id_klasifikasi` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `c1` int(10) NOT NULL,
  `c2` int(10) NOT NULL,
  `c3` int(10) NOT NULL,
  `c4` int(10) NOT NULL,
  `c5` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `klasifikasi`
--

INSERT INTO `klasifikasi` (`id_klasifikasi`, `nis`, `c1`, `c2`, `c3`, `c4`, `c5`) VALUES
(16, '2016141484', 8, 12, 27, 26, 23),
(18, '2016141281', 6, 11, 28, 26, 23),
(19, '21504007', 6, 12, 27, 29, 24),
(20, '2016141481', 6, 11, 28, 26, 23);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `id_atribut` int(11) NOT NULL,
  `range_nilai` varchar(100) NOT NULL,
  `id_bobot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `id_atribut`, `range_nilai`, `id_bobot`) VALUES
(2, 3, '70-80', 5),
(3, 3, '81-90', 6),
(4, 3, '91-100', 7),
(5, 4, 'Rp. 500.000,00 - < Rp.1.000.000,00', 3),
(6, 4, 'Rp. 1.000.000,00 - < Rp. 2.000.000,00', 4),
(8, 4, 'Rp. 3.000.000,00 - < Rp. 4.000.000,00', 6),
(9, 4, 'Rp. 4.000.000,00 -< Rp. 5.000.000,00', 7),
(10, 5, '70-80 (poin)', 5),
(11, 5, '81-90 (poin)', 6),
(12, 5, '91-100 (poin)', 7),
(16, 7, '0-40 (poin)', 3),
(17, 7, '41-59 (poin)', 4),
(18, 7, '60-75 (poin)', 5),
(19, 7, '76-85 (poin)', 6),
(20, 7, '86-100 (poin)', 7),
(21, 3, '50-60', 4),
(22, 9, '1', 5),
(23, 9, '2', 6),
(24, 9, '3', 7),
(26, 8, 'Tidak ada', 5),
(27, 6, 'Tidak Ada', 4),
(28, 6, 'Ada', 7),
(29, 8, 'Ada', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nis` int(50) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`nis`, `nama_lengkap`, `tanggal_lahir`, `jenis_kelamin`, `alamat`) VALUES
(21504007, 'sahih alfatih', '2003-10-07', 'L', 'jalan mawar'),
(2016141281, 'adi putra', '1998-07-06', 'P', 'kemang'),
(2016141481, 'yunia diviyanti', '1998-06-17', 'P', 'jasinga'),
(2016141484, 'nadia punjabi', '1970-01-01', 'P', 'komplek inkopad');

-- --------------------------------------------------------

--
-- Struktur dari tabel `normalisasi`
--

CREATE TABLE `normalisasi` (
  `id_normalisasi` int(11) NOT NULL,
  `nis` varchar(100) NOT NULL,
  `c1` varchar(10) NOT NULL,
  `c2` varchar(10) NOT NULL,
  `c3` varchar(10) NOT NULL,
  `c4` varchar(10) NOT NULL,
  `c5` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `normalisasi`
--

INSERT INTO `normalisasi` (`id_normalisasi`, `nis`, `c1`, `c2`, `c3`, `c4`, `c5`) VALUES
(1, '2016141484', '0.8', '1', '0.4', '1', '1'),
(2, '2147483647', '1', '0.6', '1', '1', '0.75'),
(3, '2016141281', '0.4', '0.8', '1', '1', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(20) DEFAULT NULL,
  `created_date` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `level`, `created_date`) VALUES
(5, 'admin', '80177534a0c99a7e3645b52f2027a48b', 'admin', '2020-08-15 09:59:43.000000');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `atribut`
--
ALTER TABLE `atribut`
  ADD PRIMARY KEY (`id_atribut`);

--
-- Indeks untuk tabel `bobot`
--
ALTER TABLE `bobot`
  ADD PRIMARY KEY (`id_bobot`);

--
-- Indeks untuk tabel `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id_hasil`);

--
-- Indeks untuk tabel `klasifikasi`
--
ALTER TABLE `klasifikasi`
  ADD PRIMARY KEY (`id_klasifikasi`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`),
  ADD KEY `id_atribut` (`id_atribut`),
  ADD KEY `id_bobot` (`id_bobot`),
  ADD KEY `id_bobot_2` (`id_bobot`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nis`);

--
-- Indeks untuk tabel `normalisasi`
--
ALTER TABLE `normalisasi`
  ADD PRIMARY KEY (`id_normalisasi`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `atribut`
--
ALTER TABLE `atribut`
  MODIFY `id_atribut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `bobot`
--
ALTER TABLE `bobot`
  MODIFY `id_bobot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `klasifikasi`
--
ALTER TABLE `klasifikasi`
  MODIFY `id_klasifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `normalisasi`
--
ALTER TABLE `normalisasi`
  MODIFY `id_normalisasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
