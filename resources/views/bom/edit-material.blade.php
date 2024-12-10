@extends('admin.app')

@section('content')

                <div class="container-fluid">
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-md-12" style="min-width:80vw">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        EDIT SPAREPART
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
                                        <form method="post"
                                            action="{{ route('material.update', $materials->no_material_pada_bom) }}" id="myForm">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-2">
                                                    <label for="kode_material" >Kode Material</label>
                                                    <input type="text" name="kode_material" class="form-control" value="{{ $materials->kode_material}}">
                                                </div>
                                                <div class="col">
                                                    <label for="desc_material" >Deskripsi Material</label>
                                                    <input type="text" name="desc_material" class="form-control" value="{{ $materials->desc_material}}" readonly>
                                                </div>
                                                
                                            </div>
                                            <div class="row mb-4 mt-2">
                                                <div class="col">
                                                    <label for="spek_material" >Spesifikasi Material</label>
                                                    <input type="text" name="spek_material" class="form-control" value="{{ $materials->spek_material}}" readonly>
                                                </div>
                                                <div class="col-1">
                                                    <label for="qty_fab" >QTY Fabrikasi</label>
                                                    <input type="text" name="qty_fab" class="form-control" value="{{ $materials->qty_fab}}">
                                                </div>
                                                <div class="col-1">
                                                    <label for="qty_fin" >QTY Finishing</label>
                                                    <input type="text" name="qty_fin" class="form-control" value="{{ $materials->qty_fin}}">
                                                </div>
                                                <div class="col-1">
                                                    <label for="satuan" >Satuan</label>
                                                    <input type="text" name="satuan" class="form-control" value="{{ $materials->satuan_material}}" readonly>
                                                </div>
                                                <div class="col">
                                                    <label for="keterangan">Keterangan</label>
                                                    <input type="text" name="keterangan" class="form-control" value="{{ $materials->keterangan}}">
                                                </div>
                                                <div class="col">
                                                    <label for="revisi">Revisi</label>
                                                    <input type="text" name="revisi" class="form-control" value="{{ $materials->revisi}}">
                                                </div>
                                            </div>
                                           
                                                
                                            
                                          
                                            <div class="row">
                                                <div class="col">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                    <a href="{{ route('bom.show', $materials->nomor_bom) }}" class="btn btn-secondary">Kembali</a>
                                                </div>
                                            </div>
                                    
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{url('https://code.jquery.com/jquery-3.5.1.slim.min.js')}}"></script>
    <script src="{{url('https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js')}}"></script>
    <script src="{{url('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js')}}"></script>

    <!-- jQuery library -->
    <script src="{{url('https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js')}}"></script>
    <!-- Scroll to Top Button-->
@endsection