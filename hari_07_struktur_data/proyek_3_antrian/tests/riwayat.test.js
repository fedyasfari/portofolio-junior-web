import test from 'node:test';
import assert from 'node:assert/strict';
import { EditorRiwayat, MAKS_RIWAYAT, MAKS_KARAKTER } from '../js/riwayat.js';

test('editor awal kosong, tombol undo dan redo seharusnya nonaktif', () => {
  const editor = new EditorRiwayat();
  const status = editor.getStatus();
  assert.equal(status.teks, '');
  assert.equal(status.bisaUndo, false);
  assert.equal(status.bisaRedo, false);
});

test('ketik tiga kali lalu undo tiga kali kembali ke kosong', () => {
  const editor = new EditorRiwayat();
  editor.ketik('A'); editor.ketik('AB'); editor.ketik('ABC');
  assert.equal(editor.getStatus().jumlahUndo, 3);
  assert.equal(editor.undo(), true);
  assert.equal(editor.getStatus().teks, 'AB');
  assert.equal(editor.undo(), true);
  assert.equal(editor.getStatus().teks, 'A');
  assert.equal(editor.undo(), true);
  assert.equal(editor.getStatus().teks, '');
  assert.equal(editor.undo(), false);
});

test('redo dua kali setelah undo tiga kali', () => {
  const editor = new EditorRiwayat();
  editor.ketik('A'); editor.ketik('AB'); editor.ketik('ABC');
  editor.undo(); editor.undo(); editor.undo();
  editor.redo(); editor.redo();
  assert.equal(editor.getStatus().teks, 'AB');
  assert.equal(editor.getStatus().jumlahRedo, 1);
});

test('ketik setelah undo harus menghapus redo', () => {
  const editor = new EditorRiwayat();
  editor.ketik('A'); editor.ketik('AB'); editor.undo();
  assert.equal(editor.getStatus().bisaRedo, true);
  editor.ketik('AX');
  assert.equal(editor.getStatus().bisaRedo, false);
  assert.equal(editor.redo(), false);
  assert.equal(editor.getStatus().teks, 'AX');
});

test('mengetik teks identik tidak menambah riwayat', () => {
  const editor = new EditorRiwayat();
  assert.equal(editor.ketik(''), false);
  editor.ketik('catatan');
  assert.equal(editor.ketik('catatan'), false);
  assert.equal(editor.getStatus().jumlahUndo, 1);
});

test('maksimum riwayat adalah 50 langkah', () => {
  const editor = new EditorRiwayat();
  for (let i = 1; i <= 55; i++) editor.ketik(`Catatan ${i}`);
  assert.equal(editor.getStatus().jumlahUndo, MAKS_RIWAYAT);
  for (let i = 0; i < MAKS_RIWAYAT; i++) assert.equal(editor.undo(), true);
  assert.equal(editor.getStatus().teks, 'Catatan 5');
  assert.equal(editor.undo(), false);
  assert.equal(editor.getStatus().jumlahRedo, MAKS_RIWAYAT);
});

test('editor dapat dimulai dari teks localStorage tanpa langkah undo', () => {
  const editor = new EditorRiwayat('catatan tersimpan');
  assert.equal(editor.getStatus().teks, 'catatan tersimpan');
  assert.equal(editor.getStatus().jumlahUndo, 0);
});

test('input non-string ditolak, state lama tetap utuh', () => {
  const editor = new EditorRiwayat('sebelumnya');
  assert.throws(() => editor.ketik(100), TypeError);
  assert.throws(() => new EditorRiwayat(null), TypeError);
  assert.equal(editor.getStatus().teks, 'sebelumnya');
});

test('input catatan terlalu panjang ditolak', () => {
  const editor = new EditorRiwayat();
  assert.throws(() => editor.ketik('x'.repeat(MAKS_KARAKTER + 1)), RangeError);
  assert.equal(editor.getStatus().teks, '');
});

test('teks saat ini dapat dihapus dan di-undo', () => {
  const editor = new EditorRiwayat('mulai');
  editor.ketik('');
  assert.equal(editor.getStatus().teks, '');
  editor.undo();
  assert.equal(editor.getStatus().teks, 'mulai');
});
