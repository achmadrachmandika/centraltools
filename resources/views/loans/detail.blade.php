@extends('admin.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pengembalian Material Peminjaman</h6>
        <small class="text-muted">Pilih material yang akan dikembalikan</small>
    </div>

    <div class="card-body">
        <div class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Proyek Peminjam:</strong> {{ $loan->peminjam->nama_project }}</p>
                    <p><strong>Proyek Pemilik:</strong> {{ $loan->pemilik->nama_project }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tanggal Peminjaman:</strong> {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d-m-Y') }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($loan->status) }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('loans.process-return', $loan->id) }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="check-all">
                                    <label class="custom-control-label" for="check-all"></label>
                                </div>
                            </th>
                            <th class="text-center">Material</th>
                            <th class="text-center">Kode</th>
                            <th class="text-center">Jumlah Dipinjam</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loan->details as $detail)
                        <tr class="{{ $detail->status === 'dikembalikan' ? 'bg-success text-white' : '' }}">
                            <td class="text-center">
                                @if($detail->status !== 'dikembalikan')
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input checkbox-item" name="detail_ids[]" value="{{ $detail->id }}" id="detail-{{ $detail->id }}">
                                    <label class="custom-control-label" for="detail-{{ $detail->id }}"></label>
                                </div>
                                @endif
                            </td>
                            <td>{{ $detail->projectMaterial->material->nama }}</td>
                            <td>{{ $detail->projectMaterial->material->kode_material }}</td>
                            <td class="text-center">{{ $detail->jumlah }}</td>
                            <td class="text-center">
                                @if($detail->status === 'dikembalikan')
                                <span class="badge badge-success">Dikembalikan</span>
                                @else
                                <span class="badge badge-warning">Dipinjam</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary" id="btn-return" disabled>Kembalikan Item Terpilih</button>
                <a href="{{ route('loans.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Check all checkboxes
        $('#check-all').on('change', function() {
            $('.checkbox-item').prop('checked', $(this).prop('checked'));
            updateReturnButton();
        });

        // Individual checkbox change
        $('.checkbox-item').on('change', function() {
            updateReturnButton();
            
            // Update "check all" checkbox
            if ($('.checkbox-item:checked').length === $('.checkbox-item').length) {
                $('#check-all').prop('checked', true);
            } else {
                $('#check-all').prop('checked', false);
            }
        });

        // Update return button state
        function updateReturnButton() {
            if ($('.checkbox-item:checked').length > 0) {
                $('#btn-return').prop('disabled', false);
            } else {
                $('#btn-return').prop('disabled', true);
            }
        }
    });
</script>
@endsection