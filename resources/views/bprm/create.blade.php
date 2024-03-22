

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
                            <div class="col-md-7">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        Tambah Bon Penyerahan Material
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

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="no_konversi">Nomor Konversi</label>
                                                        <input type="text" name="no_konversi" class="form-control" id="no_konversi">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="nomor_bpm">Nomor BPM</label>
                                                        <input type="text" name="nomor_bpm" id="nomor_bpm" class="form-control" value="{{ old('nomor_bpm') }}" placeholder="Cari..." required />
                                                    </div>
                                                    <div id="noBPMList"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="no_bprm">Nomor BPRM</label>
                                                        <input type="text" name="no_bprm" class="form-control" id="no_bprm">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="project">Project</label>
                                                        <select name="project" class="form-control" id="project">
                                                            <option value="" selected disabled>--Pilih--</option>
                                                            <option value="612">612</option>
                                                            <option value="KCI">KCI</option>
                                                            <option value="Retrofit">Retrofit</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="jumlah">Jumlah</label>
                                                        <input type="text" name="jumlah" class="form-control" id="jumlah">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="satuan">Satuan</label>
                                                        <select name="satuan" class="form-control" id="satuan">
                                                            <option value="" selected disabled>--Pilih--</option>
                                                            <option value="Pcs">Pcs</option>
                                                            <option value="Unit">Unit</option>
                                                            <option value="Set">Set</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="tgl_bprm">Tanggal BPRM</label>
                                                <input type="date" name="tgl_bprm" class="form-control" id="tgl_bprm">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="head_number">Head Number</label>
                                                        <textarea style="resize: none" name="head_number" id="head_number" class="form-control"></textarea>
                                                    </div>
                                                </div>
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

                    @include('admin/dashboard/footer')
                </div>
        <!-- End of Content Wrapper -->
            </div>
        </div>
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
    // Event handler untuk input nomor_bpm
    $('#nomor_bpm').keyup(function() {
        
        var query = $(this).val();
        if (query != '') {
            var _token = $('input[name="csrf-token"]').val();
            $.ajax({
                url: '/ajax-autocomplete-no-bpm',
                method: "GET",
                data: {
                    query: query,
                    _token: _token
                },
                success: function(data) {
                    $('#noBPMList').fadeIn();
                    $('#noBPMList').html(data);
                }
            });
        }
    });
    // Event handler untuk menangani klik pada elemen li di #barangList
    $(document).on('click', '#noBPMList li', function() {
        $('#nomor_bpm').val($(this).text());
        $('#noBPMList').fadeOut();
    });
    });
</script>

</html>