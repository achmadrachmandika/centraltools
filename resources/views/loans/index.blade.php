@extends('admin.app')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman Material Proyek</h6>
            <small class="text-muted">Halaman ini menampilkan data peminjaman material oleh proyek yang mengalami
                keterlambatan pengiriman.</small>
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
                        <th class="text-center">Nama Material</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan dimuat oleh Yajra DataTables secara server-side -->
                    {{-- @foreach($loans as $loan)
                    @foreach($loan->details as $detail)
                    <tr>
                        <td class="text-center">{{ optional($loan->peminjam)->nama_project }}</td>
                        <td class="text-center">{{ optional($loan->pemilik)->nama_project }}</td>
                        <td class="text-center">{{ optional($detail->projectMaterial->material)->nama }}</td>
                        <td class="text-center">{{ $detail->jumlah }}</td>
                        <td class="text-center">{{ $loan->tanggal_pinjam }}</td>
                        <td class="text-center">{{ ucfirst($loan->status) }}</td>
                        <td class="text-center">
                            @if($loan->status == 'dipinjam')
                            <form action="{{ route('loans.return', $loan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Kembalikan</button>
                            </form>
                            @else
                            <span class="badge badge-secondary">Sudah dikembalikan</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // $('#table-loans').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: '{{ route("loans.data") }}',
        //     columns: [
        //         { data: 'project_peminjam_name', name: 'project_peminjam_name', className: 'text-center' },
        //         { data: 'project_pemilik_name', name: 'project_pemilik_name', className: 'text-center' },
        //         { data: 'nama_material', name: 'nama_material', className: 'text-center' },
        //         { data: 'jumlah', name: 'jumlah', className: 'text-center' },
        //         { data: 'created_at', name: 'created_at', className: 'text-center' },
        //         { data: 'status', name: 'status', className: 'text-center' },
        //         { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' },
        //     ]
        // });
        $('#table-loans').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("loans.data") }}',
        columns: [
        { data: 'project_peminjam_name', name: 'project_peminjam_name' },
        { data: 'project_pemilik_name', name: 'project_pemilik_name' },
        { data: 'nama_material', name: 'nama_material' },
        { data: 'jumlah', name: 'jumlah' },
        { data: 'tanggal_pinjam', name: 'tanggal_pinjam' },
        { data: 'status', name: 'status' },
        { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
        });
    });
</script>
@endsection