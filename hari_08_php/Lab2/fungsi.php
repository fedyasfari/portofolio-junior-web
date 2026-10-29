<?php
declare(strict_types=1);

/** Menghitung rata-rata nilai. Daftar kosong menghasilkan 0.0. */
function hitungRataRata(array $daftar): float
{
    if (count($daftar) === 0) {
        return 0.0;
    }

    $total = array_sum(array_column($daftar, 'nilai'));
    return (float) ($total / count($daftar));
}

/** Mengembalikan data peserta bernilai tertinggi, atau null jika kosong. */
function cariTertinggi(array $daftar): ?array
{
    if ($daftar === []) {
        return null;
    }

    $tertinggi = $daftar[0];
    foreach ($daftar as $orang) {
        if ($orang['nilai'] > $tertinggi['nilai']) {
            $tertinggi = $orang;
        }
    }

    return $tertinggi;
}

/** Memilih peserta dengan nilai >= batas; indeks dikembalikan mulai dari 0. */
function filterLulus(array $peserta, int $batas = 70): array
{
    $hasil = array_filter(
        $peserta,
        static fn (array $orang): bool => $orang['nilai'] >= $batas
    );

    return array_values($hasil);
}

/** Mengurutkan nilai terbesar ke terkecil tanpa mengubah array asal. */
function urutkanNilai(array $peserta): array
{
    $salinan = $peserta;

    usort(
        $salinan,
        static fn (array $a, array $b): int => $b['nilai'] <=> $a['nilai']
    );

    return $salinan;
}

/** Mengelompokkan peserta berdasarkan nama kelas. */
function kelompokkanPerKelas(array $peserta): array
{
    $kelompok = [];

    foreach ($peserta as $orang) {
        $kelas = $orang['kelas'];
        $kelompok[$kelas][] = $orang;
    }

    return $kelompok;
}

/** Aturan grade: A >=90, B >=80, C >=70, D >=60, lainnya E. */
function nilaiKeGrade(int $nilai): string
{
    return match (true) {
        $nilai >= 90 => 'A',
        $nilai >= 80 => 'B',
        $nilai >= 70 => 'C',
        $nilai >= 60 => 'D',
        default => 'E',
    };
}

/** Escape konten sebelum menampilkannya dalam teks HTML. */
function e(string|int|float $nilai): string
{
    return htmlspecialchars(
        (string) $nilai,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}
