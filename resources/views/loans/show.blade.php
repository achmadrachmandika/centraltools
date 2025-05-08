@extends('admin.app')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="m-0 font-weight-bold text-primary">Detail Peminjaman Material</h6>
            <small class="text-muted">Informasi lengkap tentang peminjaman ini</small>
        </div>
        <div>
            <a href="{{ route('loans.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            
            @if($loan->status !== 'dikembalikan')
                <a href="{{ route('loans.return-form', $loan->id) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-check-square"></i> Pengembalian Parsial
                </a>
                
                  {{-- <a href="{{ route('loans.return', $loan->id) }}" 
   class="btn btn-sm btn-success btn-return-all" 
   data-url="{{ route('loans.return', $loan->id) }}">
    <i class="fas fa-undo"></i> Kembalikan Semua
</a> --}}

            @endif
        </div>
    </div>

    <div class="card-body">
        <!-- Informasi Peminjaman -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title font-weight-bold">Informasi Proyek</h6>
                        <div class="row">
                            <div class="col-md-4 font-weight-bold">Proyek Peminjam:</div>
                            <div class="col-md-8">{{ $loan->peminjam->nama_project }}</div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 font-weight-bold">Kode Proyek:</div>
                            <div class="col-md-8">{{ $loan->peminjam->ID_Project }}</div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 font-weight-bold">Proyek Pemilik:</div>
                            <div class="col-md-8">{{ $loan->pemilik->nama_project }}</div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 font-weight-bold">Kode Pemilik:</div>
                            <div class="col-md-8">{{ $loan->pemilik->ID_Project }}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title font-weight-bold">Status Peminjaman</h6>
                        <div class="row">
                            <div class="col-md-4 font-weight-bold">Tanggal Pinjam:</div>
                            <div class="col-md-8">{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d-m-Y') }}</div>
                        </div>
                        
                        @if($loan->tanggal_dikembalikan)
                        <div class="row mt-2">
                            <div class="col-md-4 font-weight-bold">Tanggal Kembali:</div>
                            <div class="col-md-8">{{ \Carbon\Carbon::parse($loan->tanggal_dikembalikan)->format('d-m-Y') }}</div>
                        </div>
                        @endif
                        
                        <div class="row mt-2">
                            <div class="col-md-4 font-weight-bold">Status:</div>
                            <div class="col-md-8">
                                @if($loan->status === 'dipinjam')
                                    <span class="badge badge-warning">Dipinjam</span>
                                @elseif($loan->status === 'dikembalikan')
                                    <span class="badge badge-success">Dikembalikan</span>
                                @else
                                    <span class="badge badge-secondary">{{ $loan->status }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-4 font-weight-bold">Progress:</div>
                            <div class="col-md-8">
                                <div class="progress">
                                    @php $progressPercent = $totalItems > 0 ? ($returnedCount / $totalItems) * 100 : 0; @endphp
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progressPercent }}%"
                                         aria-valuenow="{{ $progressPercent }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ round($progressPercent) }}%
                                    </div>
                                </div>
                                <small class="text-muted">{{ $returnedCount }} dari {{ $totalItems }} item dikembalikan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Daftar Material -->
        <div class="table-responsive mt-4">
            <h6 class="font-weight-bold mb-3">Daftar Material yang Dipinjam</h6>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Material</th>
                        <th>Kode Material</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Satuan</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loan->details as $index => $detail)
                    <tr class="{{ $detail->status === 'dikembalikan' ? 'table-success' : '' }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detail->projectMaterial->material->nama }}</td>
                        <td>{{ $detail->projectMaterial->material->kode_material }}</td>
                        <td class="text-center">{{ $detail->jumlah }}</td>
                        <td class="text-center">{{ $detail->projectMaterial->material->satuan }}</td>
                        <td class="text-center">
                            @if($detail->status === 'dikembalikan')
                                <span class="badge badge-success">Dikembalikan</span>
                            @else
                                <span class="badge badge-warning">Dipinjam</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Riwayat Pengembalian -->
        @if($returnedCount > 0)
        <div class="mt-5">
            <h6 class="font-weight-bold mb-3">Riwayat Pengembalian</h6>
            <!-- Di sini bisa ditambahkan riwayat pengembalian jika diperlukan -->
            <p class="text-muted small">
                <i class="fas fa-info-circle"></i> 
                {{ $returnedCount }} item telah dikembalikan {{ $returnedCount == $totalItems ? 'seluruhnya' : 'sebagian' }}.
            </p>
        </div>
        @endif
    </div>
</div>

{{-- <script>
    $(document).ready(function () {
        $('body').on('click', '.btn-return-all', function (e) {
            e.preventDefault();
            const url = $(this).data('url');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Kembalikan semua material peminjaman ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, kembalikan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });
</script> --}}

@endsection