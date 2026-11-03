# LAB 2 — Panduan Debugging PHP (Pemula)

## Isi paket

- `bug-nilai.php` — kode awal dari soal, sengaja masih salah.
- `tahap-01-sintaks.php` — hanya B-01 telah diperbaiki, untuk mengamati bug berikutnya.
- `solusi-nilai.php` — versi akhir yang sudah diperbaiki.
- `jejak-var-dump.php` — contoh pemakaian `var_dump()` dan `print_r()`.
- `demo-tipe-data.php` — menunjukkan perilaku string numerik dan TypeError yang nyata di PHP 8.
- `uji-nilai.php` — enam tes otomatis.
- `laporan-bug.md` — contoh isi tabel laporan.

## A. Siapkan lingkungan di Windows 11

1. Install XAMPP (mengandung PHP) atau PHP langsung, dan gunakan Visual Studio Code.
2. Buka folder proyek melalui VS Code > File > Open Folder.
3. Pilih Terminal > New Terminal.
4. Ketik `php -v` untuk melihat versi PHP. Jika tidak dikenali, gunakan PATH PHP XAMPP:
   ```powershell
   & "C:\xampp\php\php.exe" -v
   ```
   Bisa juga tambahkan `C:\xampp\php` ke Environment Variables > Path, lalu buka ulang terminal.

## B. Jalankan PHP Linter

```powershell
php -l bug-nilai.php
```

Hasilnya **gagal** karena `return $lulus` belum diakhiri `;`. Lakukan pemeriksaan pada file tahap:

```powershell
php -l tahap-01-sintaks.php
```

Hasilnya `No syntax errors detected ...`.

**Ingat:** `php -l` hanya mengecek sintaks; tidak mengecek logika atau warning runtime.

## C. Menelusuri bug satu per satu

```powershell
php tahap-01-sintaks.php
php jejak-var-dump.php
php demo-tipe-data.php
```

Tabel `laporan-bug.md` menjelaskan temuan dan koreksi.

## D. Jalankan solusi

```powershell
php -l solusi-nilai.php
php solusi-nilai.php
php uji-nilai.php
```

Hasil logika: Rata-rata `77,5`; Lulus `3 siswa`; Nilai Eko `Data tidak ditemukan`. Semua 6 tes harus lulus.

## E. Jalankan PHP melalui browser (sangat penting untuk latihan `header()`)

**Cara 1: server PHP bawaan (jika `php` ada di PATH):**

```powershell
php -d output_buffering=0 -S localhost:8000 -t .
```

Biarkan terminal server terbuka. Buka browser:

- http://localhost:8000/bug-nilai.php (error sintaks)
- http://localhost:8000/tahap-01-sintaks.php (kesalahan logika dan warning)
- http://localhost:8000/solusi-nilai.php (hasil akhir)
- http://localhost:8000/jejak-var-dump.php (penelusuran variabel)
- http://localhost:8000/uji-nilai.php (tes)

Hentikan server dengan `Ctrl+C`.

**Cara 2: XAMPP Apache:**

1. Salin folder `Lab-2-Debugging-PHP` ke `C:\xampp\htdocs\`.
2. Jalankan XAMPP Control Panel, klik **Start** untuk **Apache**. MySQL **tidak diperlukan**.
3. Buka `http://localhost/Lab-2-Debugging-PHP/solusi-nilai.php`.
4. Untuk melihat warning, aktifkan penayangan error hanya pada lingkungan **lokal**. Output buffering dapat membuat warning B-06 tidak muncul, dan pada PHP CLI pun warning ini bisa muncul jika output sudah dikirim.

**Jangan membuka `solusi-nilai.php` menggunakan `file:///`** karena browser tidak menjalankan interpreter PHP.

## F. Tentang B-02

String `'68'` adalah *numeric string*. PHP dapat menambahkannya ke angka tanpa `TypeError` meski `strict_types=1`. Teks `'enam puluh delapan'` bukan numeric string dan pada PHP 8 menimbulkan `TypeError` saat dipakai di operasi `+`. Baca: https://www.php.net/manual/en/language.types.numeric-strings.php

## G. Bukti tugas yang bisa disiapkan

1. Screenshot keluaran `php -l bug-nilai.php` yang gagal.
2. Screenshot `php -l solusi-nilai.php` yang berhasil.
3. Screenshot hasil `solusi-nilai.php` di browser.
4. Screenshot `jejak-var-dump.php` dan `uji-nilai.php`.
5. Isi `laporan-bug.md` dengan hasil praktik sendiri.
