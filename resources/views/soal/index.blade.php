@extends('adminlte::page')

@section('title', 'Soal')

@section('content_header')
<span>
    Tes /
    <a href="#" class="btn btn-link p-0">Soal</a>
</span>
@stop

@section('content')
@php
$userType = Auth::user()->type;
$url = $userType != 'admin' ? $userType . '/' : '';
@endphp
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3>Soal</h3>
                <button class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">Tambah</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col">
                    <form class="form-inline" action="{{ url($url . 'tes/soal') }}" method="GET">
                        @csrf
                        <div class="form-group mb-0 mr-2">
                            <label for="pencarian">Pencarian : </label>
                        </div>
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" name="cari" placeholder="Pertanyaan">
                        </div>
                        <div class="form-group mb-0">
                            <select class="custom-select" name="cari_kriteria_id" id="inputGroupSelect01">
                                @foreach ($saw_kriterias as $saw_kriteria)
                                <option value="{{ $saw_kriteria->id }}" {{ $saw_kriteria->id == $cariKriteriaId ? 'selected' : '' }}>{{ $saw_kriteria->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mb-0"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kriteria</th>
                                    <th>Pekerjaan</th>
                                    <th>Pertanyaan</th>
                                    <th>Dibuat pada</th>
                                    <th>Diperbarui pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($soals) && count($soals) > 0)
                                @php
                                $number = 0;
                                @endphp
                                @foreach ($soals as $soal)
                                <tr>
                                    <td>{{ ++$number }}</td>
                                    <td>{{ $soal->sawKriteria->nama }}</td>
                                    <td>{{ $soal->pekerjaan ? $soal->pekerjaan->name : '-' }}</td>
                                    <td>{{ $soal->description }}</td>
                                    <td>{{ date("Y-m-d H:i:s", strtotime($soal->created_at." +7 hours")) }}</td>
                                    <td>{{ date("Y-m-d H:i:s", strtotime($soal->updated_at." +7 hours")) }}</td>
                                    <td>
                                        <button class="btn btn-warning" data-toggle="modal" data-target="#editModal{{$soal->id}}">Edit</button>
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#hapusModal{{$soal->id}}">Hapus</button>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{$soal->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Soal</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ url($url . 'tes/soal/update/' . $soal->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group mb-0">
                                                        <label for="type">Kriteria</label>
                                                    </div>
                                                    <select class="custom-select" name="saw_kriteria_id" id="inputGroupSelect01">
                                                        @foreach ($saw_kriterias as $saw_kriteria)
                                                        <option {{ $soal->saw_kriteria_id == $saw_kriteria->id ? 'selected' : '' }} value="{{ $saw_kriteria->id }}">{{ $saw_kriteria->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="form-group mt-3 mb-0">
                                                        <label for="type">Pekerjaan</label>
                                                    </div>
                                                    <select class="custom-select" name="pekerjaan_id" id="inputGroupSelect01">
                                                        @foreach ($pekerjaans as $pekerjaan)
                                                        <option {{ $soal->pekerjaan_id == $pekerjaan->id ? 'selected' : '' }} value="{{ $pekerjaan->id }}">{{ $pekerjaan->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="form-group mt-3">
                                                        <label for="description">Pertanyaan</label>
                                                        <textarea type="description" class="form-control" name="description">{{ $soal->description }}</textarea>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" {{ $soal->options ? 'checked' : '' }} type="checkbox" name="use_options" value="true" id="defaultCheck1">
                                                        <label class="form-check-label" for="defaultCheck1">
                                                            Menggunakan pilihan jawaban
                                                        </label>
                                                    </div>
                                                    <div class="form-group mb-0">
                                                        <label for="description">Pilihan Jawaban</label>
                                                    </div>
                                                    @php
                                                    $options = $soal->options ? json_decode($soal->options) : ['','','',''];
                                                    $i = 0;
                                                    @endphp
                                                    @foreach ($options as $option)
                                                    <div class="form-check mt-1">
                                                        <input class="form-check-input" type="radio" {{ $option && $option->is_true ? 'checked' : '' }} name="answers[]" value="{{ $i++ }}" id="flexRadioDefault1">
                                                        <label class="form-check-label w-100" for="flexRadioDefault1">
                                                            <input type="text" class="form-control" name="options[]" placeholder="Jawaban" value="{{ $option && $option->value != null ? $option->value : '' }}">
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                    <div class="form-group">
                                                        <label for="name">Kategori</label>
                                                        <div>
                                                            @php
                                                            $ptags = [];
                                                            foreach ($soal->tags as $ptag) {
                                                            array_push($ptags, $ptag->id);
                                                            }
                                                            @endphp
                                                            <select style="width: 100%; border-color: gray;" class="select2 form-control" multiple="multiple" name="tags[]" required>
                                                                @foreach ($tags as $tag)
                                                                <option {{ in_array($tag->id, $ptags) ? 'selected' : '' }} value="{{ $tag->id }}">{{ $tag->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Simpan</button>
                                                </div>
                                            </form>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hapus Modal -->
                                <div class="modal fade" id="hapusModal{{$soal->id}}" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="hapusModalLabel">Hapus Soal</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ url($url . 'tes/soal/delete/' . $soal->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    Apakah anda yakin ingin menghapus Soal ini?
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
                <h5 class="modal-title" id="tambahModalLabel">Tambah Soal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url($url . 'tes/soal') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="type">Kriteria</label>
                    </div>
                    <select class="custom-select" name="saw_kriteria_id" id="inputGroupSelect01" required>
                        @foreach ($saw_kriterias as $saw_kriteria)
                        <option value="{{ $saw_kriteria->id }}">{{ $saw_kriteria->nama }}</option>
                        @endforeach
                    </select>
                    <div class="form-group mt-3 mb-0">
                        <label for="type">Pekerjaan</label>
                    </div>
                    <select class="custom-select" name="pekerjaan_id" id="inputGroupSelect01" required>
                        @foreach ($pekerjaans as $pekerjaan)
                        <option value="{{ $pekerjaan->id }}">{{ $pekerjaan->name }}</option>
                        @endforeach
                    </select>
                    <div class="form-group mt-3">
                        <label for="description">Pertanyaan</label>
                        <textarea type="description" class="form-control" name="description"></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="use_options" value="true" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
                            Menggunakan pilihan jawaban
                        </label>
                    </div>
                    <div class="form-group mb-0">
                        <label for="description">Pilihan Jawaban</label>
                    </div>
                    @for ($i = 0; $i < 4; $i++) <div class="form-check mt-1">
                        <input class="form-check-input" type="radio" name="answers[]" value="{{ $i }}" id="flexRadioDefault1">
                        <label class="form-check-label w-100" for="flexRadioDefault1">
                            <input type="text" class="form-control" name="options[]" placeholder="Jawaban">
                        </label>
                </div>
                @endfor
                <div class="form-group mt-3">
                    <label for="name">Kategori</label>
                    <div>
                        <select style="width: 100%; border-color: gray;" class="select2 form-control" multiple="multiple" name="tags[]" required>
                            @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
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
