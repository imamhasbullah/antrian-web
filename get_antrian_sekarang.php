<?php
session_start();

// pengecekan ajax request untuk mencegah direct access file
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

    // sql statement untuk menampilkan data "no_antrian" dari tabel "tbl_antrian" berdasarkan "tanggal" dan "status = 1"
    $query = $mysqli->prepare("SELECT no_antrian FROM tbl_antrian WHERE tanggal = ? AND status = '1' AND (loket = ? OR ? = '') ORDER BY updated_date DESC LIMIT 1");
    $query->bind_param("sss", $tanggal, $loket, $loket);
    $query->execute();
    $result = $query->get_result();

    // cek hasil query
    if ($result->num_rows > 0) {
        // ambil data hasil query
        $data = $result->fetch_assoc();
        $no_antrian = $data['no_antrian'];

        // Pastikan hanya angka yang diformat jika diperlukan
        $angka_antrian = preg_replace('/[^0-9]/', '', $no_antrian); // Ambil hanya angka

        // Jika ingin menampilkan nomor lengkap (misal: PU-001)
        echo htmlspecialchars($no_antrian);

        // Jika hanya ingin menampilkan angkanya saja
        // echo number_format((int)$angka_antrian, 0, '', '.');
    } else {
        // jika data "no_antrian" tidak ada, tampilkan "-"
        echo "-";
    }
}
?>
