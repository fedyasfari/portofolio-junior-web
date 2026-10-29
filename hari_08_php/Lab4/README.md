# Lab 4 — Form GET dan Akses File (PHP)

Proyek belajar PHP 8+ dengan data awal Sari (Web, 90), Budi (Web, 68), Citra (Data, 82). Memenuhi tugas pencarian GET, logging pengunjung, baca/tulis JSON, ekspor/impor CSV, dan penanganan error.

## Kebutuhan

- XAMPP: Apache aktif, PHP **8.0+** (proyek diuji dengan PHP 8.4).
- Browser: Chrome, Firefox, Edge.
- Visual Studio Code untuk mengedit kode (opsional).

## Instalasi

1. Ekstrak paket ZIP.
2. Salin seluruh folder `lab-04/` ke `C:\xampp\htdocs\hari-08\`.
3. Jalankan Apache pada XAMPP Control Panel.
4. Buka <http://localhost/hari-08/lab-04/index.php>.
5. Coba semua fitur melalui menu navigasi.

## Alamat halaman

| Alamat | Tujuan |
| --- | --- |
| `index.php` | Dashboard dan data awal |
| `cari.php?q=sa` | GET, pencarian sebagian nama, dan pencatatan log setiap kunjungan |
| `lihat-log.php` | 20 kunjungan terakhir |
| `json.php` | Buat JSON awal, tambah satu peserta, lihat isinya, pulihkan JSON rusak |
| `csv.php` | Ekspor CSV dari JSON yang valid (atau data awal), lalu impor kembali |
| `uji.php` | Pengujian fungsi otomatis (tidak mengubah data nyata) |

## Alur latihan yang disarankan

1. **Pencarian:** buka `cari.php?q=sa` -> Sari, lalu `cari.php?q=BU` -> Budi, `cari.php?q=zzz` -> tidak ada hasil.
2. **Log:** buka `lihat-log.php`; pastikan kunjungan tampil berisi format `YYYY-MM-DD HH:MM:SS | IP | kata kunci` dan terbaru di atas.
3. **JSON:** buka `json.php`; `data/peserta.json` dibuat otomatis, berisi 3 peserta. Tambah `Deni`, `Web`, `75`; jumlah peserta menjadi 4. Pencarian sekarang juga bisa menemukan Deni.
4. **CSV:** buka `csv.php`, klik **Ekspor CSV Sekarang**, lihat tabel hasil impor. File `data/peserta.csv` terbentuk dengan header `nama,kelas,nilai`.
5. **Tes otomatis:** buka `uji.php`; lihat jumlah tes yang lulus.
6. **Tes error:** rename `data/peserta.csv` sementara, buka halaman CSV -> pesan file tidak ada; ubah `data/peserta.json` menjadi `{rusak` -> halaman JSON menunjukkan kesalahan, tombol **Pulihkan JSON** dapat mengembalikan data awal (isi sebelumnya akan tertimpa).
7. **Tes folder data hilang:** stop Apache, ubah nama folder `data` menjadi `data-cadangan`, jalankan kembali dan buka `cari.php`. Folder `data/` baru akan dibuat. Setelah selesai, hapus folder `data/` pengujian jika perlu dan kembalikan `data-cadangan` menjadi `data`. Jangan lupa memindahkan `.htaccess` dari paket jika membuat folder baru dengan `mkdir` karena file `.htaccess` tidak dibuat otomatis.

## Fungsi utama di `fungsi.php`

- `cariPeserta(array $peserta, string $kataKunci): array` menggunakan `stripos`.
- `catatKunjungan(...)` menggunakan `file_put_contents(..., FILE_APPEND | LOCK_EX)`.
- `bacaLogTerakhir()` menggunakan `array_slice(array_reverse($baris), 0, 20)`.
- `siapkanFolderData()` menangani `mkdir`.
- `simpanPesertaJson()`, `bacaPesertaJson()`, `tambahPesertaJson()` menggunakan `json_encode`, `json_decode` dan `json_last_error`.
- `eksporPesertaCsv()` dan `imporPesertaCsv()` menggunakan `fputcsv`, `fgetcsv`.
- `e()` untuk `htmlspecialchars` di HTML.

## Berkas otomatis

- `data/log.txt`: dibuat ketika halaman `cari.php` dibuka.
- `data/peserta.json`: dibuat saat `json.php` dibuka, jika belum ada.
- `data/peserta.csv`: dibuat saat tombol ekspor di `csv.php` ditekan.

File otomatis tidak disertakan dalam ZIP agar pengujian "file belum ada" mudah dicoba. File-file ini diabaikan oleh `data/.gitignore` agar log IP tidak ikut diunggah ke GitHub.

## Keamanan dan batasan

- Ini untuk **belajar di localhost**; jangan mempublikasikan halaman log dan halaman pengelolaan file tanpa autentikasi, izin akses, perlindungan CSRF, dan penanganan penyimpanan yang lebih kuat.
- `data/.htaccess` menghalangi akses HTTP langsung ke file melalui Apache 2.4. Bila `data/` terhapus dan dibuat otomatis oleh `mkdir`, file `.htaccess` tidak ikut kembali; salin lagi dari paket sebelum mempublikasikan.
- Log menyimpan alamat IP dan kata kunci; batasi akses dan hapus secara berkala.
- Seluruh nilai dinamis yang tampil pada HTML di-escape menggunakan `htmlspecialchars`.
- Penguncian `FILE_APPEND | LOCK_EX` dipakai pada log. Pengelolaan JSON/CSV ditujukan untuk satu pengguna lokal, belum untuk akses banyak pengguna bersamaan.
- Untuk latihan, data awal memakai nama kelas Web/Data dan nilai 0–100. Form tambah peserta membatasi nama agar aman dan mudah diuji.

Bacaan rinci: [docs/panduan-tahap-demi-tahap.md](docs/panduan-tahap-demi-tahap.md) dan [docs/skenario-pengujian.md](docs/skenario-pengujian.md).
