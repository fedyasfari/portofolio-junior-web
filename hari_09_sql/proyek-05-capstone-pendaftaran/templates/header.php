<?php $judul = $judul ?? 'Pendaftaran Pelatihan'; ?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judul) ?> — Capstone Sprint 0</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="header">
    <div class="container header-inner">
        <a href="daftar.php" class="brand">Capstone <span>Pendaftaran Pelatihan</span></a>
        <nav aria-label="Navigasi utama">
            <a href="daftar.php">Form Peserta</a>
            <a href="index.php">Daftar Admin (Demo)</a>
            <a href="tambah.php">Tambah (Demo)</a>
        </nav>
    </div>
</header>
<main class="container main">
<div class="alert" role="note">Sprint 0: halaman admin masih simulasi lokal tanpa login. Jangan gunakan di server publik atau isi data pribadi sebenarnya.</div>
<?php if (($pesan = ambilFlash()) !== null): ?>
    <div class="alert success" role="status"><?= e($pesan) ?></div>
<?php endif; ?>
