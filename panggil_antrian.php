<?php
require_once "config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $query = mysqli_query($mysqli, "UPDATE tbl_antrian SET status = 1 WHERE id = '$id'") or die('Ada kesalahan pada query update data : ' . mysqli_error($mysqli));

    if ($query) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
