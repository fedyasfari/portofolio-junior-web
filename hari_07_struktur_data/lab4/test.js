// Jalankan: npm test
import test from 'node:test';
import assert from 'node:assert/strict';
import {
  PAJAK,
  BATAS_GRADE,
  NILAI_PUJIAN,
  hitungRataRata,
  tentukanGrade,
  hitungHargaDenganPajak,
} from './kode-bersih.js';

test('rata-rata data soal: [80, 65, 90] = 78.333...', () => {
  assert.ok(Math.abs(hitungRataRata([80, 65, 90]) - 235 / 3) < 1e-10);
});

test('rata-rata array kosong menghasilkan 0', () => {
  assert.equal(hitungRataRata([]), 0);
});

test('rata-rata satu elemen', () => {
  assert.equal(hitungRataRata([90]), 90);
});

test('rata-rata nilai sama', () => {
  assert.equal(hitungRataRata([80, 80, 80]), 80);
});

test('rata-rata tidak mengubah array asal', () => {
  const data = [60, 70, 80];
  hitungRataRata(data);
  assert.deepEqual(data, [60, 70, 80]);
});

test('input bukan array ditolak dengan pesan jelas', () => {
  assert.throws(() => hitungRataRata('80,65,90'), TypeError);
});

test('nilai bukan angka valid ditolak', () => {
  assert.throws(() => hitungRataRata([80, '65', 90]), TypeError);
  assert.throws(() => hitungRataRata([80, Number.NaN]), TypeError);
});

test('grade A untuk nilai minimal 85', () => {
  assert.equal(tentukanGrade(85), 'A');
  assert.equal(tentukanGrade(100), 'A');
});

test('grade B untuk 70 sampai di bawah 85', () => {
  assert.equal(tentukanGrade(70), 'B');
  assert.equal(tentukanGrade(84.99), 'B');
});

test('grade C untuk 55 sampai di bawah 70', () => {
  assert.equal(tentukanGrade(55), 'C');
  assert.equal(tentukanGrade(69.99), 'C');
});

test('grade D untuk nilai di bawah 55', () => {
  assert.equal(tentukanGrade(54.99), 'D');
  assert.equal(tentukanGrade(0), 'D');
});

test('grade hasil rata-rata soal adalah B', () => {
  assert.equal(tentukanGrade(hitungRataRata([80, 65, 90])), 'B');
});

test('grade menolak input bukan angka valid', () => {
  assert.throws(() => tentukanGrade('85'), TypeError);
  assert.throws(() => tentukanGrade(Infinity), TypeError);
});

test('pajak 11% dari 100.000 menghasilkan 111.000', () => {
  assert.equal(hitungHargaDenganPajak(100_000), 111_000);
});

test('pajak harga nol tetap nol', () => {
  assert.equal(hitungHargaDenganPajak(0), 0);
});

test('harga negatif dan input nonangka ditolak', () => {
  assert.throws(() => hitungHargaDenganPajak(-1), RangeError);
  assert.throws(() => hitungHargaDenganPajak('100000'), RangeError);
});

test('konstanta mempunyai nilai yang ditentukan', () => {
  assert.equal(PAJAK, 0.11);
  assert.deepEqual(BATAS_GRADE, { A: 85, B: 70, C: 55 });
  assert.equal(NILAI_PUJIAN, 80);
});

test('batas rata-rata 80 sesuai kondisi pesan awal', () => {
  assert.equal(hitungRataRata([80, 80]), NILAI_PUJIAN);
});
