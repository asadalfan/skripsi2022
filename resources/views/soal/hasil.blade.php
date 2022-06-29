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
                @if (Auth::user()->type == 'admin')
                <button class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">Tambah</button>
                @endif
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
                                    <td>{{ $hasil->lamaran_id }} (lamaran dari {{ $hasil->lamaran->pelamar->user->name }})</td>
                                    <td>{{ $hasil->sawKriteria->nama }}</td>
                                    <td>{{ $hasil->nilai ?? '-' }}</td>
                                    <td>{{ date("Y-m-d H:i:s", strtotime($hasil->created_at." +7 hours")) }}</td>
                                    <td>{{ date("Y-m-d H:i:s", strtotime($hasil->updated_at." +7 hours")) }}</td>
                                    <td>
                                        <button class="btn btn-warning" data-toggle="modal" data-target="#editModal{{$hasil->id}}">Edit</button>
                                        @if (Auth::user()->type == 'admin')
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#hapusModal{{$hasil->id}}">Hapus</button>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{$hasil->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Hasil</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ url($url . 'tes/hasil/update/' . $hasil->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group mb-0">
                                                        <label for="lamaran_id">ID Lamaran</label>
                                                    </div>
                                                    <select class="custom-select" name="lamaran_id" id="inputGroupSelect01">
                                                        @foreach ($lamarans as $lamaran)
                                                        <option {{ $hasil->lamaran_id == $lamaran->id ? 'selected' : '' }} value="{{ $lamaran->id }}">{{ $lamaran->id }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="form-group mb-0 mt-3">
                                                        <label for="saw_kriteria_id">Kriteria</label>
                                                    </div>
                                                    <select class="custom-select" name="saw_kriteria_id" id="inputGroupSelect01">
                                                        @foreach ($saw_kriterias as $saw_kriteria)
                                                        <option {{ $hasil->saw_kriteria_id == $saw_kriteria->id ? 'selected' : '' }} value="{{ $saw_kriteria->id }}">{{ $saw_kriteria->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="form-group mt-3">
                                                        <label for="nilai">Nilai</label>
                                                        <input type="number" class="form-control" step="0.001" name="nilai" placeholder="Nilai" required value="{{ $hasil->nilai }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hapus Modal -->
                                <div class="modal fade" id="hapusModal{{$hasil->id}}" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="hapusModalLabel">Hapus Hasil</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ url('tes/hasil/delete/' . $hasil->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    Apakah anda yakin ingin menghapus Hasil ini?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger">Iya</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="7" class="text-center">Data tidak ada. Klik tombol Tambah untuk menambah data baru.</td>
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

<!-- Tambah Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Hasil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('tes/hasil') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="lamaran_id">ID Lamaran</label>
                    </div>
                    <select class="custom-select" name="lamaran_id" id="inputGroupSelect01" required>
                        @foreach ($lamarans as $lamaran)
                        <option value="{{ $lamaran->id }}">{{ $lamaran->id }} ({{ $lamaran->pelamar->user->name }})</option>
                        @endforeach
                    </select>
                    <div class="form-group mb-0 mt-3">
                        <label for="saw_kriteria_id">Kriteria</label>
                    </div>
                    <select class="custom-select" name="saw_kriteria_id" id="inputGroupSelect01" required>
                        @foreach ($saw_kriterias as $saw_kriteria)
                        <option value="{{ $saw_kriteria->id }}">{{ $saw_kriteria->nama }}</option>
                        @endforeach
                    </select>
                    <div class="form-group mt-3">
                        <label for="nilai">Nilai</label>
                        <input type="number" class="form-control" step="0.001" name="nilai" placeholder="Nilai" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
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