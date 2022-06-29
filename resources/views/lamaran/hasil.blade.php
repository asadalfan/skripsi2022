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
                                    <th>Pelamar</th>
                                    <th>Status</th>
                                    <th>Diterima/Ditolak pada</th>
                                    <th>Diterima/Ditolak oleh</th>
                                    <th>Alasan Diterima/Ditolak</th>
                                    <th>Aksi</th>
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
                                    <td>{{ $lamaran->pelamar->user->name }}</td>
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
                                    <td>
                                        <button class="btn btn-danger" title="Tolak" data-toggle="modal" data-target="#tolak{{$lamaran->id}}"><i class="fa fa-times"></i></button>
                                        <button class="btn btn-success" title="Terima" data-toggle="modal" data-target="#terima{{$lamaran->id}}"><i class="fa fa-check"></i></button>
                                    </td>
                                </tr>

                                <!-- Tolak Modal -->
                                <div class="modal fade" id="tolak{{$lamaran->id}}" tabindex="-1" role="dialog" aria-labelledby="tolakModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="hapusModalLabel">Tolak Lamaran</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ url('lamaran/' . $lamaran->id) . '/tolak' }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="alasan_diterima">Alasan menolak</label>
                                                        <textarea type="text" class="form-control" name="alasan_diterima"></textarea>
                                                    </div>
                                                    <div>
                                                        Apakah anda yakin ingin menolak Lamaran ini?
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger">Iya</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Terima Modal -->
                                <div class="modal fade" id="terima{{$lamaran->id}}" tabindex="-1" role="dialog" aria-labelledby="terimaModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="hapusModalLabel">Terima Lamaran</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ url('lamaran/' . $lamaran->id) . '/terima' }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="alasan_diterima">Alasan menerima</label>
                                                        <textarea type="text" class="form-control" name="alasan_diterima"></textarea>
                                                    </div>
                                                    <div>
                                                        Apakah anda yakin ingin menerima Lamaran ini?
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Iya</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8" class="text-center">Data tidak ada. Tunggu Lamaran yang sudah diverifikasi.</td>
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
