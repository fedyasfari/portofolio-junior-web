import { Stack } from './structures.js';

// Tantangan: maksimal 50 snapshot dan debounce 600 milidetik.
const MAKS_RIWAYAT = 50;
const JEDA_KETIK = 600;
const KUNCI_CATATAN = 'pbl-hari6:catatan:v1';

const editor = document.getElementById('editor');
const tombolUndo = document.getElementById('undo');
const tombolRedo = document.getElementById('redo');
const info = document.getElementById('info');
const statusCatatan = document.getElementById('status-catatan');

const undoStack = new Stack(MAKS_RIWAYAT);
const redoStack = new Stack(MAKS_RIWAYAT);

function bacaCatatan() {
  try {
    return localStorage.getItem(KUNCI_CATATAN) ?? '';
  } catch {
    return '';
  }
}

function simpanCatatan() {
  try {
    localStorage.setItem(KUNCI_CATATAN, teksSekarang);
    statusCatatan.textContent = 'Catatan tersimpan otomatis di browser ini.';
  } catch {
    statusCatatan.textContent = 'Penyimpanan browser tidak tersedia; teks tetap ada selama halaman terbuka.';
  }
}

let teksSekarang = bacaCatatan();
let snapshotAwal = null;
let timerSnapshot = null;
editor.value = teksSekarang;

function adaPerubahanTertunda() {
  return snapshotAwal !== null && snapshotAwal !== teksSekarang;
}

function perbaruiTombol() {
  const jumlahUndo = undoStack.size() + (adaPerubahanTertunda() ? 1 : 0);
  tombolUndo.disabled = jumlahUndo === 0;
  tombolRedo.disabled = redoStack.isEmpty();
  info.textContent = `Riwayat: ${jumlahUndo} undo, ${redoStack.size()} redo (maksimal ${MAKS_RIWAYAT})`;
}

// Simpan keadaan SEBELUM rangkaian ketikan, hanya setelah jeda.
function simpanSnapshot() {
  if (timerSnapshot !== null) {
    clearTimeout(timerSnapshot);
    timerSnapshot = null;
  }
  if (adaPerubahanTertunda()) {
    undoStack.push(snapshotAwal);
  }
  snapshotAwal = null;
  perbaruiTombol();
}

editor.addEventListener('input', () => {
  if (snapshotAwal === null) snapshotAwal = teksSekarang;
  teksSekarang = editor.value;

  // Begitu ada edit baru, jalur Redo yang lama tidak berlaku.
  redoStack.clear();
  simpanCatatan();

  if (timerSnapshot !== null) clearTimeout(timerSnapshot);
  timerSnapshot = setTimeout(simpanSnapshot, JEDA_KETIK);
  perbaruiTombol();
});

function undo() {
  // Pastikan ketikan yang belum melewati debounce tetap bisa di-Undo.
  simpanSnapshot();
  if (undoStack.isEmpty()) return;

  redoStack.push(teksSekarang);
  teksSekarang = undoStack.pop();
  editor.value = teksSekarang;
  simpanCatatan();
  perbaruiTombol();
  editor.focus();
}

function redo() {
  simpanSnapshot();
  if (redoStack.isEmpty()) return;

  undoStack.push(teksSekarang);
  teksSekarang = redoStack.pop();
  editor.value = teksSekarang;
  simpanCatatan();
  perbaruiTombol();
  editor.focus();
}

tombolUndo.addEventListener('click', undo);
tombolRedo.addEventListener('click', redo);

// Shortcut opsional agar editor terasa seperti aplikasi pengetikan.
editor.addEventListener('keydown', (event) => {
  if (!(event.ctrlKey || event.metaKey) || event.altKey) return;
  const key = event.key.toLowerCase();
  if (key === 'z' && !event.shiftKey) {
    event.preventDefault();
    undo();
  } else if (key === 'y' || (key === 'z' && event.shiftKey)) {
    event.preventDefault();
    redo();
  }
});

perbaruiTombol();
if (teksSekarang) statusCatatan.textContent = 'Catatan dari kunjungan sebelumnya telah dimuat.';
