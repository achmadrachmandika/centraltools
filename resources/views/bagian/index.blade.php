@extends('admin.app')

@section('content')

<style>
    /* CSS untuk memberikan warna pada kolom Lokasi berdasarkan nilai */
    .lokasi-cell {
        padding: 10px;
        font-weight: bold;
        border-radius: 5px;
        color: white;
    }

    /* Warna khusus untuk setiap lokasi */
    .lokasi-fabrikasi {
        background-color: #4CAF50;
        /* Hijau untuk Fabrikasi */
    }

    .lokasi-finishing {
        background-color: #2196F3;
        /* Biru untuk Finishing */
    }

    /* Untuk lokasi lainnya, jika ada */
    .lokasi-default {
        background-color: black;
        /* Abu-abu untuk lokasi lainnya */
    }
</style>

<!-- Begin Page Content -->
<div class="container-fluid">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <div>
                <h6 class="m-0 font-weight-bold text-primary">Daftar lokasi Bagian </h6>
                <small class="text-muted">Halaman ini menampilkan daftar lokasi bagian dalam struktur penggunaan dan
                    subdivisinya.</small>
            </div>
            <div class="d-flex">
                <a class="btn form-control btn-outline-success ml-2" href="{{ route('bagian.create') }}">Input
                    Bagian</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="max-height: 530px !important">
                <table id="table-bagian" class="display">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Bagian</th>
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                     
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- Perhatikan pemindahan script jQuery dan DataTables ke bagian bawah sebelum script kustom -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
    // Menampilkan DataTables
    $('#table-bagian').DataTable({
        // data: [
        //     {
        //         id: 1
        //     }
        // ],
        processing: true,
        serverSide: true,
        ajax: "{{ route('bagian.data') }}",
       columns: [
    {
    data: 'DT_RowIndex',
    name: 'DT_RowIndex',
    orderable: false,
    searchable: false
    },
     
        { data: 'nama_bagian', name: 'nama_bagian' },
      
        {
        data: 'lokasi',
        name: 'lokasi',
        render: function(data, type, row) {
        let lokasiClass = 'lokasi-default';
        
        if (data.toLowerCase().includes('fabrikasi')) {
        lokasiClass = 'lokasi-fabrikasi';
        } else if (data.toLowerCase().includes('finishing')) {
        lokasiClass = 'lokasi-finishing';
        }
        
        return '<span class="lokasi-cell ' + lokasiClass + '">' + data + '</span>';
        }
        },
        {
        data: 'id',
        name: 'aksi',
        orderable: false,
        searchable: false,
        render: function(data, type, row) {
        return `
        <button class="btn btn-sm btn-danger deleteButton" data-id="${data}">
            <i class="fas fa-trash-alt"></i> Hapus
        </button>`;
        }
        }
        ]
    });

    // Menangani klik tombol Hapus
    $(document).on('click', '.deleteButton', function () {
        var bagianId = $(this).data('id');

        // SweetAlert konfirmasi untuk hapus
        Swal.fire({
            title: 'Hapus Bagian',
            text: "Apakah Anda yakin ingin menghapus bagian ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim request untuk menghapus bagian
                $.ajax({
                    url: '/bagian/' + bagianId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Hapus Berhasil', 'Bagian berhasil dihapus.', 'success');
                            $('#datatables').DataTable().ajax.reload(); // Reload DataTables
                        } else {
                            Swal.fire('Error', 'Terjadi kesalahan.', 'error');
                        }
                    }
                });
            }
        });
    });
});
</script>

<style>
    /* CSS untuk header tabel yang tetap pada posisinya */
    .sticky-header {
        position: sticky;
        top: 0;
        background-color: #444;
        z-index: 1;
    }

    /* Atur lebar kolom */
    #datatables th {
        width: auto !important;
    }
</style>
@endsection