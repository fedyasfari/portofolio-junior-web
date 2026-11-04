# LAB 2 — PHPDoc dan JSDoc

**Proyek:** Capstone Pendaftaran PHP + MySQL  
**Sumber:** `src.rar` dan `public.rar` dari Lab 1  
**Tujuan:** melengkapi dokumentasi fungsi tanpa mengubah perilaku program.

## 1. Apa yang telah dikerjakan?

- **30 dari 30 fungsi tingkat global pada `src/`** telah memperoleh DocBlock PHPDoc yang menjelaskan tujuan, parameter bila ada, dan nilai kembali.
- `@throws` digunakan **hanya pada fungsi yang dapat melempar atau meneruskan exception**. Fungsi yang tidak melempar exception tidak diberi `@throws` palsu; ini sesuai praktik PHPDoc.
- Kedua kelas exception khusus di `src/kuota.php` diberi keterangan fungsi dan cara pemulihan.
- `public/assets/js/app.js` telah dilengkapi JSDoc pada fungsi inisialisasi, handler submit, fungsi `kirim`, dan callback konfirmasi SweetAlert2.
- Dokumentasi Lab 1 pada `docs/peta-modul.md` disertakan agar tugas terdokumentasi berurutan.

### Cakupan PHPDoc

| Berkas | Fungsi yang didokumentasikan | Jumlah |
|---|---|---:|
| `src/auth.php` | `cariAdmin`, `prosesLogin`, `wajibLogin`, `logout` | 4 |
| `src/bootstrap.php` | Tidak mendefinisikan fungsi publik (berisi inisialisasi) | 0 |
| `src/database.php` | `getConnection` | 1 |
| `src/helpers.php` | `e`, `tokenCsrf`, `cekCsrf`, `hanyaPost`, `setFlash`, `ambilFlash`, `alihkan`, `redirect`, `sudahLogin`, `bolehCetak`, `validId` | 11 |
| `src/kuota.php` | `daftarkanDenganKuota`, `ubahPendaftarDenganKuota` | 2 |
| `src/pendaftar.php` | `daftarKelas`, `ambilSemuaPendaftar`, `cariPendaftar`, `ambilBuktiPendaftar`, `ambilPendaftarById`, `validasiPendaftar`, `tambahPendaftar`, `ubahPendaftar`, `hapusPendaftar` | 9 |
| `src/validasi.php` | `validNoHp`, `hitungSisaKuota`, `formatNomorBukti` | 3 |
| **Total** | | **30** |

## 2. Mengenal PHPDoc

DocBlock PHPDoc ditulis tepat di atas deklarasi fungsi.

```php
/**
 * Mengambil satu pendaftar berdasarkan ID.
 *
 * @param PDO $pdo Koneksi database aktif.
 * @param int $id ID peserta (minimal 1; divalidasi oleh pemanggil).
 * @return array<string, mixed>|null Data peserta, atau null jika tidak ditemukan.
 * @throws PDOException Jika query gagal; periksa koneksi dan log.
 */
function ambilPendaftarById(PDO $pdo, int $id): ?array
```

- Baris pertama: **tujuan** fungsi.
- `@param`: nama, jenis dan makna parameter.
- `@return`: jenis data yang dikembalikan, termasuk kondisi `null`.
- `@throws`: jenis kesalahan yang dilempar/dapat diteruskan, serta tindakan yang disarankan.
- `array<string, mixed>` adalah dokumentasi tipe array asosiatif; ini bukan sintaks deklarasi tipe parameter pada bahasa PHP.
- Tanda `?array` berarti hasil bisa array atau `null`.

### Perbedaan komentar biasa dan PHPDoc

```php
// Komentar biasa: berguna sebagai catatan dalam kode.

/**
 * DocBlock terstruktur: dibaca oleh editor dan alat analisis.
 * @param int $angka Angka yang akan diproses.
 * @return bool True jika syarat terpenuhi.
 */
```

## 3. Mengenal JSDoc

