<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/functions.php';

$galat = [];
$lama = ['nama' => '', 'email' => '', 'pesan' => ''];
$galatUmum = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $hasil = validasiTamu($_POST);
    $lama = $hasil['data'];
    $galat = $hasil['galat'];

    if (!csrfBenar(nilaiTeks($_POST, 'csrf'))) {
        $galatUmum = 'Sesi formulir tidak valid. Muat ulang halaman dan coba lagi.';
    } elseif ($galat === []) {
        $alasan = null;
        if (simpanTamu($hasil['data'], $alasan)) {
            // PRG: setelah POST sukses, redirect agar refresh tidak mengirim ulang.
            header('Location: index.php?status=sukses', true, 303);
            exit;
        }
        $galatUmum = $alasan ?? 'Gagal menyimpan data. Silakan coba lagi.';
    }
}

$kata = trim(nilaiTeks($_GET, 'q'));
$nomorHalaman = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$nomorHalaman = ($nomorHalaman === false) ? 1 : (int) $nomorHalaman;

try {
    $semua = ambilSemuaTamu();
    $daftarTamu = array_reverse(cariTamu($semua, $kata));
} catch (RuntimeException $e) {
    $daftarTamu = [];
    $galatUmum = $e->getMessage();
}

$totalTamu = count($daftarTamu);
$totalHalaman = max(1, (int) ceil($totalTamu / PER_HALAMAN));
$nomorHalaman = min($nomorHalaman, $totalHalaman);
$tamuHalaman = halamanTamu($daftarTamu, $nomorHalaman);

function urlHalaman(int $halaman, string $kata): string
{
    return 'index.php?' . http_build_query(['q' => $kata, 'page' => $halaman]);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buku Tamu Digital Sekolah</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="hero">
    <div class="container">
        <p class="eyebrow">PBL HARI 8 · PROYEK 4</p>
        <h1>📖 Buku Tamu Digital Sekolah</h1>
        <p>Silakan tinggalkan nama, email, dan pesan. Sampaikan kesan atau saran Anda.</p>
    </div>
</header>
<main class="container">
    <div class="grid">
        <section class="panel" aria-labelledby="judul-form">
            <h2 id="judul-form">✍️ Isi Buku Tamu</h2>
            <p class="muted">Semua kolom wajib diisi. Email tidak dipublikasikan.</p>

            <?php if (nilaiTeks($_GET, 'status') === 'sukses'): ?>
                <p class="alert alert-success" role="status">Terima kasih, pesan Anda sudah tersimpan.</p>
            <?php endif; ?>
            <?php if ($galatUmum !== ''): ?>
                <p class="alert alert-danger" role="alert"><?= e($galatUmum) ?></p>
            <?php endif; ?>

            <form action="index.php" method="post" novalidate>
                <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">

                <div class="field">
                    <label for="nama">Nama lengkap</label>
                    <input id="nama" name="nama" type="text" maxlength="100" required
                           value="<?= e($lama['nama']) ?>" autocomplete="name"
                           aria-invalid="<?= isset($galat['nama']) ? 'true' : 'false' ?>">
                    <?php if (isset($galat['nama'])): ?>
                        <small class="error"><?= e($galat['nama']) ?></small>
                    <?php endif; ?>
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" maxlength="254" required
                           value="<?= e($lama['email']) ?>" autocomplete="email"
                           aria-invalid="<?= isset($galat['email']) ? 'true' : 'false' ?>">
                    <?php if (isset($galat['email'])): ?>
                        <small class="error"><?= e($galat['email']) ?></small>
                    <?php endif; ?>
                </div>

                <div class="field">
                    <label for="pesan">Pesan</label>
                    <textarea id="pesan" name="pesan" rows="5" maxlength="<?= e(MAKS_PESAN) ?>" required
                              aria-invalid="<?= isset($galat['pesan']) ? 'true' : 'false' ?>"><?= e($lama['pesan']) ?></textarea>
                    <small class="muted">Maksimal <?= e(MAKS_PESAN) ?> karakter.</small>
                    <?php if (isset($galat['pesan'])): ?>
                        <small class="error"><?= e($galat['pesan']) ?></small>
                    <?php endif; ?>
                </div>
                <button class="button" type="submit">Kirim Pesan</button>
                <small class="muted block">Satu pesan diperbolehkan setiap <?= e(JEDA_KIRIM) ?> detik per IP.</small>
            </form>
        </section>

        <section class="panel" aria-labelledby="judul-daftar">
            <div class="section-head">
                <div>
                    <h2 id="judul-daftar">💬 Daftar Tamu</h2>
                    <p class="muted"><?= e($totalTamu) ?> pesan ditemukan</p>
                </div>
            </div>
            <form action="index.php" method="get" class="search-form" role="search">
                <label for="q">Cari berdasarkan nama</label>
                <div class="search-row">
                    <input id="q" type="search" name="q" placeholder="Misalnya: sari"
                           value="<?= e($kata) ?>">
                    <button type="submit" class="button">Cari</button>
                </div>
                <?php if ($kata !== ''): ?>
                    <a href="index.php" class="text-link">Reset pencarian</a>
                <?php endif; ?>
            </form>

            <?php if ($tamuHalaman === []): ?>
                <p class="empty-state"><?= $kata !== '' ? 'Tidak ada tamu dengan nama tersebut.' : 'Belum ada pesan. Jadilah pengunjung pertama!' ?></p>
            <?php else: ?>
                <div class="guest-list">
                    <?php foreach ($tamuHalaman as $tamu): ?>
                        <article class="guest-card">
                            <div class="guest-top">
                                <h3><?= e((string) ($tamu['nama'] ?? '')) ?></h3>
                                <span class="pill">#<?= e((int) ($tamu['id'] ?? 0)) ?></span>
                            </div>
                            <small class="muted">🕒 <?= e((string) ($tamu['waktu'] ?? '')) ?> WIB</small>
                            <p class="guest-message"><?= e((string) ($tamu['pesan'] ?? '')) ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($totalHalaman > 1): ?>
                <nav class="pagination" aria-label="Navigasi halaman buku tamu">
                    <?php if ($nomorHalaman > 1): ?>
                        <a href="<?= e(urlHalaman($nomorHalaman - 1, $kata)) ?>">← Sebelumnya</a>
                    <?php endif; ?>
                    <span>Halaman <?= e($nomorHalaman) ?> / <?= e($totalHalaman) ?></span>
                    <?php if ($nomorHalaman < $totalHalaman): ?>
                        <a href="<?= e(urlHalaman($nomorHalaman + 1, $kata)) ?>">Berikutnya →</a>
                    <?php endif; ?>
                </nav>
            <?php endif; ?>
        </section>
    </div>
    <footer>Proyek pembelajaran PHP berbasis file · <a href="admin.php">Halaman Admin</a></footer>
</main>
</body>
</html>
