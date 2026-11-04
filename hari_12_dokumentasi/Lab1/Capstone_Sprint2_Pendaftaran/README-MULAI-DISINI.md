# PBL Hari 11 — Capstone Sprint 2 (Pemula, Windows 11 + XAMPP)

> Proyek ini **dikembangkan dari paket PBL Hari 10 Sprint 1 yang tersedia di Library**, bukan salinan proyek XAMPP pribadi. Terdapat kemungkinan nama kolom/config Anda berbeda. Jangan menimpa langsung folder proyek lama. Latihan ini hanya untuk localhost.

## 1. Tujuan
Login admin dari database, kuota kelas aman dengan transaksi, pengujian otomatis, T6 (kasus uji) dan T7 (laporan bug).

## 2. Cara termudah: jalankan sebagai proyek DEMO terpisah
1. **Backup** folder proyek lama dan **Export SQL** database lama melalui phpMyAdmin. Jangan mengimpor `database/skema.sql` yang merupakan arsip Sprint 1 ke database lama.
2. Ekstrak ZIP. Salin folder `Capstone_Hari11_Sprint2` ke `C:\xampp\htdocs\Capstone_Hari11_Sprint2`.
3. Buka folder itu di VS Code (**File > Open Folder**).
4. Jalankan **Apache** dan **MySQL** pada XAMPP Control Panel.
5. Akses `http://localhost/phpmyadmin`, pilih **Import**, impor **`database/skema_demo_sprint2.sql`**. Script ini menciptakan database baru `db_capstone_sprint2_demo` dan tidak memuat `DROP`.
6. Di folder `config`, salin `config.contoh.php` menjadi `config.php`; sesuaikan `db_user`, `db_password`, `db_name`. Untuk demo nama DB harus `db_capstone_sprint2_demo`.
7. Buka **Terminal > New Terminal** pada VS Code (posisi root proyek). Jalankan:
   ```powershell
   & "C:\xampp\php\php.exe" -v
   & "C:\xampp\php\php.exe" database\migrasi-sprint2.php
   & "C:\xampp\php\php.exe" database\buat-admin.php admin SandiKuat123
   ```
   **Kata sandi itu hanya contoh tugas:** untuk penggunaan selain demo buat kata sandi unik lebih panjang; perintah di terminal dapat tercatat pada histori/proses.
8. Buka pendaftaran publik: `http://localhost/Capstone_Hari11_Sprint2/public/daftar.php`.
9. Buka login: `http://localhost/Capstone_Hari11_Sprint2/public/login.php` (username `admin`, password sesuai nomor 7).
10. Setelah masuk, kunjungi `index.php`, `tambah.php`, `ubah.php`, `hapus.php` dan `cetak.php`. Hanya admin yang boleh mengaksesnya. **Peserta publik tidak bisa mencetak PDF sendiri setelah Sprint 2**, mengikuti instruksi Hari 11. Jika PDF belum berfungsi, jalankan `composer install` pada root proyek untuk memasang Dompdf (proyek Sprint 1 asal memiliki composer.json; vendor belum disertakan).

## 3. Jika melanjutkan database proyek Hari 9/10 yang sudah ada
- **Jangan mengimpor skema_demo_sprint2.sql ke database lama!** Salin dulu database lama sebagai cadangan, misalnya `db_capstone_backup` melalui export phpMyAdmin.
- Salin folder ZIP Sprint 2 ke folder **baru**, jangan mengganti proyek yang ada secara otomatis.
- Dalam `config/config.php`, ubah `db_name` ke database milik Anda (`db_capstone_sprint0`, `db_pendaftaran_sprint1`, atau yang sesuai kondisi sebenarnya).
- Jalankan sekali `php database/migrasi-sprint2.php`: jika kolom `kelas.kuota` belum ada ditambahkan dengan kuota default 30, tabel `admin` dibuat jika belum ada, dan indeks kelas dibuat bila perlu. **Tidak ada `DROP TABLE`** pada skrip migrasi.
- Jalankan di phpMyAdmin untuk mencermati kelas yang sudah terisi melebihi kuota 30:
  ```sql
  SELECT k.id,k.nama_kelas,k.kuota,COUNT(p.id) AS terisi
  FROM kelas k LEFT JOIN pendaftar p ON p.kelas_id=k.id
  GROUP BY k.id,k.nama_kelas,k.kuota;
  ```
  Sesuaikan kuota secara sengaja (jangan mengurangi data pendaftar). Sebelum merge kode ke proyek asli, bandingkan perubahan setiap file: `src/bootstrap.php`, `src/helpers.php`, `src/pendaftar.php`, `templates/header.php`, `templates/_form.php`, `public/*`. Pada versi awal beberapa proyek menyimpan tanggal sebagai `tgl_daftar`, versi Sprint 1 menggunakan `tanggal_daftar`.
- Jika tabel `admin` lama memakai kolom berbeda, selaraskan lebih dulu dengan skema Hari 11. Jangan memaksa migrasi tanpa memeriksa bentuk tabel.

