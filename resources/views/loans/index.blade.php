@extends('admin.app')

@section('content')
<h2>Daftar Peminjaman Material Antar Proyek</h2>
<a href="{{ route('loans.create') }}">Tambah Peminjaman</a>

    <div class="card-body">
        <div class="table-responsive">
            <table id="myTable" class="display">
                <thead>
        <tr>
            <th>Peminjam</th>
            <th>Pemilik</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($loans as $loan)
        <tr>
            <td class="text-center">{{ $loan->peminjam->nama_project }}</td>
             <td class="text-center">{{ $loan->pemilik->nama_project }}</td>
             <td class="text-center">{{ $loan->tanggal_pinjam }}</td>
             <td class="text-center">{{ $loan->status }}</td>
            <td>
                @if($loan->status == 'dipinjam')
                <form action="{{ route('loans.return', $loan->id) }}" method="POST">
                    @csrf
                    <button type="submit">Kembalikan</button>
                </form>
                @else
                Sudah dikembalikan
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>
    </div>
    </div>
</table>
@endsection