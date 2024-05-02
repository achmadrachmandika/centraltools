<link href="{{url('css/sb-admin-2.css')}}" rel="stylesheet">

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin/dashboard/sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('admin/dashboard/header')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-md-12" style="min-width:75vw">

                                @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                                @endif

                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                        <h6 class="m-0 font-weight-bold text-primary">BON PENYERAHAN MATERIAL</h6>
                                    </div>

                                <div class="card-body">
                                        <div class="row">
                                            <div class="col-2 text-center bordered">
                                                <strong>Nomor BPRM</strong>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2 text-center bordered-no-top">
                                                {{ $bprm->nomor_bprm }}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col text-center bordered">
                                                Project
                                            </div>
                                            <div class="col text-center bordered-no-left">
                                                Tanggal Permintaan
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-center bordered-no-top-right">
                                                {{ $bprm->project }}
                                            </div>
                                            <div class="col text-center bordered-no-top">
                                                {{ $bprm->tgl_permintaan }}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-2 text-center bordered-no-right">
                                                Kode Sparepart
                                            </div>
                                            <div class="col text-center bordered-no-right">
                                                Nama Sparepart
                                            </div>
                                            <div class="col text-center bordered-no-right">
                                                Spesifikasi Sparepart
                                            </div>
                                            <div class="col-2 text-center bordered">
                                                Jumlah
                                            </div>
                                        </div>

                                        @for ($i = 1; $i <= 10; $i++)
                                            @if (!empty($bprm["kode_material_$i"]))
                                                <div class="row">
                                                    <div class="bordered-no-top-right col-2">
                                                        <p>{{ $bprm["kode_material_$i"] }}</p>
                                                    </div>
                                                    <div class="bordered-no-top-right col-4">
                                                        <p>{{ $bprm["nama_material_$i"] }}</p>
                                                    </div>
                                                    <div class="bordered-no-top-right col-4">
                                                        <p>{{ $bprm["spek_material_$i"] }}</p>
                                                    </div>
                                                    <div class="bordered-no-top col-2">
                                                        <p>{{ $bprm["jumlah_material_$i"] }} {{ $bprm["satuan_material_$i"] }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        @endfor

                                </div>
                                <a href="{{ route('bprm.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>
                            <!-- /.container-fluid -->

                        </div>
                        <!-- End of Main Content -->

                    </div>
                </div>
            </div>
            
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

    <!-- Logout Modal-->
    <!-- Include logout modal content -->

</body>

</html>

{{-- @endsection --}}