<?php
include('layouts/_header.php');
require_once 'config/database.php'; // Include the database connection
$loket = $_GET['loket'];

// Define service names
$service_names = [
    '1' => 'PTSP Umum',
    '2' => 'PTSP Pidana',
    '3' => 'PTSP Hukum',
    '4' => 'PTSP Perdata'
];
?>

<!--- Content ------------------------------->
<main class="flex-shrink-0">
    <div class="container pt-4">
        <div class="alert alert-primary text-center mb-3 mt-3" role="alert" style="background-color: #28a745; color: #fff; border-color: #28a745;">
            <i class="bi-mic-fill fs-1" style="color: #fff;"></i>
            <h4 class="mt-2">Panggilan Antrian <?= $service_names[$loket] ?></h4>
        </div>

        <div class="d-flex justify-content-center mb-4">
            <a href="index.php" class="btn btn-outline-primary me-2"><i class="bi-house-door-fill"></i> Home</a>
            <button class="btn btn-outline-danger me-2" onclick="deleteData()"><i class="bi-trash"></i> Clear Database</button>
        </div>

        <div class="row justify-content-center">
            <!-- menampilkan informasi jumlah antrian -->
            <div class="col-md-3 mb-4">
                <div class="card border-primary shadow-lg" style="border-color: #28a745;">
                    <div class="card-body text-center">
                        <div class="feature-icon-1 bg-warning text-white rounded-circle mb-4 p-3">
                            <i class="bi-people fs-1"></i>
                        </div>
                        <h4 id="jumlah-antrian" class="text-warning mb-1"></h4>
                        <p class="mb-0">Jumlah Antrian</p>
                    </div>
                </div>
            </div>
            <!-- menampilkan informasi nomor antrian yang sedang dipanggil -->
            <div class="col-md-3 mb-4">
                <div class="card border-primary shadow-lg" style="border-color: #28a745;">
                    <div class="card-body text-center">
                        <div class="feature-icon-1 bg-success text-white rounded-circle mb-4 p-3">
                            <i class="bi-person-check fs-1"></i>
                        </div>
                        <h4 id="antrian-sekarang" class="text-success mb-1"></h4>
                        <p class="mb-0">Antrian Sekarang</p>
                    </div>
                </div>
            </div>
            <!-- menampilkan informasi nomor antrian yang akan dipanggil selanjutnya -->
            <div class="col-md-3 mb-4">
                <div class="card border-primary shadow-lg" style="border-color: #28a745;">
                    <div class="card-body text-center">
                        <div class="feature-icon-1 bg-info text-white rounded-circle mb-4 p-3">
                            <i class="bi-person-plus fs-1"></i>
                        </div>
                        <h4 id="antrian-selanjutnya" class="text-info mb-1"></h4>
                        <p class="mb-0">Antrian Selanjutnya</p>
                    </div>
                </div>
            </div>
            <!-- menampilkan informasi jumlah antrian yang belum dipanggil -->
            <div class="col-md-3 mb-4">
                <div class="card border-primary shadow-lg" style="border-color: #28a745;">
                    <div class="card-body text-center">
                        <div class="feature-icon-1 bg-danger text-white rounded-circle mb-4 p-3">
                            <i class="bi-person fs-1"></i>
                        </div>
                        <h4 id="sisa-antrian" class="text-danger mb-1"></h4>
                        <p class="mb-0">Sisa Antrian</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-primary shadow-lg" style="border-color: #28a745;">
            <div class="card-body">
                <table id="tabel-antrian" class="table table-bordered table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th>Nomor Antrian</th>
                            <th>Status</th>
                            <th>Panggil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($mysqli, "SELECT * FROM tbl_antrian WHERE loket = '$loket' ORDER BY id ASC") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>";
                            echo "<td>" . $row['no_antrian'] . "</td>";
                            echo "<td>" . ($row['status'] == 1 ? 'Dipanggil' : 'Belum Dipanggil') . "</td>";
                            echo "<td><button class='btn btn-primary btn-sm' onclick='panggilAntrian(" . $row['id'] . ")' style='background-color: #28a745; border-color: #28a745;'>Panggil</button></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?php
include('layouts/_footer.php');
?>

<script>
    function panggilAntrian(id) {
        $.ajax({
            url: 'panggil_antrian.php',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                if (response == 'success') {
                    location.reload();
                } else {
                    alert('Gagal memanggil antrian');
                }
            }
        });
    }

    function deleteData() {
        if (confirm('Apakah Anda yakin ingin menghapus semua data antrian?')) {
            $.ajax({
                url: 'delete_data.php',
                type: 'POST',
                success: function(response) {
                    if (response == 'success') {
                        location.reload();
                    } else {
                        alert('Gagal menghapus data');
                    }
                }
            });
        }
    }
</script>