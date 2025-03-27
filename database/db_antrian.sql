
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `queue_setting` (
  `id` int(11) NOT NULL,
  `nama_instansi` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telpon` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `running_text` varchar(255) DEFAULT NULL,
  `youtube_id` varchar(255) DEFAULT NULL,
  `list_loket` longtext DEFAULT NULL,
  `warna_primary` varchar(255) DEFAULT NULL,
  `warna_secondary` varchar(255) DEFAULT NULL,
  `warna_accent` varchar(255) DEFAULT NULL,
  `warna_background` varchar(255) DEFAULT NULL,
  `warna_text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


INSERT INTO `queue_setting` (`id`, `nama_instansi`, `logo`, `alamat`, `telpon`, `email`, `running_text`, `youtube_id`, `list_loket`, `warna_primary`, `warna_secondary`, `warna_accent`, `warna_background`, `warna_text`) VALUES
(1, 'APOTEK ENGGAL SAE', 'logo.png', 'Jl. Mayor Dasuki No.68, Jatibarang, Kec. Jatibarang, Kabupaten Indramayu, Jawa Barat 45273', '(0234) 351122', 'apotekenggalsae@gmail.com', 'SELAMAT DATANG DI APOTEK ENGGAL SAE', 'jkS6glRPD_o', '[{\"no_loket\":\"1\",\"nama_loket\":\"Loket 1\"},{\"no_loket\":\"2\",\"nama_loket\":\"Loket 2\"},{\"no_loket\":\"3\",\"nama_loket\":\"Loket 3\"},{\"no_loket\":\"4\",\"nama_loket\":\"Loket 4\"},{\"no_loket\":\"5\",\"nama_loket\":\"Loket 5\"},{\"no_loket\":\"6\",\"nama_loket\":\"Loket 6\"}]', '#00923f', '#c39292', '#6083a9', '#56d76b', '#ffffff');


CREATE TABLE `tbl_antrian` (
  `id` bigint(20) NOT NULL,
  `tanggal` date NOT NULL,
  `no_antrian` smallint(6) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0',
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


ALTER TABLE `queue_setting`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_antrian`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `queue_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `tbl_antrian`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;