<?php
declare(strict_types=1);
/**
 * Memeriksa format nomor HP Indonesia yang diawali 08 dan terdiri atas 10–13 digit.
 *
 * @param string $noHp Nomor HP tanpa spasi, tanda plus, atau pemisah.
 * @return bool True apabila cocok dengan pola, selain itu false.
 */
function validNoHp(string $noHp): bool
{
    return preg_match('/^08[0-9]{8,11}$/', $noHp) === 1;
}
/**
 * Menghitung kapasitas tersisa tanpa menghasilkan bilangan negatif.
 *
 * @param int $kuota Batas maksimum peserta yang disediakan.
 * @param int $terisi Jumlah peserta yang sudah terdaftar.
 * @return int Sisa kursi paling sedikit nol; bukan pemeriksaan kuota atomik.
 */
function hitungSisaKuota(int $kuota, int $terisi): int
{
    return max(0, $kuota - $terisi);
}
/**
 * Membentuk nomor bukti dengan format REG-TAHUN-ID enam digit minimum.
 *
 * @param int $tahun Tahun pendaftaran, misalnya 2026.
 * @param int $id ID peserta yang dicetak pada bukti.
 * @return string Nomor bukti, misalnya REG-2026-000012.
 */
function formatNomorBukti(int $tahun, int $id): string
{
    return sprintf('REG-%d-%06d', $tahun, $id);
}
