@extends('admin.app')

@section('content')
<div class="container">
    <h2>Daftar Akun Staff</h2>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">Daftar Staff</h5>
        <a href="{{ route('staff.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Staff
        </a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <!-- Table Header -->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Site</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <!-- Table Body -->
            <tbody>
                @foreach ($staffs as $staff)
                <tr>
                    <td>{{ $staff->id }}</td>
                    <td>{{ $staff->name }}</td>
                    <td>{{ $staff->email }}</td>
                    <td>{{ $staff->site }}</td>
                    <td>
                        <a href="{{ route('staff.edit', $staff->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('staff.destroy', $staff->id) }}" method="POST" style="display:inline;"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus staff ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection