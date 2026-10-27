/**
 * Lab 2 - Tree dan Graph
 * JavaScript ES Modules: dapat di-import dari Node.js atau browser.
 */

// ============================================================
// BAGIAN 1: TREE FOLDER
// ============================================================
export const strukturFolder = {
  nama: 'proyek',
  anak: [
    {
      nama: 'js',
      anak: [
        { nama: 'app.js', anak: [] },
        { nama: 'utils.js', anak: [] }
      ]
    },
    {
      nama: 'css',
      anak: [{ nama: 'style.css', anak: [] }]
    },
    { nama: 'index.html', anak: [] },
    { nama: 'README.md', anak: [] }
  ]
};

/** Menghasilkan gambar teks struktur folder secara rekursif. */
export function cetakPohon(node) {
  if (!node) return '';

  const baris = [node.nama + ((node.anak?.length ?? 0) > 0 ? '/' : '')];

  function cetakAnak(induk, awalan) {
    const anak = induk.anak ?? [];
    anak.forEach((item, indeks) => {
      const terakhir = indeks === anak.length - 1;
      const cabang = terakhir ? '└── ' : '├── ';
      const nama = item.nama + ((item.anak?.length ?? 0) > 0 ? '/' : '');
      baris.push(awalan + cabang + nama);
      cetakAnak(item, awalan + (terakhir ? '    ' : '│   '));
    });
  }

  cetakAnak(node, '');
  return baris.join('\n');
}

/** Menghitung semua node, termasuk folder proyek (root). */
export function hitungNode(node) {
  if (!node) return 0;

  let jumlah = 1; // Hitung node saat ini.
  for (const anak of node.anak ?? []) {
    jumlah += hitungNode(anak); // Rekursi untuk semua anak.
  }
  return jumlah;
}

/**
 * Cari nama node secara rekursif dan kembalikan jalur lengkap.
 * Contoh: cariNode(strukturFolder, 'app.js') -> 'proyek/js/app.js'
 * Jika tidak ada, hasilnya null.
 */
export function cariNode(node, nama) {
  if (!node) return null;
  if (node.nama === nama) return node.nama;

  for (const anak of node.anak ?? []) {
    const jalurAnak = cariNode(anak, nama);
    if (jalurAnak !== null) {
      return `${node.nama}/${jalurAnak}`;
    }
  }

  return null;
}

// ============================================================
// BAGIAN 2: BINARY SEARCH TREE
// ============================================================
class NodeBST {
  constructor(nilai) {
    this.nilai = nilai;
    this.kiri = null;
    this.kanan = null;
  }
}

export class BinarySearchTree {
  constructor() {
    this.root = null;
  }

  insert(nilai) {
    const nodeBaru = new NodeBST(nilai);
    if (this.root === null) {
      this.root = nodeBaru;
      return true;
    }

    let sekarang = this.root;
    while (true) {
      if (nilai === sekarang.nilai) return false; // Nilai duplikat diabaikan.

      if (nilai < sekarang.nilai) {
        if (sekarang.kiri === null) {
          sekarang.kiri = nodeBaru;
          return true;
        }
        sekarang = sekarang.kiri;
      } else {
        if (sekarang.kanan === null) {
          sekarang.kanan = nodeBaru;
          return true;
        }
        sekarang = sekarang.kanan;
      }
    }
  }

  has(nilai) {
    let sekarang = this.root;

    while (sekarang !== null) {
      if (nilai === sekarang.nilai) return true;
      sekarang = nilai < sekarang.nilai ? sekarang.kiri : sekarang.kanan;
    }
    return false;
  }

  /** In-order: anak kiri -> root -> anak kanan. */
  inOrder() {
    const hasil = [];

    function telusuri(node) {
      if (node === null) return;
      telusuri(node.kiri);
      hasil.push(node.nilai);
      telusuri(node.kanan);
    }

    telusuri(this.root);
    return hasil;
  }
}

// ============================================================
// BAGIAN 3: GRAPH / ADJACENCY LIST
// ============================================================
// Hubungan antar kota di bawah hanya SIMULASI graf, bukan rute jalan asli.
// Setiap sisi tidak memiliki bobot dan berlaku dua arah.
export const grafKota = {
  Surakarta: ['Yogyakarta', 'Semarang'],
  Yogyakarta: ['Surakarta', 'Magelang', 'Klaten'],
  Semarang: ['Surakarta', 'Salatiga'],
  Magelang: ['Yogyakarta'],
  Klaten: ['Yogyakarta', 'Salatiga'],
  Salatiga: ['Semarang', 'Klaten']
};

/** Breadth-First Search: telusuri tetangga per lapisan. */
export function bfs(graf, mulai) {
  if (!Object.hasOwn(graf, mulai)) return [];

  const dikunjungi = new Set([mulai]);
  const antrean = [mulai];
  const urutan = [];
  let depan = 0; // Lebih hemat daripada shift() untuk antrean besar.

  while (depan < antrean.length) {
    const kota = antrean[depan++];
    urutan.push(kota);

    for (const tetangga of graf[kota] ?? []) {
      if (!dikunjungi.has(tetangga)) {
        dikunjungi.add(tetangga);
        antrean.push(tetangga);
      }
    }
  }
  return urutan;
}

/** Depth-First Search: telusuri satu cabang sampai dalam. */
export function dfs(graf, mulai) {
  if (!Object.hasOwn(graf, mulai)) return [];

  const dikunjungi = new Set();
  const urutan = [];

  function telusuri(kota) {
    dikunjungi.add(kota);
    urutan.push(kota);

    for (const tetangga of graf[kota] ?? []) {
      if (!dikunjungi.has(tetangga)) {
        telusuri(tetangga);
      }
    }
  }

  telusuri(mulai);
  return urutan;
}

/**
 * Jarak terpendek dalam JUMLAH SISI (bukan kilometer).
 * 0 = asal sama dengan tujuan; -1 = tidak tersedia jalur / kota tidak ada.
 * BFS menjamin jarak sisi minimum pada graph tanpa bobot.
 */
export function jarakTerpendek(graf, asal, tujuan) {
  if (!Object.hasOwn(graf, asal) || !Object.hasOwn(graf, tujuan)) {
    return -1;
  }
  if (asal === tujuan) return 0;

  const antrean = [[asal, 0]];
  const dikunjungi = new Set([asal]);
  let depan = 0;

  while (depan < antrean.length) {
    const [kota, jarak] = antrean[depan++];
    for (const tetangga of graf[kota] ?? []) {
      if (tetangga === tujuan) return jarak + 1;
      if (!dikunjungi.has(tetangga)) {
        dikunjungi.add(tetangga);
        antrean.push([tetangga, jarak + 1]);
      }
    }
  }

  return -1;
}

export function buatBSTContoh() {
  const bst = new BinarySearchTree();
  [50, 30, 70, 20, 40, 60, 80].forEach((nilai) => bst.insert(nilai));
  return bst;
}
