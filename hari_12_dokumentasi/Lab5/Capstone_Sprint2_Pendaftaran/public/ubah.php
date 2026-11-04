<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';
wajibLogin();
$id = validId($_GET['id'] ?? null);
if ($id === null) {http_response_code(404);exit('Data tidak ditemukan.');}
$pdo = getConnection();
$lama = ambilPendaftarById($pdo,$id);
if ($lama === null) {http_response_code(404);exit('Data tidak ditemukan.');}
$kelas=daftarKelas($pdo); $galat=[];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cekCsrf();
    ['data'=>$lama,'galat'=>$galat] = validasiPendaftar($_POST,$pdo,$id);
    if (!$galat) {
        try {
            ubahPendaftarDenganKuota($pdo,$id,$lama);
            setFlash('Data peserta berhasil diperbarui.');
            alihkan('index.php');
        } catch (KuotaPenuhException $ex) {
            $galat['kelas_id']=$ex->getMessage();
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            $galat['email'] = 'Perubahan gagal disimpan. Periksa apakah email sudah digunakan.';
        }
    }
}
$judul='Ubah Pendaftar';$judulTampilan='Ubah Pendaftar';$labelSimpan='Simpan Perubahan';
require __DIR__ . '/../templates/header.php';
require __DIR__ . '/../templates/_form.php';
require __DIR__ . '/../templates/footer.php';
