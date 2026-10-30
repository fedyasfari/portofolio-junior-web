<?php
declare(strict_types=1);
// JANGAN ada echo, HTML, spasi atau BOM sebelum <?php: PDF bersifat biner.
use Dompdf\Dompdf;
use Dompdf\Options;

require_once __DIR__ . '/../src/bootstrap.php';

$autoload = __DIR__ . '/../vendor/autoload.php';
if (!is_file($autoload)) {
    http_response_code(500);
    exit('Dompdf belum terpasang. Di folder proyek jalankan: composer require dompdf/dompdf');
}
require_once $autoload;

$id = filter_var(
    $_GET['id'] ?? null,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);
$bukti = ($id === false || $id === null)
    ? null
    : ambilBuktiPendaftar(getConnection(), (int) $id);

if ($bukti === null) {
    http_response_code(404);
    exit('Data tidak ditemukan.');
}

// Gunakan tanggal pendaftaran, bukan tanggal cetak, untuk membuat nomor tetap.
if (trim((string) ($bukti['tgl_daftar'] ?? '')) === '') {
    http_response_code(500);
    exit('Tanggal pendaftaran tidak tersedia.');
}
try {
    $tanggal = new DateTimeImmutable((string) $bukti['tgl_daftar']);
} catch (Exception $e) {
    error_log('Tanggal daftar tidak valid untuk ID ' . (int) $bukti['id']);
    http_response_code(500);
    exit('Tanggal pendaftaran pada database tidak valid.');
}
$nomor = sprintf('REG-%s-%06d', $tanggal->format('Y'), (int) $bukti['id']);
$tanggalTampil = $tanggal->format('d-m-Y H:i');

// Template hanya ditampung sebagai string; tidak langsung dikirim ke browser.
ob_start();
require __DIR__ . '/../templates/bukti.php';
$html = (string) ob_get_clean();

$options = new Options();
$options->set('isRemoteEnabled', false);   // Tidak mengunduh asset dari internet.
$options->set('isPhpEnabled', false);      // Jangan eksekusi PHP di dalam PDF.
$options->set('isJavascriptEnabled', false);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A5', 'portrait');
$dompdf->render();

// Jika ada output terdahulu dari PHP, browser dapat menolak PDF.
if (headers_sent($asalFile, $baris)) {
    error_log("Header sudah terkirim di {$asalFile}:{$baris}");
    exit('PDF gagal dibuka karena ada output sebelum PDF. Periksa BOM/echo.');
}
$dompdf->stream($nomor . '.pdf', ['Attachment' => false]);
exit;
