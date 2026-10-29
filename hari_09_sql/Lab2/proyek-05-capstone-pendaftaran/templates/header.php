<?php
// $judulHalaman dapat diatur halaman pemanggil.
$judulHalaman = $judulHalaman ?? 'Aplikasi Pendaftaran';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judulHalaman) ?> — Lab 2 PDO</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="header">
    <div class="container header-inner">
        <a href="index.php" class="brand">Lab 2 <span>PDO & Pendaftaran</span></a>
        <nav aria-label="Navigasi utama">
            <a href="index.php">Daftar</a>
            <a href="tambah.php">Tambah</a>
            <a href="injeksi.php">Demo SQL Injection</a>
        </nav>
    </div>
</header>
<main class="container main">
