@extends('admin.app')

@section('content')


<!-- Begin Page Content -->
<div class="container-fluid">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">SURAT PERMINTAAN MATERIAL</h6>
            <a class="btn btn-sm btn-outline-success" href="{{ route('spms.create') }}">Input SPM</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
              <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered">
                        <thead class="bg-primary text-white">
                            <tr class="text-center">
                                <th>Kode SPM</th>
                                <th>Project</th>
                                <th>Tanggal SPM</th>
                                <th>Keterangan SPM</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($spms as $spm)
                            <tr>
                                <td>{{ $spm->no_spm }}</td>
                                <td>{{ $spm->project }}</td>
                                <td>{{ $spm->tgl_spm }}</td>
                                <td>{{ $spm->keterangan_spm }}</td>
                                <td class="text-center">
                                    <a class="btn btn-info btn-sm mr-2" href="{{ route('spm.show', $spm->id) }}">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <form action="{{ route('spm.destroy', $spm->id) }}" method="POST" class="d-inline">
                                        {{-- <a class="btn btn-primary btn-sm mr-2" href="{{ route('spm.edit', $spm->id) }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </a> --}}
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection

@section('extra-scripts')
<script>
    function confirmDelete(spmId) {
        if (confirm("Apakah Anda yakin ingin menghapus SPM dengan ID " + spmId + "?")) {
            document.getElementById('deleteForm' + spmId).submit();
        }
    }
</script>
@endsection