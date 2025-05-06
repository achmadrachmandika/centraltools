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
                @if(Auth::user()->hasRole('admin') || (Auth::user()->hasRole('staff')))
                <a class="btn btn-outline-success form-control ml-2" href="{{ route('stok_material.create') }}">Input
                    Material</a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row" style="margin-bottom:15px">
           <div class="col">
           <label for="filter-status" class="mr-2 mb-0">Status:</label>
        <select class="form-control" id="filter-status" style="max-width: 200px;">
            <option value="">Semua</option>
            @foreach($daftarStatus as $status)
            <option value="{{ $status }}">{{ $status }}</option>
            @endforeach
        </select>
           </div>
        
              <div class="col-md-6 text-md-right mt-2 mt-md-0">
                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('staff'))
                <button onclick="ExportToExcel('xlsx')" class="btn btn-info">
                    <i class="fas fa-file-excel"></i> Ekspor
                </button>
                @endif
            </div>
        </div>
      
        <div class="card-body">
            <div class="col">
                <div class="table-responsive" style="max-height: 530px !important">
                    <table id="table-fabrikasi" class="display">
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
                                @if(Auth::user()->hasRole('admin') || (Auth::user()->hasRole('staff')))
                                <th class="text-center">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($stokMaterials as $stokMaterial)
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
                                @if(Auth::user()->hasRole('admin') || (Auth::user()->hasRole('staff')))
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
                            @endforeach --}}
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
                            <table id="table-fabrikasi" class="table table-bordered" width="100%" cellspacing="0">
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

</div>

<!-- /.container-fluid -->



<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script>
    // Pastikan SweetAlert dan DataTable terload dengan benar
    $(document).ready(function() {
       var table = $('#table-fabrikasi').DataTable({
        processing: true,
        serverSide: true,
      ajax: {
        url: "{{ route('stok_material-fabrikasi.data') }}",
        data: function (d) {
        d.status = $('#filter-status').val(); // ambil nilai dari select
        },
    },
        
       columns: [
    { data: 'kode_material', name: 'kode_material' },
    { data: 'nama', name: 'nama' },
    { data: 'spek', name: 'spek' },
    {
    data: 'foto',
    name: 'foto',
    orderable: false,
    searchable: false,
    render: function (data, type, full, meta) {
    if (data) {
    return `<img src="/storage/material/${data}" alt="${full.nama}" style="width: 100px; height: auto; cursor: pointer;"
        data-toggle="modal" data-target="#imageModal" data-image="/storage/material/${data}" data-title="${full.nama}">`;
    } else {
    return `Tidak Ada Foto`;
    }
    }
    },
    {
    data: 'jumlah',
    name: 'jumlah',
    className: 'text-center',
    render: function (data) {
    return data < 0 ? `<strong style="color:red;">${data}</strong>` : `<strong>${data}</strong>`;
        }
        },
        @foreach($tabelProjects as $project)
            {
            data: 'material_{{ $project }}',
            name: 'material_{{ $project }}',
            orderable: false,
            searchable: false,
            className: 'text-center'
            },
        @endforeach
        { data: 'satuan', name: 'satuan' },
        { data: 'lokasi', name: 'lokasi' },
        { data: 'status', name: 'status' },
        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('staff'))
        
        {
        data: 'id',
        name: 'aksi',
        orderable: false,
        searchable: false,
        className: 'text-center',
        render: function(data, type, row) {
        return `
        <a class="btn btn-sm btn-primary mr-1" href="/stok_material/${data}/edit">
            <i class="fas fa-edit"></i> Edit
        </a>
        <button class="btn btn-sm btn-danger deleteButton" data-id="${data}">
            <i class="fas fa-trash-alt"></i> Hapus
        </button>
        `;
        }
        }
        @endif
        ]
   
        });

        $('#filter-status').change(function() {
            table.draw(); // reload table saat filter berubah
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
       var elt = document.getElementById('table-fabrikasi');
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