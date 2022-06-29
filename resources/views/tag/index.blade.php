@extends('adminlte::page')

@section('title', 'Kategori')

@section('content_header')
<span>
    Pekerjaan /
    <a href="#" class="btn btn-link p-0">Kategori</a>
</span>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3>Kategori</h3>
                <button class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">Tambah</button>
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
                                    <th>Nama</th>
                                    <th>Dibuat pada</th>
                                    <th>Diperbarui pada</th>
                                    @if(Auth::user()->type == 'admin')
                                    <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($tags) && count($tags) > 0)
                                @php
                                $number = 0;
                                @endphp
                                @foreach ($tags as $tag)
                                <tr>
                                    <td>{{ ++$number }}</td>
                                    <td>{{ $tag->name }}</td>
                                    <td>{{ date("Y-m-d H:i:s", strtotime($tag->created_at." +7 hours")) }}</td>
                                    <td>{{ date("Y-m-d H:i:s", strtotime($tag->updated_at." +7 hours")) }}</td>
                                    @if(Auth::user()->type == 'admin')
                                    <td>
                                        <button class="btn btn-warning" data-toggle="modal" data-target="#editModal{{$tag->id}}">Edit</button>
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#hapusModal{{$tag->id}}">Hapus</button>
                                    </td>
                                    @endif
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{$tag->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Kategori</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ url('kategori/update/' . $tag->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">Nama</label>
                                                        <input type="name" class="form-control" name="name" placeholder="Nama Kategori" required value="{{ $tag->name }}">
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
                                <div class="modal fade" id="hapusModal{{$tag->id}}" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="hapusModalLabel">Hapus Kategori</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ url('kategori/delete/' . $tag->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    Apakah anda yakin ingin menghapus Kategori ini?
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
                                    <td colspan="5" class="text-center">Data tidak ada. Klik tombol Tambah untuk menambah data baru.</td>
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
                <h5 class="modal-title" id="tambahModalLabel">Tambah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('kategori') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="name" class="form-control" name="name" placeholder="Nama Kategori" required>
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
<script>
</script>
@stop
