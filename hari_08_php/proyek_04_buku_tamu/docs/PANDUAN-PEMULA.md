# Panduan Pemula — PBL Hari 8 Proyek 4: Buku Tamu Berbasis File

## 1. Tujuan belajar

Anda membangun aplikasi buku tamu digital sekolah menggunakan PHP, HTML, CSS, dan file JSON, **tanpa database**. Pengunjung mengisi nama, email, dan pesan. Pesan yang tersimpan tampil dengan yang terbaru di atas, dapat dicari berdasarkan nama.

Kemampuan yang dipelajari:
- Form `method="post"` dan cara PHP membaca `$_POST`.
- Validasi server, `filter_var`, `trim`, `mb_strlen` (jika tersedia).
- Menyimpan dan membaca file dengan `file_put_contents`, `file_get_contents`, `json_encode`, `json_decode`.
- Pencarian melalui `$_GET['q']`, `stripos`, dan `array_filter`.
- Escaping HTML dengan `htmlspecialchars`.
- PRG (`header('Location: ...', true, 303)` setelah berhasil menyimpan).
- Tantangan: pagination `array_slice`, limit 30 detik per IP, soft delete, dan ekspor CSV.

## 2. Instalasi XAMPP dan membuka program

1. Pastikan aplikasi XAMPP tersedia dan PHP versi 8.0 atau lebih baru.
2. Buka File Explorer → `C:\xampp\htdocs\` (atau folder instalasi XAMPP Anda).
3. Buat folder `hari-08` jika belum ada.
4. Ekstrak ZIP proyek ini. Salin folder `proyek-4-buku-tamu` ke `C:\xampp\htdocs\hari-08\`.
5. Buka **XAMPP Control Panel**, klik **Start** di sebelah Apache. MySQL tidak diperlukan.
6. Di browser, buka:
   `http://localhost/hari-08/proyek-4-buku-tamu/index.php`
7. Halaman "Buku Tamu Digital Sekolah" seharusnya muncul.

**Penting:** Jangan membuka `index.php` dengan klik ganda melalui `file:///C:/...`. PHP harus diproses melalui Apache di `http://localhost/...`.

## 3. Memahami folder

```text
hari-08/
└── proyek-4-buku-tamu/
    ├── index.php              # Halaman utama dan alur GET/POST
    ├── functions.php          # Validasi, baca, simpan, cari, pagination, soft delete
    ├── admin.php              # Setup password dan hapus lembut (opsional)
    ├── export-csv.php         # CSV khusus admin (opsional)
    ├── uji.php                # Tes fungsi tanpa menulis data tamu
    ├── style.css              # Desain halaman
    ├── data/
    │   ├── .htaccess          # Larang akses file di folder data
    │   ├── tamu.json          # Dibuat saat tamu pertama berhasil tersimpan
    │   ├── admin.hash         # Dibuat saat admin pertama kali disiapkan
    │   └── .tamu.lock         # Dibuat saat penyimpanan pertama
    ├── docs/PANDUAN-PEMULA.md
    ├── .gitignore
    └── README.md
```

## 4. Memahami alur index.php

**GET biasa** → PHP baca JSON → filter kata kunci pencarian → urutkan terbaru dulu → tampilkan 5 pesan pada halaman yang sesuai.

**POST** → PHP ambil `$_POST` → validasi → jika ada galat, isi input dipertahankan → jika valid, simpan JSON → kirim redirect 303 ke `index.php?status=sukses` → browser membuka halaman GET yang menampilkan notifikasi berhasil.

Mengapa PRG? Karena jika user me-refresh halaman setelah POST, browser dapat menawarkan kirim ulang form. Redirect menghindari pengiriman ulang saat refresh.

### A. Validasi

Bagian fungsi `validasiTamu()` di `functions.php` menghasilkan array:

```php
[
    'data' => ['nama' => 'Sari', 'email' => 'sari@example.com', 'pesan' => 'Halo!'],
    'galat' => [],
]
```

Jika ada masalah, `galat` berisi kunci kolom yang bermasalah, misalnya `galat['nama'] = 'Nama minimal 3 karakter.'`.

