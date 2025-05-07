@extends('admin.app')

@section('content')
<style>
    .form-modern {
        display: flex;
        gap: 1rem;
        align-items: center;
        font-family: 'Segoe UI', sans-serif;
    }

    .dropdown-modern {
        position: relative;
    }

    .dropdown-toggle-modern {
        padding: 10px 16px;
        border: 2px solid #d1d5db;
        border-radius: 10px;
        background-color: white;
        cursor: pointer;
        font-weight: 500;
        display: flex;
        align-items: center;
        transition: 0.3s ease;
    }

    .dropdown-toggle-modern:hover {
        background-color: #f3f4f6;
        border-color: #9ca3af;
    }

    .dropdown-menu-modern {
        display: none;
        position: absolute;
        background-color: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.06);
        margin-top: 5px;
        z-index: 1000;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
        font-size: 0.95rem;
    }

    .dropdown-item input[type="checkbox"] {
        accent-color: #10b981;
    }

    .btn-modern {
        padding: 10px 16px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        transition: 0.3s ease;
    }

    .btn-success-modern {
        background-color: #10b981;
        color: white;
    }

    .btn-success-modern:hover {
        background-color: #059669;
    }

    .btn-info-modern {
        background-color: #3b82f6;
        color: white;
    }

    .btn-info-modern:hover {
        background-color: #2563eb;
    }
    mark.red-highlight {
        background-color: #f8d7da;
        color: #721c24;
        font-weight: bold;
        padding: 0 4px;
        border-radius: 4px;
        }
        .preview-image {
                width: 100px;
                height: auto;
                cursor: pointer;
                transition: transform 0.2s;
                border-radius: 4px;
                }
                
                .preview-image:hover {
                transform: scale(1.05);
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
                }

        .sticky-header {
        position: sticky;
        top: 0;
        background-color: white;
        /* Warna latar belakang judul tabel */
        z-index: 1;
        /* Pastikan judul tabel tetap di atas konten tabel */
        }
        
        #myTable th {
        width: auto !important;
        }
</style>
<title>PPA|Material|CENTRAL TOOLS</title>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- CSS -->


