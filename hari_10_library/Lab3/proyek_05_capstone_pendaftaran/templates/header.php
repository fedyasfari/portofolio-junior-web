<?php /* templates/header.php - Lab 3: Bootstrap + SweetAlert2 */ ?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judul ?? 'Pendaftaran Pelatihan') ?></title>
    <!-- Bootstrap CSS dari Lab 2 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous"
    >
    <!-- SweetAlert2 CSS (versi dipasangkan dengan skrip di footer) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25/dist/sweetalert2.min.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-primary" aria-label="Navigasi utama">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="index.php">Pendaftaran Pelatihan</a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menuCapstone"
                aria-controls="menuCapstone"
                aria-expanded="false"
                aria-label="Buka atau tutup menu"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuCapstone">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Daftar</a></li>
                    <li class="nav-item"><a class="nav-link" href="tambah.php">Tambah</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="container py-4 flex-grow-1">
    <?php if ($pesan = ambilFlash()): ?>
        <!-- Tetap terlihat bila JavaScript atau CDN gagal. Saat Swal siap, JS menggantinya dengan toast. -->
        <div id="flash" class="alert alert-success" role="status" data-pesan="<?= e($pesan) ?>">
            <?= e($pesan) ?>
        </div>
    <?php endif; ?>
