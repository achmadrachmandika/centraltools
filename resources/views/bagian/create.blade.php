@extends('admin.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Lokasi Bagian</h5>
                    <small class="text-red-50">Catatan: Lokasi harus diawali dengan "lokasi-" (misalnya fabrikasi-tempat).</small>
                    <!-- Menambahkan catatan di bawah judul -->
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
                    <form method="post" action="{{ route('bagian.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_bagian" class="form-label">Nama Bagian</label>
                            <input type="text" name="nama_bagian" class="form-control" id="nama_bagian"
                                value="{{ old('nama_bagian') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <select name="lokasi" class="form-select" id="lokasi" required>
                                <option value="" disabled selected>-- Pilih Lokasi --</option>
                                <option value="fabrikasi" {{ old('lokasi')=='fabrikasi' ? 'selected' : '' }}>Fabrikasi
                                </option>
                                <option value="finishing" {{ old('lokasi')=='finishing' ? 'selected' : '' }}>Finishing
                                </option>
                            </select>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('bagian.index') }}" class="btn btn-secondary me-md-2">Kembali</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection