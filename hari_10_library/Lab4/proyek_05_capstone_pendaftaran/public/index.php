<?php
// public/index.php — Lab 4: DataTables mengambil SEMUA baris di awal.
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';

$pdo = getConnection();
$daftar = ambilPendaftar($pdo, '', 1000, 0); // Ambil semua baris untuk DataTables.
$fiturCetakAda = is_file(__DIR__ . '/cetak.php'); // Tidak buat link rusak bila file cetak belum ada.
$judul = 'Daftar Pendaftar';
require __DIR__ . '/../templates/header.php';
?>
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <h1 class="h3 mb-0">Daftar Pendaftar</h1>
    <a href="tambah.php" class="btn btn-primary">+ Tambah Pendaftar</a>
</div>
<p class="text-muted small mb-3">
    Pencarian, pengurutan, dan pembagian halaman dilakukan oleh DataTables di browser.
</p>
<div class="table-responsive">
    <table id="tabelPendaftar" class="table table-striped table-hover align-middle w-100">
        <thead class="table-light">
            <tr>
                <th scope="col">Nama</th>
                <th scope="col">Email</th>
                <th scope="col">No. HP</th>
                <th scope="col">Kelas</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($daftar as $p): ?>
                <tr>
                    <td><?= e((string) $p['nama']) ?></td>
                    <td><?= e((string) $p['email']) ?></td>
                    <td><?= e((string) $p['no_hp']) ?></td>
                    <td><?= e((string) $p['nama_kelas']) ?></td>
                    <td class="text-nowrap">
                        <a class="btn btn-sm btn-secondary"
                            href="ubah.php?id=<?= (int) $p['id'] ?>">Ubah</a>
                        <?php if ($fiturCetakAda): ?>
                            <a class="btn btn-sm btn-outline-primary"
                                href="cetak.php?id=<?= (int) $p['id'] ?>"
                                target="_blank" rel="noopener">Cetak</a>
                        <?php endif; ?>
                        <form method="post" action="hapus.php"
                            class="form-hapus d-inline"
                            data-nama="<?= e((string) $p['nama']) ?>">
                            <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
                            <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/../templates/footer.php'; ?>