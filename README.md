Aplikasi Antrian Berbasis Web
Aplikasi Antrian adalah sistem manajemen yang dirancang untuk mengatur antrian pengunjung di perusahaan atau instansi. Sistem ini membantu meningkatkan efisiensi dan efektivitas dalam memberikan layanan kepada pengunjung.

Aplikasi ini dibangun menggunakan:

Bahasa Pemrograman: PHP Versi 8

Database: MySQL/MariaDB

Komunikasi Database: MySQLi Extension (mode Procedural)

Framework CSS: Bootstrap 5 untuk desain tampilan.

Fitur Utama Aplikasi
Aplikasi Antrian ini memiliki dua antarmuka utama: Nomor Antrian dan Panggilan Antrian.

1. Nomor Antrian
Halaman ini memungkinkan pengunjung untuk mengambil nomor antrian. Fitur utama:

Pengambilan nomor antrian secara offline maupun online (bisa dikembangkan lebih lanjut).

Fungsi cetak langsung nomor antrian menggunakan printer thermal (support ESC/POS).

2. Panggilan Antrian
Halaman ini dirancang untuk petugas loket agar dapat memanggil pengunjung secara teratur. Fitur utama:

Informasi jumlah antrian, nomor antrian saat ini, nomor antrian berikutnya, dan sisa antrian.

Tombol panggilan antrian yang dapat dihubungkan dengan perangkat suara (speaker).

Library ResponsiveVoice.JS digunakan untuk memutar suara panggilan secara otomatis.

Update Fitur Terbaru
Penambahan Loket

Sistem sebelumnya hanya mendukung 1 loket, sekarang diperluas menjadi 2 loket atau lebih.

Fungsi Cetak

Penambahan fitur cetak nomor antrian ke printer thermal secara otomatis dengan kertas ukuran 80mm.

Mendukung printer dengan format ESC/POS.

Templating

Penggunaan template dinamis agar tampilan lebih rapi dan konsisten.

Perbaikan Minor

Beberapa pembaruan kecil untuk meningkatkan performa dan stabilitas aplikasi.
