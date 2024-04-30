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
                            {{-- <th>Kode Material</th> --}}
                            <th>Project</th>
                            <th>Tanggal Permintaan</th>
                            <th>Status</th>
                            <th>Daftar Material</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bpms as $bpm)
                        <tr>
                            <td>{{ $bpm->nomor_bpm }}</td>
                            {{-- <td>
                                @php
                                $kode_materials = [];
                                for ($i = 1; $i <= 10; $i++) { if (!empty($bpm["kode_material_$i"])) { $kode_materials[]=$bpm["kode_material_$i"]; }
                                    } echo implode(', ', $kode_materials);
                                                    @endphp
                                                </td> --}}
                            <td>{{ $bpm->project }}</td>
                            <td>{{ $bpm->tgl_permintaan }}</td>
                             <td class="text-center">
                                @if($bpm->status == 'diserahkan')
                                <button class="btn btn-secondary btn-sm">Diserahkan</button>
                                @elseif($bpm->status == 'diterima')
                                <button class="btn btn-success btn-sm">Diterima</button>
                                @endif
                            </td>
                            <td class="text-center">
                                <a class="btn btn-info btn-sm mr-2" href="{{ route('bpm.show', $bpm->nomor_bpm) }}"><i
                                        class="fas fa-eye"></i> Lihat</a>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('bpm.destroy', $bpm->nomor_bpm) }}" method="POST" class="d-flex justify-content-center">
                                    @if($bpm->status == 'diserahkan')
                                    <a class="btn btn-success btn-sm mr-2"
                                    href="{{ route('bpm.diterima', $bpm->nomor_bpm) }}"><i class="fas fa-check"></i> Diterima</a>
                                @elseif($bpm->status == 'diterima')
                                @endif
                                    
                                    <a class="btn btn-primary btn-sm mr-2"
                                        href="{{ route('bpm.edit', $bpm->nomor_bpm) }}"><i class="fas fa-edit"></i> Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Hapus</button>
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
        if (confirm("Apakah Anda yakin ingin menghapus BPM dengan ID " + bpmId + "?")) {
            document.getElementById('deleteForm' + bpmId).submit();
        }
    }
</script>
@endsection