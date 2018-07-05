@extends('adminlte.app')

@section('title')
About

@endsection

@section('content')

<?php
    function rupiah($angka){
        
        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        return $hasil_rupiah;
     
    }
?>

<p>
    Aplikasi tabungan ini di bangun menggunakan Laravel Framework version 5.2.39 yang berbasis PHP. bila ada permasalahan atau pertanyaan pada aplikasi ini silahkan hubungi <Strong>indobarkom</Strong>, dengan kontak berikut ini :        
</p>
<p style="font-size: 18px">Contact Person <span class="glyphicon glyphicon-user"></span> : Ainun Abdullah</p><br>
<p style="font-size: 18px">Wa/Line/Telegram <span class="glyphicon glyphicon-phone"></span> : 082338167131</p><br>
<p style="font-size: 18px">Alamat <span class="glyphicon glyphicon-tree-conifer"></span> : RT 12 - RW 03 - Sekargadung - Dukun - Gresik</p>
@endsection