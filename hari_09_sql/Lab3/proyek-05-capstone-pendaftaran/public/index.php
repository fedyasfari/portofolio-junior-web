<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';

$pdo = getConnection();
$kata = is_string($_GET['q'] ?? null) ? trim($_GET['q']) : '';
$kata = substr($kata, 0, 100);
$perHalaman = 10;
$total = hitungPendaftar($pdo, $kata);
$jumlahHalaman = max(1, (int) ceil($total / $perHalaman));
$nomorHalaman = filter_var($_GET['hal'] ?? '1', FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]);
$halaman = min($jumlahHalaman, $nomorHalaman === false ? 1 : $nomorHalaman);
$daftar = ambilPendaftar($pdo, $kata, $perHalaman, ($halaman - 1) * $perHalaman);
$judul = 'Daftar Pendaftar';
require __DIR__ . '/../templates/header.php';
?>
<div class="page-heading">
    <div>
        <p class="eyebrow">READ · SEARCH · PAGINATION</p>
        <h1>Daftar Pendaftar</h1>
        <p class="muted">Data kursus dari MySQL dengan PDO, JOIN, dan paginasi.</p>
    </div>
    <a class="button" href="tambah.php">+ Tambah Pendaftar</a>
</div>
<section class="panel">
    <form class="search-form" method="get" action="index.php">
        <div class="search-field">
            <label for="q">Cari nama pendaftar</label>
            <input id="q" name="q" value="<?= e($kata) ?>" placeholder="Contoh: Andi">
        </div>
        <button class="button" type="submit">Cari</button>
        <a class="button secondary" href="index.php">Reset</a>
    </form>
    <p class="small">Ditemukan <strong><?= $total ?></strong> pendaftar. Halaman <?= $halaman ?> dari <?= $jumlahHalaman ?>.</p>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>ID</th><th>Nama</th><th>Email</th><th>No. HP</th><th>Kelas</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php if ($daftar === []): ?>
                    <tr><td colspan="6">Tidak ada data yang cocok.</td></tr>
                <?php endif; ?>
                <?php foreach ($daftar as $p): ?>
                    <tr>
                        <td><?= (int) $p['id'] ?></td>
                        <td><?= e($p['nama']) ?></td>
                        <td><?= e($p['email']) ?></td>
                        <td><?= e($p['no_hp']) ?></td>
                        <td><?= e($p['nama_kelas']) ?></td>
                        <td>
                            <div class="actions">
                                <a class="button secondary small-button" href="ubah.php?id=<?= (int) $p['id'] ?>">Ubah</a>
                                <form method="post" action="hapus.php" onsubmit="return confirm('Yakin menghapus pendaftar ini?')">
                                    <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
                                    <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                                    <button class="button danger small-button" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php if ($jumlahHalaman > 1): ?>
        <nav class="pagination" aria-label="Halaman daftar pendaftar">
            <?php for ($i = 1; $i <= $jumlahHalaman; $i++): ?>
                <a class="page-link<?= $i === $halaman ? ' active' : '' ?>"
                   <?= $i === $halaman ? 'aria-current="page"' : '' ?>
                   href="?hal=<?= $i ?>&amp;q=<?= e(urlencode($kata)) ?>"><?= $i ?></a>
            <?php endfor; ?>
        </nav>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/../templates/footer.php'; ?>
