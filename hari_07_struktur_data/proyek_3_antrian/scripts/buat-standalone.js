/** Menggabungkan file proyek menjadi demo HTML tunggal tanpa dependensi eksternal. */
import { readFileSync, writeFileSync } from 'node:fs';

const baca = (nama) => readFileSync(new URL(`../${nama}`, import.meta.url), 'utf8');
const modul = ['js/structures.js', 'js/antrian.js', 'js/riwayat.js', 'js/app.js'];
const sumber = modul.map((nama) => baca(nama)).join('\n');
const kode = sumber
  .replace(/^import\s*\{[^}]+\}\s*from\s*['"][^'"]+['"];?\s*/gm, '')
  .replace(/\bexport\s+(?=class|const|function)\b/g, '');
const halaman = baca('index.html')
  .replace('<link rel="stylesheet" href="css/style.css" />', `<style>\n${baca('css/style.css')}\n</style>`)
  .replace('<script type="module" src="js/app.js"></script>', '')
  .replace('</body>', `<script>\n${kode}\n</script>\n</body>`);
writeFileSync(new URL('../demo-standalone.html', import.meta.url), halaman);
console.log('Berhasil membuat demo-standalone.html (bisa dibuka tanpa Live Server).');
