<?php    
require 'config/database.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$is_logged_in = isset($_SESSION['user_id']);

$layanan = [
    '1' => ['nama' => 'PTSP UMUM', 'kode' => 'PU'],
    '2' => ['nama' => 'PTSP PIDANA', 'kode' => 'PD'],
    '3' => ['nama' => 'PTSP HUKUM', 'kode' => 'PH'],
    '4' => ['nama' => 'PTSP PERDATA', 'kode' => 'PR']
];

// Set the default timezone to match the computer's timezone
date_default_timezone_set('Asia/Jakarta'); // Sesuaikan dengan zona waktu yang digunakan

// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loket'])) {
    header('Content-Type: application/json');

    $loket = $_POST['loket'];
    if (!isset($layanan[$loket])) {
        echo json_encode(['error' => 'Layanan tidak valid']);
        exit;
    }

    $kode_layanan = $layanan[$loket]['kode'];
    $tanggal = date('Y-m-d');

    // Cek jumlah antrian untuk hari ini di loket yang dipilih
    $stmt = $mysqli->prepare("SELECT COUNT(*) as total FROM tbl_antrian WHERE tanggal = ? AND loket = ?");
    $stmt->bind_param("ss", $tanggal, $loket);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    $nomor_urut = $row['total'] + 1;
    $nomor_antrian = $kode_layanan . '-' . str_pad($nomor_urut, 3, '0', STR_PAD_LEFT);

    // Simpan ke database
    $stmt = $mysqli->prepare("INSERT INTO tbl_antrian (tanggal, no_antrian, loket, status, updated_date) VALUES (?, ?, ?, '0', NOW())");
    $stmt->bind_param("sss", $tanggal, $nomor_antrian, $loket);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['nomor' => $nomor_antrian, 'loket' => $layanan[$loket]['nama']]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrian Pengadilan Negeri Kelas II Tembilahan</title>
    <link href="assets/img/logo.png" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 600px; margin-top: 50px; }
        .card { border-radius: 10px; text-align: center; padding: 20px; border-color: #28a745; }
        .btn-primary { width: 100%; font-size: 18px; background-color: #28a745; border-color: #28a745; }
        .btn-outline-primary { width: 100%; font-size: 18px; color: #28a745; border-color: #28a745; }
        .btn-outline-primary:hover { background-color: #28a745; color: #fff; }
        .back-button { position: absolute; top: 20px; right: 20px; }
    </style>
</head>
<body>
    <div class="container text-center">
        <a href="index.php" class="btn btn-secondary back-button">Kembali</a>
        <img src="assets/img/logo.png" alt="Logo Pengadilan" width="100">
        <h2 class="mt-3">PENGADILAN NEGERI KELAS II TEMBILAHAN</h2>
        
        <div class="card shadow-sm mt-4">
            <h4 class="mb-3">Nomor Antrian</h4>
            <p>Silakan pilih layanan untuk mengambil nomor antrian.</p>
            <div id="loket-section">
                <button class="btn btn-outline-primary mt-2" onclick="ambilAntrian('1')">PTSP UMUM</button>
                <button class="btn btn-outline-primary mt-2" onclick="ambilAntrian('2')">PTSP PIDANA</button>
                <button class="btn btn-outline-primary mt-2" onclick="ambilAntrian('3')">PTSP HUKUM</button>
                <button class="btn btn-outline-primary mt-2" onclick="ambilAntrian('4')">PTSP PERDATA</button>
            </div>
            <div id="nomor_antrian" style="display: none;">
                <h5 style="margin: 10px; font-size: 20px;">Nomor Antrian Anda: <span id="nomor"></span></h5>
            </div>
            <div id="print_area" style="display: none;">
                <div style="font-family: Arial, sans-serif; text-align: center; width: 250px; margin: auto; padding: 10px; border: 1px dashed #000;">
                    <h5 style="margin: 0; font-weight: bold;">PENGADILAN NEGERI</h5>
                    <h5 style="margin: 0; font-weight: bold;">KELAS II TEMBILAHAN</h5>
                    <hr style="border-top: 1px dashed #000;">
                    <p style="margin: 5px 0; font-size: 12px;">LOKET: <b id="loket"></b></p>
                    <p style="margin: 5px 0; font-size: 12px;">NOMOR ANTRIAN:</p>
                    <h1 style="margin: 0; font-size: 30px;" id="nomor_print"></h1>
                    <hr style="border-top: 1px dashed #000;">
                    <p style="margin: 0; font-size: 12px;">Tanggal: <span id="tanggal"></span></p>
                    <p style="margin: 0; font-size: 12px;">Jam: <span id="jam"></span></p>
                    <p style="margin: 0; font-size: 12px;">Harap menunggu panggilan.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function ambilAntrian(loket) {
            let formData = new FormData();
            formData.append('loket', loket);

            let response = await fetch(window.location.href, {
                method: 'POST',
                body: formData
            });

            let textResponse = await response.text();
            console.log("Response dari server:", textResponse);

            try {
                let result = JSON.parse(textResponse);
                if (result.error) {
                    alert(result.error);
                    return;
                }

                let nomorElem = document.getElementById('nomor');
                let nomorPrintElem = document.getElementById('nomor_print');
                let loketElem = document.getElementById('loket');
                let tanggalElem = document.getElementById('tanggal');
                let jamElem = document.getElementById('jam');

                nomorElem.innerText = result.nomor;
                nomorPrintElem.innerText = result.nomor;
                loketElem.innerText = result.loket;
                tanggalElem.innerText = new Date().toLocaleDateString('id-ID');
                jamElem.innerText = new Date().toLocaleTimeString('id-ID');

                let nomorAntrianElem = document.getElementById('nomor_antrian');
                nomorAntrianElem.style.display = 'block';

                // Print the ticket
                printContent('print_area');
            } catch (e) {
                console.error("Parsing JSON gagal:", e);
                alert("Terjadi kesalahan pada server.");
            }
        }

        function printContent(el) {
            let restorePage = document.body.innerHTML;
            let printContent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = restorePage;
        }
    </script>
</body>
</html>
