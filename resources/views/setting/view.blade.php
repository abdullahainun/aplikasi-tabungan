@extends('adminlte.app')
@section('title')
Pengaturan
@endsection

@section('content')
<div class="row">
	<div class="col-lg-6">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-warning"></i> Ganti Password</h3>
			</div>
			<form method="post" action="{{ url('setting') }}">
			<div class="box-body">
				<div class="form-group">
					<label>Password baru</label>
					<input class="form-control" type="password" name="password" placeholder="Masukkan password baru" required>
				</div>
				<div class="form-group">
					<label>Konfirmasi password</label>
					<input class="form-control" type="password" name="password_verify" placeholder="Masukkan kembali password baru" required>
				</div>
			</div>
			<div class="box-footer">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="id" value="1">
				<input type="submit" class="btn btn-success pull-right" value="Ganti Password">
			</div>
			</form>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-6">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-warning"></i> Backup And Restore</h3>
				<a class="btn btn-primary pull-right"  href="{{ url('setting/backup') }}">Backup</a>			
			</div>
			<div class="box-body">
				<div class="form-group">
					
					<ul class="list-group">			
						<?php
							$backupPath = '/srv/http/manajemen-tabungan/storage/app/backups';
							if ($handle = opendir($backupPath)) {
								$no = 1;
								while (false !== ($entry = readdir($handle))) {
									
									if ($entry != "." && $entry != "..") {
										?>
										<div class="box">
										<li class="form-group list-group-item box-body">
											<div class="pull-left">
												<?php 
													echo $no.'. ';
													preg_match_all('!\d+!', $entry, $matches);
													$time = strtotime($matches[0][0]);
													$newformat = date('d M Y H:i:s',$time);
													echo $newformat;
												?>
											</div>
											<div class="pull-right">
												<a type="button" class="btn btn-primary btn-xs" href="{{ '../storage/app/backups/'.$entry.'' }}">
													<span class="glyphicon glyphicon-download"></span>
													Download
												</a>
												<a type="button" class="btn btn-success btn-xs"  href="{{ url('setting/restore?file='.$entry) }}">
													<span class="glyphicon glyphicon-repeat"></span>
													Restore
												</a>
												<a type="button"  class="btn btn-danger btn-xs"  href="{{ url('/setting/delete_backup/'.$entry) }}">
													<span class="glyphicon glyphicon-remove"></span>
													Delete
												</a>
											</div>											
										</li>
										</div>										
										<?php
									$no++;						
								}
							}
							
							closedir($handle);
						}
						?>
				
					</div>
				</div>
			</ul>			
		</div>
	</div>
</div>
@endsection