@extends('admin.app')

@section('content')
<script>
    $(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Pilih--",
                allowClear: true,
                width: '100%' // biar responsif di dalam Bootstrap
            });
        });
</script>
<div class="container-fluid">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12" style="min-width:80vw">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Form Peminjaman Material Antar Proyek
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Terdapat beberapa masalah dengan inputan Anda.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form method="post" action="{{ route('loans.store') }}" id="myForm">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="project_peminjam_id" class="form-label">Proyek Peminjam</label>
                                        <select class="select2" id="project_peminjam_id" class="form-select"
                                            required>
                                            <option value="">-- Pilih Proyek Peminjam --</option>
                                            @foreach($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->nama_project }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="lokasi" class="form-label">Lokasi</label>
                                        <select class="select2" id="lokasi" class="form-select" onchange="loadMaterials()"
                                            required>
                                            <option value="">-- Pilih Lokasi --</option>
                                            <option value="fabrikasi">Fabrikasi</option>
                                            <option value="finishing">Finishing</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="project_pemilik_id" class="form-label">Proyek Pemilik
                                            Material</label>
                                        <select class="select2" id="project_pemilik_id" class="form-select"
                                            onchange="loadMaterials()" required>
                                            <option value="">-- Pilih Proyek Pemilik --</option>
                                            @foreach($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->nama_project }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                                            class="form-control" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div id="material-list" class="mt-4"></div>

                            <div class="row mt-4">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary form-control">Simpan
                                        Peminjaman</button>
                                </div>
                                <div class="col">
                                    <a href="{{ route('loans.index') }}"
                                        class="btn btn-secondary form-control">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div> <!-- end card-body -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- CSS Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- JS Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    function loadMaterials() {
        const projectId = document.getElementById('project_pemilik_id').value;
        const lokasi = document.getElementById('lokasi').value;

        if (!projectId || !lokasi) {
            document.getElementById('material-list').innerHTML = '';
            return;
        }

        const url = new URL(`/materials/by-project/${projectId}`, window.location.origin);
        url.searchParams.append('lokasi', lokasi);

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Server error: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.length === 0) {
                    document.getElementById('material-list').innerHTML =
                        '<p class="text-danger">Tidak ada material tersedia di lokasi ini.</p>';
                    return;
                }

                let html = `
                    <h5 class="mb-3">Material Tersedia</h5>
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Material</th>
                                <th>Jumlah Tersedia</th>
                                <th>Jumlah Pinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                data.forEach(item => {
                    html += `
                        <tr>
                            <td>${item.material.nama_material}</td>
                            <td>${item.jumlah}</td>
                            <td>
                                <input type="number" name="materials[${item.id}]" class="form-control" min="0" max="${item.jumlah}" value="0">
                            </td>
                        </tr>
                    `;
                });

                html += `
                        </tbody>
                    </table>
                    </div>
                `;

                document.getElementById('material-list').innerHTML = html;
            })
            .catch(error => {
                console.error(error);
                document.getElementById('material-list').innerHTML = `<p class="text-danger">Gagal memuat material: ${error.message}</p>`;
            });
    }
</script>
@endpush