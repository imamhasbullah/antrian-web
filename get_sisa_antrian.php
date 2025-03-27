<?php
session_start();

// pengecekan ajax request untuk mencegah direct access file, agar file tidak bisa diakses secara langsung dari browser
// jika ada ajax request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
  // panggil file "database.php" untuk koneksi ke database
  require_once "config/database.php";

  // ambil tanggal sekarang
  $tanggal = gmdate("Y-m-d", time() + 60 * 60 * 7);

  // Tentukan loket berdasarkan role pengguna
  $loket = '';
  if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['loket1', 'loket2', 'loket3', 'loket4'])) {
    $loket = str_replace('loket', '', $_SESSION['role']);
  }

  // sql statement untuk menampilkan jumlah data dari tabel "tbl_antrian" berdasarkan "tanggal" dan "status = 0"
  $query = $mysqli->prepare("SELECT count(id) as jumlah FROM tbl_antrian WHERE tanggal = ? AND status = '0' AND (loket = ? OR ? = '')");
  $query->bind_param("sss", $tanggal, $loket, $loket);
  $query->execute();
  $result = $query->get_result();
  $data = $result->fetch_assoc();

  // buat variabel untuk menampilkan data
  $sisa_antrian = $data['jumlah'];

  // tampilkan data
  echo number_format($sisa_antrian, 0, '', '.');
}
?>
