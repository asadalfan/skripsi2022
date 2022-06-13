@extends('adminlte::page')

@section('title', 'Perusahaan')

@section('content_header')
<span>
    Pekerjaan /
    <a href="#" class="btn btn-link p-0">Perusahaan</a>
</span>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3>Perusahaan</h3>
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
                                    <th>Pemilik</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Alamat</th>
                                    <th>Dibuat pada</th>
                                    <th>Diperbarui pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($perusahaans) && count($perusahaans) > 0)
                                @php
                                $number = 0;
                                @endphp
                                @foreach ($perusahaans as $perusahaan)
                                <tr>
                                    <td>{{ ++$number }}</td>
                                    <td>{{ $perusahaan->user ? $perusahaan->user->name : '-' }}</td>
                                    <td>{{ $perusahaan->name }}</td>
                                    <td>{{ $perusahaan->description ?? '-' }}</td>
                                    <td>{{ $perusahaan->address }}</td>
                                    <td>{{ date("Y-m-d H:i:s", strtotime($perusahaan->created_at." +7 hours")) }}</td>
                                    <td>{{ date("Y-m-d H:i:s", strtotime($perusahaan->updated_at." +7 hours")) }}</td>
                                    <td>
                                        <button class="btn btn-warning" data-toggle="modal" data-target="#editModal{{$perusahaan->id}}">Edit</button>
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#hapusModal{{$perusahaan->id}}">Hapus</button>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{$perusahaan->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Perusahaan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ url('perusahaan/update/' . $perusahaan->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">Nama</label>
                                                        <input type="name" class="form-control" name="name" placeholder="Nama Perusahaan" required value="{{ $perusahaan->name }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name">Deskripsi</label>
                                                        <textarea type="description" class="form-control" name="description">{{ $perusahaan->description }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name">Alamat</label>
                                                        <textarea type="address" class="form-control" name="address" required>{{ $perusahaan->address }}</textarea>
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
                                <div class="modal fade" id="hapusModal{{$perusahaan->id}}" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="hapusModalLabel">Hapus Perusahaan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ url('perusahaan/delete/' . $perusahaan->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    Apakah anda yakin ingin menghapus Perusahaan ini?
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
                <h5 class="modal-title" id="tambahModalLabel">Tambah Perusahaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('perusahaan') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="name" class="form-control" name="name" placeholder="Nama Perusahaan" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Deskripsi</label>
                        <textarea type="description" class="form-control" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="name">Alamat</label>
                        <textarea type="address" class="form-control" name="address" required></textarea>
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
