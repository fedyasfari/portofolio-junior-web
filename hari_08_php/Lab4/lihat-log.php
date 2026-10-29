<?php
declare(strict_types=1);
require_once __DIR__ . '/layout.php';

$path = DIREKTORI_DATA . '/log.txt';
$adaBerkas = is_file($path);
$log = bacaLogTerakhir(20);
bukaHalaman('20 Log Kunjungan Terakhir', 'lihat-log.php');
?>
<p class="lead">Setiap membuka <code>cari.php</code>, satu baris waktu | IP | kata kunci ditambahkan ke <code>data/log.txt</code>. Halaman ini tidak menambah catatan.</p>
<section class="card">
  <div class="section-heading"><h2>Isi log (terbaru dahulu)</h2><span class="counter"><?= e(count($log)) ?> baris</span></div>
  <?php if (!$adaBerkas): ?>
    <div class="notice warning">File <code>log.txt</code> belum tersedia. Buka <a href="cari.php">halaman pencarian</a> dahulu.</div>
  <?php elseif ($log === []): ?>
    <div class="notice warning">Belum ada baris log yang dapat ditampilkan.</div>
  <?php else: ?>
    <div class="table-wrap">
      <table><thead><tr><th>No.</th><th>Waktu | IP | Kata Kunci</th></tr></thead><tbody>
      <?php foreach ($log as $i => $baris): ?>
        <tr><td><?= e($i + 1) ?></td><td class="mono"><?= e($baris) ?></td></tr>
      <?php endforeach; ?>
      </tbody></table>
    </div>
  <?php endif; ?>
  <p class="hint">Akses log hanya di lingkungan lokal. Jangan mempublikasikan IP/kata kunci pengguna secara terbuka.</p>
</section>
<?php tutupHalaman(); ?>
