<?php
	function rupiah($angka){
		
		$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
		return $hasil_rupiah;
	 
	}
?>
@extends('adminlte.app')
@section('title')
Tabungan Siswa
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
	$("#tabungan").DataTable();
});
</script>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title">Daftar Tabungan</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<table id="tabungan" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Siswa</th>
							<th>Total Pemasukan</th>
							<th>Total Pengambilan</th>
							<th>Total Saldo</th>
							<th>Aktifitas Terakhir</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($savings as $saving)
						<tr>
							<th>{{ $saving->student->id }}</th>
							<th>{{ $saving->student->name }}</th>
							<th>{{ rupiah($saving->getTotalMasuk($saving->student->id)) }}</th>
							<th>{{ rupiah($saving->getTotalKeluar($saving->student->id)) }}</th>
							<th>{{ rupiah($saving->getTotalSaldo($saving->student->id)) }}</th>
							<th>{{ $saving->getLatestTransaction($saving->student->id) }}</th>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="box-footer">
				<div class="col-md-12 col-xs-12 col-sm-12 text-right">
					<div class="btn-group">
						<button class="btn btn-primary  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Export All Data <span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							{{-- <li><a href="{{ route('htmltopdf',['downloadpdf'=>'pdf']) }}">Export to PDF</a></li> --}}
							<li><a href="{{ route('savetoexcel',['downloadexcel' => 'excel']) }} ">Export to Excel</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection