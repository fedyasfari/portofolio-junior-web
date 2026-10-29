# PANDUAN LAB 3 — MODUL CRUD PENDAFTAR (PHP + PDO)

Panduan ini ditulis untuk pemula dan melanjutkan **Lab 2**. Semua sumber `src/`, `templates/`, dan `public/` dalam paket ini telah disesuaikan dengan soal Lab 3. **Jangan mencampur file baru dengan kode Lab 2 lama tanpa menyesuaikan skema.**

## A. Tujuan Lab 3

1. **CREATE**: menambah pendaftar dengan input yang divalidasi.
2. **READ**: mengambil, JOIN nama kelas, mencari nama dengan `LIKE`, dan menampilkan 10 data per halaman.
3. **UPDATE**: mengubah data pendaftar berdasarkan `id`.
4. **DELETE**: menghapus data dengan request `POST` dan token CSRF.
5. **Proteksi**: HTML escaping terhadap XSS, prepared statements, validasi sisi server, status HTTP 403/404.

## B. Instalasi XAMPP (Windows)

1. Unduh ZIP `Lab3-CRUD-Pendaftar-Proyek-Lengkap.zip`.
2. Ekstrak folder `proyek-5-capstone-pendaftaran/` ke `C:\xampp\htdocs\`.
3. Nyalakan **Apache** dan **MySQL** di XAMPP Control Panel.
4. Buka `http://localhost/phpmyadmin/`.
5. **Pilih satu jenis instalasi database** (jangan menjalankan keduanya):
   - **Belum memiliki database Lab 2 / rela mereset data latihan**: menu **Import** → pilih `database/skema.sql`. File ini menghapus dan membuat ulang dua tabel dalam `db_pelatihan`; 3 kelas dan 8 pendaftar dimasukkan lagi. **Perhatian: data latihan lama akan hilang.**
   - **Sudah memiliki db_pelatihan dari Lab 2, ingin mempertahankan data**: buat **backup** dulu di phpMyAdmin → database `db_pelatihan` → **Export** → Quick → SQL. Kemudian menu **Import** → pilih `database/migrasi-dari-lab2.sql` sekali saja. Hanya cocok untuk skema Lab 2 dari paket sebelumnya, bukan untuk skema yang sudah pernah dimigrasi.
6. Buka `config/config.php` dalam VS Code dan periksa `host`, `nama_db`, `user`, `sandi`. Konfigurasi lokal XAMPP yang umum: `localhost`, `db_pelatihan`, `root`, `''`. Jangan commit file ini ke Git.
7. Akses aplikasi: `http://localhost/proyek-5-capstone-pendaftaran/public/index.php`.
8. Jika melihat tabel 8 pendaftar, sambungan dan query daftar sudah berhasil.

> **JANGAN** membuka file `.php` dengan double click (`file://`) karena PHP perlu dieksekusi oleh Apache.

## C. Struktur folder dan fungsi

```text
proyek-5-capstone-pendaftaran/
├── config/
│   ├── config.php                 # lokal; diabaikan git
│   ├── config.contoh.php         # contoh kredensial
│   └── database.php              # getConnection() PDO
├── src/
│   ├── bootstrap.php             # session, error handler, import
│   ├── helpers.php               # e(), redirect(), CSRF, flash
│   └── pendaftar.php             # fungsi baca, tambah, ubah, hapus, validasi
├── public/
│   ├── index.php                 # READ + pencarian + paginasi
│   ├── tambah.php                # CREATE
│   ├── ubah.php                  # UPDATE
│   ├── hapus.php                 # DELETE melalui POST saja
│   ├── _form.php                 # formulir yang dipakai oleh tambah/ubah
│   ├── injeksi.php               # demonstrasi Lab 2 (localhost only)
│   └── assets/style.css         # CSS tanpa Bootstrap (hari 10 menyusul)
├── templates/header.php         # header HTML dan flash
├── templates/footer.php         # footer HTML
├── database/
│   ├── skema.sql                 # database awal Lab 3 (RESET)
│   ├── migrasi-dari-lab2.sql     # dari skema Lab 2 (PRESERVE)
│   └── tambah-data-pagination.sql # opsional: tambah 4 contoh
├── docs/
│   ├── PANDUAN-LAB3.md
│   └── LAPORAN-LAB3.md
└── .gitignore
```

