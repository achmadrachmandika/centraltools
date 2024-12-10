@extends('admin.app')

@section('content')
<style>
    .form-check-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        /* Optional: Space between checkboxes */
    }
</style>
            <div id="content">

                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header">
                                    Edit Material
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
                                    <form method="post" action="{{ route('stok_material.update', ['stok_material' => $stokMaterial->kode_material]) }}" id="myForm" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="kode_material">Kode Material</label>
                                                    <input type="text" name="kode_material" class="form-control"
                                                        id="kode_material" value="{{ $stokMaterial->kode_material}}"readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="nama">Nama Material</label>
                                                    <input type="text" name="nama" class="form-control"
                                                        id="nama" value="{{ $stokMaterial->nama}}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="project">Project</label>
                                                    <div class="form-check-grid">
                                                        @foreach ($daftar_projects as $project)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" onclick="logCheckedProjects()" name="project[]" id="project_{{ $project->nama_project }}" value="{{ $project->id }}"
                                                                {{ in_array($project->id, $materialProjectArray) ? 'checked disabled' : '' }}>
                                                                <label class="form-check-label" for="project_{{ $project->id }}">
                                                                    {{ $project->nama_project }}
                                                                </label>
                                                                <!-- Tambahkan input tersembunyi jika checkbox dinonaktifkan -->
                                                                @if(in_array($project->id, $materialProjectArray))
                                                                    <input type="hidden" name="project[]" value="{{ $project->id }}">
                                                                @endif
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="spek">Spesifikasi Material</label>
                                                    <input type="text" name="spek" class="form-control"
                                                        id="spek" value="{{ $stokMaterial->spek }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <strong>Foto Material (Opsional)</strong>
                                                    <br>
                                                    @if($stokMaterial->foto)
                                                    <input type="file" name="foto" id="foto" value="{{ $stokMaterial->foto }}" onchange="previewImage(event)">
                                                    @else
                                                    <input type="file" name="foto" id="foto" value="{{ old('foto') }}" onchange="previewImage(event)">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                @if($stokMaterial->foto)
                                                    <strong>Foto Lama</strong>
                                                    <br>
                                                    <img src="{{ asset('storage/material/' . $stokMaterial->foto) }}" style="max-width:100%; margin-top: 10px;">
                                                    @else
                                                    <strong>Foto Lama</strong>
                                                    <br>
                                                    <p class="text-center">Tidak ada Foto</p>
                                                    @endif
                                            </div>
                                            <div class="col">
                                                <strong>Foto Baru</strong>
                                                <br>
                                                <img id="preview" src="#" alt="Preview Image" style="display: none; max-width:100%; margin-top: 10px;">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div id="dynamicFormsContainer">
                                                    <!-- InnerHTML akan ditambahkan di sini -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="satuan">Satuan</label>
                                                    <input type="text" name="satuan" class="form-control"
                                                        id="satuan" value="{{ $stokMaterial->satuan }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="lokasi">Lokasi</label>
                                                    <select name="lokasi" class="form-select " disabled id="lokasi">
                                                        <option value="fabrikasi" {{ $stokMaterial->lokasi == 'fabrikasi' ? 'selected' : '' }}>Fabrikasi
                                                        </option>
                                                        <option value="finishing" {{ $stokMaterial->lokasi == 'finishing' ? 'selected' : '' }}>Finishing
                                                        </option>
                                                    </select>
                                                    <input type="hidden" name="lokasi" value="{{ $stokMaterial->lokasi }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select name="status" class="form-select" id="status">
                                                        <option value="consumables" {{ $stokMaterial->status == 'consumables' ? 'selected' : '' }}>consumables</option>
                                                        <option value="non_consumables" {{ $stokMaterial->status == 'non_consumables' ? 'selected' : '' }}>non_consumables</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <!-- Mengonversi array menjadi JSON string dan memasukkannya ke dalam input hidden -->
                                                <input type="hidden" name="hidden_project_awal" value="{{ json_encode($hiddenProjectAwal, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) }}">
                                                <button type="submit" class="btn btn-primary form-control">Submit</button>
                                            </div>
                                            <div class="col">
                                                <a onclick="history.back()" class="btn btn-outline-secondary form-control">Kembali</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
@endsection

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    

    <script>
        function logCheckedProjects() {
            var checkedProjects = document.querySelectorAll('input[name="project[]"]:checked:not(:disabled)');
            var dynamicFormsContainer = document.getElementById('dynamicFormsContainer');
            dynamicFormsContainer.innerHTML = ''; // Kosongkan dulu konten sebelum menambahkan yang baru
        
            checkedProjects.forEach(function(project) {
                var projectLabel = project.id;
                var projectValue = project.value;
                var formHTML = `
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="jumlah_${projectValue}">Jumlah untuk ${projectLabel}</label>
                                <input type="text" name="jumlah_${projectValue}" class="form-control" id="jumlah_${projectLabel}" value="{{ old('jumlah_${projectValue}') }}">
                            </div>
                        </div>
                    </div>
                `;
                dynamicFormsContainer.innerHTML += formHTML;
            });
        }
    </script>
    <script>
        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();
            
            reader.onload = function(){
                var imgElement = document.getElementById('preview');
                imgElement.src = reader.result;
                imgElement.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    </script>

    <!-- Bootstrap core JavaScript-->
            <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
            <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
            
            <!-- Core plugin JavaScript-->
            <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
            
            <!-- Custom scripts for all pages-->
            <script src="{{asset('js/sb-admin-2.min.js')}}"></script>
            
            <!-- Page level plugins -->
            <script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>
            
            <!-- Page level custom scripts -->
            <script src="{{asset('js/demo/chart-area-demo.js')}}"></script>
            <script src="{{asset('js/demo/chart-pie-demo.js')}}"></script>

</body>

