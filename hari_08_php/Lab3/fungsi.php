<?php

declare(strict_types=1);

/** Mengubah berat (kg) dan tinggi (cm) menjadi BMI. */
function hitungBmi(float $berat, float $tinggi): float
{
    if ($berat <= 0 || $tinggi <= 0) {
        throw new InvalidArgumentException('Berat dan tinggi harus lebih dari 0.');
    }

    $tinggiMeter = $tinggi / 100;
    $kuadratTinggi = $tinggiMeter * $tinggiMeter;

    if ($kuadratTinggi <= 0) {
        throw new InvalidArgumentException('Tinggi terlalu kecil untuk dihitung.');
    }

    $bmi = $berat / $kuadratTinggi;
    if (!is_finite($bmi)) {
        throw new InvalidArgumentException('Hasil BMI berada di luar rentang angka yang valid.');
    }

    return $bmi;
}

/** Kategori BMI untuk latihan pemrograman (batas kategori dewasa). */
function kategoriBmi(float $bmi): string
{
    return match (true) {
        $bmi < 18.5 => 'Kurang',
        $bmi < 25 => 'Normal',
        $bmi < 30 => 'Lebih',
        default => 'Obesitas',
    };
}

/** Mengamankan teks yang ditampilkan dalam HTML, termasuk atribut value="...". */
function e(string|int|float $nilai): string
{
    return htmlspecialchars((string) $nilai, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Ambil isi form sebagai teks tanpa peringatan jika pengunjung mengirim array. */
function ambilIsian(array $data, string $kunci): string
{
    $nilai = $data[$kunci] ?? '';
    return is_string($nilai) ? trim($nilai) : '';
}

/**
 * Validasi form; struktur hasil sengaja jelas agar mudah diperiksa saat belajar.
 *
 * @return array{berat:string, tinggi:string, galat:array<string,string>, bmi:?float, kategori:?string, hasil:?string}
 */
function prosesFormBmi(array $data): array
{
    $berat = ambilIsian($data, 'berat');
    $tinggi = ambilIsian($data, 'tinggi');
    $galat = [];
    $bmi = null;
    $kategori = null;
    $hasil = null;

    $beratAngka = filter_var($berat, FILTER_VALIDATE_FLOAT);
    $tinggiAngka = filter_var($tinggi, FILTER_VALIDATE_FLOAT);

    if ($beratAngka === false || !is_finite($beratAngka) || $beratAngka <= 0) {
        $galat['berat'] = 'Berat harus angka lebih dari 0.';
    }

    if ($tinggiAngka === false || !is_finite($tinggiAngka) || $tinggiAngka <= 0) {
        $galat['tinggi'] = 'Tinggi harus angka lebih dari 0.';
    }

    if ($galat === []) {
        try {
            $bmi = hitungBmi((float) $beratAngka, (float) $tinggiAngka);
            $kategori = kategoriBmi($bmi);
            $hasil = number_format($bmi, 1) . ' (' . $kategori . ')';
        } catch (InvalidArgumentException $exception) {
            // Mencegah hasil tak valid ditampilkan untuk angka yang sangat ekstrem.
            $galat['tinggi'] = 'Masukkan angka berat dan tinggi yang wajar untuk dihitung.';
        }
    }

    return [
        'berat' => $berat,
        'tinggi' => $tinggi,
        'galat' => $galat,
        'bmi' => $bmi,
        'kategori' => $kategori,
        'hasil' => $hasil,
    ];
}