### B. Penyimpanan JSON

Setiap pesan mendapatkan ID otomatis (1, 2, 3...), waktu pengiriman, IP, dan `dihapus_pada = null`. Data disimpan melalui `json_encode(..., JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)` ke `data/tamu.json`.

Jika file belum ada, `ambilSemuaTamu()` mengembalikan array kosong. Jika folder `data/` terhapus, saat penyimpanan berikutnya program membuat ulang folder **beserta** `.htaccess` untuk melindungi JSON. Jika JSON sudah ada tetapi rusak, program menampilkan pesan kesalahan dan **tidak menimpa data rusak** secara otomatis.

### C. Pencarian

Contoh URL: `index.php?q=sari`.

Pencarian menggunakan `stripos($nama, $kata) !== false`, artinya `sari`, `SARI`, dan `ari` cocok untuk nama `Sari`.

### D. Escaping HTML

Saat pengguna memasukkan `<script>alert(1)</script>` di pesan, program akan menampilkannya sebagai **teks**, bukan menjalankannya. Fungsi `e()` membungkus `htmlspecialchars($teks, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')`.

## 5. Uji wajib secara manual

**Tes 1 — Semua kolom kosong**
1. Buka halaman utama, klik `Kirim Pesan` tanpa mengisi apapun.
2. Seharusnya ada kesalahan di kolom nama, email, dan pesan.

**Tes 2 — Nama terlalu pendek**
1. Nama: `Ab`, email: `ab@example.com`, pesan: `Halo`.
2. Klik Kirim; nama seharusnya ditolak.

**Tes 3 — Email salah**
1. Nama: `Budi`, email: `bukan-email`, pesan: `Halo`.
2. Klik Kirim; email ditolak.

**Tes 4 — Pesan lebih dari 500 karakter**
1. Ketik atau paste 501 karakter melalui pengujian kode / inspector (HTML maxlength hanya pengamanan di browser).
2. PHP harus menolak input meskipun validasi HTML dilewati.

**Tes 5 — Data valid**
1. Nama: `Sari Putri`, email: `sari@example.com`, pesan: `Sekolah sangat nyaman.`.
2. Klik Kirim. Seharusnya redirect ke `index.php?status=sukses`.
3. Daftar tamu menunjukkan pesan Sari dan `data/tamu.json` telah dibuat.

**Tes 6 — Data lama tetap tampil pada error**
1. Isi `Budi`, `bukan-email`, `Pesan untuk sekolah`.
2. Klik kirim. Nama dan pesan tetap ada; kesalahan pada email terlihat.

**Tes 7 — XSS tidak dijalankan**
1. Tunggu 30 detik dari pengiriman terakhir (limit IP).
2. Isi nama dan email yang valid.
3. Isi pesan `<script>alert(1)</script>` lalu kirim.
4. Teks script harus terlihat di daftar tamu sebagai teks; tidak boleh muncul popup.

**Tes 8 — Pencarian nama (GET)**
1. Di kolom cari masukkan `sari`, lalu `SARI` dan `ari`.
2. Pesan Sari harus muncul untuk ketiganya.
3. Cari `zzzz`; harus muncul pesan tidak ditemukan.

**Tes 9 — PRG**
1. Kirim satu pesan valid.
2. Saat pesan berhasil, tekan F5 / Refresh.
3. Browser tidak boleh mengirim ulang POST secara otomatis.

**Tes 10 — Proteksi folder data**
1. Buka `http://localhost/hari-08/proyek-4-buku-tamu/data/tamu.json`.
2. Apache seharusnya memberi status **403 Forbidden** (jika `.htaccess` diizinkan pada konfigurasi Apache).

## 6. Uji tantangan

**Pagination 5 per halaman**
1. Buat sekurang-kurangnya 6 pesan, dengan jeda **30 detik** antar pesan dari komputer yang sama. Alternatifnya gunakan data contoh pada pengujian fungsi untuk mempelajari `array_slice`.
2. Di halaman pertama tampil maksimal 5 pesan.
3. Klik `Berikutnya` untuk pesan berikutnya. Parameter `q` harus dipertahankan jika sedang mencari nama.

