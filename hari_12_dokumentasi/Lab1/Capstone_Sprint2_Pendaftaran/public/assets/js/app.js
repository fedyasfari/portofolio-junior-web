document.addEventListener('DOMContentLoaded', () => {
  // SweetAlert2 untuk flash; jika CDN tidak tersedia, alert Bootstrap tetap ada.
  const flash = document.getElementById('flash');
  if (flash && window.Swal) {
    flash.hidden = true;
    const kind = flash.dataset.tipe === 'danger' ? 'error' : (flash.dataset.tipe || 'info');
    window.Swal.fire({
      toast: true, position: 'top-end', icon: kind,
      title: flash.dataset.pesan || flash.textContent.trim(),
      timer: 3000, timerProgressBar: true, showConfirmButton: false,
    });
  }

  // Delegasi event menghindari kehilangan event saat DataTables redraw.
  document.addEventListener('submit', (event) => {
    const form = event.target;
    if (!(form instanceof HTMLFormElement) || !form.matches('.form-hapus')) return;
    const konfirmasi = form.querySelector('input[name="konfirmasi"]');
    // Jika tidak ada JS, server menolak nilai 0. Jangan hilangkan CSRF.
    event.preventDefault();
    if (!konfirmasi) return;
    const nama = form.dataset.nama || 'ini';
    const kirim = () => { konfirmasi.value = '1'; form.submit(); };
    if (window.Swal) {
      window.Swal.fire({
        title: 'Hapus data?', text: `Data ${nama} akan dihapus permanen.`,
        icon: 'warning', showCancelButton: true,
        confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal',
        focusCancel: true, reverseButtons: true,
      }).then((hasil) => { if (hasil.isConfirmed) kirim(); });
    } else if (window.confirm(`Data ${nama} akan dihapus permanen. Lanjutkan?`)) {
      kirim();
    }
  });

  const tabel = document.getElementById('tabelPendaftar');
  if (!tabel) return;
  if (window.jQuery?.fn && typeof window.jQuery.fn.DataTable === 'function') {
    window.jQuery(tabel).DataTable({
      pageLength: 10,
      order: [], // hormati ORDER BY p.id DESC dari SQL
      language: {
        search: 'Cari:', lengthMenu: 'Tampilkan _MENU_ entri',
        info: 'Menampilkan _START_–_END_ dari _TOTAL_ peserta',
        infoEmpty: 'Belum ada peserta',
        zeroRecords: 'Tidak ditemukan data yang sesuai',
        emptyTable: 'Belum ada pendaftar',
        paginate: { first: 'Awal', previous: 'Sebelumnya', next: 'Berikutnya', last: 'Akhir' },
      },
      columnDefs: [{ targets: -1, orderable: false, searchable: false }],
    });
  } else {
    console.warn('DataTables belum dimuat: periksa CDN dan urutan library di footer.php.');
  }
});
