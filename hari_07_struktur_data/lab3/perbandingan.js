import { writeFileSync } from 'node:fs';
import { bubbleSort, insertionSort, buatDataAcak } from './algoritma.js';

const n = 1000;
const acak = buatDataAcak(n, 20261027);
const urut = Array.from({ length: n }, (_, i) => i + 1);
const terbalik = [...urut].reverse();
const kasus = [
  ['Acak', acak],
  ['Terurut', urut],
  ['Terbalik', terbalik],
];
const hasil = kasus.map(([kondisi, data]) => {
  const b = {}, i = {};
  bubbleSort(data, b);
  insertionSort(data, i);
  return { Kondisi: kondisi, Elemen: n, BubbleSort: b.perbandingan, InsertionSort: i.perbandingan };
});
console.log('\nPERBANDINGAN NILAI untuk 1.000 elemen (semakin sedikit semakin baik):');
console.table(hasil);
writeFileSync('hasil-perbandingan-1000.csv', 'Kondisi,Elemen,BubbleSort,InsertionSort\n' +
  hasil.map(r => `${r.Kondisi},${r.Elemen},${r.BubbleSort},${r.InsertionSort}`).join('\n') + '\n');
console.log('File dibuat: hasil-perbandingan-1000.csv');
console.log('Keterangan: perbandingan = hanya operasi perbandingan nilai antar-elemen.\n');
