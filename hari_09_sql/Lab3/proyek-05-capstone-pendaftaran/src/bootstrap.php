<?php
declare(strict_types=1);

// Semua halaman publik mengimpor file ini terlebih dahulu.
date_default_timezone_set('Asia/Jakarta');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$konfigurasi = require __DIR__ . '/../config/config.php';
ini_set('display_errors', !empty($konfigurasi['debug']) ? '1' : '0');
error_reporting(E_ALL);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/pendaftar.php';

set_exception_handler(function (Throwable $e): void {
    error_log('Lab 3: ' . $e->getMessage());
    http_response_code(500);
    echo 'Terjadi kesalahan pada sistem. Periksa XAMPP, database, dan error log.';
});
