<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/functions.php';

if (!adminMasuk()) {
    header('Location: admin.php', true, 303);
    exit;
}

try {
    $daftar = cariTamu(ambilSemuaTamu(), ''); // Pesan soft-deleted tidak diekspor.
} catch (RuntimeException $e) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Gagal membaca data: ' . $e->getMessage();
    exit;
}

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="buku-tamu-' . date('Y-m-d') . '.csv"');
header('Cache-Control: no-store');
$output = fopen('php://output', 'w');
if ($output === false) {
    http_response_code(500);
    exit;
}
// BOM UTF-8 memudahkan pembukaan data bahasa Indonesia pada Excel.
fwrite($output, "\xEF\xBB\xBF");
fputcsv($output, ['ID', 'Waktu', 'Nama', 'Email', 'Pesan'], ',', '"', '');
foreach ($daftar as $tamu) {
    fputcsv($output, [
        (int) ($tamu['id'] ?? 0),
        amanCsv((string) ($tamu['waktu'] ?? '')),
        amanCsv((string) ($tamu['nama'] ?? '')),
        amanCsv((string) ($tamu['email'] ?? '')),
        amanCsv((string) ($tamu['pesan'] ?? '')),
    ], ',', '"', '');
}
fclose($output);
