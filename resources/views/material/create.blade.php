<link href="{{url('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css')}}" rel="stylesheet">

<!-- Custom fonts for this template -->
<link href="{{ asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<link href="{{url('https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i')}}" rel="stylesheet">

<style>
    .form-check-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px; /* Optional: Space between checkboxes */
    }
</style>

<body id="page-top">

    <div id="wrapper">
        @include('admin.dashboard.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">

            
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                {{-- @include('admin/dashboard/header') --}}

                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header">
                                    Tambah Material
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
                                    <form method="post" action="{{ route('stok_material.store') }}" id="myForm" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="kode_material">Kode Material</label>
                                                    <input type="text" name="kode_material" class="form-control"
                                                        id="kode_material" value="{{old('kode_material')}}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="project">Project</label>
                                                    <div class="form-check-grid">
                                                        @foreach ($daftar_projects as $project)
                                                        <div class="form-check">
                                                            <input class="form-check-input" style="cursor:pointer" onclick="logCheckedProjects()"  type="checkbox" name="project[]" id="{{ $project->nama_project }}" value="{{ $project->id }}" {{ in_array($project->nama_project, old('project', [])) ? 'checked' : '' }}>
                                                            <label class="form-check-label" style="cursor:pointer" for="project_{{ $project->id }}">
                                                                {{ $project->nama_project }}
                                                            </label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="nama">Nama Material</label>
                                                    <input type="text" name="nama" class="form-control"
                                                        id="nama" value="{{old('nama')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="spek">Spesifikasi Material</label>
                                                    <input type="text" name="spek" class="form-control"
                                                        id="spek" value="{{old('spek')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="foto">Foto Material</label>
                                                    <input type="file" name="foto" class="form-control"
                                                        id="foto" value="{{old('foto')}}" onchange="previewImage(event)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <img id="preview" src="#" alt="Preview Image" style="display: none; max-height: 200px; margin-top: 10px;">
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
                                                        id="satuan" value="{{old('satuan')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="lokasi">Lokasi</label>
                                                    <select name="lokasi" class="form-select" id="lokasi">
                                                        <option selected disabled value="">--Pilih--</option>
                                                        <option value="fabrikasi" {{ old('lokasi') == 'fabrikasi' ? 'selected' : '' }}>Fabrikasi</option>
                                                        <option value="finishing" {{ old('lokasi') == 'finishing' ? 'selected' : '' }}>Finishing</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select name="status" class="form-select" id="status">
                                                        <option selected disabled value="">--Pilih--</option>
                                                        <option value="consumables" {{ old('status') == 'consumables' ? 'selected' : '' }}>Consumables</option>
                                                        <option value="non_consumables" {{ old('status') == 'non_consumables' ? 'selected' : '' }}>Non Consumables</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col">
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

            <!-- Footer -->
            @include('admin/dashboard/footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

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
            var checkedProjects = document.querySelectorAll('input[name="project[]"]:checked');
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

