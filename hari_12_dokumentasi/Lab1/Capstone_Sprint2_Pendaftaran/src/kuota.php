<?php
declare(strict_types=1);
class KuotaPenuhException extends RuntimeException {}
class KelasTidakDitemukanException extends RuntimeException {}

/** Pendaftaran dengan kunci baris kelas dan transaksi InnoDB.
 *  Penting: semua jalur INSERT pendaftar harus melalui fungsi ini.
 */
function daftarkanDenganKuota(PDO $pdo, array $data): int
{
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare('SELECT kuota FROM kelas WHERE id = :id FOR UPDATE');
        $stmt->execute(['id' => $data['kelas_id']]);
        $kuotaMentah = $stmt->fetchColumn();
        if ($kuotaMentah === false) {
            throw new KelasTidakDitemukanException('Kelas tidak ditemukan.');
        }
        $kuota = (int) $kuotaMentah;
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE kelas_id = :id');
        $stmt->execute(['id' => $data['kelas_id']]);
        if ((int) $stmt->fetchColumn() >= $kuota) {
            throw new KuotaPenuhException('Kuota kelas sudah penuh.');
        }
        $id = tambahPendaftar($pdo, $data);
        $pdo->commit();
        return $id;
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        throw $e;
    }
}

/** Jangan izinkan perpindahan kelas melalui UPDATE menerobos batas kuota. */
function ubahPendaftarDenganKuota(PDO $pdo, int $id, array $data): void
{
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare('SELECT kuota FROM kelas WHERE id = :id FOR UPDATE');
        $stmt->execute(['id' => $data['kelas_id']]);
        $raw = $stmt->fetchColumn();
        if ($raw === false) throw new KelasTidakDitemukanException('Kelas tidak ditemukan.');
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE kelas_id = :kelas_id AND id <> :id');
        $stmt->execute(['kelas_id' => $data['kelas_id'], 'id' => $id]);
        if ((int) $stmt->fetchColumn() >= (int) $raw) {
            throw new KuotaPenuhException('Kuota kelas tujuan sudah penuh.');
        }
        ubahPendaftar($pdo, $id, $data);
        $pdo->commit();
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        throw $e;
    }
}
