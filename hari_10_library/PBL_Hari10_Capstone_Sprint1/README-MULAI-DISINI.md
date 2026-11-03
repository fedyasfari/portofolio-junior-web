# PBL Hari 10 — Capstone Sprint 1

**Proyek referensi yang utuh** untuk latihan PHP 8.1+, XAMPP, MySQL, Bootstrap, DataTables, SweetAlert2, Dompdf, Composer, dan Git. Proyek ini **bukan** folder Capstone Hari 9 asli, karena berkas proyek asli belum dilampirkan di percakapan. Untuk menghindari hilangnya pekerjaan sebelumnya, jalankan paket ini di **folder dan database yang berbeda** dahulu; setelah lulus uji baru gabungkan perubahan dengan cermat.

## Target 8 tugas
1. Semua halaman Bootstrap: navbar ponsel, form, tabel dan alert.
2. Halaman admin `index.php` memakai DataTables (cari, urut, pagination).
3. SweetAlert2 untuk konfirmasi Hapus dan toast flash berhasil.
4. PDF bukti A5 lewat `cetak.php?id=...`, nomor REG-TAHUN-000001.
5. Pendaftaran publik `daftar.php` tanpa login.
6. `docs/daftar-library.md` memuat versi, lisensi, alasan, alternatif, dependency, status rilis.
7. Perintah `composer outdated`, `composer audit`, dan `npm outdated` **hanya jika ada package.json**; hasil aktual disediakan kolom untuk diisi.
8. `.gitignore` sudah memuat `vendor/`, `node_modules/`, `config/config.php`; **composer.lock dihasilkan Composer** setelah pemasangan dan baru dapat di-commit.

## LANGKAH 1 — Ekstrak folder dengan nama baru

Ekstrak ZIP. Pindahkan folder `PBL_Hari10_Capstone_Sprint1` ke:

```text
C:\xampp\htdocs\PBL_Hari10_Capstone_Sprint1
```

**Jangan** salin isinya ke proyek Hari 9 terlebih dahulu. Di VS Code, File → Open Folder → folder tersebut.

## LANGKAH 2 — Jalankan XAMPP

Di XAMPP Control Panel klik **Start** pada **Apache** dan **MySQL**. Buka `http://localhost/phpmyadmin`.

1. Pilih tab **Import**, klik Choose File, pilih `database/skema.sql`, klik **Import**.
2. SQL membuat database latihan **baru** bernama `db_pendaftaran_sprint1`, dua tabel (`kelas`, `pendaftar`), dan tiga kelas contoh.
3. Jika muncul error *foreign key* atau tabel sudah ada, pastikan memilih SQL lengkap, dan jangan impor ulang ke database Capstone lama.

## LANGKAH 3 — Buat file konfigurasi privat

Di VS Code salin `config/config.contoh.php` → beri nama `config/config.php`. Ubah `db_name`, `db_user`, dan `db_password` sesuai MySQL Anda. Untuk XAMPP lokal standar, akun `root` biasanya tanpa password. Jangan gunakan konfigurasi tanpa password saat membuka aplikasi ke internet.

### Buat password admin (jangan gunakan password contoh)

Di VS Code pilih Terminal → New Terminal, jalankan:

```powershell
C:\xampp\php\php.exe tools\buat-hash-password.php
```

Masukkan **password admin baru minimal 12 karakter**. Terminal akan menampilkan hash seperti `$2y$...`. Salin seluruh hash ke bagian `admin_password_hash` dalam `config/config.php`:

```php
'admin_email' => 'admin@example.test',
'admin_password_hash' => 'HASH_HASIL_TERMINAL_ANDA',
```

Password mentah jangan disimpan di file config atau Git. Jika Anda mengganti email, gunakan email tersebut ketika login. Halaman publik tetap bebas login.

## LANGKAH 4 — Composer / Dompdf

Pastikan Composer terpasang (`composer --version`). Di terminal root proyek:

```powershell
cd C:\xampp\htdocs\PBL_Hari10_Capstone_Sprint1
composer validate
composer install
composer show dompdf/dompdf
composer outdated
composer audit
```

