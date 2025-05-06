@extends('admin.app')

@section('title', 'Daftar Project')

@section('content')

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
                <h6 class="m-0 font-weight-bold text-primary">Daftar Proyek</h6>
                <small class="text-muted">
                    Halaman ini menyajikan informasi terkait daftar proyek yang sedang dikerjakan.
                </small>
            </div>
            <div class="d-flex">
                <input type="text" class="form-control" id="myInput" placeholder="Cari..." title="Type in a name">
                <a class="btn btn-outline-success ml-2" href="{{ route('project.create') }}">Input Project</a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="table-project" class="display">
                       <thead>
                        <tr>
                            <th class="text-center">ID Project</th>
                            <th class="text-center">Nama Project</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($projects as $project)
                        <tr>
                            <td class="text-center">{{ $project->ID_Project }}</td>
                            <td class="text-center">{{ $project->nama_project }}</td>
                            <td class="text-center d-flex justify-content-center">
                                <a class="btn btn-primary btn-sm mr-2" href="{{ route('project.edit', $project->id) }}">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('project.destroy', $project->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus Project ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm deleteButton">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#table-project').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('project.data') }}",
           columns: [
            { data: 'ID_Project', name: 'ID_Project', className: 'text-center' },
            { data: 'nama_project', name: 'nama_project', className: 'text-center' },
            {
            data: 'id',
            name: 'aksi',
            orderable: false,
            searchable: false,
            className: 'text-center',
            render: function(data, type, row) {
            return `
            <a class="btn btn-sm btn-primary mr-1" href="/project/${data}/edit">
                <i class="fas fa-edit"></i> Edit
            </a>
            <button class="btn btn-sm btn-danger deleteButton" data-id="${data}">
                <i class="fas fa-trash-alt"></i> Hapus
            </button>
            `;
            }
            }
            ]
        });

        // SweetAlert untuk tombol delete
        $(document).on('click', '.deleteButton', function () {
            const formId = $(this).data('form-id');
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
                    $('#' + formId).submit();
                }
            });
        });
    });
</script>

<script>
    document.getElementById("myInput").addEventListener("keyup", function() {
        var filter = this.value.toUpperCase();
        var rows = document.querySelectorAll("#myTable tbody tr");

        rows.forEach(function(row) {
            var found = false;
            row.querySelectorAll("td").forEach(function(cell) {
                if (cell.textContent.toUpperCase().includes(filter)) {
                    found = true;
                }
            });
            row.style.display = found ? "" : "none";
        });
    });
</script>
@endsection