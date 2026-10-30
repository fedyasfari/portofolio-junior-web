<?php
declare(strict_types=1);
// Tes CLI sederhana yang tidak memerlukan database/MySQL.
require_once __DIR__ . '/../src/helpers.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$teks = '<script>alert(1)</script>';
$aman = e($teks);
if (str_contains($aman, '<script>') || !str_contains($aman, '&lt;script&gt;')) {
    fwrite(STDERR, "GAGAL: output escaping\n");
    exit(1);
}
$token = tokenCsrf();
if (strlen($token) !== 64 || !ctype_xdigit($token) || tokenCsrf() !== $token) {
    fwrite(STDERR, "GAGAL: CSRF token\n");
    exit(1);
}
$_POST['csrf'] = $token;
cekCsrf();
echo "LULUS: HTML escaping, pembuatan dan validasi CSRF token dasar.\n";
