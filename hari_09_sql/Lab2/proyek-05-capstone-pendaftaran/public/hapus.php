<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Metode tidak diizinkan. Hapus data melalui tombol Hapus pada halaman daftar.');
}

periksaCsrf();
$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id < 1) {
    http_response_code(400);
    exit('ID pendaftar tidak valid.');
}

try {
    hapusPendaftar(getConnection(), $id);
    simpanPesan('Data pendaftar berhasil dihapus (jika ID tersedia).');
} catch (PDOException $error) {
    error_log($error->getMessage());
    simpanPesan('Penghapusan gagal. Periksa koneksi dan relasi database.');
}
redirect('index.php');
