<?php
declare(strict_types=1);

/**
 * PBL Hari 8 - Proyek 4: Buku Tamu Berbasis File.
 * Semua fungsi untuk pengolahan data disimpan terpisah dari HTML.
 */
const FILE_TAMU = __DIR__ . '/data/tamu.json';
const FILE_ADMIN = __DIR__ . '/data/admin.hash';
const MAKS_PESAN = 500;
const PER_HALAMAN = 5;
const JEDA_KIRIM = 30;

date_default_timezone_set('Asia/Jakarta');

/** Ubah karakter khusus menjadi teks aman untuk ditampilkan di halaman HTML. */
function e(string|int|float $teks): string
{
    return htmlspecialchars((string) $teks, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Ambil satu input dari GET/POST tanpa error jika input tidak tersedia / berupa array. */
function nilaiTeks(array $input, string $kunci): string
{
    $nilai = $input[$kunci] ?? '';
    return is_string($nilai) || is_numeric($nilai) ? (string) $nilai : '';
}

/** Rapikan spasi berlebihan (termasuk baris baru) pada nama. */
function bersihkanSpasi(string $teks): string
{
    return trim((string) preg_replace('/\s+/u', ' ', $teks));
}

/** Hitung karakter UTF-8 (fallback jika ekstensi mbstring belum terpasang). */
function panjangTeks(string $teks): int
{
    return function_exists('mb_strlen') ? mb_strlen($teks, 'UTF-8') : strlen($teks);
}

/**
 * Memvalidasi input buku tamu.
 *
 * @param array<string, mixed> $input Data mentah dari $_POST.
 * @return array{data: array{nama:string,email:string,pesan:string},galat:array<string,string>}
 */
function validasiTamu(array $input): array
{
    $data = [
        'nama' => bersihkanSpasi(nilaiTeks($input, 'nama')),
        'email' => trim(nilaiTeks($input, 'email')),
        'pesan' => trim(nilaiTeks($input, 'pesan')),
    ];
    $galat = [];

    if (panjangTeks($data['nama']) < 3) {
        $galat['nama'] = 'Nama minimal 3 karakter.';
    } elseif (panjangTeks($data['nama']) > 100) {
        $galat['nama'] = 'Nama maksimal 100 karakter.';
    }

    if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
        $galat['email'] = 'Format email tidak valid.';
    } elseif (panjangTeks($data['email']) > 254) {
        $galat['email'] = 'Email terlalu panjang.';
    }

    $panjang = panjangTeks($data['pesan']);
    if ($panjang === 0 || $panjang > MAKS_PESAN) {
        $galat['pesan'] = 'Pesan wajib diisi, maksimal ' . MAKS_PESAN . ' karakter.';
    }

    return ['data' => $data, 'galat' => $galat];
}

/** Membuat folder data jika belum ada. */
function siapkanFolderData(): bool
{
    $folder = dirname(FILE_TAMU);
    if (!is_dir($folder) && !mkdir($folder, 0755, true) && !is_dir($folder)) {
        return false;
    }
    // Jika folder data sempat terhapus, buat ulang proteksi Apache-nya.
    $pelindung = $folder . '/.htaccess';
    if (!is_file($pelindung) && file_put_contents($pelindung, "Require all denied\n", LOCK_EX) === false) {
        return false;
    }
    return true;
}

/**
 * Membaca semua data dari JSON. Jika file belum dibuat, hasilnya array kosong.
 * Jika JSON rusak, jangan menimpa datanya diam-diam; tampilkan kesalahan.
 *
 * @return array<int, array<string, mixed>>
 */
function ambilSemuaTamu(): array
{
    if (!is_file(FILE_TAMU)) {
        return [];
    }
    $isi = file_get_contents(FILE_TAMU);
    if ($isi === false) {
        throw new RuntimeException('File data/tamu.json tidak dapat dibaca.');
    }
    $daftar = json_decode($isi, true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($daftar) ||
        ($daftar !== [] && array_keys($daftar) !== range(0, count($daftar) - 1))) {
        throw new RuntimeException('Isi JSON tidak valid. Periksa file data/tamu.json sebelum melanjutkan.');
    }
    foreach ($daftar as $tamu) {
        if (!is_array($tamu)) {
            throw new RuntimeException('Struktur JSON tamu tidak sesuai.');
        }
    }
    return $daftar;
}

/** Token untuk memastikan formulir POST berasal dari sesi pengunjung. */
function tokenCsrf(): string
{
    if (!isset($_SESSION['csrf_buku_tamu'])) {
        $_SESSION['csrf_buku_tamu'] = bin2hex(random_bytes(24));
    }
    return $_SESSION['csrf_buku_tamu'];
}

function csrfBenar(string $token): bool
{
    return hash_equals(tokenCsrf(), $token);
}

/**
 * Menyimpan tamu dengan penguncian file, ID otomatis, waktu, dan batas 30 detik/IP.
 * Alasan kegagalan dikembalikan melalui parameter kedua ($alasan).
 *
 * @param array{nama:string,email:string,pesan:string} $data
 */
function simpanTamu(array $data, ?string &$alasan = null): bool
{
    $alasan = null;
    if (!siapkanFolderData()) {
        $alasan = 'Folder data tidak bisa dibuat. Periksa izin akses.';
        return false;
    }

    // File .lock memastikan dua permintaan tidak membaca/menulis bersamaan.
    $kunci = fopen(dirname(FILE_TAMU) . '/.tamu.lock', 'c');
    if ($kunci === false || !flock($kunci, LOCK_EX)) {
        if (is_resource($kunci)) {
            fclose($kunci);
        }
        $alasan = 'Tidak dapat mengunci penyimpanan.';
        return false;
    }

    try {
        $daftar = ambilSemuaTamu();
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $sekarang = time();
        $idTerbesar = 0;

        foreach ($daftar as $tamu) {
            $idTerbesar = max($idTerbesar, (int) ($tamu['id'] ?? 0));
            $waktuTamu = strtotime((string) ($tamu['waktu'] ?? ''));
            if (($tamu['ip'] ?? '') === $ip && $waktuTamu !== false) {
                $sisa = JEDA_KIRIM - ($sekarang - $waktuTamu);
                if ($sisa > 0) {
                    $alasan = 'Tunggu ' . $sisa . ' detik sebelum mengirim pesan lagi.';
                    return false;
                }
            }
        }

        $data['id'] = $idTerbesar + 1;
        $data['waktu'] = date('Y-m-d H:i:s');
        $data['ip'] = $ip; // Tidak pernah ditampilkan di daftar publik.
        $data['dihapus_pada'] = null;
        $daftar[] = $data;

        $json = json_encode($daftar, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($json === false || file_put_contents(FILE_TAMU, $json, LOCK_EX) === false) {
            $alasan = 'Gagal menulis file data/tamu.json.';
            return false;
        }
        return true;
    } catch (RuntimeException $e) {
        $alasan = $e->getMessage();
        return false;
    } finally {
        flock($kunci, LOCK_UN);
        fclose($kunci);
    }
}

/** Hanya tampilkan data yang belum dihapus, lalu cari nama tanpa peka kapital. */
function cariTamu(array $daftar, string $kata): array
{
    $kata = trim($kata);
    return array_values(array_filter($daftar, static function (array $tamu) use ($kata): bool {
        if (!empty($tamu['dihapus_pada'])) {
            return false;
        }
        return $kata === '' || stripos((string) ($tamu['nama'] ?? ''), $kata) !== false;
    }));
}

/** Pagination: ambil maksimum PER_HALAMAN pesan dari halaman yang diminta. */
function halamanTamu(array $daftar, int $halaman): array
{
    $halaman = max(1, $halaman);
    return array_slice($daftar, ($halaman - 1) * PER_HALAMAN, PER_HALAMAN);
}

/** Hapus lembut: pesan masih tersimpan untuk audit tetapi disembunyikan dari publik. */
function hapusTamu(int $id, ?string &$alasan = null): bool
{
    $alasan = null;
    if ($id < 1 || !siapkanFolderData()) {
        $alasan = 'ID tidak valid atau folder tidak tersedia.';
        return false;
    }
    $kunci = fopen(dirname(FILE_TAMU) . '/.tamu.lock', 'c');
    if ($kunci === false || !flock($kunci, LOCK_EX)) {
        if (is_resource($kunci)) fclose($kunci);
        $alasan = 'Tidak dapat mengunci penyimpanan.';
        return false;
    }
    try {
        $daftar = ambilSemuaTamu();
        $ketemu = false;
        foreach ($daftar as &$tamu) {
            if ((int) ($tamu['id'] ?? 0) === $id && empty($tamu['dihapus_pada'])) {
                $tamu['dihapus_pada'] = date('Y-m-d H:i:s');
                $ketemu = true;
                break;
            }
        }
        unset($tamu);
        if (!$ketemu) {
            $alasan = 'Pesan tidak ditemukan atau sudah dihapus.';
            return false;
        }
        $json = json_encode($daftar, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($json === false || file_put_contents(FILE_TAMU, $json, LOCK_EX) === false) {
            $alasan = 'Gagal menyimpan perubahan.';
            return false;
        }
        return true;
    } catch (RuntimeException $e) {
        $alasan = $e->getMessage();
        return false;
    } finally {
        flock($kunci, LOCK_UN);
        fclose($kunci);
    }
}

/** Setup admin hanya diperbolehkan saat akses dari komputer lokal. */
function aksesLokal(): bool
{
    return in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true);
}

function adminMasuk(): bool
{
    return ($_SESSION['admin_masuk'] ?? false) === true;
}

/** Hindari CSV formula injection ketika file dibuka di aplikasi spreadsheet. */
function amanCsv(string $teks): string
{
    return preg_match('/^[\s]*[=+\-@]/u', $teks) === 1 ? "'" . $teks : $teks;
}
