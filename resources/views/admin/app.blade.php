<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Central Tools-PPA</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/CT-ICON.png') }}">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Select2 CSS -->

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- jQuery (HARUS sebelum Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- CSS Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- JS Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Select2 JS -->


    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    

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
                    @yield('content')
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
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Sidebar Toggle Fix -->
    <script>
        $(document).ready(function () {
            $('#sidebarToggleTop').on('click', function () {
                $('body').toggleClass('sidebar-toggled');
                $('.sidebar').toggleClass('toggled');
            });
        });
    </script>



    <!-- Stack for additional scripts -->
    @stack('scripts')

</body>

</html>