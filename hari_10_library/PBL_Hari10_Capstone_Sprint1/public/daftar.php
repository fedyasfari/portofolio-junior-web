<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';
$pdo = getConnection();
$kelas = daftarKelas($pdo);
$lama = []; $galat = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cekCsrf();
    ['data' => $lama, 'galat' => $galat] = validasiPendaftar($_POST, $pdo);
    if (!$galat) {
        try {
            $id = tambahPendaftar($pdo, $lama);
            $_SESSION['bukti_izin'][$id] = true; // hanya sesi pendaftar sendiri
            setFlash('Pendaftaran berhasil! Simpan bukti PDF Anda.', 'success');
            alihkan('sukses.php?id=' . $id);
        } catch (PDOException $ex) {
            error_log('Pendaftaran gagal: ' . $ex->getMessage());
            $galat['email'] = 'Pendaftaran belum dapat disimpan. Periksa apakah email sudah terdaftar.';
        }
    }
}
$judul = 'Pendaftaran Publik';
$judulTampilan = 'Form Pendaftaran Pelatihan';
$labelSimpan = 'Daftar Sekarang';
require __DIR__ . '/../templates/header.php';
?>
<div class="mb-3"><p class="lead mb-1">Pendaftaran terbuka untuk peserta tanpa login.</p>
<p class="text-muted small">Isi formulir, lalu simpan bukti PDF setelah pendaftaran berhasil.</p></div>
<?php require __DIR__ . '/../templates/_form.php'; ?>
<?php require __DIR__ . '/../templates/footer.php'; ?>
