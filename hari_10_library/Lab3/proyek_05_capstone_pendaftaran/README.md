# Proyek 5 — Capstone Pendaftaran Pelatihan (PBL Hari 9, Sprint 0)

Proyek pembelajaran **PHP 8.1+, PDO MySQL/MariaDB, HTML/CSS** untuk merancang Sistem Pendaftaran Pelatihan dan menjalankan modul CRUD peserta dari Lab 3.

## Ruang lingkup Sprint 0
- Berfungsi: formulir pendaftaran peserta, daftar admin simulasi, tambah, ubah, hapus, pencarian, paginasi, validasi, CSRF dan escaping HTML.
- Baru dirancang (belum diimplementasikan): PDF bukti pendaftaran (Hari 10), login admin dan kuota kelas (Hari 11).
- **Hanya untuk lingkungan lokal.** Halaman data admin belum terlindungi autentikasi sampai Hari 11; **jangan dipublikasikan ke internet** atau gunakan data pribadi sungguhan.

## Jalankan di XAMPP
1. Simpan folder ini di `C:\xampp\htdocs\proyek-5-capstone-pendaftaran`.
2. Start **Apache** dan **MySQL**.
3. phpMyAdmin: impor `database/skema.sql` (**hanya pada database latihan; impor ulang mereset tabel dan data**).
4. Salin `config/config.contoh.php` menjadi `config/config.php` lalu isi sandi database lokal.
5. Buka `http://localhost/proyek-5-capstone-pendaftaran/public/`.
6. Form peserta: `public/daftar.php`, daftar admin simulasi: `public/index.php`.

## Dokumentasi
Buka `docs/07-PANDUAN-PEMULA.md` dahulu. Analisis, backlog, ERD, wireframe, uji CRUD, dan Git ada di folder `docs/`. Diagram wireframe juga tersedia di `wireframes/`.

## Keamanan
- Query dengan nilai input dibuat menggunakan prepared statement.
- Output yang berasal dari pengguna dan database di-escape via `e()`.
- Tambah, ubah, hapus menggunakan CSRF token.
- `config/config.php` ada pada `.gitignore` dan **tidak disertakan** dalam proyek arsip.
- File contoh SQL Injection Lab 2 sengaja **tidak disertakan**, karena proyek ini bukan laboratorium SQL Injection.

## Git
Empat commit historis tersedia melalui `riwayat-git-sprint0.bundle` yang disertakan **di sebelah folder proyek** pada arsip utama. Lihat `docs/06-GIT-DAN-COMMIT.md` untuk memulihkan riwayat dan mengecek `git log`.
