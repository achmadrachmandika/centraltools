@extends('admin.app')

@section('content')

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
    <div class="row justify-content-center">
        <div class="col-md-12" style="min-width:80vw">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Tambah SPM
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

                 <form method="post" action="{{ route('spm.store') }}" id="myForm">
                    @csrf
                
                    <!-- Basic Form Fields -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="bagian" class="form-label">Bagian</label>
                                <select class="select2" name="bagian" id="bagian">
                                    <option value="" selected disabled>--Pilih--</option>
                                    @foreach($bagians as $bagian)
                                    <option value="{{ $bagian->nama_bagian }}" {{ old('bagian')==$bagian->nama_bagian ? 'selected' : ''
                                        }}>
                                        {{ $bagian->nama_bagian }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="project">Project</label>
                                <select class="select2" name="project" id="project">
                                    <option selected disabled value="">--Pilih--</option>
                                    @foreach ($daftar_projects as $project)
                                    <option value="{{$project->id}}" {{ old('project')==$project->nama_project ? 'selected' : '' }}>
                                        {{$project->nama_project}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="tgl_spm">Tanggal Permintaan SPM</label>
                                <input type="date" name="tgl_spm" class="form-control" value="{{ old('tgl_spm') }}" id="tgl_spm">
                            </div>
                        </div>
                    </div>
                
                    <!-- Admin Info -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="nama_admin">Nama Admin</label>
                                <input type="text" name="nama_admin" class="form-control" value="{{ old('nama_admin') }}"
                                    id="nama_admin">
                            </div>
                        </div>
                
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="keterangan_spm">Keterangan SPM</label>
                                <textarea class="form-control" name="keterangan_spm" id="keterangan_spm"
                                    style="resize:none">{{ old('keterangan_spm') }}</textarea>
                            </div>
                        </div>
                    </div>
                
                    <!-- Material Input Fields -->
                    <div id="material-fields-container">
                        <div class="row material-row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="kode_material_1">Kode Material</label>
                                    <input class="form-control" type="text" name="materials[0][kode_material]" id="kode_material_1">
                                    <div id="materialList_1"></div>
                                </div>
                            </div>
                
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="nama_material_1">Nama Material</label>
                                    <input class="form-control" type="text" name="materials[0][nama_material]" id="nama_material_1">
                                </div>
                            </div>
                
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="spek_material_1">Spesifikasi Material</label>
                                    <input class="form-control" type="text" name="materials[0][spek_material]" id="spek_material_1">
                                </div>
                            </div>
                
                            <div class="col-1">
                                <div class="form-group">
                                    <label for="jumlah_material_1">Jumlah</label>
                                    <input type="number" name="materials[0][jumlah_material]" class="form-control"
                                        id="jumlah_material_1">
                                </div>
                            </div>
                
                            <div class="col-1">
                                <div class="form-group">
                                    <label for="lokasi_material_1">Lokasi</label>
                                    <input type="text" name="materials[0][lokasi_material]" class="form-control" id="lokasi_material_1">
                                </div>
                            </div>
                
                            <div class="col-1">
                                <div class="form-group">
                                    <label for="satuan_material_1">Satuan</label>
                                    <input type="text" name="materials[0][satuan_material]" class="form-control" id="satuan_material_1">
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Add More Materials -->
                    <div class="row">
                        <div class="col-2">
                            <button type="button" class="btn btn-primary form-control add-material">Tambah Material</button>
                        </div>
                    </div>
                
                    <!-- Submit Buttons -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary form-control">Submit</button>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('spm.index') }}" class="btn btn-secondary form-control">Kembali</a>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



    <!-- jQuery library -->
    @push('scripts')
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <!-- CSS Select2 -->
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            
            <!-- JS Select2 -->
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
   document.addEventListener('DOMContentLoaded', function() {
let materialCount = 1;
let materialCodeCount = 1;
let materialCountCount = 1;
let materialCountTypeCount = 1;
let materialSpecsCount = 1;
let materialLocCount = 1;
const maxmaterials = 10;
const container = document.getElementById('materials-container');
const code_container = document.getElementById('materials-code-container');
const count_container = document.getElementById('materials-count-container');
const count_type_container = document.getElementById('materials-count-type-container');
const specs_container = document.getElementById('materials-specs-container');
const loc_container = document.getElementById('materials-loc-container');
const addMaterialButton = document.querySelector('.add-material'); // Select the add button

// Function to add material name
function addMaterial() {
materialCount++;
if (materialCount > maxmaterials) {
return;
}
const newDiv1 = document.createElement('div');
newDiv1.innerHTML = `
<input class="form-control form-group" style="margin-top:5px" type="text" name="nama_material_${materialCount}"
    id="nama_material_${materialCount}">
`;
container.appendChild(newDiv1);

if (materialCount === maxmaterials) {
addMaterialButton.style.display = 'none'; // Hide button when max materials are reached
}
}

// Function to add material code
function addMaterialCode() {
materialCodeCount++;
if (materialCodeCount > maxmaterials) {
return;
}
const newDiv2 = document.createElement('div');
newDiv2.innerHTML = `
<input type="text" class="form-control form-group" placeholder="Cari.." style="margin-top:5px"
    name="kode_material_${materialCodeCount}" id="kode_material_${materialCodeCount}">
<div id="materialList_${materialCodeCount}"></div>
`;
code_container.appendChild(newDiv2);
}

// Function to add material quantity
function addMaterialCount() {
materialCountCount++;
if (materialCountCount > maxmaterials) {
return;
}
const newDiv3 = document.createElement('div');
newDiv3.innerHTML = `
<input class="form-control form-group" style="margin-top:5px" type="text" name="jumlah_material_${materialCountCount}"
    id="jumlah_material_${materialCountCount}">
`;
count_container.appendChild(newDiv3);
}

// Function to add material unit type
function addMaterialCountType() {
materialCountTypeCount++;
if (materialCountTypeCount > maxmaterials) {
return;
}
const newDiv5 = document.createElement('div');
newDiv5.innerHTML = `
<input class="form-control form-group" style="margin-top:5px" type="text"
    name="satuan_material_${materialCountTypeCount}" id="satuan_material_${materialCountTypeCount}" readonly>
`;
count_type_container.appendChild(newDiv5);
}

// Function to add material specifications
function addMaterialSpecs() {
materialSpecsCount++;
if (materialSpecsCount > maxmaterials) {
return;
}
const newDiv4 = document.createElement('div');
newDiv4.innerHTML = `
<input class="form-control form-group" style="margin-top:5px" type="text" name="spek_material_${materialSpecsCount}"
    id="spek_material_${materialSpecsCount}">
`;
specs_container.appendChild(newDiv4);
}

// Function to add material location
function addMaterialLoc() {
materialLocCount++;
if (materialLocCount > maxmaterials) {
return;
}
const newDiv4 = document.createElement('div');
newDiv4.innerHTML = `
<input class="form-control form-group" style="margin-top:5px" type="text" name="lokasi_material_${materialLocCount}"
    id="lokasi_material_${materialLocCount}">
`;
loc_container.appendChild(newDiv4);
}

// Attach the click event listener for the 'Tambah' button once
if (addMaterialButton) {
addMaterialButton.addEventListener('click', function(event) {
event.preventDefault(); // Prevent the default behavior of the button
addMaterial(); // Add the material input
addMaterialCode(); // Add material code input
addMaterialCount(); // Add material count input
addMaterialCountType();// Add material count type input
addMaterialSpecs(); // Add material specs input
addMaterialLoc(); // Add material location input
});
}
});

</script>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialize the selectedProject and selectedBagian variables
        let selectedProject = $('#project').val();
        let selectedBagian = $('#bagian').val();
        if (selectedBagian) {
            selectedBagian = selectedBagian.split('-')[0];
        }

        // Update selectedProject whenever the project selection changes
        $(document).on('change', '#project', function() {
            selectedProject = $(this).val();
            console.log('Selected project:', selectedProject); // Debugging line to check the value
        });

        // Update selectedBagian whenever the bagian selection changes
        $(document).on('change', '#bagian', function() {
            selectedBagian = $(this).val().split('-')[0];
            console.log('Selected bagian:', selectedBagian); // Debugging line to check the value
        });

        // Assuming you want to use the selectedProject and selectedBagian variables in your AJAX request
        for (let i = 1; i <= 10; i++) {
            $(document).on('keyup', `#kode_material_${i}`, function() {
                var query = $(this).val();
                if (query != '') {
                    var _token = $('input[name="csrf-token"]').val();
                    $.ajax({
                        url: '/ajax-autocomplete-material-code-spm',
                        method: "GET",
                        data: {
                            query: query,
                            project_id: selectedProject,
                            lokasi: selectedBagian,
                            _token: _token
                        },
                        success: function(data) {
                            $(`#materialList_${i}`).fadeIn();
                            $(`#materialList_${i}`).html(data);
                        }
                    });
                }
            });

            $(document).on('click', `#materialList_${i} li`, function() {
                var nama_material = $(this).data('nama');
                var satuan = $(this).data('satuan');
                var spek_material = $(this).data('spek');
                var jumlah = $(this).data('jumlah');
                var lokasi_material = $(this).data('lokasi');
                $(`#kode_material_${i}`).val($(this).text());
                $(`#nama_material_${i}`).val(nama_material);
                $(`#satuan_material_${i}`).val(satuan);
                $(`#jumlah_material_${i}`).val(jumlah);
                $(`#lokasi_material_${i}`).val(lokasi_material);
                $(`#spek_material_${i}`).val(spek_material);
                $(`#materialList_${i}`).fadeOut();
            });
        }
    });
</script>
@endpush
