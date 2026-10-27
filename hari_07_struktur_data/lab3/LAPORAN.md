# Laporan Praktikum Lab 3 — Pencarian dan Pengurutan

## A. Tujuan
Mengimplementasikan pencarian linear dan biner, Bubble Sort, Insertion Sort, dan Merge Sort; menguji kasus khusus; membandingkan jumlah perbandingan nilai dan waktu pemrosesan.

## B. Alat dan bahan
Laptop/PC, Visual Studio Code, Node.js, JavaScript ES Modules, serta browser dengan Live Server (opsional).

## C. Langkah kerja
1. Membuat `algoritma.js` berisi algoritma pencarian dan pengurutan.
2. Menjalankan `npm test` untuk kasus kosong, satu elemen, terurut, terbalik, dan duplikat.
3. Menjalankan `npm run perbandingan` untuk membandingkan penghitung perbandingan Bubble Sort dan Insertion Sort, n=1000.
4. Menjalankan `npm run benchmark` untuk membandingkan waktu Bubble Sort, Merge Sort, dan Array.sort pada 10.000 dan 100.000 angka acak yang sama. Jika Bubble Sort 100.000 belum selesai setelah batas waktu 15 detik, tulis "> 15.000 ms (dibatasi)", bukan mengarang angka durasi selesai; bila memungkinkan jalankan `npm run benchmark:penuh` untuk memperoleh waktu yang tuntas.
5. Menyalin hasil asli dari `hasil-perbandingan-1000.csv` dan `hasil-benchmark.md` ke laporan.

## D. Hasil pengujian pencarian dan pengurutan

| Kondisi | Input contoh | Output pengurutan | Catatan |
|---|---|---|---|
| Kosong | [] | [] | Tidak menghasilkan error |
| Satu elemen | [7] | [7] | Sudah terurut |
| Terurut | [1,2,3,4] | [1,2,3,4] | Tidak perlu pertukaran |
| Terbalik | [4,3,2,1] | [1,2,3,4] | Banyak pertukaran pada Bubble Sort |
| Duplikat | [4,2,4,1,2] | [1,2,2,4,4] | Nilai duplikat dipertahankan |

**Catatan:** cariBiner harus menerima data urut. Indeks yang dikembalikan didasarkan pada data urut.

## E. Jumlah perbandingan pada 1.000 elemen
Isi nilai data acak dari file CSV setelah menjalankan `npm run perbandingan`:

| Jenis input (1.000 angka) | Bubble Sort | Insertion Sort |
|---|---:|---:|
| Acak | (isi hasil) | (isi hasil) |
| Terurut | 999 | 999 |
| Terbalik | 499.500 | 499.500 |

Pada kasus terurut, Bubble Sort berhenti setelah satu putaran dan Insertion Sort hanya perlu satu perbandingan per elemen. Pada data acak, Insertion Sort sering menguji lebih sedikit pasangan nilai daripada Bubble Sort. Untuk data terbalik, masing-masing membandingkan n(n−1)/2 nilai, yaitu 499.500 saat n=1000.

## F. Tabel waktu pemrosesan (ms)
**Isi dengan hasil pengukuran pada komputer yang digunakan**, misalnya copy dari `hasil-benchmark.md`.

| Jumlah data | bubbleSort (ms) | mergeSort (ms) | Array.sort (ms) |
|---:|---:|---:|---:|
| 10.000 | (isi hasil) | (isi hasil) | (isi hasil) |
| 100.000 | (isi hasil) | (isi hasil) | (isi hasil) |

## G. Analisis Big-O
- `cariLinear`: O(n), memeriksa elemen satu per satu.
- `cariBiner`: O(log n), setiap iterasi memangkas kira-kira separuh ruang pencarian, tetapi membutuhkan data terurut.
- `bubbleSort`: O(n²) rata-rata/terburuk; O(n) untuk input yang sudah terurut karena memakai penghentian dini.
- `insertionSort`: O(n²) rata-rata/terburuk; O(n) saat sudah terurut.
- `mergeSort`: O(n log n) untuk kasus terbaik, rata-rata, terburuk; tambahan memori O(n).
- `Array.sort`: mesin JavaScript memiliki implementasi sort yang dioptimalkan; hasil konkret tergantung lingkungan. Untuk angka gunakan comparator `(a,b)=>a-b`.

## H. Kesimpulan
Pencarian linear berlaku untuk array acak maupun terurut, sedangkan pencarian biner hanya berlaku pada data terurut. Pada pengurutan, Bubble Sort dan Insertion Sort dapat bekerja efisien untuk input yang sudah terurut, namun melambat secara kuadratis saat input besar dan tidak terurut. Merge Sort lebih cocok untuk data besar karena waktu O(n log n). Hasil tabel waktu di atas harus berasal dari pengukuran aktual, bukan angka perkiraan.
