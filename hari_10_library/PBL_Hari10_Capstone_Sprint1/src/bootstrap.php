<?php
// bootstrap.php: dimuat oleh semua halaman melalui require_once.
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        // Untuk server HTTPS produksi, aktifkan cookie_secure.
        'use_strict_mode' => true,
    ]);
}
date_default_timezone_set('Asia/Jakarta');

$configPath = __DIR__ . '/../config/config.php';
if (!is_file($configPath)) {
    http_response_code(503);
    exit('Konfigurasi belum tersedia. Salin config/config.contoh.php menjadi config/config.php.');
}
$config = require $configPath;
if (!is_array($config)) {
    http_response_code(500);
    exit('Konfigurasi aplikasi tidak valid.');
}
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/pendaftar.php';
