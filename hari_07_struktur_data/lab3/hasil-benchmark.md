# Hasil Benchmark Lab 3

Lingkungan: Node.js v22.16.0; data angka acak dengan seed 20261027.

| Jumlah data | bubbleSort (ms) | mergeSort (ms) | Array.sort (ms) |
|---:|---:|---:|---:|
| 10.000 | 76,465 | 5,695 | 2,985 |
| 100.000 | > 15000 ms (batas waktu) | 28,007 | 35,891 |

Jika muncul "> 15000 ms (batas waktu)", itu artinya **belum selesai**, BUKAN hasil waktu yang tepat.
Untuk mengukur penuh tanpa cutoff: `node benchmark.js --tanpa-batas` (mungkin sangat lama).

Bubble Sort rata-rata O(n²), Merge Sort O(n log n), sedangkan Array.sort menggunakan optimasi bawaan JS.
