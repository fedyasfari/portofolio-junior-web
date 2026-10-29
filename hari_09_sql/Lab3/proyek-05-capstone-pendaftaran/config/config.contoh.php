<?php
// Contoh konfigurasi: aman dimasukkan ke Git (tanpa sandi nyata).
// Salin file ini menjadi config.php lalu sesuaikan pada komputer Anda.
return [
    'host' => 'localhost',
    'nama_db' => 'db_pelatihan',
    'user' => 'root',
    'sandi' => '', // hanya contoh instalasi XAMPP lokal; jangan isi sandi asli di sini
    'debug' => true, // ubah false pada server yang dapat diakses publik
];
