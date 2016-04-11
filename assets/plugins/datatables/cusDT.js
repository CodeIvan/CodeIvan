function cusDT(id){
  $(id).DataTable({
    "columnDefs": [{
      "defaultContent": "-",
      "targets": "_all"
    }],
    "aLengthMenu": [[1, 2, 3, 4, 5], [1, 2, 3, 4, 5]],
    "pageLength": 3,
    "oLanguage": {
      "sLengthMenu": "Tampilkan _MENU_ data",
      "sSearch": "<span class='fa fa-fw fa-search'></span> Cari ",
      "sZeroRecords": "<center>Tidak ada data yang cocok.</center>",
      "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
      "sInfoEmpty": "Tidak ada data untuk ditampilkan",
      "sInfoFiltered": " (disaring dari _MAX_ data)",
      "sLoadingRecords": "Sedang memuat...",
      "sProcessing": "Sedang memproses...",
      "sEmptyTable": "Tak ada data yang tersedia pada tabel ini.",
      "oPaginate": {
        "sNext": "<span class='fa fa-fw fa-arrow-right'></span>",
        "sPrevious": "<span class='fa fa-fw fa-arrow-left'></span>",
        "sFirst": "Awal",
        "sLast": "Akhir"
      }
    }
  });
}
