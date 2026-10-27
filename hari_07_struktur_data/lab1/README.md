# Lab 1 - Linked List (Hari 7)

## Cara paling mudah: VS Code + Live Server

1. Buka folder `hari-07-struktur-data` di VS Code.
2. Pasang ekstensi **Live Server** (oleh Ritwick Dey) jika belum ada.
3. Klik kanan `index.html`, pilih **Open with Live Server**.
4. Klik **Jalankan Pengujian**. Semua baris seharusnya ✅ LULUS.
5. Klik **Benchmark 100.000 Elemen**.
6. Tekan **F12** lalu buka **Console** untuk melihat hasil `console.time` dan `console.table`.
7. Salin waktu pengukuran dari komputer Anda ke tabel laporan.

## Alternatif: Node.js (tanpa HTML)

Di terminal VS Code, dari dalam folder proyek:

```bash
npm test
npm run benchmark
```

Tidak perlu menjalankan `npm install`, karena proyek tidak memakai library eksternal.

## Berkas

- `structures.js`: kelas `LinkedList`, `LinkedQueue`, `Stack`, dan `Queue`.
- `lab1.js`: pengujian dan benchmark memakai `QueueShift`.
- `index.html`: tampilan tombol dan hasil.
- `package.json`: pengaturan JavaScript module dan perintah npm.

## Hasil yang diharapkan

- Semua pengujian `LinkedList`, termasuk kosong, satu elemen, `remove()` kepala/tengah/ekor/tidak ada, dan duplikat, lulus.
- `QueueShift` dan `LinkedQueue` mengeluarkan angka yang sama dengan jumlah 4.999.950.000.
- Waktu benchmark tidak tetap, karena tergantung spesifikasi komputer, browser, dan beban sistem.
