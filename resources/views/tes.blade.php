<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="style.css" />
  <link href="{{url('css/sb-admin-2.css')}}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <style>
    /* Styles go here */

.page-header, .page-header-space {
  height: 200px;
}

.page-footer, .page-footer-space {
  height: 200px;

}

.page-footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  z-index: 1;
  /* border-top: 1px solid black; for demo */
  background: rgb(255, 255, 255);
}

.page-header {
  position: fixed;
  top: 0mm;
  width: 100%;
  z-index: 1;
  /* border-bottom: 1px solid black; for demo */
  background: rgb(255, 255, 255);
}

.page {
  page-break-after: always;
}

@page {
  margin: 20mm
}

@media print {
   thead {display: table-header-group;} 
   tfoot {display: table-footer-group;}
   
   button {display: none;}
   
   body {margin: 0;}
}
  </style>
</head>

<body>
  <div class="page-header" style="text-align: center">
    <div class="container">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-2">
                    <img style="width:100%" src="{{ asset('img/logo-inka.png') }}" alt="logo inka">
            </div>
            <div class="col-7"></div>
            <div class="col"><button type="button" onClick="window.print()" style="background: pink">
                PRINT ME!
              </button>
            </div>
            <div class="col">
                <a href="{{ route('bprm.index') }}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class=" text-center page-title" style="font-size: 24px;">BERITA ACARA SERAH TERIMA BARANG</p>
            </div>
        </div>
        <div class="row">
            <div class="col-2 text-center bordered">
                <strong>Nomor BPRM</strong>
            </div>
            <div class="col"></div>
            <div class="col-2 text-center bordered">
                <strong>Nama Admin</strong>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-2 text-center bordered-no-top">
                {{-- {{ $bprm->nomor_bprm }} --}}
            </div>
            <div class="col"></div>
            <div class="col-2 text-center bordered-no-top">
                {{-- {{ $bprm->nama_admin }} --}}
            </div>
        </div>
    </div>
  </div>

  <div class="page-footer">
    <div class="container">
        <div class="row mt-3">
            <div class="col-7"></div>
            <div class="col bordered text-center"
                style="height: 180px;display:flex;justify-content: space-between;flex-direction: column">
                <h6>Yang Menyerahkan <br> Pihak Pertama</h6>
                {{-- <h6>{{ $bprm->nama_admin }}</h6> --}}sdasdasdasda
            </div>
            <div class="col bordered text-center" style="height: 180px;display:flex;justify-content: space-between;flex-direction: column">
                <h6>Yang Menerima <br> Pihak Kedua</h6>
                <h6></h6>
            </div>
        </div>
    </div>
  </div>

  <div class="container">
    <table>

        <thead>
          <tr>
            <td>
              <!--place holder for the fixed-position header-->
              <div class="page-header-space"></div>
            </td>
          </tr>
        </thead>
    
        <tbody>
          <tr>
            <td>
              <!--*** CONTENT GOES HERE ***-->
              <div class="page">
                <div id="content">   
                    <div class="row">
                        <div class="col">
                            <p>Kami yang bertanda tangan dibawah ini</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <p>Nama</p>
                        </div>
                        <div class="col">
                            {{-- : {{ $bprm->nama_admin }} --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <p>Jabatan</p>
                        </div>
                        <div class="col">
                            :
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <p>Bagian</p>
                        </div>
                        <div class="col">
                            :
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p>Selanjutnya disebut <b>PIHAK PERTAMA</b>.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <p>Nama</p>
                        </div>
                        <div class="col">
                            :
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <p>Jabatan</p>
                        </div>
                        <div class="col">
                            :
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <p>Bagian</p>
                        </div>
                        <div class="col">
                            {{-- : {{ $bprm->bagian }} --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p>Selanjutnya disebut <b>PIHAK KEDUA</b>.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p><b>PIHAK PERTAMA</b> menyerahkan barang berupa peralatan/tools untuk kebutuhan pengerjaan proyek sasa kepada <b>PIHAK KEDUA</b> dan <b>PIHAK KEDUA</b> menyatakan telah menerima barang dari <b>PIHAK PERTAMA</b> berupa :</p>
                            {{-- <p><b>PIHAK PERTAMA</b> menyerahkan barang berupa peralatan/tools untuk kebutuhan pengerjaan proyek {{ $bprm->project }} kepada <b>PIHAK KEDUA</b> dan <b>PIHAK KEDUA</b> menyatakan telah menerima barang dari <b>PIHAK PERTAMA</b> berupa :</p> --}}
                        </div>
                    </div>
    
                    <br>
                    <div class="row">
                        <div class="col text-center bordered">
                            <strong>Project</strong>
                        </div>
                        <div class="col text-center bordered-no-left">
                            <strong>Bagian</strong>
                        </div>
                        <div class="col text-center bordered-no-left">
                            <strong>Tanggal BPRM</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center bordered-no-top-right">
                            {{-- {{ $bprm->project }} --}}asdasd
                        </div>
                        <div class="col text-center bordered-no-top-right">
                            {{-- {{ $bprm->bagian }} --}}asdasdad
                        </div>
                        <div class="col text-center bordered-no-top">
                            {{-- {{ $bprm->tgl_bprm }} --}}asdasda
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-2 text-center bordered-no-right">
                            <strong> Kode Sparepart </strong>
                        </div>
                        <div class="col text-center bordered-no-right">
                            <strong> Nama Sparepart </strong>
                        </div>
                        <div class="col text-center bordered-no-right">
                            <strong> Spesifikasi Sparepart </strong>
                        </div>
                        <div class="col-2 text-center bordered">
                            <strong>Jumlah</strong>
                        </div>
                    </div>
                    @for ($i = 1; $i <= 10; $i++) 
                    {{-- @if (!empty($bprm["kode_material_$i"]))  --}}
                    <div class="row">
                        <div class="bordered-no-top-right col-2">
                            {{-- <p>{{ $bprm["kode_material_$i"] }}</p> --}} sqweqweqweqweqeweqqe
                        </div>
                        <div class="bordered-no-top-right col-4">
                            {{-- <p>{{ $bprm["nama_material_$i"] }}</p> --}} sqweqweqweqweqeweqqe
                        </div>
                        <div class="bordered-no-top-right col-4">
                            {{-- <p>{{ $bprm["spek_material_$i"] }}</p> --}} sqweqweqweqweqeweqqe
                        </div>
                        <div class="bordered-no-top col-2">
                            {{-- <p>{{ $bprm["jumlah_material_$i"] }} {{ $bprm["satuan_material_$i"] }}</p> --}} sqweqweqweqweqeweqqe
                        </div>
                    </div>
                    {{-- @endif --}}
                    @endfor
                        
                </div>
    
            </td>
          </tr>
        </tbody>
    
        <tfoot>
          <tr>
            <td>
              <!--place holder for the fixed-position footer-->
              <div class="page-footer-space"></div>
            </td>
          </tr>
        </tfoot>
    
      </table>
  </div>

</body>

</html>