<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') exit("Khusus terminal.\n");
require_once __DIR__ . '/../src/bootstrap.php';
$pdo = getConnection();
$nama = 'UJI-SPRINT2-'.bin2hex(random_bytes(5));
$idKelas = 0;
$gagal = 0;
try {
    $pdo->prepare('INSERT INTO kelas (nama_kelas,kuota) VALUES (:n,1)')->execute(['n'=>$nama]);
    $idKelas = (int)$pdo->lastInsertId();
    $make = static fn(string $prefix):array => [
       'nama' => 'Peserta Test', 'email' => $prefix.'-'.bin2hex(random_bytes(6)).'@example.test',
       'no_hp' => '081234567890', 'alamat' => '', 'kelas_id' => $idKelas
    ];
    daftarkanDenganKuota($pdo, $make('pertama'));
    $stmt=$pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE kelas_id=:id');
    $stmt->execute(['id'=>$idKelas]);
    if ((int)$stmt->fetchColumn() === 1) echo "[LOLOS] 1 kursi terpakai\n";
    else {echo "[GAGAL] kursi pertama\n";$gagal++;}
    try {
        daftarkanDenganKuota($pdo, $make('kedua'));
        echo "[GAGAL] kursi kedua lolos, seharusnya ditolak\n";$gagal++;
    } catch (KuotaPenuhException $e) {
        echo "[LOLOS] kursi kedua ditolak KuotaPenuhException\n";
    }
    $stmt->execute(['id'=>$idKelas]);
    if ((int)$stmt->fetchColumn() === 1) echo "[LOLOS] jumlah pendaftar tetap 1\n";
    else {echo "[GAGAL] jumlah pendaftar berubah\n";$gagal++;}
    $admins = $pdo->query('SELECT COUNT(*) FROM admin')->fetchColumn();
    echo "[INFO] jumlah admin pada DB latihan: {$admins}\n";
} finally {
    if ($idKelas !== 0) {
        $pdo->prepare('DELETE FROM pendaftar WHERE kelas_id=:id')->execute(['id'=>$idKelas]);
        $pdo->prepare('DELETE FROM kelas WHERE id=:id')->execute(['id'=>$idKelas]);
    }
}
echo $gagal ? "{$gagal} gagal\n" : "Integrasi kuota selesai dan data uji dibersihkan.\n";
exit($gagal === 0 ? 0 : 1);