## 4. Cara kerja login
- `database/buat-admin.php` memakai `password_hash()`; tabel menyimpan **hash**, tidak menyimpan password asli.
- `src/auth.php`: `cariAdmin` memakai query parameter `:u`; `prosesLogin` memakai `password_verify()` dan mengisi `$_SESSION['admin_id']`; `wajibLogin()` menjaga halaman admin; `logout()` menghancurkan sesi.
- `public/login.php`: CSRF dan pembatasan lima percobaan per sesi selama 15 menit (untuk latihan). Pembatasan per sesi **bisa dihindari dengan menghapus cookie** dan tidak cocok sebagai perlindungan produksi.
- `public/logout.php`: hanya POST + token CSRF.
- `public/daftar.php` tetap publik. `public/cetak.php` khusus admin berdasarkan tugas Hari 11, meskipun Sprint 1 memungkinkan peserta dengan izin sesi mencetak bukti sendiri.

## 5. Cara kerja kuota
- `database/skema_demo_sprint2.sql` menciptakan kelas dengan kuota 3, 5, 2 sebagai data **contoh**.
- `src/kuota.php` memakai transaksi (`beginTransaction`, `commit`, `rollBack`) dan `SELECT kuota ... FOR UPDATE` sebelum COUNT dan INSERT. Kunci baris kelas memastikan kedua pendaftar yang mencoba kursi terakhir diproses secara bergiliran bila **semua jalur menulis menerapkan protokol penguncian yang sama**.
- `public/daftar.php` dan `tambah.php` memanggil `daftarkanDenganKuota()`. `ubah.php` memakai `ubahPendaftarDenganKuota()` agar perpindahan kelas tak menembus batas.
- Tampilan pilihan kelas menampilkan `sisa / kuota`. Angka tampilan dapat berubah karena pendaftaran concurrent; keputusan akhir selalu melalui pengecekan server di dalam transaksi.
- Pengujian balapan sejati (dua request bersamaan) harus diuji di lingkungan MySQL lokal terpisah. Skrip integrasi dasar hanya menguji percobaan dua kali secara berurutan.

## 6. Uji otomatis dan regresi
Di terminal root:
```powershell
& "C:\xampp\php\php.exe" tests\jalankan.php
& "C:\xampp\php\php.exe" tests\uji-integrasi.php
```
- `tests/jalankan.php`: **16 unit test**, tidak memerlukan database.
- `tests/uji-integrasi.php`: memerlukan **database MySQL** yang aktif. Membuat satu kelas uji dengan kuota 1, memastikan pendaftar pertama berhasil dan kedua ditolak, kemudian membersihkan data uji. JANGAN menjalankan pada data produksi.
- Latihan regresi: sementara ganti `max(0, $kuota - $terisi)` menjadi `$kuota - $terisi`, jalankan uji, amati kegagalan, dan **pulihkan** kode.
- Uji manual **27 skenario** ada di `docs/kasus-uji.md` dan `docs/kasus-uji.csv`. Isi hasil aktual, status, dan screenshot setelah Anda benar-benar menjalankan browser di XAMPP.

## 7. Cara uji browser dan bukti
- Uji pendaftaran valid: `daftar.php` dengan email unik. Pada kelas yang masih tersedia, layar menampilkan berhasil.
- Isi semua kolom kosong satu per satu; periksa pesan validasi.
- Uji nomor HP 9/10/13/14 digit.
- Isi kelas kuota 1 menggunakan dua email berbeda; peserta kedua harus ditolak.
- Login benar/salah, akses admin dari incognito, ubah URL menjadi `ubah.php?id=abc`, hapus tanpa CSRF dengan bantuan DevTools atau request lokal.
- Pada nama HTML, masukkan `<script>alert(1)</script>`; teks boleh tersimpan, tetapi jangan sampai dieksekusi pada halaman admin (output e()).
- Pada `public/index.php` tersedia pencarian server berdasarkan nama/email (selain DataTables). Uji input berisi petikan SQL hanya pada aplikasi lokal sendiri. `cariPendaftar()` memakai PDO prepared statement; input tidak boleh menjadi bagian sintaks SQL.
- Setiap kasus perlu screenshot bukti dari browser / DevTools Network (kode status) atau phpMyAdmin. Lihat `docs/kasus-uji.md`.

## 8. Laporan Bug T7
Terdapat **6 temuan nyata dari pemeriksaan kode dasar Sprint 1** di `docs/laporan-bug.md`. Status *ditemukan lewat inspeksi kode*, bukan klaim bahwa sudah berhasil direproduksi pada browser lokal Anda. Setelah uji manual, lengkapi gejala aktual, bukti, retest, dan status.

## 9. Pemeriksaan akhir
- Cek `config/config.php` berisi `'debug' => false`, lalu restart Apache atau refresh browser.
- Pastikan tidak ada `var_dump()` / `console.log()` aktif dalam `src`, `public` dan `templates`. Kata-kata itu boleh muncul di dokumentasi uji.
- Jalankan `php -l` pada file PHP yang diubah, `tests/jalankan.php`, `tests/uji-integrasi.php`, dan uji manual kritis login, kuota, CSRF, XSS, ID dan cetak PDF.
- **Keterbatasan verifikasi yang dilakukan saat paket disusun:** PHP CLI tersedia untuk lint dan unit test, tetapi lingkungan pembuat paket tidak mempunyai driver PDO MySQL/MariaDB dan server DB. Pengujian login/database HTTP yang sebenarnya **belum dijalankan**; harap lakukan di XAMPP lokal, jangan menandai LULUS sebelum memiliki bukti.
