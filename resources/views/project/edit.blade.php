@extends('admin.app')

@section('content')
                <div class="container-fluid">
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        Tambah Project
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
                                        <form method="post" action="{{ route('project.update', ['project' => $project->id]) }}" id="myForm">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="project">Nama Project</label>
                                                        <input type="text" name="project" class="form-control"
                                                            id="project" value="{{$project->nama_project}}">
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="ID_Project">Nama </label>
                                                        <input type="text" name="ID_Project" class="form-control" id="ID_Project" value="{{$project->ID_Project}}">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <button type="submit" class="btn btn-primary form-control">Submit</button>
                                                </div>
                                                <div class="col">
                                                    <a href="{{ route('project.index') }}" class="btn btn-secondary form-control">Kembali</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
@endsection