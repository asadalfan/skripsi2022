@extends('adminlte::page')

@section('title', 'Pekerjaan')

@section('content_header')
<span>
    Pekerjaan /
    <a href="#" class="btn btn-link p-0">Pekerjaan</a>
</span>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3>Pekerjaan</h3>
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
                                    <th>Pemilik</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Perusahaan</th>
                                    <th>Dibuat pada</th>
                                    <th>Diperbarui pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($pekerjaans) && count($pekerjaans) > 0)
                                @php
                                $number = 0;
                                @endphp
                                @foreach ($pekerjaans as $pekerjaan)
                                <tr>
                                    <td>{{ ++$number }}</td>
                                    <td>{{ $pekerjaan->user ? $pekerjaan->user->name : '-' }}</td>
                                    <td class="d-inline-block">
                                        {{ $pekerjaan->name }}
                                        @if($pekerjaan->diverifikasi)
                                        <i class="fa fa-check-circle text-small text-primary align-top" title="Terverifikasi"></i>
                                        @endif
                                    </td>
                                    <td>{{ $pekerjaan->description ?? '-' }}</td>
                                    <td>{{ $pekerjaan->perusahaan->name }}</td>
                                    <td>{{ date("Y-m-d H:i:s", strtotime($pekerjaan->created_at." +7 hours")) }}</td>
                                    <td>{{ date("Y-m-d H:i:s", strtotime($pekerjaan->updated_at." +7 hours")) }}</td>
                                    <td>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#lamarModal{{$pekerjaan->id}}">Ajukan Lamaran</button>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="lamarModal{{$pekerjaan->id}}" tabindex="-1" role="dialog" aria-labelledby="lamarModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="lamarModalLabel">Pengajuan Lamaran</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ url('pelamar/pekerjaan/lamar') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">Pelamar</label>
                                                        <select class="form-control" name="pelamar_id" required>
                                                            @php
                                                            $pelamar = Auth::user()->pelamar;
                                                            @endphp
                                                            <option {{ $pekerjaan->pelamar_id == $pelamar->id ? 'selected' : '' }} value="{{ $pelamar->id }}">{{ $pelamar->user->name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name">Pekerjaan</label>
                                                        <select class="form-control" name="pekerjaan_id" required>
                                                            <option {{ $pekerjaan->pekerjaan_id == $pekerjaan->id ? 'selected' : '' }} value="{{ $pekerjaan->id }}">{{ $pekerjaan->name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name">Berkas</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="inputGroupFileAddon01">CV</span>
                                                            </div>
                                                            <div class="custom-file">
                                                                <input type="file" name="cv" class="custom-file-input lamar" id="cv_input{{$number}}">
                                                                <label class="custom-file-label" id="cv_input_label{{$number}}" for="cv_input">Pilih berkas</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Ajukan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8" class="text-center">Data tidak ada.</td>
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
<script src="{{ asset('vendor/bootstrap/bs-custom-file-input.js') }}"></script>
<script type="text/javascript">
    for (let i = 1; i <= <?php echo count($pekerjaans); ?>; i++) {
        $('#cv_input' + i).on('change', function() {
            var fileName = document.getElementById("cv_input" + i).files[0].name;
            var nextSibling = document.getElementById("cv_input_label"+i);
            nextSibling.innerText = fileName;
        });
    }
</script>
@stop
