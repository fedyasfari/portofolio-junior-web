# Status pengujian yang dapat dipertanggungjawabkan

- Dijalankan oleh penyusun paket: `php -l` terhadap file PHP, dan `php tests/jalankan.php` (16/16 lolos) pada PHP CLI.
- Diperiksa secara statis: 6 masalah sumber Sprint 1 yang ada di T7.
- Tidak bisa dijalankan di lingkungan penyusun paket: PDO MySQL, Apache, database lokal XAMPP, login HTTP, 27 kasus T6 manual, dua request concurrent, dan cetak Dompdf.
- Alat dan hasil pada komputer peserta harus dicatat sendiri; jangan menandai LULUS berdasarkan ekspektasi.
