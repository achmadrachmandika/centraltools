
    <!-- Custom styles for this template -->
    <link href="{{url('css/sb-admin-2.min.css')}}" rel="stylesheet">

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin/dashboard/sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('admin/dashboard/header')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-md-12" style="min-width:80vw">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        Tambah BPM
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
                                        <form method="post" action="{{ route('bpm.store') }}" id="myForm">
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="project">Project</label>
                                                        <select class="form-select" name="project" id="project">
                                                            @foreach ($daftar_projects as $project)
                                                                <option type="text" name="project" class="form-control" id="project" value="{{$project->nama_project}}">{{$project->nama_project}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="no_spm">Nomor SPM</label>
                                                            <input type="text" name="no_spm" id="no_spm" class="form-control" value="{{ old('no_spm') }}"
                                                                placeholder="Cari..." required />
                                                        </div>
                                                        <div id="noSPMList"></div>
                                                    </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="tgl_permintaan">Tanggal Permintaan</label>
                                                        <input type="date" name="tgl_permintaan" class="form-control"
                                                            id="tgl_permintaan">
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
                                                <div class="col-2">
                                                        <label for="satuan_material_1">Satuan</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @for ($i = 1; $i <= 10; $i++)
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="kode_material_{{ $i }}" id="kode_material_{{ $i }}">
                                                        <div id="materialList_{{ $i }}"></div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="nama_material_{{ $i }}" id="nama_material_{{ $i }}">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="spek_material_{{ $i }}" id="spek_material_{{ $i }}">
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <div class="form-group">
                                                        <input type="text" name="jumlah_material_{{ $i }}" class="form-control" id="jumlah_material_{{ $i }}">
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <input type="text" name="satuan_material_{{ $i }}" class="form-control" id="satuan_material_{{ $i }}"readonly>
                                                    </div>
                                                </div>
                                                @endfor
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <a href="{{ route('bpm.index') }}" class="btn btn-secondary">Kembali</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            @include('admin/dashboard/footer')
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Bootstrap core JavaScript-->
    <script src="{{url('https://code.jquery.com/jquery-3.5.1.slim.min.js')}}"></script>
    <script src="{{url('https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js')}}"></script>
    <script src="{{url('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js')}}"></script>

    <!-- jQuery library -->
    <script src="{{url('https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js')}}"></script>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <!-- Include logout modal content -->
</body>


<script type="text/javascript">
    $(document).ready(function() {


    for (let i = 1; i <= 10; i++) {
    $(document).on('keyup', `#kode_material_${i}`, function() {
        var query = $(this).val();
        if (query != '') {
            var _token = $('input[name="csrf-token"]').val();
            $.ajax({
                url: '/ajax-autocomplete-material-code',
                method: "GET",
                data: {
                    query: query,
                    _token: _token
                },
                success: function(data) {
                    $(`#materialList_${i}`).fadeIn();
                    $(`#materialList_${i}`).html(data);
                }
            });
        }
    });

    $(document).on('click', `#materialList_${i} li`, function() {
        var nama_material = $(this).data('nama');
        var satuan = $(this).data('satuan');
        var spek_material = $(this).data('spek');
        $(`#kode_material_${i}`).val($(this).text());
        $(`#nama_material_${i}`).val(nama_material);
        $(`#satuan_material_${i}`).val(satuan);
        $(`#spek_material_${i}`).val(spek_material);
        $(`#materialList_${i}`).fadeOut();
    });
}

    

    
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
                // var jumlah_material = $(this).data('jumlah_' + i);

                console.log(nama_material);
                console.log(satuan);
                console.log(spek_material);
                console.log(kode_material);
                // console.log(jumlah_material);
                $('#kode_material_' + i).val(kode_material);
                $('#nama_material_' + i).val(nama_material);
                $('#satuan_material_' + i).val(satuan);
                $('#spek_material_' + i).val(spek_material);
                // $('#jumlah_material_' + i).val(jumlah_material);
            }
            $('#no_spm').val($(this).text());
            $('#noSPMList').fadeOut();
        });
    });
</script>

</html>