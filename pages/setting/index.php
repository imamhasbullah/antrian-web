<?php session_start(); ?>
<!doctype html>
<html lang="en" class="h-100">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Title -->
    <title>Aplikasi Antrian Pengadilan Kelas II Tembilahan</title>

    <!-- Favicon icon -->
    <link href="../../assets/img/favicon.png" type="image/png" rel="shortcut icon">

    <!-- Bootstrap CSS -->
    <link href="../../assets/vendor/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="../../assets/vendor/css/bootstrap-icons.css" rel="stylesheet">

    <!-- Font -->
    <link href="../../assets/vendor/css/swap.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="../../assets/vendor/css/datatables.min.css" type="text/css" rel="stylesheet">

    <!-- Custom Style -->
    <link href="../../assets/css/style.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        <div class="container pt-4">
            <div class="alert alert-primary text-center mb-3 mt-3" role="alert">
                <i class="bi-gear-fill text-primary fs-1"></i>
                <h4 class="mt-2">Setting Aplikasi Antrian</h4>
            </div>

            <?php if (!isset($_SESSION['username'])) : ?>
                <div class="row justify-content-center">
                    <div class="col-md-6 mb-4">
                        <div class="card border-primary shadow-lg">
                            <div class="card-body text-center">
                                <div class="feature-icon-1 bg-primary text-white rounded-circle mb-4 p-3">
                                    <i class="bi-lock-fill fs-1"></i>
                                </div>
                                <h4>Login Admin</h4>
                                <form action="login.php" method="post">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                    </div>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2">
                                        Login <i class="bi-unlock-fill ms-2"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <?php
                require_once "../../config/database.php";
                $query = mysqli_query($mysqli, "SELECT * FROM queue_setting ORDER BY id DESC LIMIT 1") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                // ambil jumlah baris data hasil query
                $rows = mysqli_num_rows($query);

                if ($rows <> 0) {
                    $data = mysqli_fetch_assoc($query);
                } else {
                    $data = [];
                }
                ?>
                <form action="" method="post" id="saveSetting">
                    <input type="hidden" name="id" value="<?= $data['id'] ? $data['id'] : ''; ?>">
                    <div class="row">
                        <div class="col-md-8 mb-4">
                            <div class="card border-primary shadow-lg">
                                <div class="card-body">
                                    <h4 class="card-title">Informasi Instansi</h4>
                                    <div class="mb-3">
                                        <label for="nama_instansi" class="form-label">Nama Instansi</label>
                                        <input type="text" class="form-control" id="nama_instansi" name="nama_instansi" placeholder="Nama Instansi" value="<?= $data['nama_instansi'] ? $data['nama_instansi'] : ''; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Alamat Lengkap" required><?= $data['alamat'] ? $data['alamat'] : ''; ?></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="telpon" class="form-label">Telpon</label>
                                                <input type="text" class="form-control" id="telpon" name="telpon" placeholder="Telpon" value="<?= $data['telpon'] ? $data['telpon'] : ''; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= $data['email'] ? $data['email'] : ''; ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="running_text" class="form-label">Running Text</label>
                                        <textarea class="form-control" id="running_text" name="running_text" rows="3" placeholder="Running Text" required><?= $data['running_text'] ? $data['running_text'] : ''; ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="youtube_id" class="form-label">YouTube ID</label>
                                        <input type="text" class="form-control" id="youtube_id" name="youtube_id" placeholder="YouTube ID in Url parameter v Exp. U7luoXkcXrg" value="<?= $data['youtube_id'] ? $data['youtube_id'] : ''; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $list_loket = $data['list_loket'] ? json_decode($data['list_loket'], true) : [];
                            ?>
                            <div class="card border-primary shadow-lg mt-4">
                                <div class="card-body">
                                    <h4 class="card-title">Daftar Loket</h4>
                                    <?php if (count($list_loket) > 0) : ?>
                                        <?php foreach ($list_loket as $key_lk => $val_lk) : ?>
                                            <div class="row block_row">
                                                <div class="col-md-11">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="mb-3">
                                                                <?php if ($key_lk == 0) : ?>
                                                                    <label class="form-label">Nomor Loket</label>
                                                                <?php endif ?>
                                                                <input type="text" class="form-control" name="no_loket[]" placeholder="Nomor Loket" value="<?= $val_lk['no_loket'] ? $val_lk['no_loket'] : ''; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="mb-3">
                                                                <?php if ($key_lk == 0) : ?>
                                                                    <label class="form-label">Nama Loket</label>
                                                                <?php endif ?>
                                                                <input type="text" class="form-control" name="nama_loket[]" placeholder="Nama Loket" value="<?= $val_lk['nama_loket'] ? $val_lk['nama_loket'] : ''; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 d-flex justify-content-center align-items-center">
                                                    <?php if ($key_lk == 0) : ?>
                                                        <button type="button" class="btn btn-primary btn-sm addLoket"><i class="bi-plus-lg text-white"></i></button>
                                                    <?php else : ?>
                                                        <button type="button" class="btn btn-danger btn-sm deleteLoket"><i class="bi-trash text-white"></i></button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <div class="row block_row">
                                            <div class="col-md-11">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nomor Loket</label>
                                                            <input type="text" class="form-control" name="no_loket[]" placeholder="Nomor Loket" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Loket</label>
                                                            <input type="text" class="form-control" name="nama_loket[]" placeholder="Nama Loket" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1 d-flex justify-content-center align-items-center">
                                                <button type="button" class="btn btn-primary btn-sm addLoket"><i class="bi-plus-lg text-white"></i></button>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div id="blockLoket"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card border-primary shadow-lg">
                                <div class="card-body">
                                    <h4 class="card-title">Styling Monitor</h4>
                                    <div class="text-center mb-3">
                                        <img src="<?= $data['logo'] && file_exists('../../assets/img/' . $data['logo']) ? '../../assets/img/' . $data['logo'] : '../../assets/img/default.png'; ?>" class="rounded-circle mb-3" alt="Logo" width="100px">
                                    </div>
                                    <div class="mb-3">
                                        <label for="logo" class="form-label">Pilih Logo</label>
                                        <input class="form-control" type="file" id="logo" name="logo">
                                        <input type="hidden" name="nama_logo" value="<?= $data['logo'] ? $data['logo'] : ''; ?>">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="warna_primary" class="form-label">Warna Primary</label>
                                                <input type="color" class="form-control form-control-color" id="warna_primary" name="warna_primary" value="<?= $data['warna_primary'] ? $data['warna_primary'] : '#563d7c'; ?>" title="Warna Primary" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="warna_secondary" class="form-label">Warna Secondary</label>
                                                <input type="color" class="form-control form-control-color" id="warna_secondary" name="warna_secondary" value="<?= $data['warna_secondary'] ? $data['warna_secondary'] : '#563d7c'; ?>" title="Warna Secondary" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="warna_accent" class="form-label">Warna Accent</label>
                                                <input type="color" class="form-control form-control-color" id="warna_accent" name="warna_accent" value="<?= $data['warna_accent'] ? $data['warna_accent'] : '#563d7c'; ?>" title="Warna Accent" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="warna_background" class="form-label">Warna Background</label>
                                                <input type="color" class="form-control form-control-color" id="warna_background" name="warna_background" value="<?= $data['warna_background'] ? $data['warna_background'] : '#563d7c'; ?>" title="Warna Background" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="warna_text" class="form-label">Warna Text</label>
                                                <input type="color" class="form-control form-control-color" id="warna_text" name="warna_text" value="<?= $data['warna_text'] ? $data['warna_text'] : '#563d7c'; ?>" title="Warna Text" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg"><i class="bi-save-fill text-white me-3"></i> Simpan</button>
                                <a href="../../index.php" class="btn btn-secondary btn-lg"><i class="bi-box-arrow-left text-white me-3"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto py-4">
        <div class="container">
            <hr class="my-4">
            <!-- copyright -->
            <div class="copyright text-center mb-2 mb-md-0">&copy; <?php date('Y') ?> - <a href="#" target="_blank" class="text-brand text-decoration-none">Pengadilan Negeri Kelas II Tembilahan</a>. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- jQuery Core -->
    <script src="../../assets/vendor/js/jquery-3.6.0.min.js" type="text/javascript"></script>
    <!-- Popper and Bootstrap JS -->
    <script src="../../assets/vendor/js/popper.min.js" type="text/javascript"></script>
    <!-- Bootstrap JS -->
    <script src="../../assets/vendor/js/bootstrap.min.js" type="text/javascript"></script>

    <!-- DataTables -->
    <script src="../../assets/vendor/js/datatables.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        const html = `<div class="row block_row">
                        <div class="col-md-11">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <input type="text" class="form-control"  name="no_loket[]" placeholder="Nomor Loket" required>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="mb-3">
                                        <input type="text" class="form-control"  name="nama_loket[]" placeholder="Nama Loket" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-danger btn-sm deleteLoket"><i class="bi-trash text-white"></i></button>
                        </div>
                    </div>`;
        $(document).on("click", ".addLoket", function(e) {
            $("#blockLoket").append(html);
        });

        $(document).on("click", ".deleteLoket", function(e) {
            $(this).parents(".block_row").remove();
        });

        $(document).on("submit", "#saveSetting", function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: 'save.php',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(result) {
                    if (result === 'Success') {
                        alert("Setting berhasil disimpan")
                        window.location.reload();
                    } else {
                        alert(result);
                    }
                },
            });
        });
    </script>
</body>

</html>