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
									<td>{{ $pekerjaan->name }}</td>
									<td>{{ $pekerjaan->description ?? '-' }}</td>
									<td>{{ $pekerjaan->perusahaan->name }}</td>
									<td>{{ $pekerjaan->created_at }}</td>
									<td>{{ $pekerjaan->updated_at }}</td>
									<td>
										<button class="btn btn-warning" data-toggle="modal" data-target="#editModal{{$pekerjaan->id}}">Edit</button>
										<button class="btn btn-danger" data-toggle="modal" data-target="#hapusModal{{$pekerjaan->id}}">Hapus</button>
									</td>
								</tr>

								<!-- Edit Modal -->
								<div class="modal fade" id="editModal{{$pekerjaan->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="editModalLabel">Edit Pekerjaan</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<form action="{{ url('pekerjaan/update/' . $pekerjaan->id) }}" method="POST">
												@csrf
												<div class="modal-body">
													<div class="form-group">
														<label for="name">Perusahaan</label>
														<select class="form-control" name="perusahaan_id" required>
															@foreach ($perusahaans as $perusahaan)
										                    <option {{ $pekerjaan->perusahaan->id == $perusahaan->id ? 'selected' : '' }} value="{{ $perusahaan->id }}">{{ $perusahaan->name }}</option>
															@endforeach
										                </select>
													</div>
													<div class="form-group">
														<label for="name">Nama</label>
														<input type="name" class="form-control" name="name" placeholder="Nama Pekerjaan" required value="{{ $pekerjaan->name }}">
													</div>
													<div class="form-group">
														<label for="name">Deskripsi</label>
														<textarea type="description" class="form-control" name="description">{{ $pekerjaan->description }}</textarea>
													</div>
													<div class="form-group">
														<label for="name">Kategori</label>
														<div>
															@php
															$ptags = [];
															foreach ($pekerjaan->tags as $ptag) {
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
								<div class="modal fade" id="hapusModal{{$pekerjaan->id}}" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="hapusModalLabel">Hapus Pekerjaan</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<form action="{{ url('pekerjaan/delete/' . $pekerjaan->id) }}" method="POST">
												@csrf
												<div class="modal-body">
													Apakah anda yakin ingin menghapus Pekerjaan ini?
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
				<h5 class="modal-title" id="tambahModalLabel">Tambah Pekerjaan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ url('pekerjaan') }}" method="POST">
				@csrf
				<div class="modal-body">
					<div class="form-group">
						<label for="name">Perusahaan</label>
						<select class="form-control" name="perusahaan_id" required>
							@foreach ($perusahaans as $perusahaan)
		                    <option value="{{ $perusahaan->id }}">{{ $perusahaan->name }}</option>
							@endforeach
		                </select>
					</div>
					<div class="form-group">
						<label for="name">Nama</label>
						<input type="name" class="form-control" name="name" placeholder="Nama Pekerjaan" required>
					</div>
					<div class="form-group">
						<label for="name">Deskripsi</label>
						<textarea type="description" class="form-control" name="description"></textarea>
					</div>
					<div class="form-group">
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