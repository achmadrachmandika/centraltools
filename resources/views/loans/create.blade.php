@extends('admin.app')

@section('content')
<style>
  .loan-card {
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: none;
    transition: all 0.3s ease;
  }
  
  .loan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
  }
  
  .loan-card .card-header {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    color: white;
    border-radius: 10px 10px 0 0;
    border-bottom: none;
    padding: 20px;
  }
  
  .form-control, .form-select {
    border-radius: 6px;
    border: 1px solid #e0e0e0;
    padding: 12px 15px;
    height: auto;
    transition: all 0.2s;
  }
  
  .form-control:focus, .form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.1);
  }
  
  .form-label {
    font-weight: 600;
    color: #566a7f;
    margin-bottom: 8px;
  }
  
  .btn {
    padding: 12px 20px;
    border-radius: 6px;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.2s;
  }
  
  .btn-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    border: none;
  }
  
  .btn-primary:hover {
    background: linear-gradient(135deg, #5a80e8 0%, #2a58d5 100%);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(78, 115, 223, 0.2);
  }
  
  .btn-secondary {
    background-color: #f8f9fc;
    border: 1px solid #dfe3e9;
    color: #566a7f;
  }
  
  .btn-secondary:hover {
    background-color: #e8ebf2;
    color: #3a4a5e;
  }
  
  .select2-container .select2-selection--single {
    height: 46px !important;
    padding: 10px 15px;
    border: 1px solid #e0e0e0 !important;
    border-radius: 6px !important;
  }
  
  .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 46px !important;
  }
  
  .animate-fade-in {
    animation: fadeIn 0.5s ease;
  }
  
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
  /* Responsive adjustments */
  @media (max-width: 768px) {
    .card-header {
      padding: 15px;
    }
    
    .btn {
      width: 100%;
      margin-bottom: 10px;
    }
  }
</style>
<script>
    $(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Pilih--",
                allowClear: true,
                width: '100%' // biar responsif di dalam Bootstrap
            });
        });
</script>
<div class="container-fluid">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12" style="min-width:80vw">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Form Peminjaman Material Antar Proyek
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Terdapat beberapa masalah dengan inputan Anda.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form method="post" action="{{ route('loans.store') }}" id="myForm" class="needs-validation" novalidate>
        @csrf
        
        <div class="row g-4 mb-4">
          <div class="col-md-6">
            <div class="form-group">
              <label for="project_peminjam_id" class="form-label">
                <i class="fas fa-project-diagram me-1"></i> Proyek Peminjam
              </label>
              <select class="select2 form-select" name="project_peminjam_id" id="project_peminjam_id" required>
                <option value="">-- Pilih Proyek Peminjam --</option>
                @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->nama_project }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback">
                Silakan pilih proyek peminjam
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="project_pemilik_id" class="form-label">
                <i class="fas fa-warehouse me-1"></i> Proyek Pemilik Material
              </label>
              <select class="select2 form-select" name="project_pemilik_id" id="project_pemilik_id" onchange="loadMaterials()" required>
                <option value="">-- Pilih Proyek Pemilik --</option>
                @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->nama_project }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback">
                Silakan pilih proyek pemilik material
              </div>
            </div>
          </div>
        </div>

        <div class="row g-4 mb-4">
          <div class="col-md-4">
            <div class="form-group">
              <label for="tanggal_pinjam" class="form-label">
                <i class="fas fa-calendar-alt me-1"></i> Tanggal Pinjam
              </label>
              <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
              <div class="invalid-feedback">
                Tanggal pinjam harus diisi
              </div>
            </div>
          </div>
        </div>

        <div id="material-list" class="mt-4">
          <!-- Material list will be loaded here -->
          <div class="text-center py-5 text-muted">
            <i class="fas fa-box fa-3x mb-3 text-secondary"></i>
            <p>Pilih proyek pemilik material untuk melihat daftar material</p>
          </div>
        </div>

        <div class="row mt-5 g-3">
          <div class="col-md-6">
            <button type="submit" class="btn btn-primary w-100" id="submitBtn">
              <i class="fas fa-save me-2"></i> Simpan Peminjaman
            </button>
          </div>
          <div class="col-md-6">
            <a href="{{ route('loans.index') }}" class="btn btn-secondary w-100">
              <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
          </div>
        </div>
      </form>
                    </div> <!-- end card-body -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

