@extends('admin.app')

@section('content')
<div class="container-fluid">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12" style="min-width:75vw">

                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold">BON PERMINTAAN MATERIAL</h6>
                      
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5><strong>Nomor BPM:</strong> {{ $bpm->no_bpm }}</h5>
                                <h6><strong>Project:</strong> {{ $bpm->project }}</h6>
                                <h6><strong>Tanggal Permintaan:</strong> {{ $bpm->tgl_permintaan }}</h6>
                            </div>
                        </div>

                        <div class="table-responsive mt-4">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-dark text-center">
                                    <tr>
                                        <th>Kode Material</th>
                                        <th>Nama Material</th>
                                        <th>Spesifikasi</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bpm->bpmMaterials as $material)
                                    <tr class="text-center">
                                     <td class="{{ $material->material ? '' : 'bg-danger text-white' }}">
                                            {{ $material->material->kode_material ?? 'Tidak Ditemukan' }}
                                        </td>
                                        <td class="{{ $material->material ? '' : 'bg-danger text-white' }}">
                                            {{ $material->material->nama ?? 'Tidak Ditemukan' }}
                                        </td>
                                        <td class="{{ $material->material ? '' : 'bg-danger text-white' }}">
                                            {{ $material->material->spek ?? 'Tidak Ditemukan' }}
                                        </td>
                                        <td>{{ $material->jumlah_material }} {{ $material->satuan_material }}</td>
                                    </tr>
                                    @endforeach
                                    @if ($bpm->bpmMaterials->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Tidak ada material</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('bpm.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Bootstrap & jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection