<?php
declare(strict_types=1);
require_once __DIR__ . '/layout.php';

$kataKunci = is_string($_GET['q'] ?? null) ? trim($_GET['q']) : '';
$semuaPeserta = dataAwal();
$pesanData = '';
if (is_file(DIREKTORI_DATA . '/peserta.json')) {
    $hasilJson = bacaPesertaJson();
    if ($hasilJson['error'] === null) {
        $semuaPeserta = $hasilJson['data'];
    } else {
        $pesanData = 'JSON tidak dapat dipakai (' . $hasilJson['error'] . '), sehingga pencarian memakai data awal.';
    }
}
$hasilPencarian = cariPeserta($semuaPeserta, $kataKunci);
$ip = (string) ($_SERVER['REMOTE_ADDR'] ?? 'Tidak diketahui');
$logTersimpan = catatKunjungan($ip, $kataKunci);

bukaHalaman('Pencarian Peserta (GET)', 'cari.php');
?>
<p class="lead">Ketik sebagian nama, misalnya <strong>ar</strong> untuk mencari Sari. Huruf besar-kecil tidak dibedakan.</p>
<form class="card search-form" action="cari.php" method="get">
  <label for="q">Kata kunci nama peserta</label>
  <div class="input-row">
    <input id="q" name="q" type="search" maxlength="200" placeholder="Contoh: sa, BU, cit" value="<?= e($kataKunci) ?>">
    <button type="submit">Cari</button>
    <a class="btn-secondary" href="cari.php">Reset</a>
  </div>
  <p class="hint">Contoh alamat: <code>cari.php?q=sa</code>. Mengosongkan pencarian akan menampilkan seluruh peserta.</p>
</form>
<?php if ($pesanData !== ''): ?><div class="notice warning"><?= e($pesanData) ?></div><?php endif; ?>
<?php if (!$logTersimpan): ?>
  <div class="notice error">Gagal menulis log. Periksa izin akses folder <code>data/</code>.</div>
<?php endif; ?>
<section class="card">
  <div class="section-heading"><h2>Hasil pencarian</h2><span class="counter"><?= e(count($hasilPencarian)) ?> peserta</span></div>
  <?php if ($kataKunci !== '' && $hasilPencarian === []): ?>
    <div class="notice warning">Tidak ada peserta dengan nama yang mengandung <strong><?= e($kataKunci) ?></strong>.</div>
  <?php else: ?>
    <?php tabelPeserta($hasilPencarian); ?>
  <?php endif; ?>
</section>
<?php tutupHalaman(); ?>
