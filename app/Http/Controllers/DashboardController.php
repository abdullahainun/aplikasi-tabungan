<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Student;
use App\Transaction;

class DashboardController extends Controller
{

	private $students;

	public function __construct() {
		$this->middleware('auth');
		$this->students = Student::all();
	}

    public function index() {
    	$data = array(
    		'page' => 'dashboard',
    		'students' => $this->jumlahSiswa(),
    		'cash' => $this->totalkas(),
    		'transactions' => $this->totalTransaksi(),
    		);
    	return view('dashboard.view', $data);
    }

    public function jumlahSiswa() {
    	return count($this->students);
    }

    public function totalKas() {
    	$totalKas = 0;
    	foreach ($this->students as $student) {
    		$totalKas += $student->savings->getTotalSaldo($student->id);
    	}
    	return $totalKas;
    }

    public function totalTransaksi() {
    	$transactions = Transaction::all();
    	return count($transactions);
    }
}
