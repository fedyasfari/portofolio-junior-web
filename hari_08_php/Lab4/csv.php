<?php
declare(strict_types=1);
require_once __DIR__ . '/layout.php';

$pesan = '';
$jenisPesan = 'success';
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $aksi = is_string($_POST['aksi'] ?? null) ? $_POST['aksi'] : '';
    if ($aksi === 'ekspor') {
        $peserta = dataAwal();
        if (is_file(DIREKTORI_DATA . '/peserta.json')) {
            $json = bacaPesertaJson();
            if ($json['error'] !== null) {
                $pesan = 'Tidak bisa mengekspor: ' . $json['error'];
                $jenisPesan = 'error';
            } else {
                $peserta = $json['data'];
            }
        }
        if ($jenisPesan !== 'error') {
            if (eksporPesertaCsv($peserta)) {
                $pesan = 'Berhasil mengekspor ' . count($peserta) . ' peserta ke data/peserta.csv.';
            } else {
                $pesan = 'Gagal menyimpan peserta.csv. Periksa izin folder data/.';
                $jenisPesan = 'error';
            }
        }
    }
}
$hasilImpor = imporPesertaCsv();
bukaHalaman('Ekspor dan Impor CSV', 'csv.php');
?>
<p class="lead">Klik Ekspor untuk menyimpan peserta dalam file CSV. Halaman lalu mengimpor CSV kembali memakai <code>fgetcsv()</code> dan menampilkan hasilnya sebagai tabel HTML.</p>
<?php if ($pesan !== ''): ?><div class="notice <?= e($jenisPesan) ?>"><?= e($pesan) ?></div><?php endif; ?>
<section class="card">
  <h2>1. Ekspor daftar peserta</h2>
  <p>Data diambil dari <code>peserta.json</code> jika file valid; jika JSON belum ada, digunakan data awal dari Lab 2.</p>
  <form method="post" action="csv.php"><input type="hidden" name="aksi" value="ekspor"><button type="submit">Ekspor CSV Sekarang</button></form>
</section>
<section class="card">
  <div class="section-heading"><h2>2. Hasil impor peserta.csv</h2><span class="counter"><?= e(count($hasilImpor['data'] ?? [])) ?> peserta</span></div>
  <?php if ($hasilImpor['error'] !== null): ?><div class="notice warning"><?= e($hasilImpor['error']) ?></div><?php else: ?><?php tabelPeserta($hasilImpor['data']); ?><?php endif; ?>
  <p class="hint">Untuk menguji file hilang, ganti nama <code>data/peserta.csv</code> lalu refresh. Untuk menguji impor, ubah data CSV yang valid dan refresh lagi.</p>
</section>
<?php tutupHalaman(); ?>
