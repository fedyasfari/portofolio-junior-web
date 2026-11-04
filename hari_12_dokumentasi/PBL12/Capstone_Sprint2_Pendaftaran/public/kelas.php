<?php

declare(strict_types=1);
/**
 * CRUD kelas untuk admin — fitur tambahan finalisasi Hari 12.
 * Perhatikan: ini halaman baru, bukan pengganti halaman pendaftar.
 * Wajib dites dengan database uji sebelum dipakai untuk data penting.
 */
require_once __DIR__ . '/../src/bootstrap.php';
wajibLogin();
$pdo = getConnection();
$galat = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    cekCsrf();
    $aksi = (string) ($_POST['aksi'] ?? '');
    $id = validId($_POST['id'] ?? null);
    try {
        if ($aksi === 'hapus') {
            if ($id === null) {
                throw new InvalidArgumentException('ID kelas tidak valid.');
            }
            // Foreign key pendaftar.kelas_id membatasi hapus kelas yang digunakan.
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('SELECT id FROM kelas WHERE id = :id FOR UPDATE');
            $stmt->execute(['id' => $id]);
            if ($stmt->fetchColumn() === false) {
                throw new InvalidArgumentException('Kelas tidak ditemukan.');
            }
            $cek = $pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE kelas_id = :id');
            $cek->execute(['id' => $id]);
            if ((int) $cek->fetchColumn() > 0) {
                throw new InvalidArgumentException('Kelas masih memiliki peserta; tidak boleh dihapus.');
            }
            $pdo->prepare('DELETE FROM kelas WHERE id = :id')->execute(['id' => $id]);
            $pdo->commit();
            setFlash('Kelas berhasil dihapus.');
            redirect('kelas.php');
        }
        if ($aksi !== 'tambah' && $aksi !== 'ubah') {
            throw new InvalidArgumentException('Aksi tidak dikenal.');
        }
        if ($aksi === 'ubah' && $id === null) {
            throw new InvalidArgumentException('ID kelas tidak valid.');
        }
        $nama = trim((string) ($_POST['nama_kelas'] ?? ''));
        $deskripsi = trim((string) ($_POST['deskripsi'] ?? ''));
        $kuota = filter_var($_POST['kuota'] ?? null, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 0, 'max_range' => 100000],
        ]);
        if (mb_strlen($nama) < 3 || mb_strlen($nama) > 100) {
            throw new InvalidArgumentException('Nama kelas harus 3–100 karakter.');
        }
        if (mb_strlen($deskripsi) > 255) {
            throw new InvalidArgumentException('Deskripsi maksimal 255 karakter.');
        }
        if ($kuota === false) {
            throw new InvalidArgumentException('Kuota harus bilangan bulat 0–100000.');
        }

        if ($aksi === 'tambah') {
            $stmt = $pdo->prepare('INSERT INTO kelas (nama_kelas, deskripsi, kuota) VALUES (:nama, :deskripsi, :kuota)');
            $stmt->execute(['nama' => $nama, 'deskripsi' => ($deskripsi === '' ? null : $deskripsi), 'kuota' => $kuota]);
            setFlash('Kelas baru berhasil ditambahkan.');
            redirect('kelas.php');
        }

        // Lock kelas, kemudian tolak kuota yang lebih kecil daripada jumlah peserta sekarang.
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('SELECT id FROM kelas WHERE id = :id FOR UPDATE');
        $stmt->execute(['id' => $id]);
        if ($stmt->fetchColumn() === false) {
            throw new InvalidArgumentException('Kelas yang diubah tidak ditemukan.');
        }
        $cek = $pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE kelas_id = :id');
        $cek->execute(['id' => $id]);
        if ((int) $cek->fetchColumn() > (int) $kuota) {
            throw new InvalidArgumentException('Kuota baru tidak boleh lebih kecil dari jumlah peserta terdaftar.');
        }
        $stmt = $pdo->prepare('UPDATE kelas SET nama_kelas = :nama, deskripsi = :deskripsi, kuota = :kuota WHERE id = :id');
        $stmt->execute(['nama' => $nama, 'deskripsi' => ($deskripsi === '' ? null : $deskripsi), 'kuota' => $kuota, 'id' => $id]);
        $pdo->commit();
        setFlash('Kelas berhasil diperbarui.');
        redirect('kelas.php');
    } catch (InvalidArgumentException $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        $galat = $e->getMessage();
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        error_log('Operasi kelas gagal: ' . $e->getMessage());
        $galat = 'Operasi kelas tidak dapat disimpan. Periksa log server.';
    }
}

