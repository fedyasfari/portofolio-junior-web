<?php
// Dipanggil dari public/cetak.php; variabel: $bukti, $nomor, $tanggalTampil.
// Pastikan file disimpan sebagai UTF-8 tanpa BOM.
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Bukti Pendaftaran <?= e($nomor) ?></title>
  <style>
    @page { margin: 16mm 14mm; }
    body { font-family: "DejaVu Sans", sans-serif; font-size: 10pt; color: #24334a; }
    .kop { border-bottom: 3px solid #1464a6; padding-bottom: 11px; margin-bottom: 18px; }
    .brand { font-size: 9pt; color: #47739a; letter-spacing: 1px; text-transform: uppercase; }
    h1 { font-size: 19pt; margin: 6px 0; color: #123c69; }
    .sub { margin-top: 5px; font-size: 9pt; color: #65778c; }
    .nomor { border: 1px solid #cbd7e5; background: #eef5fc; padding: 9px 12px; margin-bottom: 16px; }
    .nomor strong { color: #123c69; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
    td { padding: 9px 9px; border-bottom: 1px solid #dae3ef; vertical-align: top; }
    td.label { width: 34%; font-weight: bold; background: #f5f8fd; }
    .foot { font-size: 8pt; color: #586778; margin-top: 26px; border-top: 1px solid #dae3ef; padding-top: 10px; }
  </style>
</head>
<body>
  <div class="kop">
    <div class="brand">Sistem Pendaftaran Pelatihan</div>
    <h1>Bukti Pendaftaran</h1>
    <div class="sub">Dokumen konfirmasi data pendaftar</div>
  </div>
  <div class="nomor">Nomor: <strong><?= e($nomor) ?></strong></div>
  <table>
    <tr><td class="label">Nama</td><td><?= e((string) $bukti['nama']) ?></td></tr>
    <tr><td class="label">Email</td><td><?= e((string) $bukti['email']) ?></td></tr>
    <tr><td class="label">No. HP</td><td><?= e((string) $bukti['no_hp']) ?></td></tr>
    <tr><td class="label">Kelas</td><td><?= e((string) $bukti['nama_kelas']) ?></td></tr>
    <tr><td class="label">Tanggal daftar</td><td><?= e($tanggalTampil) ?></td></tr>
  </table>
  <div class="foot">
    Dicetak pada <?= e(date('d-m-Y H:i')) ?><br>
    (Mengikuti zona waktu server.)<br>
    Dokumen ini dihasilkan otomatis dari sistem pendaftaran.
  </div>
</body>
</html>
