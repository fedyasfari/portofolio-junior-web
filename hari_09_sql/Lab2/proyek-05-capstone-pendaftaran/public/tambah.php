<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';

$judulHalaman = 'Tambah Pendaftar';
$action = 'tambah.php';
$data = ['nama' => '', 'email' => '', 'no_hp' => '', 'id_kelas' => '', 'tanggal_daftar' => date('Y-m-d')];
$errors = [];
$daftarKelas = [];
$koneksiGagal = false;

try {
    $pdo = getConnection();
    $daftarKelas = semuaKelas($pdo);
} catch (Throwable $error) {
    error_log($error->getMessage());
    $koneksiGagal = true;
    $errors['database'] = 'Tidak dapat terhubung ke database. Periksa pengaturan koneksi dan MySQL.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$koneksiGagal) {
    periksaCsrf();
    foreach (['nama', 'email', 'no_hp', 'id_kelas', 'tanggal_daftar'] as $key) {
        $data[$key] = is_string($_POST[$key] ?? null) ? $_POST[$key] : '';
    }

    $idKelasTersedia = array_map('intval', array_column($daftarKelas, 'id_kelas'));
    $errors = validasiFormPendaftar($data, $idKelasTersedia);

    if ($errors === []) {
        try {
            tambahPendaftar($pdo, $data);
            simpanPesan('Pendaftar berhasil ditambahkan.');
            redirect('index.php');
        } catch (PDOException $error) {
            $errors['database'] = pesanGagalDatabase($error);
        }
    }
}

require __DIR__ . '/../templates/header.php';
?>
<div class="page-heading"><div><p class="eyebrow">CREATE</p><h1>Tambah Pendaftar</h1><p class="muted">Formulir ini menyimpan data dengan prepared statement PDO.</p></div></div>
<?php if ($koneksiGagal): ?>
    <div class="alert error"><?= e($errors['database']) ?></div>
<?php else: ?>
    <?php require __DIR__ . '/_form.php'; ?>
<?php endif; ?>
<?php require __DIR__ . '/../templates/footer.php'; ?>
