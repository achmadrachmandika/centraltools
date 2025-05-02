@extends('admin.app')

@section('content')
<h2>Daftar Peminjaman Material Antar Proyek</h2>
<a href="{{ route('loans.create') }}" class="btn btn-primary mb-3">Tambah Peminjaman</a>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="myTable" class="table table-bordered table-striped">
                <thead class="thead-dark">
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
                    @foreach($loans as $loan)
                    <tr>
                        <td class="text-center">{{ $loan->project_peminjam_name }}</td>
                        <td class="text-center">{{ $loan->project_pemilik_name }}</td>
                        <td class="text-center">{{ $loan->nama_material }}</td>
                        <td class="text-center">{{ $loan->jumlah }}
                        </td>
                        <td class="text-center">{{ $loan->created_at }}</td>
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
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection