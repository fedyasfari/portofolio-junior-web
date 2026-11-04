# Laporan PBL Hari 10 — Capstone Sprint 1

Nama: [isi]  
Tanggal pelaksanaan: [isi]  
Folder proyek: [isi]  
Database: db_pendaftaran_sprint1 / [lainnya]

## 1. Tujuan
Meningkatkan Capstone Pendaftaran Pelatihan menjadi aplikasi antarmuka profesional dengan Bootstrap, DataTables, SweetAlert2, Dompdf, form pendaftaran publik, audit dependency, dokumentasi, dan Git.

## 2. Daftar pekerjaan dan hasil pengujian

| No | Kriteria | Langkah uji | Hasil aktual | Status | Bukti screenshot |
|---|---|---|---|---|---|
| 1 | Bootstrap semua halaman | Coba 360 px & desktop; navbar, form, tabel, alert | [isi] | [Lulus/Gagal] | [isi] |
| 2 | DataTables admin | Login; cari, klik header, >10 baris dan pindah halaman | [isi] | [Lulus/Gagal] | [isi] |
| 3 | SweetAlert2 | Hapus dummy → Batal, Hapus → Ya, dan toast sesudah tambah | [isi] | [Lulus/Gagal] | [isi] |
| 4 | PDF bukti bernomor | Daftar → Cetak, cek isi, nomor REG, A5 | [isi] | [Lulus/Gagal] | [isi] |
| 5 | Form publik | Buka daftar.php dalam mode incognito tanpa login, submit valid | [isi] | [Lulus/Gagal] | [isi] |
| 6 | Dokumentasi library | Periksa docs/daftar-library.md | [isi] | [Lulus/Gagal] | [isi] |
| 7 | Audit dependency | Jalankan composer outdated, composer audit, npm outdated bila ada | [isi] | [Lulus/Gagal] | [isi] |
| 8 | Git | Periksa git ls-files composer.lock, git check-ignore vendor config/config.php | [isi] | [Lulus/Gagal] | [isi] |

## 3. Keamanan aplikasi

| Uji | Ekspektasi | Hasil aktual |
|---|---|---|
| Akses index.php tanpa login | Redirect ke login admin | [isi] |
| Akses cetak.php?id=1 dari browser lain | Ditolak 403 jika tidak berhak | [isi] |
| Hapus memakai GET | Ditolak 405 (ketika admin login) | [isi] |
| POST hapus tanpa CSRF | Ditolak 403 | [isi] |
| Form publik disisipi `<script>alert(1)</script>` pada input nama | Nama tidak tereksekusi sebagai JavaScript | [isi] |
| Form tidak valid | Pesan error merah di bawah field | [isi] |
| URL cetak memakai ID salah | Menampilkan 404 setelah hak akses sesuai | [isi] |
| Tombol Hapus → Batal pada halaman 2 | Tidak menghapus | [isi] |

## 4. Hasil perintah pemeriksaan

**composer show dompdf/dompdf**

```text
[tempel hasil terminal]
```

**composer outdated**

```text
[tempel hasil terminal]
```

**composer audit**

```text
[tempel hasil terminal]
```

**npm outdated** *(isi jika folder memiliki package.json; selain itu tulis tidak berlaku)*

```text
[tempel hasil terminal atau alasan tidak berlaku]
```

**git status --short / git ls-files composer.lock**

```text
[tempel hasil terminal]
```

## 5. Bug yang ditemukan dan tindak lanjut

| Error | Penyebab | Perbaikan | Status |
|---|---|---|---|
| [isi] | [isi] | [isi] | [isi] |

## 6. Kesimpulan (isi setelah tes nyata)

[Jelaskan apa yang berhasil, apakah Definition of Done dipenuhi, apa kendala dan perbaikan selanjutnya. Hindari menyatakan "seluruh tes lulus" bila belum benar-benar dites di XAMPP.]
