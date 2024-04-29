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
                        <div class="row justify-content-center">
                            <div class="col-md-12" style="min-width:75vw">

                                @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                                @endif

                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                        <h6 class="m-0 font-weight-bold text-primary">BILL OF MATERIALS</h6>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-2 text-center bordered">
                                                <strong>Nomor BOM</strong>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2 text-center bordered-no-top">
                                                {{ $bom->nomor_bom }}
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
                                                {{ $bom->project }}
                                            </div>
                                            <div class="col text-center bordered-no-top">
                                                {{ $bom->tgl_permintaan }}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-1 text-center bordered-no-right">
                                                No
                                            </div>
                                            <div class="col-2 text-center bordered-no-right">
                                                Deskripsi Material
                                            </div>
                                            <div class="col-1 text-center bordered-no-right">
                                                Kode Material
                                            </div>
                                            <div class="col-3 text-center bordered-no-right">
                                                Spesifikasi Material
                                            </div>
                                            <div class="col-1 text-center bordered-no-right">
                                                QTY FAB
                                            </div>
                                            <div class="col-1 text-center bordered-no-right">
                                                QTY FIN
                                            </div>
                                            <div class="col-1 text-center bordered-no-right">
                                                Total Material
                                            </div>
                                            <div class="col-1 text-center bordered">
                                                Satuan
                                            </div>
                                            <div class="col-1 text-center bordered">
                                                Aksi
                                            </div>
                                            {{-- <div class="col text-center bordered-no-right">
                                                Keterangan
                                            </div>
                                            <div class="col text-center bordered-no-right">
                                                Revisi
                                            </div> --}}
                                        </div>
                                        @foreach($materials as $material)
                                            <div class="row">
                                                <div class="bordered-no-top-right col-1">
                                                    <p>{{ $material->no }}</p>
                                                </div>
                                                <div class="bordered-no-top-right col-2">
                                                    <p>{{ $material->desc_material }}</p>
                                                </div>
                                                <div class="bordered-no-top-right col-1">
                                                    <p>{{ $material->kode_material }}</p>
                                                </div>
                                                <div class="bordered-no-top-right col-3">
                                                    <p>{{ $material->spek_material }}</p>
                                                </div>
                                                <div class="bordered-no-top-right col-1">
                                                    <p>{{ $material->qty_fab }}</p>
                                                </div>
                                                <div class="bordered-no-top-right col-1">
                                                    <p>{{ $material->qty_fin }}</p>
                                                </div>
                                                <div class="bordered-no-top-right col-1">
                                                    <p>{{ $material->total_material }}</p>
                                                </div>
                                                <div class="bordered-no-top-right col-1">
                                                    <p>{{ $material->satuan_material }}</p>
                                                </div>
                                                <div class="bordered-no-top col-1">
                                                    <form id="deleteForm{{ $material->no_material_pada_bom }}" action="{{ route('material.destroy', $material->no_material_pada_bom) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="{{ route('material.edit', $material->no_material_pada_bom) }}" class="btn btn-primary btn-sm mr-2">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                                {{-- <div class="bordered-no-top-right col-2">
                                                    <p>{{ $material->keterangan }}</p>
                                                </div>
                                                <div class="bordered-no-top-right col-2">
                                                    <p>{{ $material->revisi }}</p>
                                                </div> --}}

                                            </div>
                                        @endforeach

                                </div>
                                <a href="{{ route('bom.index',$material->nomor_bom) }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                        <!-- /.container-fluid -->

                    </div>
                    <!-- End of Main Content -->

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