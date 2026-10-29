<?php
declare(strict_types=1);

require_once __DIR__ . '/fungsi.php';
$peserta = require __DIR__ . '/data.php';

// Panggil keempat fungsi yang diminta.
$rataRata  = hitungRataRata($peserta);
$tertinggi = cariTertinggi($peserta);
$lulus     = filterLulus($peserta);
$urut      = urutkanNilai($peserta);
$kelompok  = kelompokkanPerKelas($peserta);
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lab 2 | Fungsi dan Array Asosiatif</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main class="container">
    <header class="hero">
      <span class="eyebrow">Hari 08 · PHP Dasar</span>
      <h1>Lab 2 — Fungsi dan Array Asosiatif</h1>
      <p>Hasil pengolahan data peserta menggunakan fungsi bertipe, <code>array_filter()</code>, <code>usort()</code>, dan pengelompokan kelas.</p>
      <a href="uji.php" class="button">Buka Halaman Pengujian →</a>
    </header>

    <section class="stats" aria-label="Ringkasan data">
      <article class="stat">
        <span>Jumlah peserta</span>
        <strong><?= e(count($peserta)) ?></strong>
        <small>Orang dalam data awal</small>
      </article>
      <article class="stat">
        <span>Rata-rata nilai</span>
        <strong><?= e(number_format($rataRata, 2, ',', '.')) ?></strong>
        <small>Hasil hitungRataRata()</small>
      </article>
      <article class="stat">
        <span>Nilai tertinggi</span>
        <strong><?= e($tertinggi === null ? '-' : $tertinggi['nilai']) ?></strong>
        <small><?= e($tertinggi === null ? 'Tidak ada peserta' : $tertinggi['nama']) ?></small>
      </article>
      <article class="stat">
        <span>Peserta lulus</span>
        <strong><?= e(count($lulus)) ?></strong>
        <small>Nilai minimal 70</small>
      </article>
    </section>

    <section class="panel">
      <div class="panel-heading">
        <div>
          <span class="eyebrow">Data sumber</span>
          <h2>1. Semua Peserta</h2>
        </div>
        <span class="pill"><?= e(count($peserta)) ?> peserta</span>
      </div>
      <?php $daftarTampil = $peserta; require __DIR__ . '/tabel.php'; ?>
    </section>

    <section class="panel">
      <div class="panel-heading">
        <div>
          <span class="eyebrow">filterLulus($peserta, 70)</span>
          <h2>2. Peserta Lulus</h2>
        </div>
        <span class="pill"><?= e(count($lulus)) ?> peserta</span>
      </div>
      <?php $daftarTampil = $lulus; require __DIR__ . '/tabel.php'; ?>
    </section>

    <section class="panel">
      <div class="panel-heading">
        <div>
          <span class="eyebrow">urutkanNilai($peserta)</span>
          <h2>3. Urutan Nilai Tertinggi</h2>
        </div>
        <span class="pill">Besar → kecil</span>
      </div>
      <?php $daftarTampil = $urut; require __DIR__ . '/tabel.php'; ?>
      <p class="footnote">Data awal tetap pada urutannya: Sari, Budi, Citra.</p>
    </section>

    <section class="panel">
      <div class="panel-heading">
        <div>
          <span class="eyebrow">kelompokkanPerKelas($peserta)</span>
          <h2>4. Kelompok Per Kelas</h2>
        </div>
        <span class="pill"><?= e(count($kelompok)) ?> kelas</span>
      </div>
      <?php foreach ($kelompok as $namaKelas => $anggota): ?>
        <h3>Kelas <?= e($namaKelas) ?> <span class="subtle">(<?= e(count($anggota)) ?> peserta)</span></h3>
        <?php $daftarTampil = $anggota; require __DIR__ . '/tabel.php'; ?>
      <?php endforeach; ?>
    </section>

    <footer>Lab 2 PHP Dasar · Semua data dinamis di-escape dengan htmlspecialchars().</footer>
  </main>
</body>
</html>
