import { SistemAntrean } from './antrian.js';
import { EditorRiwayat, MAKS_RIWAYAT, MAKS_KARAKTER } from './riwayat.js';

const KUNCI_CATATAN = 'pbl-hari7-catatan-v1';
const elemen = (id) => document.getElementById(id);
const sistem = new SistemAntrean();

/** Membaca teks tersimpan; jika localStorage diblokir, lanjut tanpa penyimpanan. */
function muatCatatan() {
  try {
    const teks = localStorage.getItem(KUNCI_CATATAN) ?? '';
    return teks.length <= MAKS_KARAKTER ? teks : '';
  } catch {
    return '';
  }
}

const editor = new EditorRiwayat(muatCatatan());

function simpanCatatan() {
  try {
    localStorage.setItem(KUNCI_CATATAN, editor.getStatus().teks);
    elemen('info-simpan').textContent = 'Catatan tersimpan otomatis di browser ini.';
  } catch {
    elemen('info-simpan').textContent = 'Penyimpanan browser tidak tersedia; catatan masih ada selama tab terbuka.';
  }
}

function beriPesan(id, pesan, tipe = 'info') {
  const target = elemen(id);
  target.textContent = pesan;
  target.dataset.tipe = tipe;
}

function isiDaftar(id, item, teksKosong) {
  const wadah = elemen(id);
  wadah.replaceChildren();
  if (item.length === 0) {
    const kosong = document.createElement('li');
    kosong.className = 'item-kosong';
    kosong.textContent = teksKosong;
    wadah.append(kosong);
    return;
  }
  item.forEach((nomor, indeks) => {
    const baris = document.createElement('li');
    baris.className = 'nomor-item';
    baris.textContent = nomor;
    baris.setAttribute('aria-label', `Urutan ${indeks + 1}: ${nomor}`);
    wadah.append(baris);
  });
}

function renderAntrean() {
  const status = sistem.getStatus();
  elemen('nomor-dipanggil').textContent = status.sedangDipanggil ?? '—';
  elemen('jumlah-menunggu').textContent = String(status.jumlahMenunggu);
  isiDaftar('daftar-menunggu', status.daftarMenunggu, 'Belum ada pasien menunggu.');
  isiDaftar('riwayat-panggilan', status.riwayatPanggilan, 'Belum ada nomor dipanggil.');
}

function renderEditor() {
  const status = editor.getStatus();
  if (elemen('catatan').value !== status.teks) elemen('catatan').value = status.teks;
  elemen('tombol-undo').disabled = !status.bisaUndo;
  elemen('tombol-redo').disabled = !status.bisaRedo;
  elemen('jumlah-undo').textContent = String(status.jumlahUndo);
  elemen('jumlah-redo').textContent = String(status.jumlahRedo);
  elemen('jumlah-karakter').textContent = String(status.teks.length);
  elemen('maks-riwayat').textContent = String(MAKS_RIWAYAT);
  elemen('maks-karakter').textContent = String(MAKS_KARAKTER);
}

function ambilNomor() {
  const nomor = sistem.ambilNomor();
  renderAntrean();
  beriPesan('pesan-antrean', `${nomor} berhasil diambil dan masuk antrean.`, 'sukses');
}

function panggilNomor() {
  const hasil = sistem.panggilBerikutnya();
  renderAntrean();
  beriPesan('pesan-antrean', hasil.pesan, hasil.berhasil ? 'sukses' : 'peringatan');
}

function resetAntrean() {
  const disetujui = window.confirm('Reset semua nomor, panggilan, dan riwayat antrean?');
  if (!disetujui) return;
  sistem.reset();
  renderAntrean();
  beriPesan('pesan-antrean', 'Antrean berhasil direset. Nomor berikutnya kembali A001.', 'sukses');
}

function ketikCatatan() {
  try {
    editor.ketik(elemen('catatan').value);
    renderEditor();
    simpanCatatan();
    beriPesan('pesan-editor', 'Catatan diperbarui.', 'sukses');
  } catch (error) {
    renderEditor();
    beriPesan('pesan-editor', error.message, 'peringatan');
  }
}

function ubahRiwayat(jenis) {
  const berhasil = jenis === 'undo' ? editor.undo() : editor.redo();
  renderEditor();
  if (berhasil) simpanCatatan();
  beriPesan('pesan-editor', berhasil ? `${jenis.toUpperCase()} berhasil.` : `Tidak ada langkah ${jenis}.`, berhasil ? 'sukses' : 'peringatan');
  elemen('catatan').focus();
}

function mulai() {
  elemen('tombol-ambil').addEventListener('click', ambilNomor);
  elemen('tombol-panggil').addEventListener('click', panggilNomor);
  elemen('tombol-reset').addEventListener('click', resetAntrean);
  elemen('catatan').addEventListener('input', ketikCatatan);
  elemen('tombol-undo').addEventListener('click', () => ubahRiwayat('undo'));
  elemen('tombol-redo').addEventListener('click', () => ubahRiwayat('redo'));
  renderAntrean();
  renderEditor();
}

mulai();
