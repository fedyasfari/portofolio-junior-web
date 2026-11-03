<?php
// $judul ditentukan oleh halaman pemanggil. Sumber library dipatok ke versi tertentu.
$flash = ambilFlash();
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($judul ?? 'Pendaftaran Pelatihan') ?></title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25/dist/sweetalert2.min.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-md navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="daftar.php">Pendaftaran Pelatihan</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuUtama"
            aria-controls="menuUtama" aria-expanded="false" aria-label="Buka atau tutup menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menuUtama">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="daftar.php">Daftar Publik</a></li>
        <?php if (sudahLogin()): ?>
        <li class="nav-item"><a class="nav-link" href="index.php">Data Admin</a></li>
        <li class="nav-item"><a class="nav-link" href="tambah.php">Tambah</a></li>
        <li class="nav-item">
          <form method="post" action="logout.php" class="d-inline">
             <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
             <button class="nav-link btn btn-link" type="submit">Keluar</button>
          </form>
        </li>
        <?php else: ?>
        <li class="nav-item"><a class="nav-link" href="login.php">Login Admin</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<main class="container py-4 flex-grow-1">
<?php if ($flash !== null): ?>
  <?php $tipeFlash = in_array($flash['tipe'] ?? '', ['success','danger','warning','info'], true) ? $flash['tipe'] : 'info'; ?>
  <div id="flash" class="alert alert-<?= e($tipeFlash) ?>" role="status"
       data-tipe="<?= e($tipeFlash) ?>" data-pesan="<?= e($flash['pesan'] ?? '') ?>">
    <?= e($flash['pesan'] ?? '') ?>
  </div>
<?php endif; ?>