**Batas 1 pesan setiap 30 detik per IP**
1. Kirim satu pesan valid.
2. Segera kirim pesan lain.
3. Aplikasi seharusnya menolak dan memberitahu sisa detik.
4. Setelah 30 detik, kirim ulang.

**Soft delete melalui admin**
1. Akses `http://localhost/hari-08/proyek-4-buku-tamu/admin.php` di browser lokal.
2. Pada akses pertama buat password admin minimal 10 karakter.
3. Klik `Hapus` pada salah satu pesan.
4. Pesan tersebut hilang dari daftar publik, namun masih berada di JSON dengan `dihapus_pada` terisi.
5. Klik `Keluar Admin` untuk keluar.

**Ekspor CSV**
1. Login ke `admin.php`.
2. Klik `Unduh CSV`.
3. File `buku-tamu-TANGGAL.csv` harus terunduh; baris pertama berisi ID, Waktu, Nama, Email, Pesan.
4. Pesan yang dihapus lembut tidak dimasukkan ke CSV.
5. CSV berisi email peserta; file ini tidak untuk dibagikan secara publik.

## 7. Pengujian otomatis

Buka `http://localhost/hari-08/proyek-4-buku-tamu/uji.php`.

Tes meliputi: nama minimal, email valid, batas pesan, pembersihan spasi, pencarian case-insensitive, soft delete, pagination, HTML escaping, validasi input array dan keamanan CSV. Tes otomatis bersifat **read-only**, tidak menyimpan atau menghapus tamu asli.

## 8. Kesalahan umum dan solusinya

| Masalah | Solusi |
| --- | --- |
| 404 Not Found | Pastikan folder `proyek-4-buku-tamu` berada di `htdocs/hari-08/`. |
| Halaman PHP tidak berjalan | Jalankan Apache melalui XAMPP dan buka lewat localhost, bukan `file://`. |
| `session_start(): headers already sent` | Jangan menulis HTML/spasi sebelum `<?php` di awal `index.php`. |
| Pesan tidak tersimpan | Periksa izin folder `data`, versi PHP, dan integritas `tamu.json`. |
| Pesan kedua ditolak | Tunggu 30 detik: itu fitur rate limiting. |
| JSON rusak | Simpan salinan file, lalu perbaiki format JSON. Jangan langsung menghapus file jika datanya penting. |
| 403 pada file JSON | Itu perilaku **benar**: `.htaccess` menjaga privasi data. |
| Setup admin ditolak | Akses `admin.php` dari komputer yang sama dengan server, melalui localhost. |
| Email tampil sebagai HTML | Gunakan `e()` saat menampilkan setiap input user. |
| `Call to undefined function...` | Periksa `require_once __DIR__ . '/functions.php';` dan versi PHP. |

## 9. Bukti pengumpulan

Lampirkan screenshot dari:
1. Halaman utama dengan formulir kosong.
2. Error validasi (nama dan email salah).
3. Pengiriman sukses beserta isi `data/tamu.json` (jangan tampilkan email/IP asli saat membagikan screenshot).
4. Pencarian `?q=sari` dan pesan jika tidak ditemukan.
5. Tampilan 5 pesan/halaman dan tautan berikutnya (opsional tantangan).
6. Halaman admin setelah soft delete (opsional tantangan).
7. File CSV terbuka di spreadsheet (opsional tantangan).
8. Halaman `uji.php` yang menunjukkan tes lulus.

## 10. Keamanan dan privasi

Aplikasi ini dibuat untuk tugas lokal. Proteksi `.htaccess` berlaku untuk Apache 2.4 bila konfigurasi mengizinkan `AllowOverride`. Jika akan dipasang ke internet, tambahkan HTTPS, kebijakan privasi dan retensi data, perlindungan login admin dari brute force, monitoring, backup, serta pembatasan trafik. Jangan commit `tamu.json` dan `admin.hash` ke GitHub; keduanya sudah dimasukkan ke `.gitignore`.
