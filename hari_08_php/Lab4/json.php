<?php
declare(strict_types=1);
require_once __DIR__ . '/layout.php';

$pesan = '';
$jenisPesan = 'success';
$galat = [];
$nama = '';
$kelas = 'Web';
$nilai = '';

if (!siapkanFolderData()) {
    $pesan = 'Folder data/ tidak dapat dibuat. Periksa izin tulis di lokasi proyek.';
    $jenisPesan = 'error';
} elseif (!is_file(DIREKTORI_DATA . '/peserta.json')) {
    if (simpanPesertaJson(dataAwal())) {
        $pesan = 'File peserta.json belum ada, sehingga dibuat otomatis menggunakan data awal.';
    } else {
        $pesan = 'Gagal membuat peserta.json. Periksa izin folder data/.';
        $jenisPesan = 'error';
    }
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $aksi = is_string($_POST['aksi'] ?? null) ? $_POST['aksi'] : '';
    if ($aksi === 'pulihkan') {
        if (simpanPesertaJson(dataAwal())) {
            $pesan = 'JSON berhasil dipulihkan ke tiga peserta awal.';
            $jenisPesan = 'success';
        } else {
            $pesan = 'Gagal memulihkan JSON. Periksa izin file.';
            $jenisPesan = 'error';
        }
    } elseif ($aksi === 'tambah') {
        $nama = is_string($_POST['nama'] ?? null) ? trim($_POST['nama']) : '';
        $kelas = is_string($_POST['kelas'] ?? null) ? trim($_POST['kelas']) : '';
        $nilai = is_string($_POST['nilai'] ?? null) ? trim($_POST['nilai']) : '';

        if (!preg_match("/^[\\p{L}][\\p{L} .'-]{0,79}$/u", $nama)) {
            $galat['nama'] = 'Nama wajib 1–80 karakter berupa huruf, spasi, titik, apostrof, atau tanda hubung.';
        }
        if (!in_array($kelas, ['Web', 'Data'], true)) {
            $galat['kelas'] = 'Pilih kelas Web atau Data.';
        }
        if (filter_var($nilai, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 100]]) === false) {
            $galat['nilai'] = 'Nilai harus bilangan bulat dari 0 sampai 100.';
        }

        if ($galat === []) {
            $ditambah = tambahPesertaJson(['nama' => $nama, 'kelas' => $kelas, 'nilai' => (int) $nilai]);
            $pesan = $ditambah['pesan'];
            $jenisPesan = $ditambah['ok'] ? 'success' : 'error';
            if ($ditambah['ok']) {
                $nama = '';
                $nilai = '';
                $kelas = 'Web';
            }
        }
    }
}

$hasilBaca = bacaPesertaJson();
bukaHalaman('Simpan, Baca, Tambah JSON', 'json.php');
?>
<p class="lead">Saat pertama dibuka, file <code>data/peserta.json</code> dibuat dari tiga peserta awal. Kemudian Anda dapat menambah satu peserta lewat formulir dan melihat hasilnya.</p>
<?php if ($pesan !== ''): ?><div class="notice <?= e($jenisPesan) ?>"><?= e($pesan) ?></div><?php endif; ?>
<?php if ($hasilBaca['error'] !== null): ?>
  <div class="notice error"><strong>Gagal membaca JSON:</strong> <?= e($hasilBaca['error']) ?><p>Perbaiki file secara manual, atau pulihkan ke data awal. Pemulihan akan menimpa isi file yang rusak.</p></div>
  <form method="post" action="json.php"><input type="hidden" name="aksi" value="pulihkan"><button type="submit" class="danger-btn">Pulihkan JSON ke Data Awal</button></form>
<?php else: ?>
<section class="card">
  <h2>Tambah satu peserta baru</h2>
  <form action="json.php" method="post" class="form-grid" novalidate>
    <input type="hidden" name="aksi" value="tambah">
    <div><label for="nama">Nama peserta</label><input id="nama" name="nama" maxlength="80" value="<?= e($nama) ?>" placeholder="Contoh: Deni" required><?php if (isset($galat['nama'])): ?><p class="field-error"><?= e($galat['nama']) ?></p><?php endif; ?></div>
    <div><label for="kelas">Kelas</label><select id="kelas" name="kelas"><option value="Web" <?= $kelas === 'Web' ? 'selected' : '' ?>>Web</option><option value="Data" <?= $kelas === 'Data' ? 'selected' : '' ?>>Data</option></select><?php if (isset($galat['kelas'])): ?><p class="field-error"><?= e($galat['kelas']) ?></p><?php endif; ?></div>
    <div><label for="nilai">Nilai (0–100)</label><input id="nilai" type="number" min="0" max="100" step="1" name="nilai" value="<?= e($nilai) ?>" required><?php if (isset($galat['nilai'])): ?><p class="field-error"><?= e($galat['nilai']) ?></p><?php endif; ?></div>
    <div class="form-action"><button type="submit">Tambah dan Simpan JSON</button></div>
  </form>
</section>
<section class="card"><div class="section-heading"><h2>Isi peserta.json</h2><span class="counter"><?= e(count($hasilBaca['data'])) ?> peserta</span></div><?php tabelPeserta($hasilBaca['data']); ?></section>
<?php endif; ?>
<?php tutupHalaman(); ?>
