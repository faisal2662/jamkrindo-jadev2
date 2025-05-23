-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Sep 2024 pada 10.18
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jamkrindo`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_percakapan`
--

CREATE TABLE `t_percakapan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kd_wilayah` varchar(15) DEFAULT NULL,
  `kd_cabang` varchar(15) DEFAULT NULL,
  `kd_customer` varchar(15) DEFAULT NULL,
  `updated_by` varchar(60) DEFAULT NULL,
  `update_date` int(11) DEFAULT NULL,
  `created_by` varchar(60) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(60) DEFAULT NULL,
  `is_delete` varchar(2) DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `t_percakapan`
--

INSERT INTO `t_percakapan` (`id`, `kd_wilayah`, `kd_cabang`, `kd_customer`, `updated_by`, `update_date`, `created_by`, `created_date`, `updated_date`, `deleted_date`, `deleted_by`, `is_delete`) VALUES
(7, NULL, '73', '2', NULL, NULL, 'Satria', '2024-08-28 23:38:44', '2024-08-28 23:38:44', NULL, NULL, 'N'),
(8, NULL, '1', '1', NULL, NULL, 'Santi', '2024-09-02 21:54:21', '2024-09-02 21:54:21', NULL, NULL, 'N');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_percakapan`
--
ALTER TABLE `t_percakapan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_percakapan`
--
ALTER TABLE `t_percakapan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
