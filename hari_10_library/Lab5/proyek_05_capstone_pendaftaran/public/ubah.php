<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';

$pdo = getConnection();
$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]);
$pendaftar = $id === false || $id === null ? null : ambilPendaftarById($pdo, $id);
if ($pendaftar === null) {
    http_response_code(404);
    exit('HTTP 404 — Data pendaftar tidak ditemukan.');
}

$kelas = daftarKelas($pdo);
$lama = $pendaftar;
$galat = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cekCsrf();
    $hasil = validasiPendaftar($_POST, $pdo, $id);
    $lama = $hasil['data'];
    $galat = $hasil['galat'];
    if ($galat === []) {
        try {
            ubahPendaftar($pdo, $id, $lama);
            setFlash('Data pendaftar berhasil diubah.');
            redirect('index.php');
        } catch (PDOException $e) {
            if (kegagalanEmailUnik($e)) {
                $galat['email'] = 'Email sudah terdaftar.';
            } else {
                throw $e;
            }
        }
    }
}

$judul = 'Ubah Pendaftar';
require __DIR__ . '/../templates/header.php';
?>
<div class="page-heading"><div>
    <p class="eyebrow">UPDATE</p>
    <h1>Ubah Pendaftar #<?= (int) $id ?></h1>
    <p class="muted">Ubah nilai yang diperlukan, lalu klik Simpan.</p>
</div></div>
<?php require __DIR__ . '/_form.php'; ?>
<?php require __DIR__ . '/../templates/footer.php'; ?>
