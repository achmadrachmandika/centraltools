<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    @if(Auth::user()->hasRole('admin') || (Auth::user()->hasRole('staff')))
    <a class="nav-link" href="{{ url('/dashboard') }}">
    @else
    <a class="nav-link" href="#">
    @endif
        <div class="d-flex justify-content-center align-items-center">
            <img src="{{ asset('img/CT-LOGO-LIGHT.png') }}" alt="Dashboard" style="width: 80%;">
        </div>
    </a>

    <!-- Sidebar Toggle (Responsive) -->
        <button id="sidebarToggle" class="btn btn-link d-md-none rounded-circle mx-auto my-2">
            <i class="fa fa-bars text-white"></i>
        </button>
    <!-- Heading -->
    <div class="sidebar-heading">
        Central Tools
    </div>
 

    @if(Auth::user()->hasRole('user') || Auth::user()->hasRole('admin') || Auth::user()->hasRole('staff'))
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ request()->routeIs('stok_material_fabrikasi.index', 'stok_material_finishing.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStokMaterial"
             aria-expanded="true" aria-controls="collapseStokMaterial">
             <i class="fa fa-archive" aria-hidden="true"></i>
             <span>Stok Material</span>
         </a>
         <div id="collapseStokMaterial" class="collapse" aria-labelledby="headingStokMaterial" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                  {{-- <h6 class="collapse-header">Stok Material:</h6>  --}}
                 <a class="collapse-item {{ request()->routeIs('stok_material_fabrikasi.index') ? ' active' : '' }}" href="{{ route('stok_material_fabrikasi.index') }}">Fabrikasi</a>
                 <a class="collapse-item {{ request()->routeIs('stok_material_finishing.index') ? ' active' : '' }}" href="{{ route('stok_material_finishing.index') }}">Finishing</a>
             </div>
         </div>
     </li>
    
    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item {{ request()->routeIs('bagian.index') ? ' active' : '' }} ">
        <a class="nav-link" href="{{ route('bagian.index') }}">
            <i class="fas fa-fw fa-database"></i>
            <span>Bagian</span>
        </a>
    </li>

      <li class="nav-item {{ request()->routeIs('spm.index') ? ' active' : '' }} ">
        <a class="nav-link" href="{{ route('spm.index') }}">
            <i class="fas fa-fw fa-database"></i>
            <span>SPM</span>
        </a>
    </li>
    
    @if(Auth::user()->hasRole('admin') || (Auth::user()->hasRole('staff')))
    <li class="nav-item {{ request()->routeIs('bprm.index', 'bpm.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBprmBpm"
             aria-expanded="true" aria-controls="collapseBprmBpm">
             <i class="fa fa-archive" aria-hidden="true"></i>
             <span>BPRM-BPM</span>
         </a>
         <div id="collapseBprmBpm" class="collapse" aria-labelledby="headingBprmBpm" data-parent="#accordionSidebar">
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

    <li class="nav-item {{ request()->routeIs('loans.index') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('loans.index') }}">
            <i class="fas fa-fw fa-database"></i>
            <span>Daftar Peminjaman</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('laporan.laporan-bagian', 'laporan.laporan-tanggal','laporan.laporan-project') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan"
             aria-expanded="true" aria-controls="collapseLaporan">
             <i class="fa fa-archive" aria-hidden="true"></i>
             <span>Laporan BPRM</span>
         </a>
         <div id="collapseLaporan" class="collapse" aria-labelledby="headingLaporan" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <!-- {{-- <h6 class="collapse-header">Custom Components:</h6> --}} -->
                 <a class="collapse-item {{ request()->routeIs('laporan.laporan-bagian') ? ' active' : '' }}" href="{{ route('laporan.laporan-bagian') }}">Bagian</a>
                 <a class="collapse-item {{ request()->routeIs('laporan.laporan-material') ? ' active' : '' }}"
                    href="{{ route('laporan.laporan-material') }}">Material</a>
                 <a class="collapse-item {{ request()->routeIs('laporan.laporan-tanggal') ? ' active' : '' }}" href="{{ route('laporan.laporan-tanggal') }}">Tanggal</a>
                 <a class="collapse-item {{ request()->routeIs('laporan.laporan-project') ? ' active' : '' }}" href="{{ route('laporan.laporan-project') }}">Project</a>
                 
             </div>
         </div>
     </li>

     @if(Auth::user()->hasRole('admin'))
     <li class="nav-item {{ request()->routeIs('staff.index') ? ' active' : '' }} ">
        <a class="nav-link" href="{{ route('staff.index') }}">
            <i class="fas fa-fw fa-database"></i>
            <span>Daftar Staff</span>
        </a>
    </li>
    @endif
    @endif
    @endif
    <!-- End of Nav Item - Kode Material -->

</ul>




