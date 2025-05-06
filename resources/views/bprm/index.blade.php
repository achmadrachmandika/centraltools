@extends('admin.app')

@section('content')
<style>
/* CSS untuk Fabrikasi */
.fabrikasi {
background-color: #d4edda; /* Warna hijau muda */
color: #155724; /* Warna teks hijau gelap */
padding: 5px 10px;
border-radius: 20px;
}

/* CSS untuk Finishing */
.finishing {
background-color: #cce5ff; /* Warna biru muda */
    color: #004085; /* Warna teks biru gelap */
    padding: 5px 10px;
    border-radius: 20px;
}

/* CSS untuk default jika bukan fabrikasi atau finishing */
.default {
color: #4b5563; /* Warna abu-abu gelap */
font-weight: normal;
}
    mark.red-highlight {
        background-color: #f8d7da;
        color: #721c24;
        font-weight: bold;
        padding: 0 4px;
        border-radius: 4px;
    }

 /* Tambahkan kelas CSS untuk judul tabel agar tetap pada posisi atas saat digulir */
.sticky-header {
position: sticky;
top: 0;
background-color: white;
/* Warna latar belakang judul tabel */
z-index: 1;
/* Pastikan judul tabel tetap di atas konten tabel */
}

/* Membuat pagination dan info sticky di bawah tabel */
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate {
position: sticky;
bottom: 0;
z-index: 10;
background-color: #fff;
padding: 10px;
box-shadow: 0 -3px 6px rgba(0, 0, 0, 0.1);
}

/* Posisi kiri dan kanan */
.dataTables_wrapper .dataTables_info {
float: left;
}
.dataTables_wrapper .dataTables_paginate {
float: right;
}

/* Tambahan agar tidak tertimpa konten saat scroll */
.table-responsive {
padding-bottom: 60px;
}

/* Atur lebar kolom agar sesuai dengan konten di dalamnya */
#myTable th {
width: auto !important;
}


</style>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="m-0 font-weight-bold text-primary">Bon Penyerahan Material</h6>
                                <small class="text-muted">Halaman ini menyajikan informasi terkait stok material yang telah digunakan dalam pelaksanaan proyek.<br>
                                Setiap kali dilakukan pengambilan material untuk kebutuhan proyek, jumlah stok akan otomatis <mark class="red-highlight">berkurang</mark> dalam sistem.</small>
                            </div>
                            <div class="d-flex">
                                <input type="text" id="myInput" class="form-control" placeholder="Cari..." onkeyup="myFunction()"
                                    title="Ketikkan sesuatu untuk mencari">
                                <a class="btn form-control ml-2 btn-outline-success" href="{{ route('bprm.create') }}">Input BPRM</a>
                            </div>
                            
                        </div>

                    <div class="card-body">
                         <div class="table-responsive" style="max-height:400px; overflow-y:auto; padding-bottom:60px;">
                            <table id="table-bprm" class="display">
                                <thead class="text-center sticky-header">
                                    <tr>
                                        <th class="text-center">Nomor BPRM</th>
                                        <th class="text-center">Nomor SPM</th>
                                        <th class="text-center">Project</th>
                                        <th class="text-center">Material</th>
                                        <th class="text-center">Bagian</th>
                                        <th class="text-center">Tanggal Pengajuan</th>
                                        <th class="text-center">Admin</th>
                                        <th class="text-center">Jumlah Material</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data tabel akan muncul di sini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                        
                    </div>
                </div>
                <!-- /.container-fluid -->

    <!-- Bootstrap core JavaScript-->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
    $('#table-bprm').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('bprm.data') }}",
    columns: [
    { data: 'nomor_bprm', name: 'nomor_bprm', className: 'text-center' },
    { data: 'no_spm', name: 'no_spm', className: 'text-center' },
    { data: 'project', name: 'project', className: 'text-center' },
    { data: 'materials', name: 'materials' }, // render via server
    { data: 'bagian', name: 'bagian', className: 'text-center' },
    { data: 'tgl_bprm', name: 'tgl_bprm', className: 'text-center' },
    { data: 'nama_admin', name: 'nama_admin', className: 'text-center' },
    { data: 'jumlah_materials', name: 'jumlah_materials', className: 'text-center' },
    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
    ],
    });
    });
    </script>

    <script>
        setTimeout(function() {
            let alertBox = document.getElementById('success-alert');
            if (alertBox) {
                alertBox.style.transition = "opacity 0.5s ease";
                alertBox.style.opacity = 0;
                setTimeout(() => alertBox.remove(), 500);
            }
        }, 5000);
    </script>


    {{-- <script>
        function myFunction() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("myInput");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("myTable");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        if (tr[i].getElementsByTagName("th").length > 0) {
                            continue; // Lewati baris yang berisi header
                        }
                        var found = false;
                        td = tr[i].getElementsByTagName("td");
                        for (var j = 0; j < td.length; j++) {
                            txtValue = td[j].textContent || td[j].innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                found = true;
                                break; // Hentikan loop jika ditemukan kecocokan
                            }
                        }
                        tr[i].style.display = found ? "" : "none";
                    }
                }
    </script> --}}

@endsection