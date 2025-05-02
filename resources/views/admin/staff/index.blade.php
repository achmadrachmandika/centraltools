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
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Site</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <!-- Table Body -->
                <tbody>
                    @foreach ($staffs as $index => $staff)
                    <tr>
                        <td>{{ $index + 1 }}</td> <!-- Nomor urut -->
                        <td>{{ $staff->name }}</td>
                        <td>{{ $staff->email }}</td>
                        <td>{{ $staff->site }}</td>
                        <td>
                            <a href="{{ route('staff.edit', $staff->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <!-- Form Delete -->
                            <form id="deleteForm{{ $staff->id }}" action="{{ route('staff.destroy', $staff->id) }}"
                                method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm deleteButton" data-form-id="deleteForm{{ $staff->id }}">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
       $(document).on('click', '.deleteButton', function () {
            const formId = $(this).data('form-id');
            const form = $("#" + formId); // Ambil form berdasarkan ID yang disimpan di data-form-id
            
            Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data Staff akan dihapus secara permanen!",
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
</script>
@endsection

