@extends('admin.app')
@section('content')
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

    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2 class="font-weight-bold">Data Dihapus</h2>
                    <input type="text" id="myInput" class="form-control" placeholder="Cari..." onkeyup="myFunction()"
                            title="Ketikkan sesuatu untuk mencari">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @elseif ($message = Session::get('error'))
                    <div class="alert alert-danger">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                </div>
                <div class="card-body">

                    <div class="table-responsive" style="max-height:700px; overflow-y:auto">
                        <table id="myTable" class="table table-striped">
                          <!-- Tambahkan id myTable -->
                          <thead class="bg-secondary text-white text-center sticky-header">
                            <tr>
                                <th>No</th>
                                <th>Jenis Model</th>
                                <th>ID / Kode</th>
                                <th>Nama</th>
                                <th>Spesifikasi / Keterangan</th>
                                <th>Foto</th>
                                <th>Lokasi / Bagian</th>
                                <!-- Tambahkan kolom lain yang relevan -->
                                <th>Dihapus Pada</th>
                                <th >Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->jenis_model }}</td>
                                    <td>{{ $item->kode_material ?? $item->no_spm ?? $item->nomor_bom ?? $item->ID_Project ?? '' }}</td>
                                    <td>{{ $item->nama_project ?? $item->nama ?? $item->desc_material ?? '' }}</td>
                                    <td>{{ $item->desc_material ?? $item->nama_barang ?? $item->spek ?? $item->nama_material ?? $item->keterangan ?? $item->keterangan_spm ??'' }}</td>
                                    <td>
                                        @if ($item->image_path)
                                            <img src="{{ asset($item->image_path) }}" alt="{{ $item->nama_material ?? $item->nama_unit ?? '' }}" style="max-width: 100px; height: 100px; cursor: pointer;" data-toggle="modal" data-target="#imageModal"
                                            data-image="{{ asset($item->image_path) }}" data-title="{{$item->nama_mesin ?? $item->nama_barang ?? $item->nama_material ?? $item->nama_unit ??'' }}">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{ $item->lokasi ?? $item->bagian ?? '' }}</td>
                                    <!-- Tambahkan kolom lain yang relevan -->
                                    <td>{{ $item->deleted_at }}</td>
                                    <td>
                                        <div class="btn btn-success">
                                            <a href="{{ route('restore-data', [$item->jenis_model, $item->id ?? $item->nomor_bom ?? $item->no_spm ?? $item->nomor_spr ?? $item->kode_material]) }}" class="text-white">
                                                Restore Data
                                            </a>
                                        </div>
                                        
                                        <form action="{{ route('force-delete', [$item->jenis_model, $item->id ?? $item->nomor_bom ?? $item->no_spm ?? $item->nomor_spr ?? $item->kode_material]) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this record?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus Permanen</button>
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
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script>
        $('#imageModal').on('show.bs.modal', function (event) {
              var button = $(event.relatedTarget); // Button that triggered the modal
              var imageUrl = button.data('image'); // Extract image URL from data-* attribute
              var imageTitle = button.data('title'); // Extract image title from data-* attribute
              var modal = $(this);
              modal.find('.modal-body #modalImage').attr('src', imageUrl);
              modal.find('.modal-title').text(imageTitle);
          });
      </script>

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
@endsection
