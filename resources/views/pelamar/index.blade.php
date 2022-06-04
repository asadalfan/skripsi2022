@extends('adminlte::page')

@section('title', 'Pelamar')

@section('content_header')
<span>
	<a href="#" class="btn btn-link p-0">Pelamar</a>
</span>
@stop

@section('content')
<div class="container-fluid">
	<div class="card">
		<div class="card-header">
			<div class="d-flex justify-content-between">
				<h3>Pelamar</h3>
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
									<th>Email</th>
									<th>Alamat</th>
									<th>Dibuat pada</th>
									<th>Diperbarui pada</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($pelamars) && count($pelamars) > 0)
								@php
								$number = 0;
								@endphp
								@foreach ($pelamars as $pelamar)
								<tr>
									<td>{{ ++$number }}</td>
									<td>{{ $pelamar->user->name }}</td>
									<td>{{ $pelamar->user->email }}</td>
									<td>{{ $pelamar->address }}</td>
									<td>{{ $pelamar->created_at }}</td>
									<td>{{ $pelamar->updated_at }}</td>
									<td>
										<button class="btn btn-warning" data-toggle="modal" data-target="#editModal{{$pelamar->id}}">Edit</button>
										<button class="btn btn-danger" data-toggle="modal" data-target="#hapusModal{{$pelamar->id}}">Hapus</button>
									</td>
								</tr>

								<!-- Edit Modal -->
								<div class="modal fade" id="editModal{{$pelamar->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="editModalLabel">Edit Pelamar</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<form action="{{ url('pelamar/update/' . $pelamar->id) }}" method="POST">
												@csrf
												<div class="modal-body">
													<div class="form-group">
														<label for="name">Nama</label>
														<input type="name" class="form-control" name="name" placeholder="Nama Pelamar" required value="{{ $pelamar->user->name }}">
													</div>
													<div class="form-group">
														<label for="email">Email</label>
														<input type="email" class="form-control" name="email" placeholder="Email Pelamar" required value="{{ $pelamar->user->email }}">
													</div>
													<div class="form-group">
														<label for="password">Password</label>
														<input type="password" class="form-control" name="password" placeholder="Password" minlength="8">
													</div>
													<div class="form-group">
														<label for="name">Alamat</label>
														<textarea type="address" class="form-control" name="address" required>{{ $pelamar->address }}</textarea>
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
								<div class="modal fade" id="hapusModal{{$pelamar->id}}" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="hapusModalLabel">Hapus Pelamar</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<form action="{{ url('pelamar/delete/' . $pelamar->id) }}" method="POST">
												@csrf
												<div class="modal-body">
													Apakah anda yakin ingin menghapus Pelamar ini?
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
				<h5 class="modal-title" id="tambahModalLabel">Tambah Pelamar</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ url('pelamar') }}" method="POST">
				@csrf
				<div class="modal-body">
					<div class="form-group">
						<label for="name">Nama</label>
						<input type="name" class="form-control" name="name" placeholder="Nama Pelamar" required>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email" placeholder="Email Pelamar" required>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" placeholder="Password" required minlength="8">
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
