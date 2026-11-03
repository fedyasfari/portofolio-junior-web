// LAB 1 - DEBUGGING JAVASCRIPT: SOLUSI 4 BUG
const keranjang = [
  { nama: 'Buku', harga: 25000, jumlah: 2 },
  { nama: 'Pensil', harga: 3000, jumlah: 10 },
  { nama: 'Penghapus', harga: 2000, jumlah: 1 } // B-03: jumlah diisi 1
];

function hitungSubtotal(item) {
  return item.harga * item.jumlah;
}

function hitungTotal(daftar) {
  let total = 0;
  // B-02: batas iterasi harus i < daftar.length (bukan <=).
  for (let i = 0; i < daftar.length; i++) {
    total += hitungSubtotal(daftar[i]);
  }
  return total;
}

function hitungDiskon(total) {
  // B-04: Rp50.000 juga harus mendapat diskon 10%.
  if (total >= 50000) {
    return total * 0.1;
  }
  return 0;
}

function formatRupiah(angka) {
  return 'Rp' + angka.toLocaleString('id-ID');
}

const total = hitungTotal(keranjang);
const diskon = hitungDiskon(total);
const totalBayar = total - diskon;

console.log('Subtotal Buku: ' + formatRupiah(hitungSubtotal(keranjang[0])));
console.log('Subtotal Pensil: ' + formatRupiah(hitungSubtotal(keranjang[1])));
console.log('Subtotal Penghapus: ' + formatRupiah(hitungSubtotal(keranjang[2])));
console.log('Total belanja: ' + formatRupiah(total));
console.log('Diskon 10%: ' + formatRupiah(diskon));
console.log('Total bayar: ' + formatRupiah(totalBayar)); // B-01: ) lengkap

// Pengujian otomatis sederhana untuk mencegah bug muncul kembali.
console.assert(hitungDiskon(50000) === 5000, 'Diskon batas Rp50.000 harus Rp5.000');
console.assert(hitungDiskon(49999) === 0, 'Belanja di bawah Rp50.000 tidak didiskon');
console.assert(total === 82000, 'Total belanja seharusnya Rp82.000');
console.assert(diskon === 8200, 'Diskon seharusnya Rp8.200');
console.assert(totalBayar === 73800, 'Total bayar seharusnya Rp73.800');
