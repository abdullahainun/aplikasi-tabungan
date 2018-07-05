<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Session;
use File;
use App\Http\Requests;
use App\Student;
use App\Http\Controllers\SavingController;
use PDF;
use Excel;
class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
	public function create(Request $request) {
		$duplicate = Student::where('id', $request->input('id'))->first();
		if ($duplicate) {
			$message = "Siswa dengan nomor induk <b>" . $duplicate->id . "</b> sudah ada.";
			return redirect('student')->with('warning', $message);
		} else {
			$student = new Student();
			$student->id = $request->input('id');
			$student->name = $request->input('name');
			$student->address = $request->input('address');
			$student->save();
            (new SavingController)->create($student);
			$message = "Siswa berhasil ditambahkan.";
			return redirect('student')->with('success', $message);
		}
	}

    public function getAll() {
    	$students = Student::all();
        $data = array(
            'students' => $students,
            'page' => 'student',
            );
    	return view('student.viewAll', $data);
    }

    public function getStudent($id) {
    	$student = Student::where('id', $id)->first();
        if ($student) {
            $students = Student::all();
            $data = array(
                'student' => $student,
                'students' => $students,
                'page' => 'student',
                );
            return view('student.view', $data);
        } else {
            $message = "Siswa dengan id <b>" . $id . "</b> tidak ditemukan";
            return redirect('student')->with('warning', $message);
        }
    }

    public function updateStudent(Request $request, $id) {
    	$student = Student::where('id', $id)->first();
    	$student->name = $request->input('name');
		$student->address = $request->input('address');
		$student->save();
		$message = "Siswa berhasil diupdate";
		return redirect('student/' . $id)->with('success', $message);
    }

    public function deleteStudent(Request $request) {
    	$student = Student::where('id', $request->id)->first();
    	$student->delete();
    	$message = "Siswa berhasil dihapus";
    	return redirect('student')->with('success', $message);
    }
    public function deleteAllStudent(){
        $students = Student::all();
        foreach ($students as $student) {
            $student->delete();
        }
    	$message = "Semua Siswa berhasil dihapus";
    	return redirect('student')->with('success', $message);
    }

    public function getApi() {
        $students = Student::all();

        return response()->json(array('students' => $students));
    }

    public function getApiId($id) {
        $student = Student::where('id', $id)->first();
        $student->savings;
        $student->transactions;
        return response()->json(array('student' => $student));
    }

    // import file to database
    public function import(Request $request){		    
        //validate the xls file
        $this->validate($request, array(
            'file'      => 'required'
        ));
 
        if($request->hasFile('file')){
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
 
                $path = $request->file->getRealPath();
                $data = Excel::load($path, function($reader) {})->get();
                if(!empty($data) && $data->count()){
                    $insertData = false;
                    foreach ($data as $key => $value) {
                        $student = new Student();
                        $student->id = $value->id;
			            $student->name = $value->name;
			            $student->address = $value->address;
			            $student->save();
                        $insertData = (new SavingController)->create($student);                        
                    }
                    if ($insertData == true) {
                        $message = "Siswa berhasil ditambahkan.";
                        return redirect('student')->with('success', $message);
                    }else { 
                        $message = "Error inserting the data..";
                        return redirect('student')->with('warning', $message);
                    }
                    return back();
                }
            }else {
                Session::flash('error', 'File is a '.$extension.' file.!! Please upload a valid xls/csv file..!!');
                return back();
            }
        }
    }
}
