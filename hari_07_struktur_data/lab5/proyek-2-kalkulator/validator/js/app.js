import {
  validasiNama,
  validasiEmail,
  validasiSandi,
  validasiKonfirmasi,
} from './aturan.js';

const form = document.querySelector('#form-daftar');
const ringkasan = document.querySelector('#ringkasan');
const fields = ['nama', 'email', 'sandi', 'konfirmasi'];

function ambilNilai() {
  return Object.fromEntries(fields.map((nama) => [nama, form.elements[nama].value]));
}

function periksa() {
  const data = ambilNilai();
  const pesan = {
    nama: validasiNama(data.nama),
    email: validasiEmail(data.email),
    sandi: validasiSandi(data.sandi),
    konfirmasi: validasiKonfirmasi(data.sandi, data.konfirmasi),
  };
  for (const nama of fields) {
    const kolom = form.elements[nama];
    const salah = pesan[nama] !== '';
    kolom.setAttribute('aria-invalid', String(salah));
    document.querySelector(`#error-${nama}`).textContent = pesan[nama];
  }
  return { data, valid: Object.values(pesan).every((nilai) => nilai === '') };
}

form.addEventListener('input', () => {
  periksa();
  ringkasan.textContent = '';
});

form.addEventListener('submit', (event) => {
  event.preventDefault();
  const { data, valid } = periksa();
  if (!valid) {
    ringkasan.textContent = 'Perbaiki data yang belum valid.';
    return;
  }
  // Jangan tampilkan atau simpan kata sandi.
  ringkasan.textContent = `Pendaftaran simulasi berhasil: ${data.nama} (${data.email})`;
  form.reset();
});
