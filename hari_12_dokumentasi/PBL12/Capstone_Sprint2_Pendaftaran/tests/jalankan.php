<?php
declare(strict_types=1);
/**
 * Uji unit aman yang tidak mengubah database dan tidak membutuhkan Apache.
 * Jalankan: C:\xampp\php\php.exe tests\jalankan.php
 */
require_once __DIR__ . '/../src/validasi.php';
require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/struktur_data.php';

$jumlah = 0;
$gagal = 0;
function periksa(string $nama, bool $kondisi): void
{
    global $jumlah, $gagal;
    $jumlah++;
    if ($kondisi) {
        echo "[LULUS] {$nama}" . PHP_EOL;
        return;
    }
    $gagal++;
    echo "[GAGAL] {$nama}" . PHP_EOL;
}

periksa('Nomor HP valid', validNoHp('081234567890') === true);
periksa('Nomor HP menolak karakter nonangka', validNoHp('08ABC45678') === false);
periksa('Nomor HP menolak awalan selain 08', validNoHp('071234567890') === false);
periksa('Sisa kuota positif', hitungSisaKuota(20, 7) === 13);
periksa('Sisa kuota nol bila penuh', hitungSisaKuota(10, 10) === 0);
periksa('Sisa kuota tidak negatif', hitungSisaKuota(10, 12) === 0);
periksa('Format nomor bukti', formatNomorBukti(2026, 12) === 'REG-2026-000012');
periksa('validId menerima integer positif', validId('12') === 12);
periksa('validId menolak nol', validId('0') === null);
periksa('validId menolak teks', validId('abc') === null);
periksa('validId menolak boolean', validId(true) === null);
periksa('Escape HTML melindungi tag', e('<script>') === '&lt;script&gt;');

$pendaftar = [
    ['id'=>3,'nama'=>'Cici','nama_kelas'=>'Web'],
    ['id'=>8,'nama'=>'Hana','nama_kelas'=>'Desain'],
    ['id'=>1,'nama'=>'Adi','nama_kelas'=>'Web'],
    ['id'=>4,'nama'=>'Dani','nama_kelas'=>'Data'],
    ['id'=>9,'nama'=>'Ira','nama_kelas'=>'Web'],
    ['id'=>2,'nama'=>'Budi','nama_kelas'=>'Data'],
    ['id'=>5,'nama'=>'Eka','nama_kelas'=>'Data'],
    ['id'=>6,'nama'=>'Fani','nama_kelas'=>'Web'],
    ['id'=>7,'nama'=>'Gina','nama_kelas'=>'Desain'],
];
$baru = limaPendaftarTerbaru($pendaftar, 5);
periksa('SplQueue menghasilkan 5 peserta', count($baru) === 5);
periksa('SplQueue mengurut terbaru ke terlama', array_column($baru, 'id') === [9,8,7,6,5]);
periksa('SplQueue input tidak berubah', $pendaftar[0]['id'] === 3);
periksa('SplQueue bekerja saat kosong', limaPendaftarTerbaru([]) === []);
try {
    limaPendaftarTerbaru($pendaftar, 0);
    periksa('Batas queue tidak boleh nol', false);
} catch (InvalidArgumentException $e) {
    periksa('Batas queue tidak boleh nol', true);
}

$kelas = [
    ['nama_kelas'=>'Web','terisi'=>6],
    ['nama_kelas'=>'Data','terisi'=>10],
    ['nama_kelas'=>'Desain','terisi'=>6],
    ['nama_kelas'=>'AI','terisi'=>0],
];
$peringkat = peringkatKelasBerdasarkanJumlah($kelas);
periksa('usort: kelas paling banyak di atas', array_column($peringkat,'nama_kelas') === ['Data','Desain','Web','AI']);
periksa('usort: kelas dengan nol peserta tetap ada', count($peringkat) === 4 && $peringkat[3]['terisi'] === 0);
periksa('usort: hitungan dikonversi menjadi integer', is_int($peringkat[0]['terisi']));
periksa('usort: kelas kosong tidak gagal', peringkatKelasBerdasarkanJumlah([]) === []);

printf(PHP_EOL . "Total: %d | Lulus: %d | Gagal: %d" . PHP_EOL, $jumlah, $jumlah-$gagal, $gagal);
exit($gagal === 0 ? 0 : 1);
