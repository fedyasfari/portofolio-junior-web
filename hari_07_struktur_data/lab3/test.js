import test from 'node:test';
import assert from 'node:assert/strict';
import { cariLinear, cariBiner, bubbleSort, insertionSort, mergeSort, buatDataAcak } from './algoritma.js';

const kasus = [
  { nama: 'kosong', asal: [], urut: [] },
  { nama: 'satu elemen', asal: [7], urut: [7] },
  { nama: 'sudah terurut', asal: [1, 2, 3, 4], urut: [1, 2, 3, 4] },
  { nama: 'terbalik', asal: [4, 3, 2, 1], urut: [1, 2, 3, 4] },
  { nama: 'duplikat', asal: [4, 2, 4, 1, 2], urut: [1, 2, 2, 4, 4] },
  { nama: 'negatif dan nol', asal: [0, -5, 9, -5], urut: [-5, -5, 0, 9] },
];

for (const { nama, asal, urut } of kasus) {
  test(`bubbleSort: ${nama}`, () => assert.deepEqual(bubbleSort(asal), urut));
  test(`insertionSort: ${nama}`, () => assert.deepEqual(insertionSort(asal), urut));
  test(`mergeSort: ${nama}`, () => assert.deepEqual(mergeSort(asal), urut));
}

test('cariLinear: array kosong menghasilkan -1', () => assert.equal(cariLinear([], 10), -1));
test('cariLinear: satu elemen ditemukan pada indeks 0', () => assert.equal(cariLinear([5], 5), 0));
test('cariLinear: terurut dan terbalik', () => {
  assert.equal(cariLinear([1, 2, 3], 2), 1);
  assert.equal(cariLinear([3, 2, 1], 2), 1);
});
test('cariLinear: duplikat mengembalikan indeks pertama', () => assert.equal(cariLinear([8, 5, 5], 5), 1));
test('cariLinear: data tidak ada', () => assert.equal(cariLinear([1, 2], 9), -1));

test('cariBiner: array kosong', () => assert.equal(cariBiner([], 5), -1));
test('cariBiner: satu elemen', () => assert.equal(cariBiner([5], 5), 0));
test('cariBiner: data sudah terurut', () => assert.equal(cariBiner([1, 3, 5, 7], 5), 2));
test('cariBiner: masukan terbalik harus diurutkan dahulu', () => {
  assert.equal(cariBiner(mergeSort([9, 7, 5, 3]), 7), 2);
});
test('cariBiner: duplikat -> indeks pertama', () => assert.equal(cariBiner([1, 2, 2, 2, 3], 2), 1));
test('cariBiner: data tidak ditemukan', () => assert.equal(cariBiner([1, 3, 5], 4), -1));

test('bubbleSort dan insertionSort mencatat 0 perbandingan pada array kosong/satu elemen', () => {
  for (const fungsi of [bubbleSort, insertionSort]) {
    for (const data of [[], [3]]) {
      const info = {};
      fungsi(data, info);
      assert.equal(info.perbandingan, 0);
    }
  }
});
test('data sudah terurut: n=1000 -> masing-masing 999 perbandingan', () => {
  const data = Array.from({ length: 1000 }, (_, i) => i);
  for (const fungsi of [bubbleSort, insertionSort]) {
    const info = {};
    fungsi(data, info);
    assert.equal(info.perbandingan, 999);
  }
});
test('data terbalik: n=1000 -> masing-masing 499500 perbandingan', () => {
  const data = Array.from({ length: 1000 }, (_, i) => 1000 - i);
  for (const fungsi of [bubbleSort, insertionSort]) {
    const info = {};
    fungsi(data, info);
    assert.equal(info.perbandingan, 499500);
  }
});
test('semua fungsi sorting tidak mengubah array input', () => {
  const data = [3, 1, 2];
  const sebelum = [...data];
  for (const fungsi of [bubbleSort, insertionSort, mergeSort]) fungsi(data);
  assert.deepEqual(data, sebelum);
});
test('data acak dari seed sama identik', () => {
  assert.deepEqual(buatDataAcak(50, 7), buatDataAcak(50, 7));
});
