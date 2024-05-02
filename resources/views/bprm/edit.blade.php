<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Edit Bon Penyerahan Material</title>
    <!-- Custom fonts for this template -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Edit Bon Penyerahan Material
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
                        <form method="post" action="{{ route('bprm.update', ['bprm' => $bprm->no_konversi]) }}" id="myForm">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nomor_bprm">Nomor BPRM</label>
                                <input type="text" name="nomor_bprm" class="form-control" id="nomor_bprm"
                                    value="{{ $bprm->nomor_bprm }}">
                            </div>

                            <div class="form-group">
                                <label for="nomor_bpm">Nomor BPM</label>
                                <select name="nomor_bpm" class="form-control" id="nomor_bpm">
                                    <option>Pilih Nomor BPM</option>
                                    @foreach ($bpms as $bpm)
                                    <option {{ $bpm->nomor_bpm == $bprm->nomor_bpm ? 'selected disabled' : '' }}>
                                        {{ $bpm->nomor_bpm }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="oka">Oka</label>
                                <input type="text" name="oka" class="form-control" id="oka" value="{{ $bprm->oka }}">
                            </div>

                            <div class="form-group">
                                <label for="no_bprm">Nomor BPRM</label>
                                <input type="text" name="no_bprm" class="form-control" id="no_bprm"
                                    value="{{ $bprm->no_bprm }}">
                            </div>

                            <div class="form-group">
                                <label for="jumlah_bprm">Jumlah</label>
                                <input type="text" name="jumlah_bprm" class="form-control" id="jumlah_bprm"
                                    value="{{ $bprm->jumlah_bprm }}">
                            </div>
                            <div class="form-group">
                                <label for="tgl_bprm">Tanggal BPRM</label>
                                <input type="date" name="tgl_bprm" class="form-control" id="tgl_bprm"
                                    value="{{ $bprm->tgl_bprm }}">
                            </div>
                            <div class="form-group">
                                <label for="head_number">Head Number</label>
                                <textarea name="head_number" id="head_number"
                                    class="form-control">{{ $bprm->head_number }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('bprm.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>