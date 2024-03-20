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

                    <!-- Card Container -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Material List</h6>
                            <a class="btn btn-sm btn-outline-success" href="{{ route('kode_material.create') }}"> Input Kode
                                    Material</a>
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id= "myTable" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 100px; white-space: nowrap;">Kode Material</th>
                                            <th style="width: 100px; white-space: nowrap;">Spesifikasi</th>
                                            <th style="width: 100px; white-space: nowrap;">Keterangan</th>
                                            <th style="width: 200px; white-space: nowrap;" class="text-center">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kodeMaterials as $kodeMaterial)
                                        {{-- @dd($kodeMaterial->kode_material) --}}
                                        <tr>
                                            <td>{{ $kodeMaterial->kode_material }}</td>
                                            <td style="width: 100px; white-space: nowrap;">{{ $kodeMaterial->spek }}</td>
                                            <td style="width: 100px; white-space: nowrap;">{{ $kodeMaterial->keterangan }}</td>
                                            <td>
                                                <form action="{{ route('kode_material.destroy', $kodeMaterial->kode_material) }}" method="POST"
                                                    class="text-center">
                                                    <a class="btn btn-info mr-2" href="{{ route('kode_material.show', $kodeMaterial->kode_material) }}">Show</a>
                                                    <a class="btn btn-primary mr-2"
                                                        href="{{ route('kode_material.edit', $kodeMaterial->kode_material) }}">Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End Card Container -->
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