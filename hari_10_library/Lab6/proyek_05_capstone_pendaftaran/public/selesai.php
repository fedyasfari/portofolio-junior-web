<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';
if (($_SESSION['pendaftaran_sukses'] ?? false) !== true) {
    redirect('daftar.php');
}
unset($_SESSION['pendaftaran_sukses']);
$judul = 'Pendaftaran Berhasil';
require __DIR__ . '/../templates/header.php';
?>
<section class="panel" style="max-width:680px;margin:2rem auto">
    <p class="eyebrow">PENDAFTARAN TERSIMPAN</p>
    <h1>Terima kasih, pendaftaran berhasil.</h1>
    <p>Data Anda telah disimpan pada database latihan. Simpan konfirmasi ini untuk keperluan praktik.</p>
    <p class="muted">Fitur unduh PDF resmi dijadwalkan Hari 10 dan belum tersedia pada Sprint 0.</p>
    <a class="button" href="daftar.php">Daftar peserta lain</a>
</section>
<?php require __DIR__ . '/../templates/footer.php'; ?>
