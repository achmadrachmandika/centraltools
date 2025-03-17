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
<!-- DataTables CSS -->

<!-- jQuery & DataTables JS -->

    
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
            <h6 class="m-0 font-weight-bold text-primary">List Material Fabrikasi</h6>
            <div class="d-flex">
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
                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>Kode Material</th>
                                <th>Nama Material</th>
                                <th>Spesifikasi</th>
                                <th>Foto</th>
                                <th>Stok</th>
                                @foreach($tabelProjects as $project)
                                <th>{{$project}}</th>
                                @endforeach
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
                                @if($stokMaterial->foto)
                            <td class="text-center">
                                <img src="{{ asset('storage/material/' . $stokMaterial->foto) }}"
                                    alt="{{ $stokMaterial->nama }}"
                                    style="width: 100px; height: auto; cursor: pointer;" data-toggle="modal"
                                    data-target="#imageModal"
                                    data-image="{{ asset('storage/material/' . $stokMaterial->foto) }}"
                                    data-title="{{ $stokMaterial->nama }}">
                            </td>
                            @else
                            <td class="text-center">Tidak Ada Foto</td>
                            @endif
                                <td class="text-center">
                                        <strong @if($stokMaterial->jumlah < 0) style="color: red;" @endif>{{ $stokMaterial->jumlah }}</strong> 
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
            <!-- The Popup -->
            <div id="myPopup" class="popup" style="display: none">
                <!-- Popup content -->
                <div class="popup-content">
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-1">
                            <div class="btn btn-danger btn-sm" onclick="closePopup()">&times;</div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <table id="myTable" class="table table-bordered" width="100%" cellspacing="0">
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
            </div>
        </div>
    </div>
    <!-- Modal -->
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
{{-- <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        @if ($stokMaterials->onFirstPage())
        <li class="page-item disabled"><span class="page-link">Previous</span></li>
        @else
        <li class="page-item"><a class="page-link" href="{{ $stokMaterials->previousPageUrl() }}"
                rel="prev">Previous</a>
        </li>
        @endif

        @for ($i = 1; $i <= $stokMaterials->lastPage(); $i++)
            <li class="page-item {{ $stokMaterials->currentPage() == $i ? 'active' : '' }}">
                <a class="page-link" href="{{ $stokMaterials->url($i) }}">{{ $i }}</a>
            </li>
            @endfor

            @if ($stokMaterials->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $stokMaterials->nextPageUrl() }}" rel="next">Next</a>
            </li>
            @else
            <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
    </ul>
</nav> --}}
    <!-- End Card Container -->
</div>

<!-- /.container-fluid -->



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
{{-- 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('stok_material.fabrikasi.index') }}", // Sesuaikan dengan route
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'kode_material', name: 'kode_material' },
                { data: 'nama_material', name: 'nama_material' },
                { data: 'lokasi', name: 'lokasi' },
                { data: 'status', name: 'status' },
                { data: 'jumlah', name: 'jumlah' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script> --}}
<script>
    function toggleDropdown() {
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

    $('#imageModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var imageUrl = button.data('image');
        var imageTitle = button.data('title');
        var modal = $(this);
        modal.find('.modal-body #modalImage').attr('src', imageUrl);
        modal.find('.modal-title').text(imageTitle);
    });
</script>
@endsection