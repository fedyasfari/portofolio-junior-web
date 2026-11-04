<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';
$pdo = getConnection();
$kelas = daftarKelas($pdo);
$lama = []; $galat = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cekCsrf();
    ['data' => $lama, 'galat' => $galat] = validasiPendaftar($_POST, $pdo);
    if (!$galat) {
        try {
            daftarkanDenganKuota($pdo, $lama);
            setFlash('Pendaftaran berhasil. Simpan bukti Anda; pencetakan PDF dikelola admin.', 'success');
            redirect('daftar.php?status=sukses');
        } catch (KuotaPenuhException $ex) {
            $galat['kelas_id'] = $ex->getMessage();
        } catch (KelasTidakDitemukanException $ex) {
            $galat['kelas_id'] = $ex->getMessage();
        } catch (PDOException $ex) {
            error_log('Pendaftaran gagal: ' . $ex->getMessage());
            $galat['email'] = 'Pendaftaran belum dapat disimpan. Periksa apakah email sudah terdaftar.';
        }
    }
}
$judul = 'Pendaftaran Publik';
$judulTampilan = 'Form Pendaftaran Pelatihan';
$labelSimpan = 'Daftar Sekarang';
require __DIR__ . '/../templates/header.php';
?>
<div class="mb-3"><p class="lead mb-1">Pendaftaran terbuka untuk peserta tanpa login.</p>
<p class="text-muted small">Isi formulir untuk mendaftar. Bukti PDF hanya dapat dicetak oleh admin.</p></div>
<?php if (($_GET['status'] ?? '') === 'sukses'): ?><div class="alert alert-success">Pendaftaran berhasil disimpan.</div><?php endif; ?>
<?php require __DIR__ . '/../templates/_form.php'; ?>
<?php require __DIR__ . '/../templates/footer.php'; ?>
