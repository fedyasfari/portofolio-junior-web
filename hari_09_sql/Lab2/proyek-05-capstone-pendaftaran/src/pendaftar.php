<?php
declare(strict_types=1);

function semuaPendaftar(PDO $pdo): array
{
    $sql = <<<'SQL'
SELECT p.id_pendaftar, p.nama, p.email, p.no_hp, p.tanggal_daftar,
       k.nama_kelas
FROM pendaftar AS p
INNER JOIN kelas AS k ON k.id_kelas = p.id_kelas
ORDER BY p.id_pendaftar DESC
SQL;
    return $pdo->query($sql)->fetchAll();
}

function semuaKelas(PDO $pdo): array
{
    return $pdo->query('SELECT id_kelas, nama_kelas FROM kelas ORDER BY id_kelas')->fetchAll();
}

function cariPendaftar(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM pendaftar WHERE id_pendaftar = :id');
    $stmt->execute(['id' => $id]);
    $data = $stmt->fetch();
    return $data === false ? null : $data;
}

function tambahPendaftar(PDO $pdo, array $data): void
{
    $sql = <<<'SQL'
INSERT INTO pendaftar (id_kelas, nama, email, no_hp, tanggal_daftar)
VALUES (:id_kelas, :nama, :email, :no_hp, :tanggal_daftar)
SQL;
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id_kelas' => (int) $data['id_kelas'],
        'nama' => trim($data['nama']),
        'email' => trim($data['email']),
        'no_hp' => trim($data['no_hp']),
        'tanggal_daftar' => $data['tanggal_daftar'],
    ]);
}

function ubahPendaftar(PDO $pdo, int $id, array $data): void
{
    $sql = <<<'SQL'
UPDATE pendaftar
SET id_kelas = :id_kelas, nama = :nama, email = :email,
    no_hp = :no_hp, tanggal_daftar = :tanggal_daftar
WHERE id_pendaftar = :id_pendaftar
SQL;
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id_pendaftar' => $id,
        'id_kelas' => (int) $data['id_kelas'],
        'nama' => trim($data['nama']),
        'email' => trim($data['email']),
        'no_hp' => trim($data['no_hp']),
        'tanggal_daftar' => $data['tanggal_daftar'],
    ]);
}

function hapusPendaftar(PDO $pdo, int $id): void
{
    $stmt = $pdo->prepare('DELETE FROM pendaftar WHERE id_pendaftar = :id');
    $stmt->execute(['id' => $id]);
}
