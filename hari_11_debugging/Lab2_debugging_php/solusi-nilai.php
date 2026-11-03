<?php
declare(strict_types=1);

// LAB 2 - SOLUSI DEBUGGING PHP
// B-02: semua nilai menggunakan tipe integer (angka tanpa tanda petik).
$nilai = [
    'Sari' => 90,
    'Budi' => 68,
    'Citra' => 82,
    'Dewi' => 70,
];

function hitungRataRata(array $daftar): float
{
    // Cegah pembagian dengan nol apabila array kosong.
    if (count($daftar) === 0) {
        return 0.0;
    }

    $total = 0;
    foreach ($daftar as $n) {
        $total += $n;
    }

    // B-03: bagi dengan jumlah data yang sebenarnya.
    return $total / count($daftar);
}

function hitungLulus(array $daftar): int
{
    $lulus = 0;
    foreach ($daftar as $nama => $n) {
        // B-04: nilai tepat 70 juga lulus.
        if ($n >= 70) {
            $lulus++;
        }
    }

    // B-01: ada titik koma setelah return.
    return $lulus;
}

// B-06: kirim HTTP header sebelum ada output.
header('Content-Type: text/html; charset=UTF-8');
header('X-Debug: selesai');

// B-05: ?? memakai teks pengganti jika kunci 'Eko' tidak tersedia.
$nilaiEko = $nilai['Eko'] ?? 'Data tidak ditemukan';

// Pemisah ribuan dan desimal disesuaikan untuk Indonesia.
echo 'Rata-rata: ' . number_format(hitungRataRata($nilai), 1, ',', '.') . '<br>';
echo 'Lulus: ' . hitungLulus($nilai) . ' siswa<br>';
echo 'Nilai Eko: ' . $nilaiEko . '<br>';
