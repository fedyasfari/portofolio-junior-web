<?php
// Partial formulir: variabel yang dipersiapkan oleh tambah.php / ubah.php:
// $judulHalaman, $action, $data, $daftarKelas, $errors.
?>
<section class="panel form-panel">
    <form action="<?= e($action) ?>" method="post" novalidate>
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">

        <label for="nama">Nama lengkap <span class="required">*</span></label>
        <input id="nama" type="text" name="nama" maxlength="100" required
               value="<?= e($data['nama'] ?? '') ?>">
        <?php if (isset($errors['nama'])): ?><p class="field-error"><?= e($errors['nama']) ?></p><?php endif; ?>

        <label for="email">Email <span class="required">*</span></label>
        <input id="email" type="email" name="email" maxlength="150" required
               value="<?= e($data['email'] ?? '') ?>">
        <?php if (isset($errors['email'])): ?><p class="field-error"><?= e($errors['email']) ?></p><?php endif; ?>

        <label for="no_hp">Nomor HP <span class="required">*</span></label>
        <input id="no_hp" type="tel" name="no_hp" maxlength="20" required
               value="<?= e($data['no_hp'] ?? '') ?>">
        <?php if (isset($errors['no_hp'])): ?><p class="field-error"><?= e($errors['no_hp']) ?></p><?php endif; ?>

        <label for="id_kelas">Pilihan kelas <span class="required">*</span></label>
        <select id="id_kelas" name="id_kelas" required>
            <option value="">-- Pilih kelas --</option>
            <?php foreach ($daftarKelas as $kelas): ?>
                <option value="<?= (int) $kelas['id_kelas'] ?>"
                    <?= (string) ($data['id_kelas'] ?? '') === (string) $kelas['id_kelas'] ? 'selected' : '' ?>>
                    <?= e($kelas['nama_kelas']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['id_kelas'])): ?><p class="field-error"><?= e($errors['id_kelas']) ?></p><?php endif; ?>

        <label for="tanggal_daftar">Tanggal daftar <span class="required">*</span></label>
        <input id="tanggal_daftar" type="date" name="tanggal_daftar" required
               value="<?= e($data['tanggal_daftar'] ?? '') ?>">
        <?php if (isset($errors['tanggal_daftar'])): ?><p class="field-error"><?= e($errors['tanggal_daftar']) ?></p><?php endif; ?>

        <?php if (isset($errors['database'])): ?>
            <div class="alert error" role="alert"><?= e($errors['database']) ?></div>
        <?php endif; ?>
        <div class="form-actions">
            <button type="submit" class="button">Simpan</button>
            <a href="index.php" class="button secondary">Batal</a>
        </div>
    </form>
</section>
