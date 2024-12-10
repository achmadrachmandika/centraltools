@extends('admin.app')

@section('content')
            <div id="content">
                
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-md-12" style="min-width:80vw">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        Tambah SPM
                                    </div>
                                    <div class="card-body">
                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <strong>Whoops!</strong> Terdapat beberapa masalah dengan inputan
                                            Anda.<br><br>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                        <form method="post" action="{{ route('spm.store') }}" id="myForm">
                                            @csrf

                                            {{-- <div class="form-group">
                                                <label for="no_spm">Nomor SPM</label>
                                                <input type="text" name="no_spm" class="form-control" id="no_spm" disabled>
                                            </div> --}}

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="bagian">Bagian</label>
                                                        <select class="form-select" name="bagian" id="bagian">
                                                            <option class="form-select" selected disabled value="">--Pilih--</option>
                                                            <option class="form-select" value="Fabrikasi-PPL" {{ old('bagian') == 'Fabrikasi-PPL' ? 'selected' : '' }}>Fabrikasi - PPL</option>
                                                            <option class="form-select" value="Fabrikasi-PRKB" {{ old('bagian') == 'Fabrikasi-PRKB' ? 'selected' : '' }}>Fabrikasi - PRKB</option>
                                                            <option class="form-select" value="Fabrikasi-PRKT" {{ old('bagian') == 'Fabrikasi-PRKT' ? 'selected' : '' }}>Fabrikasi - PRKT</option>
                                                            <option class="form-select" value="Fabrikasi-Bogie" {{ old('bagian') == 'Fabrikasi-Bogie' ? 'selected' : '' }}>Fabrikasi - Bogie</option>
                                                            <option class="form-select" value="Fabrikasi-Welding 1" {{ old('bagian') == 'Fabrikasi-Welding 1' ? 'selected' : '' }}>Fabrikasi - Welding 1</option>
                                                            <option class="form-select" value="Fabrikasi-Welding 2" {{ old('bagian') == 'Fabrikasi-Welding 2' ? 'selected' : '' }}>Fabrikasi - Welding 2</option>
                                                            <option class="form-select" value="Finishing-Interior" {{ old('bagian') == 'Finishing-Interior' ? 'selected' : '' }}>Finishing - Interior</option>
                                                            <option class="form-select" value="Finishing-PMK EQ" {{ old('bagian') == 'Finishing-PMK EQ' ? 'selected' : '' }}>Finishing - PMK EQ</option>
                                                            <option class="form-select" value="Finishing-PMK Bogie" {{ old('bagian') == 'Finishing-PMK Bogie' ? 'selected' : '' }}>Finishing - PMK Bogie</option>
                                                            <option class="form-select" value="Finishing-Painting" {{ old('bagian') == 'Finishing-Painting' ? 'selected' : '' }}>Finishing - Painting</option>
                                                            <option class="form-select" value="Finishing-Piping" {{ old('bagian') == 'Finishing-Piping' ? 'selected' : '' }}>Finishing - Piping</option>
                                                            <option class="form-select" value="Finishing-Wiring" {{ old('bagian') == 'Finishing-Wiring' ? 'selected' : '' }}>Finishing - Wiring</option>
                                                        </select>
                                                    </div>
                                                </div>                                                
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="project">Project</label>
                                                        <select class="form-select" name="project" id="project">
                                                            <option  name="project" class="form-select" id="project" selected disabled value="">--Pilih--</option>
                                                            @foreach ($daftar_projects as $project)
                                                            <option type="text" name="project" class="form-select"
                                                                id="project" value="{{$project->id}}" {{ old('project') == $project->nama_project ? 'selected' : '' }}>
                                                                {{$project->nama_project}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="tgl_spm">Tanggal Permintaan SPM</label>
                                                        <input type="date" name="tgl_spm" class="form-control" value = "{{old('tgl_spm')}}"
                                                            id="tgl_spm">
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="nama_admin">Nama Admin</label>
                                                        <input type="text" name="nama_admin" class="form-control" value="{{ old('nama_admin') }}" id="nama_admin">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="keterangan_spm">Keterangan SPM</label>
                                                        <textarea class="form-control" name="keterangan_spm"  id="keterangan_spm" style="resize:none">{{old('keterangan_spm')}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label for="kode_material_1">Kode Material</label>
                                                        <input class="form-control" type="text" name="kode_material_1"
                                                            id="kode_material_1">
                                                        <div id="materialList_1"></div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label for="nama_material_1">Nama Material</label>
                                                        <input class="form-control" type="text" name="nama_material_1"
                                                            id="nama_material_1">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="spek_material_1">Spesifikasi Material</label>
                                                        <input class="form-control" type="text" name="spek_material_1"
                                                            id="spek_material_1">
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <div class="form-group">
                                                        <label for="jumlah_material_1">Jumlah</label>
                                                        <input type="text" name="jumlah_material_1" class="form-control"
                                                            id="jumlah_material_1">
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label for="satuan_material_1">Satuan</label>
                                                        <input type="text" name="satuan_material_1" class="form-control"
                                                            id="satuan_material_1" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class=" col-2">
                                                    <div id="materials-code-container"></div>
                                                    <div class="btn btn-primary form-control add-material">
                                                        <label>Tambah</label></div>
                                                </div>
                                                <div class=" col-3">
                                                    <div id="materials-container"></div>
                                                </div>
                                                <div class=" col-4">
                                                    <div id="materials-specs-container"></div>
                                                </div>
                                                <div class=" col-1">
                                                    <div id="materials-count-container"></div>
                                                </div>
                                                <div class=" col-2">
                                                    <div id="materials-count-type-container"></div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col">
                                                    <button type="submit" class="btn btn-primary form-control">Submit</button>
                                                </div>
                                                <div class="col">
                                                    <a href="{{ route('spm.index') }}" class="btn btn-secondary form-control">Kembali</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
             
            <!-- Footer -->
            </div>
        </div>


    <!-- jQuery library -->
    <script src="{{url('https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js')}}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let materialCount = 1;
        let materialCodeCount = 1;
        let materialCountCount = 1;
        let materialCountTypeCount = 1;
        let materialSpecsCount = 1;
        const maxmaterials = 10;
        const container = document.getElementById('materials-container');
        const code_container = document.getElementById('materials-code-container');
        const count_container = document.getElementById('materials-count-container');
        const count_type_container = document.getElementById('materials-count-type-container');
        const specs_container = document.getElementById('materials-specs-container');

        function addmaterial() {
            materialCount++;
            if (materialCount > maxmaterials) {
                return;
            }
            const newDiv1 = document.createElement('div');
            newDiv1.innerHTML = `
                <input class="form-control form-group" style="margin-top:5px" type="text" name="nama_material_${materialCount}" id="nama_material_${materialCount}">
            `;
            container.appendChild(newDiv1);

            console.log()

            if (materialCount === maxmaterials) {
                document.querySelector('.add-material').style.display = 'none';
            }
        }

        function addmaterialCode() {
            materialCodeCount++;
            if (materialCodeCount > maxmaterials) {
                return;
            }

            console.log(materialCodeCount)

            const newDiv2 = document.createElement('div');
            newDiv2.innerHTML = `

                <input type="text" class="form-control form-group" placeholder="Cari.." style="margin-top:5px" type="text" name="kode_material_${materialCodeCount}" id="kode_material_${materialCodeCount}">
                <div id="materialList_${materialCodeCount}"></div>
            `;
            code_container.appendChild(newDiv2);

        }

        function addmaterialCount() {
            materialCountCount++;
            if (materialCountCount > maxmaterials) {
                return;
            }
            const newDiv3 = document.createElement('div');
            newDiv3.innerHTML = `
                <input class="form-control form-group" style="margin-top:5px" type="text" name="jumlah_material_${materialCountCount}" id="jumlah_material_${materialCountCount}">
            `;
            count_container.appendChild(newDiv3);
        }

        function addmaterialCountType() {
            
            materialCountTypeCount++;
            if (materialCountTypeCount > maxmaterials) {
                return;
            }
            const newDiv5 = document.createElement('div');
            newDiv5.innerHTML = `
            <input class="form-control form-group" style="margin-top:5px" type="text" name="satuan_material_${materialCountCount}" id="satuan_material_${materialCountCount}" readonly>
            `;
            count_type_container.appendChild(newDiv5);
        }

        function addmaterialSpecs() {
            materialSpecsCount++;
            if (materialSpecsCount > maxmaterials) {
                return;
            }

            console.log(materialCodeCount)
            const newDiv4 = document.createElement('div');
            newDiv4.innerHTML = `
                <input class="form-control form-group" style="margin-top:5px" type="text" name="spek_material_${materialSpecsCount}" id="spek_material_${materialSpecsCount}">
            `;
            specs_container.appendChild(newDiv4); // Mengganti count_container menjadi specs_container
            
        }

        document.querySelector('.add-material').addEventListener('click', addmaterial);
        document.querySelector('.add-material').addEventListener('click', addmaterialCode);
        document.querySelector('.add-material').addEventListener('click', addmaterialCount);
        document.querySelector('.add-material').addEventListener('click', addmaterialCountType);
        document.querySelector('.add-material').addEventListener('click', addmaterialSpecs);
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
                $(`#kode_material_${i}`).val($(this).text());
                $(`#nama_material_${i}`).val(nama_material);
                $(`#satuan_material_${i}`).val(satuan);
                $(`#jumlah_material_${i}`).val(jumlah);
                $(`#spek_material_${i}`).val(spek_material);
                $(`#materialList_${i}`).fadeOut();
            });
        }
    });
</script>
@endsection