// Data untuk form edit. Hitungan peserta dibaca, tidak diubah.
$kelas = $pdo->query('SELECT k.id, k.nama_kelas, k.deskripsi, k.kuota,
    (SELECT COUNT(*) FROM pendaftar p WHERE p.kelas_id = k.id) AS terisi
    FROM kelas k ORDER BY k.nama_kelas ASC')->fetchAll();
$judul = 'Kelola Kelas';
require __DIR__ . '/../templates/header.php';
?>
<main class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h1 class="h3 mb-0">Kelola Kelas</h1>
        <a href="index.php" class="btn btn-outline-secondary">Kembali ke peserta</a>
    </div>
    <?php if ($galat !== ''): ?><div class="alert alert-danger" role="alert"><?= e($galat) ?></div><?php endif; ?>
    <section class="card mb-4">
        <div class="card-body">
            <h2 class="h5">Tambah Kelas</h2>
            <form method="post" class="row g-2 align-items-end">
                <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
                <input type="hidden" name="aksi" value="tambah">
                <div class="col-md-4"><label class="form-label" for="namaBaru">Nama</label><input class="form-control" id="namaBaru" name="nama_kelas" maxlength="100" minlength="3" required></div>
                <div class="col-md-4"><label class="form-label" for="descBaru">Deskripsi</label><input class="form-control" id="descBaru" name="deskripsi" maxlength="255"></div>
                <div class="col-md-2"><label class="form-label" for="kuotaBaru">Kuota</label><input class="form-control" type="number" id="kuotaBaru" name="kuota" min="0" max="100000" value="20" required></div>
                <div class="col-md-2"><button type="submit" class="btn btn-primary w-100">Tambah</button></div>
            </form>
        </div>
    </section>

    <section class="card">
        <div class="card-body">
            <h2 class="h5">Daftar Kelas dan Pengelolaan</h2>
            <?php foreach ($kelas as $baris): ?>
                <div class="border-top py-3">
                    <form method="post" class="row g-2 align-items-end">
                        <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
                        <input type="hidden" name="aksi" value="ubah">
                        <input type="hidden" name="id" value="<?= (int) $baris['id'] ?>">
                        <div class="col-md-4">
                            <label class="form-label">Nama kelas #<?= (int) $baris['id'] ?></label>
                            <input class="form-control" name="nama_kelas" value="<?= e($baris['nama_kelas']) ?>" minlength="3" maxlength="100" required>
                        </div>
                        <div class="col-md-3"><label class="form-label">Deskripsi</label><input class="form-control" name="deskripsi" value="<?= e($baris['deskripsi'] ?? '') ?>" maxlength="255"></div>
                        <div class="col-md-2"><label class="form-label">Kuota</label><input class="form-control" type="number" name="kuota" min="0" max="100000" value="<?= (int) $baris['kuota'] ?>" required></div>
                        <div class="col-md-1"><span class="small text-muted">Isi: <?= (int) $baris['terisi'] ?></span></div>
                        <div class="col-md-2"><button class="btn btn-outline-primary w-100" type="submit">Simpan</button></div>
                    </form>
                    <form method="post" class="mt-2" onsubmit="return confirm('Hapus kelas yang tidak memiliki peserta?');">
                        <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
                        <input type="hidden" name="aksi" value="hapus">
                        <input type="hidden" name="id" value="<?= (int) $baris['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger" <?= (int)$baris['terisi'] > 0 ? 'disabled' : '' ?>>Hapus kelas kosong</button>
                    </form>
                </div>
            <?php endforeach; ?>
            <?php if ($kelas === []): ?><p class="text-muted">Belum ada kelas.</p><?php endif; ?>
        </div>
    </section>
</main>
<?php require __DIR__ . '/../templates/footer.php'; ?>