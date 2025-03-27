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

  // sql statement untuk menampilkan data dari tabel "tbl_antrian" berdasarkan "tanggal" dan "loket"
  $query = $mysqli->prepare("SELECT id, no_antrian, loket, status FROM tbl_antrian WHERE tanggal = ? AND (loket = ? OR ? = '')");
  $query->bind_param("sss", $tanggal, $loket, $loket);
  $query->execute();
  $result = $query->get_result();
  $rows = $result->num_rows;

  // cek hasil query
  // jika data ada
  if ($rows <> 0) {
    $response         = array();
    $response["data"] = array();

    // ambil data hasil query
    while ($row = $result->fetch_assoc()) {
      $data['id']         = $row["id"];
      $data['no_antrian'] = $row["no_antrian"];
      $data['loket']      = $row["loket"];
      $data['status']     = $row["status"];

      array_push($response["data"], $data);
    }

    // tampilkan data
    echo json_encode($response);
  }
  // jika data tidak ada
  else {
    $response         = array();
    $response["data"] = array();

    // buat data kosong untuk ditampilkan
    $data['id']         = "";
    $data['no_antrian'] = "-";
    $data['loket']      = "";
    $data['status']     = "";

    array_push($response["data"], $data);

    // tampilkan data
    echo json_encode($response);
  }
}
?>
