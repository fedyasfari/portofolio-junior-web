<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/validasi.php';
$hasilUji = [];
function uji(array &$hasil, string $nama, mixed $diharapkan, mixed $aktual): void
{ $hasil[] = [$nama, $diharapkan === $aktual, $diharapkan, $aktual]; }
uji($hasilUji,'HP 10 digit',true,validNoHp('0812345678'));
uji($hasilUji,'HP 9 digit',false,validNoHp('081234567'));
uji($hasilUji,'HP 13 digit',true,validNoHp('0812345678901'));
uji($hasilUji,'HP 14 digit',false,validNoHp('08123456789012'));
uji($hasilUji,'HP huruf',false,validNoHp('08abc45678'));
uji($hasilUji,'HP awalan +62 ditolak',false,validNoHp('+62812345678'));
uji($hasilUji,'HP diawali 07 ditolak',false,validNoHp('0712345678'));
uji($hasilUji,'HP spasi ditolak',false,validNoHp('0812345678 '));
uji($hasilUji,'Kuota normal',5,hitungSisaKuota(30,25));
uji($hasilUji,'Kuota penuh',0,hitungSisaKuota(30,30));
uji($hasilUji,'Kuota berlebih tidak negatif',0,hitungSisaKuota(30,31));
uji($hasilUji,'Kuota awal',30,hitungSisaKuota(30,0));
uji($hasilUji,'Kuota nol',0,hitungSisaKuota(0,0));
uji($hasilUji,'Nomor bukti ID 7','REG-2026-000007',formatNomorBukti(2026,7));
uji($hasilUji,'Nomor bukti ID 0','REG-2026-000000',formatNomorBukti(2026,0));
uji($hasilUji,'Nomor bukti ID 123','REG-2026-000123',formatNomorBukti(2026,123));
$gagal=0;
foreach($hasilUji as [$nama,$lolos,$expected,$actual]) {
 if($lolos) echo "[LOLOS] {$nama}\n";
 else {++$gagal;echo '[GAGAL] '.$nama.' expected='.var_export($expected,true).' actual='.var_export($actual,true).PHP_EOL;}
}
echo "Hasil: ".(count($hasilUji)-$gagal).'/'.count($hasilUji)." lolos.\n";
exit($gagal===0?0:1);