## D. Perbedaan penting nama kolom dari Lab 2

| Elemen | Lab 2 | Lab 3 |
|---|---|---|
| PK kelas | `id_kelas` | `id` |
| PK pendaftar | `id_pendaftar` | `id` |
| FK pendaftar | `id_kelas` | `kelas_id` |
| Kolom alamat | Belum ada | `alamat` |
| Tanggal | `tanggal_daftar` DATE | `tanggal_daftar` DATETIME, otomatis |

Soal Lab 3 menggunakan query `k.id = p.kelas_id` dan `p.id`. Agar tidak terjadi error "Unknown column", **database dan kode harus sama**. Untuk itu disediakan file skema baru dan migrasi.

## E. Memahami setiap file (pelan-pelan)

### 1. `config/database.php`

Fungsi `getConnection()` membuka PDO menggunakan `mysql:host=...;dbname=...;charset=utf8mb4`. Mode error `PDO::ERRMODE_EXCEPTION` melempar exception, `PDO::ATTR_DEFAULT_FETCH_MODE=PDO::FETCH_ASSOC` membuat hasil asosiatif, dan `PDO::ATTR_EMULATE_PREPARES=false` meminta native prepared statements.

### 2. `src/bootstrap.php`

Memulai session (`session_start()`), membaca konfigurasi, mengatur tingkat error, memanggil file database/helpers/pendaftar, memasang exception handler umum. Semua halaman di `public/` mengimpor file ini.

### 3. `src/helpers.php`

- `e($teks)` mengubah `<` menjadi `&lt;` dan `>` menjadi `&gt;`, sehingga karakter HTML dari pengguna tidak ditafsirkan sebagai elemen/script.
- `redirect()` mengirim HTTP 303 setelah menulis data agar menekan Refresh tidak mengulang POST.
- `tokenCsrf()` menghasilkan token acak yang disimpan pada session pengunjung.
- `cekCsrf()` membandingkan token session dengan token POST menggunakan `hash_equals()`, dan mengembalikan **403** jika token salah/hilang.
- `setFlash()` menyimpan pesan sementara; `ambilFlash()` mengambil dan menghapusnya (sekali tampil).

### 4. `src/pendaftar.php`

- `daftarKelas()`: populasi dropdown.
- `hitungPendaftar()`: menghitung total baris hasil pencarian.
- `ambilPendaftar()`: mengambil 10 baris halaman aktif dengan JOIN serta prepared statement `:kata`, `:batas`, `:offset`. Kedua parameter angka di-bind dengan `PDO::PARAM_INT`.
- `ambilPendaftarById()`: mengambil satu baris untuk proses edit.
- `emailSudahAda()`: menolak email duplikat; saat edit, baris dengan ID yang sama diabaikan.
- `validasiPendaftar()`: memeriksa panjang nama, format/keunikan email, pola HP (08 + 8–11 angka), keberadaan kelas, batas alamat.
- `tambahPendaftar()`: INSERT dengan placeholder (bukan gabung string).
- `ubahPendaftar()`: UPDATE sesuai ID.
- `hapusPendaftar()`: DELETE sesuai ID.

### 5. `templates/header.php` dan `footer.php`

HTML bersama digunakan pada semua halaman agar navigasi, judul, dan layout konsisten. Link stylesheet diarahkan ke `public/assets/style.css`. Paket Lab 3 memakai CSS sederhana; Bootstrap dari tugas Hari 10 belum diwajibkan untuk Lab 3.

### 6. `public/index.php`

- Menerima `GET q` untuk pencarian nama (misalnya `?q=andi`).
- Menerima `GET hal` untuk pagination (`?hal=2`).
- Memakai `max(1, ceil($total/10))` supaya minimal ada halaman 1.
- Memakai `min()` dan validasi integer agar halaman tidak di luar rentang.
- Tombol **Hapus** adalah form POST disertai token tersembunyi.
- Semua teks dari data pendaftar di-output memakai `e()`.

