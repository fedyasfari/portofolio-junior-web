# Panduan tahap demi tahap — Lab 4 (untuk pemula)

## 1. Apa yang dibangun?

Aplikasi PHP lokal untuk mengelola data peserta (nama, kelas, nilai). Tanpa database, menggunakan file TXT, JSON, CSV. Menu aplikasi: Beranda, Pencarian GET, Log Pengunjung, JSON, CSV, Uji Program.

## 2. Mengatur folder XAMPP

1. Buka File Explorer.
2. Masuk ke `C:\xampp\htdocs\hari-08\`.
3. Salin folder hasil ekstraksi bernama `lab-04` di dalam `hari-08`.
4. Buka XAMPP Control Panel -> Start Apache.
5. Ketik `http://localhost/hari-08/lab-04/` pada browser.

Jika folder `hari-08` belum ada, buat dengan klik kanan -> New -> Folder. Pastikan Anda **tidak** menyalin `lab-04` dua kali (salah: `lab-04/lab-04/index.php`).

## 3. Pencarian GET

**File:** `cari.php` dan `fungsi.php`.

Contoh URL: `cari.php?q=sa`. Di PHP, `$_GET['q']` bernilai `sa`. Fungsi `cariPeserta` menggunakan `stripos($orang['nama'], $kataKunci) !== false` untuk mengecek keberadaan teks tanpa membedakan kapital. `array_filter()` memproses seluruh peserta dan `array_values()` merapikan indeks hasilnya.

- Pencarian `sa` -> Sari.
- Pencarian `BU` -> Budi.
- Pencarian `tri` -> Citra.
- Pencarian `zzz` -> pesan “Tidak ada peserta”.
- Pencarian kosong -> semua peserta.

Semua kata kunci dan data peserta di-escape saat ditampilkan dalam HTML.

## 4. Log pengunjung

Saat `cari.php` dibuka, dipanggil:

```php
catatKunjungan($ip, $kataKunci);
```

Fungsi tersebut memanggil:

```php
file_put_contents($folder . '/log.txt', $baris, FILE_APPEND | LOCK_EX);
```

Artinya:
- `FILE_APPEND`: tambahkan baris, jangan hapus yang lama.
- `LOCK_EX`: minta kunci eksklusif selama menulis.
- `date('Y-m-d H:i:s')`: waktu lokal Asia/Jakarta.
- `$_SERVER['REMOTE_ADDR']`: alamat IP yang dilihat server.

`lihat-log.php` memakai `file()`, `array_reverse()`, dan `array_slice(..., 0, 20)` agar yang tampil maksimal 20 baris terbaru. Newline dan `|` di kata kunci dinormalisasi supaya tidak menghasilkan format log palsu.

## 5. JSON

**File:** `json.php` dan `fungsi.php`.

Pertama kali `json.php` dibuka, program memanggil `simpanPesertaJson(dataAwal())` jika file belum ada.

```php
$json = json_encode($peserta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
file_put_contents($folder . '/peserta.json', $json, LOCK_EX);
```

Saat dibaca:

```php
$peserta = json_decode($isi, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    // Beri pesan JSON rusak.
}
```

Langkah menambah peserta:
1. Isi nama Deni, kelas Web, nilai 75.
2. Klik Tambah dan Simpan JSON.
3. PHP validasi input, membaca JSON, menambahkan elemen ke array, dan menyimpan kembali.
4. Tabel bertambah dari 3 menjadi 4 peserta.

Jika JSON rusak, sistem **tidak langsung menimpa data**. Perbaiki secara manual atau gunakan tombol Pulihkan (tindakan ini menimpa file dengan data awal).

## 6. CSV

**File:** `csv.php` dan `fungsi.php`.

Klik Ekspor CSV Sekarang. Program mengambil data JSON yang valid (atau data awal jika JSON belum ada), lalu menggunakan:

```php
$fp = fopen($path, 'wb');
fputcsv($fp, ['nama', 'kelas', 'nilai'], ',', '"', '');
fputcsv($fp, ['Sari', 'Web', '90'], ',', '"', '');
fclose($fp);
```

Impor menggunakan:

```php
$fp = fopen($path, 'rb');
$header = fgetcsv($fp, 0, ',', '"', '');
while (($baris = fgetcsv($fp, 0, ',', '"', '')) !== false) {
    // Bentuk array asosiatif dari 3 kolom CSV.
}
fclose($fp);
```

Parameter escape `''` diatur secara eksplisit supaya kompatibel dengan PHP 8.4 tanpa peringatan deprecation.

## 7. Menangani error

- Folder `data` hilang: `siapkanFolderData()` membuat kembali dengan `mkdir()`.
- `peserta.json` hilang: halaman JSON membuat dari data awal.
- `peserta.csv` hilang: halaman CSV memberi pesan dan tombol untuk membuat file.
- `log.txt` hilang: halaman Log memberi pesan informatif.
- JSON rusak: `json_last_error()` menghasilkan status error, dan halaman menawarkan pemulihan.
- Izin file tidak mencukupi: halaman menampilkan pesan kegagalan alih-alih crash.

## 8. Menjalankan uji

Buka `http://localhost/hari-08/lab-04/uji.php`. Seluruh pengujian memakai folder sementara, tidak menyentuh data utama. Tes memeriksa pencarian, log, JSON, CSV, kesalahan file, dan keamanan output.

## 9. Bukti pengumpulan

Siapkan tangkapan layar untuk: pencarian berhasil (`q=sa`), pencarian tidak ditemukan (`q=zzz`), log terbaru, JSON sesudah tambah Deni, tabel impor CSV, pesan error JSON rusak, dan hasil uji otomatis. Simpan di `docs/screenshot/` jika diminta dosen/guru.
