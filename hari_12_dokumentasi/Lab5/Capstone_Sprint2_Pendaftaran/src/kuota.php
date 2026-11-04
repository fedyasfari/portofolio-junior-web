<?php
declare(strict_types=1);
/** Pendaftaran ditolak karena kuota kelas sudah habis; tawarkan kelas alternatif. */
class KuotaPenuhException extends RuntimeException {}
/** Kelas tujuan sudah tidak ada; minta pengguna memilih kelas yang masih tersedia. */
class KelasTidakDitemukanException extends RuntimeException {}

/**
 * Mendaftarkan peserta secara atomik menggunakan transaksi InnoDB dan kunci baris kelas.
 * Penguncian SELECT ... FOR UPDATE mencegah pendaftaran paralel melampaui kuota.
 * Seluruh jalur tambah peserta seharusnya memakai fungsi ini, bukan INSERT langsung.
 *
 * @param PDO $pdo Koneksi MySQL/PDO yang mendukung transaksi dan penguncian baris.
 * @param array{nama: string, email: string, no_hp: string, alamat: string, kelas_id: int} $data Data peserta yang sudah lolos validasi.
 * @return int ID peserta yang berhasil disimpan setelah commit.
 * @throws KelasTidakDitemukanException Jika ID kelas tidak ditemukan; muat ulang pilihan kelas dan minta memilih lagi.
 * @throws KuotaPenuhException Jika kapasitas telah habis; tampilkan pesan dan minta memilih kelas lain.
 * @throws PDOException Jika transaksi/query gagal; fungsi melakukan rollback, kemudian tampilkan pesan aman dan catat log.
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

/**
 * Mengubah peserta sambil menjaga batas kuota kelas tujuan secara atomik.
 * Peserta dengan ID yang sama dikecualikan dari hitungan isi kelas saat pengubahan.
 *
 * @param PDO $pdo Koneksi PDO yang mendukung transaksi InnoDB.
 * @param int $id ID peserta yang sedang diperbarui, seharusnya minimal 1.
 * @param array{nama: string, email: string, no_hp: string, alamat: string, kelas_id: int} $data Data hasil validasi termasuk kelas tujuan.
 * @return void Perubahan disimpan lalu transaksi di-commit; tidak ada nilai kembali.
 * @throws KelasTidakDitemukanException Jika kelas tujuan tidak ada; muat ulang daftar kelas dan pilih ulang.
 * @throws KuotaPenuhException Jika kelas tujuan penuh; minta memilih kelas lain atau mempertahankan kelas semula.
 * @throws PDOException Jika UPDATE/transaksi gagal; rollback, catat log, dan beri pesan aman.
 */
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
