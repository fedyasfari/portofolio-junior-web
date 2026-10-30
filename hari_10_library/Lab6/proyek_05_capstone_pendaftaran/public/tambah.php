<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';

$pdo = getConnection();
$kelas = daftarKelas($pdo);
$lama = ['nama' => '', 'email' => '', 'no_hp' => '', 'alamat' => '', 'kelas_id' => 0];
$galat = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cekCsrf();
    $hasil = validasiPendaftar($_POST, $pdo, null);
    $lama = $hasil['data'];
    $galat = $hasil['galat'];
    if ($galat === []) {
        try {
            tambahPendaftar($pdo, $lama);
            setFlash('Pendaftar berhasil ditambahkan.');
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

$judul = 'Tambah Pendaftar';
require __DIR__ . '/../templates/header.php';
?>
<div class="page-heading"><div>
    <p class="eyebrow">CREATE</p>
    <h1>Tambah Pendaftar</h1>
    <p class="muted">Isi formulir lalu klik Simpan. Data divalidasi oleh PHP.</p>
</div></div>
<?php require __DIR__ . '/_form.php'; ?>
<?php require __DIR__ . '/../templates/footer.php'; ?>
