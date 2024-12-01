-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Des 2024 pada 18.45
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sikmatu_user`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_data`
--

CREATE TABLE `user_data` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `email` varchar(256) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `jurusan` varchar(128) NOT NULL,
  `angkatan` int(4) NOT NULL,
  `foto` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_data`
--

INSERT INTO `user_data` (`id`, `role`, `email`, `username`, `password`, `nama`, `jurusan`, `angkatan`, `foto`) VALUES
(1, 'mahasiswa', 'defit.saputra@mhs.unsoed.ac.id', 'Defit_Saputra', '$2y$10$CDsDug3ONVkLcN7iRyns9.6woIpGd0NrI3R3B1nsyGquu49o9/2wC', '', '', 0, ''),
(2, 'dosen', 'eddy.maryanto@dos.unsoed.ac.id', 'Eddy_Maryanto', '$2y$10$qiyQexD/luKK0B1.yM5iVu1XvGrtb1JlpiLYzZX.xd3rHziszyXZ6', '', '', 0, ''),
(4, 'dosen', 'alfan.ridlo@mhs.unsoed.ac.id', 'Alfan_Fauzan', '$2y$10$LHMNywRiekuLs9JC4sD.g.kd/VrCPjEQQeY/Yl.XnldbK1/Mp8wlq', '', '', 0, ''),
(5, 'dosen', 'alfan.ridlo@mhs.unsoed.ac.id', 'Alfan_Fauzan', '$2y$10$G8xAUY11mDHl6Jy9crKPtuzyUoQ8blXYfB.Ng2xQjmsBdAtZcOL.m', '', '', 0, ''),
(6, 'dosen', 'alfan.ridlo@mhs.unsoed.ac.id', 'Alfan_Fauzan', '$2y$10$.zHHaNed51cRx71aKg1Iy.KDt/a8AupcgvOADZv0Mn7P/tIs7dXH2', '', '', 0, ''),
(7, 'mahasiswa', 'rizky.amelia@mhs.unsoed.ac.id', 'Rizky_Amelia', '$2y$10$n7Y2KdKr9iPutAIDnUSKLe66TyK1MZuuLQCMVVigMv02X/O3iGLly', '', '', 0, ''),
(8, 'mahasiswa', 'rizky.amelia@mhs.unsoed.ac.id', 'Rizky_Amelia', '$2y$10$JBwAlmBhtnvk3JkJbqxgYOIfHmIEwMm8MqKHi2ZqE0KqCc/EWA5oW', '', '', 0, ''),
(9, 'mahasiswa', 'kevin@mhs.unsoed.ac.id', 'kevin_shesh', '$2y$10$scc/yRuWw0BHxv8QlRn.4eb/0MJYnLFjB9ORy9n7.MEoBXVKYlsgq', '', '', 0, ''),
(10, 'mahasiswa', 'yuji.itadori@mhs.unsoed.ac.id', 'itadori_yuji', '$2y$10$23rbbxzjQ8a8K0FjDegf1OxrYQrLjwrxVSSWo9lKu6fEg5gOu0eyu', '', '', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
