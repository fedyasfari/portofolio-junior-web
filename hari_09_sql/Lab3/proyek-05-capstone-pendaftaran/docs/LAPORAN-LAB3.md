# LAPORAN PRAKTIKUM LAB 3 — MODUL CRUD PENDAFTAR

**Nama:** …  
**Kelas:** …  
**Tanggal:** …  
**Mata pelajaran:** Database dan Pemrograman PHP  
**Lingkungan:** XAMPP (Apache, PHP, MySQL/MariaDB), phpMyAdmin, VS Code.

## 1. Tujuan

Membangun aplikasi CRUD pendaftar menggunakan PDO, validasi input, pencarian, paginasi, pengamanan HTML output, dan token CSRF.

## 2. Alat

Laptop/PC Windows, XAMPP, VS Code, browser, file proyek ZIP Lab 3.

## 3. Langkah praktik

1. Ekstrak proyek ke `C:\xampp\htdocs\`.
2. Jalankan Apache dan MySQL.
3. Import skema untuk instalasi baru atau migrasi khusus dari Lab 2 bila data lama perlu dipertahankan.
4. Buka halaman daftar, tambah, ubah dan hapus.
5. Jalankan tes fungsi, keamanan, dan pagination.
6. Catat hasil dan screenshot.

## 4. Hasil pengujian

| No. | Pengujian | Hasil yang diharapkan | Realisasi | Nama screenshot |
|---|---|---|---|---|
| 1 | Tambah data valid | Baris baru dan pesan berhasil | … | … |
| 2 | Form kosong | Error validasi, tidak tersimpan | … | … |
| 3 | Email ganda | Pesan email sudah terdaftar | … | … |
| 4 | Kelas tidak dipilih | Error pilihan kelas | … | … |
| 5 | Ubah data | Data berubah | … | … |
| 6 | Hapus data | Data terhapus melalui POST | … | … |
| 7 | Pencarian nama | Hanya data cocok yang muncul | … | … |
| 8 | `ubah.php?id=abc` | HTTP 404 | … | … |
| 9 | `ubah.php?id=9999` | HTTP 404 | … | … |
| 10 | POST hapus tanpa CSRF | HTTP 403, data aman | … | … |
| 11 | Nama `<script>alert(1)</script>` | Muncul sebagai teks, bukan alert | … | … |
| 12 | Total data >10 | Halaman 2 bisa diakses | … | … |

## 5. Pembahasan

**a. CRUD**: CREATE menambah data lewat INSERT, READ mencari lewat SELECT/JOIN, UPDATE mengubah data berdasarkan ID, dan DELETE menghapus data terpilih.

**b. Validasi**: Server memeriksa nama, email, HP, pilihan kelas, dan panjang alamat. Email juga dibatasi UNIQUE oleh MySQL.

**c. CSRF**: Semua form POST menyertakan token session. Request penghapusan tanpa token menghasilkan HTTP 403.

**d. XSS**: Fungsi `e()` menggunakan `htmlspecialchars`, sehingga teks `<script>` ditampilkan dalam HTML sebagai teks biasa.

**e. Paginasi**: Jumlah data dihitung terpisah, lalu data dibatasi `LIMIT 10 OFFSET ...` menggunakan integer PDO.

## 6. Kesimpulan

Aplikasi CRUD berhasil dibangun dengan PDO dan prepared statements. Validasi data, token CSRF, dan HTML escaping membantu melindungi aksi dan tampilan dari masukan yang tidak sesuai. Fitur pencarian dan paginasi memudahkan pengelolaan data pendaftar dalam jumlah lebih banyak.

**Catatan:** isi kolom realisasi dan screenshot sesuai percobaan sesungguhnya; jangan mengaku pengujian berhasil sebelum dijalankan pada komputer sendiri.
