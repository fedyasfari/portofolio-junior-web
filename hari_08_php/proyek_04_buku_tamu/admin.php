<?php
declare(strict_types=1);

// Halaman admin hanya untuk latihan lokal; tidak untuk internet publik tanpa HTTPS.
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');
session_start();
require_once __DIR__ . '/functions.php';

$galat = '';
$berhasil = '';
$aksi = nilaiTeks($_POST, 'aksi');
$adaPassword = is_file(FILE_ADMIN);

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!csrfBenar(nilaiTeks($_POST, 'csrf'))) {
        $galat = 'Formulir kedaluwarsa. Muat ulang halaman.';
    } elseif ($aksi === 'setup' && !$adaPassword && aksesLokal()) {
        $password = nilaiTeks($_POST, 'password');
        $konfirmasi = nilaiTeks($_POST, 'konfirmasi');
        if (strlen($password) < 10 || $password !== $konfirmasi) {
            $galat = 'Kata sandi minimal 10 karakter dan konfirmasi harus sama.';
        } elseif (!siapkanFolderData()) {
            $galat = 'Folder data tidak dapat dibuat.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            // Mode 'x' mencegah pengaturan ulang tanpa sengaja jika file sudah ada.
            $fp = fopen(FILE_ADMIN, 'x');
            if ($fp === false) {
                $galat = 'File kata sandi admin sudah ada atau tidak bisa dibuat.';
            } else {
                $berhasilTulis = fwrite($fp, $hash) !== false;
                fclose($fp);
                if (!$berhasilTulis) {
                    $galat = 'Gagal menyimpan kata sandi.';
                } else {
                    session_regenerate_id(true);
                    $_SESSION['admin_masuk'] = true;
                    header('Location: admin.php?status=siap', true, 303);
                    exit;
                }
            }
        }
    } elseif ($aksi === 'login' && $adaPassword) {
        $hash = file_get_contents(FILE_ADMIN);
        if ($hash !== false && password_verify(nilaiTeks($_POST, 'password'), $hash)) {
            session_regenerate_id(true);
            $_SESSION['admin_masuk'] = true;
            header('Location: admin.php', true, 303);
            exit;
        }
        $galat = 'Kata sandi salah.';
    } elseif ($aksi === 'logout') {
        $_SESSION['admin_masuk'] = false;
        session_regenerate_id(true);
        header('Location: admin.php', true, 303);
        exit;
    } elseif ($aksi === 'hapus' && adminMasuk()) {
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        $alasan = null;
        if ($id !== false && hapusTamu((int) $id, $alasan)) {
            header('Location: admin.php?status=dihapus', true, 303);
            exit;
        }
        $galat = $alasan ?? 'ID pesan tidak valid.';
    } else {
        $galat = 'Permintaan tidak diperbolehkan.';
    }
}

$daftar = [];
if (adminMasuk()) {
    try {
        $daftar = array_reverse(ambilSemuaTamu());
    } catch (RuntimeException $e) {
        $galat = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrasi Buku Tamu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="hero"><div class="container"><p class="eyebrow">PBL HARI 8 · TANTANGAN</p><h1>🔐 Administrasi Buku Tamu</h1><p>Hapus lembut pesan dan ekspor data CSV setelah login.</p></div></header>
<main class="admin-container">
    <section class="panel">
        <p><a href="index.php">← Kembali ke Buku Tamu</a></p>
        <?php if ($galat !== ''): ?><p class="alert alert-danger" role="alert"><?= e($galat) ?></p><?php endif; ?>
        <?php if (nilaiTeks($_GET, 'status') === 'siap'): ?><p class="alert alert-success">Kata sandi admin berhasil dibuat.</p><?php endif; ?>
        <?php if (nilaiTeks($_GET, 'status') === 'dihapus'): ?><p class="alert alert-success">Pesan berhasil disembunyikan dari daftar publik (soft delete).</p><?php endif; ?>
        <?php if (!$adaPassword): ?>
            <?php if (!aksesLokal()): ?>
                <p class="alert alert-danger">Pengaturan awal admin hanya boleh dilakukan dari localhost.</p>
            <?php else: ?>
                <h2>Pengaturan Admin Pertama Kali</h2>
                <p class="muted">Buat password admin sendiri, minimal 10 karakter. Password disimpan sebagai hash dalam folder data yang diblokir oleh .htaccess.</p>
                <form action="admin.php" method="post">
                    <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
                    <input type="hidden" name="aksi" value="setup">
                    <div class="field"><label for="password">Kata sandi baru</label><input id="password" name="password" type="password" minlength="10" required autocomplete="new-password"></div>
                    <div class="field"><label for="konfirmasi">Ulangi kata sandi</label><input id="konfirmasi" name="konfirmasi" type="password" minlength="10" required autocomplete="new-password"></div>
                    <button class="button" type="submit">Buat Admin</button>
                </form>
            <?php endif; ?>
        <?php elseif (!adminMasuk()): ?>
            <h2>Login Admin</h2>
            <form action="admin.php" method="post">
                <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
                <input type="hidden" name="aksi" value="login">
                <div class="field"><label for="password">Kata sandi</label><input id="password" name="password" type="password" required autocomplete="current-password"></div>
                <button class="button" type="submit">Masuk</button>
            </form>
        <?php else: ?>
            <h2>Daftar Pesan</h2>
            <div class="admin-actions">
                <a class="button" href="export-csv.php">Unduh CSV</a>
                <form method="post" action="admin.php" class="inline-form">
                    <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
                    <input type="hidden" name="aksi" value="logout">
                    <button type="submit" class="button button-danger">Keluar Admin</button>
                </form>
            </div>
            <p class="muted">Menghapus pesan hanya mengisi field <code>dihapus_pada</code>, bukan menghapusnya permanen dari JSON.</p>
            <?php if ($daftar === []): ?>
                <p class="empty-state">Belum ada data tamu.</p>
            <?php else: ?>
                <div class="admin-list-wrap"><table class="admin-list">
                    <thead><tr><th>ID</th><th>Nama / Email</th><th>Pesan</th><th>Waktu</th><th>Status / Aksi</th></tr></thead>
                    <tbody>
                    <?php foreach ($daftar as $tamu): ?>
                        <tr>
                            <td><?= e((int) ($tamu['id'] ?? 0)) ?></td>
                            <td><strong><?= e((string) ($tamu['nama'] ?? '')) ?></strong><br><small><?= e((string) ($tamu['email'] ?? '')) ?></small></td>
                            <td><?= nl2br(e((string) ($tamu['pesan'] ?? ''))) ?></td>
                            <td><?= e((string) ($tamu['waktu'] ?? '')) ?></td>
                            <td>
                                <?php if (!empty($tamu['dihapus_pada'])): ?>
                                    <span class="muted">Dihapus lembut</span>
                                <?php else: ?>
                                    <form method="post" action="admin.php" class="inline-form" onsubmit="return confirm('Sembunyikan pesan ini?')">
                                        <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
                                        <input type="hidden" name="aksi" value="hapus">
                                        <input type="hidden" name="id" value="<?= e((int) ($tamu['id'] ?? 0)) ?>">
                                        <button class="button button-danger" type="submit">Hapus</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table></div>
            <?php endif; ?>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
