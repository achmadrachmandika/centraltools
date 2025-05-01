@extends('admin.app')

@section('content')

<style>
  /* CSS untuk memberikan warna pada kolom Lokasi berdasarkan nilai */
.lokasi-cell {
padding: 10px;
font-weight: bold;
border-radius: 5px;
color: white;
}

/* Warna khusus untuk setiap lokasi */
.lokasi-fabrikasi {
background-color: #4CAF50; /* Hijau untuk Fabrikasi */
}

.lokasi-finishing {
background-color: #2196F3; /* Biru untuk Finishing */
}

/* Untuk lokasi lainnya, jika ada */
.lokasi-default {
background-color: black; /* Abu-abu untuk lokasi lainnya */
}
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

<!-- JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('#myTable4');
</script>

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
                <h6 class="m-0 font-weight-bold text-primary">Daftar lokasi Bagian </h6>
                <small class="text-muted">Halaman ini menampilkan daftar lokasi bagian dalam struktur penggunaan dan subdivisinya.</small>
            </div>
            <div class="d-flex">
                {{-- <input type="text" id="myInput" class="form-control" placeholder="Cari..." onkeyup="myFunction()"
                    title="Ketikkan sesuatu untuk mencari"> --}}
                <a class="btn form-control btn-outline-success ml-2" href="{{ route('bagian.create') }}">Input Bagian</a>
            </div>
        </div>
        <div class="card-body">
          <div class="table-responsive" style="max-height: 530px !important">
                <table id="myTable4" class="display">
                    <thead>
                        <tr class="text-center">
                            <th>Nomor</th>
                            <th>Nama Bagian</th>
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                   <tbody>
                    @foreach ($bagians as $index => $bagian)
                    <tr>
                        <td>{{ $index + 1 }}</td> <!-- Nomor urut yang dimulai dari 1 -->
                        <td>{{ $bagian->nama_bagian }}</td>
                        <td class="lokasi-cell 
                            @if(str_contains(strtolower($bagian->lokasi), 'fabrikasi')) 
                                lokasi-fabrikasi 
                            @elseif(str_contains(strtolower($bagian->lokasi), 'finishing')) 
                                lokasi-finishing 
                            @else 
                                lokasi-default 
                            @endif">
                            {{ $bagian->lokasi }}
                        </td>
                        <td class="text-center">
                            <!-- Form untuk menghapus data -->
                            <form id="deleteForm{{ $bagian->id }}" action="{{ route('bagian.destroy', $bagian->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm deleteButton"
                                    data-form-id="deleteForm{{ $bagian->id }}">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
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
<!-- /.container-fluid -->


<script>
    $(document).ready(function() {
        // Inisialisasi DataTable untuk tabel dengan id 'myTable'
        let table = new DataTable('#myTable4', {
        paging: true, // Aktifkan pagination
        searching: true, // Aktifkan pencarian
        ordering: true, // Aktifkan pengurutan kolom
        lengthChange: true, // Memungkinkan user memilih jumlah baris per halaman
        info: true, // Menampilkan informasi jumlah baris yang ditampilkan
        autoWidth: false, // Nonaktifkan lebar otomatis kolom
        });
       

        $(document).on('click', '.deleteButton', function () {
        const formId = $(this).data('form-id');
        const form = $("#" + formId); // Ambil form berdasarkan ID yang disimpan di data-form-id
        
        Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
        }).then((result) => {
        if (result.isConfirmed) {
        form.submit(); // Submit form jika konfirmasi berhasil
        }
        });
        });
        });
</script>
<script>
    function confirmDelete(bpmId) {
        if (confirm("Apakah Anda yakin ingin menghapus BPM dengan ID " + bpmId + "?")) {
            document.getElementById('deleteForm' + bpmId).submit();
        }
    }

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
@endsection

