<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require('./phpSpreadSheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Centang extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mcentang');
        $this->load->model('mpage');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
        if ($this->session->userdata('admin') == TRUE) {
            if ($this->session->userdata('superadmin') == TRUE) {
                // $data['bank'] = $this->mslip_manual->getBank();
                // $data['jungut'] = $this->mslip_manual->getAll();
                // $data['program'] = $this->mslip_manual->getProgram();
                // $data['programs'] = $this->mslip_manual->getProgram();
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
                // $data['bank'] = $this->mslip_manual->getBank();
                // $data['jungut'] = $this->mslip_manual->getAllTwo($this->session->userdata('idcab'));
                // $data['program'] = $this->mslip_manual->getProgram();
                // $data['programs'] = $this->mslip_manual->getProgram();
            } else if ($this->session->userdata('admin_grup') == TRUE) {
                // $data['bank'] = $this->mslip_manual->getBank();
                // $data['jungut'] = $this->mslip_manual->getAllFour($this->session->userdata('idgrup'));
                // $data['program'] = $this->mslip_manual->getProgram();
                // $data['programs'] = $this->mslip_manual->getProgram();
            }
            $this->load->view('centang');
        } else {
            redirect(base_url());
        }
    }

    public function cetakCentang(){
        $date=$this->input->post('date');
        $tgl = explode('-', $this->input->post('date'));
        if($date == ""){
            $tgl[0]='00';
            $tgl[1]='0000';
        }
        $hari = cal_days_in_month(CAL_GREGORIAN,$tgl[0], $tgl[1]);
        if($tgl[0] == '01'){
            $bulan="JAN";
        }else if($tgl[0] == '02'){
            $bulan="FEB";
        }else if($tgl[0] == '03'){
            $bulan="MAR";
        }else if($tgl[0] == '04'){
            $bulan="APR";
        }else if($tgl[0] == '05'){
            $bulan="MEI";
        }else if($tgl[0] == '06'){
            $bulan="JUN";
        }else if($tgl[0] == '07'){
            $bulan="JUL";
        }else if($tgl[0] == '08'){
            $bulan="AGS";
        }else if($tgl[0] == '09'){
            $bulan="SEP";
        }else if($tgl[0] == '10'){
            $bulan="OKT";
        }else if($tgl[0] == '11'){
            $bulan="NOV";
        }else if($tgl[0] == '12'){
            $bulan="DES";
        }

        if ($this->input->post('btncetak')) {
            // $data['perBankJgtY'] = $this->Mrinci_slip->perBankJgtY($post['jungut']);
            // $data['perBankJgtT'] = $this->Mrinci_slip->perBankJgtT($post['jungut']);
            // $data['petugas'] = $this->Mrinci_slip->getPtgs();
            // print_r($data['perBankJgtY']);
            $data['centang'] = $this->mcentang->getCetakSlip($tgl[0],$tgl[1]);
            $this->load->view('rekap_centang', $data);
    } else {
        $data['centang'] = $this->mcentang->getCetakSlip($tgl[0],$tgl[1]);
        // $data['perBankJgtT'] = $this->Mrinci_slip->perBankJgtT($post['jungut']);
        // $data['petugas'] = $this->Mrinci_slip->getPtgs();

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

        for ($e = 0,$q = 3;$e<$hari*2;$q++,$e++);

        $sheet->setCellValue('E1','Rekap Centang Jungut')->mergeCells('E1:'.$ra[$q][0].'1')
        ->getStyle('E1')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
        ;
        $sheet->setCellValue('E2','PERIODE : '.$date.$nbsp.' TANGGAL CETAK : '.date('Y-m-d h:i:s'))->mergeCells('E2:'.$ra[$q][0].'2')
        ->getStyle('E2')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
        ;


        $sheet->setCellValue('A4','No')->mergeCells('A4:A5')
        ->getStyle('A4')->getAlignment()->setVertical('center')->setWrapText(true);
        ;
        $sheet->setCellValue('B4','Kodej')->mergeCells('B4:B5')
        ->getStyle('B4')->getAlignment()->setVertical('center')->setWrapText(true);
        ;
        $sheet->setCellValue('C4','Nama')->mergeCells('C4:C5')
        ->getStyle('C4')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->setCellValue('D4','Dep')->mergeCells('D4:D5')->getStyle('D4')->getAlignment()->setHorizontal('center')->setVertical('center')
        ;
            $end = $ra[$q][0];
            $tot = $ra[$q+=1][0];
            $tot2 = $ra[$q+1][0];
            $tot3 = $ra[$q+2][0];
            $sheet->setCellValue($tot.'4', 'Qty')->mergeCells($tot.'4:'.$tot.'5')
            ->getStyle($tot.'4')
            ->getAlignment()->setVertical('center')
            ->setHorizontal('center');
            $sheet->setCellValue($tot2.'4', 'Jumlah')
            ->mergeCells($tot2.'4:'.$tot3.'4')->getStyle($tot2.'4')
            ->getAlignment()->setVertical('center')
            ->setHorizontal('center');
            $sheet->setCellValue($tot2.'5', 'Dnt')
            ->getStyle($tot2.'5')
            ->getAlignment()->setVertical('center')
            ->setHorizontal('center');
            $sheet->setCellValue($tot3.'5', 'Dns')
            ->getStyle($tot3.'5')
            ->getAlignment()->setVertical('center')
            ->setHorizontal('center');

            for ($c = 4,$f = 1;$f <= $hari;$c++,$f++) {
                $sheet->setCellValue($ra[$c][0].'4',$f.' '.$bulan)
                    ->mergeCells($ra[$c][0].'4:'.$ra[$c+=1][0].'4')->getStyle($ra[$c][0].'4')
                    ->getAlignment()->setVertical('center')->setHorizontal('center');
            }
            for ($cc = 4,$ff = 0;$ff < $hari;$ff++) {
                $sheet->setCellValue($ra[$cc][0].'5', 'Dnt')
                    ->getStyle($ra[$cc][0].'5')
                    ->getAlignment()->setVertical('center')
                    ->setHorizontal('center');
                $sheet->setCellValue($ra[$cc+=1][0].'5','Dns')
                    ->getStyle($ra[$cc+=1][0].'5')
                    ->getAlignment()->setVertical('center')
                    ->setHorizontal('center');
            }
            $row=6;
            $rowes= count($data['centang'])+6;
                    $totaldnt1=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt1 += intval(str_replace(',','', $jumctg->dnt1));
                    }
                    $totaldns1=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns1 += intval(str_replace(',','', $jumctg->dns1));
                    }
                    $totaldnt2=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt2 += intval(str_replace(',','', $jumctg->dnt2));
                    }
                    $totaldns2=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns2 += intval(str_replace(',','', $jumctg->dns2));
                    }
                    $totaldnt3=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt3 += intval(str_replace(',','', $jumctg->dnt3));
                    }
                    $totaldns3=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns3 += intval(str_replace(',','', $jumctg->dns3));
                    }
                    $totaldnt4=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt4 += intval(str_replace(',','', $jumctg->dnt4));
                    }
                    $totaldns4=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns4 += intval(str_replace(',','', $jumctg->dns4));
                    }
                    $totaldnt5=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt5 += intval(str_replace(',','', $jumctg->dnt5));
                    }
                    $totaldns5=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns5 += intval(str_replace(',','', $jumctg->dns5));
                    }
                    $totaldnt6=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt6 += intval(str_replace(',','', $jumctg->dnt6));
                    }
                    $totaldns6=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns6 += intval(str_replace(',','', $jumctg->dns6));
                    }
                    $totaldnt7=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt7 += intval(str_replace(',','', $jumctg->dnt7));
                    }
                    $totaldns7=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns7 += intval(str_replace(',','', $jumctg->dns7));
                    }
                    $totaldnt8=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt8 += intval(str_replace(',','', $jumctg->dnt8));
                    }
                    $totaldns8=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns8 += intval(str_replace(',','', $jumctg->dns8));
                    }
                    $totaldnt9=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt9 += intval(str_replace(',','', $jumctg->dnt9));
                    }
                    $totaldns9=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns9 += intval(str_replace(',','', $jumctg->dns9));
                    }
                    $totaldnt10=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt10 += intval(str_replace(',','',$jumctg->dnt10));
                    }
                    $totaldns10=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns10 += intval(str_replace(',','',$jumctg->dns10));
                    }
                    $totaldnt11=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt11 += intval(str_replace(',','',$jumctg->dnt11));
                    }
                    $totaldns11=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns11 += intval(str_replace(',','',$jumctg->dns11));
                    }
                    $totaldnt12=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt12 += intval(str_replace(',','',$jumctg->dnt12));
                    }
                    $totaldns12=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns12 += intval(str_replace(',','',$jumctg->dns12));
                    }
                    $totaldnt13=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt13 += intval(str_replace(',','',$jumctg->dnt13));
                    }
                    $totaldns13=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns13 += intval(str_replace(',','',$jumctg->dns13));
                    }
                    $totaldnt14=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt14 += intval(str_replace(',','',$jumctg->dnt14));
                    }
                    $totaldns14=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns14 += intval(str_replace(',','',$jumctg->dns14));
                    }
                    $totaldnt15=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt15 += intval(str_replace(',','',$jumctg->dnt15));
                    }
                    $totaldns15=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns15 += intval(str_replace(',','',$jumctg->dns15));
                    }
                    $totaldnt16=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt16 += intval(str_replace(',','',$jumctg->dnt16));
                    }
                    $totaldns16=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns16 += intval(str_replace(',','',$jumctg->dns16));
                    }
                    $totaldnt17=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt17 += intval(str_replace(',','',$jumctg->dnt17));
                    }
                    $totaldns17=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns17 += intval(str_replace(',','',$jumctg->dns17));
                    }
                    $totaldnt18=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt18 += intval(str_replace(',','',$jumctg->dnt18));
                    }
                    $totaldns18=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns18 += intval(str_replace(',','',$jumctg->dns18));
                    }
                    $totaldnt19=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt19 += intval(str_replace(',','',$jumctg->dnt19));
                    }
                    $totaldns19=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns19 += intval(str_replace(',','',$jumctg->dns19));
                    }
                    $totaldnt20=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt20 += intval(str_replace(',','',$jumctg->dnt20));
                    }
                    $totaldns20=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns20 += intval(str_replace(',','',$jumctg->dns20));
                    }
                    $totaldnt21=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt21 += intval(str_replace(',','',$jumctg->dnt21));
                    }
                    $totaldns21=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns21 += intval(str_replace(',','',$jumctg->dns21));
                    }
                    $totaldnt22=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt22 += intval(str_replace(',','',$jumctg->dnt22));
                    }
                    $totaldns22=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns22 += intval(str_replace(',','',$jumctg->dns22));
                    }
                    $totaldnt23=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt23 += intval(str_replace(',','',$jumctg->dnt23));
                    }
                    $totaldns23=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns23 += intval(str_replace(',','',$jumctg->dns23));
                    }
                    $totaldnt24=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt24 += intval(str_replace(',','',$jumctg->dnt24));
                    }
                    $totaldns24=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns24 += intval(str_replace(',','',$jumctg->dns24));
                    }
                    $totaldnt25=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt25 += intval(str_replace(',','',$jumctg->dnt25));
                    }
                    $totaldns25=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns25 += intval(str_replace(',','',$jumctg->dns25));
                    }
                    $totaldnt26=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt26 += intval(str_replace(',','',$jumctg->dnt26));
                    }
                    $totaldns26=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns26 += intval(str_replace(',','',$jumctg->dns26));
                    }
                    $totaldnt27=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt27 += intval(str_replace(',','',$jumctg->dnt27));
                    }
                    $totaldns27=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns27 += intval(str_replace(',','',$jumctg->dns27));
                    }
                    $totaldnt28=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldnt28 += intval(str_replace(',','',$jumctg->dnt28));
                    }
                    $totaldns28=0;
                    foreach($data['centang'] as $jumctg){
                        $totaldns28 += intval(str_replace(',','',$jumctg->dns28));
                    }
                    $totaldnt29=0;
                    foreach($data['centang'] as $jumctg){
                        if(isset($jumctg->dnt29)){
                            
                            $totaldnt29 += intval(str_replace(',','',$jumctg->dnt29));
                        }

                    }
                    $totaldns29=0;
                    foreach($data['centang'] as $jumctg){
                        if(isset($jumctg->dns29)){
                            
                            $totaldns29 += intval(str_replace(',','',$jumctg->dns29));
                        }
                    }
                    $totaldnt30=0;
                    foreach($data['centang'] as $jumctg){
                        if(isset($jumctg->dnt30)){
                            
                            $totaldnt30 += intval(str_replace(',','',$jumctg->dnt30));
                        }
                    }
                    $totaldns30=0;
                    foreach($data['centang'] as $jumctg){
                        if(isset($jumctg->dns30)){
                            
                            $totaldns30 += intval(str_replace(',','',$jumctg->dns30));
                        }
                    }
                    $totaldnt31=0;
                    foreach($data['centang'] as $jumctg){
                        if(isset($jumctg->dnt31)){
                            
                            $totaldnt31 += intval(str_replace(',','',$jumctg->dnt31));
                        }
                    }
                    $totaldns31=0;
                    foreach($data['centang'] as $jumctg){
                        if(isset($jumctg->dns31)){
                            
                            $totaldns31 += intval(str_replace(',','',$jumctg->dns31));
                        }
                    }

                    $totalqty=0;
                    foreach($data['centang'] as $jumctg){
                        $totalqty += intval(str_replace(',','',$jumctg->qty));
                    }
                    $totaltotdnt=0;
                    foreach($data['centang'] as $jumctg){
                        $totaltotdnt += intval(str_replace(',','',$jumctg->tot_dnt));
                    }
                    $totaltotdns=0;
                    foreach($data['centang'] as $jumctg){
                        $totaltotdns += intval(str_replace(',','',$jumctg->jumlah));
                    }

            foreach($data['centang'] as $a=>$centang){
                $sheet->setCellValue('A'.$row,$a+1)
                ->getStyle('A'.$row)->getAlignment()->setVertical('center')->setWrapText(true);
                $sheet->setCellValue('B'.$row,$centang->kodej)
                ->getStyle('B'.$row)->getAlignment()->setVertical('center')->setWrapText(true);
                $sheet->setCellValue('C'.$row,$centang->nama)
                ->getStyle('C'.$row)->getAlignment()->setVertical('center')->setWrapText(true);
                $sheet->setCellValue('D'.$row,$centang->cabang)
                ->getStyle('D'.$row)->getAlignment()->setVertical('center')->setWrapText(true);

                
                if(!isset($centang->dnt29)){
                    $sheet->setCellValue($ra[4][0].$row,$centang->dnt1)
                    ->getStyle($ra[4][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[4][0].$rowes,$totaldnt1)
                    ->getStyle($ra[4][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[5][0].$row,$centang->dns1)
                    ->getStyle($ra[5][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[5][0].$rowes,number_format($totaldns1,0,',',','))
                    ->getStyle($ra[5][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[6][0].$row,$centang->dnt2)
                    ->getStyle($ra[6][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[6][0].$rowes,$totaldnt2)
                    ->getStyle($ra[6][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[7][0].$row,$centang->dns2)
                    ->getStyle($ra[7][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[7][0].$rowes,number_format($totaldns2,0,',',','))
                    ->getStyle($ra[7][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[8][0].$row,$centang->dnt3)
                    ->getStyle($ra[8][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[8][0].$rowes,$totaldnt3)
                    ->getStyle($ra[8][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[9][0].$row,$centang->dns3)
                    ->getStyle($ra[9][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[9][0].$rowes,number_format($totaldns3,0,',',','))
                    ->getStyle($ra[9][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[10][0].$row,$centang->dnt4)
                    ->getStyle($ra[10][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[10][0].$rowes,$totaldnt4)
                    ->getStyle($ra[10][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[11][0].$row,$centang->dns4)
                    ->getStyle($ra[11][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[11][0].$rowes,number_format($totaldns4,0,',',','))
                    ->getStyle($ra[11][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[12][0].$row,$centang->dnt5)
                    ->getStyle($ra[12][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[12][0].$rowes,$totaldnt5)
                    ->getStyle($ra[12][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[13][0].$row,$centang->dns5)
                    ->getStyle($ra[13][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[13][0].$rowes,number_format($totaldns5,0,',',','))
                    ->getStyle($ra[13][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[14][0].$row,$centang->dnt6)
                    ->getStyle($ra[14][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[14][0].$rowes,$totaldnt6)
                    ->getStyle($ra[14][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[15][0].$row,$centang->dns6)
                    ->getStyle($ra[15][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[15][0].$rowes,number_format($totaldns6,0,',',','))
                    ->getStyle($ra[15][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[16][0].$row,$centang->dnt7)
                    ->getStyle($ra[16][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[16][0].$rowes,$totaldnt7)
                    ->getStyle($ra[16][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[17][0].$row,$centang->dns7)
                    ->getStyle($ra[17][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[17][0].$rowes,number_format($totaldns7,0,',',','))
                    ->getStyle($ra[17][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[18][0].$row,$centang->dnt8)
                    ->getStyle($ra[18][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[18][0].$rowes,$totaldnt8)
                    ->getStyle($ra[18][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[19][0].$row,$centang->dns8)
                    ->getStyle($ra[19][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[19][0].$rowes,number_format($totaldns8,0,',',','))
                    ->getStyle($ra[19][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[20][0].$row,$centang->dnt9)
                    ->getStyle($ra[20][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[20][0].$rowes,$totaldnt9)
                    ->getStyle($ra[20][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[21][0].$row,$centang->dns9)
                    ->getStyle($ra[21][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[21][0].$rowes,number_format($totaldns9,0,',',','))
                    ->getStyle($ra[21][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[22][0].$row,$centang->dnt10)
                    ->getStyle($ra[22][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[22][0].$rowes,$totaldnt10)
                    ->getStyle($ra[22][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[23][0].$row,$centang->dns10)
                    ->getStyle($ra[23][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[23][0].$rowes,number_format($totaldns10,0,',',','))
                    ->getStyle($ra[23][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[24][0].$row,$centang->dnt11)
                    ->getStyle($ra[24][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[24][0].$rowes,$totaldnt11)
                    ->getStyle($ra[24][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[25][0].$row,$centang->dns11)
                    ->getStyle($ra[25][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[25][0].$rowes,number_format($totaldns11,0,',',','))
                    ->getStyle($ra[25][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[26][0].$row,$centang->dnt12)
                    ->getStyle($ra[26][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[26][0].$rowes,$totaldnt12)
                    ->getStyle($ra[26][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[27][0].$row,$centang->dns12)
                    ->getStyle($ra[27][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[27][0].$rowes,number_format($totaldns12,0,',',','))
                    ->getStyle($ra[27][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[28][0].$row,$centang->dnt13)
                    ->getStyle($ra[28][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[28][0].$rowes,$totaldnt13)
                    ->getStyle($ra[28][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[29][0].$row,$centang->dns13)
                    ->getStyle($ra[29][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[29][0].$rowes,number_format($totaldns13,0,',',','))
                    ->getStyle($ra[29][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[30][0].$row,$centang->dnt14)
                    ->getStyle($ra[30][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[30][0].$rowes,$totaldnt14)
                    ->getStyle($ra[30][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[31][0].$row,$centang->dns14)
                    ->getStyle($ra[31][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[31][0].$rowes,number_format($totaldns14,0,',',','))
                    ->getStyle($ra[31][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[32][0].$row,$centang->dnt15)
                    ->getStyle($ra[32][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[32][0].$rowes,$totaldnt15)
                    ->getStyle($ra[32][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[33][0].$row,$centang->dns15)
                    ->getStyle($ra[33][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[33][0].$rowes,number_format($totaldns15,0,',',','))
                    ->getStyle($ra[33][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[34][0].$row,$centang->dnt16)
                    ->getStyle($ra[34][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[34][0].$rowes,$totaldnt16)
                    ->getStyle($ra[34][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[35][0].$row,$centang->dns16)
                    ->getStyle($ra[35][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[35][0].$rowes,number_format($totaldns16,0,',',','))
                    ->getStyle($ra[35][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[36][0].$row,$centang->dnt17)
                    ->getStyle($ra[36][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[36][0].$rowes,$totaldnt17)
                    ->getStyle($ra[36][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[37][0].$row,$centang->dns17)
                    ->getStyle($ra[37][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[37][0].$rowes,number_format($totaldns17,0,',',','))
                    ->getStyle($ra[37][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[38][0].$row,$centang->dnt18)
                    ->getStyle($ra[38][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[38][0].$rowes,$totaldnt18)
                    ->getStyle($ra[38][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[39][0].$row,$centang->dns18)
                    ->getStyle($ra[39][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[39][0].$rowes,number_format($totaldns18,0,',',','))
                    ->getStyle($ra[39][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[40][0].$row,$centang->dnt19)
                    ->getStyle($ra[40][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[40][0].$rowes,$totaldnt19)
                    ->getStyle($ra[40][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[41][0].$row,$centang->dns19)
                    ->getStyle($ra[41][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[41][0].$rowes,number_format($totaldns19,0,',',','))
                    ->getStyle($ra[41][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[42][0].$row,$centang->dnt20)
                    ->getStyle($ra[42][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[42][0].$rowes,$totaldnt20)
                    ->getStyle($ra[42][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[43][0].$row,$centang->dns20)
                    ->getStyle($ra[43][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[43][0].$rowes,number_format($totaldns20,0,',',','))
                    ->getStyle($ra[43][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[44][0].$row,$centang->dnt21)
                    ->getStyle($ra[44][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[44][0].$rowes,$totaldnt21)
                    ->getStyle($ra[44][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[45][0].$row,$centang->dns21)
                    ->getStyle($ra[45][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[45][0].$rowes,number_format($totaldns21,0,',',','))
                    ->getStyle($ra[45][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[46][0].$row,$centang->dnt22)
                    ->getStyle($ra[46][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[46][0].$rowes,$totaldnt22)
                    ->getStyle($ra[46][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[47][0].$row,$centang->dns22)
                    ->getStyle($ra[47][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[47][0].$rowes,number_format($totaldns22,0,',',','))
                    ->getStyle($ra[47][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[48][0].$row,$centang->dnt23)
                    ->getStyle($ra[48][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[48][0].$rowes,$totaldnt23)
                    ->getStyle($ra[48][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[49][0].$row,$centang->dns23)
                    ->getStyle($ra[49][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[49][0].$rowes,number_format($totaldns23,0,',',','))
                    ->getStyle($ra[49][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[50][0].$row,$centang->dnt24)
                    ->getStyle($ra[50][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[50][0].$rowes,$totaldnt24)
                    ->getStyle($ra[50][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[51][0].$row,$centang->dns24)
                    ->getStyle($ra[51][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[51][0].$rowes,number_format($totaldns24,0,',',','))
                    ->getStyle($ra[51][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[52][0].$row,$centang->dnt25)
                    ->getStyle($ra[52][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[52][0].$rowes,$totaldnt25)
                    ->getStyle($ra[52][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[53][0].$row,$centang->dns25)
                    ->getStyle($ra[53][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[53][0].$rowes,number_format($totaldns25,0,',',','))
                    ->getStyle($ra[53][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[54][0].$row,$centang->dnt26)
                    ->getStyle($ra[54][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[54][0].$rowes,$totaldnt26)
                    ->getStyle($ra[54][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[55][0].$row,$centang->dns26)
                    ->getStyle($ra[55][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[55][0].$rowes,number_format($totaldns26,0,',',','))
                    ->getStyle($ra[55][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[56][0].$row,$centang->dnt27)
                    ->getStyle($ra[56][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[56][0].$rowes,$totaldnt27)
                    ->getStyle($ra[56][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[57][0].$row,$centang->dns27)
                    ->getStyle($ra[57][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);                
                    
                    $sheet->setCellValue($ra[57][0].$rowes,number_format($totaldns27,0,',',','))
                    ->getStyle($ra[57][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);                
                    
                    $sheet->setCellValue($ra[58][0].$row,$centang->dnt28)
                    ->getStyle($ra[58][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[58][0].$rowes,$totaldnt28)
                    ->getStyle($ra[58][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[59][0].$row,$centang->dns28)
                    ->getStyle($ra[59][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[59][0].$rowes,number_format($totaldns28,0,',',','))
                    ->getStyle($ra[59][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                }elseif(!isset($centang->dnt30)){
                    $sheet->setCellValue($ra[4][0].$row,$centang->dnt1)
                    ->getStyle($ra[4][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[4][0].$rowes,$totaldnt1)
                    ->getStyle($ra[4][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[5][0].$row,$centang->dns1)
                    ->getStyle($ra[5][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[5][0].$rowes,number_format($totaldns1,0,',',','))
                    ->getStyle($ra[5][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[6][0].$row,$centang->dnt2)
                    ->getStyle($ra[6][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[6][0].$rowes,$totaldnt2)
                    ->getStyle($ra[6][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[7][0].$row,$centang->dns2)
                    ->getStyle($ra[7][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[7][0].$rowes,number_format($totaldns2,0,',',','))
                    ->getStyle($ra[7][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[8][0].$row,$centang->dnt3)
                    ->getStyle($ra[8][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[8][0].$rowes,$totaldnt3)
                    ->getStyle($ra[8][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[9][0].$row,$centang->dns3)
                    ->getStyle($ra[9][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[9][0].$rowes,number_format($totaldns3,0,',',','))
                    ->getStyle($ra[9][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[10][0].$row,$centang->dnt4)
                    ->getStyle($ra[10][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[10][0].$rowes,$totaldnt4)
                    ->getStyle($ra[10][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[11][0].$row,$centang->dns4)
                    ->getStyle($ra[11][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[11][0].$rowes,number_format($totaldns4,0,',',','))
                    ->getStyle($ra[11][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[12][0].$row,$centang->dnt5)
                    ->getStyle($ra[12][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[12][0].$rowes,$totaldnt5)
                    ->getStyle($ra[12][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[13][0].$row,$centang->dns5)
                    ->getStyle($ra[13][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[13][0].$rowes,number_format($totaldns5,0,',',','))
                    ->getStyle($ra[13][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[14][0].$row,$centang->dnt6)
                    ->getStyle($ra[14][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[14][0].$rowes,$totaldnt6)
                    ->getStyle($ra[14][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[15][0].$row,$centang->dns6)
                    ->getStyle($ra[15][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[15][0].$rowes,number_format($totaldns6,0,',',','))
                    ->getStyle($ra[15][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[16][0].$row,$centang->dnt7)
                    ->getStyle($ra[16][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[16][0].$rowes,$totaldnt7)
                    ->getStyle($ra[16][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[17][0].$row,$centang->dns7)
                    ->getStyle($ra[17][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[17][0].$rowes,number_format($totaldns7,0,',',','))
                    ->getStyle($ra[17][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[18][0].$row,$centang->dnt8)
                    ->getStyle($ra[18][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[18][0].$rowes,$totaldnt8)
                    ->getStyle($ra[18][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[19][0].$row,$centang->dns8)
                    ->getStyle($ra[19][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[19][0].$rowes,number_format($totaldns8,0,',',','))
                    ->getStyle($ra[19][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[20][0].$row,$centang->dnt9)
                    ->getStyle($ra[20][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[20][0].$rowes,$totaldnt9)
                    ->getStyle($ra[20][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[21][0].$row,$centang->dns9)
                    ->getStyle($ra[21][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[21][0].$rowes,number_format($totaldns9,0,',',','))
                    ->getStyle($ra[21][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[22][0].$row,$centang->dnt10)
                    ->getStyle($ra[22][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[22][0].$rowes,$totaldnt10)
                    ->getStyle($ra[22][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[23][0].$row,$centang->dns10)
                    ->getStyle($ra[23][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[23][0].$rowes,number_format($totaldns10,0,',',','))
                    ->getStyle($ra[23][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[24][0].$row,$centang->dnt11)
                    ->getStyle($ra[24][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[24][0].$rowes,$totaldnt11)
                    ->getStyle($ra[24][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[25][0].$row,$centang->dns11)
                    ->getStyle($ra[25][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[25][0].$rowes,number_format($totaldns11,0,',',','))
                    ->getStyle($ra[25][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[26][0].$row,$centang->dnt12)
                    ->getStyle($ra[26][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[26][0].$rowes,$totaldnt12)
                    ->getStyle($ra[26][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[27][0].$row,$centang->dns12)
                    ->getStyle($ra[27][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[27][0].$rowes,number_format($totaldns12,0,',',','))
                    ->getStyle($ra[27][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[28][0].$row,$centang->dnt13)
                    ->getStyle($ra[28][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[28][0].$rowes,$totaldnt13)
                    ->getStyle($ra[28][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[29][0].$row,$centang->dns13)
                    ->getStyle($ra[29][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[29][0].$rowes,number_format($totaldns13,0,',',','))
                    ->getStyle($ra[29][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[30][0].$row,$centang->dnt14)
                    ->getStyle($ra[30][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[30][0].$rowes,$totaldnt14)
                    ->getStyle($ra[30][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[31][0].$row,$centang->dns14)
                    ->getStyle($ra[31][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[31][0].$rowes,number_format($totaldns14,0,',',','))
                    ->getStyle($ra[31][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[32][0].$row,$centang->dnt15)
                    ->getStyle($ra[32][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[32][0].$rowes,$totaldnt15)
                    ->getStyle($ra[32][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[33][0].$row,$centang->dns15)
                    ->getStyle($ra[33][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[33][0].$rowes,number_format($totaldns15,0,',',','))
                    ->getStyle($ra[33][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[34][0].$row,$centang->dnt16)
                    ->getStyle($ra[34][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[34][0].$rowes,$totaldnt16)
                    ->getStyle($ra[34][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[35][0].$row,$centang->dns16)
                    ->getStyle($ra[35][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[35][0].$rowes,number_format($totaldns16,0,',',','))
                    ->getStyle($ra[35][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[36][0].$row,$centang->dnt17)
                    ->getStyle($ra[36][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[36][0].$rowes,$totaldnt17)
                    ->getStyle($ra[36][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[37][0].$row,$centang->dns17)
                    ->getStyle($ra[37][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[37][0].$rowes,number_format($totaldns17,0,',',','))
                    ->getStyle($ra[37][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[38][0].$row,$centang->dnt18)
                    ->getStyle($ra[38][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[38][0].$rowes,$totaldnt18)
                    ->getStyle($ra[38][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[39][0].$row,$centang->dns18)
                    ->getStyle($ra[39][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[39][0].$rowes,number_format($totaldns18,0,',',','))
                    ->getStyle($ra[39][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[40][0].$row,$centang->dnt19)
                    ->getStyle($ra[40][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[40][0].$rowes,$totaldnt19)
                    ->getStyle($ra[40][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[41][0].$row,$centang->dns19)
                    ->getStyle($ra[41][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[41][0].$rowes,number_format($totaldns19,0,',',','))
                    ->getStyle($ra[41][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[42][0].$row,$centang->dnt20)
                    ->getStyle($ra[42][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[42][0].$rowes,$totaldnt20)
                    ->getStyle($ra[42][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[43][0].$row,$centang->dns20)
                    ->getStyle($ra[43][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[43][0].$rowes,number_format($totaldns20,0,',',','))
                    ->getStyle($ra[43][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[44][0].$row,$centang->dnt21)
                    ->getStyle($ra[44][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[44][0].$rowes,$totaldnt21)
                    ->getStyle($ra[44][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[45][0].$row,$centang->dns21)
                    ->getStyle($ra[45][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[45][0].$rowes,number_format($totaldns21,0,',',','))
                    ->getStyle($ra[45][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[46][0].$row,$centang->dnt22)
                    ->getStyle($ra[46][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[46][0].$rowes,$totaldnt22)
                    ->getStyle($ra[46][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[47][0].$row,$centang->dns22)
                    ->getStyle($ra[47][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[47][0].$rowes,number_format($totaldns22,0,',',','))
                    ->getStyle($ra[47][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[48][0].$row,$centang->dnt23)
                    ->getStyle($ra[48][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[48][0].$rowes,$totaldnt23)
                    ->getStyle($ra[48][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[49][0].$row,$centang->dns23)
                    ->getStyle($ra[49][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[49][0].$rowes,number_format($totaldns23,0,',',','))
                    ->getStyle($ra[49][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[50][0].$row,$centang->dnt24)
                    ->getStyle($ra[50][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[50][0].$rowes,$totaldnt24)
                    ->getStyle($ra[50][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[51][0].$row,$centang->dns24)
                    ->getStyle($ra[51][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[51][0].$rowes,number_format($totaldns24,0,',',','))
                    ->getStyle($ra[51][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[52][0].$row,$centang->dnt25)
                    ->getStyle($ra[52][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[52][0].$rowes,$totaldnt25)
                    ->getStyle($ra[52][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[53][0].$row,$centang->dns25)
                    ->getStyle($ra[53][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[53][0].$rowes,number_format($totaldns25,0,',',','))
                    ->getStyle($ra[53][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[54][0].$row,$centang->dnt26)
                    ->getStyle($ra[54][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[54][0].$rowes,$totaldnt26)
                    ->getStyle($ra[54][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[55][0].$row,$centang->dns26)
                    ->getStyle($ra[55][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[55][0].$rowes,number_format($totaldns26,0,',',','))
                    ->getStyle($ra[55][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[56][0].$row,$centang->dnt27)
                    ->getStyle($ra[56][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[56][0].$rowes,$totaldnt27)
                    ->getStyle($ra[56][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[57][0].$row,$centang->dns27)
                    ->getStyle($ra[57][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);                
                    
                    $sheet->setCellValue($ra[57][0].$rowes,number_format($totaldns27,0,',',','))
                    ->getStyle($ra[57][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);                
                    
                    $sheet->setCellValue($ra[58][0].$row,$centang->dnt28)
                    ->getStyle($ra[58][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[58][0].$rowes,$totaldnt28)
                    ->getStyle($ra[58][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[59][0].$row,$centang->dns28)
                    ->getStyle($ra[59][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[59][0].$rowes,number_format($totaldns28,0,',',','))
                    ->getStyle($ra[59][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[60][0].$row,$centang->dnt29)
                    ->getStyle($ra[60][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[60][0].$rowes,$totaldnt29)
                    ->getStyle($ra[60][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[61][0].$row,$centang->dns29)
                    ->getStyle($ra[61][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[61][0].$rowes,number_format($totaldns29,0,',',','))
                    ->getStyle($ra[61][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    
                }elseif(!isset($centang->dnt31)){
                    $sheet->setCellValue($ra[4][0].$row,$centang->dnt1)
                    ->getStyle($ra[4][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[4][0].$rowes,$totaldnt1)
                    ->getStyle($ra[4][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[5][0].$row,$centang->dns1)
                    ->getStyle($ra[5][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[5][0].$rowes,number_format($totaldns1,0,',',','))
                    ->getStyle($ra[5][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[6][0].$row,$centang->dnt2)
                    ->getStyle($ra[6][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[6][0].$rowes,$totaldnt2)
                    ->getStyle($ra[6][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[7][0].$row,$centang->dns2)
                    ->getStyle($ra[7][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[7][0].$rowes,number_format($totaldns2,0,',',','))
                    ->getStyle($ra[7][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[8][0].$row,$centang->dnt3)
                    ->getStyle($ra[8][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[8][0].$rowes,$totaldnt3)
                    ->getStyle($ra[8][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[9][0].$row,$centang->dns3)
                    ->getStyle($ra[9][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[9][0].$rowes,number_format($totaldns3,0,',',','))
                    ->getStyle($ra[9][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[10][0].$row,$centang->dnt4)
                    ->getStyle($ra[10][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[10][0].$rowes,$totaldnt4)
                    ->getStyle($ra[10][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[11][0].$row,$centang->dns4)
                    ->getStyle($ra[11][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[11][0].$rowes,number_format($totaldns4,0,',',','))
                    ->getStyle($ra[11][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[12][0].$row,$centang->dnt5)
                    ->getStyle($ra[12][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[12][0].$rowes,$totaldnt5)
                    ->getStyle($ra[12][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[13][0].$row,$centang->dns5)
                    ->getStyle($ra[13][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[13][0].$rowes,number_format($totaldns5,0,',',','))
                    ->getStyle($ra[13][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[14][0].$row,$centang->dnt6)
                    ->getStyle($ra[14][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[14][0].$rowes,$totaldnt6)
                    ->getStyle($ra[14][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[15][0].$row,$centang->dns6)
                    ->getStyle($ra[15][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[15][0].$rowes,number_format($totaldns6,0,',',','))
                    ->getStyle($ra[15][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[16][0].$row,$centang->dnt7)
                    ->getStyle($ra[16][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[16][0].$rowes,$totaldnt7)
                    ->getStyle($ra[16][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[17][0].$row,$centang->dns7)
                    ->getStyle($ra[17][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[17][0].$rowes,number_format($totaldns7,0,',',','))
                    ->getStyle($ra[17][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[18][0].$row,$centang->dnt8)
                    ->getStyle($ra[18][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[18][0].$rowes,$totaldnt8)
                    ->getStyle($ra[18][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[19][0].$row,$centang->dns8)
                    ->getStyle($ra[19][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[19][0].$rowes,number_format($totaldns8,0,',',','))
                    ->getStyle($ra[19][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[20][0].$row,$centang->dnt9)
                    ->getStyle($ra[20][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[20][0].$rowes,$totaldnt9)
                    ->getStyle($ra[20][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[21][0].$row,$centang->dns9)
                    ->getStyle($ra[21][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[21][0].$rowes,number_format($totaldns9,0,',',','))
                    ->getStyle($ra[21][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[22][0].$row,$centang->dnt10)
                    ->getStyle($ra[22][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[22][0].$rowes,$totaldnt10)
                    ->getStyle($ra[22][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[23][0].$row,$centang->dns10)
                    ->getStyle($ra[23][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[23][0].$rowes,number_format($totaldns10,0,',',','))
                    ->getStyle($ra[23][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[24][0].$row,$centang->dnt11)
                    ->getStyle($ra[24][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[24][0].$rowes,$totaldnt11)
                    ->getStyle($ra[24][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[25][0].$row,$centang->dns11)
                    ->getStyle($ra[25][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[25][0].$rowes,number_format($totaldns11,0,',',','))
                    ->getStyle($ra[25][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[26][0].$row,$centang->dnt12)
                    ->getStyle($ra[26][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[26][0].$rowes,$totaldnt12)
                    ->getStyle($ra[26][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[27][0].$row,$centang->dns12)
                    ->getStyle($ra[27][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[27][0].$rowes,number_format($totaldns12,0,',',','))
                    ->getStyle($ra[27][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[28][0].$row,$centang->dnt13)
                    ->getStyle($ra[28][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[28][0].$rowes,$totaldnt13)
                    ->getStyle($ra[28][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[29][0].$row,$centang->dns13)
                    ->getStyle($ra[29][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[29][0].$rowes,number_format($totaldns13,0,',',','))
                    ->getStyle($ra[29][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[30][0].$row,$centang->dnt14)
                    ->getStyle($ra[30][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[30][0].$rowes,$totaldnt14)
                    ->getStyle($ra[30][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[31][0].$row,$centang->dns14)
                    ->getStyle($ra[31][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[31][0].$rowes,number_format($totaldns14,0,',',','))
                    ->getStyle($ra[31][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[32][0].$row,$centang->dnt15)
                    ->getStyle($ra[32][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[32][0].$rowes,$totaldnt15)
                    ->getStyle($ra[32][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[33][0].$row,$centang->dns15)
                    ->getStyle($ra[33][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[33][0].$rowes,number_format($totaldns15,0,',',','))
                    ->getStyle($ra[33][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[34][0].$row,$centang->dnt16)
                    ->getStyle($ra[34][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[34][0].$rowes,$totaldnt16)
                    ->getStyle($ra[34][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[35][0].$row,$centang->dns16)
                    ->getStyle($ra[35][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[35][0].$rowes,number_format($totaldns16,0,',',','))
                    ->getStyle($ra[35][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[36][0].$row,$centang->dnt17)
                    ->getStyle($ra[36][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[36][0].$rowes,$totaldnt17)
                    ->getStyle($ra[36][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[37][0].$row,$centang->dns17)
                    ->getStyle($ra[37][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[37][0].$rowes,number_format($totaldns17,0,',',','))
                    ->getStyle($ra[37][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[38][0].$row,$centang->dnt18)
                    ->getStyle($ra[38][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[38][0].$rowes,$totaldnt18)
                    ->getStyle($ra[38][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[39][0].$row,$centang->dns18)
                    ->getStyle($ra[39][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[39][0].$rowes,number_format($totaldns18,0,',',','))
                    ->getStyle($ra[39][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[40][0].$row,$centang->dnt19)
                    ->getStyle($ra[40][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[40][0].$rowes,$totaldnt19)
                    ->getStyle($ra[40][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[41][0].$row,$centang->dns19)
                    ->getStyle($ra[41][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[41][0].$rowes,number_format($totaldns19,0,',',','))
                    ->getStyle($ra[41][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[42][0].$row,$centang->dnt20)
                    ->getStyle($ra[42][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[42][0].$rowes,$totaldnt20)
                    ->getStyle($ra[42][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[43][0].$row,$centang->dns20)
                    ->getStyle($ra[43][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[43][0].$rowes,number_format($totaldns20,0,',',','))
                    ->getStyle($ra[43][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[44][0].$row,$centang->dnt21)
                    ->getStyle($ra[44][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[44][0].$rowes,$totaldnt21)
                    ->getStyle($ra[44][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[45][0].$row,$centang->dns21)
                    ->getStyle($ra[45][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[45][0].$rowes,number_format($totaldns21,0,',',','))
                    ->getStyle($ra[45][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[46][0].$row,$centang->dnt22)
                    ->getStyle($ra[46][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[46][0].$rowes,$totaldnt22)
                    ->getStyle($ra[46][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[47][0].$row,$centang->dns22)
                    ->getStyle($ra[47][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[47][0].$rowes,number_format($totaldns22,0,',',','))
                    ->getStyle($ra[47][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[48][0].$row,$centang->dnt23)
                    ->getStyle($ra[48][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[48][0].$rowes,$totaldnt23)
                    ->getStyle($ra[48][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[49][0].$row,$centang->dns23)
                    ->getStyle($ra[49][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[49][0].$rowes,number_format($totaldns23,0,',',','))
                    ->getStyle($ra[49][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[50][0].$row,$centang->dnt24)
                    ->getStyle($ra[50][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[50][0].$rowes,$totaldnt24)
                    ->getStyle($ra[50][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[51][0].$row,$centang->dns24)
                    ->getStyle($ra[51][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[51][0].$rowes,number_format($totaldns24,0,',',','))
                    ->getStyle($ra[51][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[52][0].$row,$centang->dnt25)
                    ->getStyle($ra[52][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[52][0].$rowes,$totaldnt25)
                    ->getStyle($ra[52][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[53][0].$row,$centang->dns25)
                    ->getStyle($ra[53][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[53][0].$rowes,number_format($totaldns25,0,',',','))
                    ->getStyle($ra[53][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[54][0].$row,$centang->dnt26)
                    ->getStyle($ra[54][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[54][0].$rowes,$totaldnt26)
                    ->getStyle($ra[54][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[55][0].$row,$centang->dns26)
                    ->getStyle($ra[55][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[55][0].$rowes,number_format($totaldns26,0,',',','))
                    ->getStyle($ra[55][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[56][0].$row,$centang->dnt27)
                    ->getStyle($ra[56][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[56][0].$rowes,$totaldnt27)
                    ->getStyle($ra[56][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[57][0].$row,$centang->dns27)
                    ->getStyle($ra[57][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);                
                    
                    $sheet->setCellValue($ra[57][0].$rowes,number_format($totaldns27,0,',',','))
                    ->getStyle($ra[57][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);                
                    
                    $sheet->setCellValue($ra[58][0].$row,$centang->dnt28)
                    ->getStyle($ra[58][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[58][0].$rowes,$totaldnt28)
                    ->getStyle($ra[58][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[59][0].$row,$centang->dns28)
                    ->getStyle($ra[59][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[59][0].$rowes,number_format($totaldns28,0,',',','))
                    ->getStyle($ra[59][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[60][0].$row,$centang->dnt29)
                    ->getStyle($ra[60][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[60][0].$rowes,$totaldnt29)
                    ->getStyle($ra[60][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[61][0].$row,$centang->dns29)
                    ->getStyle($ra[61][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[61][0].$rowes,number_format($totaldns29,0,',',','))
                    ->getStyle($ra[61][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[62][0].$row,$centang->dnt30)
                    ->getStyle($ra[62][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[62][0].$rowes,$totaldnt30)
                    ->getStyle($ra[62][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[63][0].$row,$centang->dns30)
                    ->getStyle($ra[63][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[63][0].$rowes,number_format($totaldns30,0,',',','))
                    ->getStyle($ra[63][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    
                }else{
                    $sheet->setCellValue($ra[4][0].$row,$centang->dnt1)
                    ->getStyle($ra[4][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[4][0].$rowes,$totaldnt1)
                    ->getStyle($ra[4][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[5][0].$row,$centang->dns1)
                    ->getStyle($ra[5][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[5][0].$rowes,number_format($totaldns1,0,',',','))
                    ->getStyle($ra[5][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[6][0].$row,$centang->dnt2)
                    ->getStyle($ra[6][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[6][0].$rowes,$totaldnt2)
                    ->getStyle($ra[6][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[7][0].$row,$centang->dns2)
                    ->getStyle($ra[7][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[7][0].$rowes,number_format($totaldns2,0,',',','))
                    ->getStyle($ra[7][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[8][0].$row,$centang->dnt3)
                    ->getStyle($ra[8][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[8][0].$rowes,$totaldnt3)
                    ->getStyle($ra[8][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[9][0].$row,$centang->dns3)
                    ->getStyle($ra[9][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[9][0].$rowes,number_format($totaldns3,0,',',','))
                    ->getStyle($ra[9][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[10][0].$row,$centang->dnt4)
                    ->getStyle($ra[10][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[10][0].$rowes,$totaldnt4)
                    ->getStyle($ra[10][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[11][0].$row,$centang->dns4)
                    ->getStyle($ra[11][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[11][0].$rowes,number_format($totaldns4,0,',',','))
                    ->getStyle($ra[11][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[12][0].$row,$centang->dnt5)
                    ->getStyle($ra[12][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[12][0].$rowes,$totaldnt5)
                    ->getStyle($ra[12][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[13][0].$row,$centang->dns5)
                    ->getStyle($ra[13][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[13][0].$rowes,number_format($totaldns5,0,',',','))
                    ->getStyle($ra[13][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[14][0].$row,$centang->dnt6)
                    ->getStyle($ra[14][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[14][0].$rowes,$totaldnt6)
                    ->getStyle($ra[14][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[15][0].$row,$centang->dns6)
                    ->getStyle($ra[15][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[15][0].$rowes,number_format($totaldns6,0,',',','))
                    ->getStyle($ra[15][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[16][0].$row,$centang->dnt7)
                    ->getStyle($ra[16][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[16][0].$rowes,$totaldnt7)
                    ->getStyle($ra[16][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[17][0].$row,$centang->dns7)
                    ->getStyle($ra[17][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[17][0].$rowes,number_format($totaldns7,0,',',','))
                    ->getStyle($ra[17][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[18][0].$row,$centang->dnt8)
                    ->getStyle($ra[18][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[18][0].$rowes,$totaldnt8)
                    ->getStyle($ra[18][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[19][0].$row,$centang->dns8)
                    ->getStyle($ra[19][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[19][0].$rowes,number_format($totaldns8,0,',',','))
                    ->getStyle($ra[19][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[20][0].$row,$centang->dnt9)
                    ->getStyle($ra[20][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[20][0].$rowes,$totaldnt9)
                    ->getStyle($ra[20][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[21][0].$row,$centang->dns9)
                    ->getStyle($ra[21][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[21][0].$rowes,number_format($totaldns9,0,',',','))
                    ->getStyle($ra[21][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[22][0].$row,$centang->dnt10)
                    ->getStyle($ra[22][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[22][0].$rowes,$totaldnt10)
                    ->getStyle($ra[22][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[23][0].$row,$centang->dns10)
                    ->getStyle($ra[23][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[23][0].$rowes,number_format($totaldns10,0,',',','))
                    ->getStyle($ra[23][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[24][0].$row,$centang->dnt11)
                    ->getStyle($ra[24][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[24][0].$rowes,$totaldnt11)
                    ->getStyle($ra[24][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[25][0].$row,$centang->dns11)
                    ->getStyle($ra[25][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[25][0].$rowes,number_format($totaldns11,0,',',','))
                    ->getStyle($ra[25][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[26][0].$row,$centang->dnt12)
                    ->getStyle($ra[26][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[26][0].$rowes,$totaldnt12)
                    ->getStyle($ra[26][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[27][0].$row,$centang->dns12)
                    ->getStyle($ra[27][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[27][0].$rowes,number_format($totaldns12,0,',',','))
                    ->getStyle($ra[27][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[28][0].$row,$centang->dnt13)
                    ->getStyle($ra[28][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[28][0].$rowes,$totaldnt13)
                    ->getStyle($ra[28][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[29][0].$row,$centang->dns13)
                    ->getStyle($ra[29][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[29][0].$rowes,number_format($totaldns13,0,',',','))
                    ->getStyle($ra[29][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[30][0].$row,$centang->dnt14)
                    ->getStyle($ra[30][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[30][0].$rowes,$totaldnt14)
                    ->getStyle($ra[30][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[31][0].$row,$centang->dns14)
                    ->getStyle($ra[31][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[31][0].$rowes,number_format($totaldns14,0,',',','))
                    ->getStyle($ra[31][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[32][0].$row,$centang->dnt15)
                    ->getStyle($ra[32][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[32][0].$rowes,$totaldnt15)
                    ->getStyle($ra[32][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[33][0].$row,$centang->dns15)
                    ->getStyle($ra[33][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[33][0].$rowes,number_format($totaldns15,0,',',','))
                    ->getStyle($ra[33][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[34][0].$row,$centang->dnt16)
                    ->getStyle($ra[34][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[34][0].$rowes,$totaldnt16)
                    ->getStyle($ra[34][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[35][0].$row,$centang->dns16)
                    ->getStyle($ra[35][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[35][0].$rowes,number_format($totaldns16,0,',',','))
                    ->getStyle($ra[35][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[36][0].$row,$centang->dnt17)
                    ->getStyle($ra[36][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[36][0].$rowes,$totaldnt17)
                    ->getStyle($ra[36][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[37][0].$row,$centang->dns17)
                    ->getStyle($ra[37][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[37][0].$rowes,number_format($totaldns17,0,',',','))
                    ->getStyle($ra[37][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[38][0].$row,$centang->dnt18)
                    ->getStyle($ra[38][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[38][0].$rowes,$totaldnt18)
                    ->getStyle($ra[38][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[39][0].$row,$centang->dns18)
                    ->getStyle($ra[39][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[39][0].$rowes,number_format($totaldns18,0,',',','))
                    ->getStyle($ra[39][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[40][0].$row,$centang->dnt19)
                    ->getStyle($ra[40][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[40][0].$rowes,$totaldnt19)
                    ->getStyle($ra[40][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[41][0].$row,$centang->dns19)
                    ->getStyle($ra[41][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[41][0].$rowes,number_format($totaldns19,0,',',','))
                    ->getStyle($ra[41][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[42][0].$row,$centang->dnt20)
                    ->getStyle($ra[42][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[42][0].$rowes,$totaldnt20)
                    ->getStyle($ra[42][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[43][0].$row,$centang->dns20)
                    ->getStyle($ra[43][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[43][0].$rowes,number_format($totaldns20,0,',',','))
                    ->getStyle($ra[43][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[44][0].$row,$centang->dnt21)
                    ->getStyle($ra[44][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[44][0].$rowes,$totaldnt21)
                    ->getStyle($ra[44][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[45][0].$row,$centang->dns21)
                    ->getStyle($ra[45][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[45][0].$rowes,number_format($totaldns21,0,',',','))
                    ->getStyle($ra[45][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[46][0].$row,$centang->dnt22)
                    ->getStyle($ra[46][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[46][0].$rowes,$totaldnt22)
                    ->getStyle($ra[46][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[47][0].$row,$centang->dns22)
                    ->getStyle($ra[47][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[47][0].$rowes,number_format($totaldns22,0,',',','))
                    ->getStyle($ra[47][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[48][0].$row,$centang->dnt23)
                    ->getStyle($ra[48][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[48][0].$rowes,$totaldnt23)
                    ->getStyle($ra[48][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[49][0].$row,$centang->dns23)
                    ->getStyle($ra[49][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[49][0].$rowes,number_format($totaldns23,0,',',','))
                    ->getStyle($ra[49][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[50][0].$row,$centang->dnt24)
                    ->getStyle($ra[50][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[50][0].$rowes,$totaldnt24)
                    ->getStyle($ra[50][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[51][0].$row,$centang->dns24)
                    ->getStyle($ra[51][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[51][0].$rowes,number_format($totaldns24,0,',',','))
                    ->getStyle($ra[51][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[52][0].$row,$centang->dnt25)
                    ->getStyle($ra[52][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[52][0].$rowes,$totaldnt25)
                    ->getStyle($ra[52][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[53][0].$row,$centang->dns25)
                    ->getStyle($ra[53][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[53][0].$rowes,number_format($totaldns25,0,',',','))
                    ->getStyle($ra[53][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[54][0].$row,$centang->dnt26)
                    ->getStyle($ra[54][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[54][0].$rowes,$totaldnt26)
                    ->getStyle($ra[54][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[55][0].$row,$centang->dns26)
                    ->getStyle($ra[55][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[55][0].$rowes,number_format($totaldns26,0,',',','))
                    ->getStyle($ra[55][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[56][0].$row,$centang->dnt27)
                    ->getStyle($ra[56][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[56][0].$rowes,$totaldnt27)
                    ->getStyle($ra[56][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[57][0].$row,$centang->dns27)
                    ->getStyle($ra[57][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);                
                    
                    $sheet->setCellValue($ra[57][0].$rowes,number_format($totaldns27,0,',',','))
                    ->getStyle($ra[57][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);                
                    
                    $sheet->setCellValue($ra[58][0].$row,$centang->dnt28)
                    ->getStyle($ra[58][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[58][0].$rowes,$totaldnt28)
                    ->getStyle($ra[58][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[59][0].$row,$centang->dns28)
                    ->getStyle($ra[59][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[59][0].$rowes,number_format($totaldns28,0,',',','))
                    ->getStyle($ra[59][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[60][0].$row,$centang->dnt29)
                    ->getStyle($ra[60][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[60][0].$rowes,$totaldnt29)
                    ->getStyle($ra[60][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[61][0].$row,$centang->dns29)
                    ->getStyle($ra[61][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[61][0].$rowes,number_format($totaldns29,0,',',','))
                    ->getStyle($ra[61][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[62][0].$row,$centang->dnt30)
                    ->getStyle($ra[62][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[62][0].$rowes,$totaldnt30)
                    ->getStyle($ra[62][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[63][0].$row,$centang->dns30)
                    ->getStyle($ra[63][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[63][0].$rowes,number_format($totaldns30,0,',',','))
                    ->getStyle($ra[63][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[64][0].$row,$centang->dnt31)
                    ->getStyle($ra[64][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[64][0].$rowes,$totaldnt31)
                    ->getStyle($ra[64][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[65][0].$row,$centang->dns31)
                    ->getStyle($ra[65][0].$row)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    $sheet->setCellValue($ra[65][0].$rowes,number_format($totaldns31,0,',',','))
                    ->getStyle($ra[65][0].$rowes)->getAlignment()->setVertical('center')->setHorizontal('right')->setWrapText(true);
                    
                    
                       
                }
                $tots = $ra[$q+=1][0];
                $tots2 = $ra[$q+1][0];
                $tots3 = $ra[$q+2][0];
                $sheet->setCellValue($tot.$row,$centang->qty)
                ->getStyle($tots.$row)
                ->getAlignment()->setVertical('center')
                ->setHorizontal('right');
                $sheet->setCellValue($tot.$rowes,$totalqty)
                ->getStyle($tots.$rowes)
                ->getAlignment()->setVertical('center')
                ->setHorizontal('right');
                $sheet->setCellValue($tot2.$row, $centang->tot_dnt)
                ->getStyle($tots2.$row)
                ->getAlignment()->setVertical('center')
                ->setHorizontal('right');
                $sheet->setCellValue($tot2.$rowes,$totaltotdnt )
                ->getStyle($tots2.$rowes)
                ->getAlignment()->setVertical('center')
                ->setHorizontal('right');
                $sheet->setCellValue($tot3.$row, $centang->jumlah)
                ->getStyle($tots3.$row)
                ->getAlignment()->setVertical('center')
                ->setHorizontal('right');
                $sheet->setCellValue($tot3.$rowes,number_format($totaltotdns,0,',',','))
                ->getStyle($tots3.$rowes)
                ->getAlignment()->setVertical('center')
                ->setHorizontal('right');
                $sheet->setCellValue('A'.$rowes,'Total')->mergeCells('A'.$rowes.':D'.$rowes)
                ->getStyle($tots.$rowes)
                ->getAlignment()->setVertical('center')
                ->setHorizontal('left');


                $sheet->getStyle('A4:'.$ra[$e+6][0].$rowes)->applyFromArray($styleArray);
                $row++;
                $a++;
            }

        $writer = new Xlsx($spreadsheet);
        $filename = 'rekap_centang';
        
        // download file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        }
    }

    public function getData() {
        $tgl = explode('-', $this->input->post('date'));
        $hari = cal_days_in_month(CAL_GREGORIAN,$tgl[0], $tgl[1]);
        // // $this->session->set_userdata('tgl', $this->input->get('date'));
        // // $this->session->set_userdata('kodej', $this->input->get('kodej'));
        // // $query = $this->mcentang->getSlip($hari,$tgl[0],$tgl[1]);        
        // // $data = $this->mcentang->getDataPetugas($tgl[0],$tgl[1]);
                $draw=$_REQUEST['draw'];
                $length=$_REQUEST['length'];
                $start=$_REQUEST['start'];
                $search=$_REQUEST['search']['value'];
                $total=$this->mcentang->getDataAlls($tgl[0],$tgl[1])->num_rows();
                $output=array();
                $output['draw']=$draw;
                $output['recordsTotal']=$output['recordsFiltered']=$total;
                $output['data']=array();
                // foreach($data as $dat){
                    
                    // }
                    if($search != null){
                        $data=$this->mcentang->searchData($search,$length,$start,$tgl[0],$tgl[1]);            
                        $jum=$this->mcentang->jumSrc($search,$tgl[0],$tgl[1]);
                        $output['recordsTotal']=$output['recordsFiltered']=$jum->num_rows();
                    }else{
                        $data = $this->mcentang->getSlip($start,$length,$tgl[0],$tgl[1]);
                        }
        // for($a=1;$a <= $hari;$a++){
        //     $dats .=
        //     $dat->dns[$a] =$this->mcentang->getDns($length,$dat->kodej,$tgl[0],$tgl[1],$a);
        // }
            $nomor_urut=$start+1;
            $dnts="";
            // for($s=1;$s<=$hari;$s++){
            //     $dnts = "data->dnt".$s;
            //     $dnt{$s} = ${$dnts};
            // }
            
            foreach ($data as $data) {
                if(!isset($data->dnt29) ){
                    $output['data'][]=array($nomor_urut,$data->kodej,$data->nama,$data->cabang,$data->dnt1,$data->dns1,$data->dnt2,$data->dns2,$data->dnt3,$data->dns3,$data->dnt4,$data->dns4,$data->dnt5,$data->dns5,$data->dnt6,$data->dns6,$data->dnt7,$data->dns7,$data->dnt8,$data->dns8,$data->dnt9,$data->dns9,$data->dnt10,$data->dns10,$data->dnt11,$data->dns11,$data->dnt12,$data->dns12,$data->dnt13,$data->dns13,$data->dnt14,$data->dns14,$data->dnt15,$data->dns15,$data->dnt16,$data->dns16,$data->dnt17,$data->dns17,$data->dnt18,$data->dns18,$data->dnt19,$data->dns19,$data->dnt20,$data->dns20,$data->dnt21,$data->dns21,$data->dnt22,$data->dns22,$data->dnt23,$data->dns23,$data->dnt24,$data->dns24,$data->dnt25,$data->dns25,$data->dnt26,$data->dns26,$data->dnt27,$data->dns27,$data->dnt28,$data->dns28,$data->qty,$data->tot_dnt,$data->jumlah);
                }elseif(!isset($data->dnt30)){
                    $output['data'][]=array($nomor_urut,$data->kodej,$data->nama,$data->cabang,$data->dnt1,$data->dns1,$data->dnt2,$data->dns2,$data->dnt3,$data->dns3,$data->dnt4,$data->dns4,$data->dnt5,$data->dns5,$data->dnt6,$data->dns6,$data->dnt7,$data->dns7,$data->dnt8,$data->dns8,$data->dnt9,$data->dns9,$data->dnt10,$data->dns10,$data->dnt11,$data->dns11,$data->dnt12,$data->dns12,$data->dnt13,$data->dns13,$data->dnt14,$data->dns14,$data->dnt15,$data->dns15,$data->dnt16,$data->dns16,$data->dnt17,$data->dns17,$data->dnt18,$data->dns18,$data->dnt19,$data->dns19,$data->dnt20,$data->dns20,$data->dnt21,$data->dns21,$data->dnt22,$data->dns22,$data->dnt23,$data->dns23,$data->dnt24,$data->dns24,$data->dnt25,$data->dns25,$data->dnt26,$data->dns26,$data->dnt27,$data->dns27,$data->dnt28,$data->dns28,$data->dnt29,$data->dns29,$data->qty,$data->tot_dnt,$data->jumlah);
                }elseif(!isset($data->dnt31)){
                    $output['data'][]=array($nomor_urut,$data->kodej,$data->nama,$data->cabang,$data->dnt1,$data->dns1,$data->dnt2,$data->dns2,$data->dnt3,$data->dns3,$data->dnt4,$data->dns4,$data->dnt5,$data->dns5,$data->dnt6,$data->dns6,$data->dnt7,$data->dns7,$data->dnt8,$data->dns8,$data->dnt9,$data->dns9,$data->dnt10,$data->dns10,$data->dnt11,$data->dns11,$data->dnt12,$data->dns12,$data->dnt13,$data->dns13,$data->dnt14,$data->dns14,$data->dnt15,$data->dns15,$data->dnt16,$data->dns16,$data->dnt17,$data->dns17,$data->dnt18,$data->dns18,$data->dnt19,$data->dns19,$data->dnt20,$data->dns20,$data->dnt21,$data->dns21,$data->dnt22,$data->dns22,$data->dnt23,$data->dns23,$data->dnt24,$data->dns24,$data->dnt25,$data->dns25,$data->dnt26,$data->dns26,$data->dnt27,$data->dns27,$data->dnt28,$data->dns28,$data->dnt29,$data->dns29,$data->dnt30,$data->dns30,$data->qty,$data->tot_dnt,$data->jumlah);
                }else{
                    $output['data'][]=array($nomor_urut,$data->kodej,$data->nama,$data->cabang,$data->dnt1,$data->dns1,$data->dnt2,$data->dns2,$data->dnt3,$data->dns3,$data->dnt4,$data->dns4,$data->dnt5,$data->dns5,$data->dnt6,$data->dns6,$data->dnt7,$data->dns7,$data->dnt8,$data->dns8,$data->dnt9,$data->dns9,$data->dnt10,$data->dns10,$data->dnt11,$data->dns11,$data->dnt12,$data->dns12,$data->dnt13,$data->dns13,$data->dnt14,$data->dns14,$data->dnt15,$data->dns15,$data->dnt16,$data->dns16,$data->dnt17,$data->dns17,$data->dnt18,$data->dns18,$data->dnt19,$data->dns19,$data->dnt20,$data->dns20,$data->dnt21,$data->dns21,$data->dnt22,$data->dns22,$data->dnt23,$data->dns23,$data->dnt24,$data->dns24,$data->dnt25,$data->dns25,$data->dnt26,$data->dns26,$data->dnt27,$data->dns27,$data->dnt28,$data->dns28,$data->dnt29,$data->dns29,$data->dnt30,$data->dns30,$data->dnt31,$data->dns31,$data->qty,$data->tot_dnt,$data->jumlah);
                }
            $nomor_urut++;
            }
        echo json_encode($output);
    }

    public function getDataProgram() {
        $tgl = explode(' - ', $this->input->post('date'));
        $this->session->set_userdata('tgl', $this->input->post('date'));
        // $this->session->set_userdata('kodej', $this->input->get('kodej'));
        $data = $this->mcentang->getDataProg($this->input->post('noslip'),$tgl[0],$tgl[1]);
        echo json_encode($data);
    }

    public function insertProg(){
        $kodej= $this->input->post('kodej');
        $bank=$this->input->post('bank');
        $noslip = $this->input->post('noslip');
        $program = $this->input->post('program');
        $jumlah = $this->input->post('jumlah');
        $id_vent= $this->input->post('id_vent');
        $validasi = $this->input->post('validasi');

        // $dataProg=$this->mcentang->getProgSlip($noslip);

        
            // for ($x = 0, $y = count($dataProg); $x<=$y; $x++) {
                // if($dataProg[$x]['prog'] != $program){
                    // if($x == $y){
                    $data = $this->mcentang->insertToProg($kodej,$noslip,$program,$jumlah,$bank);
                    // }x
            //         continue;                    
            //     }
            // }


        // $data_donatur = $this->mcentang->getDataDonatur($noslip);
        // foreach( $data_donatur as $datas){
        //     $date=date_create($datas->tanggal);
        //     $object=array(
        //         'noid'=>$datas->noid,
        //         'nama'=>$datas->nama,
        //         'almktr'=>$datas->almktr,
        //         'telphp'=>$datas->telphp,
        //         'tanggal'=>$date->format('Y-m-d'),
        //         'kwsn'=>$datas->kwsn,
        //         'kodej'=>$datas->kodej,
        //         'prog'=>$datas->prog,
        //         'noslip'=>$datas->noslip,
        //         'jumlah'=>$datas->jumlah,
        //         'report_id'=>$datas->report_id,
        //         'ket'=>$datas->ket
        //     );
        //     $this->mcentang->insertToDntQ($object);
        // }
        // if( $id_vent == '2'){
        //     $data = $this->mcentang->insertToDntQ();
        // }
        echo json_encode($data);
    }
    
    public function insertSlipBaru(){
        $nokasir= $this->input->post('nokasir');
        $bank=$this->input->post('bank');
        // $noslip = $this->input->post('noslip');
        $program = $this->input->post('program');
        $jumlah = $this->input->post('jumlah');
        $id_vent= $this->input->post('id_vent');
        $keterangan = $this->input->post('keterangan');
        $jungut=$this->input->post('jungut');
        $tgl_himp=$this->input->post('tgl_himp');
        $data = $this->mcentang->insertToSlipbaru($nokasir,$bank,$program,$jumlah, $keterangan,$jungut,$tgl_himp);
        if($id_vent == '2'){
            
        }
        echo json_encode($data);
    }


    // public function cetakRekap($noslip = null) {
    //     if ($this->session->userdata('admin') == TRUE) {
    //         if (!isset($noslip)) redirect(base_url('report/validasi'));
	// 		$where = array(
	// 			"noslip" => $noslip
    //         );
    //         $data['rekap'] = $this->mvalidasi->getPerData($noslip);
    //         $data['data'] = array(
    //             'kodej' => $this->session->userdata('kodej'),
    //             'noslip' => $noslip,
    //         );
	// 		$this->load->view('rekap_validasi', $data);
    //     } else {
    //         redirect(base_url());
    //     }
    // }

}

/* End of file Validasi.php */
