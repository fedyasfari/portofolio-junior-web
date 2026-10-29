# Lab 3 — CRUD Pendaftar, validasi, pencarian, paginasi, dan keamanan

**Proyek PHP + PDO + MySQL / MariaDB untuk XAMPP**, kelanjutan dari Lab 2. Seluruh file dari struktur tugas Lab 3 disertakan, ditambah pilihan migrasi data Lab 2 dan data opsional untuk menguji paginasi.

## Mulai cepat

1. Ekstrak folder proyek ke `C:\xampp\htdocs\proyek-5-capstone-pendaftaran`.
2. Nyalakan Apache dan MySQL pada XAMPP.
3. Buka `http://localhost/phpmyadmin/`. **Pilih satu**:
   - Instal baru/reset data latihan → impor `database/skema.sql` (MERESet tabel lama).
   - Sudah punya database Lab 2 dari paket sebelumnya → backup dahulu; impor `database/migrasi-dari-lab2.sql` (hanya sekali, menyimpan data lama).
4. Periksa kredensial lokal di `config/config.php`. File ini diabaikan oleh Git.
5. Buka `http://localhost/proyek-5-capstone-pendaftaran/public/index.php`.
6. Jalankan pengujian yang tertera di `docs/PANDUAN-LAB3.md`.

## Perubahan penting dari Lab 2

Schema Lab 2 memakai `id_kelas` / `id_pendaftar`, sedangkan soal Lab 3 memakai `kelas.id` / `pendaftar.id` / `pendaftar.kelas_id` dan `alamat`. File kode, database, dan demo SQL Injection sudah diselaraskan. Kolom `tanggal_daftar` tetap ada dengan default otomatis agar fungsi lama tetap relevan.

## File penting

- `src/bootstrap.php` — session, konfigurasi, require, exception handler.
- `src/helpers.php` — e(), redirect(), tokenCsrf(), cekCsrf(), setFlash(), ambilFlash().
- `src/pendaftar.php` — 9 fungsi akses data + validasi.
- `public/index.php` — daftar, JOIN, pencarian, 10 data/halaman.
- `public/tambah.php`, `ubah.php`, `hapus.php`, `_form.php` — CRUD dan form bersama.
- `database/skema.sql` — instal baru, **menghapus tabel data latihan lama**.
- `database/migrasi-dari-lab2.sql` — konversi skema Lab 2 bila ingin menjaga data, jalankan sekali.
- `database/tambah-data-pagination.sql` — tambahan empat pendaftar, pengujian page 2.
- `docs/PANDUAN-LAB3.md` — panduan terperinci, pengujian wajib dan troubleshooting.
- `docs/LAPORAN-LAB3.md` — template laporan praktikum.

## Keamanan dan batasan

- SQL biasa: prepared statements dan bound integer untuk LIMIT/OFFSET.
- Form POST: token CSRF, validasi server, redirect setelah sukses.
- Output HTML: escaped dengan `e()`.
- Demo `public/injeksi.php` **sengaja rentan**, hanya untuk localhost seperti Lab 2; jangan unggah ke server publik.
- Belum tersedia login/perizinan pengguna; aplikasi ini **untuk pembelajaran lokal, bukan produksi**.
- Jangan commit `config/config.php` atau sandi sebenarnya ke repository.

## Uji sintaks dan integrasi

Semua file PHP dapat dicek dengan `php -l path/to/file.php`. Koneksi MySQL dan klik semua form tetap harus diuji sendiri di server XAMPP karena database pada komputer Anda tidak dapat diakses dari sini.
