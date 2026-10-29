<?php
// Partial formulir yang dipakai tambah.php dan ubah.php.
// Variabel dari halaman: $lama, $galat, $kelas, $judul.
?>
<section class="panel form-panel">
    <!-- novalidate agar validasi server tetap terlihat saat uji form kosong. -->
    <form method="post" novalidate>
        <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">

        <label for="nama">Nama <span class="required">*</span></label>
        <input id="nama" name="nama" type="text" maxlength="100"
               value="<?= e($lama['nama']) ?>" aria-invalid="<?= isset($galat['nama']) ? 'true' : 'false' ?>">
        <?php if (isset($galat['nama'])): ?><p class="field-error" role="alert"><?= e($galat['nama']) ?></p><?php endif; ?>

        <label for="email">Email <span class="required">*</span></label>
        <input id="email" name="email" type="email" maxlength="150"
               value="<?= e($lama['email']) ?>" aria-invalid="<?= isset($galat['email']) ? 'true' : 'false' ?>">
        <?php if (isset($galat['email'])): ?><p class="field-error" role="alert"><?= e($galat['email']) ?></p><?php endif; ?>

        <label for="no_hp">No. HP <span class="required">*</span></label>
        <input id="no_hp" name="no_hp" type="tel" maxlength="13"
               value="<?= e($lama['no_hp']) ?>" placeholder="081234567890"
               aria-invalid="<?= isset($galat['no_hp']) ? 'true' : 'false' ?>">
        <?php if (isset($galat['no_hp'])): ?><p class="field-error" role="alert"><?= e($galat['no_hp']) ?></p><?php endif; ?>

        <label for="kelas_id">Kelas <span class="required">*</span></label>
        <select id="kelas_id" name="kelas_id" aria-invalid="<?= isset($galat['kelas_id']) ? 'true' : 'false' ?>">
            <option value="">-- Pilih kelas --</option>
            <?php foreach ($kelas as $k): ?>
                <option value="<?= (int) $k['id'] ?>"
                    <?= (int) $lama['kelas_id'] === (int) $k['id'] ? 'selected' : '' ?>><?= e($k['nama_kelas']) ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($galat['kelas_id'])): ?><p class="field-error" role="alert"><?= e($galat['kelas_id']) ?></p><?php endif; ?>

        <label for="alamat">Alamat (opsional)</label>
        <textarea id="alamat" name="alamat" rows="3" maxlength="1000"><?= e($lama['alamat']) ?></textarea>
        <?php if (isset($galat['alamat'])): ?><p class="field-error" role="alert"><?= e($galat['alamat']) ?></p><?php endif; ?>

        <div class="form-actions">
            <button class="button" type="submit">Simpan</button>
            <a class="button secondary" href="index.php">Batal</a>
        </div>
    </form>
</section>
