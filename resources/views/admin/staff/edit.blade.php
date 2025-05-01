@extends('admin.app')

@section('content')
<div class="container">
    <h2>Edit Akun Staff</h2>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('staff.update', $staff->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $staff->name) }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $staff->email) }}" required>
        </div>

        <div class="form-group">
            <label>Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label>Site</label>
            <input type="text" name="site" class="form-control" value="{{ old('site', $staff->site) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection