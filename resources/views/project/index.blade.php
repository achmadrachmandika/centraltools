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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Project</h6>
            <div class="d-flex">
                <input type="text" class="form-control" id="myInput" placeholder="Cari..." title="Type in a name">
                <a class="btn btn-outline-success ml-2" href="{{ route('project.create') }}">Input Project</a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>ID Project</th>
                            <th>Nama Project</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                        <tr class="text-center">
                            <td>{{ $project->ID_Project }}</td>
                            <td>{{ $project->nama_project }}</td>
                            <td class="d-flex justify-content-center">
                                <a class="btn btn-primary btn-sm mr-2" href="{{ route('project.edit', $project->id) }}">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('project.destroy', $project->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus Project ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
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
</div>
@endsection

@push('scripts')
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
@endpush