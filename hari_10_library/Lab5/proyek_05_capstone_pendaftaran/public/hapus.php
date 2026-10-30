<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('HTTP 405 — Metode tidak diizinkan. Hapus melalui tombol di halaman daftar.');
}

cekCsrf();
$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]);
if ($id === false || $id === null || ambilPendaftarById(getConnection(), $id) === null) {
    http_response_code(404);
    exit('HTTP 404 — Data pendaftar tidak ditemukan.');
}

hapusPendaftar(getConnection(), $id);
setFlash('Pendaftar berhasil dihapus.');
redirect('index.php');
