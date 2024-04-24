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
            <h6 class="m-0 font-weight-bold text-primary">BON PERMINTAAN MATERIAL</h6>
            <a class="btn btn-sm btn-outline-success" href="{{ route('bpms.create') }}">Input BPM</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>Nomor BPM</th>
                            <th>Project</th>
                            <th>Tanggal Permintaan</th>
                            <th>Daftar Material</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bpms as $bpm)
                        <tr>
                            <td>{{ $bpm->nomor_bpm }}</td>
                            <td>{{ $bpm->project }}</td>
                            <td>{{ $bpm->tgl_permintaan }}</td>
                            <td class="text-center">
                                <a class="btn btn-info btn-sm mr-2" href="{{ route('bpm.show', $bpm->nomor_bpm) }}"><i
                                        class="fas fa-eye"></i></a>
                            </td>
                            <td class="text-center">
                                <form id="deleteForm{{ $bpm->nomor_bpm }}"
                                    action="{{ route('bpm.destroy', $bpm->nomor_bpm) }}" method="POST" class="d-inline">
                                    <a class="btn btn-primary btn-sm mr-2"
                                        href="{{ route('bpm.edit', $bpm->nomor_bpm) }}"><i class="fas fa-edit"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete('{{ $bpm->nomor_bpm }}')"><i
                                            class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection

@section('extra-scripts')
<script>
    function confirmDelete(bpmId) {
            if (confirm('Apakah Anda yakin ingin menghapus BPM ini?')) {
                document.getElementById('deleteForm' + bpmId).submit();
            }
        }
</script>
@endsection