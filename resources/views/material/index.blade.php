@extends('admin.app')

@section('content')
<title>PPA|Material|CENTRAL TOOLS</title>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>


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
<style>
    .status-text {
    font-size: 18px;
    font-weight: bold;
    /* Atur gaya font sesuai kebutuhan Anda */
    }
    </style>
<!-- Begin Page Content -->
<div class="container-fluid">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <!-- Card Container -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">List Material</h6>
            <div class="d-flex">
                <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Cari..."
                    title="Type in a name">
        
                @if(Auth::user()->hasRole('admin'))
                <a class="btn btn-outline-success form-control ml-2" href="{{ route('stok_material.create') }}">Input Material</a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row" style="margin-bottom:15px">
                <div class="col">
                  <form action="{{ route('filterStatus') }}" method="post" class="d-flex">
                    @csrf
                    <div class="dropdown mr-2">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="toggleDropdown()">
                            <span class="h6">Status</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="statusDropdown">
                            @foreach($daftarStatus as $status)
                            <label class="dropdown-item">
                                <input type="checkbox" name="status[]" value="{{ $status }}" {{ in_array($status, $queryStatus)
                                    ? 'checked' : '' }}>
                                <span class="status-text">{{ $status }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success ml-2"><span class="h6">Cari</span></button>
                    <div>
                        @if(Auth::user()->hasRole('admin'))
                    <button onclick="ExportToExcel('xlsx')" class="btn btn-info ml-1" type="button">
                        <span class="h6">Ekspor</span>
                    </button>
                    @endif
                    </div>
                </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col">
                <div class="table-responsive" style="max-height: 530px !important">
                    <table id="myTable" class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="bg-secondary text-white text-center sticky-header">
                            <tr>
                                <th>Kode Material</th>
                                <th>Nama Material</th>
                                <th>Spesifikasi</th>
                                <th>Stok</th>
                                <th>Satuan</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                @if(Auth::user()->hasRole('admin'))
                                <th class="text-center">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stokMaterials as $stokMaterial)
                            <tr>
                                <td>{{ $stokMaterial->kode_material }}</td>
                                <td>{{ $stokMaterial->nama }}</td>
                                <td>{{ $stokMaterial->spek }}</td>
                                <td><strong @if($stokMaterial->jumlah < 0) style="color: red;" @endif>{{ $stokMaterial->jumlah }}</strong></td>
                                <td>{{ $stokMaterial->satuan }}</td>
                                <td>{{ $stokMaterial->lokasi }}</td>
                                <td>{{ $stokMaterial->status }}</td>
                                @if(Auth::user()->hasRole('admin'))
                                <td class="flex justify-content-center">
                                   
                                    <form action="{{ route('stok_material.destroy', $stokMaterial->kode_material) }}"
                                        method="POST" class="d-flex justify-content-center">
                                        <a class="btn btn-primary btn-sm mr-2"
                                            href="{{ route('stok_material.edit', $stokMaterial->kode_material) }}"><i
                                                class="fas fa-edit"></i>Edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus Material ini?')">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End Card Container -->
</div>

<!-- /.container-fluid -->
<!-- Bootstrap core JavaScript-->
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
<script>
    function toggleDropdown() {
        var dropdownMenu = document.getElementById('statusDropdown');
        if (dropdownMenu.style.display === 'block') {
            dropdownMenu.style.display = 'none';
        } else {
            dropdownMenu.style.display = 'block';
        }
    }
</script>

<script>
    function ExportToExcel(type, dl) {
       var elt = document.getElementById('myTable');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1", autoSize: true });

       // Mendapatkan tanggal saat ini
       var currentDate = new Date();
       var dateString = currentDate.toISOString().slice(0,10);

       // Gabungkan tanggal dengan nama file
       var fileName = 'Data Material Central Tools ' + dateString + '.' + (type || 'xlsx');

       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fileName);
    }
</script>
@endsection