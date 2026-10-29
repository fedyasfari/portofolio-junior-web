# PBL Hari 8 — Proyek 4: Buku Tamu Berbasis File

Proyek latihan PHP 8+ untuk membangun buku tamu digital sekolah **tanpa MySQL**.

## Jalankan dalam 5 langkah

1. Instal dan buka XAMPP (PHP versi 8.0 atau lebih baru).
2. Jalankan **Apache** di XAMPP Control Panel.
3. Salin folder `proyek-4-buku-tamu` ke `C:\xampp\htdocs\hari-08\`.
4. Buka `http://localhost/hari-08/proyek-4-buku-tamu/index.php`.
5. Coba kirim pesan, cari nama, lalu buka `uji.php`.

## Berkas proyek

| Nama | Fungsi |
| --- | --- |
| `index.php` | Form POST, validasi, pesan galat, daftar tamu, pencarian GET, pagination, PRG |
| `functions.php` | Seluruh fungsi berisi logika program, lengkap dengan tipe dan DocBlock |
| `data/.htaccess` | Blokir akses HTTP langsung ke JSON, password hash, dan berkas kunci |
| `data/tamu.json` | Dibuat otomatis saat pesan pertama disimpan |
| `admin.php` | Setup password admin, login, dan soft delete (tantangan) |
| `export-csv.php` | Ekspor CSV hanya saat admin masuk (tantangan) |
| `uji.php` | Uji fungsi tanpa mengubah file tamu |
| `style.css` | Tampilan responsif, tanpa CSS inline |
| `docs/PANDUAN-PEMULA.md` | Panduan langkah demi langkah, penjelasan konsep, dan tes manual |
| `.gitignore` | Cegah file JSON pribadi dan hash password masuk ke Git |

## Tugas inti: terpenuhi

- [x] Validasi server per kolom; input tetap terisi jika gagal.
- [x] `json_encode` / `json_decode`, folder data dibuat jika belum ada.
- [x] Urutan terbaru, GET `q`, `stripos` tanpa peka kapital.
- [x] `htmlspecialchars()` untuk data dari pengguna.
- [x] Pola Post/Redirect/Get (PRG) setelah berhasil.
- [x] Proteksi `data/.htaccess` untuk Apache 2.4+.
- [x] Fungsi bertipe dan DocBlock; logika terpisah dari tampilan.

## Tantangan: terpenuhi

- [x] `array_slice` untuk 5 pesan per halaman.
- [x] Satu pesan setiap 30 detik per alamat IP.
- [x] Soft delete melalui `admin.php`.
- [x] Ekspor CSV melalui `export-csv.php`.

## Cara menggunakan Admin

1. Buka `http://localhost/hari-08/proyek-4-buku-tamu/admin.php` di **komputer yang menjalankan XAMPP**.
2. Pada kunjungan pertama, buat password sendiri (minimal 10 karakter).
3. Setelah login, pilih **Hapus** di samping pesan jika ingin menyembunyikan pesan dari publik.
4. Klik **Unduh CSV** untuk mengunduh data yang belum dihapus.
5. Jika logout, masukkan password yang tadi dibuat untuk login kembali.

Kata sandi disimpan sebagai *hash* di `data/admin.hash`, bukan sebagai teks asli. Pengaturan pertama kali dibatasi untuk akses localhost.

> **Khusus latihan lokal.** Jika akan dipublikasikan di internet, aktifkan HTTPS, autentikasi admin yang lebih lengkap, pembatasan brute-force, dan tinjau perlindungan data pribadi. Email pengunjung hanya terlihat oleh admin; CSV berisi email, jangan dibagikan sembarangan.

## Tes

- Buka `http://localhost/hari-08/proyek-4-buku-tamu/uji.php`.
- Tes manual (form, PRG, pagination, IP limit, admin, ekspor, akses folder) ada di `docs/PANDUAN-PEMULA.md`.
- Folder `data/tamu.json` dan `data/admin.hash` sengaja **tidak disertakan** dan otomatis dibuat oleh program, sehingga proyek dimulai dengan data kosong.