Proyek ini menyertakan `composer.json`, **belum `composer.lock`** karena lock yang sah harus dihasilkan oleh dependency resolver Composer. Pada instalasi awal ketika belum ada `composer.lock`, Composer menyelesaikan dependency dan membuat lock; jika instalasi awal Anda memerlukan langkah eksplisit, jalankan `composer update` sekali, lalu `composer install`. Setelah berhasil, folder `vendor/` dan `composer.lock` akan ada.

> Jika Composer gagal karena `ext-dom` atau `ext-mbstring` tidak aktif, buka `C:\xampp\php\php.ini` lalu aktifkan ekstensi yang diminta, tutup/buka ulang terminal, dan jalankan ulang Composer. Gunakan PHP XAMPP yang sama di terminal dan Apache.

## LANGKAH 5 — Jalankan di browser

- **Pendaftaran peserta publik, tanpa login:** `http://localhost/PBL_Hari10_Capstone_Sprint1/public/daftar.php`
- **Login admin:** `http://localhost/PBL_Hari10_Capstone_Sprint1/public/login.php`
- **Daftar admin:** `http://localhost/PBL_Hari10_Capstone_Sprint1/public/index.php` (memerlukan login)

Coba daftar sebagai peserta menggunakan **data latihan**, lalu klik Cetak Bukti PDF. Login admin untuk memeriksa DataTables, tambah, ubah, cetak, dan hapus.

Tombol **Cetak** untuk peserta umum hanya dapat digunakan pada sesi browser yang membuat pendaftaran. Setelah sesi kedaluwarsa, bukti harus dicetak oleh admin atau dikembangkan lagi dengan token bukti yang aman. Ini mencegah orang lain menebak URL ID dan mengunduh data peserta.

## LANGKAH 6 — Tes tampilan 360 px dan DataTables

1. Buka halaman di Chrome/Edge, tekan `F12`, lalu `Ctrl+Shift+M`, atur lebar **360 px**.
2. Klik ikon hamburger navbar dan pastikan menu terbuka/tertutup.
3. Periksa form tetap satu kolom dan pesan galat berada di bawah field terkait.
4. Login admin, lihat tabel DataTables. Isi minimal **11 baris** data latihan jika hendak menguji halaman kedua.
5. Ketik nama di kotak Cari; klik judul kolom Nama/Kelas untuk mengurutkan. **Aksi** tidak bisa diurutkan.
6. Pada halaman kedua DataTables, klik Hapus → Batal (data tidak terhapus), lalu coba konfirmasi terhadap data dummy. CSRF harus tetap diperiksa oleh PHP.
7. Periksa halaman tambah/ubah/logout dan toast sukses.
8. Buka PDF; periksa identitas, kelas, tanggal, nomor `REG-YYYY-NNNNNN`, A5 portrait.
9. Tekan `F12` → Console. Catat seluruh error dan perbaikannya. Perhatikan: library CSS/JS menggunakan CDN, sehingga komputer memerlukan akses internet.

## LANGKAH 7 — Audit dependency & catat hasil

```powershell
composer outdated
composer audit
composer licenses
```

**npm outdated:** proyek inti memakai CDN (tidak ada `package.json` pada root), sehingga catat **"tidak berlaku di root — tidak ada package.json"**. Jika sudah membuat `hari-10-update/` dari Lab 6, lakukan:

```powershell
cd hari-10-update
npm.cmd outdated
npm.cmd audit
```

Lalu isi tabel **hasil nyata** di `docs/LAPORAN-SPRINT1.md`. Jangan menyatakan tidak ada kerentanan sebelum benar-benar menjalankan `composer audit` dan `npm audit`.

## LANGKAH 8 — .gitignore dan commit

Dari root proyek Sprint 1:

```powershell
git init
git status --short
git add .
git status --short
git commit -m "PBL Hari 10: Capstone Sprint 1"
git ls-files composer.json composer.lock
git check-ignore vendor config/config.php
```

Sebelum commit, pastikan `composer.lock` **sudah dibuat** oleh Composer. Bila belum, jangan mengklaim tugas kedelapan telah selesai. Pastikan `config/config.php` dan `vendor/` tidak ikut commit. `node_modules/` juga diabaikan bila ada.

