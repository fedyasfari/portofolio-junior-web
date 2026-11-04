<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';
wajibLogin();
hanyaPost();cekCsrf();
$id=validId($_POST['id'] ?? null);
if ($id === null) {http_response_code(404);exit('Data tidak ditemukan.');}
// Pertahanan tambahan: JS harus menandai konfirmasi yang dilakukan pengguna.
if (($_POST['konfirmasi'] ?? '') !== '1') {
    http_response_code(422);
    exit('Penghapusan belum dikonfirmasi.');
}
$pdo=getConnection();
if (ambilPendaftarById($pdo,$id) === null) {http_response_code(404);exit('Data tidak ditemukan.');}
hapusPendaftar($pdo,$id);
setFlash('Data peserta berhasil dihapus.');
alihkan('index.php');
