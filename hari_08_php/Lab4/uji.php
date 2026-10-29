<?php
declare(strict_types=1);
require_once __DIR__ . '/layout.php';

$uji = [];
function periksa(string $nama, bool $lulus): void
{
    global $uji;
    $uji[] = ['nama' => $nama, 'lulus' => $lulus];
}

// Folder sementara mencegah hasil pengujian menghapus/mengubah file data proyek.
$folderUji = sys_get_temp_dir() . '/php_lab4_' . bin2hex(random_bytes(5));
$siap = siapkanFolderData($folderUji);
periksa('mkdir() membuat folder yang belum ada', $siap && is_dir($folderUji));
$awal = dataAwal();
periksa('Data awal sesuai tugas (3 peserta)', count($awal) === 3 && $awal[0]['nama'] === 'Sari');
periksa('stripos() menemukan sebagian nama', array_column(cariPeserta($awal, 'ar'), 'nama') === ['Sari']);
periksa('Pencarian tidak peka huruf kapital', array_column(cariPeserta($awal, 'BU'), 'nama') === ['Budi']);
periksa('Pencarian tanpa hasil mengembalikan array kosong', cariPeserta($awal, 'xyz') === []);
periksa('Kata kunci kosong menampilkan semua', count(cariPeserta($awal, '')) === 3);
periksa('htmlspecialchars mengamankan HTML berbahaya', e('<script>alert(1)</script>') === '&lt;script&gt;alert(1)&lt;/script&gt;');
periksa('Pemisah/newline tidak menyisipkan baris log palsu', amanUntukLog("foo|bar\nberikut") === 'foo bar berikut');

if ($siap) {
    periksa('Log dicatat dengan APPEND + LOCK_EX', catatKunjungan('127.0.0.1', 'sari', $folderUji) && catatKunjungan('127.0.0.1', 'BU', $folderUji));
    $log2 = bacaLogTerakhir(20, $folderUji);
    periksa('Log terbaru ditampilkan lebih dahulu', count($log2) === 2 && str_contains($log2[0], ' | BU') && str_contains($log2[1], ' | sari'));
    for ($i = 0; $i < 25; $i++) {
        catatKunjungan('127.0.0.1', 'uji-' . $i, $folderUji);
    }
    $log20 = bacaLogTerakhir(20, $folderUji);
    periksa('Log terakhir maksimal 20 baris', count($log20) === 20 && str_ends_with($log20[0], 'uji-24') && str_ends_with($log20[19], 'uji-5'));
    periksa('JSON hilang menghasilkan pesan, bukan error fatal', str_contains(bacaPesertaJson($folderUji)['error'] ?? '', 'belum ada'));
    periksa('json_encode menyimpan JSON awal', simpanPesertaJson($awal, $folderUji));
    $dibaca = bacaPesertaJson($folderUji);
    periksa('json_decode membaca data awal kembali', $dibaca['error'] === null && $dibaca['data'] === $awal);
    $ditambah = tambahPesertaJson(['nama' => 'Deni', 'kelas' => 'Web', 'nilai' => 75], $folderUji);
    periksa('Menambah satu peserta dan menyimpan ulang JSON', $ditambah['ok'] === true && count(bacaPesertaJson($folderUji)['data'] ?? []) === 4);
    file_put_contents($folderUji . '/peserta.json', '{json rusak');
    periksa('JSON rusak dikenali dengan json_last_error()', str_contains(bacaPesertaJson($folderUji)['error'] ?? '', 'JSON rusak'));
    periksa('JSON rusak tidak ditimpa saat mencoba menambahkan', tambahPesertaJson(['nama' => 'Eka', 'kelas' => 'Data', 'nilai' => 95], $folderUji)['ok'] === false);
    periksa('CSV hilang ditangani dengan pesan', str_contains(imporPesertaCsv($folderUji)['error'] ?? '', 'belum ada'));
    periksa('fputcsv membuat berkas CSV', eksporPesertaCsv($awal, $folderUji));
    $impor = imporPesertaCsv($folderUji);
    periksa('fgetcsv membaca kembali 3 peserta', $impor['error'] === null && $impor['data'] === $awal);
    file_put_contents($folderUji . '/peserta.csv', "nama,kelas,nilai\nA,Web,bukan-angka\n");
    periksa('CSV rusak ditangani tanpa error fatal', str_contains(imporPesertaCsv($folderUji)['error'] ?? '', 'baris 2'));
    // Bersihkan hanya file di folder sementara khusus tes.
    foreach (glob($folderUji . '/*') ?: [] as $berkas) {
        if (is_file($berkas)) {
            unlink($berkas);
        }
    }
    rmdir($folderUji);
} else {
    periksa('Penyimpanan sementara tersedia untuk tes lanjut', false);
}

$lulus = count(array_filter($uji, static fn (array $item): bool => $item['lulus']));
bukaHalaman('Uji Otomatis Lab 4', 'uji.php');
?>
<p class="lead">Pengujian dijalankan menggunakan folder sementara sehingga tidak mengubah <code>data/</code> asli milik proyek Anda.</p>
<div class="card">
  <h2>Ringkasan: <?= e($lulus) ?> dari <?= e(count($uji)) ?> uji berhasil</h2>
  <div class="progress-bar"><div style="width: <?= e(count($uji) ? round(100 * $lulus / count($uji)) : 0) ?>%"></div></div>
  <div class="table-wrap"><table><thead><tr><th>No.</th><th>Skenario pengujian</th><th>Status</th></tr></thead><tbody>
    <?php foreach ($uji as $i => $item): ?>
      <tr><td><?= e($i + 1) ?></td><td><?= e($item['nama']) ?></td><td><span class="status <?= $item['lulus'] ? 'pass' : 'fail' ?>"><?= $item['lulus'] ? 'LULUS' : 'GAGAL' ?></span></td></tr>
    <?php endforeach; ?>
  </tbody></table></div>
  <p class="hint">Untuk menguji alur browser (GET, tampilan log, tambah JSON, CSV), ikuti juga langkah pengujian manual dalam README.</p>
</div>
<?php tutupHalaman(); ?>
