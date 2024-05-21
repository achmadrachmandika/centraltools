<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Central Tools-Fabrikasi</title>

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    
        <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
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

                <!-- Topbar -->
                @include('admin/dashboard/header')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">BON PENYERAHAN MATERIAL</h6>
                            <div class="d-flex">
                                <input type="text" id="myInput" class="form-control" placeholder="Cari..." onkeyup="myFunction()"
                                    title="Ketikkan sesuatu untuk mencari">
                                <a class="btn form-control ml-2 btn-outline-success" href="{{ route('bprms.create') }}">Input BPRM</a>
                            </div>
                            
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="myTable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center" >Nomor BPRM</th>
                                            <th class="text-center">Nomor SPM</th>
                                            <th class="text-center" >Project</th>
                                            <th class="text-center" >Material</th>
                                            <th class="text-center" >Bagian</th>
                                            <th class="text-center" >Tanggal Pengajuan</th>
                                            <th class="text-center" >Daftar Material</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bprms as $bprm)
                                        <tr>
                                            <td class="text-center">{{ $bprm->nomor_bprm }}</td>
                                              <td class="text-center">{{ $bprm->no_spm }}</td>
                                            <td class="text-center">{{ $bprm->project }}</td>
                                            <td>
                                                @php
                                                    $kode_materials = [];
                                                    $nama_materials = [];
                                                    $formatted_materials = [];
                                            
                                                    for ($i = 1; $i <= 10; $i++) {
                                                        if (!empty($bprm["kode_material_$i"]) && !empty($bprm["nama_material_$i"])) {
                                                            $kode_material = $bprm["kode_material_$i"];
                                                            $nama_material = $bprm["nama_material_$i"];
                                                            $formatted_materials[] = " ($kode_material) $nama_material";
                                                        }
                                                    }
                                            
                                                    echo implode(',<br>', $formatted_materials);
                                                @endphp
                                            </td>
                                            <td class="text-center">{{ $bprm->bagian }}</td>
                                            <td class="text-center">{{ $bprm->tgl_bprm }}</td>
                                            <td class="text-center">
                                                @php
                                                $jumlah_materials = [];
                                                for ($i = 1; $i <= 10; $i++) { if (!empty($bprm["jumlah_material_$i"])) { $jumlah_materials[]=$bprm["jumlah_material_$i"];
                                                    } } echo implode(',<br>', $jumlah_materials);
                                                    @endphp
                                            </td>
                                            <td class="text-center"> <a class="btn btn-info btn-sm mr-2"
                                href="{{ route('bprm.show', ['bprm' => $bprm->nomor_bprm, 'id_notif' => $bprm->id_notif]) }}"> <i class="fas fa-eye"></i>
                                Lihat</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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

    <script>
        function myFunction() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("myInput");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("myTable");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        if (tr[i].getElementsByTagName("th").length > 0) {
                            continue; // Lewati baris yang berisi header
                        }
                        var found = false;
                        td = tr[i].getElementsByTagName("td");
                        for (var j = 0; j < td.length; j++) {
                            txtValue = td[j].textContent || td[j].innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                found = true;
                                break; // Hentikan loop jika ditemukan kecocokan
                            }
                        }
                        tr[i].style.display = found ? "" : "none";
                    }
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

{{-- @endsection --}}