// Server lokal sederhana TANPA instalasi paket tambahan.
import { createServer } from 'node:http';
import { createReadStream, statSync } from 'node:fs';
import { dirname, extname, resolve, sep } from 'node:path';
import { fileURLToPath } from 'node:url';

const akar = dirname(fileURLToPath(import.meta.url));
const PORT = 5500;
const jenis = {
  '.html': 'text/html; charset=utf-8',
  '.css': 'text/css; charset=utf-8',
  '.js': 'text/javascript; charset=utf-8',
  '.json': 'application/json; charset=utf-8'
};

createServer((request, response) => {
  if (request.method !== 'GET' && request.method !== 'HEAD') {
    response.writeHead(405).end('Method not allowed');
    return;
  }
  let alamat;
  try {
    alamat = decodeURIComponent(new URL(request.url, `http://localhost:${PORT}`).pathname);
  } catch {
    response.writeHead(400).end('Bad Request');
    return;
  }
  const lokasi = resolve(akar, '.' + (alamat === '/' ? '/index.html' : alamat));
  if (lokasi !== akar && !lokasi.startsWith(akar + sep)) {
    response.writeHead(403).end('Forbidden');
    return;
  }
  try {
    if (!statSync(lokasi).isFile()) throw new Error('Not a file');
    response.writeHead(200, { 'Content-Type': jenis[extname(lokasi)] ?? 'application/octet-stream' });
    if (request.method === 'HEAD') response.end();
    else createReadStream(lokasi).pipe(response);
  } catch {
    response.writeHead(404).end('File tidak ditemukan');
  }
}).listen(PORT, '127.0.0.1', () => {
  console.log(`Aplikasi siap dibuka: http://localhost:${PORT}`);
  console.log('Hentikan server dengan Ctrl+C.');
});