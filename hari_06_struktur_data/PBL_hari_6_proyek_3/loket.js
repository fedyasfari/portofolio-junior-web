import { Queue } from './structures.js';

const KUNCI_LOKET = 'pbl-hari6:loket:v1';
const antrian = new Queue();

const dipanggil = document.getElementById('dipanggil');
const jumlah = document.getElementById('jumlah');
const daftar = document.getElementById('daftar');
const riwayatElemen = document.getElementById('riwayat');
const labelTanggal = document.getElementById('tanggal-loket');
const pemberitahuan = document.getElementById('pemberitahuan');

let nomorTerakhir = 0;
let sedangDipanggil = '-';
let riwayat = []; // Lima nomor TERAKHIR, dari yang terbaru.
let tanggalAktif = tanggalLokal();

// Memakai tanggal lokal, bukan toISOString() (UTC).
function tanggalLokal() {
  const sekarang = new Date();
  const tahun = sekarang.getFullYear();
  const bulan = String(sekarang.getMonth() + 1).padStart(2, '0');
  const hari = String(sekarang.getDate()).padStart(2, '0');
  return `${tahun}-${bulan}-${hari}`;
}

function formatNomor(angka) {
  return 'A' + String(angka).padStart(3, '0');
}

function simpanData() {
  const data = {
    tanggal: tanggalAktif,
    nomorTerakhir,
    sedangDipanggil,
    menunggu: antrian.toArray(),
    riwayat
  };

  try {
    localStorage.setItem(KUNCI_LOKET, JSON.stringify(data));
  } catch {
    pemberitahuan.textContent = 'Penyimpanan tidak tersedia. Data antrean tidak bertahan setelah halaman ditutup.';
  }
}

function kosongkanLoket() {
  antrian.clear();
  nomorTerakhir = 0;
  sedangDipanggil = '-';
  riwayat = [];
}

function muatData(simpanSetelah = true) {
  kosongkanLoket();
  tanggalAktif = tanggalLokal();

  try {
    const tersimpan = JSON.parse(localStorage.getItem(KUNCI_LOKET) || 'null');
    if (tersimpan && tersimpan.tanggal === tanggalAktif) {
      nomorTerakhir = Number.isSafeInteger(tersimpan.nomorTerakhir) && tersimpan.nomorTerakhir >= 0
        ? tersimpan.nomorTerakhir : 0;
      sedangDipanggil = typeof tersimpan.sedangDipanggil === 'string'
        ? tersimpan.sedangDipanggil : '-';
      riwayat = Array.isArray(tersimpan.riwayat)
        ? tersimpan.riwayat.filter(x => typeof x === 'string').slice(0, 5) : [];
      if (Array.isArray(tersimpan.menunggu)) {
        for (const nomor of tersimpan.menunggu) {
          if (typeof nomor === 'string') antrian.enqueue(nomor);
        }
      }
    }
  } catch {
    // Abaikan data tersimpan yang rusak lalu mulai dengan antrean kosong.
  }
  if (simpanSetelah) simpanData();
  tampilkanData();
}

function tampilkanList(elemen, nomorNomor, pesanKosong) {
  elemen.textContent = '';
  if (nomorNomor.length === 0) {
    const li = document.createElement('li');
    li.textContent = pesanKosong;
    li.className = 'list-kosong';
    elemen.append(li);
    return;
  }
  for (const nomor of nomorNomor) {
    const li = document.createElement('li');
    li.textContent = nomor; // Aman: tidak membuat HTML dari input.
    elemen.append(li);
  }
}

function tampilkanData() {
  dipanggil.textContent = sedangDipanggil;
  jumlah.textContent = String(antrian.size());
  labelTanggal.textContent = new Intl.DateTimeFormat('id-ID', {
    weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
  }).format(new Date());

  // Tantangan enkapsulasi: tidak mengakses head/tail/items dari halaman.
  tampilkanList(daftar, antrian.toArray(), 'Belum ada nomor yang menunggu.');
  tampilkanList(riwayatElemen, riwayat, 'Belum ada nomor yang dipanggil.');
}

function pastikanHariIni() {
  if (tanggalAktif === tanggalLokal()) return;
  tanggalAktif = tanggalLokal();
  kosongkanLoket();
  simpanData();
  tampilkanData();
  pemberitahuan.textContent = 'Hari baru: nomor antrean otomatis dimulai lagi dari A001.';
}

document.getElementById('ambil').addEventListener('click', () => {
  pastikanHariIni();
  nomorTerakhir++;
  const nomor = formatNomor(nomorTerakhir);
  antrian.enqueue(nomor);
  pemberitahuan.textContent = `Nomor ${nomor} berhasil diambil.`;
  simpanData();
  tampilkanData();
});

document.getElementById('panggil').addEventListener('click', () => {
  pastikanHariIni();
  if (antrian.isEmpty()) {
    pemberitahuan.textContent = 'Antrean kosong. Belum ada nomor yang bisa dipanggil.';
    return;
  }

  sedangDipanggil = antrian.dequeue();
  riwayat.unshift(sedangDipanggil);
  riwayat = riwayat.slice(0, 5);
  pemberitahuan.textContent = `Memanggil nomor ${sedangDipanggil}.`;
  simpanData();
  tampilkanData();
});

document.getElementById('reset').addEventListener('click', () => {
  pastikanHariIni();
  if (!window.confirm('Reset semua antrean, riwayat, dan nomor mulai lagi dari A001?')) return;
  kosongkanLoket();
  pemberitahuan.textContent = 'Loket berhasil di-reset. Nomor berikutnya A001.';
  simpanData();
  tampilkanData();
});

// Periksa saat tab kembali aktif, dan berkala jika tab terus dibuka semalaman.
window.addEventListener('focus', pastikanHariIni);
document.addEventListener('visibilitychange', () => {
  if (!document.hidden) pastikanHariIni();
});
window.addEventListener('storage', (event) => {
  if (event.key === KUNCI_LOKET) muatData(false);
});
setInterval(pastikanHariIni, 60_000);

muatData();