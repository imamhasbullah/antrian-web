<?php
require_once __DIR__ . '/../config/database.php';
?>
<!doctype html>
<html lang="en" class="h-100">

<head></head>
    <!-- Title -->
    <title>Antrian Pengadilan Negeri Kelas II Tembilahan</title>

    <!-- Favicon icon -->
    <link href="assets/img/logo.png" type="image/x-icon" rel="shortcut icon">

    <!-- Bootstrap CSS -->
    <link href="assets/vendor/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="assets/vendor/css/bootstrap-icons.css" rel="stylesheet">

    <!-- Font -->
    <link href="assets/vendor/css/swap.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">

    <!-- Custom Style -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="d-flex flex-column h-100">
    <header>
        <div class="container">
            <div class="d-flex justify-content-end">
                <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') { ?>
                    <?php if (!isset($_SESSION['username'])) { ?>
                        <a href="pages/setting/index.php" class="btn btn-success btn-sm mt-2">Login</a>
                    <?php } else { ?>
                        <a href="pages/setting/logout.php" class="btn btn-danger btn-sm mt-2">Logout</a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </header>
</body>
</html>