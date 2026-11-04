# Dokumen Modul: Pengelolaan Pendaftar

> **ID:** MOD-PDF-001  
> **Berkas:** `src/pendaftar.php`  
> **Versi:** `1.0.1` — **aktif**  
> **Terakhir diperbarui:** 3 November 2026  
> **Penulis:** Nama Peserta (**ganti dengan nama Anda sebelum dikumpulkan**)  
> **Ruang lingkup:** Dokumentasi modul dari proyek Capstone Pendaftaran.

## 1. Identitas dan ringkasan modul (format Lab 3)

| Bagian | Isi |
|---|---|
| **ID modul / berkas** | **MOD-PDF-001 / `src/pendaftar.php`** |
| **Versi dan status** | **1.0.1 / aktif** (penomoran dokumentasi Lab 3) |
| **Penulis dan tanggal** | **Nama Peserta (isi sendiri) / 3 November 2026** |
| **Kegunaan** | Mengambil daftar kelas/peserta, mencari dan membaca peserta, memvalidasi data pendaftaran, serta melakukan operasi tambah, ubah, dan hapus pada tabel `pendaftar`. |
| **Dependensi** | `src/bootstrap.php` (memuat modul); `src/database.php` → `getConnection()` untuk `PDO`; `src/validasi.php` → `validNoHp()`; tabel database `kelas` dan `pendaftar`. **Modul pendamping proses kuota:** `src/kuota.php` → `daftarkanDenganKuota()` dan `ubahPendaftarDenganKuota()` yang memanggil fungsi simpan pada modul ini. |
| **Fungsi publik** | `daftarKelas()`, `ambilSemuaPendaftar()`, `cariPendaftar()`, `ambilBuktiPendaftar()`, `ambilPendaftarById()`, `validasiPendaftar()`, `tambahPendaftar()`, `ubahPendaftar()`, `hapusPendaftar()` — **9 fungsi**. |
| **Catatan keamanan** | Query dengan masukan pengguna menggunakan *prepared statement*/parameter terikat; validasi nama, email, no. HP, alamat, dan kelas; email duplikat diperiksa. CSRF, autentikasi admin, pemeriksaan metode HTTP, dan escaping keluaran ditangani di endpoint/helpers. Pengecekan kuota secara atomik **harus** memakai `src/kuota.php`, bukan `tambahPendaftar()` langsung. |
| **Contoh pemakaian** | `validasiPendaftar($_POST, $pdo)` pada `public/daftar.php`; `ambilPendaftarById($pdo, $id)` pada `public/ubah.php`; `ambilSemuaPendaftar(getConnection())` pada `public/index.php`. |
| **Riwayat revisi** | Lihat tabel pada bagian 5; **entri 1.0.1 bertanggal 3 November 2026** untuk pembaruan dokumentasi dan penyelarasan versi header `src/pendaftar.php`. |

## 2. Tanggung jawab dan batas modul

Modul `pendaftar.php` menangani operasi data peserta (*data access* dan validasi), bukan pengendalian akses halaman dan bukan perlindungan kuota yang bersifat transaksional. Setelah `validasiPendaftar()` menghasilkan `galat` kosong, proses tambah **belum tentu dapat dilakukan** karena kursi kelas mungkin habis. Pemeriksaan akhir harus dilakukan di `src/kuota.php` agar pendaftaran paralel tidak melampaui kuota.

Halaman yang memakai modul ini antara lain `public/index.php`, `daftar.php`, `tambah.php`, `ubah.php`, `hapus.php`, dan `cetak.php`.

## 3. Rincian seluruh fungsi publik

