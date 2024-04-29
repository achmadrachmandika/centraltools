@extends('admin.app')

@section('content')
<title>PPA|Material|CENTRAL TOOLS</title>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
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
<!-- Begin Page Content -->
<div class="container-fluid">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <!-- Card Container -->
    <div class="card" style="margin:0px 20px;padding:20px">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">List Material</h6>
                <div class="d-flex">
                    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Kode Materials.."
                        class="form-control" title="Type in a name">
                    <div class="loading-inner"></div>
               
                <a class="btn btn-sm btn-outline-success" href="{{ route('stok_material.create') }}">
                    Input Material</a>
                    </div>
            </div>
        </div>
        <div style="position: sticky; top: 0; background-color: #fff; z-index: 2;">
            <div class="card-body">
            <div class="table-responsive" style="max-height: 530px !important">
                <table id="myTable" class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="bg-secondary text-white text-center sticky-header">
                        <tr>
                            <th>Kode Material</th>
                            <th>Nama Material</th>
                            <th>Spesifikasi</th>
                            <th>Stok</th>
                            <th>Satuan</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stokMaterials as $stokMaterial)
                        <tr>
                            <td>{{ $stokMaterial->kode_material }}</td>
                            <td>{{ $stokMaterial->nama }}</td>
                            <td>{{ $stokMaterial->spek }}</td>
                            <td>{{ $stokMaterial->jumlah }}</td>
                            <td>{{ $stokMaterial->satuan }}</td>
                            <td>{{ $stokMaterial->lokasi }}</td>
                            <td>{{ $stokMaterial->status }}</td>
                            <td class="flex justify-content-center">
                                <form action="{{ route('stok_material.destroy', $stokMaterial->kode_material) }}" method="POST"
                                    class="d-flex justify-content-center">
                                    <a class="btn btn-primary btn-sm mr-2"
                                        href="{{ route('stok_material.edit', $stokMaterial->kode_material) }}"><i class="fas fa-edit"></i>Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                            class="fas fa-trash-alt"></i>Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
    <!-- End Card Container -->
</div>
<!-- /.container-fluid -->
@endsection

@section('scripts')
<!-- Bootstrap core JavaScript-->
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
            td = tr[i].getElementsByTagName("td")[1]; // Ubah indeks kolom menjadi 0 untuk mencari berdasarkan kode material
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

@endsection