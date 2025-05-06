@extends('admin.app')

@section('content')
<style>
    #noSPMList {
    position: absolute;
    z-index: 999;
    width: 100%;
    }
    </style>
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
                                        Tambah BPRM
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
                             
                                        <form method="post" action="{{ route('bprm.store') }}" id="myForm">
                                            @csrf
                                         <div class="row mb-3">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="bagian" class="form-label">Bagian</label>
                                                    <select class="select2" name="bagian" id="bagian">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach($bagians as $bagian)
                                                        <option value="{{ $bagian->nama_bagian }}" {{ old('bagian')==$bagian->nama_bagian ? 'selected' : '' }}>
                                                            {{ $bagian->nama_bagian }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="project" class="form-label">Project</label>
                                                    <select class="select2" name="project" id="project">
                                                        <option selected disabled value="">--Pilih--</option>
                                                        @foreach ($daftar_projects as $project)
                                                        <option value="{{$project->id}}" {{ old('project')==$project->nama_project ? 'selected' : '' }}>
                                                            {{$project->nama_project}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="nama_admin" class="form-label">Nama Admin</label>
                                                    <input type="text" name="nama_admin" class="form-control"
                                                        value="{{ old('nama_admin', auth()->user()->name ?? '') }}" id="nama_admin">
                                                </div>
                                            </div>
                                        
                                        </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="no_spm">Nomor SPM</label>
                                                            <input type="text" id="no_spm" name="no_spm" class="form-control" autocomplete="off">
                                                        </div>
                                                        <div id="noSPMList"></div>
                                                    </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="tgl_bprm">Tanggal Permintaan</label>
                                                        <input type="date" name="tgl_bprm" class="form-control" value="{{ old('tgl_bprm') }}"
                                                            id="tgl_bprm">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">
                                                        <label for="kode_material_1">Kode Material</label>
                                                </div>
                                                <div class="col-3">
                                                        <label for="nama_material_1">Nama Material</label>
                                                </div>
                                                <div class="col-4">
                                                        <label for="spek_material_1">Spesifikasi Material</label>
                                                </div>
                                                <div class="col-1">
                                                        <label for="jumlah_material_1">Jumlah</label>
                                                </div>
                                                <div class="col-1">
                                                    <label for="lokasi_material_1">Lokasi</label>
                                                </div>
                                                <div class="col-1">
                                                        <label for="satuan_material_1">Satuan</label>
                                                </div>
                                            </div>
                                       <div class="row">
                                        @for ($i = 1; $i <= 10; $i++) <div class="col-2">
                                            <div class="form-group">
                                                <input type="hidden" name="id_material_{{ $i }}" id="id_material_{{ $i }}">
                                                <input class="form-control kode-material" type="text" name="kode_material_{{ $i }}"
                                                    id="kode_material_{{ $i }}" data-index="{{ $i }}">
                                                <div id="materialList_{{ $i }}"></div>
                                            </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="nama_material_{{ $i }}" id="nama_material_{{ $i }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="spek_material_{{ $i }}" id="spek_material_{{ $i }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="form-group">
                                            <input type="text" name="jumlah_material_{{ $i }}" class="form-control" id="jumlah_material_{{ $i }}">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="form-group">
                                            <input type="text" name="lokasi_material_{{ $i }}" class="form-control" id="lokasi_material_{{ $i }}">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="form-group">
                                            <input type="text" name="satuan_material_{{ $i }}" class="form-control" id="satuan_material_{{ $i }}" readonly>
                                        </div>
                                    </div>
                                    @endfor
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary form-control">Submit</button>
                                        </div>
                                        <div class="col">
                                            <a href="{{ route('bprm.index') }}" class="btn btn-secondary form-control">Kembali</a>
                                        </div>
                                    </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
   
  
                @push('scripts')
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <!-- CSS Select2 -->
                    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
                    
                    <!-- JS Select2 -->
                    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



<script type="text/javascript">
    $(document).ready(function () {
    let selectedProject = $('#project').val();
    let selectedBagian = $('#bagian').val()?.split('-')[0] || "";
    
    // Update selectedProject saat project berubah
    $(document).on('change', '#project', function () {
    selectedProject = $(this).val();
    console.log('Selected project:', selectedProject);
    });
    
    // Update selectedBagian saat bagian berubah
    $(document).on('change', '#bagian', function () {
    selectedBagian = $(this).val()?.split('-')[0] || "";
    console.log('Selected bagian:', selectedBagian);
    });
    
    // Event Delegation untuk menangani semua input kode_material (lebih optimal)
    $(document).on('input', '[id^="kode_material_"]', function () {
    let index = $(this).attr('id').split('_').pop(); // Ambil index dari id
    let query = $(this).val();
    let _token = $('meta[name="csrf-token"]').attr('content');
    
    if (query !== '') {
    $.ajax({
    url: '/ajax-autocomplete-material-code-bprm',
    method: "GET",
    data: {
    query: query,
    project_id: selectedProject,
    lokasi: selectedBagian,
    _token: _token
    },
    success: function (data) {
    let dropdown = $(`#materialList_${index}`);
    dropdown.fadeIn().html(data.length ? data : "<li>Tidak ditemukan</li>");
    },
    error: function () {
    console.log('Error fetching data');
    }
    });
    } else {
    $(`#materialList_${index}`).fadeOut();
    }
    });
    
    // Saat user memilih material dari hasil pencarian
    $(document).on('click', '[id^="materialList_"] li', function () {
    let index = $(this).closest('div').attr('id').split('_').pop(); // Ambil index dari id div
    $(`#kode_material_${index}`).val($(this).text());
    $(`#nama_material_${index}`).val($(this).data('nama'));
    $(`#satuan_material_${index}`).val($(this).data('satuan'));
    $(`#jumlah_material_${index}`).val($(this).data('jumlah'));
    $(`#lokasi_material_${index}`).val($(this).data('lokasi'));
    $(`#spek_material_${index}`).val($(this).data('spek'));
    $(`#materialList_${index}`).fadeOut();
    });
    
    // Menutup dropdown jika klik di luar
    $(document).on('click', function (e) {
    if (!$(e.target).closest('[id^="kode_material_"], [id^="materialList_"]').length) {
    $('[id^="materialList_"]').fadeOut();
    }
    });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        // Event handler untuk input nomor_bpm
        $('#no_spm').keyup(function() {

            var query = $(this).val();
            if (query != '') {
                var _token = $('input[name="csrf-token"]').val();
                $.ajax({
                    url: '/ajax-autocomplete-no-spm',
                    method: "GET",
                    data: {
                        query: query,
                        project_id: $('#project_id').val(),
                        lokasi: $('#lokasi').val(),
                        _token: _token
                    },
                    success: function(data) {
                        $('#noSPMList').fadeIn();
                        $('#noSPMList').html(data);
                    }
                });
            }
        });
        // Event handler untuk menangani klik pada elemen li di #barangList
        $(document).on('click', '#noSPMList li', function() {
            for (let i = 1; i <= 10; i++) {
                var nama_material = $(this).data('nama_' + i);
                var satuan = $(this).data('satuan_' + i);
                var spek_material = $(this).data('spek_' + i);
                var kode_material = $(this).data('kode_' + i);
                var jumlah_material = $(this).data('jumlah_' + i);
                var lokasi_material = $(this).data('lokasi_' + i);

                console.log(nama_material);
                console.log(satuan);
                console.log(spek_material);
                console.log(kode_material);
                console.log(jumlah_material);
                $('#kode_material_' + i).val(kode_material);
                $('#nama_material_' + i).val(nama_material);
                $('#satuan_material_' + i).val(satuan);
                $('#spek_material_' + i).val(spek_material);
                $('#jumlah_material_' + i).val(jumlah_material);
                $('#lokasi_material_' + i).val(lokasi_material);
            }
            $('#no_spm').val($(this).text());
            $('#noSPMList').fadeOut();
        });
    });
</script>


@endpush
@endsection






