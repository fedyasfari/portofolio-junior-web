# LAPORAN PRAKTIKUM — PBL HARI 7, PROYEK 3

**Judul:** Simulator Antrean dan Riwayat Catatan Klinik  
**Nama peserta:** ........................................  
**Kelas:** ........................................  
**Tanggal:** ........................................

## A. Pendahuluan

Sebuah klinik kecil membutuhkan sistem antrean pasien yang mendahulukan pasien yang mengambil nomor lebih dulu. Klinik juga membutuhkan editor catatan sederhana yang mendukung pembatalan dan pengulangan perubahan teks. Solusinya menggabungkan materi struktur data Hari 6–7 dan Clean Code Hari 7.

## B. Tujuan

1. Mengimplementasikan LinkedQueue untuk antrean FIFO bernomor A001 dan seterusnya.
2. Menerapkan dua Stack untuk Undo dan Redo dengan batas maksimal 50 perubahan.
3. Menampilkan riwayat 5 panggilan terakhir, antrean kosong, dan konfirmasi reset.
4. Memisahkan logika struktur data dari DOM dan menerapkan Clean Code.
5. Menguji perilaku program dengan kasus normal dan kasus tepi.

## C. Alat dan teknologi

- Visual Studio Code dan ekstensi Live Server.
- JavaScript ES Modules, HTML5, CSS3.
- Node.js (unit testing bawaan dengan `node:test`).
- ESLint dan Prettier (konfigurasi tersedia; pemasangan dilakukan di perangkat peserta).

## D. Struktur proyek

```text
proyek-3-antrian/
├── index.html
├── css/style.css
├── js/structures.js
├── js/antrian.js
├── js/riwayat.js
├── js/app.js
├── tests/structures.test.js
├── tests/antrian.test.js
├── tests/riwayat.test.js
├── screenshots/tampilan-desktop.png
├── screenshots/tampilan-mobile.png
├── demo-standalone.html
├── package.json
├── eslint.config.js
├── .prettierrc
└── README.md
```

## E. Tangkapan layar

### 1. Tampilan desktop

![Tampilan desktop](screenshots/tampilan-desktop.png)

### 2. Tampilan mobile

![Tampilan mobile](screenshots/tampilan-mobile.png)

Tangkapan layar di atas menunjukkan contoh hasil aplikasi. Untuk laporan akhir, tambahkan tangkapan layar dari eksekusi di komputer Anda sendiri jika diminta oleh instruktur.

## F. Tabel pemilihan struktur data

| Kebutuhan | Struktur yang dipilih | Alasan | Alternatif yang tidak dipilih |
|---|---|---|---|
| Antrean pasien | `LinkedQueue` | Enqueue dan dequeue O(1); sesuai FIFO | Array `shift()` memiliki penggeseran elemen O(n) |
| Riwayat Undo/Redo | Dua `Stack` | LIFO; perubahan paling baru diproses lebih dulu | Queue memakai FIFO, tidak tepat |
| Riwayat 5 panggilan | Array berukuran kecil | Hanya 5 entri dan mudah ditampilkan | LinkedList berlebihan untuk lima data |

## G. Penjelasan alur fitur A (antrean)

1. `ambilNomor()` menghasilkan `A001` lalu `A002`, dst. Nomor dimasukkan ke LinkedQueue.
2. `panggilBerikutnya()` menghapus elemen terdepan menggunakan `dequeue()`.
3. Nomor tampil besar pada papan loket dan masuk riwayat panggilan.
4. Riwayat disimpan hanya sampai 5 nomor, ditampilkan dari yang terbaru.
5. Jika antrean kosong, aplikasi memberikan pesan yang jelas tanpa crash.
6. Reset memerlukan konfirmasi; jika setuju, antrean dan riwayat dibersihkan dan nomor kembali A001.

## H. Penjelasan alur fitur B (Undo/Redo)

1. Saat mengetik, teks sebelum perubahan disimpan ke Stack Undo.
2. Undo mengembalikan teks sebelumnya dan menyimpan teks yang dibatalkan ke Stack Redo.
3. Redo mengembalikan teks berikutnya dan memindahkan teks kini ke Stack Undo.
4. Mengetik setelah Undo menghapus seluruh Redo.
5. Riwayat dibatasi 50 perubahan untuk mengontrol memori.
6. Isi catatan disimpan opsional di `localStorage`, tetapi riwayat Undo/Redo tidak disimpan saat halaman dimuat ulang.

## I. Tabel hasil uji minimal

| No | Kasus uji | Ekspektasi | Hasil pengembang |
|---|---|---|---|
| 1 | Ambil 3 nomor | A001, A002, A003 | Lulus |
| 2 | Panggil 4 kali | FIFO 3 nomor, ke-4 pesan antrean kosong | Lulus |
| 3 | Ketik 3 perubahan | Undo = 3 | Lulus |
| 4 | Undo 3 kali | Kembali ke teks kosong | Lulus |
| 5 | Redo 2 kali | Teks kembali menjadi AB | Lulus |
| 6 | Ketik lagi setelah Undo | Redo terhapus | Lulus |
| 7 | Reset saat antrean berisi → Batal | Antrean tidak diubah | Lulus (UI) |
| 8 | Reset saat antrean berisi → OK | Antrean bersih, nomor kembali A001 | Lulus |
| 9 | Panggil 7 nomor | Riwayat berisi 5 nomor terbaru | Lulus |
| 10 | Buat 55 perubahan | Maksimal Undo 50 | Lulus |

**Ringkasan pengujian otomatis:** 29 lulus, 0 gagal, menggunakan `npm test`. Uji interaksi antarmuka dilakukan pada browser Chromium melalui pratinjau yang menggabungkan sumber asli. Isi kolom bukti pengujian dengan screenshot dari komputer peserta saat finalisasi tugas.

## J. Penerapan Clean Code

- Penamaan fungsi dan variabel bermakna (`ambilNomor`, `panggilBerikutnya`, `ketik`, `undo`, `redo`).
- Konstanta bernama (`MAKS_RIWAYAT = 50`, `AWALAN_NOMOR = 'A'`, dan lainnya).
- Struktur data menggunakan `private field` dan dipisahkan dari DOM (modularitas).
- JSDoc menjelaskan tujuan method penting; `getStatus()` mengembalikan salinan state.
- Pemisahan fungsi agar tidak terlalu panjang, serta penanganan kondisi kosong dan input tidak valid.
- Tersedia `eslint.config.js` dan `.prettierrc` untuk pemeriksaan akhir. Jalankan `npm install`, `npm run format`, dan `npm run lint` pada komputer peserta sebelum mengumpulkan.

## K. Kesimpulan

Proyek membuktikan bahwa LinkedQueue tepat untuk antrean pasien karena mengikuti FIFO, sedangkan dua Stack tepat untuk fitur Undo/Redo karena memakai LIFO. Riwayat lima panggilan dapat disimpan dengan array karena ukuran datanya kecil. Pemisahan logika dan tampilan membuat kode lebih mudah diuji dan dirawat. Pengujian fungsional berjalan sesuai kebutuhan utama.

**Batasan:** Proyek ini hanya simulasi. Tidak untuk data pasien nyata; penyimpanan `localStorage` tidak aman untuk rekam medis sensitif.
