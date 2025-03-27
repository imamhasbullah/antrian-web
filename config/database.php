<?php
// deklarasi parameter koneksi database
$host     = "localhost";              // server database, default “localhost” atau “127.0.0.1”
$username = "antria64_pn";                   // username database, default “root”
$password = "PnTbh22334455";                       // password database, default kosong
$database = "antria64_pn";             // memilih database yang akan digunakan

// buat koneksi database
$mysqli = mysqli_connect($host, $username, $password, $database);

// cek koneksi
// jika koneksi gagal 
if (!$mysqli) {
  // tampilkan pesan gagal koneksi
  die('Koneksi Database Gagal : ' . mysqli_connect_error());
}

$base_url = 'https://antrianpntbh.web.id';
