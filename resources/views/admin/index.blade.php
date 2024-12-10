@extends('admin.app')

@section('content')


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

@endsection