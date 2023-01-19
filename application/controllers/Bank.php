<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// Load library phpspreadsheet
require('./phpSpreadSheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class Bank extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mprogram');
        $this->load->model('mbank');
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
            $this->load->view('per_bank', $data);
        } else {
            $data['cabang'] = $this->mprogram->getCabangUser();
            $this->load->view('per_bank', $data);
        }
    }

    public function perBank() {
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
            if ($post['cabang'] == "-") {
                $data['bank'] = $this->mbank->getBank();
                $this->load->view('rekap_perbank', $data);
            } else {
                $data['bank'] = $this->mbank->getBank();
                $this->load->view('rekap_perbank', $data);
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

            $style2 = array(
                'font' => array(
                    'bold' => TRUE
                ),
                'fill' => array(
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => array(
                        'rgb' => '4acc39',
                    )
                ),
            );

            $style3 = array(
                'font' => array(
                    'bold' => TRUE
                ),
                'fill' => array(
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => array(
                        'rgb' => 'f75127',
                    )
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
                $sheet->setCellValue('E1', 'REKAP LAPORAN PER BANK')
                    ->mergeCells('E1:'.$ra[$q][0].'1')->getStyle('E1')
                    ->getAlignment()->setHorizontal('center');
            } else {
                $sheet->setCellValue('A1', 'REKAP LAPORAN PER BANK')
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

            $sheet->setCellValue('A4', 'BANK')
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

            if ($this->input->post('cabang') == '-') {
                if($this->sesion->userdata('admin_grup')==TRUE){
                    $cabang = $this->mprogram->getCabangGrup();
                }else{
                    
                    $cabang = $this->mprogram->getCabang();
                }
                $y = count($cabang);
                $data['bank'] = $this->mbank->getBank();
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
                $jml = array();
                $jml2 = array();
                foreach ($data['bank'] as $bank) {
                    $sheet->setCellValue('A'.$row, $bank->NM_BANK )
                        ->mergeCells('A'.$row.":".$tot2.$row)->getStyle('A'.$row)->getFont()->setBold(TRUE);
                    $row++;
                    $sumt = 0;
                    foreach ($this->mbank->perBankAll($bank->BANK) as $program) {
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
                    $sheet->setCellValue('A'.$row, "JUMLAH ".$bank->NM_BANK )
                        ->mergeCells('A'.$row.':D'.$row)->getStyle('A'.$row);
                    
                    $sumj = $sumk = 0;
                    $j = array();
                    
                    for ($a = 0; $a < $y; $a++) {
                        $j[] = [$cabang[$a]->cabang.'_jungut',
                        $cabang[$a]->cabang.'_kantor'];
                    }

                    $sum = array();
                    $prog = $this->mbank->perBankAll($bank->BANK);
                    
                    for ($a = 0;$a < $y; $a++) {
                        $jungut = $j[$a][0];
                        $kantor = $j[$a][1];
                        
                        for ($v = 0;$v < count($prog);$v++) {
                            $sumj += $prog[$v]->$jungut;
                            $sumk += $prog[$v]->$kantor;
                        }
                        $sum[] = [$sumj,$sumk];
                        $sumj = 0;
                        $sumk = 0;
                    }

                    $jmltest = array();
                    for ($sumcol = 4,$sumarr = 0;$sumarr < $y;$sumarr++) {
                        $jmltest[] = [$sum[$sumarr][0],$sum[$sumarr][1]];
                        $sheet->setCellValue($ra[$sumcol][0].$row, number_format($sum[$sumarr][0],0,'.',','))
                            ->getStyle($ra[$sumcol][0].$row)
                            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->setCellValue($ra[$sumcol+=1][0].$row, number_format($sum[$sumarr][1],0,'.',','))
                            ->getStyle($ra[$sumcol+=1][0].$row)
                            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    }
                    $jml[] = [$jmltest];
                    $jml2[] = [$sumt];
                    $sheet->setCellValue($tot.$row, number_format($sumt,0,'.',','))
                        ->mergeCells($tot.$row.':'.$tot2.$row)->getStyle($tot.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle("A".$row.":".$tot.$row)->applyFromArray($style2);
                    $row++;
                }

                $finaltotal = array();
                $ttl = $ttl2 = $ttl3 = 0;
                for ($cc = 0;$cc<$y;$cc++) {
                    for ($bb = 0;$bb<count($jml);$bb++) {
                        $ttl += $jml[$bb][0][$cc][0];
                        $ttl2 += $jml[$bb][0][$cc][1];
                    }
                    $finaltotal[] = [$ttl,$ttl2];
                    $ttl = 0;
                    $ttl2 = 0;
                }

                for ($kk = 0;$kk<count($jml2);$kk++) {
                    $ttl3 += $jml2[$kk][0];
                }

                $sheet->setCellValue('A'.$row, "JUMLAH")
                    ->mergeCells('A'.$row.':D'.$row)->getStyle('A'.$row);
                
                for ($fcol = 4, $farr = 0;$farr < $y;$farr++) {
                    $sheet->setCellValue($ra[$fcol][0].$row, number_format($finaltotal[$farr][0],0,'.',','))
                        ->getStyle($ra[$fcol][0].$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue($ra[$fcol+=1][0].$row, number_format($finaltotal[$farr][1],0,'.',','))
                        ->getStyle($ra[$fcol+=1][0].$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                }

                $sheet->setCellValue($tot.$row, number_format($ttl3,0,'.',','))
                    ->mergeCells($tot.$row.":".$tot2.$row)->getStyle($tot.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                $sheet->getStyle('A'.$row.':'.$tot.$row)->applyFromArray($style3);
                $sheet->getStyle('A4:'.$tot2.$row)->applyFromArray($styleArray);

            } else {
                $cab = "";
                if($this->session->userdata('admin_grup')==TRUE){
                    $cabang = $this->mprogram->getCabangGrup();
                }else{

                    $cabang = $this->mprogram->getCabang();
                }
                $y = count($cabang);
                $data['bank'] = $this->mbank->getBank();
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

                $row = 6;
                $jml = array();
                foreach ($data['bank'] as $bank) {
                    $sheet->setCellValue('A'.$row, $bank->NM_BANK )
                        ->mergeCells('A'.$row.':M'.$row)->getStyle('A'.$row)->getFont()->setBold(TRUE);
                    $row++;
                    $sum1 = $sum2 = $sum3 = 0;
                    foreach ($this->mbank->perBankCab($bank->BANK,$this->input->post('cabang')) as $program ) {
                        $sum1 += $program->jungut;
                        $sum2 += $program->kantor;
                        $sum3 += $program->total;
                        
                        $sheet->setCellValue('A'.$row, $program->program )
                            ->mergeCells('A'.$row.':D'.$row)->getStyle('A'.$row);
                        $sheet->setCellValue('E'.$row, number_format($program->jungut,0,'.',','))
                            ->mergeCells('E'.$row.':G'.$row)
                            ->getStyle('E'.$row)->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->setCellValue('H'.$row, number_format($program->kantor,0,'.',','))
                            ->mergeCells('H'.$row.':J'.$row)
                            ->getStyle('H'.$row)->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $sheet->setCellValue('K'.$row, number_format($program->kantor,0,'.',','))
                            ->mergeCells('K'.$row.':M'.$row)
                            ->getStyle('K'.$row)->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $row++;    
                    }
                    $jml[] = [$sum1,$sum2,$sum3];
                    $sheet->setCellValue('A'.$row, "JUMLAH ".$bank->NM_BANK )
                        ->mergeCells('A'.$row.':D'.$row)->getStyle('A'.$row);
                    $sheet->setCellValue('E'.$row, number_format($sum1,0,'.',','))
                        ->mergeCells('E'.$row.':G'.$row)
                        ->getStyle('E'.$row)->getAlignment()
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('H'.$row, number_format($sum2,0,'.',','))
                        ->mergeCells('H'.$row.':J'.$row)
                        ->getStyle('H'.$row)->getAlignment()
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('K'.$row, number_format($sum3,0,'.',','))
                        ->mergeCells('K'.$row.':M'.$row)
                        ->getStyle('K'.$row)->getAlignment()
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle("A".$row.":M".$row)->applyFromArray($style2);
                    $row++;
                }

                $ttl1 = $ttl2 = $ttl3 = 0;
                for ($kk = 0;$kk<count($jml);$kk++) {
                    $ttl1 += $jml[$kk][0];
                    $ttl2 += $jml[$kk][1];
                    $ttl3 += $jml[$kk][2];
                }

                $sheet->setCellValue('A'.$row, "JUMLAH")
                    ->mergeCells('A'.$row.':D'.$row)->getStyle('A'.$row);
                $sheet->setCellValue('E'.$row, number_format($ttl1,0,'.',','))
                    ->mergeCells('E'.$row.':G'.$row)
                    ->getStyle('E'.$row)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('H'.$row, number_format($ttl2,0,'.',','))
                    ->mergeCells('H'.$row.':J'.$row)
                    ->getStyle('H'.$row)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('K'.$row, number_format($ttl3,0,'.',','))
                    ->mergeCells('K'.$row.':M'.$row)
                    ->getStyle('K'.$row)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle("A".$row.":M".$row)->applyFromArray($style3);
                $sheet->getStyle("A4:M".$row)->applyFromArray($styleArray);
                
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'rekap_perbank';
            
            // download file
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        }

    }

}

/* End of file Bank.php */
