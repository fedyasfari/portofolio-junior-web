<?php
// Salin sebagai config/config.php. Jangan commit file berisi kredensial.
return [
    'db_host' => '127.0.0.1',
    'db_port' => '3306',
    'db_name' => 'db_pendaftaran_sprint1',
    'db_user' => 'root',
    'db_password' => '', // XAMPP lokal; gunakan password yang aman bila dipublikasikan.
    'admin_email' => 'admin@example.test',
    // Harus diisi hash dari tools/buat-hash-password.php. Jangan pakai password mentah.
    'admin_password_hash' => '',
];
