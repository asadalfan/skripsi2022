@extends('adminlte::page')

@section('title', 'Hasil')

@section('content_header')
<span>
    Tes /
    <a href="#" class="btn btn-link p-0">Hasil</a>
</span>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3>Hasil</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pekerjaan</th>
                                    <th>Kriteria</th>
                                    <th>Nilai</th>
                                    <th>Dibuat pada</th>
                                    <th>Diperbarui pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($hasils) && count($hasils) > 0)
                                @php
                                $number = 0;
                                @endphp
                                @foreach ($hasils as $hasil)
                                <tr>
                                    <td>{{ ++$number }}</td>
                                    <td>{{ $hasil->lamaran->pekerjaan->name }}</td>
                                    <td>{{ $hasil->sawKriteria->nama }}</td>
                                    <td>{{ $hasil->nilai ?? '-' }}</td>
                                    <td>{{ date("Y-m-d H:i:s", strtotime($hasil->created_at." +7 hours")) }}</td>
                                    <td>{{ date("Y-m-d H:i:s", strtotime($hasil->updated_at." +7 hours")) }}</td>
                                    <td>
                                        <button class="btn btn-info" data-toggle="modal" data-target="#detailModal{{$hasil->id}}">Detail</button>
                                    </td>
                                </tr>

                                <!-- Detail Modal -->
                                <div class="modal fade" id="detailModal{{$hasil->id}}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel">Detail Hasil</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        @php
                                                        $number = 0;
                                                        @endphp
                                                        @foreach($hasil->sawHasilDetails as $detail)
                                                        <div class="row mb-1">
                                                            <div class="col-12">
                                                                {{ ++$number }}.&emsp;{{ $detail->soal->description }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon1">Jawaban</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" placeholder="Jawaban" value="{{ $detail->answer }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-success" data-dismiss="modal">Ok</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="7" class="text-center">Data tidak ada.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="/css/admin_custom.css">
<style type="text/css">
    .form-group .select2 .select2-selection__rendered {
        font-size: 1rem !important;
        line-height: normal;
    }

    .form-group .select2 .select2-selection__choice {
        background: #3490dc;
        border-color: #1C7BCA;
    }

    .form-group .select2 .select2-selection__choice .select2-selection__choice__remove {
        color: white;
        margin: 0px;
    }

    .form-group .select2 .select2-selection__choice .select2-selection__choice__remove:hover {
        color: white;
        margin: 0px;
        background: red;
    }
</style>
@stop

@section('js')
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@stop