<!-- Begin Page Content -->
<div class="container-fluid">
   @if(session('success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Card Container -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <div>
                <h6 class="m-0 font-weight-bold text-primary">List Material Finishing</h6>
                <small class="text-muted">Halaman ini menampilkan data stok material untuk lokasi finishing, <br>mencakup semua material
                    yang telah dicatat dalam sistem pada tiap proyek di <mark class="red-highlight">lokasi finishing</mark>.</small>
            </div>
            <div class="d-flex">

                @if(Auth::user()->hasRole('admin') || (Auth::user()->hasRole('staff')))
                <a class="btn btn-outline-success form-control ml-2" href="{{ route('stok_material.create') }}">Input
                    Material</a>
                @endif
            </div>
        </div>
    <div class="card-body">
        <div class="row" style="margin-bottom:15px">
            <div class="col">
                <label for="filter-status" class="mr-2 mb-0">Status:</label>
                <select class="form-control" id="filter-status" style="max-width: 200px;">
                    <option value="">Semua</option>
                    @foreach($daftarStatus as $status)
                    <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>
            </div>
    
            <div class="col-md-6 text-md-right mt-2 mt-md-0">
                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('staff'))
                <button onclick="ExportToExcel('xlsx')" class="btn btn-info">
                    <i class="fas fa-file-excel"></i> Ekspor
                </button>
                @endif
            </div>
        </div>
    </div>
       <div class="card-body">
        <div class="col">
            <div class="table-responsive" style="max-height:500px; overflow-y:auto; padding-bottom:50px;">
                <table id="table-finishing" class="display">
                    <thead class="text-center sticky-header">
                        <tr>
                            <th>Kode Material</th>
                            <th>Nama Material</th>
                            <th>Spesifikasi</th>
                            <th>Foto</th>
                            <th>Stok</th>
                            @foreach($tabelProjects as $project)
                            <th>{{ $project }}</th>
                            @endforeach
                            <th>Satuan</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            @if(Auth::user()->hasRole('admin') || (Auth::user()->hasRole('staff')))
                            <th class="text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
  <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image View</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
    <!-- End Card Container -->


<!-- /.container-fluid -->
<!-- Bootstrap core JavaScript-->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<!-- 2. Tambahkan JavaScript untuk DataTables Responsive -->
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<!-- 3. Script DataTable dengan konfigurasi responsif yang optimal -->
<script>
    $(document).ready(function() {
        // Inisialisasi DataTable dengan konfigurasi responsif
        var table = $('#table-finishing').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('stok_material-finishing.data') }}",
                data: function (d) {
                    d.status = $('#filter-status').val();
                }
            },
            
            columnDefs: [
                // Kolom expand/collapse untuk tampilan mobile
                {
                    className: 'dtr-control',
                    orderable: false,
                    targets: 0
                },
                // Prioritas kolom (yang lebih rendah akan dihilangkan lebih dahulu saat responsif)
                { responsivePriority: 1, targets: 0 }, // Kode material
                { responsivePriority: 2, targets: 1 }, // Nama
                { responsivePriority: 3, targets: 4 }, // Jumlah
                { responsivePriority: 10, targets: 2 }, // Spek (prioritas rendah)
                { responsivePriority: 10, targets: 3 }, // Foto (prioritas rendah)
                
                // Konfigurasi kolom gambar
                {
                    targets: 3, // Kolom foto (sesuaikan indeks jika diperlukan)
                    className: 'text-center',
                    width: '100px'
                }
            ],
            columns: [
                { data: 'kode_material', name: 'kode_material' },
                { data: 'nama', name: 'nama' },
                { data: 'spek', name: 'spek' },
                {
                   data: 'foto',
                name: 'foto',
                orderable: false,
                searchable: false,
                render: function (data, type, full, meta) {
                if (data) {
                return `<img src="/storage/material/${data}" alt="${full.nama}" class="preview-image" data-toggle="modal"
                    data-target="#imageModal" data-image="/storage/material/${data}" data-title="${full.nama}">`;
                } else {
                return `<span class="text-muted">Tidak Ada Foto</span>`;
                        }
                    }
                },
                {
                    data: 'jumlah',
                    name: 'jumlah',
                    className: 'text-center',
                    render: function (data) {
                        return data < 0 ? `<strong class="text-danger">${data}</strong>` : `<strong>${data}</strong>`;
                    }
                },
                @foreach($tabelProjects as $project)
                {
                    data: 'material_{{ $project }}',
                    name: 'material_{{ $project }}',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                @endforeach
                { data: 'satuan', name: 'satuan' },
                { data: 'lokasi', name: 'lokasi' },
                { data: 'status', name: 'status' },
                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('staff'))
                {
                    data: 'id',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `
                        <div class="btn-group btn-group-sm">
                            <a class="btn btn-primary" href="/stok_material/${data}/edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger deleteButton" data-id="${data}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>`;
                    }
                }
                @endif
            ],
            // Konfigurasi tambahan
            autoWidth: false,     // Mencegah perhitungan otomatis lebar kolom
            scrollX: true,        // Scroll horizontal jika diperlukan
            scrollCollapse: true, // Collapse scroll saat tidak diperlukan
            // language: {
            //     processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
            //     search: "Cari:",
            //     lengthMenu: "Tampilkan _MENU_ data",
            //     info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
            //     infoEmpty: "Tidak ada data yang ditampilkan",
            //     infoFiltered: "(difilter dari _MAX_ total data)",
            //     zeroRecords: "Tidak ada data yang cocok",
            //     paginate: {
            //         first: "Awal",
            //         last: "Akhir",
            //         next: "&raquo;",
            //         previous: "&laquo;"
            //     }
            // }
        });

        // Event filter
        $('#filter-status').change(function() {
            table.draw(); // reload table saat filter berubah
        });

        // Event delegation untuk tombol delete
        $(document).on('click', '.deleteButton', function () {
            const id = $(this).data('id');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim request AJAX untuk delete
                    $.ajax({
                    url: `/stok_material/${id}`,
                    type: 'DELETE',
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                    // Periksa apakah respons adalah JSON valid
                    if (response.success !== undefined) {
                    Swal.fire(
                    'Terhapus!',
                    response.message || 'Data berhasil dihapus.',
                    'success'
                    );
                    } else {
                    // Jika respons bukan JSON yang diharapkan
                    console.log('Respons tidak valid:', response);
                    Swal.fire(
                    'Terhapus!',
                    'Data berhasil dihapus, tetapi respons tidak sesuai format.',
                    'success'
                    );
                    }
                    table.ajax.reload();
                    },
                    error: function(xhr, status, error) {
                    console.log('Error:', xhr, status, error);
                    Swal.fire(
                    'Gagal!',
                    'Terjadi kesalahan saat menghapus data.',
                    'error'
                    );
                    },
                    complete: function() {
                    // Reload datatable setelah operasi selesai
                    table.ajax.reload();
                    }
                    });
                }
            });
        });
    });
