@extends('admin.app')

@section('content')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

<!-- JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('#myTable6');
</script>

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
                    Laporan Penggunaan Material
                    @if(isset($startDate) && isset($endDate) && $startDate && $endDate)
                    <span class="ml-2">({{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }})</span>
                    @endif
                </h6>

                <div class="d-flex align-items-center">
                    <input type="text" id="myInput" class="form-control ml-3" style="max-width: 250px;"
                        placeholder="Cari..." onkeyup="myFunction()" title="Ketikkan sesuatu untuk mencari">

                    @if(Auth::user()->hasRole('admin'))
                    <button onclick="ExportToExcel('xlsx')" class="btn btn-info ml-1" type="button">
                        <span class="h6">Ekspor</span>
                    </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.filterMaterial') }}">
                <div class="form-row">
                    <div class="form-group col-md-2">

                        <label for="start_date">Tanggal Awal</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="end_date">Tanggal Akhir</label>

                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <div class="form-group col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-success btn-block">
                            Search
                            <div id="loading-spinner" class="loading-spinner d-none"></div>
                        </button>
                    </div>
                </div>
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
            </form>



        </div>
        <div class="card-body">
            <div class="table-responsive">
              <table id="myTable6" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>Kode Material</th>
                        <th>Nama Material</th>
                        <th>Spesifikasi</th>
                        @foreach($dates as $date)
                        <th>{{ $date['date'] }}</th>
                        @endforeach
                        <th>Jumlah Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporanMaterial as $data)
                    <tr>
                        <td>{{ $data['kode_material'] }}</td>
                        <td>{{ $data['nama_material'] }}</td>
                        <td>{{ $data['spek'] }}</td>
                        @foreach($dates as $date)
                        <td>{{ $data['dates'][$date['date']] ?? 0 }}</td>
                        @endforeach
                        <td>{{ $data['total'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<script>
    $(document).ready(function() {
    // Inisialisasi DataTable untuk tabel dengan id 'myTable'
    let table = new DataTable('#myTable6', {
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

<!-- Tempatkan kode JavaScript di bagian bawah file HTML -->
<script>
    const submitButton = document.getElementById('submit-button');
    const loadingSpinner = document.getElementById('loading-spinner');

    submitButton.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the form from submitting immediately

        // Show the loading spinner
        loadingSpinner.classList.remove('d-none');

        // Submit the form after a short delay to simulate loading
        setTimeout(function() {
            event.target.closest('form').submit();
        }, 1000);
    });
</script>

<script>
    function ExportToExcel(type, dl) {
       var elt = document.getElementById('myTable6');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1", autoSize: true });

       // Mendapatkan tanggal saat ini
       var currentDate = new Date();
       var dateString = currentDate.toISOString().slice(0,10);

       // Gabungkan tanggal dengan nama file
       var fileName = 'Laporan BPRM Berdasarkan Tanggal ' + dateString + '.' + (type || 'xlsx');


       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fileName);
    }
</script>
@endsection