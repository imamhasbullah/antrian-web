<?php
session_start();
require_once "config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tentukan loket berdasarkan role pengguna
    $loket = '';
    if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['loket1', 'loket2', 'loket3', 'loket4'])) {
        $loket = str_replace('loket', '', $_SESSION['role']);
    }

    // Query untuk menghapus data antrian berdasarkan loket
    $query = $mysqli->prepare("DELETE FROM tbl_antrian WHERE loket = ?");
    $query->bind_param("s", $loket);
    $query->execute();

    if ($query->affected_rows > 0) {
        // Reset the auto-increment value
        $mysqli->query("ALTER TABLE tbl_antrian AUTO_INCREMENT = 1");
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
