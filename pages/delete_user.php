<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

$user_id = $_GET['id'];
if ($user_id) {
    $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        header("Location: users.php");
        exit();
    } else {
        echo 'Failed to delete user.';
    }
    $stmt->close();
} else {
    header("Location: users.php");
    exit();
}
?>
