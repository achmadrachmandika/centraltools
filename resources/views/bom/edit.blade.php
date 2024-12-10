@extends('admin.app')

@section('content')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-md-12" style="min-width:80vw">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        EDIT BOM
                                    </div>
                                    <div class="card-body">
                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <strong>Whoops!</strong> Terdapat beberapa masalah dengan inputan
                                            Anda.<br><br>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                        <form method="post"
                                            action="{{ route('bom.update', $bom->nomor_bom) }}" id="myForm">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="nomor_bom">No. BOM</label>
                                                        <input type="text" name="nomor_bom" class="form-control"
                                                            id="nomor_bom" value="{{$bom->nomor_bom}}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label for="project">Project</label>
                                                            <select class="form-control" name="project" id="project">
                                                                @foreach ($daftar_projects as $project)
                                                                <option value="{{$project->nama_project}}" {{ $project->
                                                                    nama_project == $bom->project ? 'selected' : '' }}>
                                                                    {{$project->nama_project}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="tgl_permintaan">Tanggal Permintaan</label>
                                                        <input type="date" name="tgl_permintaan" class="form-control"
                                                            id="tgl_permintaan" value="{{$bom->tgl_permintaan}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-4">
                                                <div class="col">
                                                    <label for="keterangan">Keterangan</label>
                                                    <textarea name="keterangan" style="resize:none;height:100px" class="form-control">{{$bom->keterangan}}</textarea>
                                                </div>
                                            </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('bom.index') }}" class="btn btn-secondary">Kembali</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
    <!-- End of Page Wrapper -->
    <!-- Bootstrap core JavaScript-->
    <script src="{{url('https://code.jquery.com/jquery-3.5.1.slim.min.js')}}"></script>
    <script src="{{url('https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js')}}"></script>
    <script src="{{url('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js')}}"></script>

    <!-- jQuery library -->
    <script src="{{url('https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js')}}"></script>
    <!-- Scroll to Top Button-->
@endsection