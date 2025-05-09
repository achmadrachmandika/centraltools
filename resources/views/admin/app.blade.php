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

    <!-- PILIH SALAH SATU VERSI BOOTSTRAP - Disarankan Bootstrap 5 karena DataTables 2.3.0 -->
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.3.0/css/dataTables.bootstrap5.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- jQuery (load SEBELUM Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CSS Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    
    <!-- Bootstrap 5 JS -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap5.js"></script>
    
    <!-- Select2 JS (setelah jQuery) -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 500);
                }
            }, 5000);
        });
    </script>
    {{-- <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"> </script> --}}
    {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"> </script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.3.0/js/dataTables.js"> </script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap5.js"> </script> --}}

    {{-- <script>
        $(document).ready(function () {
            $('#sidebarToggleTop').on('click', function () {
                $('body').toggleClass('sidebar-toggled');
                $('.sidebar').toggleClass('toggled');
            });
        });
    </script>



    <!-- Stack for additional scripts -->
    @stack('scripts') --}}

</body>

</html>