@extends('admin.app')

@section('content')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        let table = new DataTable('#myTable5', {
            paging: true,
            searching: true,
            ordering: true,
            lengthChange: true,
            info: true,
            autoWidth: false
        });
    });
</script>

<style>
    .loading-spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .loading-spinner.d-none {
        display: none;
    }
       mark.green-highlight {
        background-color: #d4edda;
        /* Hijau muda (background success) */
        color: #155724;
        /* Hijau gelap (teks success) */
        font-weight: bold;
        padding: 0 4px;
        border-radius: 4px;
    }
</style>

<div class="container-fluid">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
           <h6 class="m-0 font-weight-bold text-primary d-flex flex-column">
            @if(!request()->has('start_date') && !request()->has('end_date') && !request()->has('bagian'))
            <div>
                <h6 class="m-0 font-weight-bold text-primary">Laporan BPRM Berdasarkan Bagian</h6>
                <small class="text-muted">
                    Halaman ini menyajikan informasi terkait data pengeluaran material untuk kebutuhan proyek berdasarkan
                    <mark class="green-highlight">berkurang</mark>
                </small>
            </div>
            @endif
        
            @if(isset($startDate) && isset($endDate))
            <small class="text-muted mt-1">Periode: {{ $startDate->format('d/m/Y') }} hingga {{ $endDate->format('d/m/Y')
                }}</small>
            @endif
        </h6>
            @if(Auth::user()->hasRole('admin'))
            <button onclick="ExportToExcel('xlsx')" class="btn btn-info ml-1">Ekspor</button>
            @endif
        </div>

        <div class="card-header">
            <form method="GET" action="{{ route('laporan.filterBagian') }}" class="mb-4">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="bagian">Bagian</label>
                        {{-- <select class="form-select" name="bagian" id="bagian">
                            <option value="" disabled selected>--Pilih--</option>
                            @foreach($bagian as $option)
                            <option value="{{ $option }}" {{ request('bagian')==$option ? 'selected' : '' }}>{{
                                str_replace('-', ' - ', $option) }}</option>
                            @endforeach
                        </select> --}}
                        <select name="bagian" class="form-control">
                            <option value="">-- Semua Bagian --</option>
                            @foreach ($bagianList as $item)
                            <option value="{{ $item }}" {{ request('bagian')==$item ? 'selected' : '' }}>
                                {{ $item }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="start_date">Tanggal Awal:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ request('start_date') }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="end_date">Tanggal Akhir:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ request('end_date') }}" required>
                    </div>
                    <div class="form-group col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-success btn-block">Search</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable5" class="display">
                    <thead>
                        <tr>
                            <th>Kode Material</th>
                            <th>Nama Material</th>
                            <th>Spesifikasi</th>
                            <th>Jumlah Total</th>
                            <th>Proyek</th>
                            <th>Tanggal</th>
                            <th>Bagian</th>
                        </tr>
                    </thead>
           
                        <tbody>
                            @foreach($laporanBagian as $data)
                            <tr>
                                <td>{{ $data['kode_material'] }}</td>
                                <td>{{ $data['nama_material'] }}</td>
                                <td>{{ $data['spek'] }}</td>
                                <td>{{ $data['total'] }}</td>
                                <td>{{ $data['project'] }}</td>
                                <td>{{ $data['tanggal'] }}</td>
                                <td>{{ $data['bagian'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                  
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function ExportToExcel(type, dl) {
        var elt = document.getElementById('myTable5');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1", autoSize: true });
        var currentDate = new Date().toISOString().slice(0,10);
        var fileName = 'Laporan_BPRM_Bagian_' + currentDate + '.' + (type || 'xlsx');
        return dl ? XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) : XLSX.writeFile(wb, fileName);
    }
</script>

@endsection