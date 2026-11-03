<?php
declare(strict_types=1);

// Langkah pertama: HANYA bug B-01 (titik koma) yang diperbaiki.
// Masalah lainnya sengaja masih ada untuk latihan debugging.
$nilai = ['Sari' => 90, 'Budi' => '68', 'Citra' => 82, 'Dewi' => 70];

function hitungRataRata(array $daftar): float
{
    $total = 0;
    foreach ($daftar as $n) {
        $total += $n;
    }
    return $total / (count($daftar) - 1);
}

function hitungLulus(array $daftar): int
{
    $lulus = 0;
    foreach ($daftar as $nama => $n) {
        if ($n > 70) {
            $lulus++;
        }
    }
    return $lulus;
}

echo 'Rata-rata: ' . hitungRataRata($nilai) . '<br>';
echo 'Lulus: ' . hitungLulus($nilai) . '<br>';
echo 'Nilai Eko: ' . $nilai['Eko'];
header('X-Debug: selesai');
