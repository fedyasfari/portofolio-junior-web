import { LinkedQueue } from './structures.js';

export const AWALAN_NOMOR = 'A';
export const NOMOR_AWAL = 1;
export const DIGIT_NOMOR = 3;
export const MAKS_RIWAYAT_PANGGILAN = 5;

/** Logika antrean klinik, terpisah dari DOM/UI. */
export class SistemAntrean {
  #antrean = new LinkedQueue();
  #nomorBerikutnya = NOMOR_AWAL;
  #sedangDipanggil = null;
  #riwayat = [];

  /** Mengambil tiket baru dan menaruhnya pada akhir antrean. */
  ambilNomor() {
    const angka = String(this.#nomorBerikutnya).padStart(DIGIT_NOMOR, '0');
    const nomor = `${AWALAN_NOMOR}${angka}`;
    this.#antrean.enqueue(nomor);
    this.#nomorBerikutnya++;
    return nomor;
  }

  /** Memanggil nomor antrean terdepan (FIFO). */
  panggilBerikutnya() {
    const nomor = this.#antrean.dequeue();
    if (nomor === undefined) {
      return { berhasil: false, pesan: 'Antrean kosong. Ambil nomor terlebih dahulu.' };
    }
    this.#sedangDipanggil = nomor;
    this.#riwayat.unshift(nomor);
    if (this.#riwayat.length > MAKS_RIWAYAT_PANGGILAN) this.#riwayat.pop();
    return { berhasil: true, nomor, pesan: `Nomor ${nomor}, silakan ke loket.` };
  }

  /** Mengembalikan salinan data agar state internal tetap aman. */
  getStatus() {
    return {
      sedangDipanggil: this.#sedangDipanggil,
      jumlahMenunggu: this.#antrean.size,
      daftarMenunggu: this.#antrean.toArray(),
      riwayatPanggilan: [...this.#riwayat],
    };
  }

  /** Reset menghapus antrean, riwayat, panggilan aktif, dan nomor berikutnya. */
  reset() {
    this.#antrean.clear();
    this.#riwayat = [];
    this.#sedangDipanggil = null;
    this.#nomorBerikutnya = NOMOR_AWAL;
  }
}
