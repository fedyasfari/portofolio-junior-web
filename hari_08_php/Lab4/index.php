<?php
declare(strict_types=1);
require_once __DIR__ . '/layout.php';
bukaHalaman('Lab 4 — Form GET dan Akses File', 'index.php');
?>
<p class="lead">Selamat datang! Latihan ini mengolah data peserta yang sama dengan Lab 2 dan menyimpannya ke berkas, tanpa menggunakan database.</p>
<div class="cards">
  <a class="card link-card" href="cari.php"><span class="card-symbol">⌕</span><h2>Pencarian GET</h2><p>Cari sebagian nama menggunakan <code>stripos()</code>.</p><span class="cta">Buka pencarian →</span></a>
  <a class="card link-card" href="lihat-log.php"><span class="card-symbol">≡</span><h2>Log Kunjungan</h2><p>20 kunjungan terakhir: waktu, IP, kata kunci.</p><span class="cta">Lihat log →</span></a>
  <a class="card link-card" href="json.php"><span class="card-symbol">{ }</span><h2>Kelola JSON</h2><p>Buat, baca, tambahkan peserta, dan simpan kembali.</p><span class="cta">Kelola peserta →</span></a>
  <a class="card link-card" href="csv.php"><span class="card-symbol">▤</span><h2>Ekspor / Impor CSV</h2><p>Tulis CSV dengan <code>fputcsv()</code>, baca dengan <code>fgetcsv()</code>.</p><span class="cta">Kelola CSV →</span></a>
</div>
<section class="card">
<h2>Data awal peserta</h2>
<?php tabelPeserta(dataAwal()); ?>
<p class="hint">Folder <code>data/</code> dibuat otomatis oleh program jika belum ada. File disimpan relatif terhadap direktori <code>lab-04/</code>.</p>
</section>
<?php tutupHalaman(); ?>
