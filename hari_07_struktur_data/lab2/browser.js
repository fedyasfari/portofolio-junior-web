import {
  strukturFolder, cetakPohon, hitungNode, cariNode,
  buatBSTContoh, grafKota, bfs, dfs, jarakTerpendek
} from './structures.js';

const $ = (id) => document.getElementById(id);
const bst = buatBSTContoh();

$('cetak').textContent = cetakPohon(strukturFolder);
$('jumlah').textContent = String(hitungNode(strukturFolder));
$('inorder').textContent = JSON.stringify(bst.inOrder());
$('has60').textContent = String(bst.has(60));
$('has65').textContent = String(bst.has(65));
$('graf').textContent = JSON.stringify(grafKota, null, 2);
$('bfs').textContent = bfs(grafKota, 'Surakarta').join(' → ');
$('dfs').textContent = dfs(grafKota, 'Surakarta').join(' → ');

$('tombolCari').addEventListener('click', () => {
  const nama = $('namaNode').value.trim();
  const jalur = cariNode(strukturFolder, nama);
  $('hasilCari').textContent = jalur ?? 'Node tidak ditemukan.';
});
$('namaNode').addEventListener('keydown', (event) => {
  if (event.key === 'Enter') $('tombolCari').click();
});

for (const kota of Object.keys(grafKota)) {
  for (const id of ['asal', 'tujuan']) {
    const opsi = document.createElement('option');
    opsi.value = kota;
    opsi.textContent = kota;
    $(id).append(opsi);
  }
}
$('asal').value = 'Surakarta';
$('tujuan').value = 'Salatiga';

function perbaruiJarak() {
  const asal = $('asal').value;
  const tujuan = $('tujuan').value;
  const jumlahSisi = jarakTerpendek(grafKota, asal, tujuan);
  $('hasilJarak').textContent = jumlahSisi === -1
    ? 'Tidak tersedia jalur.'
    : `${jumlahSisi} sisi (bukan kilometer)`;
}

$('tombolJarak').addEventListener('click', perbaruiJarak);
perbaruiJarak();
