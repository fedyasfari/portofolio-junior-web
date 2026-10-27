import { cariLinear, cariBiner, bubbleSort, insertionSort, mergeSort, buatDataAcak } from './algoritma.js';

const ambil = id => document.getElementById(id);
function bacaData() {
  const teks = ambil('masukan').value.trim();
  if (teks === '') return [];
  const bagian = teks.split(',').map(s => s.trim());
  if (bagian.some(s => s === '' || !Number.isFinite(Number(s)))) {
    throw new Error('Masukkan angka yang valid, dipisahkan koma; contoh: 8, 3, 5.');
  }
  return bagian.map(Number);
}
function buatTabel(kepala, baris) {
  const tabel = document.createElement('table');
  const thead = document.createElement('thead');
  const trh = document.createElement('tr');
  for (const judul of kepala) {
    const th = document.createElement('th'); th.textContent = judul; trh.appendChild(th);
  }
  thead.appendChild(trh); tabel.appendChild(thead);
  const tbody = document.createElement('tbody');
  for (const barisData of baris) {
    const tr = document.createElement('tr');
    for (const nilai of barisData) {
      const td = document.createElement('td'); td.className = 'out'; td.textContent = String(nilai); tr.appendChild(td);
    }
    tbody.appendChild(tr);
  }
  tabel.appendChild(tbody);
  return tabel;
}
function tulisTabel(id, kepala, baris) {
  const tempat = ambil(id); tempat.replaceChildren(buatTabel(kepala, baris));
}
function tunjukkanError(error) {
  ambil('pesan').className = 'error';
  ambil('pesan').textContent = error.message;
}

ambil('urutkan').addEventListener('click', () => {
  try {
    const data = bacaData();
    const b = {}, i = {};
    tulisTabel('hasilSort', ['Metode', 'Output', 'Perbandingan nilai'], [
      ['Input asli', JSON.stringify(data), '—'],
      ['Bubble Sort', JSON.stringify(bubbleSort(data, b)), b.perbandingan],
      ['Insertion Sort', JSON.stringify(insertionSort(data, i)), i.perbandingan],
      ['Merge Sort', JSON.stringify(mergeSort(data)), '—'],
      ['Array.sort', JSON.stringify([...data].sort((x, y) => x - y)), '—'],
    ]);
    ambil('pesan').className = 'success';
    ambil('pesan').textContent = 'Pengurutan berhasil. Array asli tidak diubah.';
  } catch (error) { tunjukkanError(error); }
});

ambil('cari').addEventListener('click', () => {
  try {
    const data = bacaData();
    const target = Number(ambil('target').value);
    if (ambil('target').value.trim() === '' || !Number.isFinite(target)) throw Error('Angka target tidak valid.');
    const terurut = mergeSort(data);
    tulisTabel('hasilCari', ['Pencarian', 'Array yang diperiksa', 'Indeks hasil'], [
      ['Linear', JSON.stringify(data), cariLinear(data, target)],
      ['Biner', JSON.stringify(terurut), cariBiner(terurut, target)],
    ]);
    ambil('pesan').textContent = '';
  } catch (error) { tunjukkanError(error); }
});

ambil('hitung').addEventListener('click', () => {
  const n = 1000;
  const urut = Array.from({ length: n }, (_, i) => i + 1);
  const daftar = [['Acak', buatDataAcak(n, 20261027)], ['Terurut', urut], ['Terbalik', [...urut].reverse()]];
  const baris = daftar.map(([nama, data]) => {
    const b = {}, i = {};
    bubbleSort(data, b); insertionSort(data, i);
    return [nama, n, b.perbandingan.toLocaleString('id-ID'), i.perbandingan.toLocaleString('id-ID')];
  });
  tulisTabel('hasilHitung', ['Kondisi', 'N', 'Bubble Sort', 'Insertion Sort'], baris);
});

ambil('contohKosong').addEventListener('click', () => { ambil('masukan').value = ''; ambil('urutkan').click(); });
ambil('contohDuplikat').addEventListener('click', () => { ambil('masukan').value = '4, 2, 4, 1, 2'; ambil('urutkan').click(); });
ambil('urutkan').click();
