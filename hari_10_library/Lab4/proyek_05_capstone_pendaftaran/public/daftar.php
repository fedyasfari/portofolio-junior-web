<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';

$pdo = getConnection();
$kelas = daftarKelas($pdo);
$lama = ['nama' => '', 'email' => '', 'no_hp' => '', 'alamat' => '', 'kelas_id' => 0];
$galat = [];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    cekCsrf();
    $hasil = validasiPendaftar($_POST, $pdo, null);
    $lama = $hasil['data'];
    $galat = $hasil['galat'];
    if ($galat === []) {
        try {
            tambahPendaftar($pdo, $lama);
            $_SESSION['pendaftaran_sukses'] = true;
            redirect('selesai.php');
        } catch (PDOException $e) {
            if (kegagalanEmailUnik($e)) {
                $galat['email'] = 'Email sudah terdaftar.';
            } else {
                throw $e;
            }
        }
    }
}

$judul = 'Pendaftaran Pelatihan';
require __DIR__ . '/../templates/header.php';
?>
<div class="page-heading"><div>
    <p class="eyebrow">PESERTA · SPRINT 0</p>
    <h1>Form Pendaftaran Pelatihan</h1>
    <p class="muted">Pilih kelas lalu isi identitas fiktif untuk latihan di XAMPP lokal.</p>
</div></div>
<?php require __DIR__ . '/_form.php'; ?>
<?php require __DIR__ . '/../templates/footer.php'; ?>
