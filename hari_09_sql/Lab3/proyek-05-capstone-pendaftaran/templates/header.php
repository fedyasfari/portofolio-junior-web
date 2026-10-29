<?php $judul = $judul ?? 'Pendaftaran Pelatihan'; ?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judul) ?> — Lab 3 CRUD</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="header">
    <div class="container header-inner">
        <a href="index.php" class="brand">Lab 3 <span>CRUD Pendaftaran</span></a>
        <nav aria-label="Navigasi utama">
            <a href="index.php">Daftar Pendaftar</a>
            <a href="tambah.php">Tambah</a>
            <a href="injeksi.php">Demo SQL Injection Lab 2</a>
        </nav>
    </div>
</header>
<main class="container main">
<?php if (($pesan = ambilFlash()) !== null): ?>
    <div class="alert success" role="status"><?= e($pesan) ?></div>
<?php endif; ?>
