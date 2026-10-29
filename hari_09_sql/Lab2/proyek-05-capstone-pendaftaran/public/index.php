<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';

$judulHalaman = 'Daftar Pendaftar';
$data = [];
$pesanError = null;

try {
    $data = semuaPendaftar(getConnection());
} catch (Throwable $error) {
    error_log($error->getMessage());
    $pesanError = 'Gagal memuat data. Periksa MySQL, nama database, dan config/config.php.';
}

require __DIR__ . '/../templates/header.php';
?>
<div class="page-heading">
    <div>
        <p class="eyebrow">APLIKASI CRUD</p>
        <h1>Daftar Pendaftar</h1>
        <p class="muted">Menampilkan data dari dua tabel menggunakan PDO dan JOIN.</p>
    </div>
    <a class="button" href="tambah.php">+ Tambah Pendaftar</a>
</div>
<?php if (($pesan = ambilPesan()) !== null): ?>
    <div class="alert success" role="status"><?= e($pesan) ?></div>
<?php endif; ?>
<?php if ($pesanError !== null): ?>
    <div class="alert error" role="alert"><?= e($pesanError) ?></div>
<?php else: ?>
    <section class="panel">
        <p class="small">Jumlah pendaftar: <strong><?= count($data) ?></strong></p>
        <div class="table-wrap">
            <table>
                <thead>
                <tr><th>ID</th><th>Nama</th><th>Email</th><th>HP</th><th>Kelas</th><th>Tanggal</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                <?php if ($data === []): ?>
                    <tr><td colspan="7">Belum ada pendaftar. Tambahkan data terlebih dahulu.</td></tr>
                <?php endif; ?>
                <?php foreach ($data as $item): ?>
                    <tr>
                        <td><?= (int) $item['id_pendaftar'] ?></td>
                        <td><?= e($item['nama']) ?></td>
                        <td><?= e($item['email']) ?></td>
                        <td><?= e($item['no_hp']) ?></td>
                        <td><?= e($item['nama_kelas']) ?></td>
                        <td><?= e($item['tanggal_daftar']) ?></td>
                        <td class="actions">
                            <a class="button secondary small-button" href="ubah.php?id=<?= (int) $item['id_pendaftar'] ?>">Ubah</a>
                            <form method="post" action="hapus.php" onsubmit="return confirm('Hapus pendaftar ini?')">
                                <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
                                <input type="hidden" name="id" value="<?= (int) $item['id_pendaftar'] ?>">
                                <button class="button danger small-button" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
<?php endif; ?>
<?php require __DIR__ . '/../templates/footer.php'; ?>