</script>

{{-- <script>
    // Pastikan SweetAlert dan DataTable terload dengan benar
    $(document).ready(function() {
        // Inisialisasi DataTable
        var table = $('#table-finishing').DataTable({
            processing: true,
            serverSide: true,
           ajax: {
            url: "{{ route('stok_material-finishing.data') }}",
            data: function (d) {
            d.status = $('#filter-status').val(); // ambil nilai dari select
            },
            },
            columnDefs: [
            // Kolom expand/collapse untuk tampilan mobile
            {
            className: 'dtr-control',
            orderable: false,
            targets: 0
            },
            // Prioritas kolom (yang lebih rendah akan dihilangkan lebih dahulu saat responsif)
            { responsivePriority: 1, targets: 0 }, // Kode material
            { responsivePriority: 2, targets: 1 }, // Nama
            { responsivePriority: 3, targets: 4 }, // Jumlah
            { responsivePriority: 10, targets: 2 }, // Spek (prioritas rendah)
            { responsivePriority: 10, targets: 3 }, // Foto (prioritas rendah)
            
            // Konfigurasi kolom gambar
            {
            targets: 3, // Kolom foto (sesuaikan indeks jika diperlukan)
            className: 'text-center',
            width: '100px'
            }
            ],
            columns: [
            { data: 'kode_material', name: 'kode_material' },
            { data: 'nama', name: 'nama' },
            { data: 'spek', name: 'spek' },
            {
            data: 'foto',
            name: 'foto',
            orderable: false,
            searchable: false,
            render: function (data, type, full, meta) {
           if (data) {
        return `<img src="/storage/material/${data}" alt="${full.nama}" class="preview-image" data-toggle="modal"
            data-target="#imageModal" data-image="/storage/material/${data}" data-title="${full.nama}">`;
        } else {
        return `<span class="text-muted">Tidak Ada Foto</span>`;
            }
            }
            },
            {
            data: 'jumlah',
            name: 'jumlah',
            className: 'text-center',
            render: function (data) {
            return data < 0 ? `<strong style="color:red;">${data}</strong>` : `<strong>${data}</strong>`;
                }
                },
                @foreach($tabelProjects as $project)
                {
                data: 'material_{{ $project }}',
                name: 'material_{{ $project }}',
                orderable: false,
                searchable: false,
                className: 'text-center'
                },
                @endforeach
                { data: 'satuan', name: 'satuan' },
                { data: 'lokasi', name: 'lokasi' },
                { data: 'status', name: 'status' },
                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('staff'))
            
                {
                data: 'id',
                name: 'aksi',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                return `
                <a class="btn btn-sm btn-primary mr-1" href="/stok_material/${data}/edit">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <button class="btn btn-sm btn-danger deleteButton" data-id="${data}">
                    <i class="fas fa-trash-alt"></i> Hapus
                </button>
                `;
                }
                }
                @endif
                ],
                });

                $('#filter-status').change(function() {
                table.draw(); // reload table saat filter berubah
                });

        // Event delegation untuk tombol delete
        $(document).on('click', '.deleteButton', function () {
            const formId = $(this).data('form-id');
            const form = $("#" + formId); // Ambil form berdasarkan ID yang disimpan di data-form-id

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit form jika konfirmasi berhasil
                }
            });
        });
    });
</script> --}}


<script>
    function ExportToExcel(type, dl) {
       var elt = document.getElementById('table-finishing');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1", autoSize: true });

       // Mendapatkan tanggal saat ini
       var currentDate = new Date();
       var dateString = currentDate.toISOString().slice(0,10);

       // Gabungkan tanggal dengan nama file
       var fileName = 'Data Material Central Tools ' + dateString + '.' + (type || 'xlsx');

       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fileName);
    }
</script>

<script>
    $(document).ready(function() {
    // Event handler untuk modal
    $('#imageModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Tombol yang memicu modal
        var imageUrl = button.data('image');  // Ambil URL gambar
        var imageTitle = button.data('title'); // Ambil judul gambar
        
        var modal = $(this);
        modal.find('.modal-title').text(imageTitle); // Set judul modal
        modal.find('#modalImage').attr('src', imageUrl); // Set source gambar
        modal.find('#modalImage').attr('alt', imageTitle); // Set alt text gambar
    });
});
</script>


@endsection