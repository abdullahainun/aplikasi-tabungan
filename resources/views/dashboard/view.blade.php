@extends('adminlte.app')
@section('title')
Dasbor

@endsection

@section('content')

<?php
    function rupiah($angka){
        
        $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
        return $hasil_rupiah;
     
    }
?>
<div class="row">
	<div class="col-lg-3 col-xs-6">
		<div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ $students }}</h3>

              <p>Siswa Terdaftar</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
            <a href="{{ url('student') }}" class="small-box-footer">Kelola siswa <i class="fa fa-arrow-circle-right"></i></a>
        </div>
	</div>
	<div class="col-lg-3 col-xs-6">
		<div class="small-box bg-purple">
            <div class="inner">
              <p style="font-size: 30px">{{ rupiah($cash) }}</p>

              <p>Total Kas</p>
            </div>
            <div class="icon">
              <i class="ion ion-cash"></i>
            </div>
            <a href="{{ url('saving') }}" class="small-box-footer">Tabungan siswa <i class="fa fa-arrow-circle-right"></i></a>
        </div>
	</div>
	<div class="col-lg-3 col-xs-6">
		<div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $transactions }}</h3>

              <p>Transaksi</p>
            </div>
            <div class="icon">
              <i class="ion ion-loop"></i>
            </div>
            <a href="{{ url('transaction') }}" class="small-box-footer">Riwayat transaksi <i class="fa fa-arrow-circle-right"></i></a>
        </div>
	</div>
	<div class="col-lg-3 col-xs-6">
		<div class="small-box bg-blue">
            <div class="inner">
            	<p>Pengaturan</p>

            	<h3>Akun</h3>
            </div>
            <div class="icon">
              <i class="ion ion-gear-a"></i>
            </div>
            <a href="{{ url('setting') }}" class="small-box-footer">Pengaturan akun <i class="fa fa-arrow-circle-right"></i></a>
        </div>
	</div>
</div>
@endsection