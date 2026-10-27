import test from 'node:test';
import assert from 'node:assert/strict';
import { hitungRataRata, tentukanGrade, hitungHargaDenganPajak } from '../kode-bersih.js';

test('rata-rata sesuai data Lab 4', () => {
  assert.equal(hitungRataRata([80, 65, 90]), 235 / 3);
  assert.equal(tentukanGrade(hitungRataRata([80, 65, 90])), 'B');
});

test('array kosong', () => assert.equal(hitungRataRata([]), 0));
test('grade ambang A/B/C/D', () => {
  assert.equal(tentukanGrade(85), 'A');
  assert.equal(tentukanGrade(70), 'B');
  assert.equal(tentukanGrade(55), 'C');
  assert.equal(tentukanGrade(54), 'D');
});
test('pajak 11 persen', () => assert.equal(hitungHargaDenganPajak(100000), 111000));
test('input angka tidak valid', () => assert.throws(() => hitungRataRata(['80']), TypeError));
