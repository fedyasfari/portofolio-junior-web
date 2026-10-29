# Skenario pengujian manual Lab 4

Centang setelah menjalankan di XAMPP:

- [ ] `cari.php?q=sa` -> Sari ditemukan.
- [ ] `cari.php?q=BU` -> Budi ditemukan (case-insensitive).
- [ ] `cari.php?q=zzz` -> pesan tidak ada hasil.
- [ ] `cari.php?q=%3Cscript%3Ealert(1)%3C%2Fscript%3E` -> teks terlihat aman, tidak muncul popup.
- [ ] Buka `lihat-log.php` -> log berformat `waktu | IP | kata kunci`.
- [ ] Ulangi pencarian sebanyak 25 kali -> halaman log tetap menampilkan maksimal 20 baris (terbaru di atas).
- [ ] `json.php` pertama kali -> JSON dibuat jika belum ada; tabel 3 peserta.
- [ ] Tambah `Deni`, `Web`, `75` -> tabel JSON 4 peserta.
- [ ] `cari.php?q=de` -> Deni ditemukan setelah JSON ditambah.
- [ ] `csv.php` klik Ekspor -> file `data/peserta.csv` ada dan halaman menampilkan 4 peserta hasil impor.
- [ ] Rename `data/peserta.csv` -> halaman CSV menampilkan pesan file tidak ada.
- [ ] Rusakkan `data/peserta.json` sementara dengan isi `{rusak` -> halaman JSON menampilkan kesalahan JSON.
- [ ] Tekan Pulihkan JSON -> kembali 3 peserta (ingat data sebelumnya tertimpa).
- [ ] Rename folder `data/` sementara -> buka cari -> folder dibuat lagi.
- [ ] Buka `uji.php` -> semua tes LULUS.

**Peringatan:** sebelum menguji kerusakan, salin/backup `peserta.json` dan `peserta.csv` jika berisi data yang ingin disimpan. File `log.txt` dapat berisi IP pengunjung, jangan diunggah atau dibagikan.
