
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

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Bill Of Material</h6>
                            <a class="btn btn-sm btn-outline-success" href="{{ route('bom.create') }}">Input BOM</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="myTable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nomor BOM</th>
                                            <th>Project</th>
                                            <th>Tanggal Permintaan</th>
                                            <th>Daftar Material</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($boms as $bom)
                                        <tr>
                                            <td>{{ $bom->nomor_bom }}</td>
                                            <td>{{ $bom->project }}</td>
                                            <td>{{ $bom->tgl_permintaan }}</td>
                                            <td class="flex justify-content-center">
                                                <a class="btn btn-info btn-sm mr-2" href="{{ route('bom.show', $bom->nomor_bom) }}"><i
                                                        class="fas fa-eye"></i></a>
                                                <!-- Menambahkan ikon mata untuk tindakan Show -->
                                                <td>
                                                    <form id="deleteForm{{ $bom->nomor_bom }}" action="{{ route('bom.destroy', $bom->nomor_bom) }}" method="POST"
                                                        class="d-flex justify-content-center">
                                                        <a class="btn btn-primary btn-sm mr-2" href="{{ route('bom.edit', $bom->nomor_bom) }}"><i
                                                                class="fas fa-edit"></i></a> <!-- Menambahkan ikon pensil untuk tindakan Edit -->
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $bom->nomor_bom }}')"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                        <!-- Menambahkan ikon tong sampah untuk tindakan Delete -->
                                                    </form>
                                                </td>
                                            </td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    </table>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            @include('admin/dashboard/footer')
            <!-- Footer -->
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <!-- Include logout modal content -->

</body>

</html>
<script>
        function confirmDelete(nomorBOM) {
            if (confirm("Apakah Anda yakin ingin menghapus BOM dengan nomor " + nomorBOM + "?")) {
                document.getElementById("deleteForm" + nomorBOM).submit();
 }
           }
    </script>

<script>
    function myFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0]; // Ubah indeks kolom menjadi 0 untuk mencari berdasarkan nama
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