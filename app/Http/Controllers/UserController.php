<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Hash;
use Artisan;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function updatePassword(Request $request) {
    	if ($request->input('password') != $request->input('password_verify')) {
    		$message = 'Password tidak sama.';
    		return redirect('/setting')->with('warning', $message);
    	}
    	$user = User::findOrFail(1);
    	$user->fill([
    		'password' => Hash::make($request->input('password')),
    	])->save();
    	$message = "Password sukses diganti.";
    	return redirect('/setting')->with('success', $message);
    }

    public function viewSetting() {
    	$data = array(
    		'page' => 'setting',
    		);
    	return view('setting.view', $data);
	}
	
	public function backup(Request $request)
	{
		Artisan::call("backup:mysql-dump");
		$message = "Data berhasil di backup.";
    return redirect('/setting')->with('success', $message);
	}
	public function restore()
	{
		Artisan::call('backup:mysql-restore', ['--filename' => $_GET['file'], '--yes' => ' ']);
		$message = "Data berhasil di backup.";
    return redirect('/setting')->with('success', $message);
	}
	public function delete_backup($file){
		Storage::disk('local')->delete('backups/'.$file);
		$message = "Data berhasil di hapus.";		
    return redirect('/setting')->with('success', $message);		
	}
}
