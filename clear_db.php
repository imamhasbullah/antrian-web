<?php

// panggil file "database.php" untuk koneksi ke database
require_once "config/database.php";
require_once "config/config.php";

// sql statement untuk menampilkan jumlah data dari tabel "tbl_antrian" berdasarkan "tanggal"
$query = mysqli_query($mysqli, "TRUNCATE TABLE tbl_antrian")
    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));

// redirect();
header("location:" . $base_url);
