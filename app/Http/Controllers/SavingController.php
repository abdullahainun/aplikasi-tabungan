<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Saving;
use App\Student;
use DB;
use Excel; // Excel namespace

class SavingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create(Student $student) {
        $saving = new Saving();
        $saving->balance = 0;
        $saving->student_id = $student->id;
        $saving->save();
        return true;
    }

    public function getAllSaving() {
    	$savings = Saving::all();
    	$data = array(
            'savings' => $savings,
            'page' => 'saving',
        );
        return view('saving.viewAll', $data);
    }

    public function getSaving($id) {
        $saving = Saving::where('student_id', $id)->first();
        // echo "hello";
        echo $saving->student->name;
    }		
    public function export(Request $req){
        $savings = Saving::all();		
		$data = array(
			'savings' => $savings,
			'page' => 'rekap transaksi',
		);
		// if request has excel
		if($req->has('downloadexcel')){
			Excel::create('rekapAkhirTabungan', function($excel) use ($savings) {
				$excel->sheet('rekapTabungan', function($sheet) use ($savings){
					// Sets all borders

					// Font size
					$sheet->setFontSize(10);
					$sheet->setColumnFormat(array(
						"C:E" => "#,##0"
					 ));

					// Set all margins
					$sheet->setPageMargin(1);
					// Set height for a single row
					$sheet->setHeight(1, 15);
					$sheet->setHeight(2, 15);
					$sheet->setHeight(3, 15);
					// set title
					$sheet->cell('A1', function($cell){
						$cell->setValue('DAFTAR PENABUNG');
						// Set font size
						$cell->setFontSize(11);
					});

					$sheet->mergeCells('A1:G1');

					$sheet->cell('A2', function($cell){
						$cell->setValue('TKA. TPA. TQA AL-HUDA SAMBOGUNUNG DUKUN GRESIK');						
					});
					$sheet->mergeCells('A2:G2');

					$sheet->cell('A3', function($cell){
						$cell->setValue('TAHUN PELAJARAN 2017/2018');
					});
					$sheet->mergeCells('A3:G3');
					
					// SET COLUMN TITLE
					$sheet->cell('A5', function($cell){
						$cell->setValue('NO.REG');
						$cell->setBackground('#bce4e5');		
						$cell->setBorder('thin', 'thin', 'thin', 'thin');																
					});
					$sheet->cell('B5', function($cell){
						$cell->setValue('NAMA NASABAH');
						$cell->setBackground('#bce4e5');						
						$cell->setBorder('thin', 'thin', 'thin', 'thin');												
					});
					$sheet->cell('C5', function($cell){
						$cell->setValue('JML TABUNGAN');
						$cell->setBackground('#bce4e5');						
						$cell->setBorder('thin', 'thin', 'thin', 'thin');												
					});
					$sheet->cell('D5', function($cell){
						$cell->setValue('POTONGAN');
						$cell->setBackground('#bce4e5');						
						$cell->setBorder('thin', 'thin', 'thin', 'thin');												
					});
					$sheet->cell('E5', function($cell){
						$cell->setValue('JML. AKHIR');
						$cell->setBackground('#bce4e5');						
						$cell->setBorder('thin', 'thin', 'thin', 'thin');												
					});
					$sheet->mergeCells('F5:G5');
					$sheet->cell('F5', function($cell){
						$cell->setValue('TANDA TANGAN');
						$cell->setAlignment('center');	
						$cell->setBackground('#bce4e5');													
						$cell->setBorder('thin', 'thin', 'thin', 'thin');												
					});
					$no = 6;
					foreach ($savings as $saving) {						 
						// no id siswa
						$sheet->cell('A'.$no, function($cell) use ($saving){							
							$cell->setValue($saving->student->id);		
							$cell->setAlignment('center');
							$cell->setBorder('thin', 'thin', 'thin', 'thin');
						});

						// nama siswa
						$sheet->cell('B'.$no, function($cell) use ($saving){							
							$cell->setValue($saving->student->name);	
							$cell->setAlignment('left');
							$cell->setBorder('thin', 'thin', 'thin', 'thin');
						});

						// saldo masuk
						$sheet->cell('C'.$no, function($cell) use ($saving){							
							$cell->setValue($saving->getTotalMasuk($saving->student->id));		
							$cell->setAlignment('right');				
							$cell->setBorder('thin', 'thin', 'thin', 'thin');									
						});

						// saldo keluar
						$sheet->cell('D'.$no, function($cell) use ($saving){							
							$cell->setValue($saving->getTotalKeluar($saving->student->id));		
							$cell->setAlignment('right');						
							$cell->setBorder('thin', 'thin', 'thin', 'thin');							
						});

						// total saldo
						$sheet->cell('E'.$no, function($cell) use ($saving){							
							$cell->setValue($saving->getTotalSaldo($saving->student->id));		
							$cell->setAlignment('right');					
							$cell->setBorder('thin', 'thin', 'thin', 'thin');
						});
						
						// tanda tangan
						if($no%2==0) { 
							$nextno = $no + 1;
							$sheet->mergeCells('F'.$no.':F'.$nextno.'');							
							$sheet->cell('F'.$no, function($cell) use ($saving){
								$cell->setValue($saving->student->id);								
								$cell->setAlignment('left');		
								$cell->setValignment('top');
								$cell->setBorder('thin', 'thin', 'thin', 'thin');							
							});
						} else {		
							$beforeno = $no - 1;
							$sheet->mergeCells('G'.$beforeno.':G'.$no.'');
							$sheet->cell('G'.$beforeno, function($cell) use ($saving){
								$cell->setValue($saving->student->id);								
								$cell->setAlignment('left');
								$cell->setValignment('bottom');	
								$cell->setBorder('thin', 'thin', 'thin', 'thin');								
							});
						}
						$no++;
					}
					$sheet->cell('A'.$no, function($cell){
						$cell->setValue('TOTAL');
						$cell->setBorder('thin', 'thin', 'thin', 'thin');																
					});	
					$sheet->mergeCells('A'.$no.':B'.$no);
					// total saldo masuk
					$sheet->cell('C'.$no, function($cell) use ($no){
						$no = $no - 1;											
						$cell->setValue('=SUM(C1:C'.$no.')');
						$cell->setBorder('thin', 'thin', 'thin', 'thin');						
					});
					// total saldo keluar
					$sheet->cell('D'.$no, function($cell) use ($no){
						$no = $no - 1;											
						$cell->setValue('=SUM(D1:D'.$no.')');
						$cell->setBorder('thin', 'thin', 'thin', 'thin');						
					});

					// total saldo
					$sheet->cell('E'.$no, function($cell) use ($no){
						$no = $no - 1;											
						$cell->setValue('=SUM(E1:E'.$no.')');
						$cell->setBorder('thin', 'thin', 'thin', 'thin');						
					});

					// Set auto size for sheet
					$sheet->setAutoSize(true);
				});		
				// Amplop Tab
				$excel->sheet('AmplopTab', function($sheet) {			
					// Set font with ->setStyle()`
					$sheet->setStyle(array(
						'font' => array(
							'name'      =>  'Calibri',
							'size'      =>  18,
							'bold'      =>  true
						)
					));

					// set title
					$sheet->cell('B6', function($cell){
						$cell->setValue('TABUNGAN SANTRI AL-HUDA TAHUN 2017/2018');
					});
					$sheet->mergeCells('B6:D6');
					
					$sheet->cell('B8', function($cell){
						$cell->setValue('NO.  TABUNGAN');
					});

					$sheet->cell('B9', function($cell){
						$cell->setValue('NAMA PENABUNG');
					});

					$sheet->cell('B10', function($cell){
						$cell->setValue('JUMLAH TABUNGAN');
					});

					$sheet->cell('B11', function($cell){
						$cell->setValue('SUDAH DIAMBIL');
					});
					$sheet->cell('B14', function($cell){
						$cell->setValue('TOTAL');
					});

					for ($i=8; $i <15 ; $i++) { 
						$sheet->cell('c'.$i, function($cell){
							$cell->setValue(':');
						});
					}
					$sheet->cell('E6', function($cell){
						$cell->setValue('1');
					});		
					$sheet->cell('D8', function($cell){
						$cell->setValue('VLOOKUP(E6,$rekapTabungan.A6:E1000, 1)');
					});								
					$sheet->cell('D9', function($cell){
						$cell->setValue('VLOOKUP(E6,$rekapTabungan.A6:E1000, 2)');
					});								
					$sheet->cell('D10', function($cell){
						$cell->setValue('VLOOKUP(E6,$rekapTabungan.A6:E1000, 3)');
					});								
					$sheet->cell('D11', function($cell){
						$cell->setValue('VLOOKUP(E6,$rekapTabungan.A6:E1000, 4)');
					});								
					$sheet->cell('D14', function($cell){
						$cell->setValue('VLOOKUP(E6,$rekapTabungan.A6:E1000, 5)');
					});								

					$sheet->cell('B17', function($cell){
						$cell->setValue('Terima Kasih Atas Kepercayaannya Pada Kami');
					});					
					$sheet->mergeCells('B17:D17');					
					$sheet->cell('B18', function($cell){
						$cell->setValue('Semoga Barokah Mohon Maaf Lahir dan Batin AAMIIN....');
					});					
					$sheet->mergeCells('B18:D18');
					$sheet->setAutoSize(true);

				});	
			})->export('xls');
			
		}
    }
}
