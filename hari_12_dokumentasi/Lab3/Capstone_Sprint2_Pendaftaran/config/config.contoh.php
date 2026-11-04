<?php
declare(strict_types=1);
// SALIN menjadi config/config.php dan isi sesuai MySQL lokal Anda.
// JANGAN unggah config.php ke repositori publik.
return [
    'db_host' => '127.0.0.1',
    'db_port' => '3306',
    'db_name' => 'db_capstone_sprint2_demo', // atau DB lama Anda (lihat panduan migrasi)
    'db_user' => 'root',
    'db_password' => '', // contoh khusus XAMPP lokal
    'debug' => false,
];
