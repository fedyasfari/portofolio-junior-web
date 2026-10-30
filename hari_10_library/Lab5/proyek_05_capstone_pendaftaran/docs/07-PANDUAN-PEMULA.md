# 07 — Panduan Tahap demi Tahap (Pemula)

Panduan ini dibuat untuk menyelesaikan **PBL Hari 9 – Capstone Sprint 0: Analisis, Desain, dan Modul CRUD**.

## 1. Persiapan alat
- Windows + XAMPP (Apache, MySQL/MariaDB, PHP 8.1+), Chrome/Edge, VS Code.
- Git/Git Bash untuk riwayat commit; jika belum ada, unduh dari situs resmi Git.
- Seluruh tugas dilakukan pada server lokal; jangan memakai data pribadi asli.

## 2. Memahami hasil yang diminta
1. Analisis kebutuhan → `docs/01-ANALISIS-KEBUTUHAN.md`.
2. Backlog ≥10 user story → `docs/02-BACKLOG-USER-STORY.md` (14 story).
3. ERD dan tabel kelas, pendaftar, admin → `docs/03-DESAIN-BASIS-DATA.md` dan `database/skema.sql`.
4. Wireframe 3 halaman → `docs/04-WIREFRAME-TIGA-HALAMAN.md`, `wireframes/*.svg`.
5. CRUD dan pengujian → kode dalam `src/`+`public/`, `docs/05-RENCANA-PENGUJIAN-CRUD.md`.
6. Git dan 4 commit → `.gitignore`, `README.md`, `docs/06-GIT-DAN-COMMIT.md`, bundle Git.

## 3. Ekstraksi proyek
1. Unduh `PBL_Hari9_Sprint0_Capstone_Lengkap.zip`.
2. Klik kanan → Extract All.
3. Salin **folder** `proyek-5-capstone-pendaftaran` ke `C:\xampp\htdocs\`.
4. Pastikan hasilnya: `C:\xampp\htdocs\proyek-5-capstone-pendaftaran\public\index.php`.
5. Hindari folder bertumpuk (misal `...\proyek-5-capstone-pendaftaran\proyek-5-capstone-pendaftaran\`).
6. Jika ada folder dengan nama yang sama dari Lab 3, buat backup lalu pindahkan proyek lama terlebih dahulu.

## 4. Menjalankan Apache dan MySQL
1. Buka XAMPP Control Panel.
2. Klik **Start** pada Apache lalu MySQL.
3. Tunggu status keduanya berubah menjadi aktif.
4. Buka `http://localhost/phpmyadmin/`.
5. Jika halaman tidak muncul, periksa apakah Apache menggunakan port selain 80 atau apakah layanan lain mengambil port tersebut.

## 5. Mengimpor database
1. Pada phpMyAdmin, buka tab **Import**.
2. Klik Choose File → pilih `database/skema.sql`.
3. Klik **Go / Kirim** dan pastikan tidak muncul pesan gagal.
4. Klik database `db_capstone_sprint0` di panel kiri.
5. Periksa ada tabel `kelas`, `pendaftar`, dan `admin`.
6. Jalankan SQL:

```sql
USE db_capstone_sprint0;
SELECT COUNT(*) AS total_kelas FROM kelas;
SELECT COUNT(*) AS total_pendaftar FROM pendaftar;
SELECT COUNT(*) AS total_admin FROM admin;
```

Hasil awal harus **3**, **12**, dan **0**. **Peringatan:** skema berisi `DROP TABLE` hanya pada database latihan ini; impor ulang akan menghapus data yang sebelumnya Anda masukkan di database tersebut.

## 6. Mengatur koneksi PDO
1. Di VS Code, buka folder proyek.
2. Di folder `config`, duplikat `config.contoh.php`, beri nama `config.php`.
3. Isi `host`, `nama_db`, `user`, `sandi` sesuai MySQL lokal.
4. Contoh XAMPP tanpa password: `host=localhost`, `nama_db=db_capstone_sprint0`, `user=root`, `sandi=''`.
5. Simpan perubahan. Jangan kirim `config.php` ke Git, screenshot, atau teman.

