-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 19, 2025 at 03:46 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_antrian`
--

-- --------------------------------------------------------

--
-- Table structure for table `queue_setting`
--

CREATE TABLE `queue_setting` (
  `id` int NOT NULL,
  `nama_instansi` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telpon` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `running_text` varchar(255) DEFAULT NULL,
  `youtube_id` varchar(255) DEFAULT NULL,
  `list_loket` longtext,
  `warna_primary` varchar(255) DEFAULT NULL,
  `warna_secondary` varchar(255) DEFAULT NULL,
  `warna_accent` varchar(255) DEFAULT NULL,
  `warna_background` varchar(255) DEFAULT NULL,
  `warna_text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `queue_setting`
--

INSERT INTO `queue_setting` (`id`, `nama_instansi`, `logo`, `alamat`, `telpon`, `email`, `running_text`, `youtube_id`, `list_loket`, `warna_primary`, `warna_secondary`, `warna_accent`, `warna_background`, `warna_text`) VALUES
(1, 'PENGADILAN NEGERI KELAS II TEMBILAHAN', 'logo (2).png', 'Jalan Prof. M. Yamin, SH No.02. \r\nTembilahan 29211 Kab. Indragiri Hilir Propinsi Riau', '(0768) 21085', 'pntembilahan.pengadilan@gmail.com', 'SELAMAT DATANG DI PENGADILAN NEGERI KELAS II TEMBILAHAN', '-', '[{\"no_loket\":\"1\",\"nama_loket\":\"Loket 1\"},{\"no_loket\":\"2\",\"nama_loket\":\"Loket 2\"},{\"no_loket\":\"3\",\"nama_loket\":\"Loket 3\"},{\"no_loket\":\"4\",\"nama_loket\":\"Loket 4\"}]', '#00923f', '#c39292', '#6083a9', '#56d76b', '#ffffff');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_antrian`
--

CREATE TABLE `tbl_antrian` (
  `id` bigint NOT NULL,
  `tanggal` date NOT NULL,
  `no_antrian` smallint NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0',
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_antrian`
--

INSERT INTO `tbl_antrian` (`id`, `tanggal`, `no_antrian`, `status`, `updated_date`) VALUES
(18, '2025-02-18', 1, '0', NULL),
(19, '2025-02-18', 2, '1', '2025-02-18 15:49:36'),
(20, '2025-02-18', 3, '1', '2025-02-18 15:49:25'),
(21, '2025-02-18', 4, '0', NULL),
(22, '2025-02-18', 5, '0', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `queue_setting`
--
ALTER TABLE `queue_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_antrian`
--
ALTER TABLE `tbl_antrian`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `queue_setting`
--
ALTER TABLE `queue_setting`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_antrian`
--
ALTER TABLE `tbl_antrian`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'loket1', 'loket2', 'loket3', 'loket4') NOT NULL
);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
