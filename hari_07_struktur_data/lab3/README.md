# Lab 3 — Pencarian dan Pengurutan (Hari 7)

## Untuk pemula: cara membuka

1. Ekstrak ZIP, lalu buka folder `hari-07-lab3-pencarian-pengurutan` dengan VS Code.
2. Di VS Code, buka Terminal → New Terminal. Jalankan `node -v` untuk memastikan Node.js sudah ada.
3. Jalankan contoh cepat: `npm start`.
4. Jalankan seluruh tes: `npm test`.
5. Bandingkan jumlah perbandingan 1.000 angka: `npm run perbandingan`.
6. Ukur algoritma 10.000 dan 100.000 angka: `npm run benchmark`.
   **Perhatian:** Bubble Sort pada 100.000 data acak bisa melampaui beberapa menit. Untuk keamanan, benchmark standar membatasi pekerjaan pada 15 detik per algoritma di worker thread; jika belum selesai, tabel menampilkan **"> 15000 ms (batas waktu)"**, bukan durasi palsu. Untuk mencoba tanpa cutoff gunakan `npm run benchmark:penuh` (sangat lama pada komputer tertentu). Untuk latihan cepat, pakai `npm run benchmark:cepat` (hanya 10.000).
7. Untuk tampilan browser, klik kanan `index.html` lalu pilih **Open with Live Server** di VS Code. Bisa juga gunakan server lokal lain. Hindari double-click berkas HTML karena `import` modul JS sering diblokir untuk URL `file://`.

Tidak perlu `npm install`: proyek tidak memakai dependensi eksternal.

## Struktur proyek

- `algoritma.js`: kode `cariLinear`, `cariBiner`, `bubbleSort`, `insertionSort`, `mergeSort`, dan pembuat data acak.
- `contoh.js`: menjalankan contoh kasus.
- `test.js`: memeriksa kasus kosong, satu elemen, urut, terbalik, duplikat, serta hasil pencarian.
- `perbandingan.js`: hitung jumlah perbandingan nilai Bubble Sort vs Insertion Sort pada 1.000 elemen.
- `benchmark.js` dan `benchmark-worker.js`: ukur waktu Bubble Sort, Merge Sort, dan `Array.sort` untuk 10.000 dan 100.000 elemen dengan worker thread dan pembatas waktu aman. Menyimpan hasil ke CSV dan Markdown.
- `index.html`, `browser.js`, `style.css`: tampilan pengujian di browser.
- `LAPORAN.md`: kerangka laporan dan penjelasan Big-O.

## 1. Pencarian

`cariLinear(data, target)` memeriksa semua elemen dari kiri ke kanan. Bisa digunakan pada data belum terurut. Mengembalikan indeks pertama atau `-1`. Contoh:

```js
cariLinear([8, 3, 5, 1], 5); // 2
```

`cariBiner(dataTerurut, target)` membagi ruang pencarian menjadi dua berulang kali. **Syarat: array harus terurut menaik.** Indeks yang dikembalikan mengacu ke array yang sudah terurut (bukan indeks pada array asal). Untuk duplikat, mengembalikan indeks pertama.

```js
cariBiner([1, 3, 5, 8], 5); // 2
cariBiner([1, 2, 2, 4], 2); // 1
cariBiner([], 5); // -1
```

Kompleksitas: pencarian linear `O(n)`, pencarian biner `O(log n)` karena jumlah calon posisi dipangkas kira-kira setengah tiap langkah. Mengurutkan lebih dahulu juga membutuhkan biaya tersendiri.

## 2. Pengurutan

- `bubbleSort`: membandingkan elemen bertetangga, menukar jika salah urutan. Berhenti lebih cepat jika tidak ada pertukaran; kondisi terurut `O(n)`, rata-rata/terbalik `O(n²)`.
- `insertionSort`: menyisipkan nilai ke posisi yang tepat dalam bagian kiri yang telah terurut. Terurut `O(n)`, rata-rata/terbalik `O(n²)`.
- `mergeSort`: memecah rentang menjadi dua secara rekursif, lalu menggabungkannya dalam urutan. `O(n log n)`.
- `Array.sort((a,b)=>a-b)`: pengurutan bawaan JS, menggunakan pembanding numerik sehingga `10` berada setelah `2`.

Seluruh fungsi kami mengembalikan *array baru*, jadi input awal tetap utuh.

Contoh:

```js
import { bubbleSort, insertionSort, mergeSort } from './algoritma.js';
const data = [8, 3, 5, 1];
const statistik = {};
console.log(bubbleSort(data, statistik)); // [1,3,5,8]
console.log(statistik.perbandingan); // jumlah perbandingan nilai
console.log(insertionSort(data)); // [1,3,5,8]
console.log(mergeSort(data)); // [1,3,5,8]
console.log(data); // [8,3,5,1] -> tetap
```

## 3. Jumlah perbandingan 1.000 elemen

Jalankan `npm run perbandingan`. Program membandingkan kondisi acak, terurut, dan terbalik dengan dataset yang sama untuk dua algoritma. File `hasil-perbandingan-1000.csv` dihasilkan otomatis.

Definisi **perbandingan**: hanya operasi membandingkan nilai antar-elemen. `j >= 0` dan `i < batas` tidak dihitung. Bubble Sort menambahkan banyaknya perbandingan pada setiap putaran (sama dengan menghitungnya satu per satu); Insertion Sort menambah hitungan ketika membandingkan nilai yang disisipkan dengan elemen sebelumnya.

Untuk data urut ukuran 1.000: keduanya 999 kali. Untuk data terbalik ukuran 1.000: keduanya 499.500 kali. Untuk data acak, hasil tergantung seed dan pengaturan data.

## 4. Benchmark waktu 10.000 dan 100.000 elemen

`npm run benchmark` mengukur waktu dalam **milidetik** dengan `performance.now()` dan batas pengujian 15 detik untuk setiap algoritma. Jika terlampaui, program mencatat kondisi tidak selesai, bukan waktu tepat. Perintah `npm run benchmark:penuh` menghapus cutoff sehingga perhitungan benar-benar bisa tuntas di perangkat yang sanggup. Setiap algoritma menerima data acak yang identik; input tidak diubah oleh masing-masing fungsi. Hasil dicek terhadap keluaran terurut yang benar dan ditulis ke `hasil-benchmark.csv` dan `hasil-benchmark.md`.

Pengukuran sengaja **tidak** memasukkan biaya membuat data acak atau memeriksa kebenaran hasil. Pengukuran **memasukkan** biaya membuat salinan array agar perlakuan sebanding. Waktu satu kali uji dapat bervariasi karena perangkat, Node.js, optimisasi JIT, proses lain, dan pengelolaan memori. Ulangi beberapa kali jika membuat laporan eksperimental yang lebih ketat.

`O(n²)` Bubble Sort jauh lebih mahal pada input besar dibanding `O(n log n)` Merge Sort. `Array.sort` biasanya lebih cepat karena implementasi internal JavaScript dioptimalkan, walau durasi tepatnya tidak universal.

## Soal tambahan pemahaman

1. Mengapa mencari 8 dengan `cariBiner([8, 1, 3], 8)` tidak valid?
2. Mengapa kedua algoritma `bubbleSort` dan `insertionSort` hanya melakukan 999 perbandingan pada data yang sudah urut?
3. Mengapa hasil sorting harus dibandingkan dengan `Array.sort((a,b)=>a-b)` dan bukan `Array.sort()` tanpa argumen?
4. Apakah indeks hasil `cariBiner` selalu sama dengan indeks data asli sebelum diurutkan?
