<!-- Footer -->
<footer class="footer mt-auto py-4">
    <div class="container-fluid">
        <!-- copyright -->
        <div class="copyright text-center mb-2 mb-md-0">
            &copy; <?php echo date('Y'); ?> - <a class="text-danger text-decoration-none">Pengadilan Negeri Tembilahan</a>. Some Rights Reserved.
        </div>
    </div>
</footer>

<!-- load file audio bell antrian -->
<audio id="tingtung" src="assets/audio/tingtung.mp3"></audio>

<!-- jQuery Core -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- Popper and Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

<!-- DataTables -->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
<!-- Responsivevoice -->
<script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Fungsi untuk menampilkan notifikasi
        function showNotification(type, message) {
            if (type === 'error') {
                alert("Error: " + message);
            } else if (type === 'success') {
                alert("Success: " + message);
            }
        }

        // Tampilkan jumlah antrian
        $('#antrian').load('get_antrian.php', function(response, status, xhr) {
            if (status === "error") {
                showNotification('error', xhr.statusText);
            }
        });

        // Proses insert data
        $('#insert').on('click', function() {
            $.ajax({
                type: 'POST',
                url: 'insert.php',
                success: function(result) {
                    if (result === 'Sukses') {
                        $('#antrian').load('get_antrian.php').fadeIn('slow');
                        showNotification('success', 'Antrian berhasil ditambahkan!');
                    } else {
                        showNotification('error', 'Gagal menambahkan antrian!');
                    }
                },
                error: function(xhr) {
                    showNotification('error', xhr.statusText);
                }
            });
        });

        <?php if (isset($loket)) { ?>
            // Tampilkan informasi antrian
            const loadQueueData = () => {
                $('#jumlah-antrian').load('get_jumlah_antrian.php').fadeIn("slow");
                $('#antrian-sekarang').load('get_antrian_sekarang.php').fadeIn("slow");
                $('#antrian-selanjutnya').load('get_antrian_selanjutnya.php').fadeIn("slow");
                $('#sisa-antrian').load('get_sisa_antrian.php').fadeIn("slow");
            };

            // Load data awal
            loadQueueData();

            // Menampilkan data antrian menggunakan DataTables
            var table = $('#tabel-antrian').DataTable({
                "lengthChange": false,
                "searching": false,
                "ajax": {
                    "url": "get_antrian_table.php",
                    "error": function(xhr) {
                        showNotification('error', xhr.statusText);
                    }
                },
                "columns": [
                    { "data": "no_antrian", "width": '250px', "className": 'text-center' },
                    { "data": "status", "visible": false },
                    {
                        "data": null,
                        "orderable": false,
                        "searchable": false,
                        "width": '100px',
                        "className": 'text-center',
                        "render": function(data) {
                            if (data["status"] === "") {
                                return "-";
                            } else if (data["status"] === "0") {
                                return "<button class=\"btn btn-success btn-sm rounded-circle\"><i class=\"bi-mic-fill\"></i></button>";
                            } else if (data["status"] === "1") {
                                return "<button class=\"btn btn-secondary btn-sm rounded-circle\"><i class=\"bi-mic-fill\"></i></button>";
                            }
                        }
                    }
                ],
                "order": [[0, "desc"]],
                "iDisplayLength": 10,
            });

            // Panggilan antrian
            $('#tabel-antrian tbody').on('click', 'button', function() {
                var data = table.row($(this).parents('tr')).data();
                var id = data["id"];
                var bell = document.getElementById('tingtung');

                if (bell) {
                    bell.pause();
                    bell.currentTime = 0;
                    bell.play();

                    // Mainkan suara nomor antrian setelah bell selesai
                    setTimeout(function() {
                        responsiveVoice.speak("Nomor Antrian, " + data["no_antrian"] + ", menuju, loket, <?= htmlspecialchars($loket, ENT_QUOTES) ?>", "Indonesian Female", {
                            rate: 0.9, pitch: 1, volume: 1
                        });
                    }, bell.duration * 770);

                    // Update data antrian
                    $.ajax({
                        type: "POST",
                        url: "update.php",
                        data: { id: id },
                        error: function(xhr) {
                            showNotification('error', xhr.statusText);
                        }
                    });
                } else {
                    showNotification('error', 'Audio bell tidak ditemukan!');
                }
            });

            // Auto reload data setiap 3 detik
            setInterval(function() {
                loadQueueData();
                table.ajax.reload(null, false);
            }, 3000);
        <?php } else { ?>
            console.error("Variabel $loket tidak didefinisikan!");
        <?php } ?>
    });

    function deleteData() {
        if (confirm("Apakah anda yakin akan mereset database? Hal ini mengakibatkan hilangnya semua data antrian")) {
            window.location = '<?= $base_url ?>/clear_db.php';
        }
    }

    function printContent(el) {
        var restorepage = $('body').html();
        var printcontent = $('#' + el).clone();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
    }
</script>
