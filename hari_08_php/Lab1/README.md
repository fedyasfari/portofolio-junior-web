# Hari 08 - Lab 1 PHP Dasar

Program pada `dasar.php` memenuhi tugas:

1. Variabel nama, umur, dan status serta `var_dump()` masing-masing.
2. Tabel perkalian 1–10 dalam HTML `<table>` memakai `for` bersarang.
3. Penentuan ganjil atau genap untuk 1–20.
4. FizzBuzz untuk 1–30.
5. Konversi nilai ujian ke grade menggunakan `match`.
6. Penampilan hari dan tanggal hari ini dalam bahasa Indonesia menggunakan array dan `date('w')`.

## Persyaratan

- XAMPP dengan Apache, atau server PHP lokal.
- **PHP 8.0 atau lebih baru** karena kode memakai `match`.
- Peramban (Chrome, Firefox, Edge, dan sebagainya).
- Editor kode (misalnya VS Code).

## Menjalankan dengan XAMPP (Windows)

1. Jalankan **XAMPP Control Panel** dan tekan **Start** pada baris **Apache**. Untuk lab ini, MySQL tidak diperlukan.
2. Buat folder `C:\xampp\htdocs\hari-08\`.
3. Salin `dasar.php` dari repositori ini ke folder tersebut.
4. Buka `http://localhost/hari-08/dasar.php` di peramban.
5. Periksa keenam bagian hasil yang ditampilkan.

> Bila XAMPP dipasang di lokasi lain, gunakan folder `htdocs` dari instalasi XAMPP Anda. Jika port Apache diubah (misalnya 8080), gunakan `http://localhost:8080/hari-08/dasar.php`.

## Alternatif tanpa XAMPP (PHP terinstal)

Dari folder yang memuat `dasar.php`, jalankan:

```bash
php -S localhost:8000
```

Buka `http://localhost:8000/dasar.php` di peramban. Server bawaan PHP cocok untuk pengembangan lokal, bukan untuk produksi.

## Struktur folder yang diminta tugas

```text
xampp/
└── htdocs/
    └── hari-08/
        └── dasar.php       <-- berkas untuk dijalankan

repositori-proyek/
└── hari-08-php/
    ├── dasar.php           <-- salinan berkas yang sama
    ├── README.md
    └── docs/
        └── panduan-pengujian.md
```

## Cara mencoba perubahan

- Ubah `$nama`, `$umur`, dan `$status` di awal `dasar.php`, lalu refresh browser.
- Ubah `$nilai` menjadi 95, 85, 75, 65, atau 55 untuk menguji grade A–E.
- Jangan lupa menyimpan berkas setelah mengubah isinya (`Ctrl+S`).

## Hasil yang diharapkan

- 10 baris × 10 kolom hasil perkalian (ditambah judul baris/kolom).
- Angka 1 adalah ganjil; 2 adalah genap; 20 adalah genap.
- FizzBuzz: 3 -> Fizz, 5 -> Buzz, 15 dan 30 -> FizzBuzz.
- Nilai 85 -> grade B.
- Nama hari mengikuti waktu saat halaman diakses, berdasarkan zona waktu Asia/Jakarta.

## Pemeriksaan sintaks (opsional)

```bash
php -l dasar.php
```

Jika sintaks benar, perintah mengeluarkan `No syntax errors detected in dasar.php`.
