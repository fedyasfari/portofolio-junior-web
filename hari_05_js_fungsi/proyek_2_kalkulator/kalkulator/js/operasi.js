
export const tambah = (a, b) => a + b;

export const kurang = (a, b) => a - b;

export const kali = (a, b) => a * b;

export function bagi(a, b) {
  if (b === 0) {
    throw new Error('Tidak bisa dibagi nol');
  }

  return a / b;
}

export function hitung(operator, a, b) {
  switch (operator) {
    case '+':
      return tambah(a, b);

    case '-':
      return kurang(a, b);

    case '*':
      return kali(a, b);

    case '/':
      return bagi(a, b);

    default:
      throw new Error('Operator tidak dikenal');
  }
}
