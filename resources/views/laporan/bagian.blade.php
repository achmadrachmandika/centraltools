@extends('admin.app')

@section('content')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

<!-- JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('#myTable5');
</script>
<style>
    .loading-spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .loading-spinner.d-none {
        display: none;
    }
</style>

<!-- Begin Page Content -->
<div class="container-fluid">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Laporan BPRM Berdasarkan Bagian
                    @if(isset($startDate) && isset($endDate) && $startDate && $endDate)
                    <span class="ml-2">({{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }})</span>
                    @endif
                </h6>
                <div class="d-flex align-items-center">
                    {{-- <input type="text" id="myInput" class="form-control ml-3" style="max-width: 250px;"
                        placeholder="Cari..." onkeyup="myFunction()" title="Ketikkan sesuatu untuk mencari"> --}}

                    @if(Auth::user()->hasRole('admin'))
                    <button onclick="ExportToExcel('xlsx')" class="btn btn-info ml-1" type="button">
                        <span class="h6">Ekspor</span>
                    </button>
                    @endif
                </div>

            </div>
        </div>
        <div class="card-header">
            <form method="GET" action="{{ route('laporan.filterBagian') }}" class="mb-4">

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="bagian">Bagian</label>
                        <select class="form-select" name="bagian" id="bagian">
                            <option class="form-select" {{ old('bagian') ? '' : 'selected' }} disabled value="">--Pilih--</option>
                            <option class="form-select" value="Fabrikasi-PPL" {{ old('bagian')=='Fabrikasi-PPL' ? 'selected' : '' }}>
                                Fabrikasi - PPL</option>
                            <option class="form-select" value="Fabrikasi-PRKB" {{ old('bagian')=='Fabrikasi-PRKB' ? 'selected' : '' }}>
                                Fabrikasi - PRKB</option>
                            <option class="form-select" value="Fabrikasi-PRKT" {{ old('bagian')=='Fabrikasi-PRKT' ? 'selected' : '' }}>
                                Fabrikasi - PRKT</option>
                            <option class="form-select" value="Fabrikasi-Bogie" {{ old('bagian')=='Fabrikasi-Bogie' ? 'selected' : '' }}>
                                Fabrikasi - Bogie</option>
                            <option class="form-select" value="Fabrikasi-Welding 1" {{ old('bagian')=='Fabrikasi-Welding 1' ? 'selected'
                                : '' }}>Fabrikasi - Welding 1</option>
                            <option class="form-select" value="Fabrikasi-Welding 2" {{ old('bagian')=='Fabrikasi-Welding 2' ? 'selected'
                                : '' }}>Fabrikasi - Welding 2</option>
                            <option class="form-select" value="Finishing-Interior" {{ old('bagian')=='Finishing-Interior' ? 'selected' : ''
                                }}>Finishing - Interior</option>
                            <option class="form-select" value="Finishing-PMK EQ" {{ old('bagian')=='Finishing-PMK EQ' ? 'selected' : '' }}>
                                Finishing - PMK EQ</option>
                            <option class="form-select" value="Finishing-PMK Bogie" {{ old('bagian')=='Finishing-PMK Bogie' ? 'selected'
                                : '' }}>Finishing - PMK Bogie</option>
                            <option class="form-select" value="Finishing-Painting" {{ old('bagian')=='Finishing-Painting' ? 'selected' : ''
                                }}>Finishing - Painting</option>
                            <option class="form-select" value="Finishing-Piping" {{ old('bagian')=='Finishing-Piping' ? 'selected' : '' }}>
                                Finishing - Piping</option>
                            <option class="form-select" value="Finishing-Wiring" {{ old('bagian')=='Finishing-Wiring' ? 'selected' : '' }}>
                                Finishing - Wiring</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="start_date">Tanggal Awal:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ request('start_date') }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="end_date">Tanggal Akhir:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ request('end_date') }}" required>
                    </div>
                    <div class="form-group col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-success btn-block">
                            Search
                            <div id="loading-spinner" class="loading-spinner d-none"></div>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        {{--
    </div> --}}
    <div class="card-body">
        <div class="table-responsive">
            <table id="myTable5" class="table table-bordered">
                <thead>

                    <tr>
                        <th>Kode Material</th>
                        <th>Nama Material</th>
                        <th>Spesifikasi</th>
                        <th>Project</th>
                        <th>Tanggal</th>
                        <th>Bagian</th>
                       
                        <th>Jumlah Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($totals as $materialCode => $data)
                    <tr>
                        <td>{{ $materialCode }}</td>
                        <td>{{ $data['nama_material'] }}</td>
                        <td>{{ $data['spek'] }}</td>

                        <td>
                            <ul>
                                @php
                                $projectNames = [];
                                @endphp
                                @foreach($data['projects'] as $project)
                                @foreach($projectArray as $dataProject)
                                @if($dataProject->id == $project['project'])
                                @php
                                // Menambahkan nama proyek ke array jika belum ada
                                if (!in_array($dataProject->nama_project, $projectNames)) {
                                $projectNames[] = $dataProject->nama_project;
                                }
                                @endphp
                                @endif
                                @endforeach
                                @endforeach
                        
                                @foreach($projectNames as $projectName)
                                <li>{{ $projectName }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach($data['projects'] as $project)
                                <li>{{ $project['tgl_bprm'] }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach($data['projects'] as $project)
                                <li>{{ $project['bagian'] }}</li>
                                @endforeach
                            </ul>

                        </td>
                        <td>{{ $data['total'] }}</td>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
    // Inisialisasi DataTable untuk tabel dengan id 'myTable'
    let table = new DataTable('#myTable5', {
    paging: true, // Aktifkan pagination
    searching: true, // Aktifkan pencarian
    ordering: true, // Aktifkan pengurutan kolom
    lengthChange: true, // Memungkinkan user memilih jumlah baris per halaman
    info: true, // Menampilkan informasi jumlah baris yang ditampilkan
    autoWidth: false, // Nonaktifkan lebar otomatis kolom
    });
    });
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

<style>
    /* Tambahkan kelas CSS untuk judul tabel agar tetap pada posisi atas saat digulir */
    .sticky-header {
        position: sticky;
        top: 0;
        background-color: #444;
        /* Warna latar belakang judul tabel */
        z-index: 1;
        /* Pastikan judul tabel tetap di atas konten tabel */
    }

    /* Atur lebar kolom agar sesuai dengan konten di dalamnya */
    #myTable th {
        width: auto !important;
    }
</style>


<script>
    function ExportToExcel(type, dl) {
       var elt = document.getElementById('myTable5');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1", autoSize: true });

       // Mendapatkan tanggal saat ini
       var currentDate = new Date();
       var dateString = currentDate.toISOString().slice(0,10);

       // Gabungkan tanggal dengan nama file

       var fileName = 'Laporan BPRM Berdasarkan Bagian ' + dateString + '.' + (type || 'xlsx');


       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fileName);
    }
</script>
@endsection