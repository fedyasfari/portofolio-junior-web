<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';
wajibAdmin();
$pdo = getConnection();
$kelas = daftarKelas($pdo);
$lama=[]; $galat=[];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cekCsrf();
    ['data'=>$lama,'galat'=>$galat] = validasiPendaftar($_POST,$pdo);
    if (!$galat) {
        try {
            tambahPendaftar($pdo,$lama);
            setFlash('Peserta berhasil ditambahkan.');
            alihkan('index.php');
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            $galat['email']='Data belum dapat disimpan. Pastikan email belum terdaftar.';
        }
    }
}
$judul='Tambah Pendaftar';$judulTampilan='Tambah Pendaftar';$labelSimpan='Simpan';
require __DIR__ . '/../templates/header.php';
require __DIR__ . '/../templates/_form.php';
require __DIR__ . '/../templates/footer.php';
