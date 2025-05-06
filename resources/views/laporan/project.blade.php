@extends('admin.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

<!-- JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('#myTable7');
</script>

<div class="container-fluid">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Laporan BPRM Berdasarkan Project
                    @if(isset($startDate) && isset($endDate) && $startDate && $endDate)
                    <span class="ml-2">({{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }})</span>
                    @endif
                </h6>
                <div class="d-flex align-items-center">
                    <input type="text" id="myInput" class="form-control ml-3" style="max-width: 250px;"
                        placeholder="Cari..." onkeyup="myFunction()" title="Ketikkan sesuatu untuk mencari">

                    @if(Auth::user()->hasRole('admin'))
                    <button onclick="ExportToExcel('xlsx')" class="btn btn-info ml-1" type="button">
                        <span class="h6">Ekspor</span>
                    </button>
                    @endif
                </div>
            </div>
        </div>

       <div class="card-header">
        <form method="GET" action="{{ route('laporan.filterProject') }}" class="mb-4">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="project">Project</label>
                    <select class="form-select" name="project" id="project">
                        <option class="form-select" {{ request('project') ? '' : 'selected' }} disabled value="">
                            --Pilih--</option>
                        @foreach ($projectArray as $dataProject)
                        <option class="form-control" value="{{ $dataProject->id }}" {{ request('project')==$dataProject->id
                            ? 'selected' : '' }}>
                            {{ $dataProject->nama_project }}
                        </option>
                        @endforeach
                    </select>
                </div>
    
                <!-- Tanggal Awal -->
                <div class="form-group col-md-3">
                    <label for="start_date">Tanggal Awal</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                        value="{{ request('start_date') ?? $startDateInput }}" required>
                </div>
    
                <!-- Tanggal Akhir -->
                <div class="form-group col-md-3">
                    <label for="end_date">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="end_date" name="end_date"
                        value="{{ request('end_date') ?? $endDateInput }}" required>
                </div>
    
                <!-- Tombol Submit -->
                <div class="form-group col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-success btn-block">
                        Search
                    </button>
                </div>
            </div>
        </form>
    </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable7" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Material</th>
                            <th>Nama Material</th>
                            <th>Spesifikasi</th>
                            <th>Project</th>
                            <th>Jumlah Total</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($laporanProject as $data)
                        <tr>
                            <td>{{ $data['kode_material'] }}</td>
                            <td>{{ $data['nama_material'] }}</td>
                            <td>{{ $data['spek'] }}</td>
                            <td>{{ $data['project'] }}</td>
                            <td>{{ $data['total'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
        let table = new DataTable('#myTable7', {
            paging: true,
            searching: true,
            ordering: true,
            lengthChange: true,
            info: true,
            autoWidth: false,
        });
    });
    </script>

    @endsection