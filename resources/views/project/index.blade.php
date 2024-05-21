@extends('admin.app')

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
                <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Cari..." title="Type in a name">
                <a class="btn btn-outline-success form-control ml-2" href="{{ route('project.create') }}">Input Project</a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>Id Project</th>
                            <th>Nama Project</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                        <tr>
                            <td style="text-align: center">{{ $project->id }}</td>
                            <td style="text-align: center">{{ $project->nama_project }}</td>
                            <td class="flex justify-content-center">
                                <form action="{{ route('project.destroy', $project->id) }}" method="POST"
                                    class="d-flex justify-content-center">
                                    <a class="btn btn-primary btn-sm mr-2"
                                        href="{{ route('project.edit', $project->id) }}"><i
                                            class="fas fa-edit"></i>Edit</a>
                                    @csrf
                                    @method('DELETE')
                                  <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus Project ini?')">
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
<!-- /.container-fluid -->
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            if (tr[i].getElementsByTagName("th").length > 0) {
                continue; // Lewati baris yang berisi header
            }
            var found = false;
            td = tr[i].getElementsByTagName("td");
            for (var j = 0; j < td.length; j++) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break; // Hentikan loop jika ditemukan kecocokan
                }
            }
            tr[i].style.display = found ? "" : "none";
        }
    }
</script>