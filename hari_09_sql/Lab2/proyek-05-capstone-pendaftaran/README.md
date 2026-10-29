# Lab 2 — Koneksi PDO dan Demonstrasi SQL Injection

Proyek pembelajaran PHP 8 + MySQL/MariaDB via XAMPP. Memuat CRUD sederhana dan perbandingan query rentan terhadap SQL Injection versus prepared statement.

## Isi dan penempatan file

```text
proyek-5-capstone-pendaftaran/
├── config/
│   ├── config.php             # lokal saja; diabaikan oleh Git
│   ├── config.contoh.php      # contoh aman untuk Git
│   └── database.php          # fungsi getConnection(): PDO
├── src/
│   ├── bootstrap.php         # session dan require file pendukung
│   ├── helpers.php           # escape HTML, CSRF, validasi, redirect
│   └── pendaftar.php         # fungsi CRUD via prepared statements
├── public/
│   ├── index.php             # daftar pendaftar
│   ├── tambah.php            # formulir membuat data
│   ├── ubah.php              # formulir menyunting data
│   ├── hapus.php             # menerima POST untuk menghapus
│   ├── _form.php             # formulir bersama tambah/ubah
│   ├── injeksi.php           # demo rentan & aman, localhost only
│   └── assets/style.css
├── templates/
│   ├── header.php
│   └── footer.php
├── database/skema.sql        # membuat DB + tabel + 3 kelas + 8 pendaftar
├── docs/PANDUAN-LAB2.md      # panduan sangat rinci + jawaban teori
├── docs/LAPORAN-PRAKTIKUM.md # template laporan dan bukti screenshot
└── .gitignore
```

## Cara cepat memakai XAMPP (Windows)

1. Ekstrak ZIP, letakkan folder `proyek-5-capstone-pendaftaran` ke dalam `C:\xampp\htdocs\`.
2. Jalankan **XAMPP Control Panel**. Klik **Start** pada **Apache** dan **MySQL**.
3. Buka `http://localhost/phpmyadmin/` melalui browser.
4. Klik tab **Import** pada halaman utama phpMyAdmin dan impor `database/skema.sql`. File SQL membuat `db_pelatihan` secara otomatis. Jika ingin memilih database dulu, buat `db_pelatihan`, kemudian impor dari dalamnya.
5. Pastikan `config/config.php` berisi nilai yang sesuai dengan MySQL lokal. Default XAMPP baru biasanya `root` dengan password kosong. Jika komputer Anda berbeda, ubah hanya config.php.
6. Buka `http://localhost/proyek-5-capstone-pendaftaran/public/index.php`.
7. Uji tombol **Tambah**, **Ubah**, dan **Hapus**.
8. Buka `http://localhost/proyek-5-capstone-pendaftaran/public/injeksi.php`.
9. Uji parameter normal `andi@example.com`, lalu `x' OR '1'='1` untuk mengamati perbedaan.

**Jangan membuka file `.php` dengan klik ganda / `file://`.** Browser perlu mengirim request ke Apache agar kode PHP dieksekusi.

> Perhatian: File `skema.sql` menggunakan `DROP TABLE` agar bisa digunakan lagi dari awal. Impor ulang akan **menghapus perubahan data latihan sebelumnya** dalam `db_pelatihan`. Database Lab 1 `db_pendaftaran_kursus` tidak tersentuh.

## Uji SQL Injection

Parameter yang digunakan untuk simulasi:

```text
x' OR '1'='1
```

URL siap dicoba:

```text
http://localhost/proyek-5-capstone-pendaftaran/public/injeksi.php?email=x%27%20OR%20%271%27%3D%271
```

Pada data awal (8 pendaftar):

| Percobaan | Query rentan | Query aman |
|---|---:|---:|
| `andi@example.com` | 1 hasil | 1 hasil |
| `x' OR '1'='1` | 8 hasil | 0 hasil |

Jika sudah menambah/menghapus pendaftar, angka pada versi rentan berubah mengikuti jumlah data, sementara versi aman tetap 0 untuk payload tersebut.

**Mengapa?** Versi rentan menggabungkan input ke teks SQL (`email = 'x' OR '1'='1'`) sehingga kondisi selalu benar. Prepared statement mengirim input sebagai **parameter data tunggal**, sehingga apostrof, OR, dan tanda sama dengan di dalamnya tidak berubah menjadi operator SQL.

## Pengamanan minimal contoh

- Akses ke `injeksi.php` dibatasi untuk IP loopback (127.0.0.1 atau ::1); jangan dipublikasikan.
- Aksi pembuatan/pembaruan/penghapusan memakai prepared statement PDO.
- `config/config.php` tercantum di `.gitignore`; jangan pernah push sandi database ke GitHub.
- Form POST memiliki token CSRF; penghapusan hanya melalui POST.
- Output yang mengandung input pengguna diproses `htmlspecialchars()`.
- Proyek ini adalah demonstrasi lokal, **belum** mencakup autentikasi dan hak akses untuk penggunaan publik.

## Jika tidak berhasil

- `Not Found / 404` → periksa folder di `C:\xampp\htdocs\` dan gunakan URL dengan `/public/index.php`.
- `Access denied for user` → cek nilai `user` dan `sandi` di `config/config.php`.
- `Unknown database db_pelatihan` → impor `database/skema.sql`.
- `could not find driver` → aktifkan ekstensi PHP `pdo_mysql` pada `php.ini`, lalu restart Apache.
- `Connection refused` → pastikan MySQL berjalan di XAMPP.
- `config/config.php belum ada` → buat salinan dari `config/config.contoh.php`.
- Data lama hilang setelah impor → `skema.sql` adalah skrip reset data **latihan**; jangan gunakan pada data nyata.
- `injeksi.php` memberikan HTTP 403 → demo sengaja dibatasi pada koneksi localhost di komputer tempat Apache berjalan.

Lihat `docs/PANDUAN-LAB2.md` untuk penjelasan setiap file, langkah pengujian dan bahan laporan.
