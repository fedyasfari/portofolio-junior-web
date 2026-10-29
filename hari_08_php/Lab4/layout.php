<?php
declare(strict_types=1);
require_once __DIR__ . '/fungsi.php';

function bukaHalaman(string $judul, string $aktif): void
{
    $navigasi = [
        ['file' => 'index.php', 'label' => 'Beranda'],
        ['file' => 'cari.php', 'label' => 'Pencarian GET'],
        ['file' => 'lihat-log.php', 'label' => 'Log Pengunjung'],
        ['file' => 'json.php', 'label' => 'JSON'],
        ['file' => 'csv.php', 'label' => 'CSV'],
        ['file' => 'uji.php', 'label' => 'Uji Program'],
    ];
    ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($judul) ?> | Lab 4 PHP</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="site-header">
    <div class="container">
      <div class="brand"><span class="logo">PHP</span><div><strong>Lab 4 · Akses File</strong><small>Hari 08 · Pemrograman Web</small></div></div>
      <nav aria-label="Navigasi utama">
        <?php foreach ($navigasi as $item): ?>
          <a class="<?= $aktif === $item['file'] ? 'active' : '' ?>" href="<?= e($item['file']) ?>"><?= e($item['label']) ?></a>
        <?php endforeach; ?>
      </nav>
    </div>
  </header>
  <main class="container">
    <h1><?= e($judul) ?></h1>
    <?php
}

function tutupHalaman(): void
{
    ?>
  </main>
  <footer class="footer"><div class="container">Latihan PHP 8+ · Aplikasi lokal untuk pembelajaran · HTML di-escape pada output dinamis.</div></footer>
</body>
</html>
    <?php
}

function tabelPeserta(array $peserta): void
{
    if ($peserta === []) {
        echo '<p class="empty">Tidak ada peserta untuk ditampilkan.</p>';
        return;
    }
    ?>
    <div class="table-wrap">
      <table>
        <thead><tr><th>No.</th><th>Nama</th><th>Kelas</th><th>Nilai</th><th>Grade</th></tr></thead>
        <tbody>
          <?php foreach ($peserta as $nomor => $orang): ?>
            <tr>
              <td><?= e($nomor + 1) ?></td>
              <td><?= e($orang['nama']) ?></td>
              <td><?= e($orang['kelas']) ?></td>
              <td><?= e($orang['nilai']) ?></td>
              <td><span class="pill"><?= e(gradeNilai((int) $orang['nilai'])) ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php
}
