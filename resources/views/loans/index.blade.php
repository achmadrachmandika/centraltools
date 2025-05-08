@extends('admin.app')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman Material Proyek</h6>
            <small class="text-muted">Halaman ini menampilkan data peminjaman material antar proyek.</small>
        </div>
        <div class="d-flex">
            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('staff'))
            <a class="btn btn-outline-success form-control ml-2" href="{{ route('loans.create') }}">Tambah Peminjaman</a>
            @endif
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="table-loans" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Peminjam</th>
                        <th class="text-center">Pemilik</th>
                        <th class="text-center">Kode Material</th>
                        <th class="text-center">Nama Material</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#table-loans').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("loans.data") }}',
            columns: [
                { data: 'project_peminjam_name', name: 'project_peminjam_name' },
                { data: 'project_pemilik_name', name: 'project_pemilik_name' },
                 { data: 'kode_material', name: 'kode_material' },
                { data: 'nama_material', name: 'nama_material' },
                { data: 'jumlah', name: 'jumlah' },
                { data: 'tanggal_pinjam', name: 'tanggal_pinjam' },
                { 
                    data: 'status', 
                    name: 'status',
                    render: function(data, type, row) {
                        if (data === 'dipinjam') {
                            return '<span class="badge badge-warning">Dipinjam</span>';
                        } else if (data === 'dikembalikan') {
                            return '<span class="badge badge-success">Dikembalikan</span>';
                        } else {
                            return '<span class="badge badge-secondary">' + data + '</span>';
                        }
                    }
                },
                { 
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false 
                }
            ]
        });
    });
</script>
@endsection