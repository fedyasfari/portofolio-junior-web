<?php
declare(strict_types=1);

// Inisialisasi semua halaman publik; jangan mengungkap kredensial ke browser.
date_default_timezone_set('Asia/Jakarta');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

set_exception_handler(static function (Throwable $e): void {
    error_log('Capstone Sprint 0: ' . $e->getMessage());
    http_response_code(500);
    echo 'Terjadi kesalahan sistem. Periksa layanan MySQL dan catatan error Apache.';
});

$configPath = __DIR__ . '/../config/config.php';
if (!is_file($configPath)) {
    throw new RuntimeException('config/config.php belum ada; salin config.contoh.php lalu sesuaikan.');
}
$konfigurasi = require $configPath;
ini_set('display_errors', !empty($konfigurasi['debug']) ? '1' : '0');
error_reporting(E_ALL);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/pendaftar.php';
