<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    if (!empty($username) && !empty($password) && !empty($role)) {
        $stmt = $mysqli->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $role);
        if ($stmt->execute()) {
            header("Location: users.php");
            exit();
        } else {
            $error = 'Failed to create user.';
        }
        $stmt->close();
    } else {
        $error = 'All fields are required.';
    }
}
?>

<?php include('../layouts/_header.php'); ?>

<main class="flex-shrink-0">
    <div class="container">
        <div class="alert alert-primary text-center mb-3 mt-3" role="alert">
            <h4 class="mt-2">Tambah Pengguna Baru</h4>
        </div>
        <div class="container pt-3">
            <div class="row justify-content-center">
                <div class="col-md-8 mb-4">
                    <div class="card border-primary shadow-lg">
                        <div class="card-body">
                            <?php if ($error) { ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                            <?php } ?>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="admin">Admin</option>
                                        <option value="loket1">Loket 1</option>
                                        <option value="loket2">Loket 2</option>
                                        <option value="loket3">Loket 3</option>
                                        <option value="loket4">Loket 4</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Tambah Pengguna</button>
                                <a href="users.php" class="btn btn-secondary">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('../layouts/_footer.php'); ?>
