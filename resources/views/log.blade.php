@extends('admin.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2 class="font-weight-bold">Log Aktivitas</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height:700px; overflow-y:auto">
                        <table id="myTable" class="table table-striped">
                          <!-- Tambahkan id myTable -->
                          <thead class="bg-secondary text-white text-center sticky-header">
                            <tr>
                                <th>No</th>
                                    <th>Nama Log</th>
                                    <th>ID Subject</th>
                                    <th>Deskripsi</th>
                                    <th>User</th>
                                    <th style="max-width:200px">Properties</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td>{{$log->id}}</td>
                                    <td>{{$log->log_name}} ({{$log->event}})</td>
                                    <td>{{$log->subject_id}}</td>
                                    <td>{{$log->description}}</td>
                                    <td>
                                        {{$log->causer_name}} ({{$log->causer_id}})
                                    </td>
                                    <td style="max-width:200px">{{$log->properties}}</td>
                                    <td>{{$log->created_at}}</td>
                                    <td>{{$log->updated_at}}</td>
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
@endsection
