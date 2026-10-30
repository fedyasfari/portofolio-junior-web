# 05 — Rencana Pengujian CRUD (Uji Manual Wajib)

**Prasyarat:** Apache+MySQL hidup; `config/config.php` disalin dari contoh dan disesuaikan; `database/skema.sql` sudah diimpor. Hanya uji dengan data fiktif.

| ID | Skenario uji | Langkah singkat | Hasil yang diharapkan | Realisasi |
|---|---|---|---|---|
| TC-01 | Koneksi | Buka `public/index.php` | Tabel tampil, bukan error 1045/1049 | ☐ |
| TC-02 | Import skema | Impor skema dari database kosong | 3 tabel, 3 kelas, 12 pendaftar, 0 admin | ☐ |
| TC-03 | Peserta daftar valid | Buka `daftar.php`, isi data unik dan valid, Simpan | Tersimpan dan diarahkan ke `selesai.php` | ☐ |
| TC-04 | Admin menambah | Buka `tambah.php`, masukkan nama+email baru | 1 baris baru tampil | ☐ |
| TC-05 | Form kosong | Kirim `tambah.php` tanpa data | Pesan kesalahan pada field wajib | ☐ |
| TC-06 | Email ganda | Isi `andi@example.com` | Ditolak: email sudah terdaftar | ☐ |
| TC-07 | Tidak pilih kelas | Isi benar kecuali kelas kosong | Muncul pesan harus pilih kelas | ☐ |
| TC-08 | Nomor HP salah | Isi `12345` | Pesan format nomor HP | ☐ |
| TC-09 | Ubah | Buka Ubah peserta tertentu, ubah nomor HP | Data target berubah, data lain tetap | ☐ |
| TC-10 | Hapus | Hapus 1 peserta fiktif | Tepat satu data hilang | ☐ |
| TC-11 | Cari | Cari `Andi` | Hasil mengandung nama sesuai | ☐ |
| TC-12 | Halaman 2 | Buka `index.php?hal=2` pada 12 seed | Halaman 2 tersedia (2 baris sebelum perubahan) | ☐ |
| TC-13 | Ubah ID tidak valid | Buka `ubah.php?id=abc` dan `?id=9999` | HTTP 404 | ☐ |
| TC-14 | Hapus tanpa token | POST `id=1` tanpa CSRF | HTTP 403, data tidak dihapus | ☐ |
| TC-15 | Escaping XSS | Masukkan `<script>alert(1)</script>` sebagai teks nama pada database uji, buka daftar | Teks di-escape; popup tidak muncul | ☐ |
| TC-16 | Pencarian aman | Cari `%' OR 1=1 --` | Tidak menampilkan seluruh data dari injeksi | ☐ |
| TC-17 | Kualitas log | Jalankan alur utama; cek `apache/logs/error.log` | Tidak ada Warning/Notice baru terkait proyek | ☐ |
| TC-18 | Git config | `git check-ignore config/config.php` | File terabaikan; tidak ada di `git ls-files` | ☐ |

## Contoh data valid
- Nama: `Rina Amelia`
- Email: `rina.amilia@example.com` (gunakan alamat fiktif baru yang belum ada)
- HP: `081234567890`
- Kelas: `Web Development`
- Alamat: `Surakarta`

## Uji respons HTTP (Windows PowerShell)

```powershell
curl.exe -i "http://localhost/proyek-5-capstone-pendaftaran/public/ubah.php?id=abc"
curl.exe -i -X POST "http://localhost/proyek-5-capstone-pendaftaran/public/hapus.php" -d "id=1"
```

Baris pertama harus merespons 404; baris kedua harus 403 karena tidak punya token CSRF. **Jangan jalankan penghapusan tanpa `WHERE`** untuk menguji fungsi hapus.

## Menguji XSS tanpa salah paham
Validasi form menolak nama terlalu pendek tetapi bukan semua karakter `<` dan `>`. Cara yang aman: di database latihan saja, masukkan nama panjang berisi `<script>` pada satu data fiktif melalui phpMyAdmin, lalu buka daftar dan amati. Jika output di-escape, teks terlihat dan tidak menjalankan alert. Setelah uji, kembalikan nama semula.

## Kapan dianggap lulus?
Catat hasil aktual dan screenshot. Jangan menulis 'semua berhasil' jika belum menjalankan kasus. Uji ini adalah **rencana**; hasil dari XAMPP pengguna belum diverifikasi saat paket dibuat.
