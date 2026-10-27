import { cariLinear, cariBiner, bubbleSort, mergeSort, insertionSort } from './algoritma.js';

console.log('\n=== LAB 3: PENCARIAN ===');
const angka = [8, 3, 5, 1, 5];
console.log('Array awal       :', angka);
console.log('cariLinear(5)    :', cariLinear(angka, 5), '(indeks dimulai dari 0)');
const terurut = mergeSort(angka);
console.log('Array terurut    :', terurut);
console.log('cariBiner(5)     :', cariBiner(terurut, 5), '(indeks pertama)');
console.log('cariBiner(99)    :', cariBiner(terurut, 99));

console.log('\n=== LAB 3: PENGURUTAN ===');
const kasus = {
  kosong: [],
  satuElemen: [7],
  sudahTerurut: [1, 2, 3, 4],
  terbalik: [4, 3, 2, 1],
  duplikat: [4, 2, 4, 1, 2],
};
for (const [nama, isi] of Object.entries(kasus)) {
  const infoBubble = {};
  const infoInsertion = {};
  console.log(`\n${nama} | input:`, isi);
  console.log('bubbleSort   :', bubbleSort(isi, infoBubble), `(${infoBubble.perbandingan} perbandingan)`);
  console.log('insertionSort:', insertionSort(isi, infoInsertion), `(${infoInsertion.perbandingan} perbandingan)`);
  console.log('mergeSort    :', mergeSort(isi));
}
console.log('\nTips: jalankan npm test, npm run perbandingan, lalu npm run benchmark.\n');
