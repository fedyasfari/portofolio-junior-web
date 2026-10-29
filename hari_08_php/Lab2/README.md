# Lab 2 — PHP: Fungsi dan Array Asosiatif

## Tujuan
Mempraktikkan `declare(strict_types=1)`, tipe parameter dan return, array asosiatif, perulangan `foreach`, `array_filter()`, `usort()`, array berkelompok, `match`, dan `htmlspecialchars()`.

## Persyaratan
- XAMPP dengan Apache aktif, dan PHP **8.0 atau lebih baru**.
- Browser modern.
- VS Code (opsional untuk pengeditan).

## Susunan berkas
```text
lab-02/
├── index.php       # halaman hasil semua fungsi
├── data.php        # data peserta sesuai soal
├── fungsi.php      # 4 fungsi wajib + konversi grade + escape
├── tabel.php       # templat tabel dipakai berulang
├── uji.php         # 15 pengujian otomatis
├── style.css       # tampilan responsif
├── README.md
└── docs/
    └── panduan-pengujian.md
```

## Cara menjalankan
1. Ekstrak folder `lab-02` ke `C:\xampp\htdocs\hari-08\lab-02\`.
2. Buka XAMPP Control Panel lalu aktifkan **Apache** (MySQL tidak diperlukan).
3. Buka `http://localhost/hari-08/lab-02/index.php`.
4. Buka `http://localhost/hari-08/lab-02/uji.php` untuk memeriksa seluruh pengujian.
5. Salin folder `lab-02` juga ke repositori `hari-08-php`.

## Hasil yang diharapkan
- Rata-rata `(90 + 68 + 82) / 3 = 80.0`.
- Nilai tertinggi **Sari (90)**.
- Lulus dengan batas 70: **Sari (90)** dan **Citra (82)**.
- Urutan nilai menurun: **Sari 90**, **Citra 82**, **Budi 68**.
- Pengelompokan: `Web` (Sari, Budi); `Data` (Citra).
- Grade: Sari A, Budi D, Citra B.
- `uji.php`: **15 dari 15 pengujian berhasil**.

## Mengapa `array_values()` sesudah `array_filter()`?
`array_filter()` mempertahankan kunci asli. `array_values()` merapikan indeks menjadi 0,1,... untuk tabel bernomor.

## Mengapa `usort()` bekerja pada `$salinan`?
`usort()` mengubah array yang diberikan kepadanya. Mengurutkan `$salinan` memungkinkan fungsi mengembalikan hasil baru tanpa mengubah data asli milik pemanggil.

## Keamanan output
Semua data peserta, nilai, nomor baris, jumlah, dan nama kelas ditampilkan menggunakan fungsi `e()`, yaitu pembungkus `htmlspecialchars(..., ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')`.

## Sumber resmi
- https://www.php.net/manual/en/function.array-filter.php
- https://www.php.net/manual/en/function.usort.php
- https://www.php.net/manual/en/function.htmlspecialchars.php
