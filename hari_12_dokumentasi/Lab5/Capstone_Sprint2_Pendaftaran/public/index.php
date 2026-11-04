<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';
wajibLogin();
$cari = trim((string)($_GET['q'] ?? ''));
$cari = substr($cari, 0, 100);
$daftar = $cari === '' ? ambilSemuaPendaftar(getConnection()) : cariPendaftar(getConnection(), $cari);
$judul = 'Daftar Admin';
require __DIR__ . '/../templates/header.php';
?>
<div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
  <h1 class="h3 mb-0">Daftar Pendaftar (Admin)</h1>
  <a href="tambah.php" class="btn btn-primary">+ Tambah Pendaftar</a>
</div>
<form method="get" action="index.php" class="row g-2 align-items-center mb-3">
 <div class="col-sm-8 col-md-5"><label for="q" class="form-label">Cari server (nama/email)</label>
 <input class="form-control" id="q" name="q" value="<?= e($cari) ?>" placeholder="Nama atau email"></div>
 <div class="col-auto align-self-end"><button type="submit" class="btn btn-outline-primary">Cari</button></div>
 <div class="col-auto align-self-end"><a class="btn btn-link" href="index.php">Reset</a></div>
</form>
<div class="card border-0 shadow-sm"><div class="card-body">
<div class="table-responsive">
  <table id="tabelPendaftar" class="table table-striped table-hover align-middle w-100">
    <thead class="table-light"><tr>
      <th scope="col">Nama</th><th scope="col">Email</th><th scope="col">No. HP</th><th scope="col">Kelas</th><th scope="col">Aksi</th>
    </tr></thead>
    <tbody>
      <?php foreach ($daftar as $p): ?>
      <tr>
        <td><?= e($p['nama']) ?></td><td><?= e($p['email']) ?></td>
        <td><?= e($p['no_hp']) ?></td><td><?= e($p['nama_kelas']) ?></td>
        <td class="text-nowrap">
          <a class="btn btn-sm btn-secondary" href="ubah.php?id=<?= (int) $p['id'] ?>">Ubah</a>
          <a class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener"
             href="cetak.php?id=<?= (int) $p['id'] ?>">Cetak</a>
          <form method="post" action="hapus.php" class="form-hapus d-inline" data-nama="<?= e($p['nama']) ?>">
            <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
            <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
            <input type="hidden" name="konfirmasi" value="0">
            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div></div></div>
<?php require __DIR__ . '/../templates/footer.php'; ?>
