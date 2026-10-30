<?php
// public/index.php — Lab 3: gunakan form-hapus dan data-nama untuk SweetAlert2.
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';

$pdo = getConnection();
$kata = trim((string) ($_GET['q'] ?? ''));
$perHalaman = 10;
$total = hitungPendaftar($pdo, $kata);
$jumlahHalaman = max(1, (int) ceil($total / $perHalaman));
$halaman = min($jumlahHalaman, max(1, (int) ($_GET['hal'] ?? 1)));
$daftar = ambilPendaftar($pdo, $kata, $perHalaman, ($halaman - 1) * $perHalaman);
$judul = 'Daftar Pendaftar';
require __DIR__ . '/../templates/header.php';
?>
<h1 class="h3 mb-3">Daftar Pendaftar</h1>
<form method="get" class="row g-2 align-items-end mb-3">
    <div class="col-sm-8 col-md-6">
        <label class="form-label" for="q">Cari nama</label>
        <input class="form-control" id="q" name="q" value="<?= e($kata) ?>" placeholder="Ketik nama peserta">
    </div>
    <div class="col-auto">
        <button class="btn btn-primary" type="submit">Cari</button>
    </div>
</form>
<?php if ($daftar === []): ?>
    <div class="alert alert-info">Tidak ada data.</div>
<?php else: ?>
    <div class="table-responsive">
        <!-- Jangan aktifkan DataTables dulu: index ini masih memakai pagination PHP. -->
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr><th>Nama</th><th>Email</th><th>No. HP</th><th>Kelas</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($daftar as $p): ?>
                    <tr>
                        <td><?= e($p['nama']) ?></td>
                        <td><?= e($p['email']) ?></td>
                        <td><?= e($p['no_hp']) ?></td>
                        <td><?= e($p['nama_kelas']) ?></td>
                        <td class="text-nowrap">
                            <a class="btn btn-sm btn-secondary" href="ubah.php?id=<?= (int) $p['id'] ?>">Ubah</a>
                            <form method="post" action="hapus.php" class="form-hapus d-inline" data-nama="<?= e($p['nama']) ?>">
                                <!-- WAJIB: server memverifikasi token di hapus.php. -->
                                <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
                                <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                                <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
<nav aria-label="Halaman" class="mt-3">
    <ul class="pagination flex-wrap">
        <?php for ($i = 1; $i <= $jumlahHalaman; $i++): ?>
            <li class="page-item <?= $i === $halaman ? 'active' : '' ?>">
                <a class="page-link" href="?hal=<?= $i ?>&amp;q=<?= urlencode($kata) ?>" <?= $i === $halaman ? 'aria-current="page"' : '' ?>><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
<?php require __DIR__ . '/../templates/footer.php'; ?>
