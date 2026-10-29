<?php

declare(strict_types=1);

require_once __DIR__ . '/fungsi.php';

header('Content-Type: text/html; charset=UTF-8');

$metode = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$data = [
    'berat' => '',
    'tinggi' => '',
    'galat' => [],
    'bmi' => null,
    'kategori' => null,
    'hasil' => null,
];

if ($metode === 'POST') {
    $data = prosesFormBmi($_POST);
}

$berat = $data['berat'];
$tinggi = $data['tinggi'];
$galat = $data['galat'];
$hasil = $data['hasil'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Lab 3 PHP Dasar: Form POST, validasi, kalkulator BMI, dan htmlspecialchars.">
  <title>Lab 3 | Kalkulator BMI</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main class="container">
    <div class="heading">
      <p class="eyebrow">PHP DASAR / HARI 08 / LAB 03</p>
      <h1>Kalkulator BMI</h1>
      <p>Latihan memproses form HTML dengan metode <code>POST</code>, memvalidasi angka, dan menampilkan hasil secara aman.</p>
    </div>

    <section class="card" aria-labelledby="form-judul">
      <div class="section-header">
        <h2 id="form-judul">Masukkan data</h2>
        <span class="chip">Metode POST</span>
      </div>
      <form method="post" action="" novalidate>
        <div class="form-group">
          <label for="berat">Berat (kg)</label>
          <input
            type="text"
            inputmode="decimal"
            id="berat"
            name="berat"
            placeholder="Contoh: 70"
            value="<?= e($berat) ?>"
            aria-describedby="berat-petunjuk<?= isset($galat['berat']) ? ' berat-galat' : '' ?>"
            aria-invalid="<?= isset($galat['berat']) ? 'true' : 'false' ?>"
          >
          <small id="berat-petunjuk" class="hint">Gunakan titik untuk desimal, misalnya 62.5.</small>
          <?php if (isset($galat['berat'])): ?>
            <p class="error" id="berat-galat" role="alert"><?= e($galat['berat']) ?></p>
          <?php endif; ?>
        </div>

        <div class="form-group">
          <label for="tinggi">Tinggi (cm)</label>
          <input
            type="text"
            inputmode="decimal"
            id="tinggi"
            name="tinggi"
            placeholder="Contoh: 175"
            value="<?= e($tinggi) ?>"
            aria-describedby="tinggi-petunjuk<?= isset($galat['tinggi']) ? ' tinggi-galat' : '' ?>"
            aria-invalid="<?= isset($galat['tinggi']) ? 'true' : 'false' ?>"
          >
          <small id="tinggi-petunjuk" class="hint">Tinggi dimasukkan dalam sentimeter (cm).</small>
          <?php if (isset($galat['tinggi'])): ?>
            <p class="error" id="tinggi-galat" role="alert"><?= e($galat['tinggi']) ?></p>
          <?php endif; ?>
        </div>

        <button type="submit">Hitung BMI</button>
      </form>

      <?php if ($hasil !== null): ?>
        <div class="result" role="status" aria-live="polite">
          <p class="result-label">Hasil BMI</p>
          <p class="result-value"><?= e($hasil) ?></p>
          <p class="result-explain">Berat <?= e($berat) ?> kg, tinggi <?= e($tinggi) ?> cm.</p>
        </div>
      <?php elseif ($metode === 'POST' && $galat !== []): ?>
        <p class="validation-note" role="status">Perbaiki isian yang ditandai, lalu klik <strong>Hitung BMI</strong> kembali.</p>
      <?php endif; ?>
    </section>

    <section class="card info" aria-labelledby="info-judul">
      <h2 id="info-judul">Kategori BMI yang digunakan dalam tugas</h2>
      <table>
        <thead><tr><th>Nilai BMI</th><th>Kategori</th></tr></thead>
        <tbody>
          <tr><td>Kurang dari 18,5</td><td>Kurang</td></tr>
          <tr><td>18,5 sampai kurang dari 25</td><td>Normal</td></tr>
          <tr><td>25 sampai kurang dari 30</td><td>Lebih</td></tr>
          <tr><td>30 atau lebih</td><td>Obesitas</td></tr>
        </tbody>
      </table>
      <p class="hint">Catatan: ini proyek latihan PHP. BMI adalah indikator sederhana, bukan diagnosis kesehatan; interpretasinya tidak sama untuk semua kelompok usia/kondisi.</p>
      <a class="test-link" href="uji.php">Buka halaman pengujian otomatis</a>
    </section>
    <footer>Lab 3 — Form POST dan Validasi • PHP 8+</footer>
  </main>
</body>
</html>
