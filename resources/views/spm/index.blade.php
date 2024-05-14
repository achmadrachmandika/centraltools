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
            <h6 class="m-0 font-weight-bold text-primary">SURAT PERMINTAAN MATERIAL</h6>
            <div class="d-flex">
                <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Cari..." title="Type in a name">
            <a class="btn form-control ml-2 btn-outline-success" href="{{ route('spms.create') }}">Input SPM</a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
              <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered">
                        <thead class="bg-primary text-white">
                            <tr class="text-center">
                                <th>Kode SPM</th>
                                <th>Project</th>
                                <th>Kode Material</th>
                                <th>Material</th>
                                 <th>Jumlah</th>
                                <th>Tanggal SPM</th>
                                <th>Keterangan SPM</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($spms as $spm)
                            <tr>
                                <td>
                                    <div class="" style="display: flex">
                                        {{ $spm->no_spm }}
                                    @if($spm->status === 'unread')
                                    <div class="mx-3 rounded-pill bg-danger">
                                        <span class="h6 text-uppercase text-white px-2 py-1"><span class="data-count"></span>
                                            Baru</span>
                                    </div>
                                    @endif
                                    </div>
                                </td>
                                <td>{{ $spm->project }}</td>
                                <td>
                                    @php
                                    $kode_materials = [];
                                    for ($i = 1; $i <= 10; $i++) { if (!empty($spm["kode_material_$i"])) { $kode_materials[]=$spm["kode_material_$i"]; }
                                        } echo implode(',<br>', $kode_materials);
                                    @endphp
                                </td>
                                <td>
                                    @php
                                    $nama_materials = [];
                                    for ($i = 1; $i <= 10; $i++) { if (!empty($spm["nama_material_$i"])) { $nama_materials[]=$spm["nama_material_$i"]; }
                                        } echo implode(',<br>', $nama_materials);
                                        @endphp
                                </td>
                                <td>
                                    @php
                                    $jumlah_materials = [];
                                    for ($i = 1; $i <= 10; $i++) { if (!empty($spm["jumlah_material_$i"])) { $jumlah_materials[]=$spm["jumlah_material_$i"]; }
                                        } echo implode(',<br>', $jumlah_materials);
                                        @endphp
                                <td>{{ $spm->tgl_spm }}</td>
                                <td>{{ $spm->keterangan_spm }}</td>
                                <td class="text-center">
                                    <a class="btn btn-info btn-sm mr-2"  href="{{ route('spm.show', ['spm' => $spm->no_spm, 'id_notif' => $spm->id_notif]) }}"> <i class="fas fa-eye"></i> Lihat</a>
                                    <form action="{{ route('spm.destroy', $spm->no_spm) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus SPM ini?')">
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
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
<script>
    function confirmDelete(spmId) {
        if (confirm("Apakah Anda yakin ingin menghapus SPM dengan ID " + spmId + "?")) {
            document.getElementById('deleteForm' + spmId).submit();
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
