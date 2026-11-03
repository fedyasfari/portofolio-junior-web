<?php
declare(strict_types=1);

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
function tokenCsrf(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return (string) $_SESSION['csrf_token'];
}
function cekCsrf(): void
{
    $terkirim = $_POST['csrf'] ?? null;
    if (!is_string($terkirim) || !hash_equals(tokenCsrf(), $terkirim)) {
        http_response_code(403);
        exit('Permintaan ditolak: token CSRF tidak valid.');
    }
}
function hanyaPost(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Allow: POST');
        http_response_code(405);
        exit('Metode tidak diizinkan.');
    }
}
function setFlash(string $pesan, string $tipe = 'success'): void
{
    $_SESSION['flash'] = ['pesan' => $pesan, 'tipe' => $tipe];
}
function ambilFlash(): ?array
{
    $hasil = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return is_array($hasil) ? $hasil : null;
}
function alihkan(string $alamat): never
{
    header('Location: ' . $alamat, true, 303);
    exit;
}
function sudahLogin(): bool
{
    return ($_SESSION['admin_login'] ?? false) === true;
}
function wajibAdmin(): void
{
    if (!sudahLogin()) {
        setFlash('Masuk sebagai admin untuk mengakses halaman tersebut.', 'warning');
        alihkan('login.php');
    }
}
function bolehCetak(int $id): bool
{
    return sudahLogin() || ($_SESSION['bukti_izin'][$id] ?? false) === true;
}
function validId(mixed $value): ?int
{
    if (!is_scalar($value) || is_bool($value)) return null;
    $hasil = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    return $hasil === false ? null : $hasil;
}
