@extends('admin.app')

@push('styles')
<style>
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1) !important;
    }

    .dashboard-card {
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        background: linear-gradient(135deg, var(--from), var(--to));
        color: white;
    }

    .dashboard-card .card-body {
        padding: 1.5rem 1.25rem;
    }

    .dashboard-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1f2937;
    }

    .text-muted-sub {
        font-size: 0.95rem;
        color: #6b7280;
    }
</style>
@endpush


@section('content')

<!-- Notifikasi Login -->
@if(session('success'))
<div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
{{-- @if (session('success'))
<div id="alert-success" class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Selamat datang</strong> {{ session('success') }}
</div>
@endif --}}

<div class="container-fluid">
    <!-- Page Heading -->
    <div>
            <h1 class="dashboard-title">Dashboard Central Tools</h1>
            <p class="text-muted-sub">Informasi pada setiap card menunjukkan jumlah data yang telah tercatat untuk masing-masing jenis aktivitas di sistem
            Central Tools</p>
        </div>

    <!-- Content Row -->
    <div class="row">
        @php
        $cards = [
        ['title' => 'TOTAL SPM', 'count' => $spm->count(), 'route' => route('spm.index'), 'icon' => 'fas fa-database',
        'colors' => ['#81C784', '#4CAF50']],
        ['title' => 'TOTAL PROYEK', 'count' => $projects->count(), 'route' => route('project.index'), 'icon' => 'fas
        fa-folder', 'colors' => ['#64B5F6', '#1E88E5']],
        ['title' => 'TOTAL RENCANA', 'count' => $bom->count(), 'route' => route('bom.index'), 'icon' => 'fas
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