JSDoc memiliki fungsi yang sama, tetapi untuk JavaScript. Karena `app.js` semula menggunakan fungsi anonim pada event listener dan Promise, callback tersebut diberi nama agar dokumentasinya mudah ditemukan lewat Hover di VS Code.

```js
/**
 * Menangani pengiriman form hapus setelah pengguna memberi konfirmasi.
 * @param {SubmitEvent} event Peristiwa submit formulir.
 * @returns {void} Tidak mengembalikan data.
 */
function tanganiSubmitHapus(event) {
  // Logika penghapusan ada dalam berkas app.js.
}
```

Perhatikan perbedaan sintaks:

- PHPDoc: `@param int $id`.
- JSDoc: `@param {number} id`.
- PHPDoc: `@return`.
- JSDoc: `@returns` (atau `@return`, namun dipakai `@returns` di proyek ini).

## 4. Kapan menggunakan `@throws` dan cara pemulihannya

| Exception atau penghentian | Sumber | Penanganan yang sesuai |
|---|---|---|
| `KuotaPenuhException` | `daftarkanDenganKuota`, `ubahPendaftarDenganKuota` | Tangkap di endpoint; tampilkan pesan bahwa kelas penuh; minta peserta memilih kelas lain. |
| `KelasTidakDitemukanException` | Dua fungsi kuota | Muat ulang daftar kelas dan minta pengguna memilih kelas yang masih tersedia. |
| `PDOException` | Operasi database di `pendaftar.php`, `auth.php`, dan `kuota.php` | Simpan detail ke log server, tampilkan pesan umum, dan rollback transaksi jika masih aktif. |
| `Random\RandomException` | `tokenCsrf` (ketika `random_bytes()` gagal) | Catat gangguan server dan minta formulir dicoba lagi. |
| `exit(...)`, `redirect(...)` | `cekCsrf`, `hanyaPost`, `alihkan`, `redirect`, `getConnection` saat koneksi gagal | **Bukan** exception yang dapat ditangkap dengan `catch`. Fungsi mengirim respons/redirect lalu menghentikan request. |

> **Penting:** Komentar `@throws` **tidak membuat PHP otomatis menangani error**. Untuk menangkap exception, program tetap memerlukan `try { ... } catch (...) { ... }`.

### Contoh menangani kuota penuh

```php
try {
    $idBaru = daftarkanDenganKuota($pdo, $hasil['data']);
} catch (KuotaPenuhException $e) {
    $galat['kelas_id'] = 'Kuota penuh. Silakan pilih kelas lain.';
} catch (KelasTidakDitemukanException $e) {
    $galat['kelas_id'] = 'Kelas tidak tersedia. Pilih kelas yang lain.';
} catch (PDOException $e) {
    error_log($e->getMessage());
    $galat['email'] = 'Pendaftaran gagal disimpan. Silakan coba lagi.';
}
```

Ini contoh untuk dipelajari, **bukan** instruksi menimpa kode endpoint yang sudah tersedia. Pada arsip asli `public/daftar.php`, pengecualian kelas penuh dan kelas tidak ditemukan sudah ditangani.

## 5. Cara memasang berkas di VS Code (Windows + XAMPP)

1. **Cadangkan proyek**. Contoh: salin seluruh folder `proyek-5-capstone-pendaftaran` menjadi `proyek-5-capstone-pendaftaran-backup`.
2. Buka folder proyek asli di VS Code melalui **File → Open Folder**.
3. Ekstrak ZIP hasil Lab 2 ini, kemudian **salin folder `src` dan `docs`** ke root proyek dan izinkan overwrite berkas yang namanya sama.
4. Salin `public/assets/js/app.js` dari ZIP ke lokasi yang sama di proyek; izinkan overwrite.
5. **Jangan hapus `config/`, `templates/`, `vendor/`, `database/`, atau berkas halaman `public/*.php`** di proyek asli. Paket ZIP ini hanya memuat berkas yang berubah dan dokumentasi.
6. Buka `src/pendaftar.php`, gulir ke `function validasiPendaftar`, dan amati DocBlock di atasnya.

