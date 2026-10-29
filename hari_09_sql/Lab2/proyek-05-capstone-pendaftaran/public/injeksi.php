<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';

// KEAMANAN: DEMO RAW SQL SENGAJA TIDAK AMAN.
// Hanya akses dari browser di komputer itu sendiri (127.0.0.1 / ::1).
if (!in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true)) {
    http_response_code(403);
    exit('Halaman demonstrasi hanya boleh dibuka dari localhost.');
}

$judulHalaman = 'Demonstrasi SQL Injection';
$email = isset($_GET['email']) && is_string($_GET['email'])
    ? substr($_GET['email'], 0, 300)
    : 'andi@example.com';

$hasilBerbahaya = [];
$hasilAman = [];
$errorBerbahaya = null;
$errorHalaman = null;
$sqlBerbahaya = '';

try {
    $pdo = getConnection();

    // VERSI BERBAHAYA. JANGAN TIRU PADA APLIKASI ASLI!
    $sqlBerbahaya = "SELECT id_pendaftar, nama, email FROM pendaftar WHERE email = '$email' ORDER BY id_pendaftar";
    try {
        $hasilBerbahaya = $pdo->query($sqlBerbahaya)->fetchAll();
    } catch (PDOException $error) {
        $errorBerbahaya = 'Query gagal: ' . $error->getMessage();
    }

    // VERSI AMAN. Nilai email adalah data, BUKAN bagian sintaks SQL.
    $stmt = $pdo->prepare(
        'SELECT id_pendaftar, nama, email FROM pendaftar WHERE email = :email ORDER BY id_pendaftar'
    );
    $stmt->execute(['email' => $email]);
    $hasilAman = $stmt->fetchAll();
} catch (Throwable $error) {
    error_log($error->getMessage());
    $errorHalaman = 'Database tidak tersedia. Jalankan MySQL dan impor database/skema.sql.';
}

require __DIR__ . '/../templates/header.php';
?>
<div class="page-heading">
    <div><p class="eyebrow">DEMONSTRASI LOKAL</p><h1>SQL Injection: Rentan vs Aman</h1>
        <p class="muted">Bandingkan query gabungan string dengan prepared statement PDO.</p></div>
</div>
<div class="alert warning"><strong>Peringatan:</strong> kode berbahaya di sini hanya untuk simulasi pada data contoh di komputer sendiri. Jangan unggah halaman ini ke server publik.</div>
<?php if ($errorHalaman !== null): ?>
    <div class="alert error"><?= e($errorHalaman) ?></div>
<?php else: ?>
    <section class="panel">
        <form method="get" action="injeksi.php">
            <label for="email">Nilai parameter email</label>
            <div class="inline-form">
                <input id="email" name="email" type="text" value="<?= e($email) ?>">
                <button class="button" type="submit">Bandingkan</button>
            </div>
        </form>
        <p class="small">Tes normal: <a href="injeksi.php?email=andi%40example.com">andi@example.com</a> &nbsp; · &nbsp;
        Tes injeksi: <a href="injeksi.php?email=x%27%20OR%20%271%27%3D%271"><code>x' OR '1'='1</code></a></p>
    </section>
    <div class="compare">
        <section class="panel">
            <h2 class="bad-title">Versi Berbahaya (raw SQL)</h2>
            <pre><code><?= e($sqlBerbahaya) ?></code></pre>
            <?php if ($errorBerbahaya !== null): ?><p class="field-error"><?= e($errorBerbahaya) ?></p><?php endif; ?>
            <p>Jumlah hasil: <strong><?= count($hasilBerbahaya) ?></strong></p>
            <div class="table-wrap">
            <table><thead><tr><th>ID</th><th>Nama</th><th>Email</th></tr></thead><tbody>
                <?php if ($hasilBerbahaya === []): ?><tr><td colspan="3">Tidak ditemukan.</td></tr><?php endif; ?>
                <?php foreach ($hasilBerbahaya as $item): ?>
                    <tr><td><?= (int) $item['id_pendaftar'] ?></td><td><?= e($item['nama']) ?></td><td><?= e($item['email']) ?></td></tr>
                <?php endforeach; ?>
            </tbody></table>
            </div>
        </section>
        <section class="panel">
            <h2 class="good-title">Versi Aman (prepared statement)</h2>
            <pre><code>SELECT id_pendaftar, nama, email
FROM pendaftar
WHERE email = :email</code></pre>
            <p>Jumlah hasil: <strong><?= count($hasilAman) ?></strong></p>
            <div class="table-wrap">
            <table><thead><tr><th>ID</th><th>Nama</th><th>Email</th></tr></thead><tbody>
                <?php if ($hasilAman === []): ?><tr><td colspan="3">Tidak ditemukan.</td></tr><?php endif; ?>
                <?php foreach ($hasilAman as $item): ?>
                    <tr><td><?= (int) $item['id_pendaftar'] ?></td><td><?= e($item['nama']) ?></td><td><?= e($item['email']) ?></td></tr>
                <?php endforeach; ?>
            </tbody></table>
            </div>
        </section>
    </div>
    <section class="panel">
        <h2>Mengapa hasilnya berbeda?</h2>
        <p>Versi rentan menyisipkan masukan ke teks SQL. Masukan <code>x' OR '1'='1</code>
        membuat kondisi <code>OR '1'='1'</code> bernilai benar untuk setiap baris.
        Versi aman menggunakan <code>prepare()</code> dan <code>execute()</code>, sehingga seluruh nilai tersebut
        diperlakukan sebagai <strong>satu string email</strong>, bukan sebagai perintah SQL.</p>
    </section>
<?php endif; ?>
<?php require __DIR__ . '/../templates/footer.php'; ?>
