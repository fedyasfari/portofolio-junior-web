<?php
declare(strict_types=1);

require_once __DIR__ . '/fungsi.php';
$peserta = require __DIR__ . '/data.php';
$salinanAwal = $peserta;
$hasilLulus = filterLulus($peserta);
$hasilUrut  = urutkanNilai($peserta);
$kelompok   = kelompokkanPerKelas($peserta);

// Pengujian sederhana tanpa library tambahan.
$tes = [
    ['Rata-rata 90, 68, 82 adalah 80.0', hitungRataRata($peserta) === 80.0],
    ['Rata-rata array kosong bernilai 0.0', hitungRataRata([]) === 0.0],
    ['Peserta tertinggi adalah Sari (90)', cariTertinggi($peserta)['nama'] === 'Sari'],
    ['Data tertinggi kosong mengembalikan null', cariTertinggi([]) === null],
    ['Filter nilai minimal 70 menghasilkan dua peserta', count($hasilLulus) === 2],
    ['Filter 70 menyisakan Sari dan Citra', array_column($hasilLulus, 'nama') === ['Sari', 'Citra']],
    ['Filter dengan batas 85 menghasilkan Sari', array_column(filterLulus($peserta, 85), 'nama') === ['Sari']],
    ['Filter menggunakan indeks mulai dari 0', array_keys($hasilLulus) === [0, 1]],
    ['Pengurutan menurun: Sari, Citra, Budi', array_column($hasilUrut, 'nama') === ['Sari', 'Citra', 'Budi']],
    ['Pengurutan tidak mengubah data asal', $peserta === $salinanAwal],
    ['Pengelompokan menghasilkan kelas Web dan Data', array_keys($kelompok) === ['Web', 'Data']],
    ['Kelas Web memiliki dua peserta', count($kelompok['Web']) === 2],
    ['Kelas Data memiliki satu peserta', count($kelompok['Data']) === 1],
    ['Konversi grade 90=A, 82=B, 68=D', nilaiKeGrade(90) === 'A' && nilaiKeGrade(82) === 'B' && nilaiKeGrade(68) === 'D'],
    ['HTML berbahaya diubah menjadi teks aman', e('<script>alert("x")</script>') === '&lt;script&gt;alert(&quot;x&quot;)&lt;/script&gt;'],
];

$jumlahBerhasil = count(array_filter($tes, static fn (array $tesKasus): bool => $tesKasus[1]));
$jumlahTes = count($tes);
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengujian Otomatis | Lab 2 PHP</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main class="container">
    <header class="hero">
      <span class="eyebrow">Pengujian tanpa instalasi tambahan</span>
      <h1>Pengujian Otomatis Lab 2</h1>
      <p>Setiap baris membandingkan hasil fungsi dengan hasil yang diharapkan.</p>
      <a href="index.php" class="button">← Kembali ke Hasil Lab 2</a>
    </header>
    <section class="panel">
      <div class="panel-heading">
        <div>
          <span class="eyebrow">Ringkasan uji</span>
          <h2><?= e($jumlahBerhasil) ?> dari <?= e($jumlahTes) ?> pengujian berhasil</h2>
        </div>
        <span class="pill <?= $jumlahBerhasil === $jumlahTes ? 'ok' : 'fail' ?>">
          <?= e($jumlahBerhasil === $jumlahTes ? 'SEMUA LULUS' : 'PERLU PERBAIKAN') ?>
        </span>
      </div>
      <div class="table-wrap">
        <table>
          <thead><tr><th>No.</th><th>Skenario pengujian</th><th>Hasil</th></tr></thead>
          <tbody>
          <?php foreach ($tes as $nomor => $skenario): ?>
            <tr>
              <td><?= e($nomor + 1) ?></td>
              <td><?= e($skenario[0]) ?></td>
              <td><span class="pill <?= $skenario[1] ? 'ok' : 'fail' ?>"><?= e($skenario[1] ? 'LULUS' : 'GAGAL') ?></span></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</body>
</html>