## 6. Cara memeriksa Hover DocBlock di VS Code

**Untuk PHP:**

1. Buka **Extensions** (`Ctrl+Shift+X`), cari **PHP Intelephense**, lalu instal/aktifkan jika belum ada.
2. Buka `public/daftar.php` dan arahkan mouse ke nama `validasiPendaftar` dalam pemanggilan berikut:

   ```php
   validasiPendaftar($_POST, $pdo)
   ```

3. Tunggu pop-up yang menampilkan deskripsi, parameter, dan nilai kembali; bergantung versi ekstensi, bagian `@throws` juga dapat terlihat.
4. Coba pemanggilan `daftarkanDenganKuota()` di halaman yang sama untuk membaca peringatan exception.
5. Tekan `Ctrl` + klik nama fungsi jika ingin menuju definisinya di folder `src/`.
6. Jika Hover tidak muncul, pastikan seluruh folder proyek dibuka sebagai workspace (bukan hanya satu berkas), kemudian jalankan **Developer: Reload Window** dari Command Palette (`Ctrl+Shift+P`).

**Untuk JavaScript:**

1. Buka `public/assets/js/app.js`.
2. Arahkan mouse ke pemanggilan `tanganiSubmitHapus` atau `tanganiKonfirmasi` dan lihat JSDoc-nya.
3. Fitur JavaScript Hover umumnya sudah tersedia melalui dukungan JavaScript bawaan VS Code.

**Bukti praktik yang dapat dikumpulkan:** tangkapan layar kode DocBlock PHPDoc, pop-up Hover pada pemanggilan PHP, kode JSDoc JavaScript, serta pop-up Hover JavaScript. Sesuaikan dengan permintaan pengajar.

## 7. Memeriksa sintaks tanpa menjalankan aplikasi

Buka terminal PowerShell pada root proyek.

**Periksa satu berkas:**

```powershell
& 'C:\xampp\php\php.exe' -l .\src\pendaftar.php
```

**Periksa seluruh `src/`:**

```powershell
Get-ChildItem .\src -Filter *.php | ForEach-Object {
    & 'C:\xampp\php\php.exe' -l $_.FullName
}
```

**Periksa JavaScript (jika Node.js sudah dipasang):**

```powershell
node --check .\public\assets\js\app.js
```

Hasil yang diharapkan untuk PHP adalah `No syntax errors detected`. Untuk `node --check`, keberhasilan biasanya tidak menghasilkan keluaran teks dan kembali ke prompt.

## 8. Hasil pemeriksaan paket ini

- [x] **30/30** fungsi PHP telah memiliki DocBlock di tepat atas deklarasinya.
- [x] Seluruh berkas PHP di `src/` lolos `php -l` (PHP 8.4 pada lingkungan pemeriksaan).
- [x] File `app.js` lolos pemeriksaan `node --check` (Node.js v22).
- [x] Perbandingan token PHP sebelum/sesudah menghasilkan hasil **identik bila whitespace dan komentar diabaikan**. Tidak ada perubahan logika PHP.
- [x] JSDoc memiliki `@param` untuk fungsi yang menerima parameter dan `@returns` untuk semua fungsi.
- [ ] Pemeriksaan Hover langsung di VS Code komputer pengguna **belum dilakukan**; ikuti panduan langkah 6.
- [ ] Uji login, daftar, edit, dan hapus secara langsung **belum dilakukan** karena arsip tidak memuat seluruh lingkungan aplikasi (`config/`, `templates/`, database, dan dependensi).

## 9. Catatan untuk pengumpulan

Sebaiknya kumpulkan folder `src/` dan file `public/assets/js/app.js` yang telah diperbarui, beserta laporan singkat atau screenshot Hover dari VS Code. `docs/lab2-panduan.md` dapat dijadikan referensi penjelasan tugas. Dokumentasi tidak menggantikan pengujian aplikasi pada komputer Anda.