## 7. Mengakses halaman aplikasi
- Form peserta: `http://localhost/proyek-5-capstone-pendaftaran/public/daftar.php`
- Daftar admin simulasi: `http://localhost/proyek-5-capstone-pendaftaran/public/index.php`
- Tambah admin: `http://localhost/proyek-5-capstone-pendaftaran/public/tambah.php`
- Ubah: klik tombol Ubah pada tabel.
- Hapus: klik tombol Hapus pada tabel (POST + token CSRF).

**Pengingat:** Dashboard admin belum memakai login; **jangan dipublikasikan** sampai fitur autentikasi benar-benar diterapkan di Hari 11.

## 8. Praktik lengkap CRUD
### CREATE
Buka `daftar.php` atau `tambah.php` → Nama `Rina Amelia`, Email unik `rina.amilia@example.com`, HP `081234567890`, kelas Web Development → Simpan. Lihat data bertambah.

### READ
Buka `index.php`. Lihat kolom ID, nama, email, HP, kelas; data terbaru tampil paling atas.

### UPDATE
Klik Ubah pada data Rina → ubah nomor HP → Simpan. Pastikan hanya target yang berubah.

### DELETE
Klik Hapus untuk data fiktif yang memang ingin dihapus → konfirmasi. Periksa data tersebut hilang, data lain tetap ada.

### SEARCH
Masukkan `Andi` di kolom Cari. Klik Cari; hasil yang memuat nama tersebut ditampilkan.

### PAGINATION
Dengan 12 data awal, halaman pertama menunjukkan 10 entri dan halaman kedua 2 entri.

## 9. Menguji keamanan dan validasi
Ikuti tabel lengkap di `05-RENCANA-PENGUJIAN-CRUD.md`. Uji form kosong, email ganda, kelas kosong, HP tidak valid, ID 404, POST hapus tanpa token 403, escaping `<script>`, pencarian yang mengandung karakter `'`, dan log error.

## 10. Memahami tiga wireframe
Buka `wireframes/LIHAT-WIREFRAME.html` dengan browser, atau lihat SVG satu per satu. Wireframe 1 dan 2 sesuai fungsi Sprint 0; wireframe 3 hanya gambaran PDF Hari 10.

## 11. Periksa Git
Buka `06-GIT-DAN-COMMIT.md`, lalu pulihkan bundle riwayat agar empat commit dapat ditampilkan. Foto/screenshot perintah `git log --oneline -4` untuk bukti.

## 12. Kesalahan yang sering terjadi
| Gejala | Penyebab mungkin | Perbaikan |
|---|---|---|
| `404 Not Found` | Nama folder/URL salah | Cek direktori `htdocs` dan nama folder |
| `Access denied` 1045 | Sandi/user MySQL salah | Perbaiki `config/config.php` |
| `Unknown database` 1049 | Skema belum diimpor/nama berbeda | Impor skema dan samakan `nama_db` |
| `could not find driver` | Ekstensi `pdo_mysql` belum aktif | Aktifkan `pdo_mysql` di PHP XAMPP |
| Duplicate entry 1062 | Email sudah digunakan | Gunakan email baru atau ubah data |
| 403 saat tambah/hapus | Token CSRF tidak sah | Buka ulang form dari halaman aplikasi |
| 404 pada `ubah.php?id=abc` | ID bukan bilangan valid | Ini hasil uji yang benar |
| Form kembali tanpa menyimpan | Ada validasi gagal | Lihat pesan merah di bawah kolom |
| Tidak terlihat halaman 2 | Data kurang dari 11 setelah edit/hapus | Impor ulang database latihan atau tambah data contoh |

## 13. Yang dikumpulkan
- Folder sumber lengkap **tanpa kredensial nyata**.
- `docs/01` sampai `docs/10`, 3 SVG wireframe, dan skema.sql.
- Bukti screenshot: database di phpMyAdmin, halaman daftar, form valid/invalid, ubah, hapus, cari, halaman 2, uji 403/404, perintah Git, dan log yang diperiksa.
- Isi laporan dari `docs/08-TEMPLATE-LAPORAN.md` dengan hasil uji sebenarnya; jangan mengklaim tes koneksi yang belum dijalankan.

## 14. Setelah Sprint 0
Hari 10: bangun cetak PDF dengan akses aman. Hari 11: implementasi login+otorisasi serta penegakan kuota secara transaksional. Pada Sprint 0 keduanya hanya dirancang, bukan selesai.
