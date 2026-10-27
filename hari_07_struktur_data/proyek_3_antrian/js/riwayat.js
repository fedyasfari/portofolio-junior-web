import { Stack } from './structures.js';

export const MAKS_RIWAYAT = 50;
export const MAKS_KARAKTER = 10_000;

function periksaTeks(teks) {
  if (typeof teks !== 'string') throw new TypeError('Catatan harus berupa teks.');
  if (teks.length > MAKS_KARAKTER) {
    throw new RangeError(`Catatan maksimal ${MAKS_KARAKTER} karakter.`);
  }
}

/** Editor riwayat berbasis dua Stack, independen dari DOM. */
export class EditorRiwayat {
  #undo = new Stack(MAKS_RIWAYAT);
  #redo = new Stack(MAKS_RIWAYAT);
  #teks = '';

  constructor(teksAwal = '') {
    periksaTeks(teksAwal);
    this.#teks = teksAwal;
  }

  /** Satu perubahan teks = satu langkah undo; ketik baru menghapus redo. */
  ketik(teksBaru) {
    periksaTeks(teksBaru);
    if (teksBaru === this.#teks) return false;
    this.#undo.push(this.#teks);
    this.#teks = teksBaru;
    this.#redo.clear();
    return true;
  }

  undo() {
    if (this.#undo.isEmpty()) return false;
    this.#redo.push(this.#teks);
    this.#teks = this.#undo.pop();
    return true;
  }

  redo() {
    if (this.#redo.isEmpty()) return false;
    this.#undo.push(this.#teks);
    this.#teks = this.#redo.pop();
    return true;
  }

  getStatus() {
    return {
      teks: this.#teks,
      jumlahUndo: this.#undo.size,
      jumlahRedo: this.#redo.size,
      bisaUndo: !this.#undo.isEmpty(),
      bisaRedo: !this.#redo.isEmpty(),
    };
  }
}
