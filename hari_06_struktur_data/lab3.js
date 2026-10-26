
import { Stack } from './structures.js';

// =======================================
// SOAL 3 - VALIDASI KURUNG SEIMBANG
// =======================================

export function kurungSeimbang(teks) {
  const pasangan = {
    ')': '(',
    ']': '[',
    '}': '{'
  };

  const tumpukan = new Stack();

  for (const karakter of teks) {
    if ('([{'.includes(karakter)) {
      tumpukan.push(karakter);

    } else if (karakter in pasangan) {
      if (
        tumpukan.isEmpty() ||
        tumpukan.pop() !== pasangan[karakter]
      ) {
        return false;
      }
    }
  }

  return tumpukan.isEmpty();
}

// =======================================
// SOAL 4A - MEMBALIK STRING DENGAN STACK
// =======================================

export function balikString(teks) {
  const tumpukan = new Stack();
  let hasil = '';

  // Memasukkan setiap karakter
  for (const karakter of teks) {
    tumpukan.push(karakter);
  }

  // Mengambil karakter dari belakang
  while (!tumpukan.isEmpty()) {
    hasil += tumpukan.pop();
  }

  return hasil;
}

// =======================================
// SOAL 4B - MEMERIKSA PALINDROM
// =======================================

export function adalahPalindrom(teks) {
  const bersih = teks
    .toLowerCase()
    .replace(/[^\p{L}\p{N}]/gu, '');

  return bersih === balikString(bersih);
}

// =======================================
// PENGUJIAN SOAL 2 - STACK
// =======================================

console.log('=== SOAL 2: UJI STACK ===');

const stack = new Stack();

stack.push('Buku A');
stack.push('Buku B');
stack.push('Buku C');

console.log('Setelah push:', stack.items);

console.log('Peek:', stack.peek());

console.log('Pop 1:', stack.pop());
console.log('Pop 2:', stack.pop());
console.log('Pop 3:', stack.pop());

console.log('Kosong?', stack.isEmpty());

// Pop lagi ketika sudah kosong
console.log('Pop saat kosong:', stack.pop());

// =======================================
// PENGUJIAN SOAL 3 - KURUNG
// =======================================

console.log('\n=== SOAL 3: KURUNG ===');

console.log(kurungSeimbang('(a+b)*[c-d]'));
console.log(kurungSeimbang('(a+b]'));
console.log(kurungSeimbang('((a)'));
console.log(kurungSeimbang(''));

// Pengujian tambahan
console.log(kurungSeimbang('{[()]}'));
console.log(kurungSeimbang('([)]'));

// =======================================
// PENGUJIAN SOAL 4 - STRING
// =======================================

console.log('\n=== SOAL 4: STRING ===');

console.log('Balik BELAJAR:', balikString('BELAJAR'));
console.log('Balik KATAK:', balikString('KATAK'));

console.log('katak:', adalahPalindrom('katak'));
console.log('Kasur rusak:', adalahPalindrom('Kasur rusak'));
console.log('belajar:', adalahPalindrom('belajar'));
