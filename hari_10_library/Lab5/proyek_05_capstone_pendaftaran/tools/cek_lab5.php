<?php
declare(strict_types=1);
// Buka melalui terminal: php tools/cek_lab5.php (bukan melalui browser).
if (PHP_SAPI !== 'cli') { http_response_code(403); exit('Hanya terminal.'); }
$root = dirname(__DIR__);
$items = [
  'public/cetak.php', 'templates/bukti.php', 'src/pendaftar.php',
  'composer.json', 'vendor/autoload.php', '.gitignore'
];
echo "=== Pemeriksaan Lab 5 (tanpa koneksi database) ===
";
foreach ($items as $file) {
    echo (is_file($root . '/' . $file) ? '[OK] ' : '[BELUM] ') . $file . "
";
}
if (is_file($root . '/src/pendaftar.php')) {
    require_once $root . '/src/pendaftar.php';
    echo function_exists('ambilBuktiPendaftar')
       ? "[OK] Fungsi ambilBuktiPendaftar tersedia
"
       : "[BELUM] Tambahkan fungsi ambilBuktiPendaftar pada src/pendaftar.php
";
}
foreach (['dom','mbstring','gd'] as $ext) {
    $required = $ext !== 'gd';
    echo (extension_loaded($ext) ? '[OK] ' : ($required ? '[WAJIB] ' : '[SARAN] ')) . "Ekstensi PHP: $ext
";
}
if (is_file($root . '/vendor/autoload.php')) {
    require_once $root . '/vendor/autoload.php';
    echo class_exists('Dompdf\Dompdf')
       ? "[OK] Kelas Dompdf dapat digunakan
"
       : "[BELUM] Kelas Dompdf tidak ditemukan. Ulang composer install
";
}
if (is_file($root . '/.gitignore')) {
    $s = file_get_contents($root . '/.gitignore');
    echo preg_match('#(^|\n)\s*/?vendor/?\s*(?:\r?\n|$)#', $s)
       ? "[OK] vendor ada di .gitignore
"
       : "[BELUM] Tambahkan /vendor/ pada .gitignore
";
}
echo "
Pastikan file composer.lock ada setelah Composer berhasil dijalankan.
";
