-- LAB 1: DATABASE DAN SQL
-- Langkah 1: buat basis data dan dua tabel yang saling berelasi.
-- Catatan: ini adalah skema contoh karena DDL 'T2' belum dilampirkan.
-- Jalankan file ini PERTAMA melalui tab Import di phpMyAdmin.

CREATE DATABASE IF NOT EXISTS db_pendaftaran_kursus
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE db_pendaftaran_kursus;

CREATE TABLE IF NOT EXISTS kelas (
  id_kelas INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nama_kelas VARCHAR(100) NOT NULL,
  deskripsi VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id_kelas)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pendaftar (
  id_pendaftar INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_kelas INT UNSIGNED NOT NULL,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  no_hp VARCHAR(20) NOT NULL,
  tanggal_daftar DATE NOT NULL,
  PRIMARY KEY (id_pendaftar),
  CONSTRAINT uq_pendaftar_email UNIQUE (email),
  CONSTRAINT fk_pendaftar_kelas
    FOREIGN KEY (id_kelas) REFERENCES kelas(id_kelas)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB;
