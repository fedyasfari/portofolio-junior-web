import test from 'node:test';
import assert from 'node:assert/strict';
import { tambah, kurang, kali, bagi, hitung } from '../proyek-2-kalkulator/kalkulator/js/operasi.js';
import { validasiNama, validasiEmail, validasiSandi, validasiKonfirmasi } from '../proyek-2-kalkulator/validator/js/aturan.js';

test('operasi dasar kalkulator', () => {
  assert.equal(tambah(2, 3), 5);
  assert.equal(kurang(7, 2), 5);
  assert.equal(kali(3, 4), 12);
  assert.equal(bagi(10, 2), 5);
});
test('nol pembagi ditolak', () => assert.throws(() => bagi(5, 0), /Tidak bisa dibagi nol/));
test('ketelitian desimal', () => assert.equal(hitung(0.1, '+', 0.2), 0.3));
test('operator tidak dikenal ditolak', () => assert.throws(() => hitung(1, '%', 2), /Operator/));
test('nama minimal 3 karakter', () => {
  assert.notEqual(validasiNama('Al'), '');
  assert.equal(validasiNama('Andi'), '');
});
test('email harus punya format', () => {
  assert.notEqual(validasiEmail('abc'), '');
  assert.equal(validasiEmail('andi@example.com'), '');
});
test('sandi minimal 8 dengan huruf dan angka', () => {
  assert.notEqual(validasiSandi('abcdefghi'), '');
  assert.equal(validasiSandi('abcde123'), '');
});
test('konfirmasi harus sama', () => {
  assert.notEqual(validasiKonfirmasi('abcde123', 'abcde124'), '');
  assert.equal(validasiKonfirmasi('abcde123', 'abcde123'), '');
});
