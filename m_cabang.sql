-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 05 Sep 2024 pada 11.56
-- Versi server: 10.6.19-MariaDB
-- Versi PHP: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agrobizp_jade_jamkrindo`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_cabang`
--

CREATE TABLE `m_cabang` (
  `id_cabang` int(11) NOT NULL,
  `kd_cabang` varchar(5) DEFAULT NULL,
  `kd_wilayah` int(11) DEFAULT NULL,
  `kode_uker` varchar(20) DEFAULT NULL,
  `kelas_uker` varchar(5) DEFAULT NULL,
  `nm_cabang` varchar(80) DEFAULT NULL,
  `desc_cabang` text DEFAULT NULL,
  `latitude_cabang` varchar(20) DEFAULT NULL,
  `longitude_cabang` varchar(25) DEFAULT NULL,
  `url_location` text DEFAULT NULL,
  `kd_provinsi` int(11) DEFAULT NULL,
  `kd_kota` int(11) DEFAULT NULL,
  `alamat_cabang` text DEFAULT NULL,
  `telp_cabang` varchar(15) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `created_by` varchar(60) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(60) DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(60) DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `is_delete` varchar(2) DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `m_cabang`
--

INSERT INTO `m_cabang` (`id_cabang`, `kd_cabang`, `kd_wilayah`, `kode_uker`, `kelas_uker`, `nm_cabang`, `desc_cabang`, `latitude_cabang`, `longitude_cabang`, `url_location`, `kd_provinsi`, `kd_kota`, `alamat_cabang`, `telp_cabang`, `fax`, `email`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `is_delete`) VALUES
(4, NULL, 23, NULL, NULL, 'Kanca Ambon', NULL, '-3.696812586', '128.181106', NULL, 81, 461, 'No 16 Ruko 1, 97126, Jl. Philip Latumahina, Kel Honipopu, Kec. Sirimau, Kota Ambon, Maluku', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:34:13', '', '0000-00-00 00:00:00', 'N'),
(5, NULL, 16, NULL, NULL, 'Kanca Balige', NULL, '2.334079993', '99.06817604', NULL, 12, 29, 'Jl. Sisingamangaraja No. 87 Kec. Balige, Kab. Toba, Sumatera Utara 22312', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:43:31', '', '0000-00-00 00:00:00', 'N'),
(6, NULL, 22, NULL, NULL, 'Kanca Balikpapan', NULL, '-1.125025188', '116.8542888', NULL, 64, 363, 'Jl. Jenderal Sudirman No.10, Damai, Kecamatan Balikpapan Selatan, Kota Balikpapan, Kalimantan Timur 76114', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:13:33', '', '0000-00-00 00:00:00', 'N'),
(7, '', 15, NULL, NULL, 'Kanca Banda Aceh', '', '', '', '', 31, 156, NULL, NULL, NULL, '', 'Admin', '0000-00-00 00:00:00', '', '2024-08-29 21:17:00', 'Admin Testing', '2024-08-29 21:17:00', 'Y'),
(8, NULL, 17, NULL, NULL, 'Kanca Bandar Lampung', NULL, '-5.422936282', '105.2685332', NULL, 18, 139, 'Jl. Jend Sudirman No.128 RT.001 RW 001, Rw. Laut, Kec. Tanjungkarang Timur, Kota Bandar Lampung, Lampung 35128', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:22:06', '', '0000-00-00 00:00:00', 'N'),
(9, NULL, 18, NULL, NULL, 'Kanca Bandung', NULL, '-6.937872335', '107.6768601', NULL, 32, 164, 'Jl. Soekarno Hatta No 774 RT 06 RW 07 Cisaranten Endah Kec. Arcamanik, Kota Bandung 40293', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:23:43', '', '0000-00-00 00:00:00', 'N'),
(10, '', 15, NULL, NULL, 'Kanca Bandung', '', '', '', '', 31, 156, NULL, NULL, NULL, '', 'Admin', '0000-00-00 00:00:00', '', '2024-08-29 02:07:37', 'Admin Testing', '2024-08-29 02:07:37', 'Y'),
(11, NULL, 20, NULL, NULL, 'Kanca Banyuwangi', NULL, '-8.234630882', '114.3570386', NULL, 35, 237, 'Jl. Brawijaya No.8, Kebalenan, Kec. Banyuwangi, Kabupaten Banyuwangi, Kota Banyuwangi, Jawa Timur 68417', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:18:57', '', '0000-00-00 00:00:00', 'N'),
(12, NULL, 16, NULL, NULL, 'Kanca Batam', NULL, '1.128749026', '104.0368337', NULL, 21, 153, 'Komp Ruko Mahkota Raya Blok G No.9  Jl. Raja Ali Haji Fisabilillah, Tlk. Tering, Kec. Batam Kota, Kota Batam, Kepulauan Riau 29444', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:31:52', '', '0000-00-00 00:00:00', 'N'),
(13, NULL, 17, NULL, NULL, 'Kanca Bengkulu', NULL, '-3.79181704', '102.254934', NULL, 17, 125, 'Jl. Ahmad Yani Rt. 004/ Rw 001 No.28 Kelurahan Jitra, Kecamatan Teluk Segara, Kota Bengkulu-38119', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:24:05', '', '0000-00-00 00:00:00', 'N'),
(14, '', 15, NULL, NULL, 'Kanca Bitung', '', '', '', '', 31, 156, NULL, NULL, NULL, '', 'Admin', '0000-00-00 00:00:00', '', '2024-08-29 21:17:12', 'Admin Testing', '2024-08-29 21:17:12', 'Y'),
(15, '', 5, NULL, NULL, 'Cabang Petang ', NULL, NULL, NULL, NULL, 31, 156, NULL, NULL, NULL, '', 'Admin', '0000-00-00 00:00:00', 'Admin', '2024-08-07 20:15:36', '', '0000-00-00 00:00:00', 'N'),
(16, NULL, 18, NULL, NULL, 'Kanca Cirebon', NULL, '-6.719569641', '108.5503049', NULL, 32, 169, '\"Komplek Cirebon Super Block (CSB)\r\nJl. Dr. Cipto Mangunkusumo No. 26 Office Park Kav. No.15 Kel. Pekiringan Kec. Kesambi Kota Cirebon 45131\"', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:25:42', '', '0000-00-00 00:00:00', 'N'),
(17, NULL, 21, NULL, NULL, 'Kanca Denpasar', NULL, '-8.674434981', '115.2603897', NULL, 51, 282, 'Jl. Hang Tuah No.76, Sanur Kaja, Denpasar Selatan, Kota Denpasar, Bali 80228', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:21:34', '', '0000-00-00 00:00:00', 'N'),
(18, NULL, 23, NULL, NULL, 'Kanca Gorontalo', NULL, '0.786277576', '123.0346394', NULL, 75, 445, 'Jl. HB Jassin, Kel. Dulalowo, Kec. Kota Tengah, Kota Gorontalo', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:37:22', '', '0000-00-00 00:00:00', 'N'),
(19, NULL, 15, NULL, NULL, 'Kanca Jakarta', NULL, '-6.15552985', '106.8454434', NULL, 31, 158, 'Gedung Jamkrindo\r\nJl. Angkasa Blok B-9 Kav. 6 Kota Baru - Bandar Kemayoran, Jakarta Pusat - 10610', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:47:30', '', '0000-00-00 00:00:00', 'N'),
(20, NULL, 17, NULL, NULL, 'Kanca Jambi', NULL, '-1.603242865', '103.6029038', NULL, 15, 97, 'Jl. Soemantri Brojonegoro No. 23 RT 11 Kelurahan Payo Lebar Kecamatan Jelutung, Kota Jambi, Jambi 36124', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:23:09', '', '0000-00-00 00:00:00', 'N'),
(21, NULL, 23, NULL, NULL, 'Kanca Jayapura', NULL, '-2.565049183', '140.6973979', NULL, 94, 514, 'Jl. Raya Abepura, Entrop, Distrik Jayapura Selatan, Kota Jayapura, Papua 99224', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:26:59', '', '0000-00-00 00:00:00', 'N'),
(22, NULL, 20, NULL, NULL, 'Kanca Kediri', NULL, '-7.827189341', '112.0176928', NULL, 35, 257, 'Jl. Kilisuci No.85, Setono Pande, Kec. Kota, Kota Kediri, Jawa Timur 64129', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:14:00', '', '0000-00-00 00:00:00', 'N'),
(23, NULL, 23, NULL, NULL, 'Kanca Kendari', NULL, '-3.98267684', '122.5215241', NULL, 74, 438, 'Jl. Brigjend M. Yunus, Bende, Kec. Kadia, Kota Kendari, Sulawesi Tenggara 93461', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:28:39', '', '0000-00-00 00:00:00', 'N'),
(24, NULL, 19, NULL, NULL, 'Kanca Kudus', NULL, '-6.804932789', '110.8495356', NULL, 33, 206, 'Jl. Jend. Sudirman Ruko Sudirman Square No. 12-14, Nganguk, Kec. Kota Kudus, Kabupaten Kudus, Jawa Tengah 59312', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:42:27', '', '0000-00-00 00:00:00', 'N'),
(25, NULL, 21, NULL, NULL, 'Kanca Kupang', NULL, '-10.18566461', '123.6050588', NULL, 53, 314, 'Jl. Jenderal Soeharto No.110 Blok.A, RT 20, RW 008, Kel Naikolan, Kec Maulafa, Kota Kupang-NTT 85111', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:22:42', '', '0000-00-00 00:00:00', 'N'),
(26, NULL, 20, NULL, NULL, 'Kanca Madiun', NULL, '-7.626790582', '111.5325449', NULL, 35, 263, 'Jl. Thamrin No.38, Klegen, Kec. Kartoharjo, Kota Madiun, Jawa Timur 63117', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:15:48', '', '0000-00-00 00:00:00', 'N'),
(27, NULL, 23, NULL, NULL, 'Kanca Makassar', NULL, '-5.160966456', '119.4170679', NULL, 73, 420, 'Jl. DR. Ratulangi No.140, Mario, Kec. Mariso, Kota Makassar, Sulawesi Selatan 90125', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:15:08', '', '0000-00-00 00:00:00', 'N'),
(28, NULL, 20, NULL, NULL, 'Kanca Malang', NULL, '-7.972854365', '112.6237562', NULL, 35, 259, 'Jl. Semeru No.66, Oro-oro Dowo, Kec. Klojen, Kota Malang, Jawa Timur 65115', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:16:57', '', '0000-00-00 00:00:00', 'N'),
(29, NULL, 23, NULL, NULL, 'Kanca Mamuju', NULL, '-2.679137143', '118.8786208', NULL, 76, 449, 'Jl. Urip Sumoharjo No.55, Karema, Kec. Mamuju, Kabupaten Mamuju, Sulawesi Barat 91512', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:30:19', '', '0000-00-00 00:00:00', 'N'),
(30, NULL, 23, NULL, NULL, 'Kanca Manado', NULL, '1.478173024', '124.8342861', NULL, 71, 382, 'Megamas, Jl. Titiwungan Selatan No.22, Titiwungan Utara, Kec. Sario, Kota Manado, Sulawesi Utara', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:17:45', '', '0000-00-00 00:00:00', 'N'),
(31, NULL, 23, NULL, NULL, 'Kanca Manokwari', NULL, '-0.863699564', '134.0534978', NULL, 91, 477, 'Jl. Trikora Wosi, Wosi, Kec. Manokwari Bar., Kabupaten Manokwari, Papua Bar. 98312', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:36:19', '', '0000-00-00 00:00:00', 'N'),
(32, NULL, 21, NULL, NULL, 'Kanca Mataram', NULL, '-8.524434607', '116.0807594', NULL, 52, 291, 'Jl. Sriwijaya, Pagesangan Tim., Kec. Mataram, Kota Mataram, Nusa Tenggara Barat. 83115', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:23:59', '', '0000-00-00 00:00:00', 'N'),
(33, NULL, 16, NULL, NULL, 'Kanca Medan', '<p>Kanca Medan - Kanwil Medan</p>', '3.577315455', '98.64986515', NULL, 12, 53, 'Jl. Sei Serayu No.40, Babura Sunggal, Kec. Medan Sunggal, Kota Medan, Sumatera Utara 20154', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:09:07', '', '0000-00-00 00:00:00', 'N'),
(34, NULL, 16, NULL, NULL, 'Kanca Padang', NULL, '-0.919423005', '100.3608789', NULL, 13, 69, 'Jl. Khatib Sulaiman No. 47 C, Ulak Karang Utara, Kec. Padang Utara, Kota Padang, Sumatera Barat 25173', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:17:23', '', '0000-00-00 00:00:00', 'N'),
(35, NULL, 22, NULL, NULL, 'Kanca Palangkaraya', NULL, '-2.207625572', '113.9135125', NULL, 62, 342, 'Jl. Christopel Mihing No.31, Langkai, Kec. Pahandut, Kota Palangka Raya, Kalimantan Tengah 74874', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:28:50', '', '0000-00-00 00:00:00', 'N'),
(36, NULL, 17, NULL, NULL, 'Kanca Palembang', NULL, '-2.952370725', '104.7864484', NULL, 16, 112, 'Jl. Residen Abdul Rozak No.9A, Kalidoni, Kec. Ilir Tim. II, Kota Palembang, Sumatera Selatan 30163', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:21:34', '', '0000-00-00 00:00:00', 'N'),
(37, NULL, 23, NULL, NULL, 'Kanca Palopo', NULL, '-2.989592132', '120.1865218', NULL, 73, 422, 'Jl. Dr. Sam Ratulangi No. 90 Kec. Wara Utara, Kota Palopo. Provinsi Sulawesi Selatan - 91911', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:39:54', '', '0000-00-00 00:00:00', 'N'),
(38, NULL, 23, NULL, NULL, 'Kanca Palu', NULL, '-0.922993105', '119.894419', NULL, 72, 398, 'Jl. Dewi Sartika No.58, Birobuli Sel., Kec. Palu Sel., Kota Palu, Sulawesi Tengah 94111', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:23:11', '', '0000-00-00 00:00:00', 'N'),
(39, NULL, 17, NULL, NULL, 'Kanca Pangkal Pinang', NULL, '-2.11749084', '106.1099999', NULL, 19, 147, 'Jl. A. Yani No.11 H, Batin Tikal, Kec. Taman Sari, Kota Pangkal Pinang, Kepulauan Bangka Belitung 33684', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:25:00', '', '0000-00-00 00:00:00', 'N'),
(40, NULL, 23, NULL, NULL, 'Kanca Pare-Pare', NULL, '-4.007576896', '119.6262347', NULL, 73, 421, 'Jl. Andi Mappatola No 30 C,  Kelurahan Ujung Sabbang, Kecamatan Ujung, Kota Parepare, Provinsi Sulawesi Selatan', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:38:28', '', '0000-00-00 00:00:00', 'N'),
(41, '', 15, NULL, NULL, 'Kanca Pekalongan', '', '', '', '', 31, 156, NULL, NULL, NULL, '', 'Admin', '0000-00-00 00:00:00', '', '2024-08-29 21:17:26', 'Admin Testing', '2024-08-29 21:17:26', 'Y'),
(42, NULL, 16, NULL, NULL, 'Kanca Pekanbaru', NULL, '0.504164134', '101.4524378', NULL, 14, 86, 'Jl. Jend. Sudirman No.150, Sukaramai, Kec. Pekanbaru Kota, Kota Pekanbaru, Riau 28155', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:14:06', '', '0000-00-00 00:00:00', 'N'),
(43, NULL, 15, NULL, NULL, 'Kanca Pontianak', NULL, '-0.047376652', '109.3330225', NULL, 61, 327, 'Jl. Moch. Sohor No 4. RT/RW 004/007, Kel. Akcaya, Pontianak Selatan, Kalimantan Barat 78121', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:28:08', '', '0000-00-00 00:00:00', 'N'),
(44, NULL, 18, NULL, NULL, 'Kanca Purwakarta', NULL, '-6.540660169', '107.4408346', NULL, 32, 174, 'Jl. Ibrahim Singadilaga No. 6, RT. 01/RW. 01, Purwamekar, Kec. Purwakarta, Kabupaten Purwakarta, Jawa Barat 41119', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:27:08', '', '0000-00-00 00:00:00', 'N'),
(45, NULL, 19, NULL, NULL, 'Kanca Purwokerto', NULL, '-7.426236869', '109.2337465', NULL, 33, 189, 'Jl. Jend. Sudirman No.196b, Kranjimuntang, Sokanegara, Kec. Purwokerto Tim., Kabupaten Banyumas, Jawa Tengah 53115', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:37:13', '', '0000-00-00 00:00:00', 'N'),
(46, NULL, 22, NULL, NULL, 'Kanca Samarinda', NULL, '-0.33779344', '117.148491', NULL, 64, 364, 'Jl. Ahmar Yani No.37A, Sungai Pinang Dalam, Kec. Sungai Pinang, Kota Samarinda, Kalimantan Timur 75242', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:26:20', '', '0000-00-00 00:00:00', 'N'),
(47, NULL, 19, NULL, NULL, 'Kanca Semarang', NULL, '-6.987952576', '110.3921954', NULL, 33, 220, 'Jl. Pamularsih Raya No. 68A, Bongsari, Kec. Semarang Barat, Kota Semarang, Jawa Tengah 50148', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:31:15', '', '0000-00-00 00:00:00', 'N'),
(48, NULL, 15, NULL, NULL, 'Kanca Serang', NULL, '-6.095653551', '106.1598421', NULL, 36, 272, 'Ruko Rau Jl. Kiyai Abdul Latif No.08, Cimuncang, Kec. Serang, Kota Serang, Banten 42111', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:14:06', '', '0000-00-00 00:00:00', 'N'),
(49, NULL, 19, NULL, NULL, 'Kanca Solo', NULL, '-7.564921778', '110.8034545', NULL, 33, 218, 'Jl. Slamet Riyadi No.333, Purwosari, Laweyan, Surakarta City, Central Java 57142', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:35:34', '', '0000-00-00 00:00:00', 'N'),
(50, NULL, 23, NULL, NULL, 'Kanca Sorong', NULL, '-0.887558438', '131.3086028', NULL, 91, 485, 'Jl. Basuki Rahmat Km 9, Kota Sorong, Papua Bar., Klasabi, Kecamatan Sorong Manoi, Kota Sorong, Papua Bar. 98412', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:02:53', '', '0000-00-00 00:00:00', 'N'),
(51, NULL, 18, NULL, NULL, 'Kanca Sukabumi', NULL, '-6.916476323', '106.9362035', NULL, 32, 180, 'Ruko Bounty Jl. SIliwangi No. 90 E RT. 02 RW. 05 Cikole, Kec. Cikole, Kota Sukabumi, Jawa Barat 43113', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:28:28', '', '0000-00-00 00:00:00', 'N'),
(52, NULL, 21, NULL, NULL, 'Kanca Sumbawa Besar', NULL, '-8.282004293', '117.4313912', NULL, 52, 286, 'Jl. Hasanudin No.82, Bugis, Kec. Sumbawa, Kabupaten Sumbawa, Kota Sumbawa, Nusa Tenggara Barat. 84313', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:25:04', '', '0000-00-00 00:00:00', 'N'),
(53, NULL, 20, NULL, NULL, 'Kanca Surabaya', NULL, '-7.281555788', '112.7319465', NULL, 35, 264, 'Jl. Diponegoro No.171, Darmo, Kec. Wonokromo, Kota Surabaya, Jawa Timur 60241', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:31:44', '', '0000-00-00 00:00:00', 'N'),
(54, NULL, 15, NULL, NULL, 'Kanca Tangerang', NULL, '-6.275574014', '106.659106', NULL, 36, 273, 'Ruko Golden Boulevard Blok C No.1, Jl.Pahlawan Seribu, Kel.Lengkong Wetan, Kec.Serpong, Lengkong Karya, Serpong Utara, South Tangerang City, Banten 15322', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:22:24', '', '0000-00-00 00:00:00', 'N'),
(55, NULL, 16, NULL, NULL, 'Kanca Tanjung Pinang', NULL, '0.910488337', '104.4643284', NULL, 21, 154, 'Komplek Ruko Pamedan, Jl. Raja Ali Haji No. 6, Tj. Ayun Sakti, Kec. Bukit Bestari, Kota Tanjung Pinang, Kepulauan Riau 29122', '0771316919', NULL, 'tanjung.pinang@jamkrindo.co.id', 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:17:55', '', '0000-00-00 00:00:00', 'N'),
(56, NULL, 22, NULL, NULL, 'Kanca Tarakan', NULL, '3.31038254', '117.5938194', NULL, 65, 370, 'Jl. Jend. Sudirman, Pamusian, Kec. Tarakan Tengah, Kota Tarakan, Kalimantan Utara', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:30:17', '', '0000-00-00 00:00:00', 'N'),
(57, NULL, 18, NULL, NULL, 'Kanca Tasikmalaya', NULL, '-7.331723641', '108.2343429', NULL, 32, 186, 'Jl. Sutisna Senjaya No.199A, Cikalang, Kec. Tawang, Kab. Tasikmalaya, Jawa Barat 46113', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:29:48', '', '0000-00-00 00:00:00', 'N'),
(58, NULL, 19, NULL, NULL, 'Kanca Tegal', NULL, '-6.861257354', '109.1346763', NULL, 33, 222, 'Jl. Gajah Mada No.21 Mintaragen, Kec. Tegal Timur, Kota Tegal', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:40:10', '', '0000-00-00 00:00:00', 'N'),
(59, NULL, 23, NULL, NULL, 'Kanca Ternate', NULL, '0.916598853', '127.3447696', NULL, 82, 471, 'Jl. Inpres No. 7 Ubo – Ubo Kel. Tabona, Ternate Selatan', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:32:03', '', '0000-00-00 00:00:00', 'N'),
(60, NULL, 19, NULL, NULL, 'Kanca Yogyakarta', NULL, '-7.789583779', '110.3537106', NULL, 34, 227, 'Jl. HOS Cokroaminoto No.161 A, Tegalrejo, Kec. Tegalrejo, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55244', NULL, NULL, NULL, 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-09-04 21:32:27', '', '0000-00-00 00:00:00', 'N'),
(61, NULL, 24, NULL, NULL, 'Kantor Pusat', NULL, NULL, NULL, NULL, 31, 156, NULL, NULL, NULL, '', 'Admin', '0000-00-00 00:00:00', 'Admin Testing', '2024-08-29 21:09:23', '', '0000-00-00 00:00:00', 'N'),
(62, '', 15, NULL, NULL, 'Kanwil I Medan', '', '', '', '', 31, 156, NULL, NULL, NULL, '', 'Admin', '0000-00-00 00:00:00', '', '2024-08-29 21:14:47', 'Admin Testing', '2024-08-29 21:14:47', 'Y'),
(63, '', 15, NULL, NULL, 'Kanwil II Palembang', '', '', '', '', 31, 156, NULL, NULL, NULL, '', 'Admin', '0000-00-00 00:00:00', '', '2024-08-29 02:00:47', 'Admin Testing', '2024-08-29 02:00:47', 'Y'),
(64, '', 15, NULL, NULL, 'Kanwil III Jakarta', '', '', '', '', 31, 156, NULL, NULL, NULL, '', 'Admin', '0000-00-00 00:00:00', '', '2024-08-29 21:16:40', 'Admin Testing', '2024-08-29 21:16:40', 'Y'),
(65, '', 15, NULL, NULL, 'Kanwil IV Bandung', '', '', '', '', 31, 156, NULL, NULL, NULL, '', 'Admin', '0000-00-00 00:00:00', '', '2024-08-29 02:07:22', 'Admin Testing', '2024-08-29 02:07:22', 'Y'),
(66, '', 15, NULL, NULL, 'Kanwil IX Makassar', '', '', '', '', 31, 156, NULL, NULL, NULL, '', 'Admin', '0000-00-00 00:00:00', '', '2024-08-29 20:13:28', 'Admin Testing', '2024-08-29 20:13:28', 'Y'),
(67, '', 15, NULL, NULL, 'Kanwil V Semarang', '', '', '', '', 31, 156, NULL, NULL, NULL, '', 'Admin', '0000-00-00 00:00:00', '', '2024-08-29 02:10:55', 'Admin Testing', '2024-08-29 02:10:55', 'Y'),
(68, '', 15, NULL, NULL, 'Kanwil VI Surabaya', '', '', '', '', 31, 156, NULL, NULL, NULL, '', 'Admin', '0000-00-00 00:00:00', '', '2024-08-29 20:01:42', 'Admin Testing', '2024-08-29 20:01:42', 'Y'),
(69, '', 15, NULL, NULL, 'Kanwil VII Denpasar', '', '', '', '', 31, 156, NULL, NULL, NULL, '', 'Admin', '0000-00-00 00:00:00', '', '2024-08-29 20:10:00', 'Admin Testing', '2024-08-29 20:10:00', 'Y'),
(70, '', 15, NULL, NULL, 'Kanwil VIII Banjarmasin', '', '', '', '', 31, 156, NULL, NULL, NULL, '', 'Admin', '0000-00-00 00:00:00', '', '2024-08-29 20:06:20', 'Admin Testing', '2024-08-29 20:06:20', 'Y'),
(71, NULL, 15, NULL, NULL, 'Cabang IV', '<p>Banten&nbsp;</p>\r\n<p>Banten</p>', '2934820', NULL, NULL, 31, 156, 'Jakarta', NULL, NULL, NULL, 'Fahmi Nugraha', '2024-08-07 20:12:42', 'Admin Testing', '2024-09-04 03:26:47', 'Admin Testing', '2024-09-04 03:26:47', 'Y'),
(73, 'KCJ', 15, NULL, NULL, 'Kantor Cabang Jakarta', '<p>Kantor Cabang</p>', '-6.1556578', '106.8428675', 'https://maps.app.goo.gl/XFbjWwP8m9CsFy599', 31, 159, NULL, NULL, NULL, '', 'Fahmi Nugraha', '2024-08-22 12:40:21', 'Admin Testing', '2024-08-29 21:17:47', 'Admin Testing', '2024-08-29 21:17:47', 'Y'),
(74, 'KCS', 15, NULL, NULL, 'Kantor Cabang Serang', NULL, NULL, NULL, NULL, 36, 272, NULL, NULL, NULL, '', 'Fahmi Nugraha', '2024-08-22 13:12:37', 'Fahmi Nugraha', '2024-08-29 21:18:00', 'Admin Testing', '2024-08-29 21:18:00', 'Y'),
(75, 'KCP', 15, NULL, NULL, 'Kantor Cabang Pontianak', NULL, NULL, NULL, NULL, 61, 327, NULL, NULL, NULL, '', 'Fahmi Nugraha', '2024-08-22 13:27:11', NULL, '2024-08-29 21:18:12', 'Admin Testing', '2024-08-29 21:18:12', 'Y'),
(76, 'KCM', 16, NULL, NULL, 'Kantor Cabang Medan', NULL, NULL, NULL, NULL, 12, 24, NULL, NULL, NULL, '', 'Fahmi Nugraha', '2024-08-25 22:09:58', 'Fahmi Nugraha', '2024-08-29 21:15:22', 'Admin Testing', '2024-08-29 21:15:22', 'Y'),
(77, NULL, 22, NULL, NULL, 'Kanca Banjarmasin', NULL, '-3.190976955', '114.6173618', NULL, 63, 354, '70236, Jl. Gatot Subroto No.17, Kuripan, Kec. Banjarmasin Tim., Kota Banjarmasin, Kalimantan Selatan 70237', NULL, NULL, NULL, 'Admin Testing', '2024-08-29 20:07:46', 'Admin Testing', '2024-09-04 21:27:34', NULL, NULL, 'N'),
(78, NULL, 15, NULL, NULL, 'KANTOR CABANG JAKARTA', NULL, NULL, NULL, NULL, NULL, 145, NULL, NULL, NULL, '', 'Admin Testing', '2024-08-30 03:12:28', 'Fahmi Nugraha', '2024-09-04 03:27:09', 'Admin Testing', '2024-09-04 03:27:09', 'Y'),
(79, 'KCB', 15, NULL, NULL, 'kantor Cabang jakarta', NULL, NULL, NULL, NULL, 31, 157, 'Jakarta', NULL, NULL, NULL, 'Admin Testing', '2024-09-01 20:59:02', 'Admin Testing', '2024-09-01 21:00:31', 'Admin Testing', '2024-09-01 21:00:31', 'Y'),
(80, '71', 15, '72', 'CRG', 'Curug', '<p>Test</p>', '-6.2893157', '106.5672908', 'https://maps.app.goo.gl/XFbjWwP8m9CsFy599', 36, 268, 'Curug', NULL, NULL, NULL, 'Admin Testing', '2024-09-01 23:07:02', 'Admin Testing', '2024-09-02 07:29:32', 'Admin Testing', '2024-09-02 07:29:32', 'Y'),
(81, 'rqw', 19, 'wqe', 'A', 'Kantor Cabang Jakarta', NULL, '-6.2185853,106', '4799165', 'https://maps.app.goo.gl/SQWdqAhtjPvGLhia9', 31, 155, 'fsda', '5435', 'e343ew', 'tes@gmail.com', 'Admin Testing', '2024-09-01 23:14:56', NULL, '2024-09-01 23:18:06', 'Admin Testing', '2024-09-01 23:18:06', 'Y'),
(82, NULL, 16, NULL, NULL, 'KUP Rantau Prapat', NULL, '2.103177995', '99.82533835', NULL, 12, 30, 'Jalan MH Thamrin No 4, Rantauprapat, Rantau Utara, Rantauprapat, Kec. Rantau Utara, Kab. Labuhanbatu, Sumatera Utara 21412', NULL, NULL, NULL, 'Admin Testing', '2024-09-04 03:05:14', 'Admin Testing', '2024-09-04 03:06:20', NULL, NULL, 'N'),
(83, NULL, 16, NULL, NULL, 'Kantor Unit Pelayanan Padangsidimpuan', NULL, '1.379638862', '99.27151665', NULL, 12, 55, 'Jl. Serma Lion Kosong No. 1 (Komplek Grand Palace Sudirman) Kota Padangsidimpuan', NULL, NULL, NULL, 'Admin Testing', '2024-09-04 03:15:51', NULL, '2024-09-04 03:15:51', NULL, NULL, 'N'),
(84, NULL, 16, NULL, NULL, 'Kantor Unit Pelayanan Dumai', NULL, '1.67504119', '101.4490226', NULL, 14, 87, 'Jl. Jend. Sudirman No.265, Bintan, Kec. Dumai Kota, Kota Dumai, Riau 28826', NULL, NULL, NULL, 'Admin Testing', '2024-09-04 03:21:25', NULL, '2024-09-04 03:21:25', NULL, NULL, 'N'),
(85, NULL, 16, NULL, NULL, 'Kantor Unit Pelayanan Lubuklinggau', NULL, '-3.274652204', '102.9021142', NULL, 16, 115, 'Jl. Trans Sumatera Lahat - Lubuk Linggau No.17, Taba Pingin, Kec. Lubuk Linggau Sel. II, Kota Lubuklinggau, Sumatera Selatan 31625', NULL, NULL, NULL, 'Admin Testing', '2024-09-04 03:24:51', NULL, '2024-09-04 03:24:51', NULL, NULL, 'N'),
(86, NULL, 15, NULL, NULL, 'Kantor Unit Pelayanan Bogor', NULL, '-6.571629164', '106.8082592', NULL, 32, 179, 'Jl. Raya Pajajaran No. 28, RT.02/RW.05, Bantarjati, Kec. Bogor Utara, Kota Bogor, Jawa Barat 16161', NULL, NULL, NULL, 'Admin Testing', '2024-09-04 19:57:27', NULL, '2024-09-04 19:57:27', NULL, NULL, 'N'),
(87, NULL, 15, NULL, NULL, 'Kantor Unit Pelayanan Cibinong', NULL, '-6.485404649', '106.8408306', NULL, 32, 161, 'Ruko Cibinong City Center Jalan Tegar Beriman 1 Blok A Nomor 29 Cibinong Kab Bogor', NULL, NULL, NULL, 'Admin Testing', '2024-09-04 19:59:48', NULL, '2024-09-04 19:59:48', NULL, NULL, 'N'),
(88, NULL, 15, NULL, NULL, 'Kantor Unit Pelayanan Bekasi', NULL, '-6.24320092', '106.9930999', NULL, 32, 183, 'Komplek Ruko Sentra Niaga Kalimalang, Jl. Ahmad Yani No.16, Marga Jaya, Kec. Bekasi Sel., Kota Bks, Jawa Barat 17144', NULL, NULL, NULL, 'Admin Testing', '2024-09-04 20:00:52', NULL, '2024-09-04 20:00:52', NULL, NULL, 'N'),
(89, NULL, 18, NULL, NULL, 'Kantor Unit Pelayanan Cimahi', NULL, '-6.868845096', '107,5286063', NULL, 32, 185, 'Jl. Amir Mahmud No. 572B-C  RT02/RW02, Padasuka, Cimahi Tengah, Cimahi', NULL, NULL, NULL, 'Admin Testing', '2024-09-04 20:02:33', 'Admin Testing', '2024-09-04 20:03:33', NULL, NULL, 'N'),
(90, NULL, 19, NULL, NULL, 'Kantor Unit Pelayanan Magelang', NULL, '-7.51741983', '110.2261837', NULL, 33, 195, 'Ruko Metro Square Blok C-2, Jalan Mayjen Bambang Sugeng, Mertoyudan, Jarangan, Sumberrejo, Kec. Mertoyudan, Kabupaten Magelang, Jawa Tengah 56172', NULL, NULL, NULL, 'Admin Testing', '2024-09-04 20:05:24', NULL, '2024-09-04 20:05:24', NULL, NULL, 'N'),
(91, NULL, 19, NULL, NULL, 'Kantor Unit Pelayanan Cilacap', NULL, '-7.727985031', '109.0142778', NULL, 33, 188, 'Jl. Jendral Sudirman No. 17, Sidanegara, Cilacap Tengah, Sidakaya Dua, Sidakaya, Kec. Cilacap Sel., Kabupaten Cilacap, Jawa Tengah 53211', NULL, NULL, NULL, 'Admin Testing', '2024-09-04 20:06:32', NULL, '2024-09-04 20:06:32', NULL, NULL, 'N'),
(92, NULL, 19, NULL, NULL, 'Kantor Unit Pelayanan Pekalongan', NULL, '-6.891876921', '109.6673781', NULL, 33, 213, 'Jl. KH. Mansyur No. 164 B, Podosugih, Kec. Pekalongan Barat, Kota Pekalongan', NULL, NULL, NULL, 'Admin Testing', '2024-09-04 20:10:14', NULL, '2024-09-04 20:10:14', NULL, NULL, 'N'),
(93, NULL, 20, NULL, NULL, 'Kantor Unit Pelayanan Surabaya Kota', NULL, '-7.2555011', '112.7480106', NULL, 35, 234, 'Ruko Central Merr, Jl. Dr. Ir. H. Soekarno No.360 B, Kedung Baruk, Kec. Rungkut, Surabaya, Jawa Timur 60298', NULL, NULL, NULL, 'Admin Testing', '2024-09-04 20:23:57', NULL, '2024-09-04 20:23:57', NULL, NULL, 'N'),
(94, NULL, 20, NULL, NULL, 'Kantor Unit Pelayanan Pamekasan', NULL, '-7.161647865', '113.4924753', NULL, 35, 255, 'Jl. Jokotole No.133, Murleke, Barurambat Tim., Kec. Pademawu, Kabupaten Pamekasan, Jawa Timur 69321', NULL, NULL, NULL, 'Admin Testing', '2024-09-04 20:30:58', NULL, '2024-09-04 20:30:58', NULL, NULL, 'N'),
(95, NULL, 20, NULL, NULL, 'Kantor Unit Pelayanan Bojonegoro', NULL, '-7.151096821', '111.8896752', NULL, 35, 249, 'Jl. WR. Supratman No.15, Kadipaten, Kec. Bojonegoro, Kabupaten Bojonegoro, Jawa Timur 62111', NULL, NULL, NULL, 'Admin Testing', '2024-09-04 20:32:30', NULL, '2024-09-04 20:32:30', NULL, NULL, 'N'),
(96, NULL, 20, NULL, NULL, 'Kantor Unit Pelayanan Jember', NULL, '-8.177835917', '113.6936857', NULL, 35, 236, 'Jl. KH Wachid Hasyim No.12, Kebondalem, Kepatihan, Kec. Kaliwates, Kabupaten Jember, Jawa Timur 68131', NULL, NULL, NULL, 'Admin Testing', '2024-09-04 20:34:27', NULL, '2024-09-04 20:34:27', NULL, NULL, 'N'),
(97, NULL, 22, NULL, NULL, 'Kantor Unit Pelayanan Pangkalan Bun', NULL, '-2.707554994', '111,6480516', NULL, 62, 329, 'Jl. Iskandar Kec.Arut Selatan, Kab Kotawaringin Barat, Kalimantan Tengah 74113', NULL, NULL, NULL, 'Admin Testing', '2024-09-04 20:51:20', NULL, '2024-09-04 20:51:20', NULL, NULL, 'N'),
(98, NULL, 23, NULL, NULL, 'Kantor Unit Pelayanan Watampone', NULL, '-4.53992933', '120.3174444', NULL, 73, 409, 'Jl. Poros Leppangeng - Watampone No.55, Jeppee, Kec. Tanete Riattang Bar., Kabupaten Bone, Sulawesi Selatan 92711', NULL, NULL, NULL, 'Admin Testing', '2024-09-04 20:53:41', NULL, '2024-09-04 20:53:41', NULL, NULL, 'N');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `m_cabang`
--
ALTER TABLE `m_cabang`
  ADD PRIMARY KEY (`id_cabang`) USING BTREE,
  ADD KEY `m_cabang_ibfk_1` (`kd_wilayah`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `m_cabang`
--
ALTER TABLE `m_cabang`
  MODIFY `id_cabang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `m_cabang`
--
ALTER TABLE `m_cabang`
  ADD CONSTRAINT `m_cabang_ibfk_1` FOREIGN KEY (`kd_wilayah`) REFERENCES `m_wilayah` (`id_kanwil`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
