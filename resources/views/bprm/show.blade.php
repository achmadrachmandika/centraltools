<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css" />
    <link href="{{url('css/sb-admin-2.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>BAST Barang Nomor BPM {{ $bprm->nomor_bprm }}</title>
    <style>
        body {
            font-size: 18px;
        }

        .page-header,
        .page-footer {
            text-align: center;
            background: #fff;
            padding: 15px 0;
        }

        .page-title {
            font-size: 26px;
            font-weight: bold;
        }

        .bordered {
            border: 2px solid black;
            padding: 10px;
            font-size: 20px;
            text-align: center;
        }

        .btn-print {
            font-size: 22px;
            padding: 10px 20px;
        }

        .signature-box {
            height: 80px;
            border-top: 2px solid black;
            margin-top: 20px;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
            border: 2px solid black;
            padding: 10px;
            font-size: 18px;
        }

        @media print {
            .btn {
                display: none;
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="page-header">
        <img src="{{ asset('img/logo-inka.png') }}" alt="logo inka" width="150px">
        <p class="page-title">BERITA ACARA SERAH TERIMA BARANG</p>
        <button onClick="window.print()" class="btn btn-success btn-print">Cetak</button>
        <a href="{{ route('bprm.index') }}" class="btn btn-primary btn-print">Kembali</a>
    </div>

    <div class="container">
        <table class="table">
            <tr>
                <th>Nomor BPRM</th>
                <th>Nama Admin</th>
            </tr>
            <tr>
                <td>{{ $bprm->nomor_bprm }}</td>
                <td>{{ $bprm->nama_admin }}</td>
            </tr>
        </table>

        <table class="table">
            <tr>
                <th>Project</th>
                <th>Bagian</th>
                <th>Tanggal BPRM</th>
            </tr>
            <tr>
                <td>{{ $bprm->project }}</td>
                <td>{{ $bprm->bagian }}</td>
                <td>{{ $bprm->tgl_bprm }}</td>
            </tr>
        </table>

        <table class="table">
            <tr>
                <th>Kode Sparepart</th>
                <th>Nama Sparepart</th>
                <th>Spesifikasi Sparepart</th>
                <th>Jumlah</th>
            </tr>
            @foreach ($bprm->bprmMaterials as $bprmMaterial)
            <tr>
                <td class="{{ $bprmMaterial->material ? '' : 'bg-danger text-white' }}">
                    {{ $bprmMaterial->material->kode_material ?? 'Tidak Ditemukan' }}
                </td>
                <td class="{{ $bprmMaterial->material ? '' : 'bg-danger text-white' }}">
                    {{ $bprmMaterial->material->nama ?? 'Tidak Ditemukan' }}
                </td>
                <td class="{{ $bprmMaterial->material ? '' : 'bg-danger text-white' }}">
                    {{ $bprmMaterial->material->spek ?? 'Tidak Ditemukan' }}
                </td>
                <td>{{ $bprmMaterial->jumlah_material }} {{ $bprmMaterial->satuan_material }}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="page-footer">
        <div class="row">
            <div class="col-6 bordered text-center">
                <h6>Yang Menyerahkan <br> Pihak Pertama</h6>
                <h6>{{ $bprm->nama_admin }}</h6>
                <div class="signature-box"></div>
            </div>
            <div class="col-6 bordered text-center">
                <h6>Yang Menerima <br> Pihak Kedua</h6>
                <h6></h6>
                <div class="signature-box"></div>
            </div>
        </div>
    </div>
</body>

</html>