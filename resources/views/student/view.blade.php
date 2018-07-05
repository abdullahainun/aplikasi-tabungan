@extends('adminlte.app')
@section('title')
Pengelolaan Siswa
@endsection

@section('page_css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">

<style type="text/css">
.noline {
	display:inline;
    margin:0px;
    padding:0px;
}
</style>
@endsection

@section('page_js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>
$(function() {
	$("#siswa").DataTable();
});
</script>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-6">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title">Edit Siswa</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<form action="{{ url('student/' . $student->id) }}" method="post">
			<div class="box-body">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="_method" value="put">
				<div class="form-group">
					<label>Nomor Identitas</label>
					<input type="number" value="{{ $student->id }}" class="form-control" disabled>
				</div>
				<div class="form-group">
					<label>Nama Siswa</label>
					<input type="text" name="name" value="{{ $student->name }}" placeholder="Masukkan nama lengkap siswa" class="form-control" required>
				</div>
				<div class="form-group">
					<label>Alamat</label>
					<input type="text" name="address" value="{{ $student->address }}" placeholder="Masukkan Alamat siswa" class="form-control" required>
				</div>
			</div>
			<div class="box-footer">
				<input type="submit" class="btn btn-success pull-right" value="Edit Siswa">
			</div>
			</form>
		</div>
	</div>
	<div class="col-lg-6 col-md-6">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title">Daftar Siswa</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<table id="siswa" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Alamat</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($students as $student)
						<tr>
							<th>{{ $student->id }}</th>
							<th>{{ $student->name }}</th>
							<th>{{ $student->address }}</th>
							<th>
								<a href="{{ url('student/' . $student->id) }}"><button class="btn btn-info" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button></a>
								<form method="post" action="{{ url('student') }}" class="noline">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="_method" value="delete">
									<input type="hidden" name="id" value="{{ $student->id }}">
									<button type="submit" class="btn btn-danger" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
								</form>
							</th>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection