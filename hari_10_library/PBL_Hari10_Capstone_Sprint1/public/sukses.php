<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';
$id = validId($_GET['id'] ?? null);
if ($id === null || !bolehCetak($id)) {
    http_response_code(403);
    exit('Anda tidak memiliki akses ke bukti pendaftaran ini.');
}
$bukti = ambilBuktiPendaftar(getConnection(), $id);
if ($bukti === null) { http_response_code(404); exit('Data tidak ditemukan.'); }
$judul = 'Pendaftaran Berhasil';
require __DIR__ . '/../templates/header.php';
?>
<section class="card shadow-sm border-0"><div class="card-body p-4">
  <h1 class="h4">Pendaftaran berhasil!</h1>
  <p>Terima kasih, <strong><?= e($bukti['nama']) ?></strong>. Data Anda sudah tersimpan pada kelas <strong><?= e($bukti['nama_kelas']) ?></strong>.</p>
  <p class="text-muted small">Unduh atau cetak PDF sekarang. Tautan hanya tersedia untuk sesi browser ini atau admin yang sudah login.</p>
  <a href="cetak.php?id=<?= (int) $id ?>" target="_blank" rel="noopener" class="btn btn-primary">Cetak Bukti PDF</a>
  <a href="daftar.php" class="btn btn-secondary">Kembali</a>
</div></section>
<?php require __DIR__ . '/../templates/footer.php'; ?>
