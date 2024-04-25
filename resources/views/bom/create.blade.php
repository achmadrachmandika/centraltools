<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Central Tools-Fabrikasi</title>
    <!-- Custom fonts for this template -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ url('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin.dashboard.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('admin.dashboard.header')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-md-12" style="min-width:80vw">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        Tambah Bill Of Materials
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
                                        <form method="post" action="{{ route('bom.store') }}" id="myForm">
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="project">Project</label>
                                                        <select class="form-control" name="project" id="project">
                                                            @foreach ($daftar_projects as $project)
                                                            <option type="text" name="project" class="form-control" id="project" value="{{$project->nama_project}}">
                                                                {{$project->nama_project}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="tgl_permintaan">Tanggal Permintaan</label>
                                                        <input type="date" name="tgl_permintaan" class="form-control"
                                                            id="tgl_permintaan">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="kode_material_1">Import Excel</label>
                                                        <input class="form-control" type="file" name="excel-bom"
                                                            id="kode_material_1">   
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col">
                                                    <!-- Button Submit -->
                                                    <button type="submit" class="btn btn-primary form-control">Submit</button>
                                                </div>
                                                <div class="col">
                                                    <!-- Button Kembali -->
                                                    <a href="{{ route('bom.index') }}" class="btn btn-secondary form-control">Kembali</a>
                                                </div>
                
                                            </div>
                                            <!-- Tambah bagian untuk material ke-2, ke-3, dst. sesuai kebutuhan -->

                                            
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            @include('admin.dashboard.footer')
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let materialCount = 1;
            let materialCodeCount = 1;
            let materialCountCount = 1;
            let materialCountTypeCount = 1;
            let materialSpecsCount = 1;
            const maxmaterials = 10;
            const container = document.getElementById('materials-container');
            const code_container = document.getElementById('materials-code-container');
            const count_container = document.getElementById('materials-count-container');
            const count_type_container = document.getElementById('materials-count-type-container');
            const specs_container = document.getElementById('materials-specs-container');
    
            function addmaterial() {
                materialCount++;
                if (materialCount > maxmaterials) {
                    return;
                }
                const newDiv1 = document.createElement('div');
                newDiv1.innerHTML = `
                    <input class="form-control form-group" style="margin-top:5px" type="text" name="nama_material_${materialCount}" id="nama_material_${materialCount}">
                `;
                container.appendChild(newDiv1);
    
                console.log()
    
                if (materialCount === maxmaterials) {
                    document.querySelector('.add-material').style.display = 'none';
                }
            }
    
            function addmaterialCode() {
                materialCodeCount++;
                if (materialCodeCount > maxmaterials) {
                    return;
                }
    
                console.log(materialCodeCount)
    
                const newDiv2 = document.createElement('div');
                newDiv2.innerHTML = `
    
                    <input type="text" class="form-control form-group" placeholder="Cari.." style="margin-top:5px" type="text" name="kode_material_${materialCodeCount}" id="kode_material_${materialCodeCount}">
                    <div id="materialList_${materialCodeCount}"></div>
                `;
                code_container.appendChild(newDiv2);
    
            }
    
            function addmaterialCount() {
                materialCountCount++;
                if (materialCountCount > maxmaterials) {
                    return;
                }
                const newDiv3 = document.createElement('div');
                newDiv3.innerHTML = `
                    <input class="form-control form-group" style="margin-top:5px" type="text" name="jumlah_material_${materialCountCount}" id="jumlah_material_${materialCountCount}">
                `;
                count_container.appendChild(newDiv3);
            }
    
            function addmaterialCountType() {
                
                materialCountTypeCount++;
                if (materialCountTypeCount > maxmaterials) {
                    return;
                }
                const newDiv5 = document.createElement('div');
                newDiv5.innerHTML = `
                <input class="form-control form-group" style="margin-top:5px" type="text" name="satuan_material_${materialCountCount}" id="satuan_material_${materialCountCount}" readonly>
                `;
                count_type_container.appendChild(newDiv5);
            }
    
            function addmaterialSpecs() {
                materialSpecsCount++;
                if (materialSpecsCount > maxmaterials) {
                    return;
                }
    
                console.log(materialCodeCount)
                const newDiv4 = document.createElement('div');
                newDiv4.innerHTML = `
                    <input class="form-control form-group" style="margin-top:5px" type="text" name="spek_material_${materialSpecsCount}" id="spek_material_${materialSpecsCount}">
                `;
                specs_container.appendChild(newDiv4); // Mengganti count_container menjadi specs_container
                
            }
    
            document.querySelector('.add-material').addEventListener('click', addmaterial);
            document.querySelector('.add-material').addEventListener('click', addmaterialCode);
            document.querySelector('.add-material').addEventListener('click', addmaterialCount);
            document.querySelector('.add-material').addEventListener('click', addmaterialCountType);
            document.querySelector('.add-material').addEventListener('click', addmaterialSpecs);
        });
    </script>
    
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
    
    </html>




