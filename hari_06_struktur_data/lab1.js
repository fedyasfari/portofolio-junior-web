
const peserta = [
  { id: 1, nama: 'Sari', kelas: 'Web', nilai: 90, aktif: true },
  { id: 2, nama: 'Budi', kelas: 'Web', nilai: 68, aktif: true },
  { id: 3, nama: 'Citra', kelas: 'Data', nilai: 82, aktif: false },
  { id: 4, nama: 'Deni', kelas: 'Web', nilai: 75, aktif: true },
  { id: 5, nama: 'Eka', kelas: 'Data', nilai: 95, aktif: true },
  { id: 6, nama: 'Farhan', kelas: 'UIUX', nilai: 73, aktif: false },
  { id: 7, nama: 'Gina', kelas: 'Web', nilai: 88, aktif: true },
  { id: 8, nama: 'Hadi', kelas: 'Data', nilai: 60, aktif: true },
  { id: 9, nama: 'Intan', kelas: 'UIUX', nilai: 84, aktif: true },
  { id: 10, nama: 'Joko', kelas: 'Web', nilai: 79, aktif: false }
];

// SOAL 1 - Filter peserta aktif
function ambilPesertaAktif(data) {
  return data.filter((orang) => orang.aktif === true);
}

// SOAL 2 - Urutkan nama tanpa mengubah array asli
function urutkanBerdasarkanNama(data) {
  return [...data].sort((a, b) =>
    a.nama.localeCompare(b.nama)
  );
}

// SOAL 3 - Cari peserta berdasarkan ID
function cariPesertaBerdasarkanId(data, id) {
  return data.find((orang) => orang.id === id);
}

// SOAL 4 - Menghitung peserta per kelas
function hitungPesertaPerKelas(data) {
  const jumlahPerKelas = {};

  data.forEach((orang) => {
    if (jumlahPerKelas[orang.kelas] === undefined) {
      jumlahPerKelas[orang.kelas] = 0;
    }

    jumlahPerKelas[orang.kelas] += 1;
  });

  return jumlahPerKelas;
}

// SOAL 5A - Menambah peserta
function tambahPeserta(data, pesertaBaru) {
  const sudahAda = cariPesertaBerdasarkanId(
    data, pesertaBaru.id
  );

  if (sudahAda !== undefined) {
    console.log('ID peserta sudah digunakan.');
    return false;
  }

  data.push(pesertaBaru);
  return true;
}

// SOAL 5B - Mengubah nilai peserta
function ubahNilaiPeserta(data, id, nilaiBaru) {
  const orang = cariPesertaBerdasarkanId(data, id);

  if (orang === undefined) {
    console.log('Peserta tidak ditemukan.');
    return false;
  }

  orang.nilai = nilaiBaru;
  return true;
}

// SOAL 5C - Menghapus peserta
function hapusPeserta(data, id) {
  const posisi = data.findIndex(
    (orang) => orang.id === id
  );

  if (posisi === -1) {
    console.log('Peserta tidak ditemukan.');
    return false;
  }

  data.splice(posisi, 1);
  return true;
}

// SOAL 6 - Membuat indeks berdasarkan ID
function buatIndeksPeserta(data) {
  return data.reduce((indeks, orang) => {
    indeks[orang.id] = orang;
    return indeks;
  }, {});
}

// ===================================
// PENGUJIAN PROGRAM
// ===================================

console.log('DATA AWAL');
console.table(peserta);

// UJI SOAL 1
console.log('SOAL 1 - PESERTA AKTIF');
const pesertaAktif = ambilPesertaAktif(peserta);
console.table(pesertaAktif);
console.log('Jumlah peserta aktif:', pesertaAktif.length);

// UJI SOAL 2
console.log('SOAL 2 - URUT BERDASARKAN NAMA');
const pesertaUrut = urutkanBerdasarkanNama(peserta);
console.table(pesertaUrut);
console.log('Array asli tetap dimulai dengan:', peserta[0].nama);

// UJI SOAL 3
console.log('SOAL 3 - PENCARIAN PESERTA');
const ditemukan = cariPesertaBerdasarkanId(peserta, 5);
console.log('ID 5:', ditemukan);

const tidakDitemukan = cariPesertaBerdasarkanId(peserta, 99);
console.log('ID 99:', tidakDitemukan ?? 'Peserta tidak ditemukan.');

// UJI SOAL 4
console.log('SOAL 4 - JUMLAH PER KELAS');
console.log(hitungPesertaPerKelas(peserta));

// UJI SOAL 5
console.log('SOAL 5 - TAMBAH, UBAH, HAPUS');

// Tambah
tambahPeserta(peserta, {
  id: 11,
  nama: 'Lala',
  kelas: 'Data',
  nilai: 91,
  aktif: true
});
console.log('Setelah tambah:', peserta.length);
console.table(peserta);

// Ubah
ubahNilaiPeserta(peserta, 2, 80);
console.log('Setelah ubah Budi:');
console.log(cariPesertaBerdasarkanId(peserta, 2));

// Hapus
hapusPeserta(peserta, 3);
console.log('Setelah hapus Citra:', peserta.length);
console.table(peserta);

// UJI SOAL 6
console.log('SOAL 6 - OBJEK BERINDEKS ID');
const pesertaById = buatIndeksPeserta(peserta);

console.log('ID 5:', pesertaById[5]);
console.log('ID 11:', pesertaById[11]);
console.log('ID 3:', pesertaById[3] ?? 'Peserta tidak ditemukan.');
