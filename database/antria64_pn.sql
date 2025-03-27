-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 27, 2025 at 03:09 PM
-- Server version: 8.0.35-cll-lve
-- PHP Version: 8.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `antria64_pn`
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
(1, 'PENGADILAN NEGERI KELAS II TEMBILAHAN', 'logo.png', 'Jalan Prof. M. Yamin, SH No.02. \r\nTembilahan 29211 Kab. Indragiri Hilir Propinsi Riau', '(0768) 21085', 'pntembilahan.pengadilan@gmail.com', 'SELAMAT DATANG DI PENGADILAN NEGERI KELAS II TEMBILAHAN', '-', '[{\"no_loket\":\"1\",\"nama_loket\":\"Loket 1\"},{\"no_loket\":\"2\",\"nama_loket\":\"Loket 2\"},{\"no_loket\":\"3\",\"nama_loket\":\"Loket 3\"},{\"no_loket\":\"4\",\"nama_loket\":\"Loket 4\"}]', '#004cff', '#020066', '#6083a9', '#9feaf4', '#000000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_antrian`
--

CREATE TABLE `tbl_antrian` (
  `id` bigint NOT NULL,
  `tanggal` date NOT NULL,
  `no_antrian` varchar(300) NOT NULL,
  `loket` varchar(20) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0',
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_antrian`
--

INSERT INTO `tbl_antrian` (`id`, `tanggal`, `no_antrian`, `loket`, `status`, `updated_date`) VALUES
(1, '2025-03-27', 'PU-001', '1', '1', '2025-03-27 15:03:49'),
(2, '2025-03-27', 'PU-002', '1', '1', '2025-03-27 14:56:21'),
(3, '2025-03-27', 'PH-001', '3', '1', '2025-03-27 14:27:54'),
(4, '2025-03-27', 'PU-003', '1', '1', '2025-03-27 14:56:34'),
(5, '2025-03-27', 'PU-004', '1', '1', '2025-03-27 15:05:07'),
(6, '2025-03-27', 'PD-001', '2', '1', '2025-03-27 14:59:09'),
(7, '2025-03-27', 'PU-005', '1', '1', '2025-03-27 15:06:28'),
(8, '2025-03-27', 'PD-002', '2', '0', '2025-03-27 15:06:05'),
(9, '2025-03-27', 'PH-002', '3', '0', '2025-03-27 15:06:08'),
(10, '2025-03-27', 'PR-001', '4', '0', '2025-03-27 15:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','loket1','loket2','loket3','loket4') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin123', '0192023a7bbd73250516f069df18b500', 'admin'),
(2, 'loket1', '34eeb43959b691bd84ed0c62da2f6d62', 'loket1'),
(3, 'loket2', 'dba53601835994f0daa3882c688a21f4', 'loket2'),
(4, 'loket3', 'c734133429ff805b514557ebeb7f7a23', 'loket3'),
(5, 'loket4', '52aaec9cc06525a15e773a5df8ad0e37', 'loket4');

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

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
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
