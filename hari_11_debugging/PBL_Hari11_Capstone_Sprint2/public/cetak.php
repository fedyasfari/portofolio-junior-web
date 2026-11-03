<?php
declare(strict_types=1);
// Jangan mencetak output apapun sebelum stream().
require_once __DIR__ . '/../src/bootstrap.php';
wajibLogin();
$id = validId($_GET['id'] ?? null);
if ($id === null) {http_response_code(404);exit('Data tidak ditemukan.');}
if (!bolehCetak($id)) {http_response_code(403);exit('Akses bukti tidak diizinkan.');}
$bukti=ambilBuktiPendaftar(getConnection(),$id);
if ($bukti === null) {http_response_code(404);exit('Data tidak ditemukan.');}
$autoload = __DIR__ . '/../vendor/autoload.php';
if (!is_file($autoload)) {
    http_response_code(503);
    exit('Library Dompdf belum terpasang. Jalankan composer install dari root proyek.');
}
require_once $autoload;
$tanggal=(string)($bukti['tgl_daftar']??'');
$ts=strtotime($tanggal);
if ($ts===false) {http_response_code(500);exit('Tanggal pendaftaran tidak valid.');}
$nomor=formatNomorBukti((int)date('Y',$ts), (int)$bukti['id']);
$tanggalDaftarTampil=date('d/m/Y H:i',$ts);
$dicetakPada=date('d/m/Y H:i');
ob_start();
require __DIR__ . '/../templates/bukti.php';
$html=(string)ob_get_clean();
$options=new \Dompdf\Options();
$options->set('isRemoteEnabled',false);
$options->set('isPhpEnabled',false);
$options->set('defaultFont','DejaVu Sans');
$dompdf=new \Dompdf\Dompdf($options);
$dompdf->loadHtml($html,'UTF-8');
$dompdf->setPaper('A5','portrait');
$dompdf->render();
$dompdf->stream($nomor . '.pdf',['Attachment'=>false]);
