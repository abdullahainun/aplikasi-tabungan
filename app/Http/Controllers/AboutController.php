<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AboutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $data = array(
    		'page' => 'about',
    	);
        return view('about.view', $data);
    }
    public function about()
    {
        return view('about.about');
    }
}
