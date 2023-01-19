<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require('./phpSpreadSheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Per_petugas extends CI_Controller {
    

    public function __construct() {
        parent::__construct();
        $this->load->model('mper_petugas');
        $this->load->model('mprogram');
        $this->load->model('mpage');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
        $data['tahun'] = array();
        for($tahun = 2014; $tahun <= date('Y');$tahun++){
            $data['tahun'][] = [
               "tahun" => $tahun
            ];
        }
        if ($this->session->userdata('admin') == TRUE) {
            if ($this->session->userdata('superadmin') == TRUE) {
                $data['cabang'] = $this->mper_petugas->getCabang();
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
                $data['cabang'] = $this->mper_petugas->getCabangCab();
            } else if ($this->session->userdata('admin_grup') == TRUE) {
                $data['cabang'] = $this->mper_petugas->getCabangGrup();
            }
            $this->load->view('per_petugas', $data);
        } else {
            redirect(base_url());
        }
    }

    public function getJungut() {
        if ($this->input->get('cabang') == '-') {
            $data = $this->mper_petugas->getAll();
        } else {
            $data = $this->mper_petugas->getAllTwo($this->input->get('cabang'));
        }   
        echo json_encode($data);
    }

    public function cetakRekap() {
        if($this->input->post('bulan') == '01' ){
            $bln = "Januari";
        }elseif($this->input->post('bulan') == '02' ){
            $bln = "Februari";
        }elseif($this->input->post('bulan') == '03' ){
            $bln = "Maret";
        }elseif($this->input->post('bulan') == '04' ){
            $bln = "April";
        }elseif($this->input->post('bulan') == '05' ){
            $bln = "Mei";
        }
        elseif($this->input->post('bulan') == '06' ){
            $bln = "Juni";
        }
        elseif($this->input->post('bulan') == '07' ){
            $bln = "Juli";
        }
        elseif($this->input->post('bulan') == '08' ){
            $bln = "Agustus";
        }elseif($this->input->post('bulan') == '09' ){
            $bln = "September";
        }elseif($this->input->post('bulan') == '10' ){
            $bln = "Oktober";
        }elseif($this->input->post('bulan') == '11' ){
            $bln = "November";
        }elseif($this->input->post('bulan') == '12' ){
            $bln = "Desember";
        }
            $data['periode']=array(
                "tahun" => $this->input->post('tahun'),
                "bulan" => $bln
            );
            $idcabang=$this->input->post('cabang');
            $tahun = $this->input->post('tahun');
            $bulan = $this->input->post('bulan');
            $jungut = $this->input->post('jungut');
        if($this->input->post('btncetak')){
            
                if($jungut == "-" && $idcabang == '-'){
                // $data['petugas']=$this->mper_petugas->getPetugasAll($idcabang);
                $data['prestasi']=$this->mper_petugas->rekapPerPetugasAll($bulan,$tahun);
                $this->load->view('rekap_per_petugas',$data);
                }
                elseif($jungut == "-" && $idcabang != '-')
                {
                $data['petugas']=$this->mper_petugas->getPetugasAll($idcabang);
                $data['prestasi']=$this->mper_petugas->rekapPerPetugas($bulan,$tahun,$idcabang);
                $this->load->view('rekap_per_petugas',$data);
                }else{
                $data['petugas']=$this->mper_petugas->getPetugas($jungut,$idcabang);
                $data['prestasi']=$this->mper_petugas->rekapPerPetugasJungut($jungut,$bulan,$tahun,$idcabang);
                $this->load->view('rekap_per_petugas',$data);
                }
        }
        else{
            if($jungut == "-" && $idcabang == '-'){
                // $data['petugas']=$this->mper_petugas->getPetugasAll($idcabang);
                $data['prestasi']=$this->mper_petugas->rekapPerPetugasAll($bulan,$tahun);
                $prestasi=$data['prestasi'];
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

                $sheet->setCellValue('A1','REKAP PEROLEHAN TOTAL PER JUNGUT')
                ->mergeCells('A1:T1')->getStyle('A1')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
                $sheet->setCellValue('A2','WILAYAH : SEMUA WILAYAH'.$nbsp.$nbsp.$nbsp.'PERIODE : '.$data['periode']['bulan'].' '.$data['periode']['tahun'])
                ->mergeCells('A2:T2')->getStyle('A2')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
                $sheet->setCellValue('A4','No')
                ->mergeCells('A4:A5')->getStyle('A4')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
                ;
                $sheet->setCellValue('B4','NAMA')
                ->mergeCells('B4:C4')->mergeCells('B4:B5')->mergeCells('B5:C5')->getStyle('B4')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
                ;
                $sheet->setCellValue('D4','KODE')->mergeCells('D4:D5')->getStyle('D4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('E4','TARGET')
                ->mergeCells('E4:F4')->getStyle('E4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('G4','HASIL')
                ->mergeCells('G4:H4')->getStyle('G4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('I4','HASIL%')
                ->mergeCells('I4:J4')->getStyle('I4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('K4','%RATA2')
                ->mergeCells('K4:K5')->getStyle('K4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('L4','GAGAL')
                ->mergeCells('L4:M4')->getStyle('L4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('N4','LEBIH')
                ->mergeCells('N4:O4')->getStyle('N4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('P4','TOTAL')
                ->mergeCells('P4:Q4')->getStyle('P4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('R4','%TOTAL')
                ->mergeCells('R4:S4')->getStyle('R4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('T4','%RATA2')
                ->mergeCells('T4:T5')->getStyle('T4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('E5','DONATUR')
                ->getStyle('E5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('F5','DONASI')
                ->getStyle('F5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('G5','DONATUR')
                ->getStyle('G5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('H5','DONASI')
                ->getStyle('H5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('I5','DONATUR')
                ->getStyle('I5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('J5','DONASI')
                ->getStyle('J5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('L5','DONATUR')
                ->getStyle('L5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('M5','DONASI')
                ->getStyle('M5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('N5','DONATUR')
                ->getStyle('N5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('O5','DONASI')
                ->getStyle('O5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('P5','DONATUR')
                ->getStyle('P5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('Q5','DONASI')
                ->getStyle('Q5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('R5','DONATUR')
                ->getStyle('R5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('S5','DONASI')
                ->getStyle('S5')->getAlignment()->setVertical('center')->setHorizontal('center');

                $row=6;
                foreach($prestasi as $no => $prestasi){
                    $sheet->setCellValue('A'.$row,$no+1)->getStyle('A'.$row)->getAlignment()->setHorizontal('left');
                    $sheet->setCellValue('B'.$row,$prestasi->nama)->mergeCells('B'.$row.':C'.$row);
                    $sheet->setCellValue('D'.$row,$prestasi->kodej)->getStyle('D'.$row)->getAlignment()->setHorizontal('right');
                    $sheet->setCellValue('E'.$row,$prestasi->T_DNT);
                    $sheet->setCellValue('F'.$row,number_format($prestasi->T_DNS,0,',',','));
                    $sheet->setCellValue('G'.$row,$prestasi->H_DNT);
                    $sheet->setCellValue('H'.$row,number_format($prestasi->H_DNS,0,',',','));
                    $persn_hsl1=(intval($prestasi->H_DNT) / intval($prestasi->T_DNT))*100; 
                    $sheet->setCellValue('I'.$row,number_format($persn_hsl1,2,',',',').'%');
                    $persn_hsl2=(intval($prestasi->H_DNS) / intval($prestasi->T_DNS))*100;
                    $sheet->setCellValue('J'.$row,number_format($persn_hsl2,2,',',',').'%');
                    $rata=($persn_hsl1 + $persn_hsl2)/2;
                    $sheet->setCellValue('K'.$row,number_format($rata,2,',',',').'%');
                    $sheet->setCellValue('L'.$row,$prestasi->G_DNT);
                    $sheet->setCellValue('M'.$row,number_format($prestasi->G_DNS,0,',',','));
                    $sheet->setCellValue('N'.$row,$prestasi->L_DNT);
                    $sheet->setCellValue('O'.$row,number_format($prestasi->L_DNS,0,',',','));
                    $sheet->setCellValue('P'.$row,$prestasi->TT_DNT);
                    $sheet->setCellValue('Q'.$row,number_format($prestasi->TT_DNS,0,',',','));
                    $persn_hsl3=(intval($prestasi->TT_DNT) / intval($prestasi->T_DNT))*100; 
                    $sheet->setCellValue('R'.$row,number_format($persn_hsl3,2,',',',').'%');
                    $persn_hsl4=(intval($prestasi->TT_DNS) / intval($prestasi->T_DNS))*100;
                    $sheet->setCellValue('S'.$row,number_format($persn_hsl4,2,',',',').'%');
                    $rata1=($persn_hsl3 + $persn_hsl4)/2;
                    $sheet->setCellValue('T'.$row,number_format($rata1,2,',',',').'%');

                    $row++;
                }
                $rows=count($data['prestasi']);
                $row=$rows+6;
                $sheet->setCellValue('A'.$row,'JUMLAH')->mergeCells('A'.$row.':D'.$row);
                $tot1=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot1+= $prestasi->T_DNT;
                }
                $sheet->setCellValue('E'.$row,$tot1);
                $tot2=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot2+= $prestasi->T_DNS;
                }
                $sheet->setCellValue('F'.$row,number_format($tot2,0,',',','));
                $tot3=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot3+= $prestasi->H_DNT;
                }
                $sheet->setCellValue('G'.$row,$tot3);
                $tot4=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot4+= $prestasi->H_DNS;
                }
                $sheet->setCellValue('H'.$row,number_format($tot4,0,',',','));
                if(count($data['prestasi'])<0){$tot_persn_hsl1=$tot3/$tot1*100;}else{$tot_persn_hsl1=0;}
                $sheet->setCellValue('I'.$row,number_format($tot_persn_hsl1,2,',',',').'%');
                if(count($data['prestasi'])<0){$tot_persn_hsl2=$tot4/$tot2*100;}else{$tot_persn_hsl2=0;}
                $sheet->setCellValue('J'.$row,number_format($tot_persn_hsl2,2,',',',').'%');
                if(count($data['prestasi'])<0){$rat_persn_hsl1=($tot_persn_hsl1+$tot_persn_hsl2)/2;}else{$rat_persn_hsl1=0;}
                $sheet->setCellValue('K'.$row,number_format($rat_persn_hsl1,2,',',',').'%');
                $tot5=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot5+= $prestasi->G_DNT;
                }
                $sheet->setCellValue('L'.$row,$tot5);
                $tot6=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot6+= $prestasi->G_DNS;
                }
                $sheet->setCellValue('M'.$row,number_format($tot6,0,',',','));
                $tot7=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot7+= $prestasi->L_DNT;
                }
                $sheet->setCellValue('N'.$row,$tot7);
                $tot8=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot8+= $prestasi->L_DNS;
                }
                $sheet->setCellValue('O'.$row,number_format($tot8,0,',',','));
                $tot9=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot9+= $prestasi->TT_DNT;
                }
                $sheet->setCellValue('P'.$row,$tot9);
                $tot10=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot10+= $prestasi->TT_DNS;
                }
                $sheet->setCellValue('Q'.$row,number_format($tot10,0,',',','));
                if(count($data['prestasi'])<0){$tot_persn_hsl3=$tot9/$tot1*100;}else{$tot_persn_hsl3=0;}
                $sheet->setCellValue('R'.$row,number_format($tot_persn_hsl3,2,',',',').'%');
                if(count($data['prestasi'])<0){$tot_persn_hsl4=$tot10/$tot2*100;}else{$tot_persn_hsl4=0;}
                $sheet->setCellValue('S'.$row,number_format($tot_persn_hsl4,2,',',',').'%');
                if(count($data['prestasi'])<0){$rat_persn_hsl2=($tot_persn_hsl3+$tot_persn_hsl4)/2;}else{$rat_persn_hsl2=0;}
                $sheet->setCellValue('T'.$row,number_format($rat_persn_hsl2,2,',',',').'%');

                $rows=count($data['prestasi']);
                $row=$rows+6;
                $sheet->getStyle('A4:T'.$row)->applyFromArray($styleArray);

                $writer = new Xlsx($spreadsheet);
                $filename = 'rekap_prestasi_per_petugas';
                
                // download file
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
        
                }
                elseif($jungut == "-" && $idcabang != '-')
                {
                $data['petugas']=$this->mper_petugas->getPetugasAll($idcabang);
                $data['prestasi']=$this->mper_petugas->rekapPerPetugas($bulan,$tahun,$idcabang);
                $prestasi=$data['prestasi'];
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

                $sheet->setCellValue('A1','REKAP PEROLEHAN TOTAL PER JUNGUT')
                ->mergeCells('A1:T1')->getStyle('A1')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
                $sheet->setCellValue('A2','WILAYAH : '.$data['petugas']->nama_cabang.$nbsp.$nbsp.$nbsp.'PERIODE : '.$data['periode']['bulan'].' '.$data['periode']['tahun'])
                ->mergeCells('A2:T2')->getStyle('A2')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
                $sheet->setCellValue('A4','No')
                ->mergeCells('A4:A5')->getStyle('A4')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
                ;
                $sheet->setCellValue('B4','NAMA')
                ->mergeCells('B4:C4')->mergeCells('B4:B5')->mergeCells('B5:C5')->getStyle('B4')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
                ;
                $sheet->setCellValue('D4','KODE')->mergeCells('D4:D5')->getStyle('D4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('E4','TARGET')
                ->mergeCells('E4:F4')->getStyle('E4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('G4','HASIL')
                ->mergeCells('G4:H4')->getStyle('G4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('I4','HASIL%')
                ->mergeCells('I4:J4')->getStyle('I4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('K4','%RATA2')
                ->mergeCells('K4:K5')->getStyle('K4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('L4','GAGAL')
                ->mergeCells('L4:M4')->getStyle('L4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('N4','LEBIH')
                ->mergeCells('N4:O4')->getStyle('N4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('P4','TOTAL')
                ->mergeCells('P4:Q4')->getStyle('P4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('R4','%TOTAL')
                ->mergeCells('R4:S4')->getStyle('R4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('T4','%RATA2')
                ->mergeCells('T4:T5')->getStyle('T4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('E5','DONATUR')
                ->getStyle('E5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('F5','DONASI')
                ->getStyle('F5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('G5','DONATUR')
                ->getStyle('G5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('H5','DONASI')
                ->getStyle('H5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('I5','DONATUR')
                ->getStyle('I5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('J5','DONASI')
                ->getStyle('J5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('L5','DONATUR')
                ->getStyle('L5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('M5','DONASI')
                ->getStyle('M5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('N5','DONATUR')
                ->getStyle('N5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('O5','DONASI')
                ->getStyle('O5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('P5','DONATUR')
                ->getStyle('P5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('Q5','DONASI')
                ->getStyle('Q5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('R5','DONATUR')
                ->getStyle('R5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('S5','DONASI')
                ->getStyle('S5')->getAlignment()->setVertical('center')->setHorizontal('center');

                $row=6;
                foreach($prestasi as $no => $prestasi){
                    $sheet->setCellValue('A'.$row,$no+1)->getStyle('A'.$row)->getAlignment()->setHorizontal('left');
                    $sheet->setCellValue('B'.$row,$prestasi->nama)->mergeCells('B'.$row.':C'.$row);
                    $sheet->setCellValue('D'.$row,$prestasi->kodej)->getStyle('D'.$row)->getAlignment()->setHorizontal('right');
                    $sheet->setCellValue('E'.$row,$prestasi->T_DNT);
                    $sheet->setCellValue('F'.$row,number_format($prestasi->T_DNS,0,',',','));
                    $sheet->setCellValue('G'.$row,$prestasi->H_DNT);
                    $sheet->setCellValue('H'.$row,number_format($prestasi->H_DNS,0,',',','));
                    $persn_hsl1=(intval($prestasi->H_DNT) / intval($prestasi->T_DNT))*100; 
                    $sheet->setCellValue('I'.$row,number_format($persn_hsl1,2,',',',').'%');
                    $persn_hsl2=(intval($prestasi->H_DNS) / intval($prestasi->T_DNS))*100;
                    $sheet->setCellValue('J'.$row,number_format($persn_hsl2,2,',',',').'%');
                    $rata=($persn_hsl1 + $persn_hsl2)/2;
                    $sheet->setCellValue('K'.$row,number_format($rata,2,',',',').'%');
                    $sheet->setCellValue('L'.$row,$prestasi->G_DNT);
                    $sheet->setCellValue('M'.$row,number_format($prestasi->G_DNS,0,',',','));
                    $sheet->setCellValue('N'.$row,$prestasi->L_DNT);
                    $sheet->setCellValue('O'.$row,number_format($prestasi->L_DNS,0,',',','));
                    $sheet->setCellValue('P'.$row,$prestasi->TT_DNT);
                    $sheet->setCellValue('Q'.$row,number_format($prestasi->TT_DNS,0,',',','));
                    $persn_hsl3=(intval($prestasi->TT_DNT) / intval($prestasi->T_DNT))*100; 
                    $sheet->setCellValue('R'.$row,number_format($persn_hsl3,2,',',',').'%');
                    $persn_hsl4=(intval($prestasi->TT_DNS) / intval($prestasi->T_DNS))*100;
                    $sheet->setCellValue('S'.$row,number_format($persn_hsl4,2,',',',').'%');
                    $rata1=($persn_hsl3 + $persn_hsl4)/2;
                    $sheet->setCellValue('T'.$row,number_format($rata1,2,',',',').'%');

                    $row++;
                }
                $rows=count($data['prestasi']);
                $row=$rows+6;
                $sheet->setCellValue('A'.$row,'JUMLAH')->mergeCells('A'.$row.':D'.$row);
                $tot1=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot1+= $prestasi->T_DNT;
                }
                $sheet->setCellValue('E'.$row,$tot1);
                $tot2=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot2+= $prestasi->T_DNS;
                }
                $sheet->setCellValue('F'.$row,number_format($tot2,0,',',','));
                $tot3=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot3+= $prestasi->H_DNT;
                }
                $sheet->setCellValue('G'.$row,$tot3);
                $tot4=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot4+= $prestasi->H_DNS;
                }
                $sheet->setCellValue('H'.$row,number_format($tot4,0,',',','));
                if(count($data['prestasi'])<0){$tot_persn_hsl1=$tot3/$tot1*100;}else{$tot_persn_hsl1=0;}
                $sheet->setCellValue('I'.$row,number_format($tot_persn_hsl1,2,',',',').'%');
                if(count($data['prestasi'])<0){$tot_persn_hsl2=$tot4/$tot2*100;}else{$tot_persn_hsl2=0;}
                $sheet->setCellValue('J'.$row,number_format($tot_persn_hsl2,2,',',',').'%');
                if(count($data['prestasi'])<0){$rat_persn_hsl1=($tot_persn_hsl1+$tot_persn_hsl2)/2;}else{$rat_persn_hsl1=0;}
                $sheet->setCellValue('K'.$row,number_format($rat_persn_hsl1,2,',',',').'%');
                $tot5=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot5+= $prestasi->G_DNT;
                }
                $sheet->setCellValue('L'.$row,$tot5);
                $tot6=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot6+= $prestasi->G_DNS;
                }
                $sheet->setCellValue('M'.$row,number_format($tot6,0,',',','));
                $tot7=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot7+= $prestasi->L_DNT;
                }
                $sheet->setCellValue('N'.$row,$tot7);
                $tot8=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot8+= $prestasi->L_DNS;
                }
                $sheet->setCellValue('O'.$row,number_format($tot8,0,',',','));
                $tot9=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot9+= $prestasi->TT_DNT;
                }
                $sheet->setCellValue('P'.$row,$tot9);
                $tot10=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot10+= $prestasi->TT_DNS;
                }
                $sheet->setCellValue('Q'.$row,number_format($tot10,0,',',','));
                if(count($data['prestasi'])<0){$tot_persn_hsl3=$tot9/$tot1*100;}else{$tot_persn_hsl3=0;}
                $sheet->setCellValue('R'.$row,number_format($tot_persn_hsl3,2,',',',').'%');
                if(count($data['prestasi'])<0){$tot_persn_hsl4=$tot10/$tot2*100;}else{$tot_persn_hsl4=0;}
                $sheet->setCellValue('S'.$row,number_format($tot_persn_hsl4,2,',',',').'%');
                if(count($data['prestasi'])<0){$rat_persn_hsl2=($tot_persn_hsl3+$tot_persn_hsl4)/2;}else{$rat_persn_hsl2=0;}
                $sheet->setCellValue('T'.$row,number_format($rat_persn_hsl2,2,',',',').'%');

                $rows=count($data['prestasi']);
                $row=$rows+6;
                $sheet->getStyle('A4:T'.$row)->applyFromArray($styleArray);

                $writer = new Xlsx($spreadsheet);
                $filename = 'rekap_prestasi_per_petugas';
                
                // download file
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                
                }else{
                $data['petugas']=$this->mper_petugas->getPetugas($jungut,$idcabang);
                $data['prestasi']=$this->mper_petugas->rekapPerPetugasJungut($jungut,$bulan,$tahun,$idcabang);
                $prestasi=$data['prestasi'];
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

                $sheet->setCellValue('A1','REKAP PEROLEHAN TOTAL PER JUNGUT')
                ->mergeCells('A1:T1')->getStyle('A1')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
                $sheet->setCellValue('A2',$data['petugas']->name.$nbsp.$nbsp.$nbsp.'WILAYAH : '.$data['petugas']->nama_cabang.$nbsp.$nbsp.$nbsp.'PERIODE : '.$data['periode']['bulan'].' '.$data['periode']['tahun'])
                ->mergeCells('A2:T2')->getStyle('A2')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
                $sheet->setCellValue('A4','No')
                ->mergeCells('A4:A5')->getStyle('A4')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
                ;
                $sheet->setCellValue('B4','NAMA')
                ->mergeCells('B4:C4')->mergeCells('B4:B5')->mergeCells('B5:C5')->getStyle('B4')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
                ;
                $sheet->setCellValue('D4','KODE')->mergeCells('D4:D5')->getStyle('D4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('E4','TARGET')
                ->mergeCells('E4:F4')->getStyle('E4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('G4','HASIL')
                ->mergeCells('G4:H4')->getStyle('G4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('I4','HASIL%')
                ->mergeCells('I4:J4')->getStyle('I4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('K4','%RATA2')
                ->mergeCells('K4:K5')->getStyle('K4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('L4','GAGAL')
                ->mergeCells('L4:M4')->getStyle('L4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('N4','LEBIH')
                ->mergeCells('N4:O4')->getStyle('N4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('P4','TOTAL')
                ->mergeCells('P4:Q4')->getStyle('P4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('R4','%TOTAL')
                ->mergeCells('R4:S4')->getStyle('R4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('T4','%RATA2')
                ->mergeCells('T4:T5')->getStyle('T4')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('E5','DONATUR')
                ->getStyle('E5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('F5','DONASI')
                ->getStyle('F5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('G5','DONATUR')
                ->getStyle('G5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('H5','DONASI')
                ->getStyle('H5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('I5','DONATUR')
                ->getStyle('I5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('J5','DONASI')
                ->getStyle('J5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('L5','DONATUR')
                ->getStyle('L5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('M5','DONASI')
                ->getStyle('M5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('N5','DONATUR')
                ->getStyle('N5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('O5','DONASI')
                ->getStyle('O5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('P5','DONATUR')
                ->getStyle('P5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('Q5','DONASI')
                ->getStyle('Q5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('R5','DONATUR')
                ->getStyle('R5')->getAlignment()->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('S5','DONASI')
                ->getStyle('S5')->getAlignment()->setVertical('center')->setHorizontal('center');

                $row=6;
                foreach($prestasi as $no => $prestasi){
                    $sheet->setCellValue('A'.$row,$no+1)->getStyle('A'.$row)->getAlignment()->setHorizontal('left');
                    $sheet->setCellValue('B'.$row,$prestasi->nama)->mergeCells('B'.$row.':C'.$row);
                    $sheet->setCellValue('D'.$row,$prestasi->kodej)->getStyle('D'.$row)->getAlignment()->setHorizontal('right');
                    $sheet->setCellValue('E'.$row,$prestasi->T_DNT);
                    $sheet->setCellValue('F'.$row,number_format($prestasi->T_DNS,0,',',','));
                    $sheet->setCellValue('G'.$row,$prestasi->H_DNT);
                    $sheet->setCellValue('H'.$row,number_format($prestasi->H_DNS,0,',',','));
                    $persn_hsl1=(intval($prestasi->H_DNT) / intval($prestasi->T_DNT))*100; 
                    $sheet->setCellValue('I'.$row,number_format($persn_hsl1,2,',',',').'%');
                    $persn_hsl2=(intval($prestasi->H_DNS) / intval($prestasi->T_DNS))*100;
                    $sheet->setCellValue('J'.$row,number_format($persn_hsl2,2,',',',').'%');
                    $rata=($persn_hsl1 + $persn_hsl2)/2;
                    $sheet->setCellValue('K'.$row,number_format($rata,2,',',',').'%');
                    $sheet->setCellValue('L'.$row,$prestasi->G_DNT);
                    $sheet->setCellValue('M'.$row,number_format($prestasi->G_DNS,0,',',','));
                    $sheet->setCellValue('N'.$row,$prestasi->L_DNT);
                    $sheet->setCellValue('O'.$row,number_format($prestasi->L_DNS,0,',',','));
                    $sheet->setCellValue('P'.$row,$prestasi->TT_DNT);
                    $sheet->setCellValue('Q'.$row,number_format($prestasi->TT_DNS,0,',',','));
                    $persn_hsl3=(intval($prestasi->TT_DNT) / intval($prestasi->T_DNT))*100; 
                    $sheet->setCellValue('R'.$row,number_format($persn_hsl3,2,',',',').'%');
                    $persn_hsl4=(intval($prestasi->TT_DNS) / intval($prestasi->T_DNS))*100;
                    $sheet->setCellValue('S'.$row,number_format($persn_hsl4,2,',',',').'%');
                    $rata1=($persn_hsl3 + $persn_hsl4)/2;
                    $sheet->setCellValue('T'.$row,number_format($rata1,2,',',',').'%');

                    $row++;
                }
                $rows=count($data['prestasi']);
                $row=$rows+6;
                $sheet->setCellValue('A'.$row,'JUMLAH')->mergeCells('A'.$row.':D'.$row);
                $tot1=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot1+= $prestasi->T_DNT;
                }
                $sheet->setCellValue('E'.$row,$tot1);
                $tot2=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot2+= $prestasi->T_DNS;
                }
                $sheet->setCellValue('F'.$row,number_format($tot2,0,',',','));
                $tot3=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot3+= $prestasi->H_DNT;
                }
                $sheet->setCellValue('G'.$row,$tot3);
                $tot4=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot4+= $prestasi->H_DNS;
                }
                $sheet->setCellValue('H'.$row,number_format($tot4,0,',',','));
                if(count($data['prestasi'])<0){$tot_persn_hsl1=$tot3/$tot1*100;}else{$tot_persn_hsl1=0;}
                $sheet->setCellValue('I'.$row,number_format($tot_persn_hsl1,2,',',',').'%');
                if(count($data['prestasi'])<0){$tot_persn_hsl2=$tot4/$tot2*100;}else{$tot_persn_hsl2=0;}
                $sheet->setCellValue('J'.$row,number_format($tot_persn_hsl2,2,',',',').'%');
                if(count($data['prestasi'])<0){$rat_persn_hsl1=($tot_persn_hsl1+$tot_persn_hsl2)/2;}else{$rat_persn_hsl1=0;}
                $sheet->setCellValue('K'.$row,number_format($rat_persn_hsl1,2,',',',').'%');
                $tot5=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot5+= $prestasi->G_DNT;
                }
                $sheet->setCellValue('L'.$row,$tot5);
                $tot6=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot6+= $prestasi->G_DNS;
                }
                $sheet->setCellValue('M'.$row,number_format($tot6,0,',',','));
                $tot7=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot7+= $prestasi->L_DNT;
                }
                $sheet->setCellValue('N'.$row,$tot7);
                $tot8=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot8+= $prestasi->L_DNS;
                }
                $sheet->setCellValue('O'.$row,number_format($tot8,0,',',','));
                $tot9=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot9+= $prestasi->TT_DNT;
                }
                $sheet->setCellValue('P'.$row,$tot9);
                $tot10=0;
                foreach($data['prestasi'] as $prestasi){
                    $tot10+= $prestasi->TT_DNS;
                }
                $sheet->setCellValue('Q'.$row,number_format($tot10,0,',',','));
                if(count($data['prestasi'])<0){$tot_persn_hsl3=$tot9/$tot1*100;}else{$tot_persn_hsl3=0;}
                $sheet->setCellValue('R'.$row,number_format($tot_persn_hsl3,2,',',',').'%');
                if(count($data['prestasi'])<0){$tot_persn_hsl4=$tot10/$tot2*100;}else{$tot_persn_hsl4=0;}
                $sheet->setCellValue('S'.$row,number_format($tot_persn_hsl4,2,',',',').'%');
                if(count($data['prestasi'])<0){$rat_persn_hsl2=($tot_persn_hsl3+$tot_persn_hsl4)/2;}else{$rat_persn_hsl2=0;}
                $sheet->setCellValue('T'.$row,number_format($rat_persn_hsl2,2,',',',').'%');

                $rows=count($data['prestasi']);
                $row=$rows+6;
                $sheet->getStyle('A4:T'.$row)->applyFromArray($styleArray);

                $writer = new Xlsx($spreadsheet);
                $filename = 'rekap_prestasi_per_petugas';
                
                // download file
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                
                
                }
        }
    }

}

/* End of file Per_petugas.php */
