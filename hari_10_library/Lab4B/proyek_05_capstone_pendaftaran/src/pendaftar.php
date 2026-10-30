<?php
declare(strict_types=1);

/** Ambil seluruh pilihan kelas untuk dropdown. */
function daftarKelas(PDO $pdo): array
{
    return $pdo->query('SELECT id, nama_kelas FROM kelas ORDER BY nama_kelas')->fetchAll();
}

/** Hitung seluruh hasil pencarian, berguna bagi paginasi. */
function hitungPendaftar(PDO $pdo, string $kata): int
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE nama LIKE :kata');
    $stmt->execute(['kata' => '%' . $kata . '%']);
    return (int) $stmt->fetchColumn();
}

/** Ambil satu halaman daftar pendaftar, dengan pencarian dan JOIN. */
function ambilPendaftar(PDO $pdo, string $kata, int $batas, int $offset): array
{
    $sql = 'SELECT p.id, p.nama, p.email, p.no_hp, k.nama_kelas
            FROM pendaftar p INNER JOIN kelas k ON k.id = p.kelas_id
            WHERE p.nama LIKE :kata
            ORDER BY p.id DESC LIMIT :batas OFFSET :offset';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':kata', '%' . $kata . '%', PDO::PARAM_STR);
    // Wajib integer karena LIMIT dan OFFSET memerlukan bilangan.
    $stmt->bindValue(':batas', $batas, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function ambilPendaftarById(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM pendaftar WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $baris = $stmt->fetch();
    return $baris === false ? null : $baris;
}

/** Pengecekan email, kecuali id pendaftar yang sedang diubah. */
function emailSudahAda(PDO $pdo, string $email, ?int $kecualiId): bool
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE email = :email AND id <> :id');
    $stmt->execute(['email' => $email, 'id' => $kecualiId ?? 0]);
    return (int) $stmt->fetchColumn() > 0;
}

function validasiPendaftar(array $input, PDO $pdo, ?int $idUbah): array
{
    // Is_string mencegah error ketika pengguna mengirim field berupa array.
    $nilai = static function (string $kunci) use ($input): string {
        return is_string($input[$kunci] ?? null) ? trim($input[$kunci]) : '';
    };
    $kelasInput = filter_var($input['kelas_id'] ?? null, FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]);
    $data = [
        'nama' => $nilai('nama'),
        'email' => strtolower($nilai('email')),
        'no_hp' => $nilai('no_hp'),
        'alamat' => $nilai('alamat'),
        'kelas_id' => $kelasInput === false || $kelasInput === null ? 0 : $kelasInput,
    ];
    $galat = [];

    $panjangNama = function_exists('mb_strlen') ? mb_strlen($data['nama'], 'UTF-8') : strlen($data['nama']);
    if ($panjangNama < 3 || $panjangNama > 100) {
        $galat['nama'] = 'Nama wajib 3–100 karakter.';
    }
    if (strlen($data['email']) > 150 || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $galat['email'] = 'Masukkan alamat email yang valid (maksimal 150 karakter).';
    } elseif (emailSudahAda($pdo, $data['email'], $idUbah)) {
        $galat['email'] = 'Email sudah terdaftar.';
    }
    if (!preg_match('/^08[0-9]{8,11}$/', $data['no_hp'])) {
        $galat['no_hp'] = 'Nomor HP harus diawali 08 dan berjumlah 10–13 digit.';
    }
    // Normalisasi integer dibutuhkan karena PDO dapat mengembalikan ID sebagai string.
    $idKelasValid = array_map('intval', array_column(daftarKelas($pdo), 'id'));
    if (!in_array($data['kelas_id'], $idKelasValid, true)) {
        $galat['kelas_id'] = 'Pilih kelas yang tersedia.';
    }
    if (strlen($data['alamat']) > 1000) {
        $galat['alamat'] = 'Alamat maksimal 1.000 karakter.';
    }
    return ['data' => $data, 'galat' => $galat];
}

function tambahPendaftar(PDO $pdo, array $d): bool
{
    $sql = 'INSERT INTO pendaftar (nama, email, no_hp, alamat, kelas_id)
            VALUES (:nama, :email, :no_hp, :alamat, :kelas_id)';
    return $pdo->prepare($sql)->execute($d);
}

function ubahPendaftar(PDO $pdo, int $id, array $d): bool
{
    $sql = 'UPDATE pendaftar SET nama = :nama, email = :email,
            no_hp = :no_hp, alamat = :alamat, kelas_id = :kelas_id WHERE id = :id';
    return $pdo->prepare($sql)->execute($d + ['id' => $id]);
}

function hapusPendaftar(PDO $pdo, int $id): bool
{
    return $pdo->prepare('DELETE FROM pendaftar WHERE id = :id')->execute(['id' => $id]);
}

function ambilSemuaPendaftar(PDO $pdo): array
{
    $sql = 'SELECT p.id, p.nama, p.email, p.no_hp,
                   p.tanggal_daftar AS tgl_daftar, k.nama_kelas
            FROM pendaftar p
            JOIN kelas k ON k.id = p.kelas_id
            ORDER BY p.id DESC';
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
