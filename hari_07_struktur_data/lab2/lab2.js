import {
  strukturFolder,
  cetakPohon,
  hitungNode,
  cariNode,
  buatBSTContoh,
  grafKota,
  bfs,
  dfs,
  jarakTerpendek
} from './structures.js';

console.log('\n=== 1. TREE STRUKTUR FOLDER ===');
console.log(cetakPohon(strukturFolder));
console.log('Jumlah semua node:', hitungNode(strukturFolder));
console.log('Jalur app.js:', cariNode(strukturFolder, 'app.js'));
console.log('Jalur tidak ditemukan:', cariNode(strukturFolder, 'main.py'));

console.log('\n=== 2. BINARY SEARCH TREE ===');
const bst = buatBSTContoh();
console.log('inOrder():', bst.inOrder());
console.log('has(60):', bst.has(60));
console.log('has(65):', bst.has(65));
console.log(`
          50
        /    \\
      30      70
     /  \\    /  \\
    20  40  60  80`);

console.log('\n=== 3. GRAPH ENAM KOTA ===');
console.log('Adjacency list:', grafKota);
console.log('BFS dari Surakarta:', bfs(grafKota, 'Surakarta'));
console.log('DFS dari Surakarta:', dfs(grafKota, 'Surakarta'));
console.log('Jarak Surakarta -> Salatiga:', jarakTerpendek(grafKota, 'Surakarta', 'Salatiga'), 'sisi');
console.log('Jarak Surakarta -> Magelang:', jarakTerpendek(grafKota, 'Surakarta', 'Magelang'), 'sisi');
console.log('Jarak Surakarta -> Surakarta:', jarakTerpendek(grafKota, 'Surakarta', 'Surakarta'), 'sisi');
console.log('Jarak ke kota tidak ada:', jarakTerpendek(grafKota, 'Surakarta', 'Bogor'));
