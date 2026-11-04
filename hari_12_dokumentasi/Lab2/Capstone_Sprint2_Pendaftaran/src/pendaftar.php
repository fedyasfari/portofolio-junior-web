<?php
declare(strict_types=1);

/**
 * Mengambil semua kelas beserta kuota, jumlah peserta, dan kapasitas tersisa.
 *
 * @param PDO $pdo Koneksi database aktif.
 * @return list<array<string, mixed>> Daftar kelas dengan id, nama_kelas, kuota, terisi, sisa.
 * @throws PDOException Jika query daftar kelas gagal; periksa skema dan koneksi.
 */
function daftarKelas(PDO $pdo): array
{
    return $pdo->query('SELECT k.id, k.nama_kelas, k.kuota, COUNT(p.id) AS terisi,
          GREATEST(0, CAST(k.kuota AS SIGNED) - CAST(COUNT(p.id) AS SIGNED)) AS sisa
          FROM kelas k LEFT JOIN pendaftar p ON p.kelas_id = k.id
          GROUP BY k.id, k.nama_kelas, k.kuota ORDER BY k.nama_kelas')->fetchAll();
}
/**
 * Mengambil seluruh pendaftar beserta nama kelas, diurutkan dari ID terbaru.
 *
 * @param PDO $pdo Koneksi database aktif.
 * @return list<array<string, mixed>> Daftar peserta dengan alias tanggal tgl_daftar.
 * @throws PDOException Jika query peserta gagal; periksa skema dan koneksi.
 */
function ambilSemuaPendaftar(PDO $pdo): array
{
    // Skema Sprint 1 memakai tanggal_daftar, alias menjaga kompatibilitas Lab 4/5.
    $sql = 'SELECT p.id, p.nama, p.email, p.no_hp, p.tanggal_daftar AS tgl_daftar,
                   k.nama_kelas FROM pendaftar p JOIN kelas k ON k.id = p.kelas_id
            ORDER BY p.id DESC';
    return $pdo->query($sql)->fetchAll();
}
/**
 * Mencari peserta menurut nama atau email menggunakan parameter SQL terikat.
 *
 * @param PDO $pdo Koneksi database aktif.
 * @param string $cari Kata kunci; pencarian LIKE menambahkan wildcard di kedua sisi.
 * @return list<array<string, mixed>> Daftar peserta yang sesuai, atau daftar kosong.
 * @throws PDOException Jika pencarian database gagal; periksa koneksi dan log.
 */
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
/**
 * Mengambil identitas peserta dan kelas untuk isi bukti pendaftaran PDF.
 *
 * @param PDO $pdo Koneksi database aktif.
 * @param int $id ID peserta yang dicari, diharapkan minimal 1.
 * @return array<string, mixed>|null Data bukti, atau null bila peserta tidak ada.
 * @throws PDOException Jika query bukti gagal; periksa koneksi dan log.
 */
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
/**
 * Mengambil satu baris pendaftar berdasarkan ID, termasuk kelas_id dan alamat.
 *
 * @param PDO $pdo Koneksi database aktif.
 * @param int $id ID peserta (minimal 1; validasi dilakukan oleh pemanggil).
 * @return array<string, mixed>|null Data pendaftar atau null jika tidak ditemukan.
 * @throws PDOException Jika query gagal; periksa koneksi dan log.
 */
function ambilPendaftarById(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM pendaftar WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $hasil = $stmt->fetch();
    return $hasil === false ? null : $hasil;
}
/**
 * Memvalidasi formulir pendaftar, menormalkan data, dan mengembalikan galat per kolom.
 * Pemeriksaan email duplikat mengecualikan ID peserta yang sedang diubah.
 * Validasi ini belum menjamin kursi tersedia; kuota dicek di transaksi terpisah.
 *
 * @param array<string, mixed> $input Data mentah, biasanya $_POST (nama, email, no_hp, alamat, kelas_id).
 * @param PDO $pdo Koneksi untuk memeriksa kelas dan duplikasi email.
 * @param int|null $kecualiId ID peserta saat edit; null pada penambahan (nilai default).
 * @return array{data: array{nama: string, email: string, no_hp: string, alamat: string, kelas_id: int}, galat: array<string, string>} Data bersih dan galat; galat kosong jika valid.
 * @throws PDOException Jika pemeriksaan kelas atau email gagal; catat log dan tampilkan pesan umum.
 */
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
/**
 * Menyimpan peserta baru ke tabel pendaftar dan mengembalikan ID yang terbentuk.
 * Tidak mengecek kuota; panggil melalui daftarkanDenganKuota() dalam alur normal.
 *
 * @param PDO $pdo Koneksi database aktif.
 * @param array{nama: string, email: string, no_hp: string, alamat: string, kelas_id: int} $data Data pendaftar yang telah divalidasi.
 * @return int ID peserta baru dari lastInsertId().
 * @throws PDOException Jika INSERT gagal, misalnya email sudah digunakan; rollback transaksi lalu beri pesan aman.
 */
function tambahPendaftar(PDO $pdo, array $data): int
{
    $sql = 'INSERT INTO pendaftar (nama,email,no_hp,alamat,kelas_id)
            VALUES (:nama,:email,:no_hp,:alamat,:kelas_id)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
    return (int) $pdo->lastInsertId();
}
/**
 * Memperbarui identitas dan kelas seorang peserta berdasarkan ID.
 * Tidak mengecek kuota; gunakan ubahPendaftarDenganKuota() pada alur edit normal.
 *
 * @param PDO $pdo Koneksi database aktif.
 * @param int $id ID peserta yang diperbarui, seharusnya minimal 1.
 * @param array{nama: string, email: string, no_hp: string, alamat: string, kelas_id: int} $data Data hasil validasi.
 * @return void Tidak mengembalikan data atau jumlah baris yang diubah.
 * @throws PDOException Jika UPDATE gagal; rollback transaksi dan tampilkan pesan aman.
 */
function ubahPendaftar(PDO $pdo, int $id, array $data): void
{
    $sql = 'UPDATE pendaftar SET nama=:nama,email=:email,no_hp=:no_hp,
            alamat=:alamat,kelas_id=:kelas_id WHERE id=:id';
    $pdo->prepare($sql)->execute($data + ['id' => $id]);
}
/**
 * Menghapus baris pendaftar berdasarkan ID; endpoint wajib memeriksa izin dan CSRF.
 *
 * @param PDO $pdo Koneksi database aktif.
 * @param int $id ID peserta yang dihapus, seharusnya minimal 1.
 * @return void Tidak mengembalikan jumlah baris yang dihapus.
 * @throws PDOException Jika DELETE gagal; catat log dan tampilkan pesan aman.
 */
function hapusPendaftar(PDO $pdo, int $id): void
{
    $pdo->prepare('DELETE FROM pendaftar WHERE id=:id')->execute(['id'=>$id]);
}