### 7. `public/tambah.php`, `ubah.php`, `_form.php`

Kedua halaman memakai `_form.php` yang sama. POST melewati `cekCsrf()` lalu `validasiPendaftar()`. Jika ada error, input yang tadi diketik tetap tampil dan kesalahan muncul di bawah kolom. Jika berhasil, proses menyimpan → flash → redirect.

### 8. `public/hapus.php`

Bukan halaman link GET, melainkan penerima form POST. HTTP **405** untuk GET, HTTP **403** untuk token hilang, HTTP **404** untuk ID tidak tersedia. Bila valid, data dihapus lalu redirect.

## F. Uji wajib: kerjakan satu demi satu

**Uji 1 — Tambah data valid**

Buka `tambah.php`. Contoh:
- Nama `Rina Amelia`
- Email `rina@example.com`
- HP `081234567890`
- Kelas `Web Development`
- Alamat `Surakarta`
Klik Simpan. Hasil: kembali ke daftar, terlihat pesan berhasil dan nama Rina. Jumlah data semula 8 menjadi 9.

**Uji 2 — Form kosong**

Buka `tambah.php` lagi, tanpa mengisi data klik Simpan. Karena form memakai `novalidate`, PHP tetap menerima dan memvalidasi data kosong. Hasil: pesan error nama, email, HP, dan kelas. Tidak ada baris baru.

**Uji 3 — Email ganda**

Isi data valid tetapi email `andi@example.com`. Hasil: `Email sudah terdaftar.` dan tidak ada INSERT baru. Proteksi berlapis: validasi PHP dan UNIQUE di MySQL.

**Uji 4 — Kelas tidak dipilih**

Isi semua kolom lain dengan data valid dan email unik; biarkan dropdown `-- Pilih kelas --`. Hasil: `Pilih kelas yang tersedia.`

**Uji 5 — Ubah data**

Di `index.php`, klik Ubah pada sebuah data. Ubah nomor HP/kelas/alamat, lalu Simpan. Hasil: data berubah dan pesan keberhasilan tampil. Jika email tidak diubah, pengecekan email tetap mengizinkan email yang dimiliki baris itu sendiri.

**Uji 6 — Hapus data**

Klik Hapus pada data yang baru Anda buat (Rina). Setujui konfirmasi. Hasil: baris Rina hilang, jumlah data turun. Jangan hapus sample Andi apabila masih diperlukan untuk latihan Lab 2.

**Uji 7 — Cari nama**

Ketik `an` pada kolom pencarian lalu klik Cari. Hasil: nama yang mengandung `an`. Coba kata yang tidak ada, misalnya `zzxy`, hasil `Tidak ada data yang cocok`.

**Uji 8 — Ubah dengan ID salah**

Buka dua alamat (dari browser):
- `http://localhost/proyek-5-capstone-pendaftaran/public/ubah.php?id=abc`
- `http://localhost/proyek-5-capstone-pendaftaran/public/ubah.php?id=9999`
Keduanya menampilkan **HTTP 404**, bukan form yang bisa diubah. Jika mengecek lewat Developer Tools → Network, statusnya 404.

**Uji 9 — Hapus tanpa token CSRF**

**Cara aman tanpa menyentuh data**: buka Terminal di VS Code, jalankan:

```bash
curl.exe -i -X POST "http://localhost/proyek-5-capstone-pendaftaran/public/hapus.php" -d "id=1"
```

Pada Windows PowerShell gunakan `curl.exe`, bukan alias `curl`. Hasil: `HTTP/1.1 403 Forbidden` (atau status 403 pada HTTP/2). Tidak ada data yang dihapus, karena request ditolak sebelum query DELETE.

**Uji 10 — XSS pada nama**

Tambahkan pendaftar baru memakai nama persis:

```text
<script>alert(1)</script>
```

