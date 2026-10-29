<?php

declare(strict_types=1);

require_once __DIR__ . '/fungsi.php';

header('Content-Type: text/html; charset=UTF-8');

/** @var list<array{nama:string, lulus:bool, detail:string}> $tes */
$tes = [];
function periksa(string $nama, bool $lulus, string $detail = ''): void
{
    global $tes;
    $tes[] = ['nama' => $nama, 'lulus' => $lulus, 'detail' => $detail];
}

periksa('Rumus BMI 70 kg / 175 cm', abs(hitungBmi(70, 175) - 22.857142857) < 0.00001);
periksa('Kategori BMI 18,4 = Kurang', kategoriBmi(18.4) === 'Kurang');
periksa('Kategori BMI 18,5 = Normal', kategoriBmi(18.5) === 'Normal');
periksa('Kategori BMI 24,9 = Normal', kategoriBmi(24.9) === 'Normal');
periksa('Kategori BMI 25 = Lebih', kategoriBmi(25.0) === 'Lebih');
periksa('Kategori BMI 29,9 = Lebih', kategoriBmi(29.9) === 'Lebih');
periksa('Kategori BMI 30 = Obesitas', kategoriBmi(30.0) === 'Obesitas');

$kosong = prosesFormBmi(['berat' => '', 'tinggi' => '']);
periksa('Form kosong menghasilkan 2 galat', count($kosong['galat']) === 2 && $kosong['hasil'] === null);

$huruf = prosesFormBmi(['berat' => 'abc', 'tinggi' => 'def']);
periksa('Input huruf menghasilkan 2 galat', count($huruf['galat']) === 2);

$negatif = prosesFormBmi(['berat' => '-70', 'tinggi' => '-175']);
periksa('Input negatif menghasilkan 2 galat', count($negatif['galat']) === 2);

$nol = prosesFormBmi(['berat' => '0', 'tinggi' => '0']);
periksa('Input nol ditolak', count($nol['galat']) === 2);

$valid = prosesFormBmi(['berat' => '70', 'tinggi' => '175']);
periksa('Input valid menampilkan 22.9 (Normal)', $valid['hasil'] === '22.9 (Normal)');

$desimal = prosesFormBmi(['berat' => '62.5', 'tinggi' => '165']);
periksa('Input desimal dengan titik diterima', $desimal['hasil'] !== null && $desimal['galat'] === []);

$spasi = prosesFormBmi(['berat' => ' 70 ', 'tinggi' => ' 175 ']);
periksa('Spasi awal/akhir dihapus dengan trim', $spasi['berat'] === '70' && $spasi['tinggi'] === '175');

$script = '<script>alert(1)</script>';
$injeksi = prosesFormBmi(['berat' => $script, 'tinggi' => '175']);
periksa('HTML/script pada input berat ditolak', isset($injeksi['galat']['berat']) && $injeksi['hasil'] === null);
periksa('Script di-escape sebelum dirender', e($script) === '&lt;script&gt;alert(1)&lt;/script&gt;');

$atribut = '\"><img src=x onerror=alert(1)>';
periksa('Tanda kutip dan tag di-escape di value', !str_contains(e($atribut), '<img') && str_contains(e($atribut), '&quot;'));

$arrayTidakValid = prosesFormBmi(['berat' => ['1'], 'tinggi' => '175']);
periksa('Input berat sebagai array tidak menyebabkan error', isset($arrayTidakValid['galat']['berat']));

$gagal = count(array_filter($tes, static fn (array $tesSatu): bool => !$tesSatu['lulus']));
$lulus = count($tes) - $gagal;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pengujian Lab 3 – Kalkulator BMI</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main class="container">
    <p class="eyebrow">LAB 03 / PENGUJIAN</p>
    <h1>Hasil Pengujian Otomatis</h1>
    <p>Pengujian formula BMI, kategori, validasi POST, dan escaping HTML.</p>
    <section class="card">
      <h2><?= e($lulus) ?> / <?= e(count($tes)) ?> tes berhasil</h2>
      <p><?= $gagal === 0 ? 'Semua pengujian lulus.' : e((string) $gagal) . ' pengujian belum lulus.' ?></p>
      <table>
        <thead><tr><th>No.</th><th>Pengujian</th><th>Status</th></tr></thead>
        <tbody>
          <?php foreach ($tes as $nomor => $item): ?>
            <tr>
              <td><?= e($nomor + 1) ?></td>
              <td><?= e($item['nama']) ?></td>
              <td><span class="pill <?= $item['lulus'] ? 'pass' : 'fail' ?>"><?= $item['lulus'] ? 'LULUS' : 'GAGAL' ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <p><a class="test-link" href="index.php">Kembali ke Kalkulator BMI</a></p>
    </section>
  </main>
</body>
</html>
