@extends('admin.app')

@push('styles')
@endpush

@section('content')

<!-- Notifikasi Login -->
@if (session('success'))
<div id="alert-success" class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Login Berhasil!</strong> {{ session('success') }}
</div>
@endif

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">CENTRAL TOOLS</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        @php
        $cards = [
        ['title' => 'TOTAL SPM', 'count' => $spm->count(), 'route' => route('spm.index'), 'icon' => 'fas fa-database',
        'colors' => ['#81C784', '#4CAF50']],
        ['title' => 'TOTAL PROJECT', 'count' => $projects->count(), 'route' => route('project.index'), 'icon' => 'fas
        fa-folder', 'colors' => ['#64B5F6', '#1E88E5']],
        ['title' => 'TOTAL BOM', 'count' => $bom->count(), 'route' => route('bom.index'), 'icon' => 'fas
        fa-clipboard-list', 'colors' => ['#FFB74D', '#FB8C00']],
        ['title' => 'TOTAL BPM', 'count' => $bpm->count(), 'route' => route('bpm.index'), 'icon' => 'fas fa-sign-in-alt',
        'colors' => ['#BA68C8', '#8E24AA']],
        ['title' => 'TOTAL BPRM', 'count' => $bprm->count(), 'route' => route('bprm.index'), 'icon' => 'fas fa-sign-out-alt', 'colors' => ['#EF5350', '#E53935']],
        ];
        @endphp

        @foreach ($cards as $card)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden position-relative card-hover"
                style="background: linear-gradient(135deg, {{ $card['colors'][0] }}, {{ $card['colors'][1] }}); color: white;">
                <a href="{{ $card['route'] }}" class="text-decoration-none">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">{{ $card['title'] }}</div>
                                <div class="h5 mb-0 font-weight-bold">{{ $card['count'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="{{ $card['icon'] }} fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let alertSuccess = document.getElementById("alert-success");
        if (alertSuccess) {
            setTimeout(() => {
                alertSuccess.style.transition = "opacity 0.5s ease-out";
                alertSuccess.style.opacity = "0";
                setTimeout(() => alertSuccess.remove(), 500);
            }, 5000);
        }
    });
</script>
@endpush