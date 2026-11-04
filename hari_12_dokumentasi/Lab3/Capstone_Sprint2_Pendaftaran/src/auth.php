<?php
declare(strict_types=1);

/**
 * Modul Autentikasi Admin.
 * ID modul : MOD-AUT-001
 * Dokumen  : docs/modul/auth.md
 * Status   : aktif (penomoran tugas Lab 3)
 * Penulis  : Fedy Asfari (isi sendiri)
 * Tanggal  : 2026-11-03
 *
 * @version 1.0.1
 */

/**
 * Mengambil satu akun admin berdasarkan username untuk pemeriksaan login.
 *
 * @param PDO $pdo Koneksi database aktif.
 * @param string $username Username yang dicari secara tepat.
 * @return array<string, mixed>|null Kolom id, username, password_hash; null jika tidak ada.
 * @throws PDOException Jika query database gagal; periksa koneksi dan log server.
 */
function cariAdmin(PDO $pdo, string $username): ?array
{
    $stmt = $pdo->prepare('SELECT id, username, password_hash FROM admin WHERE username = :u LIMIT 1');
    $stmt->execute(['u' => $username]);
    $baris = $stmt->fetch();
    return $baris === false ? null : $baris;
}

/**
 * Memeriksa kredensial admin menggunakan password_verify dan membuat sesi login.
 * Jika berhasil, ID sesi diregenerasi dan token CSRF sebelumnya dihapus.
 *
 * @param PDO $pdo Koneksi database aktif.
 * @param string $username Username yang dikirim lewat formulir.
 * @param string $sandi Kata sandi mentah untuk dibandingkan dengan hash, bukan untuk disimpan.
 * @return bool True bila cocok dan sesi telah terisi; false bila kredensial salah.
 * @throws PDOException Jika pencarian admin gagal; catat log dan tampilkan pesan umum.
 * @see wajibLogin Untuk melindungi halaman admin setelah login.
 */
function prosesLogin(PDO $pdo, string $username, string $sandi): bool
{
    $admin = cariAdmin($pdo, $username);
    if ($admin === null || !password_verify($sandi, (string) $admin['password_hash'])) {
        return false;
    }
    session_regenerate_id(true);
    $_SESSION['admin_id'] = (int) $admin['id'];
    $_SESSION['admin_username'] = (string) $admin['username'];
    // Token CSRF baru setelah naik hak akses; form login sudah selesai diproses.
    unset($_SESSION['csrf_token']);
    return true;
}

/**
 * Melindungi halaman admin dengan mengarahkan pengunjung yang belum login.
 *
 * @return void Tidak ada nilai; jika belum login, redirect() mengakhiri request.
 */
function wajibLogin(): void
{
    if (!sudahLogin()) {
        redirect('login.php');
    }
}

/**
 * Menghapus data sesi admin, menghapus cookie sesi bila digunakan, dan menutup sesi.
 *
 * @return void Tidak ada nilai; pemanggil mengarahkan browser setelah logout.
 */
function logout(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time()-42000,
            $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}
