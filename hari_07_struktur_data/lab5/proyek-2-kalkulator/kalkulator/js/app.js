import { hitung } from './operasi.js';

const layarEl = document.querySelector('#layar');
const papanEl = document.querySelector('#papan');
const riwayatEl = document.querySelector('#riwayat');

let layar = '0';
let angkaPertama = null;
let operatorAktif = null;
let menungguAngka = false;
const riwayat = [];

function perbaruiLayar() {
  layarEl.textContent = layar;
}

function perbaruiRiwayat() {
  riwayatEl.replaceChildren();
  for (const item of riwayat) {
    const baris = document.createElement('li');
    baris.textContent = item;
    riwayatEl.append(baris);
  }
}

function reset() {
  layar = '0';
  angkaPertama = null;
  operatorAktif = null;
  menungguAngka = false;
  perbaruiLayar();
}

function masukkanAngka(angka) {
  if (menungguAngka || layar.startsWith('Tidak bisa') || layar === 'Error') {
    layar = '0';
    menungguAngka = false;
  }
  if (angka === '.') {
    if (!layar.includes('.')) layar += '.';
  } else {
    layar = layar === '0' ? angka : layar + angka;
  }
  perbaruiLayar();
}

function pilihOperator(operator) {
  if (operatorAktif !== null && menungguAngka) {
    operatorAktif = operator;
    return;
  }
  if (operatorAktif !== null) {
    hitungHasil();
  }
  angkaPertama = Number(layar);
  operatorAktif = operator;
  menungguAngka = true;
}

function hitungHasil() {
  if (operatorAktif === null || angkaPertama === null) return;
  const angkaKedua = Number(layar);
  const ekspresi = `${angkaPertama} ${operatorAktif} ${angkaKedua}`;
  try {
    const hasil = hitung(angkaPertama, operatorAktif, angkaKedua);
    layar = String(hasil);
    riwayat.unshift(`${ekspresi} = ${layar}`);
    if (riwayat.length > 5) riwayat.pop();
    perbaruiRiwayat();
  } catch (kesalahan) {
    layar = kesalahan.message;
  }
  angkaPertama = null;
  operatorAktif = null;
  menungguAngka = true;
  perbaruiLayar();
}

function hapusTerakhir() {
  if (menungguAngka || layar.startsWith('Tidak bisa')) return;
  layar = layar.length > 1 ? layar.slice(0, -1) : '0';
  if (layar === '-' || layar === '') layar = '0';
  perbaruiLayar();
}

function prosesTombol(tombol) {
  if (tombol.dataset.angka !== undefined) {
    masukkanAngka(tombol.dataset.angka);
  } else if (tombol.dataset.operator !== undefined) {
    pilihOperator(tombol.dataset.operator);
  } else if (tombol.dataset.aksi === 'sama') {
    hitungHasil();
  } else if (tombol.dataset.aksi === 'hapus') {
    hapusTerakhir();
  } else if (tombol.dataset.aksi === 'reset') {
    reset();
  }
}

papanEl.addEventListener('click', (event) => {
  const tombol = event.target.closest('button');
  if (tombol) prosesTombol(tombol);
});

window.addEventListener('keydown', (event) => {
  const tombol = [...papanEl.querySelectorAll('button')].find((elemen) => {
    if (/^[0-9.]$/.test(event.key)) return elemen.dataset.angka === event.key;
    if (['+', '-', '*', '/'].includes(event.key)) {
      return elemen.dataset.operator === event.key;
    }
    if (event.key === 'Backspace') return elemen.dataset.aksi === 'hapus';
    if (event.key === 'Escape' || event.key.toLowerCase() === 'c') {
      return elemen.dataset.aksi === 'reset';
    }
    if (event.key === 'Enter' || event.key === '=') {
      return elemen.dataset.aksi === 'sama';
    }
    return false;
  });
  if (tombol) {
    event.preventDefault();
    tombol.click();
  }
});

perbaruiLayar();
