@extends('admin.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

<!-- JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('#myTable3');
</script>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">BON PENYERAHAN MATERIAL</h6>
                            <div class="d-flex">
                                <input type="text" id="myInput" class="form-control" placeholder="Cari..." onkeyup="myFunction()"
                                    title="Ketikkan sesuatu untuk mencari">
                                <a class="btn form-control ml-2 btn-outline-success" href="{{ route('bprm.create') }}">Input BPRM</a>
                            </div>
                            
                        </div>

                     <div class="card-body">
                        <div class="table-responsive">
                            <table id="myTable3" class="display">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nomor BPRM</th>
                                        <th class="text-center">Nomor SPM</th>
                                        <th class="text-center">Project</th>
                                        <th class="text-center">Material</th>
                                        <th class="text-center">Bagian</th>
                                        <th class="text-center">Tanggal Pengajuan</th>
                                        <th class="text-center">Admin</th>
                                        <th class="text-center">Jumlah Material</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bprms as $bprm)
                                    <tr>
                                        <td class="text-center">{{ $bprm->nomor_bprm }}</td>
                                        <td class="text-center">{{ $bprm->no_spm }}</td>
                                        <td class="text-center">{{ $bprm->project }}</td>
                                        <td>
                                            @foreach ($bprm->bprmMaterials as $bprmMaterial)
                                            ({{ $bprmMaterial->material->kode_material }}) {{ $bprmMaterial->material->nama_material }}<br>
                                            @endforeach
                                        </td>
                                        <td class="text-center">{{ $bprm->bagian }}</td>
                                        <td class="text-center">{{ $bprm->tgl_bprm }}</td>
                                        <td class="text-center">{{ $bprm->nama_admin }}</td>
                                        <td class="text-center">
                                            @foreach ($bprm->bprmMaterials as $bprmMaterial)
                                            {{ $bprmMaterial->jumlah_material }}<br>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-info btn-sm mr-2"
                                                href="{{ route('bprm.show', ['bprm' => $bprm->nomor_bprm, 'id_notif' => $bprm->id_notif]) }}">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                        
                        <!-- Modal Image (Jika diperlukan) -->
                        <!-- <div id="imageModal" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <img id="modalImage" src="" alt="" style="width: 100%;">
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
                <!-- /.container-fluid -->

    <!-- Bootstrap core JavaScript-->
    @push('scripts')
    <script>
        $(document).ready(function() {
        // Inisialisasi DataTable untuk tabel dengan id 'myTable'
        let table = new DataTable('#myTable3', {
        paging: true, // Aktifkan pagination
        searching: true, // Aktifkan pencarian
        ordering: true, // Aktifkan pengurutan kolom
        lengthChange: true, // Memungkinkan user memilih jumlah baris per halaman
        info: true, // Menampilkan informasi jumlah baris yang ditampilkan
        autoWidth: false, // Nonaktifkan lebar otomatis kolom
        });
        });
    </script>
    @endpush

    {{-- <script>
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
    </script> --}}

@endsection