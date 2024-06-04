<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPRM-Show</title>
    <!-- Link CSS -->
    <link href="{{url('css/sb-admin-2.css')}}" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin/dashboard/sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container bordered bg-white mt-3">
                    <div id="printPage" class='mt-3 bordered'>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-2 text-center"><img style="width:100%"
                                            src="{{ asset('img/logo-inka.png') }}" alt="logo inka"></div>
                                    <div class="col-8 text-center"></div>
                                    <div class="col-2 text-center"></div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p class=" text-center page-title" style="font-size: 24px;">BERITA ACARA SERAH TERIMA BARANG</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-2 text-center bordered">
                                            <strong>Nomor BPRM</strong>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-2 text-center bordered">
                                            <strong>Nama Admin</strong>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-2 text-center bordered-no-top">
                                            {{ $bprm->nomor_bprm }}
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-2 text-center bordered-no-top">
                                            {{ $bprm->nama_admin }}
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col">
                                            <p>Kami yang bertanda tangan dibawah ini</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                            <p>Nama</p>
                                        </div>
                                        <div class="col">
                                            : {{ $bprm->nama_admin }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                            <p>Jabatan</p>
                                        </div>
                                        <div class="col">
                                            :
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                            <p>Bagian</p>
                                        </div>
                                        <div class="col">
                                            :
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>Selanjutnya disebut <b>PIHAK PERTAMA</b>.</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                            <p>Nama</p>
                                        </div>
                                        <div class="col">
                                            :
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                            <p>Jabatan</p>
                                        </div>
                                        <div class="col">
                                            :
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                            <p>Bagian</p>
                                        </div>
                                        <div class="col">
                                            : {{ $bprm->bagian }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>Selanjutnya disebut <b>PIHAK KEDUA</b>.</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p><b>PIHAK PERTAMA</b> menyerahkan barang berupa peralatan/tools untuk kebutuhan pengerjaan proyek {{ $bprm->project }} kepada <b>PIHAK KEDUA</b> dan <b>PIHAK KEDUA</b> menyatakan telah menerima barang dari <b>PIHAK PERTAMA</b> berupa :</p>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="row">
                                        <div class="col text-center bordered">
                                            <strong>Project</strong>
                                        </div>
                                        <div class="col text-center bordered-no-left">
                                            <strong>Bagian</strong>
                                        </div>
                                        <div class="col text-center bordered-no-left">
                                            <strong>Tanggal BPRM</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-center bordered-no-top-right">
                                            {{ $bprm->project }}
                                        </div>
                                        <div class="col text-center bordered-no-top-right">
                                            {{ $bprm->bagian }}
                                        </div>
                                        <div class="col text-center bordered-no-top">
                                            {{ $bprm->tgl_bprm }}
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-2 text-center bordered-no-right">
                                           <strong> Kode Sparepart </strong>
                                        </div>
                                        <div class="col text-center bordered-no-right">
                                           <strong> Nama Sparepart </strong>
                                        </div>
                                        <div class="col text-center bordered-no-right">
                                            <strong> Spesifikasi Sparepart </strong>
                                        </div>
                                        <div class="col-2 text-center bordered">
                                            <strong>Jumlah</strong>
                                        </div>
                                    </div>
                                    @for ($i = 1; $i <= 10; $i++) @if (!empty($bprm["kode_material_$i"])) <div
                                        class="row">
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
                                    <div class="row mt-3">
                                        <div class="col-7"></div>
                                        <div class="col bordered text-center"
                                            style="height: 180px;display:flex;justify-content: space-between;flex-direction: column">
                                            <h6>Yang Menyerahkan <br> Pihak Pertama</h6>
                                            <h6>{{ $bprm->nama_admin }}</h6>
                                        </div>
                                        <div class="col bordered text-center" style="height: 180px;display:flex;justify-content: space-between;flex-direction: column">
                                            <h6>Yang Menerima <br> Pihak Kedua</h6>
                                            <h6></h6>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col text-center">
                    <a onclick="generatePDF()" class="btn btn-success">Cetak PDF</a>
                    <a href="{{ route('bprm.index') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
            <!-- End Page Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- PrintThis Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"
        integrity="sha512-d5Jr3NflEZmFDdFHZtxeJtBzk0eB+kkRXWFQqEc1EKmolXjHm2IKCA7kTvXBNjIYzjXfD5XzIjaaErpkZHCkBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Script untuk Cetak PDF -->
    <script>
        function generatePDF() {
                $('#printPage').printThis();
            }
    </script>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <!-- Include logout modal content -->

</body>

</html>