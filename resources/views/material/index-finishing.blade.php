@extends('admin.app')

@section('content')
<title>PPA|Material|CENTRAL TOOLS</title>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

@stack('css')

<!-- JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('#myTable');
</script>
<!-- CSS -->


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
            <h6 class="m-0 font-weight-bold text-primary">List Material Finishing</h6>
            <div class="d-flex">

                @if(Auth::user()->hasRole('admin'))
                <a class="btn btn-outline-success form-control ml-2" href="{{ route('stok_material.create') }}">Input
                    Material</a>
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
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="toggleDropdown2()">
                            <span class="h6">Status</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="statusDropdown">
                            @foreach($daftarStatus as $status)
                            <label class="dropdown-item">
                                <input type="checkbox" name="status[]" value="{{ $status }}" {{ in_array($status,
                                    $queryStatus) ? 'checked' : '' }}>
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
            <div class="table-responsive" style="max-height: 530px !important;">
                <table id="stokTable" class="display table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Material</th>
                            <th>Nama Material</th>
                            <th>Spesifikasi</th>
                            <th>Foto</th>
                            <th>Stok</th>
                            @foreach($tabelProjects as $project)
                            <th>{{ $project }}</th>
                            @endforeach
                            <th>Satuan</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            @if(Auth::user()->hasRole('admin'))
                            <th class="text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stokMaterials as $stokMaterial)
                        <tr>
                            <td>{{ $stokMaterial->kode_material }}</td>
                            <td>{{ $stokMaterial->nama }}</td>
                            <td>{{ $stokMaterial->spek }}</td>
                            @if($stokMaterial->foto)
                            <td class="text-center">
                                <img src="{{ asset('storage/material/' . $stokMaterial->foto) }}" alt="{{ $stokMaterial->nama }}"
                                    style="width: 100px; height: auto; cursor: pointer;" data-toggle="modal" data-target="#imageModal"
                                    data-image="{{ asset('storage/material/' . $stokMaterial->foto) }}" data-title="{{ $stokMaterial->nama }}">
                            </td>
                            @else
                            <td class="text-center">Tidak Ada Foto</td>
                            @endif
                            <td class="text-center">
                                <strong @if($stokMaterial->jumlah < 0) style="color: red;" @endif>{{
                                        $stokMaterial->jumlah }}</strong>
                            </td>
                            @foreach ($stokMaterial->getAttributes() as $key => $value)
                            @if (str_starts_with($key, 'material_'))
                            <td class="text-center">{{ $value }}</td>
                            @endif
                            @endforeach
                            <td>{{ $stokMaterial->satuan }}</td>
                            <td>{{ $stokMaterial->lokasi }}</td>
                            <td>{{ $stokMaterial->status }}</td>
                            @if(Auth::user()->hasRole('admin'))
                            <td class="flex justify-content-center">
                        
                                <form action="{{ route('stok_material.destroy', $stokMaterial->id) }}" method="POST" id="deleteForm">
                                    <a class="btn btn-primary btn-sm mr-2" href="{{ route('stok_material.edit', $stokMaterial->id) }}"><i
                                            class="fas fa-edit"></i>Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" id="deleteButton">
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
    
    <!-- Modal Popup -->
    <div id="myPopup" class="popup" style="display: none;">
        <div class="popup-content">
            <div class="d-flex justify-content-between">
                <div></div>
                <button class="btn btn-danger btn-sm" onclick="closePopup()">&times;</button>
            </div>
            <div class="table-responsive mt-4" style="max-height: 530px !important;">
                <table id="popupTable" class="display table table-striped table-bordered">
                    <thead class="bg-secondary text-white text-center sticky-header">
                        <tr>
                            <th>Project</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody id="popupContent">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

     <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image View</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="" style="width: 100%; height: auto;">
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- End Card Container -->


<!-- /.container-fluid -->
<!-- Bootstrap core JavaScript-->
@push('scripts')
<script>
    $(document).ready(function() {
    // Inisialisasi DataTable untuk tabel dengan id 'myTable'
    let table = new DataTable('#myTable', {
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
    function toggleDropdown2() {
            var dropdown = document.getElementById('statusDropdown');
            dropdown.classList.toggle('show');
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('#dropdownMenuButton')) {
                var dropdowns = document.getElementsByClassName("dropdown-menu");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
</script>
<script>
    // function myFunction() {
    //     var input, filter, table, tr, td, i, txtValue;
    //     input = document.getElementById("myInput");
    //     filter = input.value.toUpperCase();
    //     table = document.getElementById("myTable");
    //     tr = table.getElementsByTagName("tr");
    //     for (i = 0; i < tr.length; i++) {
    //         if (tr[i].getElementsByTagName("th").length > 0) {
    //             continue; // Lewati baris yang berisi header
    //         }
    //         var found = false;
    //         td = tr[i].getElementsByTagName("td");
    //         for (var j = 0; j < td.length; j++) {
    //             txtValue = td[j].textContent || td[j].innerText;
    //             if (txtValue.toUpperCase().indexOf(filter) > -1) {
    //                 found = true;
    //                 break; // Hentikan loop jika ditemukan kecocokan
    //             }
    //         }
    //         tr[i].style.display = found ? "" : "none";
    //     }
    // }

    window.onload = function() {
    var images = document.getElementsByTagName('img');
    for (var i = 0; i < images.length; i++) {
        images[i].src = images[i].src + '?' + new Date().getTime();
    }
};
</script>

<script>
    function ExportToExcel(type, dl) {
       var elt = document.getElementById('myTable2');
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

      $('#imageModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var imageUrl = button.data('image');
        var imageTitle = button.data('title');
        var modal = $(this);
        modal.find('.modal-body #modalImage').attr('src', imageUrl);
        modal.find('.modal-title').text(imageTitle);
    });
</script>
@endpush
@endsection