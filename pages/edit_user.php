<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

$error = '';
$user_id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $role = $_POST['role'];

    if (!empty($username) && !empty($role)) {
        $stmt = $mysqli->prepare("UPDATE users SET username = ?, role = ? WHERE id = ?");
        $stmt->bind_param("ssi", $username, $role, $user_id);
        if ($stmt->execute()) {
            header("Location: users.php");
            exit();
        } else {
            $error = 'Failed to update user.';
        }
        $stmt->close();
    } else {
        $error = 'All fields are required.';
    }
}

// Fetch user data
$stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<?php include('../layouts/_header.php'); ?>

<main class="flex-shrink-0">
    <div class="container">
        <div class="alert alert-primary text-center mb-3 mt-3" role="alert">
            <h4 class="mt-2">Edit User</h4>
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
                                    <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="loket1" <?= $user['role'] == 'loket1' ? 'selected' : '' ?>>Loket 1</option>
                                        <option value="loket2" <?= $user['role'] == 'loket2' ? 'selected' : '' ?>>Loket 2</option>
                                        <option value="loket3" <?= $user['role'] == 'loket3' ? 'selected' : '' ?>>Loket 3</option>
                                        <option value="loket4" <?= $user['role'] == 'loket4' ? 'selected' : '' ?>>Loket 4</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update User</button>
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