Lengkapi email unik, HP dan kelas yang valid. Setelah Simpan, nama tersebut terlihat sebagai **teks literal**, bukan memunculkan alert JavaScript. Karena `e()` memakai `htmlspecialchars` sebelum mencetak nilai ke HTML.

**Uji 11 — Paginasi >10 data**

Data awal berjumlah 8. Agar mudah, impor file `database/tambah-data-pagination.sql` **satu kali**, sehingga data contoh bertambah 4 menjadi 12 (jika belum menambah/menghapus data). Buka `index.php` lalu klik angka **2**. Halaman pertama memuat maksimal 10; halaman kedua berisi sisa data. Saat melakukan pencarian, kata yang diketik tetap dipertahankan di URL tiap halaman.

> Urutan uji memengaruhi jumlah total karena uji tambah/hapus/XSS menambah atau menghapus data. Pengujian pagination hanya membutuhkan lebih dari 10 pendaftar; tidak wajib tepat 12.

## G. Kenapa validasi perlu dua tingkat?

Validasi PHP membuat pengguna mendapatkan pesan yang mudah dimengerti, sedangkan aturan tabel SQL seperti `UNIQUE(email)` tetap mencegah duplikat bila dua orang menyimpan data pada waktu hampir bersamaan. Prepared statements mengatasi SQL Injection tetapi tidak menggantikan validasi, CSRF, atau HTML escaping.

## H. Memahami perbedaan proteksi

| Konsep | Risiko yang dicegah | Contoh |
|---|---|---|
| Prepared statement | SQL Injection | `WHERE email = :email` |
| Output escaping `e()` | XSS ketika isi data dicetak di HTML | `<script>` jadi teks |
| Token CSRF | POST palsu dari situs lain | field `csrf`, `hash_equals` |
| Validasi input | Data salah/tidak lengkap | HP harus 08 dan 10–13 digit |
| HTTP 404 | Edit/hapus ID tak dikenal | `ubah.php?id=abc` |
| HTTP 405 | Penghapusan lewat GET | `GET hapus.php` |

## I. Error yang mungkin muncul

| Gejala | Penyebab | Penyelesaian |
|---|---|---|
| `Unknown column 'p.id'` / `Unknown column 'kelas_id'` | Skema masih Lab 2 | Backup, lalu impor file migrasi Lab 2; atau reset skema latihan Lab 3 |
| `Unknown database db_pelatihan` | Database belum dibuat | Impor `database/skema.sql` |
| `Access denied for user 'root'` | User/sandi salah | Ubah `config/config.php` |
| `could not find driver` | pdo_mysql belum aktif | Aktifkan pdo_mysql pada php.ini, restart Apache |
| `Call to undefined function ...` | File proyek tercampur versi lama | Ekstrak ZIP Lab 3 lengkap ke folder baru/replace semua file |
| `403` saat menyimpan | Session tidak valid/token hilang | Buka ulang formulir dari index dan gunakan tombol Simpan |
| Pencarian tidak keluar | Kata tidak cocok | Coba `an` atau Reset |
| Tidak ada tombol halaman 2 | Total data <= 10 | Tambahkan sampai ada 11+ data |
| `404 Not Found` pada URL aplikasi | Folder proyek salah | Pastikan `C:\xampp\htdocs\proyek-5-capstone-pendaftaran\public\index.php` ada |

## J. Dokumentasi yang dikumpulkan

Screenshot: 1) XAMPP Apache/MySQL berjalan; 2) struktur folder di VS Code; 3) tabel database di phpMyAdmin; 4) daftar data; 5) tambah valid; 6) error form kosong; 7) error email duplikat; 8) error kelas; 9) data setelah edit; 10) data setelah delete; 11) pencarian nama; 12) kedua halaman 404; 13) 403 tanpa token; 14) output XSS aman; 15) halaman 2 saat total >10.

Isi laporan memakai `docs/LAPORAN-LAB3.md` dan lampirkan folder proyek beserta skema SQL. File `config/config.php` **tidak boleh dimasukkan ke Git**; jangan memakai konfigurasi lokal contoh pada server publik.
