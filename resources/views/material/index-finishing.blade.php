@extends('admin.app')

@section('content')
<style>
    .form-modern {
        display: flex;
        gap: 1rem;
        align-items: center;
        font-family: 'Segoe UI', sans-serif;
    }

    .dropdown-modern {
        position: relative;
    }

    .dropdown-toggle-modern {
        padding: 10px 16px;
        border: 2px solid #d1d5db;
        border-radius: 10px;
        background-color: white;
        cursor: pointer;
        font-weight: 500;
        display: flex;
        align-items: center;
        transition: 0.3s ease;
    }

    .dropdown-toggle-modern:hover {
        background-color: #f3f4f6;
        border-color: #9ca3af;
    }

    .dropdown-menu-modern {
        display: none;
        position: absolute;
        background-color: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.06);
        margin-top: 5px;
        z-index: 1000;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
        font-size: 0.95rem;
    }

    .dropdown-item input[type="checkbox"] {
        accent-color: #10b981;
    }

    .btn-modern {
        padding: 10px 16px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        transition: 0.3s ease;
    }

    .btn-success-modern {
        background-color: #10b981;
        color: white;
    }

    .btn-success-modern:hover {
        background-color: #059669;
    }

    .btn-info-modern {
        background-color: #3b82f6;
        color: white;
    }

    .btn-info-modern:hover {
        background-color: #2563eb;
    }
</style>
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
            <div>
                <h6 class="m-0 font-weight-bold text-primary">List Material Finishing</h6>
                <small class="text-muted">Halaman ini menampilkan data stok material untuk lokasi finishing, <br>mencakup semua material
                    yang telah dicatat dalam sistem pada tiap proyek di lokasi finishing.</small>
            </div>
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
                <form action="{{ route('filterStatus') }}" method="post" class="form-modern">
                    @csrf
                    <div class="dropdown-modern">
                        <button type="button" class="dropdown-toggle-modern" onclick="toggleDropdown2()">
                            Status ▼
                        </button>
                        <div class="dropdown-menu-modern" id="statusDropdown">
                            @foreach($daftarStatus as $status)
                            <label class="dropdown-item-modern">
                                <input type="checkbox" name="status[]" value="{{ $status }}" {{ in_array($status, $queryStatus) ? 'checked' : '' }}>
                                <span>{{ $status }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
            
                    <button type="submit" class="btn-modern btn-success-modern">Cari</button>
            
                   @if(Auth::user()->hasRole('admin'))
                    <button onclick="ExportToExcel('xlsx')" class="btn-modern btn-info-modern" type="button">
                        Ekspor
                    </button>
                    @endif
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
                                <form action="{{ route('stok_material.destroy', $stokMaterial->id) }}" method="POST"
                                    id="deleteForm{{ $stokMaterial->id }}">
                                    <a class="btn btn-primary btn-sm mr-2" href="{{ route('stok_material.edit', $stokMaterial->id) }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm deleteButton" data-form-id="deleteForm{{ $stokMaterial->id }}">
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
    // Pastikan SweetAlert dan DataTable terload dengan benar
    $(document).ready(function() {
        // Inisialisasi DataTable
        let table = new DataTable('#myTable', {
            paging: true, 
            searching: true, 
            ordering: true, 
            lengthChange: true, 
            info: true, 
            autoWidth: false
        });

        // Event delegation untuk tombol delete
        $(document).on('click', '.deleteButton', function () {
            const formId = $(this).data('form-id');
            const form = $("#" + formId); // Ambil form berdasarkan ID yang disimpan di data-form-id

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit form jika konfirmasi berhasil
                }
            });
        });
    });
</script>

<script>
    function toggleDropdown2() {
        const dropdown = document.getElementById("statusDropdown");
        dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
    }

    // Optional: auto-close dropdown if clicked outside
    document.addEventListener("click", function (e) {
        const toggleBtn = document.querySelector('.dropdown-toggle-modern');
        const dropdown = document.getElementById("statusDropdown");
        if (!toggleBtn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = "none";
        }
    });
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
@endpush
@endsection