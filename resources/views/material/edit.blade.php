<link href="{{url('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css')}}" rel="stylesheet">

<!-- Custom fonts for this template -->
<link href="{{ asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<link href="{{url('https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i')}}" rel="stylesheet">

<body id="page-top">

    <div id="wrapper">
        @include('admin.dashboard.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">

            
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                @include('admin/dashboard/header')

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
                                    <form method="post"
                                        action="{{ route('stok_material.update', ['stok_material' => $stokMaterial->kode_material]) }}" id="myForm">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="kode_material">Kode Material</label>
                                                    <input type="text" name="kode_material" class="form-control"
                                                        id="kode_material" value="{{ $stokMaterial->kode_material}}">
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
                                                    <label for="jumlah">Jumlah</label>
                                                    <input type="text" name="jumlah" class="form-control"
                                                    id="jumlah" value="{{ $stokMaterial->jumlah }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="satuan">Satuan</label>
                                                    <input type="text" name="satuan" class="form-control"
                                                        id="satuan" value="{{ $stokMaterial->satuan }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="lokasi">Lokasi</label>
                                                    <input type="text" name="lokasi" class="form-control"
                                                        id="lokasi" value="{{ $stokMaterial->lokasi }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="project">Project</label>
                                                    <input type="text" name="project" class="form-control"
                                                        id="project" value="{{ $stokMaterial->project }}">
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="status">status</label>
                                                    <input type="text" name="status" class="form-control" id="status" value="{{ $stokMaterial->status }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <button type="submit" class="btn btn-primary form-control">Submit</button>
                                            </div>
                                            <div class="col">
                                                <a href="{{ route('stok_material.index') }}" class="btn btn-outline-secondary form-control">Kembali</a>
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

