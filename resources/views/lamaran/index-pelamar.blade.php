@extends('adminlte::page')

@section('title', 'Lamaran')

@section('content_header')
<span>
    Lamaran /
    <a href="#" class="btn btn-link p-0">Lamaran</a>
</span>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3>Lamaran</h3>
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
                                    <th>CV</th>
                                    <th>Dibuat pada</th>
                                    <th>Diperbarui pada</th>
                                    <th>Status Verifikasi</th>
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
                                    <td>
                                        <a href="{{ asset('storage/cv/' . json_decode($lamaran->files)->cv) }}" class="btn-link" target="_blank" title="Lihat / Download">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td>{{ date("Y-m-d H:i:s", strtotime($lamaran->created_at." +7 hours")) }}</td>
                                    <td>{{ date("Y-m-d H:i:s", strtotime($lamaran->updated_at." +7 hours")) }}</td>
                                    <td>
                                        @if (! $lamaran->diverifikasi_pada)
                                        <span class="text-warning">Menunggu</span>
                                        @elseif($lamaran->diverifikasi)
                                        <span class="text-success">Terverifikasi</span>
                                        @else
                                        <span class="text-danger">Tidak terverifikasi</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($lamaran->diverifikasi && $lamaran->diverifikasi_pada)
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#tesModal{{$lamaran->id}}">Lihat Tes</button>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Tes Modal -->
                                <div class="modal fade" id="tesModal{{$lamaran->id}}" tabindex="-1" role="dialog" aria-labelledby="tesModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="tesModalLabel">List Tes</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @php
                                                $numberKriteria = 0;
                                                $hasilKriteriaIds = [];
                                                foreach($lamaran->sawHasils as $hasil) {
                                                    array_push($hasilKriteriaIds, $hasil->saw_kriteria_id);
                                                }
                                                @endphp
                                                @foreach($kriterias as $kriteria)
                                                <div class="row">
                                                    <div class="col-1 mb-1">
                                                        {{ ++$numberKriteria }}
                                                    </div>
                                                    <div class="col-6 mb-1">
                                                        {{ $kriteria->nama }}
                                                    </div>
                                                    <div class="col-5 mb-1 d-flex flex-row-reverse">
                                                        @if(in_array($kriteria->id, $hasilKriteriaIds))
                                                        <span class="text-success">Sudah dikerjakan</span>
                                                        @else
                                                        <a href="{{ url('pelamar/tes/soal/'. $kriteria->id .'/'. $lamaran->id ) }}" class="btn btn-primary">Kerjakan</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">Data tidak ada. Klik tombol Tambah untuk menambah data baru.</td>
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
                <h5 class="modal-title" id="tambahModalLabel">Tambah Lamaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('lamaran') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Pelamar</label>
                        <select class="form-control" name="pelamar_id" required>
                            @foreach ($pelamars as $pelamar)
                            <option value="{{ $pelamar->id }}">{{ $pelamar->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Pekerjaan</label>
                        <select class="form-control" name="pekerjaan_id" required>
                            @foreach ($pekerjaans as $pekerjaan)
                            <option value="{{ $pekerjaan->id }}">{{ $pekerjaan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Berkas</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">CV</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="cv" class="custom-file-input add" id="cv_input" required>
                                <label class="custom-file-label" id="cv_input_label" for="cv_input">Pilih berkas</label>
                            </div>
                        </div>
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
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script src="{{ asset('vendor/bootstrap/bs-custom-file-input.js') }}"></script>
<script type="text/javascript">
    var addClass = document.querySelector('.add');
    addClass.addEventListener('change', function(e) {
        var fileName = document.getElementById("cv_input").files[0].name;
        var nextSibling = document.getElementById("cv_input_label");
        nextSibling.innerText = fileName;
    });

    var editClass = document.querySelector('.edit');
    editClass.addEventListener('change', function(e) {
        var fileNameEdit = document.getElementById("cv_input_edit").files[0].name;
        var nextSiblingEdit = document.getElementById("cv_input_label_edit");
        nextSiblingEdit.innerText = fileNameEdit;
    });
</script>
@stop
