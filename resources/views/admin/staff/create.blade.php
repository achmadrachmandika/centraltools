@extends('admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">Tambah Akun Staff</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

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

                    <form method="POST" action="{{ route('staff.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control form-control-lg" id="name"
                                value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg" id="email"
                                value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg" id="password"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="site" class="form-label">Site</label>
                            <input type="text" name="site" class="form-control form-control-lg" id="site"
                                value="{{ old('site', 'INKA Madiun') }}" required>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-between">
                            <a href="{{ route('staff.index') }}" class="btn btn-outline-secondary btn-lg">Kembali ke
                                Daftar Staff</a>
                            <button type="submit" class="btn btn-primary btn-lg">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection