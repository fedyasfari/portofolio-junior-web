# Dokumen Modul: Autentikasi Admin

> **ID:** MOD-AUT-001  
> **Berkas:** `src/auth.php`  
> **Versi:** `1.0.1` — **aktif**  
> **Terakhir diperbarui:** 3 November 2026  
> **Penulis:** Fedy Asfari (**ganti dengan nama Anda sebelum dikumpulkan**)  
> **Ruang lingkup:** Dokumentasi modul yang ada pada proyek Capstone Pendaftaran, bukan modul autentikasi baru.

## 1. Identitas dan ringkasan modul (format Lab 3)

| Bagian | Isi |
|---|---|
| **ID modul / berkas** | **MOD-AUT-001 / `src/auth.php`** |
| **Versi dan status** | **1.0.1 / aktif** (penomoran dokumentasi Lab 3) |
| **Penulis dan tanggal** | **Fedy Asfari (isi sendiri) / 3 November 2026** |
| **Kegunaan** | Memeriksa akun admin dengan `password_verify()`, membuat sesi autentikasi, mengharuskan login saat membuka halaman terproteksi, serta mengakhiri sesi melalui logout. |
| **Dependensi** | `src/bootstrap.php` (memulai sesi dan memuat modul); `src/database.php` → `getConnection()` untuk memperoleh koneksi `PDO`; `src/helpers.php` → `sudahLogin()` dan `redirect()`; `config/config.php` dibaca oleh bootstrap untuk koneksi database; tabel MySQL `admin` dengan kolom `id`, `username`, `password_hash`. |
| **Fungsi publik** | `cariAdmin()`, `prosesLogin()`, `wajibLogin()`, `logout()` — **4 fungsi**. |
| **Catatan keamanan** | Kata sandi dicek terhadap hash, bukan dibandingkan sebagai teks biasa; ID sesi diregenerasi saat login; token CSRF lama dibersihkan; logout dilakukan dari endpoint POST dengan CSRF; pesan salah login tidak mengungkap keberadaan username. |
| **Contoh pemakaian** | `wajibLogin();` pada awal `public/index.php`; `prosesLogin(getConnection(), $username, $sandi)` pada `public/login.php`; `logout();` pada `public/logout.php`. |
| **Riwayat revisi** | Lihat tabel pada bagian 5; **entri 1.0.1 bertanggal 3 November 2026** untuk pembaruan dokumentasi dan penyelarasan versi header `src/auth.php`. |

## 2. Tanggung jawab modul

Modul `auth.php` menyimpan *logika autentikasi*, **bukan** form HTML login. Halaman `public/login.php` menerima POST, memeriksa CSRF, menerapkan pembatasan percobaan, memanggil fungsi login, dan menentukan halaman tujuan. `public/logout.php` membatasi permintaan menjadi POST serta melakukan pemeriksaan CSRF sebelum memanggil `logout()`.

## 3. Rincian fungsi publik

| Fungsi dan signature | Tujuan | Parameter | Nilai kembali / kondisi khusus |
|---|---|---|---|
| `cariAdmin(PDO $pdo, string $username): ?array` | Membaca satu akun admin berdasarkan username. | `$pdo`: koneksi database; `$username`: username yang dicari. | `array` berisi `id`, `username`, `password_hash` atau `null` jika tidak ditemukan. `PDOException` mungkin terjadi bila query gagal. |
| `prosesLogin(PDO $pdo, string $username, string $sandi): bool` | Memeriksa username serta password dan menyimpan sesi ketika berhasil. | `$pdo`: koneksi; `$username`: username; `$sandi`: kata sandi masukan. | `true` jika berhasil; `false` jika salah. Query dapat melempar `PDOException`. Ketika sukses melakukan `session_regenerate_id(true)`, menyimpan `admin_id` dan `admin_username`, lalu menghapus token CSRF lama. |
| `wajibLogin(): void` | Melindungi halaman yang hanya boleh diakses admin. | Tidak ada. | Tidak mengembalikan nilai. Jika belum masuk, memanggil `redirect('login.php')` yang menghentikan request. |
| `logout(): void` | Membersihkan data sesi dan mengakhirinya. | Tidak ada. | Tidak mengembalikan nilai. Mengosongkan `$_SESSION`, menghapus cookie sesi (jika digunakan), lalu `session_destroy()`. |

### Kondisi gagal dan pemulihan

- **Username atau kata sandi salah:** `prosesLogin()` menghasilkan `false`. Halaman login menampilkan pesan umum dan pengguna dapat mencoba lagi.
- **Percobaan login berulang:** `public/login.php` membatasi **5 kegagalan per sesi selama jendela 15 menit**. Ini mekanisme latihan pada level sesi, bukan perlindungan menyeluruh per akun atau IP.
- **Database gagal:** query pada `cariAdmin()` dapat melempar `PDOException`. Periksa koneksi dan log server, lalu tampilkan pesan umum; jangan menampilkan detail database kepada pengguna.
- **Belum login:** `wajibLogin()` mengalihkan ke `login.php`; setelah login berhasil pengguna dapat mengakses kembali halaman admin.

## 4. Contoh pemakaian dari alur proyek

**Melindungi halaman admin (`public/index.php`):**

```php
<?php
require_once __DIR__ . '/../src/bootstrap.php';
wajibLogin();
// Kode halaman daftar peserta dilanjutkan di sini.
```

**Memproses kredensial setelah form POST dan pemeriksaan CSRF (`public/login.php`):**

```php
<?php
// Cuplikan ilustrasi; bootstrap dan cekCsrf() harus dijalankan lebih dahulu.
$berhasil = prosesLogin(getConnection(), $username, $sandi);
if ($berhasil) {
    redirect('index.php');
}
// Jika false, tampilkan pesan umum bahwa kredensial salah.
```

**Mengakhiri sesi dari endpoint `public/logout.php`:**

```php
<?php
require_once __DIR__ . '/../src/bootstrap.php';
wajibLogin();
hanyaPost();
cekCsrf();
logout();
redirect('login.php');
```

### Catatan keamanan tambahan

1. `password_verify()` digunakan untuk memeriksa kata sandi terhadap `password_hash` dalam database. Fungsi `prosesLogin()` **tidak** membuat akun atau hash baru.
2. Setelan sesi seperti `cookie_httponly`, `cookie_samesite = Lax`, dan `use_strict_mode` disiapkan oleh `src/bootstrap.php`, **bukan** `src/auth.php`. Untuk server HTTPS produksi, aktifkan juga `cookie_secure`.
3. Token CSRF dipakai oleh endpoint/form melalui `src/helpers.php`. `logout()` sendiri **tidak** memeriksa metode POST atau CSRF, sehingga pemanggil harus memeriksanya.
4. Data sesi di server menjadi dasar pemeriksaan `sudahLogin()`; pembatasan login di `public/login.php` belum setara sistem proteksi serangan login skala produksi.

## 5. Riwayat revisi

| Versi | Tanggal | Perubahan | Penulis |
|---|---|---|---|
| **1.0.1** | **3 November 2026** | Menyusun dokumen `docs/modul/auth.md`, menyesuaikan informasi fungsi, dependensi, keamanan, dan contoh pemakaian dengan kode asli; menambahkan header berkas `src/auth.php` dengan `@version 1.0.1`. Perubahan bersifat dokumentasi, tanpa mengubah logika fungsi. | Nama Peserta (isi sendiri) |

**Catatan versi:** angka `1.0.0` adalah contoh versi dasar pada soal Lab 3; tidak ada bukti riwayat rilis sebelumnya pada kode yang diunggah. Oleh karena itu tabel tidak mengarang tanggal/penulis rilis `1.0.0`. Nomor `1.0.1` digunakan secara konsisten sebagai versi tugas dokumentasi ini.

## 6. Hubungan dengan tugas sebelumnya

- **Lab 1:** identifikasi `src/auth.php` dan keempat fungsi publiknya pada peta modul.
- **Lab 2:** PHPDoc untuk keempat fungsi telah dibuat, termasuk `@param`, `@return`, dan `@throws` bila sesuai.
- **Lab 3:** dokumentasi modul ini memperjelas tanggung jawab, dependensi, keamanan, contoh pemakaian, serta revisi versi file.
