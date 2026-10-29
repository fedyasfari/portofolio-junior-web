<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';

$judulHalaman = 'Ubah Pendaftar';
$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
$daftarKelas = [];
$data = null;
$errors = [];
$pesanHalaman = null;

if ($id === false || $id < 1) {
    http_response_code(400);
    $pesanHalaman = 'ID pendaftar tidak valid.';
} else {
    try {
        $pdo = getConnection();
        $daftarKelas = semuaKelas($pdo);
        $data = cariPendaftar($pdo, $id);
        if ($data === null) {
            http_response_code(404);
            $pesanHalaman = 'Pendaftar tidak ditemukan.';
        }
    } catch (Throwable $error) {
        error_log($error->getMessage());
        $pesanHalaman = 'Tidak dapat mengambil data dari database.';
    }
}

if ($pesanHalaman === null && $_SERVER['REQUEST_METHOD'] === 'POST') {
    periksaCsrf();
    foreach (['nama', 'email', 'no_hp', 'id_kelas', 'tanggal_daftar'] as $key) {
        $data[$key] = is_string($_POST[$key] ?? null) ? $_POST[$key] : '';
    }

    $idKelasTersedia = array_map('intval', array_column($daftarKelas, 'id_kelas'));
    $errors = validasiFormPendaftar($data, $idKelasTersedia);
    if ($errors === []) {
        try {
            ubahPendaftar($pdo, $id, $data);
            simpanPesan('Pendaftar berhasil diperbarui.');
            redirect('index.php');
        } catch (PDOException $error) {
            $errors['database'] = pesanGagalDatabase($error);
        }
    }
}

$action = $id !== false ? 'ubah.php?id=' . $id : 'ubah.php';
require __DIR__ . '/../templates/header.php';
?>
<div class="page-heading"><div><p class="eyebrow">UPDATE</p><h1>Ubah Pendaftar</h1><p class="muted">Perbarui data pendaftar berdasarkan ID.</p></div></div>
<?php if ($pesanHalaman !== null): ?>
    <div class="alert error"><?= e($pesanHalaman) ?></div>
    <a class="button secondary" href="index.php">Kembali</a>
<?php else: ?>
    <?php require __DIR__ . '/_form.php'; ?>
<?php endif; ?>
<?php require __DIR__ . '/../templates/footer.php'; ?>
