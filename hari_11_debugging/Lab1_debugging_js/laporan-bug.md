# Laporan Bug — Lab 1 Debugging JavaScript

Nama: __________________________  |  Tanggal: __________________________

## Tabel temuan dan perbaikan

| ID | Jenis | Lokasi | Gejala | Penyebab | Perbaikan |
|---|---|---|---|---|---|
| B-01 | Syntax error | Baris `console.log` terakhir | `SyntaxError: missing ) after argument list` (teks dapat sedikit berbeda antar-runtime) | Kurang `)` penutup untuk `console.log` | Ganti menjadi `console.log('Total bayar: ' + formatRupiah(total - diskon));` |
| B-02 | Runtime error | Perulangan dalam `hitungTotal` | `TypeError: Cannot read properties of undefined (reading 'harga')` | `i <= daftar.length` membuat indeks terakhir melewati batas array | Ubah menjadi `i < daftar.length` |
| B-03 | Logic/data error | Objek `Penghapus` pada `keranjang` | Hasil total menjadi `NaN` dan tampil `RpNaN` | Properti `jumlah` tidak ada (`undefined`), sehingga `2000 * undefined` menjadi `NaN` | Tambahkan `jumlah: 1` pada data penghapus |
| B-04 | Logic error | Fungsi `hitungDiskon` | Tepat Rp50.000 tidak mendapatkan diskon | Kondisi `total > 50000` tidak mencakup nilai sama dengan Rp50.000 | Ubah menjadi `total >= 50000` |

## Pemeriksaan per langkah

1. Sebelum perbaikan apa pun: kode gagal diparse karena B-01.
2. Setelah B-01: B-02 muncul saat menghitung elemen array di luar batas.
3. Setelah B-02: B-03 tampak sebagai `NaN` (bukan exception).
4. Setelah B-03: total transaksi contoh menjadi Rp82.000 dan total bayar Rp73.800; tetapi B-04 masih harus diuji pada nilai batas Rp50.000.
5. Setelah B-04: `hitungDiskon(50000)` memberikan 5000 dan semua pengujian `console.assert` lulus.

## Perhitungan manual

- Buku: 25.000 × 2 = Rp50.000
- Pensil: 3.000 × 10 = Rp30.000
- Penghapus: 2.000 × 1 = Rp2.000
- Total sebelum diskon: Rp82.000
- Diskon 10%: Rp8.200
- **Total bayar: Rp73.800**

## Kesimpulan

Kegiatan ini memperlihatkan perbedaan *syntax error* (penulisan kode), *runtime error* (program berhenti saat berjalan), dan *logic/data error* (program berjalan tetapi hasil tidak sesuai). Pengujian nilai batas Rp50.000 penting karena transaksi Rp82.000 saja tidak dapat memperlihatkan bug B-04.
