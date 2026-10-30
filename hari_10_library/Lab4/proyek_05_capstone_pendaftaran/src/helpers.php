<?php
declare(strict_types=1);

/** Mencegah HTML / JavaScript dari pengguna dieksekusi dalam HTML. */
function e(?string $teks): string
{
    return htmlspecialchars($teks ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Setelah menyimpan, redirect supaya POST tidak terulang saat refresh. */
function redirect(string $url): never
{
    header('Location: ' . $url, true, 303);
    exit;
}

function tokenCsrf(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function cekCsrf(): void
{
    $kiriman = $_POST['csrf'] ?? null;
    $tersimpan = $_SESSION['csrf'] ?? '';
    if (!is_string($kiriman) || $tersimpan === '' || !hash_equals($tersimpan, $kiriman)) {
        http_response_code(403);
        exit('Permintaan tidak valid (HTTP 403): token CSRF tidak cocok.');
    }
}

function setFlash(string $pesan): void
{
    $_SESSION['flash'] = $pesan;
}

function ambilFlash(): ?string
{
    $pesan = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return is_string($pesan) ? $pesan : null;
}

/** Menerjemahkan error email unik menjadi pesan untuk pengguna. */
function kegagalanEmailUnik(PDOException $e): bool
{
    return (int) ($e->errorInfo[1] ?? 0) === 1062;
}
