# Lab 5 — Lembar Kerja Doc Hunt

**Penulis/peserta:** `[ISI NAMA]`  
**Tanggal:** 3 November 2026  
**Repositori bermasalah dari instruktur:** `[ISI URL / NAMA FOLDER REPO SETELAH DITERIMA]`

> **Status:** Enam masalah di bawah adalah **contoh kasus dari soal Lab 5**, bukan temuan yang telah diverifikasi pada repositori instruktur. Anda perlu memeriksa repo yang dibagikan instruktur, mencatat lokasi aslinya, lalu melakukan perbaikan yang terbukti. Jangan mengubah kode Capstone aktif hanya demi memunculkan kesalahan latihan.

## 1. Tabel enam masalah dari soal

| No | Masalah dokumentasi pada soal | Dampak | Arah perbaikan |
|---|---|---|---|
| 1 | `@param` menyebut dua parameter, tanda tangan fungsi memiliki tiga | Pemakai salah memanggil | Sinkronkan DocBlock dengan tanda tangan fungsi |
| 2 | Tidak ada `@throws`, padahal fungsi melempar `RuntimeException` | Exception tidak tertangani | Tambahkan `@throws` dan cara menanganinya |
| 3 | Komentar menyebut pembulatan ke atas, kode justru membulatkan ke bawah | Menyesatkan pembaca | Perbaiki komentar atau kode sesuai kebutuhan sebenarnya |
| 4 | `@return int` padahal fungsi mengembalikan `?array` | Informasi tipe salah | Perbaiki tipe dan keterangan `null` |
| 5 | README memasang berkas yang sudah tidak ada | Instalasi gagal | Perbarui langkah, uji dari awal |
| 6 | Sandi database asli tertulis di README | Kebocoran rahasia | Hapus sandi, gunakan file konfigurasi contoh dan rotasi kredensial yang bocor |

## 2. Cara mencari dan memperbaiki satu per satu

### Kasus 1 — Jumlah @param tidak cocok

**Contoh dokumentasi salah:**

```php
/**
 * @param array $input Data formulir.
 * @param PDO $pdo Koneksi database.
 */
function validasiPendaftar(array $input, PDO $pdo, ?int $kecualiId = null): array
```

**Contoh perbaikan:** tambahkan `@param int|null $kecualiId ID yang dikecualikan ketika mengubah, null saat tambah.`. Tidak perlu mengubah tanda tangan fungsi jika kode sudah benar. Periksa `@return` dan `@throws` secara terpisah.

### Kasus 2 — @throws hilang

**Contoh:** jika kode memuat `throw new RuntimeException('Gagal');`, dokumentasikan kemungkinan tersebut dengan `@throws RuntimeException` dan jelaskan agar pemanggil menangani exception atau menampilkan pesan yang aman. Hanya tambahkan tag jika exception benar-benar dapat terjadi/keluar dari fungsi.

### Kasus 3 — Komentar bertentangan dengan kode

```php
// SALAH: Membulatkan ke atas.
$hasil = floor(12.8); // sebenarnya hasil 12: ke bawah
```

**Perbaikan komentar:** `// Membulatkan nilai ke bawah ke bilangan bulat terdekat.` Pertimbangkan mengubah fungsi hanya bila kebutuhan sebenarnya memang mengharuskan `ceil()`.

### Kasus 4 — Salah tipe @return

```php
/** @return int */ // SALAH bila hasilnya array atau null
function ambilPendaftarById(PDO $pdo, int $id): ?array
```

**Perbaikan:** `@return array<string, mixed>|null Data peserta atau null bila tidak ditemukan.`

### Kasus 5 — Langkah instalasi menunjuk file hilang

Temukan nama berkas di README, lalu periksa dengan `Test-Path .\nama-file` dari akar proyek. Jika tidak ada, ganti petunjuk dengan berkas yang benar-benar digunakan; jalankan langkah instalasi dari salinan proyek bersih / folder uji agar tidak merusak data aktif.

### Kasus 6 — Password nyata berada di README

Hapus sandi dari dokumentasi. Bila kredensial itu pernah dipakai/diunggah, **ganti (rotasi) sandinya**: penghapusan dari README tidak otomatis menghilangkan kebocoran dari histori Git. Gunakan `config/config.contoh.php` dengan placeholder saja; simpan `config/config.php` di luar pelacakan Git dan periksa histori sebelum berbagi repo.

## 3. Perintah pencarian di VS Code / PowerShell

Jalankan dari akar repositori contoh yang diberikan instruktur:

```powershell
# Cari deklarasi fungsi dan PHPDoc dalam file PHP.
Get-ChildItem . -Recurse -File -Filter *.php | Select-String -Pattern '@param','@return','@throws','function '

# Cari referensi berkas atau konfigurasi dalam README.
Select-String -Path .\README.md -Pattern 'config','database','install','composer','php'

# Pastikan nama file yang diklaim di README benar-benar ada.
Test-Path .\config\config.contoh.php
```

Catatan: perintah pencarian hanyalah penyaring awal; cocokkan setiap temuan dengan kode sebenarnya. Jangan menyalin keluaran yang mengandung sandi ke screenshot/laporan.

## 4. Lembar hasil temuan nyata — isi setelah menerima repo instruktur

| No | File : baris | Bukti kesalahan (ringkas, tanpa sandi) | Perubahan yang dilakukan | Cara menguji | Status |
|---|---|---|---|---|---|
| 1 | BELUM DIPERIKSA | — | — | Hover / PHPDoc | Belum |
| 2 | BELUM DIPERIKSA | — | — | Periksa exception | Belum |
| 3 | BELUM DIPERIKSA | — | — | Bandingkan hasil `floor/ceil` | Belum |
| 4 | BELUM DIPERIKSA | — | — | Bandingkan return | Belum |
| 5 | BELUM DIPERIKSA | — | — | Instalasi pada folder uji | Belum |
| 6 | BELUM DIPERIKSA | — | — | Audit README/Git tanpa mengekspos sandi | Belum |

## 5. Bukti yang sebaiknya dikumpulkan

- Screenshot **sebelum** perbaikan (kecuali sandi nyata: jangan difoto/disebarkan).
- Screenshot **sesudah** perbaikan untuk setiap kasus.
- Hasil PHPDoc/JSDoc jika relevan, pemeriksaan `php -l`, dan uji instalasi README.
- Ringkasan perbaikan pada `CHANGELOG.md` repositori latihan jika instruktur memintanya.

## 6. Kesimpulan (diisi setelah praktik)

**Jumlah masalah yang benar-benar ditemukan:** `[0–6 atau sesuai hasil]`  
**Jumlah berhasil diperbaiki dan diuji:** `[ISI]`  
**Kendala yang belum selesai:** `[ISI]`
