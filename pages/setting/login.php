<?php
session_start();
require '../../config/database.php'; // Pastikan koneksi database sudah benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameInput = isset($_POST['username']) ? $_POST['username'] : '';
    $passwordInput = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($usernameInput) && !empty($passwordInput)) {
        // Hash the input password using md5
        $hashedPassword = md5($passwordInput);

        // Query to check if the user exists in the database
        $stmt = $mysqli->prepare("SELECT username, password, role FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $usernameInput, $hashedPassword);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        // Verify the password
        if ($user) {
            // Authentication successful
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Set the role in session

            // Redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: ../../index.php"); // Redirect to setting index page for admin
            } else {
                header("Location: ../../index.php"); // Redirect to main index page for other roles
            }
            exit;
        } else {
            echo "<script>alert('Username atau password yang anda masukan salah'); window.location.href='index.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Username dan password tidak boleh kosong'); window.location.href='index.php';</script>";
        exit;
    }
}
?>
