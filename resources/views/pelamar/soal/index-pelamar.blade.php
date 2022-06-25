@extends('adminlte::page')

@section('title', 'Mengerjakan Tes')

@section('content_header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Tes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Soal</li>
    </ol>
</nav>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3>Soal {{ $kriteria->nama }}</h3>
            </div>
        </div>
        <form action="{{ url('pelamar/tes/soal/'.$kriteria->id.'/'.$lamaran->id.'/selesai') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        @php
                        $number = 0;
                        @endphp
                        @foreach($soals as $soal)
                        <div class="row mb-1">
                            <div class="col-12 h5">
                                {{ ++$number }}.&emsp;{{ $soal->description }}
                            </div>
                        </div>
                        <div class="row ml-5">
                            @if($soal->options)
                            @php
                            $options = $soal->options ? json_decode($soal->options, true) : [];
                            @endphp
                            @foreach($options as $option)
                            <div class="col-6">
                                <input type="radio" name="{{ $soal->id }}" value="{{ $option['value'] . ($option['is_true'] ? '~~~correct' : '') }}">
                                <label>{{ $option['value'] }}</label>
                            </div>
                            @endforeach
                            @else
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="{{ $soal->id }}">
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex flex-row-reverse">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
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
