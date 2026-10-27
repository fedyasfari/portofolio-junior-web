import test from 'node:test';
import assert from 'node:assert/strict';
import {
  strukturFolder, cetakPohon, hitungNode, cariNode,
  BinarySearchTree, buatBSTContoh, grafKota, bfs, dfs, jarakTerpendek
} from './structures.js';

test('cetakPohon menampilkan folder dan berkas', () => {
  const gambar = cetakPohon(strukturFolder);
  assert.match(gambar, /proyek\//);
  assert.match(gambar, /├── js\//);
  assert.match(gambar, /└── README\.md/);
});
test('hitungNode menghitung root dan semua anak', () => {
  assert.equal(hitungNode(strukturFolder), 8);
  assert.equal(hitungNode(null), 0);
  assert.equal(hitungNode({ nama: 'saja', anak: [] }), 1);
});
test('cariNode mendapatkan jalur lengkap', () => {
  assert.equal(cariNode(strukturFolder, 'app.js'), 'proyek/js/app.js');
  assert.equal(cariNode(strukturFolder, 'style.css'), 'proyek/css/style.css');
  assert.equal(cariNode(strukturFolder, 'proyek'), 'proyek');
  assert.equal(cariNode(strukturFolder, 'main.py'), null);
  assert.equal(cariNode(null, 'apa'), null);
});
test('BST urutan inOrder terurut dari kecil ke besar', () => {
  assert.deepEqual(buatBSTContoh().inOrder(), [20, 30, 40, 50, 60, 70, 80]);
});
test('BST has benar untuk 60 dan salah untuk 65', () => {
  const bst = buatBSTContoh();
  assert.equal(bst.has(60), true);
  assert.equal(bst.has(65), false);
});
test('BST kosong dan nilai duplikat', () => {
  const bst = new BinarySearchTree();
  assert.deepEqual(bst.inOrder(), []);
  assert.equal(bst.has(60), false);
  assert.equal(bst.insert(50), true);
  assert.equal(bst.insert(50), false);
  assert.deepEqual(bst.inOrder(), [50]);
});
test('Graf memiliki enam kota', () => {
  assert.equal(Object.keys(grafKota).length, 6);
});
test('BFS mengikuti tingkat ketetanggaan', () => {
  assert.deepEqual(bfs(grafKota, 'Surakarta'), [
    'Surakarta', 'Yogyakarta', 'Semarang', 'Magelang', 'Klaten', 'Salatiga'
  ]);
  assert.deepEqual(bfs(grafKota, 'Bogor'), []);
});
test('DFS menyusuri cabang', () => {
  assert.deepEqual(dfs(grafKota, 'Surakarta'), [
    'Surakarta', 'Yogyakarta', 'Magelang', 'Klaten', 'Salatiga', 'Semarang'
  ]);
  assert.deepEqual(dfs(grafKota, 'Bogor'), []);
});
test('jarakTerpendek menghitung jumlah sisi minimum', () => {
  assert.equal(jarakTerpendek(grafKota, 'Surakarta', 'Salatiga'), 2);
  assert.equal(jarakTerpendek(grafKota, 'Surakarta', 'Magelang'), 2);
  assert.equal(jarakTerpendek(grafKota, 'Yogyakarta', 'Salatiga'), 2);
  assert.equal(jarakTerpendek(grafKota, 'Surakarta', 'Surakarta'), 0);
});
test('jarakTerpendek menangani kota tidak ada dan graf terputus', () => {
  assert.equal(jarakTerpendek(grafKota, 'Bogor', 'Surakarta'), -1);
  assert.equal(jarakTerpendek(grafKota, 'Surakarta', 'Bogor'), -1);
  assert.equal(jarakTerpendek({ A: ['B'], B: ['A'], C: [] }, 'A', 'C'), -1);
});
