<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Central Tools-PPA</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .card:hover {
            cursor: pointer;
            transform: scale(1.05);
            /* Atau animasi lain sesuai kebutuhan */
            transition: transform 0.3s ease;
            /* Atur durasi dan jenis animasi yang diinginkan */
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
        <a class="nav-link" href="{{ url('/dashboard') }}">
            <div class="d-flex justify-content-center align-items-center">
                <img src="{{ asset('img/ppa.png') }}" alt="Dashboard" style="width: 80%">
            </div>
        </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
         


            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Central Tools
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('stok_material.index') }}">
                    <i class="fas fa-fw fa-database"></i>
                    <span>Stok Material</span>
                </a>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('spm.index') }}">
                    <i class="fas fa-fw fa-database"></i>
                    <span>SPM</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                     aria-expanded="true" aria-controls="collapseTwo">
                     <i class="fa fa-archive" aria-hidden="true"></i>
                     <span>BPRM-BPM</span>
                 </a>
                 <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                     <div class="bg-white py-2 collapse-inner rounded">
                         {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                         <a class="collapse-item" href="{{ route('bprm.index') }}">BPRM</a>
                         <a class="collapse-item" href="{{ route('bpm.index') }}">BPM</a>
                     </div>
                 </div>
             </li>

             <li class="nav-item">
                <a class="nav-link" href="{{ route('bom.index') }}">
                    <i class="fas fa-fw fa-database"></i>
                    <span>Bill Of Materials (BOM)</span>
                </a>
            </li>

            <li class="nav-item{{ request()->routeIs('project.index') ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('project.index') }}">
                    <i class="fas fa-fw fa-database"></i>
                    <span>Daftar Project</span>
                </a>
            </li>

            <li class="nav-item{{ request()->routeIs('laporan.index') ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('laporan.index') }}">
                    <i class="fas fa-fw fa-database"></i>
                    <span>Laporan BPRM</span>
                </a>
            </li>

            

            

          

            <!-- Divider -->
            {{-- <hr class="sidebar-divider"> --}}

            <!-- Heading -->
            {{-- <div class="sidebar-heading">
                Addons
            </div> --}}

            <!-- Nav Item - Pages Collapse Menu -->

            <!-- Nav Item - Charts -->

            <!-- Nav Item - Tables -->

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">  
                                <form  action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item" style="cursor:pointer">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">CENTRAL TOOLS</h1>
                    </div>
                
                    <!-- Content Row -->
                    <div class="row">
                
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2 position-relative">
                                <a href="{{ route('spm.index')}}">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    TOTAL SPM
                                                </div>
                                                <div style="display:flex">
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $spm->count() }}
                                                    </div>
                                                    <div class="mx-3 translate-middle badge rounded-pill bg-danger" id="unreadBadge"
                                                        style="display: none;">
                                                        <span class="h6 text-uppercase text-white px-2 py-1"><span
                                                                class="data-count"></span> Baru</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-database fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2 position-relative">
                                <a href="{{ route('project.index')}}">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    TOTAL PROJECT
                                                </div>
                                                <div style="display:flex">
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $projects->count() }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-database fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                           <div class="card border-left-warning shadow h-100 py-2 position-relative">
                                <a href="{{ route('bom.index')}}">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    TOTAL BOM
                                                </div>
                                                <div style="display:flex">
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $bom->count() }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                
                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                          <div class="card border-left-success shadow h-100 py-2 position-relative">
                            <a href="{{ route('stok_material.index')}}">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                TOTAL MATERIAL
                                            </div>
                                            <div style="display:flex">
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stokMaterials->count() }}
                                                </div>
                                                <div class="mx-3 translate-middle badge rounded-pill bg-danger" id="unreadBadge"
                                                    style="display: none;">
                                                    <span class="h6 text-uppercase text-white px-2 py-1"><span class="data-count"></span>
                                                        Baru</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        </div>
                
                        <div class="col-xl-3 col-md-6 mb-4">
                           <div class="card border-left-primary shadow h-100 py-2 position-relative">
                            <a href="{{ route('bpm.index')}}">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                TOTAL BPM
                                            </div>
                                            <div style="display:flex">
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $bpm->count() }}
                                                </div>
                                                <div class="mx-3 translate-middle badge rounded-pill bg-danger" id="unreadBadge"
                                                    style="display: none;">
                                                    <span class="h6 text-uppercase text-white px-2 py-1"><span class="data-count"></span>
                                                        Baru</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                          <div class="card border-left-warning shadow h-100 py-2 position-relative">
                            <a href="{{ route('bprm.index')}}">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                TOTAL BPRM
                                            </div>
                                            <div style="display:flex">
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $bprm->count() }}
                                                </div>
                                                <div class="mx-3 translate-middle badge rounded-pill bg-danger" id="unreadBadge"
                                                    style="display: none;">
                                                    <span class="h6 text-uppercase text-white px-2 py-1"><span class="data-count"></span>
                                                        Baru</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        
                        </div>
                    </div>
                
                </div>

            </div>
                <!-- /.container-fluid -->
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Periksa notifikasi yang belum dilihat saat halaman dimuat
            checkUnreadNotifications();
    
            // Fungsi untuk memeriksa notifikasi yang belum dilihat
            function checkUnreadNotifications() {
                fetch("{{ url('/notifications/unread') }}")
                    .then(response => response.json())
                    .then(data => {
                        const unreadBadge = document.getElementById('unreadBadge');
                        const dataCount = document.querySelector('.data-count');
                        
                        if (data.count > 0) {
                            // Tampilkan notifikasi kepada pengguna
                            dataCount.textContent = data.count;
                            unreadBadge.style.display = 'block'; // Tampilkan elemen
                        } else {
                            unreadBadge.style.display = 'none'; // Sembunyikan elemen
                        }
                    });
            }
        });
    </script>

</body>

</html>