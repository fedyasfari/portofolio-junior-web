<?php
declare(strict_types=1);

function daftarKelas(PDO $pdo): array
{
    return $pdo->query('SELECT k.id, k.nama_kelas, k.kuota, COUNT(p.id) AS terisi,
          GREATEST(0, CAST(k.kuota AS SIGNED) - CAST(COUNT(p.id) AS SIGNED)) AS sisa
          FROM kelas k LEFT JOIN pendaftar p ON p.kelas_id = k.id
          GROUP BY k.id, k.nama_kelas, k.kuota ORDER BY k.nama_kelas')->fetchAll();
}
function ambilSemuaPendaftar(PDO $pdo): array
{
    // Skema Sprint 1 memakai tanggal_daftar, alias menjaga kompatibilitas Lab 4/5.
    $sql = 'SELECT p.id, p.nama, p.email, p.no_hp, p.tanggal_daftar AS tgl_daftar,
                   k.nama_kelas FROM pendaftar p JOIN kelas k ON k.id = p.kelas_id
            ORDER BY p.id DESC';
    return $pdo->query($sql)->fetchAll();
}
/** Pencarian server dengan placeholder: input tidak menjadi kode SQL. */
function cariPendaftar(PDO $pdo, string $cari): array
{
    $sql = 'SELECT p.id, p.nama, p.email, p.no_hp, p.tanggal_daftar AS tgl_daftar,
                   k.nama_kelas FROM pendaftar p JOIN kelas k ON k.id = p.kelas_id
            WHERE p.nama LIKE :nama OR p.email LIKE :email
            ORDER BY p.id DESC';
    $stmt = $pdo->prepare($sql);
    $kata = '%' . $cari . '%';
    $stmt->execute(['nama' => $kata, 'email' => $kata]);
    return $stmt->fetchAll();
}
function ambilBuktiPendaftar(PDO $pdo, int $id): ?array
{
    $sql = 'SELECT p.id, p.nama, p.email, p.no_hp, p.tanggal_daftar AS tgl_daftar,
                   k.nama_kelas FROM pendaftar p JOIN kelas k ON k.id = p.kelas_id
            WHERE p.id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $baris = $stmt->fetch();
    return $baris === false ? null : $baris;
}
function ambilPendaftarById(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM pendaftar WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $hasil = $stmt->fetch();
    return $hasil === false ? null : $hasil;
}
function validasiPendaftar(array $input, PDO $pdo, ?int $kecualiId = null): array
{
    $data = [
        'nama' => trim((string) ($input['nama'] ?? '')),
        'email' => mb_strtolower(trim((string) ($input['email'] ?? ''))),
        'no_hp' => trim((string) ($input['no_hp'] ?? '')),
        'alamat' => trim((string) ($input['alamat'] ?? '')),
        'kelas_id' => filter_var($input['kelas_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: 0,
    ];
    $galat = [];
    if (mb_strlen($data['nama']) < 3 || mb_strlen($data['nama']) > 150) {
        $galat['nama'] = 'Nama harus terdiri dari 3 sampai 150 karakter.';
    }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || strlen($data['email']) > 190) {
        $galat['email'] = 'Masukkan alamat email yang valid.';
    }
    if (!validNoHp($data['no_hp'])) {
        $galat['no_hp'] = 'Nomor HP harus diawali 08 dan berjumlah 10–13 digit.';
    }
    if (mb_strlen($data['alamat']) > 1000) {
        $galat['alamat'] = 'Alamat maksimal 1000 karakter.';
    }
    $pilihan = array_map('intval', array_column(daftarKelas($pdo), 'id'));
    if (!in_array($data['kelas_id'], $pilihan, true)) {
        $galat['kelas_id'] = 'Silakan pilih kelas yang tersedia.';
    }
    if (!isset($galat['email'])) {
        $cek = $pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE email = :email AND id <> :id');
        $cek->execute(['email' => $data['email'], 'id' => $kecualiId ?? 0]);
        if ((int) $cek->fetchColumn() > 0) $galat['email'] = 'Email sudah digunakan untuk pendaftaran.';
    }
    return ['data' => $data, 'galat' => $galat];
}
function tambahPendaftar(PDO $pdo, array $data): int
{
    $sql = 'INSERT INTO pendaftar (nama,email,no_hp,alamat,kelas_id)
            VALUES (:nama,:email,:no_hp,:alamat,:kelas_id)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
    return (int) $pdo->lastInsertId();
}
function ubahPendaftar(PDO $pdo, int $id, array $data): void
{
    $sql = 'UPDATE pendaftar SET nama=:nama,email=:email,no_hp=:no_hp,
            alamat=:alamat,kelas_id=:kelas_id WHERE id=:id';
    $pdo->prepare($sql)->execute($data + ['id' => $id]);
}
function hapusPendaftar(PDO $pdo, int $id): void
{
    $pdo->prepare('DELETE FROM pendaftar WHERE id=:id')->execute(['id'=>$id]);
}
