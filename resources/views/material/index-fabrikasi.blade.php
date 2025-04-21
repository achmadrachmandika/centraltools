@extends('admin.app')

@section('content')

<style>
    .filter-form {
    display: flex;
    gap: 1rem;
    align-items: center;
    font-family: 'Segoe UI', sans-serif;
    margin-bottom: 1.5rem;
    }
    
    /* Dropdown button */
    .dropdown-toggle-btn {
    padding: 10px 18px;
    background-color: #ffffff;
    border: 2px solid #d1d5db;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 500;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    }
    .dropdown-toggle-btn:hover {
    border-color: #9ca3af;
    background-color: #f9fafb;
    }
    
    /* Dropdown menu */
    .dropdown-menu-modern {
    display: none;
    position: absolute;
    margin-top: 8px;
    background-color: #ffffff;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    padding: 10px;
    z-index: 1000;
    }
    .dropdown-item-modern {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 4px 0;
    }
    .dropdown-item-modern input[type="checkbox"] {
    accent-color: #10b981;
    }
    
    /* Modern buttons */
    .btn-modern {
    padding: 10px 16px;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
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
    
    /* Positioning dropdown */
    .dropdown-container {
    position: relative;
    }

    mark.green-highlight {
    background-color: #d4edda;
    /* Hijau muda (background success) */
    color: #155724;
    /* Hijau gelap (teks success) */
    font-weight: bold;
    padding: 0 4px;
    border-radius: 4px;
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
            <div>
                <h6 class="m-0 font-weight-bold text-primary">List Material Fabrikasi</h6>
                <small class="text-muted">Halaman ini menampilkan data stok material untuk lokasi fabrikasi, <br>mencakup semua material
                    yang telah dicatat dalam sistem pada tiap proyek di <mark class="green-highlight">lokasi fabrikasi</mark>.</small>
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
            <form action="{{ route('filterStatus') }}" method="post" class="filter-form">
                @csrf
                <div class="dropdown-container">
                    <button class="dropdown-toggle-btn" type="button" onclick="toggleDropdown()">
                        <span>Status</span>
                        <svg style="margin-left: 8px;" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M1.5 5.5l6 6 6-6" />
                        </svg>
                    </button>
                    <div class="dropdown-menu-modern" id="statusDropdown">
                        @foreach($daftarStatus as $status)
                        <label class="dropdown-item-modern">
                            <input type="checkbox" name="status[]" value="{{ $status }}" {{ in_array($status, $queryStatus)
                                ? 'checked' : '' }}>
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
                <li class="page-item"><a class="page-link" href="{{ $stokMaterials->nextPageUrl() }}"
                        rel="next">Next</a>
                </li>
                @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
        </ul>
    </nav> --}}
    <!-- End Card Container -->
</div>

<!-- /.container-fluid -->


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
    function toggleDropdown() {
        let dropdown = document.getElementById("statusDropdown");
        dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
    }

    // Optional: hide dropdown if click outside
    document.addEventListener("click", function (event) {
        let button = document.querySelector('.dropdown-toggle-btn');
        let dropdown = document.getElementById("statusDropdown");
        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
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