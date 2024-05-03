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
            <h6 class="m-0 font-weight-bold text-primary">BON PERMINTAAN MATERIAL</h6>
            <div class="d-flex">
                <input type="text" id="myInput" class="form-control" placeholder="Cari..." onkeyup="myFunction()"
                    title="Ketikkan sesuatu untuk mencari">
                <a class="btn form-control btn-outline-success ml-2" href="{{ route('bpms.create') }}">Input BPM</a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Nomor BPM</th>
                            <th>Project</th>
                            <th>Tanggal Permintaan</th>
                            <th>Daftar Material</th>
                        </tr>
                    </thead>
                <tbody>
                    @foreach ($bpms as $bpm)
                    <tr>
                        <td>{{ $bpm->id }}</td>
                        <td>{{ $bpm->no_bpm }}</td>
                        <td>{{ $bpm->project }}</td>
                        <td>{{ $bpm->tgl_permintaan }}</td>
                        <td class="text-center">
                            <a class="btn btn-info btn-sm mr-2" href="{{ route('bpm.show', $bpm->id) }}"><i
                                    class="fas fa-eye"></i> Lihat</a>
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

<script>
    function confirmDelete(bpmId) {
        if (confirm("Apakah Anda yakin ingin menghapus BPM dengan ID " + bpmId + "?")) {
            document.getElementById('deleteForm' + bpmId).submit();
        }
    }
</script>

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