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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Bill Of Material</h6>
            <div class="d-flex">
            <input type="text" id="myInput" class="form-control" placeholder="Cari..." onkeyup="myFunction()"
                title="Ketikkan sesuatu untuk mencari">
            <a class="btn btn-sm btn-outline-success" href="{{ route('bom.create') }}">Input BOM</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nomor BOM</th>
                            <th>Project</th>
                            <th>Tanggal Permintaan</th>
                            <th>Keterangan</th>
                            <th>Daftar Material</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($boms as $bom)
                        <tr>
                            <td>{{ $bom->nomor_bom }}</td>
                            <td>{{ $bom->project }}</td>
                            <td>{{ $bom->tgl_permintaan }}</td>
                            <td>{{ $bom->keterangan }}</td>
                            <td class="text-center">
                                <a href="{{ route('bom.show', $bom->nomor_bom) }}" class="btn btn-info btn-sm mr-2">
                                    <i class="fas fa-eye mr-1"></i> Lihat
                                </a>
                            </td>
                            <td class="text-center">
                                <form id="deleteForm{{ $bom->nomor_bom }}" action="{{ route('bom.destroy', $bom->nomor_bom) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('bom.edit', $bom->nomor_bom) }}" class="btn btn-primary btn-sm mr-2">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i>Hapus</button>
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

<script>
    function confirmDelete(nomorBOM) {
            if (confirm("Apakah Anda yakin ingin menghapus BOM dengan nomor " + nomorBOM + "?")) {
                document.getElementById("deleteForm" + nomorBOM).submit();
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
