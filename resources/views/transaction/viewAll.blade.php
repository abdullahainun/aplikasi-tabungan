<?php
	function rupiah($angka){
		
		$hasil_rupiah = number_format($angka,0,'.',',');
		return $hasil_rupiah;
	 
	}
?>
@extends('adminlte.app')
@section('title')
Transaksi
@endsection

@section('page_css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<script src="{{ asset('dist/js/vue.js') }}"></script>

<style type="text/css">
.noline {
	display:inline;
    margin:0px;
    padding:0px;
}
.tfoot input {
	width: 100%;
    padding: 3px;
    box-sizing: border-box;
}
</style>
@endsection

@section('page_js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>

jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "currency-pre": function ( a ) {
        a = (a==="-") ? 0 : a.replace( /[^\d\-\.]/g, "" );
        return parseFloat( a );
    },
 
    "currency-asc": function ( a, b ) {
        return a - b;
    },
 
    "currency-desc": function ( a, b ) {
        return b - a;
    }
} );

$(document).ready(function() {
	
	// Bootstrap datepicker
	$('.input-daterange input').each(function() {
		$(this).datepicker('clearDates');
	});


	$('#transaksi thead th').each( function () {
        var title = $('#transaksi tfoot th').eq( $(this).index() ).text();
		if (title != 'aksi' && title != 'Tanggal' && title != 'Jenis Transaksi' && title != 'Saldo') {
        	$(this).html( '<input type="text" placeholder="Cari '+title+'" />' );			
		}else if(title == 'Jenis Transaksi'){
			$(this).html('<select id="filter_jns_transaksi" class="btn btn-primary"> \
				<option value="">Semua</option>\
				<option value="setor">setor</option>\
				<option value="ambil">ambil</option> \</select>');
		}
    } );
 
    // DataTable
	var table = $('#transaksi').DataTable({
		"columnDefs": [
			  { "targets": 6, "orderable": false },
			  { "type": "currency", targets: 5 },
			  {
                "targets": [ 0 ],
                "visible": false
              }
  		]
	});
	$("#filter_jns_transaksi").on('change', function() {
	    //filter by selected value on second column
	    table.column(4).search($(this).val()).draw();
	}); 
	
	// var totalSaldo = 0;	
	// Extend dataTables search
	$.fn.dataTable.ext.search.push(
	function(settings, data, dataIndex) {
			var min = $('#min-date').val();
			var max = $('#max-date').val();
			var createdAt = data[0] || 0; // Our date column in the table
			var saldo = data[4] || 0;
			// totalSaldo = Number(totalSaldo) + Number(saldo.replace(",", ""));
			if (
				(min == "" || max == "") ||
				(moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
			) {
				return true;
			}
			return false;
		}
	);
	// Re-draw the table when the a date range filter changes
	$('.date-range-filter').change(function() {
		table.draw();
	});

	// $('#my-table_filter').hide();
    // Apply the search
    table.columns().eq( 0 ).each( function ( colIdx ) {
        $( 'input', table.column( colIdx ).header() ).on( 'keyup change', function () {
            table
                .column( colIdx )
                .search( this.value )
                .draw();
        } );
    } );
} );
</script>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="box box-success">
			<div class="box-header with-border">
				<div class="row">
					<div class="col-md-4">
						<h3 class="box-title">Riwayat Transaksi</h3>				
					</div>
					<div class="col-md-4 pull-right">
						<div class="input-group input-daterange">
							<input type="text" id="min-date" class="form-control date-range-filter" data-date-format="d M yyyy " placeholder="From:">					  
							<div class="input-group-addon">to</div>					  
							<input type="text" id="max-date" class="form-control date-range-filter" data-date-format="d M yyyy" placeholder="To:"> 
						  </div>
						</div>
				</div>
			</div>
			<div class="box-body">
				<table id="transaksi" class="display table table-bordered table-striped tabl-sm" style="width:100%">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>timestamp</th>
							<th>No</th>
							<th>siswa</th>
							<th>Jenis Transaksi</th>
							<th>Saldo</th>
							<th>aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($transactions as $transaction)
						<tr>
							<th>{{ $transaction->created_at->format('d-M-Y') }}</th>
							<th>{{ $transaction->created_at->format('d-M-Y h:i:sa') }}</th>
							<th>{{ $transaction->student->id }}</th>
							<th>{{ $transaction->student->name }}</th>
							<th>@if ($transaction->type) Setor @else Ambil @endif</th>
							{{-- <th><p style="text-align: right">{{ rupiah($transaction->amount) }}</p></th> --}}
							<th>{{ rupiah($transaction->amount) }}</th>
							<th>
								<form method="post" action="{{ url('transaction') }}" class="noline">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="_method" value="delete">
									<input type="hidden" name="id" value="{{ $transaction->id }}">
									<button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
								</form>
							</th>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th>Tanggal</th>
							<th>timestamp</th>
							<th>No</th>
							<th>siswa</th>
							<th>Jenis Transaksi</th>
							<th>Saldo</th>
							<th>aksi</th>
						</tr>
					</tfoot>
				</table>				
			</div>
			<div class="box-footer with-border">
				{{-- <p>total saldo = </p>					 --}}
			</div>
		</div>
	</div>

</div>
<script>
</script>
@endsection