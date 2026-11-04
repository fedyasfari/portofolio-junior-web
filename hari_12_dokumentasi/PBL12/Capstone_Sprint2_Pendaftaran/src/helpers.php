<?php
declare(strict_types=1);

/**
 * Mengamankan nilai untuk ditampilkan sebagai teks HTML dengan escaping UTF-8.
 *
 * @param mixed $value Nilai yang akan ditampilkan, biasanya berasal dari database atau formulir.
 * @return string Teks aman untuk konteks isi HTML dan atribut HTML yang diapit tanda kutip.
 */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Mengambil token CSRF dari sesi, atau membuat token acak jika belum tersedia.
 *
 * @return string Token heksadesimal untuk disisipkan ke formulir POST.
 * @throws \Random\RandomException Jika generator token acak gagal; catat kesalahan dan minta pengguna mencoba lagi.
 */
function tokenCsrf(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return (string) $_SESSION['csrf_token'];
}

/**
 * Menolak pengiriman formulir bila token CSRF tidak cocok dengan token sesi.
 *
 * @return void Tidak ada nilai; permintaan ditutup dengan HTTP 403 bila token tidak valid.
 * @throws \Random\RandomException Jika token sesi harus dibuat tetapi sumber acak gagal.
 */
function cekCsrf(): void
{
    $terkirim = $_POST['csrf'] ?? null;
    if (!is_string($terkirim) || !hash_equals(tokenCsrf(), $terkirim)) {
        http_response_code(403);
        exit('Permintaan ditolak: token CSRF tidak valid.');
    }
}

/**
 * Memastikan endpoint hanya diakses menggunakan HTTP POST.
 *
 * @return void Tidak ada nilai; selain POST akan mengirim HTTP 405 dan menghentikan request.
 */
function hanyaPost(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Allow: POST');
        http_response_code(405);
        exit('Metode tidak diizinkan.');
    }
}

/**
 * Menyimpan satu pesan singkat ke sesi untuk ditampilkan pada halaman berikutnya.
 *
 * @param string $pesan Isi pesan yang ingin ditampilkan.
 * @param string $tipe Jenis notifikasi, misalnya success atau danger; default success.
 * @return void Pesan disimpan pada $_SESSION['flash'].
 */
function setFlash(string $pesan, string $tipe = 'success'): void
{
    $_SESSION['flash'] = ['pesan' => $pesan, 'tipe' => $tipe];
}

/**
 * Mengambil pesan flash sekali pakai dan langsung menghapusnya dari sesi.
 *
 * @return array{pesan: string, tipe: string}|null Pesan flash atau null jika tidak tersedia.
 */
function ambilFlash(): ?array
{
    $hasil = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return is_array($hasil) ? $hasil : null;
}

/**
 * Mengalihkan browser ke alamat tujuan memakai status HTTP 303.
 *
 * @param string $alamat URL atau path tujuan pengalihan; gunakan tujuan yang tepercaya.
 * @return never Fungsi selalu mengakhiri request dengan exit.
 */
function alihkan(string $alamat): never
{
    header('Location: ' . $alamat, true, 303);
    exit;
}

/**
 * Alias untuk alihkan() agar pemanggil dapat menggunakan nama fungsi umum.
 *
 * @param string $alamat URL atau path tujuan pengalihan.
 * @return never Fungsi mengalihkan browser lalu menghentikan request.
 */
function redirect(string $alamat): never
{
    alihkan($alamat);
}

/**
 * Memeriksa apakah sesi saat ini menyimpan ID admin yang dianggap telah masuk.
 *
 * @return bool True jika admin_id tidak kosong; false jika belum masuk.
 */
function sudahLogin(): bool
{
    return !empty($_SESSION['admin_id']);
}

/**
 * Memeriksa izin mencetak bukti pendaftaran; aturan sekarang hanya mengizinkan admin.
 *
 * @param int $id ID peserta yang hendak dicetak; belum dipakai dalam aturan izin saat ini.
 * @return bool True apabila sesi admin aktif; selain itu false.
 */
function bolehCetak(int $id): bool
{
    // Sprint 2: hanya admin, mengikuti tugas Hari 11.
    return sudahLogin();
}

/**
 * Memeriksa dan mengubah masukan menjadi ID bilangan bulat positif.
 *
 * @param mixed $value Masukan dari URL atau formulir; harus berupa skalar bukan boolean.
 * @return int|null ID minimal 1 jika sah, atau null jika tidak valid.
 */
function validId(mixed $value): ?int
{
    if (!is_scalar($value) || is_bool($value)) return null;
    $hasil = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    return $hasil === false ? null : $hasil;
}
