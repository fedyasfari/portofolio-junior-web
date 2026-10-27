import test from 'node:test';
import assert from 'node:assert/strict';
import { SistemAntrean, MAKS_RIWAYAT_PANGGILAN } from '../js/antrian.js';

test('nomor berturut A001, A002, A003', () => {
  const loket = new SistemAntrean();
  assert.deepEqual([loket.ambilNomor(), loket.ambilNomor(), loket.ambilNomor()], ['A001', 'A002', 'A003']);
  assert.equal(loket.getStatus().jumlahMenunggu, 3);
});

test('FIFO: tiga nomor dipanggil dengan urutan yang sama', () => {
  const loket = new SistemAntrean();
  for (let i = 0; i < 3; i++) loket.ambilNomor();
  assert.deepEqual([loket.panggilBerikutnya().nomor, loket.panggilBerikutnya().nomor, loket.panggilBerikutnya().nomor], ['A001', 'A002', 'A003']);
  assert.equal(loket.getStatus().jumlahMenunggu, 0);
});

test('kasus uji minimal: ambil 3 lalu panggil 4, yang ke-4 kosong', () => {
  const loket = new SistemAntrean();
  for (let i = 0; i < 3; i++) loket.ambilNomor();
  for (let i = 0; i < 3; i++) assert.equal(loket.panggilBerikutnya().berhasil, true);
  const keempat = loket.panggilBerikutnya();
  assert.equal(keempat.berhasil, false);
  assert.match(keempat.pesan, /Antrean kosong/);
  assert.equal(loket.getStatus().sedangDipanggil, 'A003');
});

test('riwayat panggilan dibatasi 5 nomor dan yang baru ditampilkan dulu', () => {
  const loket = new SistemAntrean();
  for (let i = 0; i < 7; i++) loket.ambilNomor();
  for (let i = 0; i < 7; i++) loket.panggilBerikutnya();
  assert.equal(MAKS_RIWAYAT_PANGGILAN, 5);
  assert.deepEqual(loket.getStatus().riwayatPanggilan, ['A007', 'A006', 'A005', 'A004', 'A003']);
});

test('reset saat antrean berisi pasien mengosongkan semua state', () => {
  const loket = new SistemAntrean();
  loket.ambilNomor(); loket.ambilNomor(); loket.panggilBerikutnya(); loket.ambilNomor();
  loket.reset();
  assert.deepEqual(loket.getStatus(), {
    sedangDipanggil: null, jumlahMenunggu: 0, daftarMenunggu: [], riwayatPanggilan: [],
  });
  assert.equal(loket.ambilNomor(), 'A001');
});

test('nomor A1000 tetap benar setelah nomor melewati 999', () => {
  const loket = new SistemAntrean();
  let nomor;
  for (let i = 0; i < 1000; i++) nomor = loket.ambilNomor();
  assert.equal(nomor, 'A1000');
});

test('snapshot getStatus tidak dapat mengubah data antrean asli', () => {
  const loket = new SistemAntrean();
  loket.ambilNomor(); loket.ambilNomor();
  const snapshot = loket.getStatus();
  snapshot.daftarMenunggu.push('PALSU');
  snapshot.riwayatPanggilan.push('PALSU');
  assert.deepEqual(loket.getStatus().daftarMenunggu, ['A001', 'A002']);
  assert.deepEqual(loket.getStatus().riwayatPanggilan, []);
});
