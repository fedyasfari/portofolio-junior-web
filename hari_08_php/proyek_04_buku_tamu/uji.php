<?php
declare(strict_types=1);
require_once __DIR__ . '/functions.php';

// Uji fungsi murni, tanpa menghapus/mengubah data pengguna.
$contoh = [
    ['id' => 1, 'nama' => 'Sari', 'pesan' => 'Halo', 'dihapus_pada' => null],
    ['id' => 2, 'nama' => 'Budi', 'pesan' => 'Bagus', 'dihapus_pada' => null],
    ['id' => 3, 'nama' => 'Citra', 'pesan' => 'Terima kasih', 'dihapus_pada' => null],
    ['id' => 4, 'nama' => 'Sandi', 'pesan' => 'Salam', 'dihapus_pada' => '2026-01-01 09:00:00'],
];

$pengujian = [
    'Nama minimal 3 karakter' => isset(validasiTamu(['nama'=>'Ab','email'=>'ab@mail.com','pesan'=>'Halo'])['galat']['nama']),
    'Email salah ditolak' => isset(validasiTamu(['nama'=>'Sari','email'=>'bukan-email','pesan'=>'Halo'])['galat']['email']),
    'Pesan kosong ditolak' => isset(validasiTamu(['nama'=>'Sari','email'=>'s@mail.com','pesan'=>' '])['galat']['pesan']),
    'Pesan lebih 500 karakter ditolak' => isset(validasiTamu(['nama'=>'Sari','email'=>'s@mail.com','pesan'=>str_repeat('x',501)])['galat']['pesan']),
    'Input valid diterima' => validasiTamu(['nama'=>'Sari','email'=>'s@mail.com','pesan'=>'Halo'])['galat'] === [],
    'Spasi nama dirapikan' => bersihkanSpasi('  Sari   Putri  ') === 'Sari Putri',
    'Cari tidak peka kapital' => count(cariTamu($contoh, 'SA')) === 1,
    'Cari sebagian nama' => cariTamu($contoh, 'itr')[0]['nama'] === 'Citra',
    'Cari nama tidak ada' => cariTamu($contoh, 'xyz') === [],
    'Hapus lembut tidak tampil' => count(cariTamu($contoh, '')) === 3,
    'Halaman pertama berisi <=5' => count(halamanTamu(range(1,9), 1)) === 5,
    'Halaman kedua berisi sisanya' => count(halamanTamu(range(1,9), 2)) === 4,
    'HTML script di-escape' => e('<script>alert(1)</script>') === '&lt;script&gt;alert(1)&lt;/script&gt;',
    'Atribut kutip di-escape' => e('" onfocus="alert(1)') === '&quot; onfocus=&quot;alert(1)',
    'Input array berbahaya ditolak jadi teks kosong' => nilaiTeks(['nama'=>['x']], 'nama') === '',
    'CSV formula dinetralkan' => amanCsv('=1+1') === "'=1+1",
];
$lulus = count(array_filter($pengujian));
?><!DOCTYPE html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Pengujian Buku Tamu</title><link rel="stylesheet" href="style.css"></head><body>
<main class="admin-container"><section class="panel"><h1>Pengujian Proyek Buku Tamu</h1><p><strong><?= e($lulus) ?> dari <?= e(count($pengujian)) ?> tes lulus</strong></p>
<?php foreach ($pengujian as $nama=>$berhasil): ?><p><?= $berhasil ? '✅' : '❌' ?> <?= e($nama) ?></p><?php endforeach; ?>
<p><a href="index.php">Kembali ke aplikasi</a></p><p class="muted">Tes ini tidak menulis atau menghapus data tamu. Uji form, penguncian file, login, dan ekspor secara manual.</p></section></main>
</body></html>
