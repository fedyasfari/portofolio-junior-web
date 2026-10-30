// Lab 4: DataTables + Lab 3: SweetAlert2.
// File digunakan di seluruh halaman (Daftar, Tambah, Ubah).
document.addEventListener('DOMContentLoaded', () => {
  // Flash PHP -> toast sukses. Jika SweetAlert2 gagal, alert HTML tetap terlihat.
  const flash = document.getElementById('flash');
  if (flash && typeof window.Swal !== 'undefined') {
    flash.hidden = true;
    window.Swal.fire({
      toast: true,
      position: 'top-end',
      icon: 'success',
      title: flash.dataset.pesan || flash.textContent.trim(),
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
    });
  }

  // Event delegation: bekerja juga jika DataTables menggambar ulang isi tabel.
  document.addEventListener('submit', (event) => {
    const form = event.target;
    if (!(form instanceof HTMLFormElement) || !form.classList.contains('form-hapus')) {
      return;
    }
    const nama = form.dataset.nama || 'ini';

    if (typeof window.Swal === 'undefined') {
      if (!window.confirm(`Data ${nama} akan dihapus permanen. Lanjutkan?`)) {
        event.preventDefault();
      }
      return;
    }

    event.preventDefault();
    window.Swal.fire({
      title: 'Hapus data?',
      text: `Data ${nama} akan dihapus permanen.`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal',
      confirmButtonColor: '#d33',
      focusCancel: true,
      reverseButtons: true,
    }).then((hasil) => {
      if (hasil.isConfirmed) {
        // Form POST tetap membawa id + token CSRF, divalidasi PHP di hapus.php.
        form.submit();
      }
    });
  });

  const tabel = document.getElementById('tabelPendaftar');
  if (!tabel) return; // Halaman Tambah dan Ubah tidak memiliki tabel.

  if (
    window.jQuery && window.jQuery.fn &&
    typeof window.jQuery.fn.DataTable === 'function'
  ) {
    window.jQuery(tabel).DataTable({
      pageLength: 10,
      // SQL sudah mengurutkan berdasarkan ID menurun. Jangan sort Nama saat pertama dimuat.
      order: [],
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json',
      },
      columnDefs: [{ orderable: false, searchable: false, targets: -1 }],
    });
  } else {
    console.warn('DataTables belum termuat. Periksa koneksi/CDN dan urutan JS pada footer.php.');
  }
});
