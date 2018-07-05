@extends('adminlte.app')
@section('title')
Panduan Menggunakan aplikasi
@endsection

@section('content')
<div class="container">
    <div class="row col-md-12 col-sm-12">        
        <h4>1. Membuat user baru untuk setiap periode tabungan</h4>
        <!-- 16:9 aspect ratio -->
        <div class="col-sm-12 col-xs-12 col-md-8">
            <div class="embed-responsive embed-responsive-16by9">
                <video width="320" height="240" controls>
                        <source src="{{ asset('tutorial/register.webm')}} " type="video/mp4">
                </video>
            </div>
            <hr>
        </div>
    </div>
    <div class="row col-md-12 col-sm-12">        
        <h4>2. Mengelola data nasabah / siswa</h4>
        <div class="col-sm-12 col-xs-12 col-md-8">
            <ul>
                <li>
                    Menambahkan nasabah / siswa secara manual
                </li>
            </ul>
            <div class="embed-responsive embed-responsive-16by9">
                <video width="320" height="240" controls>
                    <source src="{{ asset('tutorial/add_student.webm')}} " type="video/mp4">
                </video>
            </div>
            <hr>            
        </div>
        <div class="col-sm-12 col-xs-12 col-md-8">
            <br>
            <ul>
                <li>
                    Menambahkan nasabah / siswa malalui file excel/csv 
                </li>
            </ul>            
        <p>Bila anda ingin menambahkan nasabah melalui file excel, silahkan download template file excel <a href="{{ asset('import/list_siswa.xls') }}">ini</a>, kemudian import file tersebut ke aplikasi ini.</p>
            <div class="embed-responsive embed-responsive-16by9">
                <video width="320" height="240" controls>
                    <source src="{{ asset('tutorial/import_student.webm')}} " type="video/mp4">
                </video>
            </div>
            <hr>            
        </div>
    </div>
    <div class="row col-md-12 col-sm-12">        
        <h4>3. Transaksi</h4>
        <!-- 16:9 aspect ratio -->
        <div class="col-sm-12 col-xs-12 col-md-8">
            <div class="embed-responsive embed-responsive-16by9">
                <video width="320" height="240" controls>
                    <source src="{{ asset('tutorial/transaksi.webm') }}" type="video/mp4">
                </video>                
            </div>
        </div>
        <hr>        
    </div>    
    <div class="row col-md-12 col-sm-12">        
        <h4>4. export rekap transaksi berdasarkan periode yang di inginkan</h4>
        <!-- 16:9 aspect ratio -->
        <div class="col-sm-12 col-xs-12 col-md-8">
            <div class="embed-responsive embed-responsive-16by9">
                <video width="320" height="240" controls>
                    <source src="{{ asset('tutorial/export_to_excel.webm') }}" type="video/mp4">
                </video>    
            </div>
        </div>
    </div>        
    <div class="row col-md-12 col-sm-12">        
        <h4>5. export hasil akhir tabungan </h4>
        <!-- 16:9 aspect ratio -->
        <div class="col-sm-12 col-xs-12 col-md-8">
            <div class="embed-responsive embed-responsive-16by9">
                <video width="320" height="240" controls>
                    <source src="{{ asset('tutorial/export_hasilakhir.webm') }}" type="video/mp4">
                </video> 
            </div>
        </div>
    </div>                                   
</div>
@endsection