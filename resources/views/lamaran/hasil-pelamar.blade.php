@extends('adminlte::page')

@section('title', 'Hasil Lamaran')

@section('content_header')
<span>
    Lamaran /
    <a href="#" class="btn btn-link p-0">Hasil Lamaran</a>
</span>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3>Hasil Lamaran</h3>
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
                                    <th>Status</th>
                                    <th>Diterima/Ditolak pada</th>
                                    <th>Diterima/Ditolak oleh</th>
                                    <th>Alasan Diterima/Ditolak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($lamarans) && count($lamarans) > 0)
                                @php
                                $number = 0;
                                @endphp
                                @foreach ($lamarans as $lamaran)
                                <tr>
                                    <td>{{ ++$number }}</td>
                                    <td>{{ $lamaran->pekerjaan->name }}</td>
                                    <td>
                                        @if ($lamaran->diterima)
                                        <span class="badge badge-success">Diterima</span>
                                        @elseif ($lamaran->diterima_pada)
                                        <span class="badge badge-danger">Ditolak</span>
                                        @else
                                        <span class="badge badge-warning">Menunggu</span>
                                        @endif
                                    </td>
                                    <td>{{ $lamaran->diterima_pada ? date("Y-m-d H:i:s", strtotime($lamaran->diterima_pada." +7 hours")) : '-' }}</td>
                                    <td>{{ $lamaran->diterimaOleh ? $lamaran->diterimaOleh->name : '-' }}</td>
                                    <td>{{ $lamaran->alasan_diterima ? $lamaran->alasan_diterima : '-' }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">Data tidak ada.</td>
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
<link rel="stylesheet" href="/css/admin_custom.css">
@stop
