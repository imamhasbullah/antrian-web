<?php 
session_start();
include('layouts/_header.php');
require_once "config/database.php";

// Ambil pengaturan loket terbaru
try {
    $stmt = $mysqli->prepare("SELECT * FROM queue_setting ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    
    $list_loket = !empty($data['list_loket']) ? json_decode($data['list_loket'], true) : [];
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// Define service names
$service_names = [
    'loket1' => 'PTSP UMUM',
    'loket2' => 'PTSP PIDANA',
    'loket3' => 'PTSP HUKUM',
    'loket4' => 'PTSP PERDATA'
];
?>

<main class="flex-shrink-0">
   <div class="container">
        <div class="alert alert-primary text-center mb-3 mt-3" role="alert" style="background-color: #28a745; color: #fff; border-color: #28a745;">
            <img src="<?= !empty($data['logo']) && file_exists('assets/img/' . $data['logo']) ? 'assets/img/' . $data['logo'] : 'assets/img/logo.png' ?>" alt="Logo" width="80px" class="rounded-circle shadow">
            <h4 class="mt-2"><?= !empty($data['nama_instansi']) ? $data['nama_instansi'] : ''; ?></h4>
        </div>
  
        <div class="container pt-3">
            <div class="row justify-content-center">
                <!-- Halaman Nomor Antrian -->
                <?php if (!isset($_SESSION['role']) || in_array($_SESSION['role'], ['admin', 'loket1', 'loket2', 'loket3', 'loket4'])) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card border-primary shadow-lg" style="border-color: #28a745;">
                        <div class="card-body text-center">
                            <i class="bi-people fs-1 mb-3" style="color: #28a745;"></i>
                            <h4>Nomor Antrian</h4>
                            <p class="mb-4">Halaman ini digunakan untuk mengambil nomor antrian.</p>
                            <a href="antrian.php" class="btn btn-primary rounded-pill px-4 py-2" style="background-color: #28a745; border-color: #28a745;">Tampilkan <i class="bi-chevron-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
                <!-- Halaman Panggilan Antrian -->
                <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'loket1', 'loket2', 'loket3', 'loket4'])) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card border-primary shadow-lg" style="border-color: #28a745;">
                        <div class="card-body text-center">
                            <i class="bi-mic fs-1 mb-3" style="color: #28a745;"></i>
                            <h4>Panggilan Antrian</h4>
                            <p class="mb-4">Petugas loket dapat memanggil antrian pengunjung di sini.</p>
                            <div class="d-flex justify-content-center flex-wrap gap-2">
                                <?php foreach ($list_loket as $loket) { ?>
                                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'loket' . $loket['no_loket']) { ?>
                                <a href="panggil.php?loket=<?= $loket['no_loket'] ?>" class="btn btn-primary rounded-pill px-3 py-1" style="background-color: #28a745; border-color: #28a745;"><?= $service_names['loket' . $loket['no_loket']] ?> <i class="bi-chevron-right ms-2"></i></a>
                                <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
                <!-- Halaman Admin (Monitor & Setting Antrian) -->
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                <div class="col-md-4 mb-4">
                    <div class="card border-primary shadow-lg" style="border-color: #28a745;">
                        <div class="card-body text-center">
                            <i class="bi-display fs-1 mb-3" style="color: #28a745;"></i>
                            <h4>Monitor Antrian</h4>
                            <p class="mb-4">Menampilkan antrian di monitor.</p>
                            <a href="pages/monitor" class="btn btn-primary rounded-pill px-4 py-2" style="background-color: #28a745; border-color: #28a745;">Tampilkan <i class="bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-primary shadow-lg" style="border-color: #28a745;">
                        <div class="card-body text-center">
                            <i class="bi-gear fs-1 mb-3" style="color: #28a745;"></i>
                            <h4>Setting Antrian</h4>
                            <p class="mb-4">Atur konfigurasi antrian.</p>
                            <a href="pages/setting" class="btn btn-primary rounded-pill px-4 py-2" style="background-color: #28a745; border-color: #28a745;">Tampilkan <i class="bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-primary shadow-lg" style="border-color: #28a745;">
                        <div class="card-body text-center">
                            <i class="bi-people fs-1 mb-3" style="color: #28a745;"></i>
                            <h4>Setting User</h4>
                            <p class="mb-4">Atur akun dan role pengguna.</p>
                            <a href="pages/users.php" class="btn btn-primary rounded-pill px-4 py-2" style="background-color: #28a745; border-color: #28a745;">Tampilkan <i class="bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>

<?php
include('layouts/_footer.php');
?>
