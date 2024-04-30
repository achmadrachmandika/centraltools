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
                            <a class="btn btn-sm btn-outline-success" href="{{ route('bprms.create') }}">Input BPRM</a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="myTable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px; white-space: nowrap;">Nomor BPRM</th>
                                            <th style="width: 50px; white-space: nowrap;">Nomor SPM</th>
                                            <th style="width: 50px; white-space: nowrap;">Project</th>
                                            <th style="width: 50px; white-space: nowrap;">Tanggal Pengajuan</th>
                                            <th style="width: 50px; white-space: nowrap;">Daftar Material</th>
                                            <th style="width: 200px; white-space: nowrap;" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bprms as $bprm)
                                        <tr>
                                            <td>{{ $bprm->nomor_bprm }}</td>
                                            <td>{{ $bprm->no_spm }}</td>
                                            <td>{{ $bprm->project }}</td>
                                            <td>{{ $bprm->tgl_bprm }}</td>
                                            <td class="text-center"> <a class="btn btn-info btn-sm mr-2 "
                                                href="{{ route('bprm.show', $bprm->nomor_bprm) }}"><i
                                                    class="fas fa-eye"></i> Lihat</a></td>
                                            <td>
                                                <form action="{{ route('bprm.destroy', $bprm->nomor_bprm) }}" method="POST"
                                                    class="d-flex justify-content-center">
                                                    
                                                    <!-- Menambahkan ikon mata untuk tindakan Show -->
                                                    <a class="btn btn-primary btn-sm mr-2"
                                                        href="{{ route('bprm.edit', $bprm->nomor_bprm) }}"><i
                                                            class="fas fa-edit"></i> Edit</a>
                                                    <!-- Menambahkan ikon pensil untuk tindakan Edit -->
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="fas fa-trash-alt"></i> Hapus</button>
                                                    <!-- Menambahkan ikon tong sampah untuk tindakan Delete -->
                                                </form>
                                            </td>
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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <!-- Include logout modal content -->

</body>

</html>

{{-- @endsection --}}