| Fungsi dan signature | Kegunaan | Parameter | Nilai kembali / kasus khusus |
|---|---|---|---|
| `daftarKelas(PDO $pdo): array` | Menampilkan kelas, kuota, jumlah terisi, dan sisa tempat. | `$pdo`: koneksi database. | Array daftar kelas; `PDOException` jika query gagal. |
| `ambilSemuaPendaftar(PDO $pdo): array` | Menampilkan seluruh peserta beserta nama kelas, ID terbaru dahulu. | `$pdo`: koneksi database. | Array daftar peserta, dapat kosong; `PDOException` bila gagal. |
| `cariPendaftar(PDO $pdo, string $cari): array` | Mencari nama atau email menggunakan SQL `LIKE`. | `$pdo`: koneksi; `$cari`: kata kunci. | Array peserta yang cocok, dapat kosong; `PDOException` bila gagal. |
| `ambilBuktiPendaftar(PDO $pdo, int $id): ?array` | Mengambil informasi peserta dan kelas untuk PDF bukti. | `$pdo`: koneksi; `$id`: ID peserta positif yang telah diperiksa oleh pemanggil. | Array detail atau `null` jika tidak ditemukan. |
| `ambilPendaftarById(PDO $pdo, int $id): ?array` | Mengambil satu baris peserta lengkap untuk diubah atau diperiksa. | `$pdo`: koneksi; `$id`: ID peserta. | Array data atau `null` jika ID tidak ditemukan. |
| `validasiPendaftar(array $input, PDO $pdo, ?int $kecualiId = null): array` | Menormalkan input dan mengumpulkan pesan kesalahan per kolom. | `$input`: nilai formulir; `$pdo`: koneksi; `$kecualiId`: ID peserta yang dikecualikan saat pemeriksaan duplikasi email ketika edit (default `null`). | `['data' => [...], 'galat' => [...]]`; `galat` kosong jika valid. Kuota **belum** dijamin tersedia. |
| `tambahPendaftar(PDO $pdo, array $data): int` | Melakukan `INSERT` satu peserta. | `$pdo`: koneksi; `$data`: data yang sudah divalidasi. | ID peserta baru. **Tidak mengecek kuota**; alur normal harus memakai `daftarkanDenganKuota()`. |
| `ubahPendaftar(PDO $pdo, int $id, array $data): void` | Melakukan `UPDATE` peserta. | `$pdo`: koneksi; `$id`: peserta yang diubah; `$data`: data hasil validasi. | Tidak mengembalikan nilai. **Tidak mengecek kuota**; alur normal harus memakai `ubahPendaftarDenganKuota()`. |
| `hapusPendaftar(PDO $pdo, int $id): void` | Menghapus peserta berdasarkan ID. | `$pdo`: koneksi; `$id`: ID yang dihapus. | Tidak mengembalikan nilai; pemanggil wajib memeriksa login, CSRF, metode POST, dan ID. |

**Perhatian:** Semua fungsi yang melakukan query database dapat menimbulkan `PDOException` ketika operasi database gagal. Fungsi pengambilan data dengan nilai kembali `?array` menghasilkan `null` ketika baris tidak ditemukan, bukan karena exception query.

### Batas validasi pada `validasiPendaftar()`

| Data | Aturan pada kode |
|---|---|
| `nama` | 3 sampai 150 karakter setelah `trim()` |
| `email` | Format email valid dan panjang maksimal 190 byte; dikonversi ke huruf kecil |
| `no_hp` | Diawali `08`, terdiri atas 10–13 digit |
| `alamat` | Maksimal 1.000 karakter |
| `kelas_id` | Bilangan bulat positif dan harus merujuk kelas pada daftar |
| Duplikasi email | Email lain tidak boleh sama; saat edit, peserta dengan ID `$kecualiId` dikecualikan |

Jika ada data tidak sesuai, fungsi menaruh pesan kesalahan pada `galat`, misalnya `galat['email']` atau `galat['kelas_id']`.

## 4. Contoh pemakaian dari alur proyek

**A. Mengambil daftar peserta pada halaman admin:**

```php
<?php
require_once __DIR__ . '/../src/bootstrap.php';
wajibLogin();
$daftar = ambilSemuaPendaftar(getConnection());
```

