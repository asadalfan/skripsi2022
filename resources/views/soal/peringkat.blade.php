@extends('adminlte::page')

@section('title', 'Peringkat')

@section('content_header')
<span>
    Tes /
    <a href="#" class="btn btn-link p-0">Peringkat</a>
</span>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3>Peringkat</h3>
                <a href="{{ url('tes/peringkat/hitung') }}" class="btn btn-primary">Update Peringkat</a>
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
                                    <th>ID Lamaran</th>
                                    <th>Pelamar</th>
                                    <th>Tes</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($peringkats) && count($peringkats) > 0)
                                @php
                                $number = 0;
                                @endphp
                                @foreach ($peringkats as $peringkat)
                                <tr>
                                    <td>{{ ++$number }}</td>
                                    <td>{{ $peringkat->lamaran_id }}</td>
                                    <td>{{ $peringkat->lamaran->pelamar->user->name }}</td>
                                    <td>
                                        <a class="btn btn-link" data-toggle="modal" data-target="#detailModal{{$peringkat->id}}" title="Lihat detail hasil nilai tes">Lihat</a>
                                    </td>
                                    <td>
                                        <abbr title="{{ $peringkat->nilai }}"><strong>{{ $peringkat->nilai_fuzzy }}</strong></abbr>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">Data tidak ada. Klik tombol Update Peringkat untuk menghitung data terbaru.</td>
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

@foreach ($peringkats as $peringkat)
<!-- Detail Modal -->
<div class="modal fade" id="detailModal{{$peringkat->id}}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Nilai Tes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tes</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($peringkat->lamaran->sawHasils) && count($peringkat->lamaran->sawHasils) > 0)
                            @php
                            $number = 0;
                            @endphp
                            @foreach ($peringkat->lamaran->sawHasils as $hasil)
                            <tr>
                                <td>{{ ++$number }}</td>
                                <td>{{ $hasil->sawKriteria->nama }}</td>
                                <td>{{ $hasil->nilai }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="3" class="text-center">Pelamar belum memiliki nilai tes.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
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
