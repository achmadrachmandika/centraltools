<!-- Bootstrap core CSS -->
<link href="{{url('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css')}}" rel="stylesheet">

<!-- Custom fonts for this template -->
<link href="{{url('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<link href="{{url('https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i')}}" rel="stylesheet">

<link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    @if(Auth::user()->hasRole('admin'))
    <a class="nav-link" href="{{ url('/dashboard') }}">
    @else
    <a class="nav-link" href="#">
    @endif
        <div class="d-flex justify-content-center align-items-center">
            <img src="{{ asset('img/ppa.png') }}" alt="Dashboard" style="width: 80%;">
        </div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    {{-- <li class="nav-item active">
        <a class="nav-link" href="{{ url('/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li> --}}
    <!-- End of Nav Item - Dashboard -->

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Central Tools
    </div>

    @if(Auth::user()->hasRole('user') || Auth::user()->hasRole('admin'))
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ request()->routeIs('stok_material.index') ? ' active' : '' }} ">
        <a class="nav-link" href="{{ route('stok_material.index') }}">
            <i class="fas fa-fw fa-database"></i>
            <span>Stok Material</span>
        </a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item {{ request()->routeIs('spm.index') ? ' active' : '' }} ">
        <a class="nav-link" href="{{ route('spm.index') }}">
            <i class="fas fa-fw fa-database"></i>
            <span>SPM</span>
        </a>
    </li>
    @if(Auth::user()->hasRole('admin'))
    <li class="nav-item {{ request()->routeIs('bprm.index', 'bpm.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
             aria-expanded="true" aria-controls="collapseTwo">
             <i class="fa fa-archive" aria-hidden="true"></i>
             <span>BPRM-BPM</span>
         </a>
         <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                 <a class="collapse-item {{ request()->routeIs('bprm.index') ? ' active' : '' }}" href="{{ route('bprm.index') }}">BPRM</a>
                 <a class="collapse-item {{ request()->routeIs('bpm.index') ? ' active' : '' }}" href="{{ route('bpm.index') }}">BPM</a>
             </div>
         </div>
     </li>

     <li class="nav-item {{ request()->routeIs('bom.index') ? ' active' : '' }} ">
        <a class="nav-link"  href="{{ route('bom.index') }}">
            <i class="fas fa-fw fa-database"></i>
            <span>Bill Of Materials (BOM)</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('project.index') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('project.index') }}">
            <i class="fas fa-fw fa-database"></i>
            <span>Daftar Project</span>
        </a>
    </li>
    @endif
    @endif
    <!-- End of Nav Item - Kode Material -->

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->

<!-- JavaScript for Sidebar Toggle -->

<!-- Bootstrap core JavaScript-->
        <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        
        <!-- Core plugin JavaScript-->
        <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
        
        <!-- Custom scripts for all pages-->
        <script src="{{asset('js/sb-admin-2.min.js')}}"></script>
        
        <!-- Page level plugins -->
        {{-- <script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script> --}}
        
        <!-- Page level custom scripts -->
        {{-- <script src="{{asset('js/demo/chart-area-demo.js')}}"></script>
        <script src="{{asset('js/demo/chart-pie-demo.js')}}"></script> --}}
