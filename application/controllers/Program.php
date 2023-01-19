<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load library phpspreadsheet
require('./phpSpreadSheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class Program extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mprogram');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
        if ($this->session->userdata('admin') == TRUE) {
            if ($this->session->userdata('superadmin') == TRUE) {
                $data['cabang'] = $this->mprogram->getCabang();
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
                $data['cabang'] = $this->mprogram->getCabangCab();
            } else if ($this->session->userdata('admin_grup') == TRUE) {
                $data['cabang'] = $this->mprogram->getCabangGrup();
            }
            $this->load->view('per_program', $data);
        } else {
            $data['cabang'] = $this->mprogram->getCabangUser();
            $this->load->view('per_program', $data);
        }
    }

    public function perProgram() {
        $post = $this->input->post();
        $tglhimp = explode(' - ', $post['tglhimp']);
        $tglval = explode(' - ', $post['tglval']);
        if ($post['tglhimp'] == '' && $post['tglval'] == '') {
            $data['date'] = array (
                'date_himp1' => '',
                'date_himp2' => '',
                'date_val1' => '',
                'date_val2' => ''
            );
        } else if ($post['tglhimp'] == '') {
            $data['date'] = array (
                'date_himp1' => '',
                'date_himp2' => '',
                'date_val1' => $tglval[0],
                'date_val2' => $tglval[1]
            );
        } else if ($post['tglval'] == '') {
            $data['date'] = array (
                'date_himp1' => $tglhimp[0],
                'date_himp2' => $tglhimp[1],
                'date_val1' => '',
                'date_val2' => ''
            );
        } else {
            $data['date'] = array (
                'date_himp1' => $tglhimp[0],
                'date_himp2' => $tglhimp[1],
                'date_val1' => $tglval[0],
                'date_val2' => $tglval[1]
            );
        }
        
        if ($this->input->post('btncetak')) {
            if ($post['cabang'] == '-') {
                if($this->session->userdata('admin_grup')==TRUE){
                    $cabang = $this->mprogram->getCabangGrup();
                }else{
                $cabang = $this->mprogram->getCabang();
                }
                $y = count($cabang);
                $select = "";
                for ($x = 0;$x < $y; $x++) {
                    $select .= "SUM(case when name not like 'KANTOR%' and idcabang = ".$cabang[$x]->id_cab." then keu_j.jml else 0 end) as ".$cabang[$x]->cabang."_jungut,
                    SUM(case when name like 'KANTOR%' and idcabang = ".$cabang[$x]->id_cab." then keu_j.jml else 0 end) as ".$cabang[$x]->cabang."_kantor,";
                }
                $query = "keu_j.prog as prog, NM_PROGRAM as program,".$select." SUM(keu_j.jml) as total";
                if($this->session->userdata('admin_grup')==TRUE){
                $data['perProgram'] = $this->mprogram->perProgramGrupAll($query);
                }else{
                $data['perProgram'] = $this->mprogram->perProgramAll($query);
                }
                $this->load->view('rekap_perprogram', $data);
            } else {
                $data['perProgram'] = $this->mprogram->perProgramCab($post['cabang']);
                // print_r($data['perProgram']);
                $this->load->view('rekap_perprogram', $data);
            }
        } else {
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
            
            $ra = array();
            for ($r = "A", $e = "Z";$r <= $e ;$r++) {
                $ra[] = [$r];
            }

            if($this->session->userdata('admin_grup')==TRUE){
                for ($e = 0,$q = 3;$e<count($this->mprogram->getCabangGrup())*2;$q++,$e++);
            }else{
                for ($e = 0,$q = 3;$e<count($this->mprogram->getCabang())*2;$q++,$e++);
            }
            
            if ($post['cabang'] == '-') {
                $sheet->setCellValue('E1', 'REKAP PEROLEHAN TOTAL PER JUNGUT')
                    ->mergeCells('E1:'.$ra[$q][0].'1')->getStyle('E1')
                    ->getAlignment()->setHorizontal('center');
            } else {
                $sheet->setCellValue('A1', 'REKAP PEROLEHAN TOTAL PER JUNGUT')
                    ->mergeCells('A1:M1')->getStyle('A1')
                    ->getAlignment()->setHorizontal('center');
            }

            if (($post['tglhimp'] != "" && $post['tglval'] != "") || ($post['tglhimp'] == "" && $post['tglval'] != "")) {
                if ($post['cabang'] == '-') {
                    $sheet->setCellValue('E2', "PERIODE : TANGGAL KEUANGAN ".$data['date']['date_val1']." s/d ".$data['date']['date_val2'])
                        ->mergeCells('E2:'.$ra[$q][0].'2')->getStyle('E2')
                        ->getAlignment()->setHorizontal('center');
                } else {
                    $sheet->setCellValue('A2', "PERIODE : TANGGAL KEUANGAN ".$data['date']['date_val1']." s/d ".$data['date']['date_val2'])
                        ->mergeCells('A2:M2')->getStyle('A2')
                        ->getAlignment()->setHorizontal('center');
                }
            } else if ($post['tglhimp'] != "" && $post['tglval'] == "") {
                if ($post['cabang'] == '-') {
                    $sheet->setCellValue('E2', "PERIODE : TANGGAL PENGHIMPUNAN ".$data['date']['date_himp1']." s/d ".$data['date']['date_himp2'])
                        ->mergeCells('E2:'.$ra[$q][0].'2')->getStyle('E2')
                        ->getAlignment()->setHorizontal('center');
                } else {
                    $sheet->setCellValue('A2', "PERIODE : TANGGAL PENGHIMPUNAN ".$data['date']['date_himp1']." s/d ".$data['date']['date_himp2'])
                        ->mergeCells('A2:M2')->getStyle('A2')
                        ->getAlignment()->setHorizontal('center');
                }
            }

            $sheet->setCellValue('A4', 'Program')
                    ->mergeCells('A4:D5')->getStyle('A4')
                    ->getAlignment()->setVertical('center')
                    ->setHorizontal('center');
            $end = $ra[$q][0];
            $tot = $ra[$q+=1][0];
            $tot2 = $ra[$q+=1][0];
            if ($post['cabang'] == '-') {
                $sheet->setCellValue($tot.'4', 'Total')
                    ->mergeCells($tot.'4:'.$tot2.'5')->getStyle($tot.'4')
                    ->getAlignment()->setVertical('center')
                    ->setHorizontal('center');
            } else {
                $sheet->setCellValue('K4', 'Total')
                    ->mergeCells('K4:M5')->getStyle('K4')
                    ->getAlignment()->setVertical('center')
                    ->setHorizontal('center');
            }

            if ($post['cabang'] == '-') {
                if($this->session->userdata('admin_grup')==TRUE){
                    $cabang = $this->mprogram->getCabangGrup();
                }else{
                    $cabang = $this->mprogram->getCabang();
                }
                $y = count($cabang);
                $select = "";
                for ($x = 0;$x < $y; $x++) {
                    $select .= "SUM(case when name not like 'KANTOR%' and idcabang = ".$cabang[$x]->id_cab." then keu_j.jml else 0 end) as ".$cabang[$x]->cabang."_jungut,
                    SUM(case when name like 'KANTOR%' and idcabang = ".$cabang[$x]->id_cab." then keu_j.jml else 0 end) as ".$cabang[$x]->cabang."_kantor,";
                }
                $query = "keu_j.prog as prog, NM_PROGRAM as program,".$select." SUM(keu_j.jml) as total";
                if($this->session->userdata('admin_grup')==TRUE){
                    $data['perProgram'] = $this->mprogram->perProgramGrupAll($query);
                }else{
                    $data['perProgram'] = $this->mprogram->perProgramAll($query);
                }
                for ($c = 4,$f = 0;$f < $y;$c++,$f++) {
                    $sheet->setCellValue($ra[$c][0].'4',$cabang[$f]->nm_cabang)
                            ->mergeCells($ra[$c][0].'4:'.$ra[$c+=1][0].'4')->getStyle($ra[$c][0].'4')
                            ->getAlignment()->setVertical('center')
                            ->setHorizontal('center');
                }
                for ($cc = 4,$ff = 0;$ff < $y;$ff++) {
                    $sheet->setCellValue($ra[$cc][0].'5', 'JUNGUT')
                            ->getStyle($ra[$cc][0].'5')
                            ->getAlignment()->setVertical('center')
                            ->setHorizontal('center');
                    $sheet->setCellValue($ra[$cc+=1][0].'5','KANTOR')
                            ->getStyle($ra[$cc+=1][0].'5')
                            ->getAlignment()->setVertical('center')
                            ->setHorizontal('center');
                }
                
                $row = 6;
                $sumt = 0;
                $test = array();
                foreach ($data['perProgram'] as $program) {
                    $sumt += $program->total;
                    $sheet->setCellValue('A'.$row, $program->program )
                        ->mergeCells('A'.$row.':D'.$row)->getStyle('A'.$row);
                    
                    for ($te = 4,$m = 0;$m < $y;$m++) {
                        $jgt = $cabang[$m]->cabang."_jungut";
                        $ktr = $cabang[$m]->cabang."_kantor";
                        // $test[] = [$program->$jgt,$program->$ktr];
                        $sheet->setCellValue($ra[$te][0].$row, number_format($program->$jgt,0,'.',','))
                                ->getStyle($ra[$te][0].$row)->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->setCellValue($ra[$te+=1][0].$row, number_format($program->$ktr,0,'.',','))
                                ->getStyle($ra[$te+=1][0].$row)->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    }
                    $sheet->setCellValue($tot.$row, number_format($program->total,0,'.',','))
                        ->mergeCells($tot.$row.':'.$tot2.$row)->getStyle($tot.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $row++;
                }

                $sum = array();
                $sumj = $sumk = 0;
                
                for ($o = 0;$o < $y;$o++) $test[] = [$cabang[$o]->cabang."_jungut", $cabang[$o]->cabang."_kantor"];

                for ($p = 0;$p < $y;$p++) {
                    $jungut = $test[$p][0];
                    $kantor = $test[$p][1];
                    for ($dd = 0;$dd < count($data['perProgram']);$dd++) {
                        $sumj += $data['perProgram'][$dd]->$jungut;
                        $sumk += $data['perProgram'][$dd]->$kantor;
                    }
                    $sum[] = [$sumj, $sumk];
                    $sumj = $sumk = 0;
                }

                for ($sumcol = 4,$sumarr = 0;$sumarr < $y;$sumarr++) {
                    $sheet->setCellValue($ra[$sumcol][0].$row, number_format($sum[$sumarr][0],0,'.',','))
                            ->getStyle($ra[$sumcol][0].$row)
                            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue($ra[$sumcol+=1][0].$row, number_format($sum[$sumarr][1],0,'.',','))
                            ->getStyle($ra[$sumcol+=1][0].$row)
                            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                }
                
                // echo "<pre>";
                // print_r($sum);
                // echo "</pre>";return;

                $sheet->setCellValue('A'.$row, 'JUMLAH' )
                        ->mergeCells('A'.$row.':D'.$row)->getStyle('A'.$row)
                        ->getAlignment()->setVertical('center')
                        ->setHorizontal('center');
                $sheet->setCellValue($tot.$row, number_format($sumt,0,'.',','))
                        ->mergeCells($tot.$row.':'.$tot2.$row)->getStyle($tot.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('A4:'.$tot2.$row)->applyFromArray($styleArray);
            } else {
                $cab = "";
                $cabang = $this->mprogram->getCabang();
                $y = count($cabang);
                $data['perProgram'] = $this->mprogram->perProgramCab($post['cabang']);
                for ($cbg = 0; $cbg < $y;$cbg++) {
                    if ($cabang[$cbg]->id_cab == $this->input->post('cabang')) {
                        $cab = $cabang[$cbg]->nm_cabang;
                    }
                } 
                $sheet->setCellValue('E4', $cab)
                    ->mergeCells('E4:J4')->getStyle('E4')
                    ->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('E5', 'JUNGUT')
                    ->mergeCells('E5:G5')->getStyle('E5')
                    ->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('H5', 'KANTOR')
                    ->mergeCells('H5:J5')->getStyle('H5')
                    ->getAlignment()->setHorizontal('center');
                
                $sumj = $sumk = $sumt = 0;
                $row = 6;
                foreach ($data['perProgram'] as $program) {
                    $sumj += $program->jungut;
                    $sumk += $program->kantor;
                    $sumt += $program->total;
                    $sheet->setCellValue('A'.$row, $program->program)
                        ->mergeCells('A'.$row.':D'.$row)->getStyle('A'.$row);
                    $sheet->setCellValue('E'.$row, number_format($program->jungut,0,'.',','))
                        ->mergeCells('E'.$row.':G'.$row)->getStyle('E'.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('H'.$row, number_format($program->kantor,0,'.',','))
                        ->mergeCells('H'.$row.':J'.$row)->getStyle('H'.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('K'.$row, number_format($program->total,0,'.',','))
                        ->mergeCells('K'.$row.':M'.$row)->getStyle('K'.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $row++;
                }

                $sheet->setCellValue('A'.$row, 'JUMLAH' )
                    ->mergeCells('A'.$row.':D'.$row)->getStyle('A'.$row)
                    ->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('E'.$row, number_format($sumj,0,'.',','))
                    ->mergeCells('E'.$row.':G'.$row)->getStyle('E'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('H'.$row, number_format($sumk,0,'.',','))
                    ->mergeCells('H'.$row.':J'.$row)->getStyle('H'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('K'.$row, number_format($sumt,0,'.',','))
                    ->mergeCells('K'.$row.':M'.$row)->getStyle('K'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                
                $sheet->getStyle('A4:M'.$row)->applyFromArray($styleArray);
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'rekap_perprogram';
            
            // download file
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        }
    }

}

/* End of file Program.php */