<script>
    // Function to load materials based on selected project and location
    function loadMaterials() {
        // Get the selected Project ID and Location
        const projectPeminjamId = document.getElementById('project_peminjam_id').value;
        const projectPemilikId = document.getElementById('project_pemilik_id').value;
        // const lokasi = document.getElementById('lokasi').value;

        console.log('Project Peminjam ID:', projectPeminjamId); 
        console.log('Project Pemilik ID:', projectPemilikId);
        // console.log('Lokasi:', lokasi);

        // If either projectId or lokasi is not selected, show a warning and stop the function
        if (!projectPeminjamId) {
            console.warn('Project ID atau lokasi belum dipilih.');
            document.getElementById('material-list').innerHTML = ''; // Clear the material list
            return; // Exit the function early
        }
        console.log('TES');

        // Build the URL with project ID and location as query parameters
        const url = new URL(`/materials/by-project/${projectPemilikId}`, window.location.origin);
        // url.searchParams.append('lokasi', lokasi);

        console.log('URL yang di-fetch:', url.toString()); // Log the URL to ensure it's correct

        // Fetch the data from the server
        fetch(url)
            .then(response => {
                console.log('Status respons:', response.status);
                // If the response is not ok (status is not 200), throw an error
                if (!response.ok) {
                    throw new Error(`Server error: ${response.status}`);
                }
                return response.json(); // Parse the JSON response
            })
            .then(data => {
                console.log('Data diterima:', data); // Log the received data

                // Check if the data is an array
                if (!Array.isArray(data)) {
                    console.warn('Data yang diterima bukan array:', data);
                    document.getElementById('material-list').innerHTML =
                        '<p class="text-danger">Format data tidak sesuai.</p>';
                    return;
                }

                console.log('Jumlah data diterima:', data.length);

                // If no data is received, display a message
                if (data.length === 0) {
                    document.getElementById('material-list').innerHTML =
                        '<p class="text-danger">Tidak ada material tersedia di lokasi ini.</p>';
                    return;
                }

                // Build the HTML table to display the materials
                let html = `
                    <h5 class="mb-3">Material Tersedia</h5>
                    <div class="table-responsive">
                        <table id="table-material" class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Material</th>
                                    <th>Nama Material</th>
                                    <th>Jumlah Tersedia</th>
                                    <th>Jumlah Pinjam</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                // Loop through each item in the data and add it to the table
                data.forEach(item => {
                    console.log('Item material:', item); // Log each item for debugging

                    // Ensure that each item has 'material' and 'jumlah' properties
                    if (item.material &&item.material.kode_material && item.material.nama_material && item.jumlah !== undefined){
                        html += `
                            <tr>
                                <td>${item.material?.kode_material || 'Tidak ada kode material'}</td>
                                <td>${item.material?.nama_material || 'Tidak ada nama'}</td>
                                <td>${item.jumlah}</td>
                                <td>
                                    <input type="number" name="materials[${item.id}]" class="form-control jumlah-input" min="0" max="${item.jumlah}" value="0">

                                </td>
                            </tr>
                        `;
                    } else {
                        console.warn('Item material tidak valid:', item);
                    }
                });

                html += `
                        </tbody>
                    </table>
                </div>
                `;

                // Update the HTML to display the material list
                document.getElementById('material-list').innerHTML = html;

                $('#table-material').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                url: '{{ route('loans.material.data') }}',
                data: function (d) {
                d.project_id = projectPemilikId; // Mengirim project_id sebagai parameter
                }
                },
                columns: [
                { data: 'material.kode_material', name: 'material.kode_material' },
                { data: 'material.nama_material', name: 'material.nama_material' },
                { data: 'jumlah', name: 'jumlah' },
                {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
    return `<input type="number" name="materials[${data}]" class="form-control jumlah-input" min="0" max="${row.jumlah}" value="0">`;
}
                }
                ]
                });
            })
            .catch(error => {
                // Handle any errors during the fetch
                console.error('Terjadi kesalahan saat fetch:', error);
                document.getElementById('material-list').innerHTML =
                    `<p class="text-danger">Gagal memuat material: ${error.message}</p>`;
            });
    }
</script>

<script>
document.getElementById('myForm').addEventListener('submit', function (e) {
    const jumlahInputs = document.querySelectorAll('.jumlah-input');
    let invalid = false;
    let atLeastOneValid = false;

    jumlahInputs.forEach(input => {
        const val = parseInt(input.value);
        const max = parseInt(input.max);

        if (!isNaN(val) && val > 0 && val <= max) {
            atLeastOneValid = true;
        } else if (val !== 0) {
            // Jika user isi > stok, atau nilai negatif
            invalid = true;
        }
    });

    if (invalid || !atLeastOneValid) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Jumlah Tidak Valid',
            text: 'Jumlah pinjam harus lebih dari 0, tidak boleh melebihi stok, dan minimal satu material harus dipilih.',
            confirmButtonText: 'OK'
        });
    }
});

</script>
@endpush