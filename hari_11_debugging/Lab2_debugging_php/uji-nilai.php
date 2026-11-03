<?php
declare(strict_types=1);

// Memuat fungsi dari jawaban final untuk diuji.
// Output HTML solusi ditampung lalu dibuang agar layar uji tetap bersih.
ob_start();
require_once __DIR__ . '/solusi-nilai.php';
ob_end_clean();

$tes = [
    'Rata-rata empat siswa = 77,5' => hitungRataRata(['Sari' => 90, 'Budi' => 68, 'Citra' => 82, 'Dewi' => 70]) === 77.5,
    'Jumlah lulus = 3' => hitungLulus(['Sari' => 90, 'Budi' => 68, 'Citra' => 82, 'Dewi' => 70]) === 3,
    'Nilai 70 dinyatakan lulus' => hitungLulus(['Dewi' => 70]) === 1,
    'Nilai 69 tidak lulus' => hitungLulus(['Budi' => 69]) === 0,
    'Rata-rata array kosong aman' => hitungRataRata([]) === 0.0,
    'Tidak ada kelulusan pada array kosong' => hitungLulus([]) === 0,
];

$gagal = 0;
foreach ($tes as $judul => $berhasil) {
    if (!$berhasil) {
        $gagal++;
    }
    echo ($berhasil ? '[LULUS] ' : '[GAGAL] ') . $judul;
    echo PHP_SAPI === 'cli' ? "
" : "<br>
";
}
echo "Hasil: " . (count($tes) - $gagal) . '/' . count($tes) . ' pengujian lulus';
echo PHP_SAPI === 'cli' ? "
" : "<br>
";
