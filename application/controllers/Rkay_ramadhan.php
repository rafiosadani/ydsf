<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load library phpspreadsheet
require('./phpSpreadSheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class Rkay_ramadhan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mrkay_ramadhan');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
		$data['pintu'] = $this->mrkay_ramadhan->getPintu();
        $this->load->view('rkay_ramadhan', $data);
	}
	
	public function cetak(){
		if($this->input->post('pintu')=="-"){
			$data['rekap_pintu'] = $this->mrkay_ramadhan->getDataAll();
			$data['pintu']="SEMUA PINTU";
		}else{
			list($pintu,$nm_pintu) = explode('|', $_POST['pintu']);
			$data['rekap_pintu'] = $this->mrkay_ramadhan->getData($pintu);
			$data['pintu']= $nm_pintu;
		}
		$data['thn']= $this->mrkay_ramadhan->getThn();
		$data['cabang'] = $this->mrkay_ramadhan->cabang();

		if($this->input->post('format')=="html"){
			$this->load->view('rekap_rkay_ramadhan', $data);
		}else{
			$nbsp = "\xc2\xa0";
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $styleArray = array(
                    'borders' => array(
                        'allBorders' => array(
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => array('argb' => '000000'),
                        ),
                    ),
				);
				date_default_timezone_set('Asia/Jakarta');
				foreach ($data['thn'] as $tampil) {
					$thn_ini = substr($tampil->tgl_awal,0,4);
				}
				$sheet->setCellValue('A1','Rekap Perbandingan Perolehan Ramadhan Dengan RKAY '.$thn_ini)
                ->mergeCells('A1:L1')->getStyle('A1')->getAlignment()->setVertical('center')->setHorizontal('left')->setWrapText(true);
				$sheet->setCellValue('A2','Pintu : '.$data['pintu'])
                ->mergeCells('A2:L2')->getStyle('A2')->getAlignment()->setVertical('center')->setHorizontal('left')->setWrapText(true);
				$sheet->setCellValue('A3','Tanggal Cetak : '.date("Y-m-d h:i:s"))
                ->mergeCells('A3:L3')->getStyle('A3')->getAlignment()->setVertical('center')->setHorizontal('left')->setWrapText(true);
				
				$sheet->setCellValue('A5','Cabang')
                ->mergeCells('A5:B5')->getStyle('A5')->getAlignment()->setVertical('center')->setHorizontal('left')->setWrapText(true);
				$sheet->setCellValue('C5','RKAY RMD (a)')
                ->mergeCells('C5:D5')->getStyle('C5')->getAlignment()->setVertical('center')->setHorizontal('left')->setWrapText(true);
				$sheet->setCellValue('E5','Ramadhan '.($thn_ini-1).' (b)')
                ->mergeCells('E5:F5')->getStyle('E5')->getAlignment()->setVertical('center')->setHorizontal('left')->setWrapText(true);
				$sheet->setCellValue('G5','Ramadhan '.$thn_ini.' (c)')
                ->mergeCells('G5:H5')->getStyle('G5')->getAlignment()->setVertical('center')->setHorizontal('left')->setWrapText(true);
				$sheet->setCellValue('I5','% '.$thn_ini.' vs RKAY')
                ->mergeCells('I5:J5')->getStyle('I5')->getAlignment()->setVertical('center')->setHorizontal('left')->setWrapText(true);
				$sheet->setCellValue('K5','% '.$thn_ini.' vs '.($thn_ini-1))
                ->mergeCells('K5:L5')->getStyle('K5')->getAlignment()->setVertical('center')->setHorizontal('left')->setWrapText(true);
				
				$row= 6;
				foreach ($data['rekap_pintu'] as $tampil) {
				
					$sheet->setCellValue('A'.$row,$tampil->nm_cabang)
					->mergeCells('A'.$row.':B'.$row)->getStyle('A'.$row)->getAlignment()->setVertical('center')->setHorizontal('left')->setWrapText(true);
					$sheet->setCellValue('C'.$row,number_format($tampil->rkay_rmd,0,'.','.'))
					->mergeCells('C'.$row.':D'.$row)->getStyle('C'.$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
					$sheet->setCellValue('E'.$row,number_format($tampil->rmd_thn_llu,0,'.','.'))
					->mergeCells('E'.$row.':F'.$row)->getStyle('E'.$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
					$sheet->setCellValue('G'.$row,number_format($tampil->rmd_thn_ini,0,'.','.'))
					->mergeCells('G'.$row.':H'.$row)->getStyle('G'.$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
					if($tampil->rkay_rmd==0 || $tampil->rmd_thn_ini==0 ){
						$sheet->setCellValue('I'.$row,'0')
						->mergeCells('I'.$row.':J'.$row)->getStyle('I'.$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
					}else{
						$sheet->setCellValue('I'.$row,number_format(($tampil->rmd_thn_ini/$tampil->rkay_rmd*100),2,',',','))
						->mergeCells('I'.$row.':J'.$row)->getStyle('I'.$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
					}
					
					if($tampil->rmd_thn_llu==0 || $tampil->rmd_thn_ini==0 ){
						$sheet->setCellValue('K'.$row,'0')
						->mergeCells('K'.$row.':L'.$row)->getStyle('K'.$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
					}else{
						$sheet->setCellValue('K'.$row,number_format(($tampil->rmd_thn_ini/$tampil->rmd_thn_llu*100),2,',',','))
						->mergeCells('K'.$row.':L'.$row)->getStyle('K'.$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
					}
					$row++;	
				}
				$rows=count($data['rekap_pintu']);
				$row=$rows+6;
				
				$sheet->setCellValue('A'.$row,'Total')
				->mergeCells('A'.$row.':B'.$row)->getStyle('A'.$row)->getAlignment()->setVertical('center')->setHorizontal('left')->setWrapText(true);
				
				$tota = 0;
				foreach ($data['rekap_pintu'] as $tampil) {
				$tota = $tampil->rkay_rmd + $tota;	
				}
				$sheet->setCellValue('C'.$row,number_format($tota,0,'.','.'))
				->mergeCells('C'.$row.':D'.$row)->getStyle('C'.$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
					
				$totb = 0;
				foreach ($data['rekap_pintu'] as $tampil) {
				$totb = $tampil->rmd_thn_llu + $totb;	
				}
				$sheet->setCellValue('E'.$row,number_format($totb,0,'.','.'))
				->mergeCells('E'.$row.':F'.$row)->getStyle('E'.$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
				
				$totc = 0;
				foreach ($data['rekap_pintu'] as $tampil) {
				$totc = $tampil->rmd_thn_ini + $totc;	
				}
				$sheet->setCellValue('G'.$row,number_format($totc,0,'.','.'))
				->mergeCells('G'.$row.':H'.$row)->getStyle('G'.$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
				
				if($tota==0 || $totc==0 ){
					$sheet->setCellValue('I'.$row,'0')
					->mergeCells('I'.$row.':J'.$row)->getStyle('I'.$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
					
				}else{
					$sheet->setCellValue('I'.$row,number_format(($totc/$tota*100),2,',',','))
					->mergeCells('I'.$row.':J'.$row)->getStyle('I'.$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
					
				}

				if($totb==0 || $totc==0 ){
					$sheet->setCellValue('K'.$row,'0')
					->mergeCells('K'.$row.':L'.$row)->getStyle('K'.$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
					
				}else{
					$sheet->setCellValue('K'.$row,number_format(($totc/$totb*100),2,',',','))
					->mergeCells('K'.$row.':L'.$row)->getStyle('K'.$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
					
				}	

			
				
				$sheet->getStyle('A5:L'.$row)->applyFromArray($styleArray);

                $writer = new Xlsx($spreadsheet);
                $filename = 'rekap_perolehan_rkay_ramadhan';
                
                // download file
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');	
		}
	}
}
?>
