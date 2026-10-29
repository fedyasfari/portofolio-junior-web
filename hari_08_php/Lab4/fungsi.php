<?php
declare(strict_types=1);

// Semua path memakai __DIR__, bukan direktori kerja browser.
const DIREKTORI_DATA = __DIR__ . '/data';
date_default_timezone_set('Asia/Jakarta');

function e(string|int|float|null $teks): string
{
    return htmlspecialchars((string) $teks, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function dataAwal(): array
{
    return require __DIR__ . '/data-awal.php';
}

function siapkanFolderData(string $folder = DIREKTORI_DATA): bool
{
    return is_dir($folder) || @mkdir($folder, 0755, true) || is_dir($folder);
}

function cariPeserta(array $peserta, string $kataKunci): array
{
    $kataKunci = trim($kataKunci);
    if ($kataKunci === '') {
        return $peserta;
    }

    return array_values(array_filter(
        $peserta,
        static fn (array $orang): bool => stripos($orang['nama'], $kataKunci) !== false
    ));
}

function gradeNilai(int $nilai): string
{
    return match (true) {
        $nilai >= 90 => 'A',
        $nilai >= 80 => 'B',
        $nilai >= 70 => 'C',
        $nilai >= 60 => 'D',
        default => 'E',
    };
}

function amanUntukLog(string $teks): string
{
    // Cegah satu pencarian membuat baris atau kolom log palsu.
    return substr(trim(str_replace(["\r", "\n", '|'], ' ', $teks)), 0, 200);
}

function catatKunjungan(string $ip, string $kataKunci, string $folder = DIREKTORI_DATA): bool
{
    if (!siapkanFolderData($folder)) {
        return false;
    }

    $baris = date('Y-m-d H:i:s') . ' | ' . amanUntukLog($ip)
        . ' | ' . amanUntukLog($kataKunci) . PHP_EOL;

    return @file_put_contents($folder . '/log.txt', $baris, FILE_APPEND | LOCK_EX) !== false;
}

function bacaLogTerakhir(int $batas = 20, string $folder = DIREKTORI_DATA): array
{
    $file = $folder . '/log.txt';
    if (!is_file($file) || !is_readable($file)) {
        return [];
    }

    $baris = @file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($baris === false) {
        return [];
    }

    // Sesuai soal: ambil 20 baris paling baru, ditampilkan dari terbaru.
    return array_slice(array_reverse($baris), 0, max(0, $batas));
}

/** Hasil: ['data' => array|null, 'error' => string|null]. */
function bacaPesertaJson(string $folder = DIREKTORI_DATA): array
{
    $path = $folder . '/peserta.json';
    if (!is_file($path)) {
        return ['data' => null, 'error' => 'Berkas peserta.json belum ada.'];
    }

    $isi = @file_get_contents($path);
    if ($isi === false) {
        return ['data' => null, 'error' => 'Berkas peserta.json tidak dapat dibaca.'];
    }

    $hasil = json_decode($isi, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['data' => null, 'error' => 'JSON rusak: ' . json_last_error_msg()];
    }

    if (!is_array($hasil) || array_values($hasil) !== $hasil) {
        return ['data' => null, 'error' => 'Struktur JSON harus berupa array peserta.'];
    }

    foreach ($hasil as $baris) {
        if (!is_array($baris)
            || !isset($baris['nama'], $baris['kelas'], $baris['nilai'])
            || !is_string($baris['nama'])
            || !is_string($baris['kelas'])
            || !is_int($baris['nilai'])) {
            return ['data' => null, 'error' => 'Isi JSON tidak sesuai format peserta.'];
        }
    }

    return ['data' => $hasil, 'error' => null];
}

function simpanPesertaJson(array $peserta, string $folder = DIREKTORI_DATA): bool
{
    if (!siapkanFolderData($folder)) {
        return false;
    }

    $json = json_encode($peserta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if ($json === false || json_last_error() !== JSON_ERROR_NONE) {
        return false;
    }

    return @file_put_contents($folder . '/peserta.json', $json . PHP_EOL, LOCK_EX) !== false;
}

function tambahPesertaJson(array $orangBaru, string $folder = DIREKTORI_DATA): array
{
    $hasilBaca = bacaPesertaJson($folder);
    if ($hasilBaca['error'] !== null) {
        return ['ok' => false, 'pesan' => $hasilBaca['error']];
    }

    $peserta = $hasilBaca['data'];
    $peserta[] = $orangBaru;
    if (!simpanPesertaJson($peserta, $folder)) {
        return ['ok' => false, 'pesan' => 'Gagal menyimpan peserta.json. Periksa izin folder data.'];
    }

    return ['ok' => true, 'pesan' => 'Peserta berhasil ditambahkan dan JSON disimpan ulang.'];
}

function eksporPesertaCsv(array $peserta, string $folder = DIREKTORI_DATA): bool
{
    if (!siapkanFolderData($folder)) {
        return false;
    }

    $fp = @fopen($folder . '/peserta.csv', 'wb');
    if ($fp === false) {
        return false;
    }

    // Escape CSV disetel '' eksplisit agar aman untuk PHP 8.4+.
    $berhasil = fputcsv($fp, ['nama', 'kelas', 'nilai'], ',', '"', '') !== false;
    foreach ($peserta as $orang) {
        $baris = [(string) $orang['nama'], (string) $orang['kelas'], (string) $orang['nilai']];
        // Hindari formula CSV saat berkas dibuka di aplikasi spreadsheet.
        // Aplikasi ini memakai input nama/kelas yang tidak menerima awalan formula.
        if (fputcsv($fp, $baris, ',', '"', '') === false) {
            $berhasil = false;
            break;
        }
    }
    if (!fclose($fp)) {
        $berhasil = false;
    }

    return $berhasil;
}

/** Hasil: ['data' => array|null, 'error' => string|null]. */
function imporPesertaCsv(string $folder = DIREKTORI_DATA): array
{
    $path = $folder . '/peserta.csv';
    if (!is_file($path)) {
        return ['data' => null, 'error' => 'Berkas peserta.csv belum ada. Klik Ekspor CSV dahulu.'];
    }
    $fp = @fopen($path, 'rb');
    if ($fp === false) {
        return ['data' => null, 'error' => 'Berkas peserta.csv tidak dapat dibaca.'];
    }

    $header = fgetcsv($fp, 0, ',', '"', '');
    if ($header !== ['nama', 'kelas', 'nilai']) {
        fclose($fp);
        return ['data' => null, 'error' => 'Header CSV harus: nama,kelas,nilai.'];
    }

    $peserta = [];
    $barisKe = 1;
    while (($kolom = fgetcsv($fp, 0, ',', '"', '')) !== false) {
        $barisKe++;
        if ($kolom === [null]) {
            continue;
        }
        if (count($kolom) !== 3 || !preg_match('/^\d+$/', trim((string) $kolom[2]))) {
            fclose($fp);
            return ['data' => null, 'error' => 'Format CSV tidak valid pada baris ' . $barisKe . '.'];
        }
        $nilai = (int) $kolom[2];
        if ($nilai < 0 || $nilai > 100) {
            fclose($fp);
            return ['data' => null, 'error' => 'Nilai CSV di luar 0-100 pada baris ' . $barisKe . '.'];
        }
        $peserta[] = [
            'nama' => (string) $kolom[0],
            'kelas' => (string) $kolom[1],
            'nilai' => $nilai,
        ];
    }
    fclose($fp);

    return ['data' => $peserta, 'error' => null];
}
