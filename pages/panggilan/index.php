<!doctype html>
<html lang="en" class="h-100">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Aplikasi Antrian General Static">
    <meta name="author" content="Ade Rahman">

    <!-- Title -->
    <title>Aplikasi Antrian General Static</title>

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
            <div class="d-flex flex-column flex-md-row px-4 py-3 mb-4 bg-white rounded-2 shadow-sm">
                <!-- judul halaman -->
                <div class="d-flex align-items-center me-md-auto">
                    <i class="bi-mic-fill text-success me-3 fs-3"></i>
                    <h1 class="h5 pt-2">Panggilan Antrian <span class="namaLoket"></span></h1>
                </div>
                <!-- breadcrumbs -->
                <div class="ms-5 ms-md-0 pt-md-3 pb-md-0">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="bi-house-fill text-success"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Antrian</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <!-- menampilkan informasi jumlah antrian -->
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-start">
                                <div class="feature-icon-3 me-4">
                                    <i class="bi-people text-warning"></i>
                                </div>
                                <div>
                                    <p id="jumlah-antrian" class="fs-3 text-warning mb-1"></p>
                                    <p class="mb-0">Jumlah Antrian</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- menampilkan informasi nomor antrian yang sedang dipanggil -->
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-start">
                                <div class="feature-icon-3 me-4">
                                    <i class="bi-person-check text-success"></i>
                                </div>
                                <div>
                                    <p id="antrian-sekarang" class="fs-3 text-success mb-1"></p>
                                    <p class="mb-0">Antrian Sekarang</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- menampilkan informasi nomor antrian yang akan dipanggil selanjutnya -->
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-start">
                                <div class="feature-icon-3 me-4">
                                    <i class="bi-person-plus text-info"></i>
                                </div>
                                <div>
                                    <p id="antrian-selanjutnya" class="fs-3 text-info mb-1"></p>
                                    <p class="mb-0">Antrian Selanjutnya</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- menampilkan informasi jumlah antrian yang belum dipanggil -->
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-start">
                                <div class="feature-icon-3 me-4">
                                    <i class="bi-person text-danger"></i>
                                </div>
                                <div>
                                    <p id="sisa-antrian" class="fs-3 text-danger mb-1"></p>
                                    <p class="mb-0">Sisa Antrian</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table id="tabel-antrian" class="table table-bordered table-striped table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>Nomor Antrian</th>
                                    <th>Status</th>
                                    <th>Panggil</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto py-4">
        <div class="container">
            <hr class="my-4">
            <!-- copyright -->
             <div class="copyright text-center mb-2 mb-md-0">&copy; <?php date('Y') ?> - <a href="https://www.youtube.com/@sunmorilingkarnagreg6969" target="_blank" class="text-brand text-decoration-none">KaSetya02</a>. All rights reserved.
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
    <!-- Responsivevoice -->

    <script type="text/javascript">
        $(document).ready(function() {
            // Koneksi websocket
            var is_open = false;
            
            // Ubah alamat ip websocket
            var conn = new WebSocket('ws://127.0.0.1/');
            conn.onopen = function(e) {
                console.log("Connection established!");
                is_open = true;
            };


            var loket = localStorage.getItem('_loket');
            $(".namaLoket").html(' Loket ' + loket);
            // tampilkan informasi antrian
            $('#jumlah-antrian').load('get_jumlah_antrian.php');
            $('#antrian-sekarang').load('get_antrian_sekarang.php');
            $('#antrian-selanjutnya').load('get_antrian_selanjutnya.php');
            $('#sisa-antrian').load('get_sisa_antrian.php');

            // menampilkan data antrian menggunakan DataTables
            var table = $('#tabel-antrian').DataTable({
                "lengthChange": false, // non-aktifkan fitur "lengthChange"
                "searching": false, // non-aktifkan fitur "Search"
                "ajax": "get_antrian.php", // url file proses tampil data dari database
                // menampilkan data
                "columns": [{
                        "data": "no_antrian",
                        "width": '200px',
                        "orderable": false,
                        "searchable": false,
                        "className": 'text-center',
                        render: function(data) {
                            return '<b>' + data + '</b>'
                        }
                    },
                    {
                        "data": "status",
                        "visible": false
                    },
                    {
                        "data": null,
                        "orderable": false,
                        "searchable": false,
                        "width": '100px',
                        "className": 'text-center',
                        "render": function(data, type, row) {
                            // jika tidak ada data "status"
                            if (data["status"] === "") {
                                // sembunyikan button panggil
                                var btn = "-";
                            }
                            // jika data "status = 0"
                            else if (data["status"] === "0") {
                                // tampilkan button panggil
                                var btn = "<button class=\"btn btn-success btn-sm rounded-circle\"><i class=\"bi-mic-fill\"></i></button>";
                            }
                            // jika data "status = 1"
                            else if (data["status"] === "1") {
                                // tampilkan button ulangi panggilan
                                var btn = "<button class=\"btn btn-secondary btn-sm rounded-circle\"><i class=\"bi-mic-fill\"></i></button>";
                            };
                            return btn;
                        }
                    },
                ],
                "order": [
                    [0, "desc"] // urutkan data berdasarkan "no_antrian" secara descending
                ],
                "iDisplayLength": 10, // tampilkan 10 data per halaman
            });

            // panggilan antrian dan update data
            $('#tabel-antrian tbody').on('click', 'button', function() {
                // ambil data dari datatables 
                var data = table.row($(this).parents('tr')).data();
                // buat variabel untuk menampilkan data "id"
                var id = data["id"];

                if (is_open) {
                    conn.send(JSON.stringify({
                        no_antrian: data["no_antrian"],
                        loket: loket
                    }));
                }

                // proses update data
                $.ajax({
                    type: "POST", // mengirim data dengan method POST
                    url: "update.php", // url file proses update data
                    // tentukan data yang dikirim
                    data: {
                        id: id
                    }
                });
            });

            // auto reload data antrian setiap 1 detik untuk menampilkan data secara realtime
            setInterval(function() {
                $('#jumlah-antrian').load('get_jumlah_antrian.php').fadeIn("slow");
                $('#antrian-sekarang').load('get_antrian_sekarang.php').fadeIn("slow");
                $('#antrian-selanjutnya').load('get_antrian_selanjutnya.php').fadeIn("slow");
                $('#sisa-antrian').load('get_sisa_antrian.php').fadeIn("slow");
                table.ajax.reload(null, false);
            }, 1000);
        });
    </script>
</body>

</html>