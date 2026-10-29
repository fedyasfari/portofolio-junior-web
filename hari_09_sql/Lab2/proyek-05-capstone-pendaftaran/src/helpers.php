<?php
declare(strict_types=1);

/** Ubah karakter khusus sebelum menampilkan input pengguna dalam HTML. */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Arahkan kembali setelah POST agar tidak terkirim ulang saat refresh. */
function redirect(string $path): never
{
    header('Location: ' . $path, true, 303);
    exit;
}

function csrfToken(): string
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function periksaCsrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals(csrfToken(), $token)) {
        http_response_code(403);
        exit('Permintaan ditolak: token keamanan tidak cocok. Muat ulang halaman.');
    }
}

function simpanPesan(string $pesan): void
{
    $_SESSION['pesan_sukses'] = $pesan;
}

function ambilPesan(): ?string
{
    $pesan = $_SESSION['pesan_sukses'] ?? null;
    unset($_SESSION['pesan_sukses']);
    return is_string($pesan) ? $pesan : null;
}

/**
 * Verifikasi data formulir. Jika tidak valid, hasilnya berupa pesan kesalahan
 * dengan key sesuai nama input.
 */
function validasiFormPendaftar(array $data, array $idKelasTersedia): array
{
    $errors = [];

    $nama = trim((string) ($data['nama'] ?? ''));
    $email = trim((string) ($data['email'] ?? ''));
    $noHp = trim((string) ($data['no_hp'] ?? ''));
    $idKelas = filter_var($data['id_kelas'] ?? null, FILTER_VALIDATE_INT);
    $tanggal = (string) ($data['tanggal_daftar'] ?? '');

    if (strlen($nama) < 3 || strlen($nama) > 100) {
        $errors['nama'] = 'Nama harus 3–100 karakter.';
    }
    if (strlen($email) > 150 || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Masukkan alamat email yang valid (maksimal 150 karakter).';
    }
    if (!preg_match('/^[0-9+()\-\s]{9,20}$/', $noHp)) {
        $errors['no_hp'] = 'Nomor HP harus 9–20 karakter (angka dan tanda telepon).';
    }
    if ($idKelas === false || !in_array($idKelas, $idKelasTersedia, true)) {
        $errors['id_kelas'] = 'Pilih kelas yang tersedia.';
    }

    $date = DateTimeImmutable::createFromFormat('!Y-m-d', $tanggal);
    if ($date === false || $date->format('Y-m-d') !== $tanggal) {
        $errors['tanggal_daftar'] = 'Pilih tanggal pendaftaran yang valid.';
    }

    return $errors;
}

/** Pesan singkat untuk error basis data tanpa membocorkan query atau sandi. */
function pesanGagalDatabase(PDOException $error): string
{
    if ((int) ($error->errorInfo[1] ?? 0) === 1062) {
        return 'Email sudah digunakan oleh pendaftar lain. Masukkan email berbeda.';
    }
    error_log('PDO: ' . $error->getMessage());
    return 'Operasi database gagal. Pastikan MySQL berjalan dan data valid.';
}
