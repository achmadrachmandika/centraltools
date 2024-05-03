<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill of Materials</title>
    <!-- Bootstrap core CSS -->
    <link href="{{ url('css/sb-admin-2.css') }}" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <!-- Your custom CSS styles -->
    <style>
        /* Tambahkan kelas CSS untuk judul tabel agar tetap pada posisi atas saat digulir */
        .sticky-header {
            position: sticky;
            top: 0;
            background-color: #444;
            /* Warna latar belakang judul tabel */
            z-index: 1;
            /* Pastikan judul tabel tetap di atas konten tabel */
        }

        /* Atur lebar kolom agar sesuai dengan konten di dalamnya */
        #myTable th {
            width: auto !important;
        }
    </style>
    
</head>

<body id="page-top">

    <div id="wrapper">
        <!-- Sidebar -->
        @include('admin/dashboard/sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                @include('admin/dashboard/header')
                <div class="container-fluid">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">BILL OF MATERIALS - Nomor BOM {{ $bom->nomor_bom }}, {{ $bom->project }}</h6>
                            <br>
                            <h6 class="m-0 font-weight-bold text-primary">Tanggal Permintaan {{ $bom->tgl_permintaan }}</h6>
                        </div>
                        
                        
                        <div style="position: sticky; top: 0; background-color: #fff; z-index: 2;">
                            <div class="card-body">
                                <div class="d-flex">
                                <input type="text" id="myInput" class="form-control mb-3 mr-2" placeholder="Cari..." onkeyup="myFunction()"
                                    title="Ketikkan sesuatu untuk mencari">
                                <!-- Tombol ekspor -->
                                <button onclick="ExportToExcel('xlsx')" class="btn btn-info" type="button">
                                    <span class="h6">Ekspor</span>
                                </button>
                                </div>
                                <div class="table-responsive" style="max-height: 560px !important">
                                    <table id="myTable" class="table table-bordered" width="100%" cellspacing="0">
                                        <thead class="bg-secondary text-white text-center sticky-header">

                                            <tr>
                                                <!-- Header row -->
                                                <th>No</th>
                                                <th>Deskripsi Material</th>
                                                <th>Kode Material</th>
                                                <th>Spesifikasi Material</th>
                                                <th>QTY FAB</th>
                                                <th>QTY FIN</th>
                                                <th>Total</th>
                                                <th>Satuan</th>
                                                <th>Aksi</th>
                                                {{-- <th>Keterangan</th>
                                                <th>Revisi</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($materials as $material)
                                            <!-- Baris tabel -->
                                            <tr>
                                                <td class="text-center">{{ $material->no }}</td>
                                                <td>{{ $material->desc_material }}</td>
                                                <td class="text-center">{{ $material->kode_material }}</td>
                                                <td>{{ $material->spek_material }}</td>
                                                <td class="text-center">{{ $material->qty_fab }}</td>
                                                <td class="text-center">{{ $material->qty_fin }}</td>
                                                <td class="text-center">{{ $material->total_material }}</td>
                                                <td class="text-center">{{ $material->satuan_material }}</td>
                                                <td class="text-center">
                                                    <form id="deleteForm{{ $material->no_material_pada_bom }}"
                                                        action="{{ route('material.destroy', $material->no_material_pada_bom) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf   
                                                        @method('DELETE')
                                                        <a href="{{ route('material.edit', $material->no_material_pada_bom) }}"
                                                            class="btn btn-primary btn-sm mr-2">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="submit"
                                                            onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Material Ini?')"
                                                            class="btn btn-danger btn-sm"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                                {{-- <td>{{ $material->keterangan }}</td>
                                                <td>{{ $material->revisi }}</td> --}}
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('admin/dashboard/footer')
            </div>
            <!-- Footer -->

        </div>

        <!-- Bootstrap core JavaScript -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script>
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
        </script>

        <script>
            function ExportToExcel(type, dl) {
               var elt = document.getElementById('myTable');
               var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1", autoSize: true });
        
               // Mendapatkan tanggal saat ini
               var currentDate = new Date();
               var dateString = currentDate.toISOString().slice(0,10);
        
               // Gabungkan tanggal dengan nama file
               var fileName = 'Data Material Central Tools ' + dateString + '.' + (type || 'xlsx');
        
               return dl ?
                 XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
                 XLSX.writeFile(wb, fileName);
            }
        </script>

        <!-- Scroll to Top Button -->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal -->
        <!-- Include logout modal content -->

</body>

</html>