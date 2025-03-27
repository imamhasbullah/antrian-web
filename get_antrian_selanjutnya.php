<?php
session_start();

// Pengecekan AJAX request untuk mencegah akses langsung ke file
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    // Panggil file "database.php" untuk koneksi ke database
    require_once "config/database.php";

    // Ambil tanggal sekarang (WIB)
    $tanggal = gmdate("Y-m-d", time() + 60 * 60 * 7);

    // Tentukan loket berdasarkan role pengguna
    $loket = '';
    if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['loket1', 'loket2', 'loket3', 'loket4'])) {
        $loket = str_replace('loket', '', $_SESSION['role']);
    }

    // Query untuk mendapatkan nomor antrian berikutnya yang masih "status = 0"
    $query = $mysqli->prepare("SELECT no_antrian FROM tbl_antrian WHERE tanggal = ? AND status = '0' AND (loket = ? OR ? = '') ORDER BY no_antrian ASC LIMIT 1");
    $query->bind_param("sss", $tanggal, $loket, $loket);
    $query->execute();
    $result = $query->get_result();

    // Periksa apakah ada data antrian
    if ($result->num_rows > 0) {
        // Ambil data hasil query
        $data = $result->fetch_assoc();
        $no_antrian = $data['no_antrian'];

        // ✅ Menampilkan nomor antrian tanpa error
        echo htmlspecialchars($no_antrian);
    } else {
        // Jika tidak ada nomor antrian, tampilkan "-"
        echo "-";
    }
}
?>
