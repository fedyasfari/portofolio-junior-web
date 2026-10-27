# Lab 2 — Tree dan Graph (Pemula)

Isi proyek:
- `structures.js`: struktur folder, `cetakPohon`, `hitungNode`, `cariNode`, `BinarySearchTree`, graf kota, `bfs`, `dfs`, dan `jarakTerpendek`.
- `lab2.js`: contoh penggunaan yang dicetak di terminal.
- `test-lab2.js`: pengujian otomatis (Node.js).
- `index.html`, `browser.js`, `style.css`: aplikasi demonstrasi interaktif untuk browser.
- `package.json`: menjalankan perintah `npm`.

## Cara A — Terminal VS Code (direkomendasikan)

1. Instal Node.js versi modern yang mendukung `node --test` dan `Object.hasOwn` (disarankan Node.js 20 atau lebih baru).
2. Buka folder proyek di VS Code.
3. Terminal > New Terminal.
4. Jalankan:

   ```bash
   npm start
   npm test
   ```

Tidak perlu `npm install` karena proyek tidak menggunakan package dari luar.

## Cara B — Browser

1. Buka folder proyek dengan VS Code.
2. Pasang ekstensi Live Server.
3. Klik kanan `index.html` > Open with Live Server.
4. Coba input pencarian `app.js` dan jarak Surakarta–Salatiga.

**Catatan:** Jangan membuka `index.html` langsung lewat `file://` karena browser biasanya membatasi JavaScript module. Gunakan Live Server.

## Output yang diharapkan

- `hitungNode(strukturFolder)` menghasilkan **8**, termasuk node root `proyek`.
- `cariNode(strukturFolder, 'app.js')` -> `proyek/js/app.js`.
- `inOrder()` -> `[20, 30, 40, 50, 60, 70, 80]`.
- `has(60)` -> `true`; `has(65)` -> `false`.
- `bfs(grafKota, 'Surakarta')` -> `Surakarta → Yogyakarta → Semarang → Magelang → Klaten → Salatiga`.
- `dfs(grafKota, 'Surakarta')` -> `Surakarta → Yogyakarta → Magelang → Klaten → Salatiga → Semarang`.
- `jarakTerpendek(grafKota, 'Surakarta', 'Salatiga')` -> **2 sisi**.
- `jarakTerpendek(grafKota, 'Surakarta', 'Surakarta')` -> **0 sisi**.
- Jika kota tidak ada atau tidak terhubung, `jarakTerpendek` mengembalikan **-1**.

## Konsep

- Tree adalah data hierarkis (parent–children); fungsi rekursif memanggil dirinya untuk menelusuri anak.
- BST menyimpan nilai lebih kecil di kiri dan lebih besar di kanan.
- inOrder menggunakan urutan kiri–root–kanan, sehingga menghasilkan data terurut.
- Graf menyimpan hubungan antarkota sebagai adjacency list (nama kota → daftar tetangga).
- BFS menelusuri per lapisan menggunakan antrean.
- DFS menelusuri cabang menggunakan rekursi.
- Jarak BFS untuk graf tanpa bobot adalah jumlah sisi yang dilalui, **bukan** km.
- Graf ini hanya contoh koneksi logis, bukan klaim jaringan jalan kota yang sebenarnya.