## Struktur proyek

```text
PBL_Hari10_Capstone_Sprint1/
├── .gitignore
├── composer.json
├── composer.lock             # BARU muncul setelah Composer dijalankan
├── config/
│   ├── config.contoh.php     # boleh commit
│   └── config.php            # buat sendiri, jangan commit
├── database/skema.sql
├── src/bootstrap.php, helpers.php, database.php, pendaftar.php
├── templates/header.php, footer.php, _form.php, bukti.php
├── public/
│   ├── daftar.php, sukses.php, login.php, logout.php
│   ├── index.php, tambah.php, ubah.php, hapus.php, cetak.php
│   └── assets/js/app.js
├── tools/buat-hash-password.php
└── docs/daftar-library.md, LAPORAN-SPRINT1.md
```

## Jika Anda ingin memakai proyek Hari 9 yang sudah ada

Jangan langsung menimpa seluruh folder. Proyek contoh ini memiliki skema dan autentikasi admin sendiri. **Periksa perbedaan** pada `config`, nama kolom tanggal, tanda tangan fungsi pada `src/pendaftar.php`, session helper, dan file view. Manfaatkan file contoh sebagai **referensi kode**, lalu merge secara bertahap agar perubahan Hari 9 tidak hilang. Bagian paling baru adalah `public/daftar.php`, `public/sukses.php`, `public/login.php`, serta pengamanan admin. Simpan backup database terlebih dahulu.

## Troubleshooting penting

| Gejala | Penyebab umum | Solusi |
|---|---|---|
| `Unknown database` atau SQLSTATE[HY000] | Database belum diimpor / nama berbeda | Import `database/skema.sql`, sesuaikan `db_name` |
| `Call to undefined function mb_strlen()` | mbstring belum aktif | Aktifkan `extension=mbstring` di php.ini XAMPP |
| `could not find driver` | ekstensi pdo_mysql belum aktif | Aktifkan `extension=pdo_mysql`, restart Apache/terminal |
| Composer gagal ext-dom | PHP DOM extension belum aktif | Aktifkan ekstensi XML/DOM sesuai instalasi PHP |
| Login admin selalu gagal | Hash password masih kosong atau keliru | Jalankan `tools/buat-hash-password.php` dan paste hash lengkap |
| `Class Dompdf... not found` | `vendor/` belum terpasang | Jalankan `composer install` |
| PDF kosong / error headers | Ada echo/BOM sebelum `stream()` | Pastikan `cetak.php` tidak mencetak output sebelum stream, pakai ob_get_clean |
| DataTables tidak aktif | JS tidak termuat atau jQuery terlambat | Periksa F12 Network; urutan pemuatan di footer |
| Navbar tidak bisa dibuka | Bootstrap bundle JS gagal dimuat | Pastikan `bootstrap.bundle.min.js` tersedia |
| SweetAlert konfirmasi tak muncul | CDN mati atau app.js salah path | Periksa Network; server tetap menolak penghapusan tanpa konfirmasi |
| DataTables jumlah kolom berbeda | `<thead>` dan `<tbody>` tidak cocok | Lima header, lima `<td>` setiap baris; untuk data kosong biarkan `<tbody>` kosong |
| PDF 403 | Cetak ID orang lain tanpa hak akses | Cetak bukti dari sesi pendaftaran atau masuk sebagai admin |
| `composer.lock` belum ada | Instalasi dependency belum selesai | Jalankan `composer install` / `composer update` dan commit setelah terbentuk |

## Lingkup keamanan

Proyek ini untuk **latihan lokal**, belum sistem produksi lengkap. Sudah mencakup validasi POST, token CSRF, output escaping, prepared statements, auth admin, dan pembatasan PDF menurut sesi. Untuk produksi tambahkan HTTPS, manajemen pengguna dan peran, pengaturan session/cookie secure, CSRF defense-in-depth, rate limiting berbasis server, pemantauan keamanan dependency, serta arahkan DocumentRoot web hanya ke folder `public/`.
