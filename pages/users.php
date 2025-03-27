<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

// Handle CRUD operations here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle create, update, delete operations
    // ...existing code...
}

// Fetch users from the database
$users = [];
$query = $mysqli->query("SELECT * FROM users");
while ($row = $query->fetch_assoc()) {
    $users[] = $row;
}
?>

<?php include('../layouts/_header.php'); ?>

<main class="flex-shrink-0">
    <div class="container">
        <div class="alert alert-primary text-center mb-3 mt-3" role="alert">
            <h4 class="mt-2">Manage Users</h4>
        </div>
        <div class="container pt-3">
            <div class="row justify-content-center">
                <div class="col-md-8 mb-4">
                    <div class="card border-primary shadow-lg">
                        <div class="card-body">
                            <h5 class="card-title">User List</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) { ?>
                                    <tr>
                                        <td><?= $user['id'] ?></td>
                                        <td><?= $user['username'] ?></td>
                                        <td><?= $user['role'] ?></td>
                                        <td>
                                            <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <a href="create_user.php" class="btn btn-primary">Tambah Pengguna</a>
                            <a href="../index.php" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('../layouts/_footer.php'); ?>
