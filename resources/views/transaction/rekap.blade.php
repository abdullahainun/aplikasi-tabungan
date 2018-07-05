<?php
	function rupiah($angka){
		
		$hasil_rupiah = number_format($angka,0,',','.');
		return $hasil_rupiah;
	 
	}
?>
@extends('adminlte.app')
@section('title')
Rekap Transaksi
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
		$(this).datepicker({
            format: "yyyy-mm-dd",
            // startView: "months", 
            // minViewMode: "months"            
        });

	});

 
    // DataTable
	var table = $('#transaksi').DataTable({
		"columnDefs": [
			//   { "targets": 5, "orderable": false },
			  { "type": "currency", targets: [2,3,4] },
  		]
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
		// Create Base64 Object
		var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

        var date = $(this).val();

        if($("#min-date").val()!="" && $("#max-date").val()!=""){
            // var url='?start='+$("#min-date").val()+'&end='+$("#max-date").val();
            var url='?start='+Base64.encode($("#min-date").val())+'&end='+Base64.encode($("#max-date").val());
            window.location = url;
        }
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
                            <div class="col-md-8">
							<?php
								$start= base64_decode($_GET['start']);
								$end=base64_decode($_GET['end']);
							?>
							{{-- <h3 class="box-title">Rekap tabungan dari <strong>{{ date_format($start,"d M Y") }} s/d {{ date_format($end,"d M Y")}}</strong></h3> --}}
							<h3 class="box-title">Rekap tabungan dari <strong>{{ $start }} s/d {{ $end }}</strong></h3>
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
				<table id="transaksi" class="display table table-bordered table-striped table-sm" style="width:100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
                            <th>Masuk</th>
							<th>Keluar</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
							<?php
								$totalMasuk = 0;
								$totalKeluar = 0;
								$totalSaldo = 0;
							?>
							@foreach ($savings as $saving)
							<?php
								$totalMasuk += $saving->getTotalMasukBy($saving->student->id, $_GET['start'], $_GET['end']);
								$totalKeluar += $saving->getTotalKeluarBy($saving->student->id, $_GET['start'], $_GET['end']);
								$totalSaldo += $saving->getTotalSaldoBy($saving->student->id, $_GET['start'], $_GET['end']);
							?> 
                            <tr>
                                <th>{{ $saving->student->id }}</th>
                                <th>{{ $saving->student->name }}</th>
                                <th><p style="text-align: right">{{ rupiah($saving->getTotalMasukBy($saving->student->id, $_GET['start'], $_GET['end'])) }}</p></th>
                                <th><p style="text-align: right">{{ rupiah($saving->getTotalKeluarBy($saving->student->id, $_GET['start'], $_GET['end'])) }}</p></th>
                                <th><p style="text-align: right">{{ rupiah($saving->getTotalSaldoBy($saving->student->id, $_GET['start'], $_GET['end'])) }}</p></th>
                            </tr>
                            @endforeach
					</tbody>
					<tfoot>
						<tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Total</th>
						</tr>
					</tfoot>
				</table>				
			</div>
			<div class="box-footer with-border">
				<div class="row">
					<div class="col-md-8">
						<p style="font-size: 24px"> 
							<span class="label label-success">Total Masuk : {{ 'Rp. '.rupiah($totalMasuk) }}</span>
							<span class="label label-danger">Total Keluar :{{ 'Rp. '.rupiah($totalKeluar) }}</span>
							<span class="label label-primary">Total Saldo : {{ 'Rp. '.rupiah($totalSaldo) }}</span>									
						</p>
					</div>
					<div class="col-md-4 text-right">
						<div class="btn-group">
							<button class="btn btn-primary  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Export All Data <span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								{{-- <li><a href="{{ route('htmltopdf',['downloadpdf'=>'pdf']) }}">Export to PDF</a></li> --}}
								<li><a href="{{ route('htmltoexcel',['start' => base64_encode($_GET['start']), 'end' => base64_encode($_GET['end']), 'downloadexcel'=>'excel']) }}">Export to Excel</a></li>
							</ul>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>

</div>
<script>
</script>
@endsection