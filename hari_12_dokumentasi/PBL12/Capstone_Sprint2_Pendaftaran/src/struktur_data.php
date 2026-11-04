<?php
declare(strict_types=1);

/**
 * Menyaring beberapa pendaftar terbaru menggunakan SplQueue (FIFO).
 *
 * Setiap baris harus memiliki 'id'. Input diurutkan dari ID kecil ke besar;
 * antrean menyimpan maksimal $batas entri. Keluaran ditampilkan terbaru dahulu.
 * Struktur ini untuk RINGKASAN, bukan penyimpanan permanen database.
 *
 * @param list<array<string, mixed>> $pendaftar Baris dari ambilSemuaPendaftar().
 * @param int $batas Banyak peserta yang diambil, minimal 1.
 * @return list<array<string, mixed>> Maksimal $batas peserta, ID terbesar dahulu.
 * @throws InvalidArgumentException Jika batas tidak positif atau baris tidak punya ID.
 */
function limaPendaftarTerbaru(array $pendaftar, int $batas = 5): array
{
    if ($batas < 1) {
        throw new InvalidArgumentException('Batas harus minimal 1.');
    }
    foreach ($pendaftar as $baris) {
        if (!isset($baris['id']) || !filter_var($baris['id'], FILTER_VALIDATE_INT)) {
            throw new InvalidArgumentException('Setiap pendaftar wajib memiliki ID numerik.');
        }
    }
    usort($pendaftar, static fn(array $a, array $b): int => (int) $a['id'] <=> (int) $b['id']);
    $antrean = new SplQueue();
    foreach ($pendaftar as $baris) {
        $antrean->enqueue($baris);
        if ($antrean->count() > $batas) {
            $antrean->dequeue(); // Buang pendaftar terlama jika melebihi batas.
        }
    }
    // Urutan antrean tertua-terbaru dibalik untuk tampilan dashboard.
    return array_reverse(iterator_to_array($antrean, false));
}

/**
 * Mengurutkan kelas dari jumlah peserta terbanyak dengan array asosiatif dan usort().
 *
 * Kelas yang belum memiliki peserta tetap ditampilkan karena sumbernya daftarKelas(),
 * bukan pengelompokan dari daftar pendaftar saja.
 *
 * @param list<array<string, mixed>> $kelas Data dari daftarKelas() (nama_kelas, terisi).
 * @return list<array{nama_kelas: string, terisi: int}> Peringkat besar ke kecil.
 * @throws InvalidArgumentException Jika data kelas tidak memiliki kolom penting.
 */
function peringkatKelasBerdasarkanJumlah(array $kelas): array
{
    $peringkat = [];
    foreach ($kelas as $baris) {
        if (!array_key_exists('nama_kelas', $baris) || !array_key_exists('terisi', $baris)) {
            throw new InvalidArgumentException('Data kelas harus memuat nama_kelas dan terisi.');
        }
        $peringkat[] = [
            'nama_kelas' => (string) $baris['nama_kelas'],
            'terisi' => max(0, (int) $baris['terisi']),
        ];
    }
    usort($peringkat, static function (array $a, array $b): int {
        return ($b['terisi'] <=> $a['terisi'])
            ?: strcmp($a['nama_kelas'], $b['nama_kelas']);
    });
    return $peringkat;
}