{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Central Tools-Fabrikasi</title>
    <!-- Custom fonts for this template -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ url('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin.dashboard.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('admin.dashboard.header')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-md-12" style="min-width:80vw">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        Tambah Bill Of Materials
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
                                        <form method="post" action="{{ route('bom.store') }}" id="myForm">
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="project">Project</label>
                                                        <select class="form-control" name="project" id="project">
                                                            @foreach ($daftar_projects as $project)
                                                            <option type="text" name="project" class="form-control" id="project" value="{{$project->nama_project}}">
                                                                {{$project->nama_project}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
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
                                                    <div class="form-group">
                                                        <label for="kode_material_1">Kode Material</label>
                                                        <input class="form-control" type="text" name="kode_material_1"
                                                            id="kode_material_1">
                                                        <div id="materialList_1"></div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label for="nama_material_1">Nama Material</label>
                                                        <input class="form-control" type="text" name="nama_material_1"
                                                            id="nama_material_1">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="spek_material_1">Spesifikasi Material</label>
                                                        <input class="form-control" type="text" name="spek_material_1" id="spek_material_1">
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <div class="form-group">
                                                        <label for="jumlah_material_1">Jumlah</label>
                                                        <input type="text" name="jumlah_material_1" class="form-control"
                                                            id="jumlah_material_1">
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label for="satuan_material_1">Satuan</label>
                                                        <input type="text" name="satuan_material_1" class="form-control"
                                                            id="satuan_material_1" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class=" col-2">
                                                    <div id="materials-code-container"></div>
                                                    <div class="btn btn-primary form-control add-material"><label>Tambah</label></div>
                                                </div>
                                                <div class=" col-3">
                                                    <div id="materials-container"></div>
                                                </div>
                                                <div class=" col-4">
                                                    <div id="materials-specs-container"></div>
                                                </div>
                                                <div class=" col-1">
                                                    <div id="materials-count-container"></div>
                                                </div>
                                                <div class=" col-2">
                                                    <div id="materials-count-type-container"></div>
                                                </div>
                                            <br>
                                            <!-- Tambah bagian untuk material ke-2, ke-3, dst. sesuai kebutuhan -->

                                            <!-- Button Submit -->
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <!-- Button Kembali -->
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
            @include('admin.dashboard.footer')
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let materialCount = 1;
            let materialCodeCount = 1;
            let materialCountCount = 1;
            let materialCountTypeCount = 1;
            let materialSpecsCount = 1;
            const maxmaterials = 10;
            const container = document.getElementById('materials-container');
            const code_container = document.getElementById('materials-code-container');
            const count_container = document.getElementById('materials-count-container');
            const count_type_container = document.getElementById('materials-count-type-container');
            const specs_container = document.getElementById('materials-specs-container');
    
            function addmaterial() {
                materialCount++;
                if (materialCount > maxmaterials) {
                    return;
                }
                const newDiv1 = document.createElement('div');
                newDiv1.innerHTML = `
                    <input class="form-control form-group" style="margin-top:5px" type="text" name="nama_material_${materialCount}" id="nama_material_${materialCount}">
                `;
                container.appendChild(newDiv1);
    
                console.log()
    
                if (materialCount === maxmaterials) {
                    document.querySelector('.add-material').style.display = 'none';
                }
            }
    
            function addmaterialCode() {
                materialCodeCount++;
                if (materialCodeCount > maxmaterials) {
                    return;
                }
    
                console.log(materialCodeCount)
    
                const newDiv2 = document.createElement('div');
                newDiv2.innerHTML = `
    
                    <input type="text" class="form-control form-group" placeholder="Cari.." style="margin-top:5px" type="text" name="kode_material_${materialCodeCount}" id="kode_material_${materialCodeCount}">
                    <div id="materialList_${materialCodeCount}"></div>
                `;
                code_container.appendChild(newDiv2);
    
            }
    
            function addmaterialCount() {
                materialCountCount++;
                if (materialCountCount > maxmaterials) {
                    return;
                }
                const newDiv3 = document.createElement('div');
                newDiv3.innerHTML = `
                    <input class="form-control form-group" style="margin-top:5px" type="text" name="jumlah_material_${materialCountCount}" id="jumlah_material_${materialCountCount}">
                `;
                count_container.appendChild(newDiv3);
            }
    
            function addmaterialCountType() {
                
                materialCountTypeCount++;
                if (materialCountTypeCount > maxmaterials) {
                    return;
                }
                const newDiv5 = document.createElement('div');
                newDiv5.innerHTML = `
                <input class="form-control form-group" style="margin-top:5px" type="text" name="satuan_material_${materialCountCount}" id="satuan_material_${materialCountCount}" readonly>
                `;
                count_type_container.appendChild(newDiv5);
            }
    
            function addmaterialSpecs() {
                materialSpecsCount++;
                if (materialSpecsCount > maxmaterials) {
                    return;
                }
    
                console.log(materialCodeCount)
                const newDiv4 = document.createElement('div');
                newDiv4.innerHTML = `
                    <input class="form-control form-group" style="margin-top:5px" type="text" name="spek_material_${materialSpecsCount}" id="spek_material_${materialSpecsCount}">
                `;
                specs_container.appendChild(newDiv4); // Mengganti count_container menjadi specs_container
                
            }
    
            document.querySelector('.add-material').addEventListener('click', addmaterial);
            document.querySelector('.add-material').addEventListener('click', addmaterialCode);
            document.querySelector('.add-material').addEventListener('click', addmaterialCount);
            document.querySelector('.add-material').addEventListener('click', addmaterialCountType);
            document.querySelector('.add-material').addEventListener('click', addmaterialSpecs);
        });
    </script>
    
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
    
    </html> --}}