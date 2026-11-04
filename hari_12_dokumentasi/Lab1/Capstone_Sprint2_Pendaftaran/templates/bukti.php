<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8"><title><?= e($nomor) ?> | Bukti Pendaftaran</title>
<style>
@page { margin: 15mm 12mm; }
body { font-family: "DejaVu Sans", sans-serif; font-size: 10pt; color: #172033; }
h1 { text-align:center; margin:0; font-size:18pt; color:#16488a; }
p.sub { text-align:center; color:#555; margin:5px 0 20px; font-size:9pt; }
.nomor { margin:15px 0; }
table { width:100%; border-collapse:collapse; table-layout:fixed; }
td { padding:9px; border:1px solid #c6d0e0; overflow-wrap:break-word; }
td.label { width:36%; background:#edf4ff; font-weight:bold; }
footer { font-size:8.5pt; margin-top:17px; color:#566; }
</style>
</head>
<body>
<h1>Bukti Pendaftaran</h1>
<p class="sub">Program Pelatihan · Capstone Sprint 1</p>
<p class="nomor"><strong>Nomor:</strong> <?= e($nomor) ?></p>
<table>
<tr><td class="label">Nama</td><td><?= e($bukti['nama']) ?></td></tr>
<tr><td class="label">Email</td><td><?= e($bukti['email']) ?></td></tr>
<tr><td class="label">No. HP</td><td><?= e($bukti['no_hp']) ?></td></tr>
<tr><td class="label">Kelas</td><td><?= e($bukti['nama_kelas']) ?></td></tr>
<tr><td class="label">Tanggal daftar</td><td><?= e($tanggalDaftarTampil) ?></td></tr>
</table>
<footer>Dicetak pada <?= e($dicetakPada) ?> WIB.</footer>
</body>
</html>