**B. Memvalidasi formulir pendaftaran publik:**

```php
<?php
// Cuplikan: jalankan hanya setelah bootstrap.php dan cekCsrf() pada POST.
$pdo = getConnection();
['data' => $data, 'galat' => $galat] = validasiPendaftar($_POST, $pdo);

if ($galat === []) {
    try {
        // Perlindungan kuota berada di src/kuota.php, bukan di tambahPendaftar().
        $idBaru = daftarkanDenganKuota($pdo, $data);
    } catch (KuotaPenuhException $e) {
        $galat['kelas_id'] = $e->getMessage(); // Minta pengguna memilih kelas lain.
    } catch (KelasTidakDitemukanException $e) {
        $galat['kelas_id'] = 'Kelas tidak tersedia. Silakan pilih ulang.';
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $galat['email'] = 'Data belum dapat disimpan. Silakan coba lagi.';
    }
}
```

**C. Mengambil data peserta untuk halaman ubah:**

```php
<?php
// ID berasal dari URL tetapi harus divalidasi lebih dahulu.
$id = validId($_GET['id'] ?? null);
if ($id === null) {
    http_response_code(404);
    exit('Data tidak ditemukan.');
}
$pendaftar = ambilPendaftarById(getConnection(), $id);
```

### Catatan keamanan dan pemulihan

1. Parameter SQL seperti `:id`, `:email`, dan `:nama` dipisahkan dari teks query melalui PDO; ini membantu mencegah SQL injection pada nilai masukan.
2. Fungsi CRUD di `src/pendaftar.php` **tidak** otomatis membatasi akses. Endpoint `public/tambah.php`, `ubah.php`, `hapus.php`, dan `index.php` memakai `wajibLogin()` sesuai kebutuhan.
3. Form POST harus memeriksa token CSRF melalui `cekCsrf()`; endpoint hapus juga memeriksa metode `POST` dan konfirmasi pengguna.
4. Saat nilai ditampilkan di HTML, gunakan helper `e()` untuk menghindari injeksi HTML (XSS); `pendaftar.php` sendiri tidak merender HTML.
5. Untuk menambah atau mengubah kelas peserta, panggil `daftarkanDenganKuota()` atau `ubahPendaftarDenganKuota()` pada `src/kuota.php`. Dua fungsi tersebut menggunakan transaksi dan penguncian baris kelas serta melakukan *rollback* jika gagal.
6. Pengecekan email duplikat melalui `SELECT COUNT(*)` membantu memberikan pesan yang mudah dipahami, tetapi penolakan duplikasi serentak perlu dijamin juga oleh batasan unik di database apabila tersedia.

## 5. Riwayat revisi

| Versi | Tanggal | Perubahan | Penulis |
|---|---|---|---|
| **1.0.1** | **3 November 2026** | Menyusun dokumen `docs/modul/pendaftar.md`, memetakan seluruh sembilan fungsi, dependensi, aturan validasi, keamanan, dan contoh pemakaian; menambahkan header `@version 1.0.1` pada `src/pendaftar.php`. Perubahan hanya dokumentasi, tanpa perubahan logika CRUD. | Nama Peserta (isi sendiri) |

**Catatan versi:** angka `1.0.0` adalah contoh versi dasar pada soal Lab 3; tidak ada bukti riwayat rilis sebelumnya pada kode yang diunggah. Tabel tidak mengarang tanggal/penulis rilis itu. Nomor `1.0.1` digunakan sebagai versi tugas dokumentasi yang konsisten dengan header berkas sumber.

## 6. Hubungan dengan tugas sebelumnya

- **Lab 1:** memetakan fungsi dan tanggung jawab `src/pendaftar.php`.
- **Lab 2:** melengkapi PHPDoc pada sembilan fungsi, termasuk tipe parameter dan keluaran.
- **Lab 3:** mendokumentasikan modul secara terstruktur dan menyelaraskan versi dokumen serta berkas sumber.
