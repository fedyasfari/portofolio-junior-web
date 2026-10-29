-- MIGRASI KHUSUS dari skema LAB 2 yang memakai id_pendaftar dan id_kelas.
-- Mempertahankan data lama, mengubah nama kolom, dan menambah alamat.
-- Jalankan HANYA SATU KALI pada db_pelatihan versi Lab 2.
-- Buat backup dulu lewat phpMyAdmin > Export > Quick > SQL.
-- Jangan jalankan jika skema sudah memakai id dan kelas_id.
USE db_pelatihan;

ALTER TABLE pendaftar DROP FOREIGN KEY fk_pendaftar_kelas;

ALTER TABLE kelas
    CHANGE COLUMN id_kelas id INT NOT NULL AUTO_INCREMENT;

ALTER TABLE pendaftar
    CHANGE COLUMN id_pendaftar id INT NOT NULL AUTO_INCREMENT,
    CHANGE COLUMN id_kelas kelas_id INT NOT NULL,
    ADD COLUMN alamat TEXT NULL AFTER no_hp,
    MODIFY COLUMN tanggal_daftar DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE pendaftar
    ADD CONSTRAINT fk_pendaftar_kelas
        FOREIGN KEY (kelas_id) REFERENCES kelas(id)
        ON DELETE RESTRICT ON UPDATE CASCADE;
