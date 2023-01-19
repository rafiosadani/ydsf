<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load library phpspreadsheet
require('./phpSpreadSheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class Page extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('mlogin');
        $this->load->model('mpage');
        $this->load->model('mprogram');
        $this->load->library('form_validation');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
      if ($this->input->get('show') ){
        if ($this->session->userdata('superadmin')== TRUE) {
            $data['aktifUmur20']=$this->mpage->aktifUmur20();
            $data['aktifUmur20AllTime'] = $this->mpage->aktifUmur20AllTime();
            
            $data['aktifUmur2030']=$this->mpage->aktifUmur2030();
            $data['aktifUmur2030AllTime'] = $this->mpage->aktifUmur2030AllTime();

            $data['aktifUmur3040']=$this->mpage->aktifUmur3040();
            $data['aktifUmur3040AllTime'] = $this->mpage->aktifUmur3040AllTime();

            $data['aktifUmur4050']=$this->mpage->aktifUmur4050();
            $data['aktifUmur4050AllTime'] = $this->mpage->aktifUmur4050AllTime();

            $data['aktifUmur50']=$this->mpage->aktifUmur50();
            $data['aktifUmur50AllTime'] = $this->mpage->aktifUmur50AllTime();

            $data['unknownAktifUmur']=$this->mpage->unknownAktifUmur();
            $data['unknownAktifUmurAllTime']=$this->mpage->unknownAktifUmurAllTime();

            $data['aktifKelaminL']=$this->mpage->aktifKelaminL();
            $data['aktifKelaminLAllTime']=$this->mpage->aktifKelaminLAllTime();

            $data['aktifKelaminP']=$this->mpage->aktifKelaminP();
            $data['aktifKelaminPAllTime']=$this->mpage->aktifKelaminPAllTime();

            $data['unknownAktifKelamin']=$this->mpage->unknownAktifKelamin();
            $data['unknownAktifKelaminAllTime']=$this->mpage->unknownAktifKelaminAllTime();

            $data['aktifYesTelp']=$this->mpage->aktifYesTelp();
            $data['aktifYesTelpAllTime']=$this->mpage->aktifYesTelpAllTime();

            $data['aktifNoTelp']=$this->mpage->aktifNoTelp();
            $data['aktifNoTelpAllTime']=$this->mpage->aktifNoTelpAllTime();

            $data['aktifSetor20']=$this->mpage->aktifSetor20();
            $data['aktifSetor20AllTime']=$this->mpage->aktifSetor20AllTime();

            $data['aktifSetor2030']=$this->mpage->aktifSetor2030();
            $data['aktifSetor2030AllTime']=$this->mpage->aktifSetor2030AllTime();

            $data['aktifSetor3050']=$this->mpage->aktifSetor3050();
            $data['aktifSetor3050AllTime']=$this->mpage->aktifSetor3050AllTime();

            $data['aktifSetor50100']=$this->mpage->aktifSetor50100();
            $data['aktifSetor50100AllTime']=$this->mpage->aktifSetor50100AllTime();

            $data['aktifSetor100']=$this->mpage->aktifSetor100();
            $data['aktifSetor100AllTime']=$this->mpage->aktifSetor100AllTime();

            $data['target']=$this->mpage->Target();
            $data['tertagih']=$this->mpage->Tertagih();
            $data['keuangan']=$this->mpage->Keuangan();
            $this->load->view('dashboard',$data);
        } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang')==TRUE) {
            $data['aktifUmur20']=$this->mpage->aktifUmur20Cabang();
            $data['aktifUmur20AllTime']=$this->mpage->aktifUmur20CabangAllTime();

            $data['aktifUmur2030']=$this->mpage->aktifUmur2030Cabang();
            $data['aktifUmur2030AllTime']=$this->mpage->aktifUmur2030CabangAllTime();

            $data['aktifUmur3040']=$this->mpage->aktifUmur3040Cabang();
            $data['aktifUmur3040AllTime']=$this->mpage->aktifUmur3040CabangAllTime();

            $data['aktifUmur4050']=$this->mpage->aktifUmur4050Cabang();
            $data['aktifUmur4050AllTime']=$this->mpage->aktifUmur4050CabangAllTime();

            $data['aktifUmur50']=$this->mpage->aktifUmur50Cabang();
            $data['aktifUmur50AllTime']=$this->mpage->aktifUmur50CabangAllTime();

            $data['unknownAktifUmur']=$this->mpage->unknownAktifUmurCabang();
            $data['unknownAktifUmurAllTime']=$this->mpage->unknownAktifUmurCabangAllTime();

            $data['aktifKelaminL']=$this->mpage->aktifKelaminLCabang();

            $data['aktifKelaminP']=$this->mpage->aktifKelaminPCabang();
            
            $data['unknownAktifKelamin']=$this->mpage->unknownAktifKelaminCabang();
            $data['aktifYesTelp']=$this->mpage->aktifYesTelpCabang();
            $data['aktifNoTelp']=$this->mpage->aktifNoTelpCabang();
            $data['aktifSetor20']=$this->mpage->aktifSetor20Cabang();
            $data['aktifSetor2030']=$this->mpage->aktifSetor2030Cabang();
            $data['aktifSetor3050']=$this->mpage->aktifSetor3050Cabang();
            $data['aktifSetor50100']=$this->mpage->aktifSetor50100Cabang();
            $data['aktifSetor100']=$this->mpage->aktifSetor100Cabang();
            $data['target']=$this->mpage->TargetCabang();
            $data['tertagih']=$this->mpage->TertagihCabang();
            $data['keuangan']=$this->mpage->KeuanganCabang();
            $this->load->view('dashboard',$data);
        } else if ($this->session->userdata('admin_grup') == TRUE) {
            $data['aktifUmur20']=$this->mpage->aktifUmur20Group();
            $data['aktifUmur2030']=$this->mpage->aktifUmur2030Group();
            $data['aktifUmur3040']=$this->mpage->aktifUmur3040Group();
            $data['aktifUmur4050']=$this->mpage->aktifUmur4050Group();
            $data['aktifUmur50']=$this->mpage->aktifUmur50Group();
            $data['aktifKelaminL']=$this->mpage->aktifKelaminLGroup();
            $data['aktifKelaminP']=$this->mpage->aktifKelaminPGroup();
            $data['unknownAktifUmur']=$this->mpage->unknownAktifUmurGroup();
            $data['unknownAktifKelamin']=$this->mpage->unknownAktifKelaminGroup();
            $data['aktifYesTelp']=$this->mpage->aktifYesTelpGroup();
            $data['aktifNoTelp']=$this->mpage->aktifNoTelpGroup();
            $data['aktifSetor20']=$this->mpage->aktifSetor20Group();
            $data['aktifSetor2030']=$this->mpage->aktifSetor2030Group();
            $data['aktifSetor3050']=$this->mpage->aktifSetor3050Group();
            $data['aktifSetor50100']=$this->mpage->aktifSetor50100Group();
            $data['aktifSetor100']=$this->mpage->aktifSetor100Group();
            $data['target']=$this->mpage->TargetGroup();
            $data['tertagih']=$this->mpage->TertagihGroup();
            $data['keuangan']=$this->mpage->KeuanganGroup();
            $this->load->view('dashboard',$data);
        } else {
            $data['aktifUmur20']=$this->mpage->aktifUmur20User();
            $data['aktifUmur2030']=$this->mpage->aktifUmur2030User();
            $data['aktifUmur3040']=$this->mpage->aktifUmur3040User();
            $data['aktifUmur4050']=$this->mpage->aktifUmur4050User();
            $data['aktifUmur50']=$this->mpage->aktifUmur50User();
            $data['aktifKelaminL']=$this->mpage->aktifKelaminLUser();
            $data['aktifKelaminP']=$this->mpage->aktifKelaminPUser();
            $data['unknownAktifUmur']=$this->mpage->unknownAktifUmurUser();
            $data['unknownAktifKelamin']=$this->mpage->unknownAktifKelaminUser();
            $data['aktifYesTelp']=$this->mpage->aktifYesTelpUser();
            $data['aktifNoTelp']=$this->mpage->aktifNoTelpUser();
            $data['aktifSetor20']=$this->mpage->aktifSetor20User();
            $data['aktifSetor2030']=$this->mpage->aktifSetor2030User();
            $data['aktifSetor3050']=$this->mpage->aktifSetor3050User();
            $data['aktifSetor50100']=$this->mpage->aktifSetor50100User();
            $data['aktifSetor100']=$this->mpage->aktifSetor100User();
            $data['target']=$this->mpage->TargetUser();
            $data['tertagih']=$this->mpage->TertagihUser();
            $data['keuangan']=$this->mpage->KeuanganUser();
            $this->load->view('dashboard',$data);
        }}
        else {
          $this->load->view('dashboard');
        }
    }

    public function dashboard2() {
        $view = 'view';
        $this->load_lot_table($view);
    }

    public function load_lot_table($type) {
        if ($this->session->userdata('superadmin')== TRUE) {
            $data['targetJungut'] = $this->mpage->targetJungut();
            if($type == 'view') {
                return $this->load->view('dashboard2v2', $data);
            } elseif($type == 'refresh') {
                $view = 'view';
                $this->load_lot_table2($view);
            }
        } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang')==TRUE) {
            $data['targetJungut'] = $this->mpage->targetJungutCabang();
            $data['cabang'] = $this->mpage->daftarNamaCabang();
            if($type == 'view') {
                return $this->load->view('dashboard2v2', $data);
            } elseif($type == 'refresh') {
                $view = 'view';
                $this->load_lot_table2($view);
            }
        } else if ($this->session->userdata('admin_grup') == TRUE) {
            $data['targetJungut'] = $this->mpage->targetJungutGroup();
            if($type == 'view') {
                return $this->load->view('dashboard2v2', $data);
            } elseif($type == 'refresh') {
                $view = 'view';
                $this->load_lot_table2($view);
            }
        }
    }

    public function load_lot_tablev2($type) {
        if ($this->session->userdata('superadmin')== TRUE) {
            $data['targetJungut'] = $this->mpage->targetJungut();
            if($type == 'view') {
                return $this->load->view('dashboard2v2', $data);
            } elseif($type == 'refresh') {
                return $this->load->view('dashboard2v2', $data);
            }
        } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang')==TRUE) {
            $data['targetJungut'] = $this->mpage->targetJungutCabang();
            $data['cabang'] = $this->mpage->daftarNamaCabang();
            if($type == 'view') {
                return $this->load->view('dashboard2v2', $data);
            } elseif($type == 'refresh') {
                return $this->load->view('dashboard2v2', $data);
            }
        } else if ($this->session->userdata('admin_grup') == TRUE) {
            $data['targetJungut'] = $this->mpage->targetJungutGroup();
            if($type == 'view') {
                return $this->load->view('dashboard2v2', $data);
            } elseif($type == 'refresh') {
                return $this->load->view('dashboard2v2', $data);
            }
        }
    }

    public function load_lot_table2($type) {
        if ($this->session->userdata('superadmin')== TRUE) {
            // $data['presJungut'] = $this->mpage->presentaseJungut();
            $data['presJungut'] = $this->mpage->presentaseJungutv2();
            if($type == 'view') {
                return $this->load->view('grafik2v2', $data);
            } elseif($type == 'refresh') {
                $view = 'view';
                $this->load_lot_table5($view);
            }
        } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang')==TRUE) {
            // $data['presJungut'] = $this->mpage->presentaseJungutCabang();
            $data['presJungut'] = $this->mpage->presentaseJungutCabangv2();
            if($type == 'view') {
                return $this->load->view('grafik2v2', $data);
            } elseif($type == 'refresh') {
                $view = 'view';
                $this->load_lot_table5($view);
            }
        } else if ($this->session->userdata('admin_grup') == TRUE) {
            // $data['presJungut'] = $this->mpage->presentaseJungutGroup();
            $data['presJungut'] = $this->mpage->presentaseJungutGroupv2(); 
            if($type == 'view') {
                return $this->load->view('grafik2v2', $data);
            } elseif($type == 'refresh') {
                $view = 'view';
                $this->load_lot_table5($view);
            }
        }
    }

    public function load_lot_table5($type) {
        if ($this->session->userdata('superadmin')== TRUE) {
            // $data['laporanHarian'] = $this->mpage->laporanHarian();
            $data['laporanHarian'] = $this->mpage->laporanHarianv2();
            if($type == 'view') {
                return $this->load->view('grafik5v2', $data);
            } elseif($type == 'refresh') {
                $view = 'view';
                $this->load_lot_table3($view);
            }
        } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang')==TRUE) {
            // $data['laporanHarian'] = $this->mpage->laporanHarianCabang();
            $data['laporanHarian'] = $this->mpage->laporanHarianCabangv2();
            if($type == 'view') {
                return $this->load->view('grafik5v2', $data);
            } elseif($type == 'refresh') {
                $view = 'view';
                $this->load_lot_table3($view);
            }
        } else if ($this->session->userdata('admin_grup') == TRUE) {
            // $data['laporanHarian'] = $this->mpage->laporanHarianGroup();
            $data['laporanHarian'] = $this->mpage->laporanHarianGroupv2();
            if($type == 'view') {
                return $this->load->view('grafik5v2', $data);
            } elseif($type == 'refresh') {
                $view = 'view';
                $this->load_lot_table3($view);
            }
        }
    }

    public function load_lot_table3($type) {
        if ($this->session->userdata('superadmin')== TRUE) {
            $data['grafikJungutSetahun'] = $this->mpage->grafikJungutSetahun();
            $data['jgtSetahun'] = $this->mpage->JungutSetahun();
            if($type == 'view') {
                return $this->load->view('grafik3v2', $data);
            } elseif($type == 'refresh') {
                $view = 'view';
                $this->load_lot_table4($view);
            }
        } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang')==TRUE) {
            $data['grafikJungutSetahun'] = $this->mpage->grafikJungutSetahunCabang();
            $data['jgtSetahun'] = $this->mpage->JungutSetahunCabang();
            if($type == 'view') {
                return $this->load->view('grafik3v2', $data);
            } elseif($type == 'refresh') {
                $view = 'view';
                $this->load_lot_table4($view);
            }
        } else if ($this->session->userdata('admin_grup') == TRUE) {
            $data['grafikJungutSetahun'] = $this->mpage->grafikJungutSetahunGroup();
            $data['jgtSetahun'] = $this->mpage->JungutSetahunGroup();
            if($type == 'view') {
                return $this->load->view('grafik3v2', $data);
            } elseif($type == 'refresh') {
                $view = 'view';
                $this->load_lot_table4($view);
            }
        }
    }

    public function load_lot_table4($type) {
        if ($this->session->userdata('superadmin')== TRUE) {
            $data['masukKeluar'] = $this->mpage->donaturMasukKeluar();
            if($type == 'view') {
                return $this->load->view('grafik4v2', $data);
            } elseif($type == 'refresh') {
                $view = 'view';
                $this->load_lot_table($view);
            }
        } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang')==TRUE) {
            $data['masukKeluar'] = $this->mpage->donaturMasukKeluarCabang();
            if($type == 'view') {
                return $this->load->view('grafik4v2', $data);
            } elseif($type == 'refresh') {
                $view = 'view';
                $this->load_lot_table($view);
            }
        } else if ($this->session->userdata('admin_grup') == TRUE) {
            $data['masukKeluar'] = $this->mpage->donaturMasukKeluarGroup();
            if($type == 'view') {
                return $this->load->view('grafik4v2', $data);
            } elseif($type == 'refresh') {
                $view = 'view';
                $this->load_lot_table($view);
            }
        }
    }

    public function display_lot_table() {
        $refresh = 'refresh';
        $this->load_lot_table($refresh);
    }

    public function display_lot_tablev2() {
        $refresh = 'refresh';
        $this->load_lot_tablev2($refresh);
    }

    public function display_lot_table2() {
        $refresh = 'refresh';
        $this->load_lot_table2($refresh);
    }

    public function display_lot_table3() {
        $refresh = 'refresh';
        $this->load_lot_table3($refresh);
    }

    public function display_lot_table4() {
        $refresh = 'refresh';
        $this->load_lot_table4($refresh);
    }

    public function display_lot_table5() {
        $refresh = 'refresh';
        $this->load_lot_table5($refresh);
    }

    public function user() {
        if ($this->session->userdata('superadmin') == TRUE && $this->session->userdata('hak') == '0') {
            $data['user'] = $this->mlogin->getAll();
            $this->load->view('user', $data);
        } else {
            redirect(base_url('dashboard'));
        }
    }

    // public function indexUser() {
    //     $data['user'] = $this->mlogin->getAll();
    //     $this->load->view('dashboard_user', $data);
    // }

    public function report() {
        if ($this->session->userdata('superadmin') == TRUE) {
            $data['report'] = $this->mpage->getAll();
            $this->load->view('report', $data);
        } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
            $idcabang = $this->session->userdata('idcab');
            $data['report_dua'] = $this->mpage->getAllTwo($idcabang);
            $this->load->view('report', $data);
        } else if ($this->session->userdata('admin_grup') == TRUE) {
            $idgrup = $this->session->userdata('idgrup');
            $data['report_empat'] = $this->mpage->getAllFour($idgrup);
            $this->load->view('report', $data);
        } else {
            $kodej = $this->session->userdata('ses_kodej');
            $data['report_tiga'] = $this->mpage->getAllThree($kodej);
            $this->load->view('report', $data);
        }

    }

    public function cetakRekap() {
        if ($this->input->post()) {
            $tanggal = explode(" - ", $this->input->post('date'));
            $data['date'] = array(
                'tanggal1' => $tanggal[0],
                'tanggal2' => $tanggal[1]
            );
            $data['count'] = $this->mpage->getCount();
            $data['prl'] = $this->mpage->getPrltot();
            // $data['program'] = $this->mprogram->getProgram();
            $data['jumlah'] = $this->mprogram->getJumlah($tanggal[0], $tanggal[1]);
            $data['ptgs'] = $this->mpage->getPtgs();
            // echo $data['ptgs']->name;
            if ($this->input->post('cetak')) {
                $this->load->view('rekap', $data);
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

                //table 1

                $sheet->getStyle('A4:S5')->applyFromArray($styleArray);

                $sheet->setCellValue('A1', 'REKAP PEROLEHAN TOTAL PER JUNGUT')
                    ->mergeCells('A1:S1')->getStyle('A1')
                    ->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('A2', 'KODE JUNGUT : '.$data['ptgs']->kodej.$nbsp.$nbsp.$nbsp.'PERIODE : '.date('d-m-Y', strtotime($tanggal[0])).' s/d '.date('d-m-Y', strtotime($tanggal[1])).$nbsp.$nbsp.$nbsp.'TANGGAL CETAK : '.date('d-m-Y h:i'))
                    ->mergeCells('A2:S2')->getStyle('A2')
                    ->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('A4', 'No.')
                    ->mergeCells('A4:A5')->getStyle('A4')
                    ->getAlignment()->setVertical('center')
                    ->setHorizontal('center');
                $sheet->setCellValue('B4', 'Kawasan')
                    ->mergeCells('B4:B5')->getStyle('B4')
                    ->getAlignment()->setVertical('center')
                    ->setHorizontal('center');
                $sheet->setCellValue('C4', 'Target')
                    ->mergeCells('C4:D4')->getStyle('C4')
                    ->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('C5', 'Donatur')
                    ->getStyle('C5')->getAlignment()
                    ->setHorizontal('center');
                $sheet->setCellValue('D5', 'Donasi')
                    ->getStyle('D5')->getAlignment()
                    ->setHorizontal('center');
                $sheet->setCellValue('E4', 'RK')
                    ->mergeCells('E4:E5')->getStyle('E4')
                    ->getAlignment()->setVertical('center')
                    ->setHorizontal('center');
                $sheet->setCellValue('F4', 'Hasil')
                    ->mergeCells('F4:G4')->getStyle('F4')
                    ->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('F5', 'Donatur')
                    ->getStyle('F5')->getAlignment()
                    ->setHorizontal('center');
                $sheet->setCellValue('G5', 'Donasi')
                    ->getStyle('G5')->getAlignment()
                    ->setHorizontal('center');
                $sheet->setCellValue('H4', 'Gagal')
                    ->mergeCells('H4:I4')->getStyle('H4')
                    ->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('H5', 'Donatur')
                    ->getStyle('H5')->getAlignment()
                    ->setHorizontal('center');
                $sheet->setCellValue('I5', 'Donasi')
                    ->getStyle('I5')->getAlignment()
                    ->setHorizontal('center');
                $sheet->setCellValue('J4', 'Donatur Baru')
                    ->mergeCells('J4:K4')->getStyle('J4')
                    ->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('J5', 'Donatur')
                    ->getStyle('J5')->getAlignment()
                    ->setHorizontal('center');
                $sheet->setCellValue('K5', 'Donasi')
                    ->getStyle('K5')->getAlignment()
                    ->setHorizontal('center');
                $sheet->setCellValue('L4', 'Lebih')
                    ->mergeCells('L4:M4')->getStyle('L4')
                    ->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('L5', 'Donatur')
                    ->getStyle('L5')->getAlignment()
                    ->setHorizontal('center');
                $sheet->setCellValue('M5', 'Donasi')
                    ->getStyle('M5')->getAlignment()
                    ->setHorizontal('center');
                $sheet->setCellValue('N4', 'Total')
                    ->mergeCells('N4:O4')->getStyle('N4')
                    ->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('N5', 'Donatur')
                    ->getStyle('N5')->getAlignment()
                    ->setHorizontal('center');
                $sheet->setCellValue('O5', 'Donasi')
                    ->getStyle('O5')->getAlignment()
                    ->setHorizontal('center');
                $sheet->setCellValue('P4', '%')
                    ->mergeCells('P4:Q4')->getStyle('P4')
                    ->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('P5', 'DNT')
                    ->getStyle('P5')->getAlignment()
                    ->setHorizontal('center');
                $sheet->setCellValue('Q5', 'DNS')
                    ->getStyle('Q5')->getAlignment()
                    ->setHorizontal('center');
                $sheet->setCellValue('R4', 'Kwitansi Gagal')
                    ->mergeCells('R4:S4')->getStyle('R4')
                    ->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('R5', 'DNT')
                    ->getStyle('R5')->getAlignment()
                    ->setHorizontal('center');
                $sheet->setCellValue('S5', 'DNS')
                    ->getStyle('S5')->getAlignment()
                    ->setHorizontal('center');

                $row = 6;
                $sum1 = 0;$sum2 = 0;$sum3 = 0;$sum4 = 0;$sum5 = 0;$sum6 = 0;
                $sum7 = 0;$sum8 = 0;$sum9 = 0;$sum10 = 0;$sum11 = 0;$sum12 = 0;
                $sum13 = 0;$sum14 = 0;$sum15 = 0;$sum16 = 0;

                foreach ($data['prl'] as $key => $prl) {
                    $sum1 += $prl->Trg_dnt;$sum2 += $prl->trg_dns;$sum3 += $prl->hsl_dnt;
                    $sum4 += $prl->hsl_dns;$sum5 += $prl->ggl_dnt;$sum6 += $prl->ggl_dns;
                    $sum7 += $prl->br_dnt;$sum8 += $prl->br_dns;$sum9 += $prl->lb_dnt;
                    $sum10 += $prl->lb_dns;$sum11 += $prl->ttl_dnt;$sum12 += $prl->ttl_dns;
                    $sum15 += $prl->btl_dnt;$sum16 += $prl->btl_dns;
                    $sum13 += round(100*($prl->ttl_dnt/$prl->Trg_dnt) / $data['count']->total ,2);
                    $sum14 += round(100*($prl->ttl_dns/$prl->trg_dns) / $data['count']->total ,2);

                    $sheet->setCellValue('A'.$row,$key+1)->getStyle('A'.$row)->getAlignment()->setHorizontal('center');
                    $sheet->setCellValue('B'.$row,$prl->kwsn)->getStyle('B'.$row)->getAlignment()->setHorizontal('center');
                    $sheet->setCellValue('C'.$row,$prl->Trg_dnt)->getStyle('C'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('D'.$row,number_format($prl->trg_dns,0,'.',','))->getStyle('D'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('E'.$row,$prl->rk)->getStyle('E'.$row)->getAlignment()->setHorizontal('center');
                    $sheet->setCellValue('F'.$row,$prl->hsl_dnt)->getStyle('F'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('G'.$row,number_format($prl->hsl_dns,0,'.',','))->getStyle('G'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('H'.$row,$prl->ggl_dnt)->getStyle('H'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('I'.$row,number_format($prl->ggl_dns,0,'.',','))->getStyle('I'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('J'.$row,$prl->br_dnt)->getStyle('J'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('K'.$row,number_format($prl->br_dns,0,'.',','))->getStyle('K'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('L'.$row,$prl->lb_dnt)->getStyle('L'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('M'.$row,number_format($prl->lb_dns,0,'.',','))->getStyle('M'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('N'.$row,$prl->ttl_dnt)->getStyle('N'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('O'.$row,number_format($prl->ttl_dns,0,'.',','))->getStyle('O'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('P'.$row,round(100*($prl->ttl_dnt/$prl->Trg_dnt),2).'%')->getStyle('P'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('Q'.$row,round(100*($prl->ttl_dns/$prl->trg_dns),2).'%')->getStyle('Q'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('R'.$row,$prl->btl_dnt)->getStyle('R'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('S'.$row,$prl->btl_dns)->getStyle('S'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $row++;
                }

                $sheet->getStyle('A4:S'.$row)->applyFromArray($styleArray);
                // $baris = $row-=1;
                // echo $baris;
                $sheet->setCellValue('A'.$row, 'JUMLAH')
                    ->mergeCells('A'.$row.':B'.$row)->getStyle('A'.$row)
                    ->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('C'.$row, $sum1)
                    ->getStyle('C'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('D'.$row, number_format($sum2,0,'.',','))
                    ->getStyle('D'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('F'.$row, $sum3)
                    ->getStyle('F'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('G'.$row, number_format($sum4,0,'.',','))
                    ->getStyle('G'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('H'.$row, $sum5)
                    ->getStyle('H'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('I'.$row, number_format($sum6,0,'.',','))
                    ->getStyle('I'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('J'.$row, $sum7)
                    ->getStyle('J'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('K'.$row, number_format($sum8,0,'.',','))
                    ->getStyle('K'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('L'.$row, $sum9)
                    ->getStyle('L'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('M'.$row, number_format($sum10,0,'.',','))
                    ->getStyle('M'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('N'.$row, $sum11)
                    ->getStyle('N'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('O'.$row, number_format($sum12,0,'.',','))
                    ->getStyle('O'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('P'.$row, $sum13.'%')
                    ->getStyle('P'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('Q'.$row, $sum14.'%')
                    ->getStyle('Q'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('R'.$row, number_format($sum15,0,'.',','))
                    ->getStyle('R'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('S'.$row, number_format($sum16,0,'.',','))
                    ->getStyle('S'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                $row +=2;

                //table 2
                $sheet->setCellValue('A'.$row, 'No.')
                    ->getStyle('A'.$row)->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('B'.$row, 'Program')->mergeCells('B'.$row.':G'.$row)
                    ->getStyle('B'.$row)->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('H'.$row, 'Tertagih')->mergeCells('H'.$row.':J'.$row)
                    ->getStyle('H'.$row, 'Keuangan')->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('K'.$row, 'Keuangan')->mergeCells('K'.$row.':M'.$row)
                    ->getStyle('K'.$row)->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('N'.$row, 'Belum Setor')->mergeCells('N'.$row.':P'.$row)
                    ->getStyle('N'.$row)->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('Q'.$row, 'Kwitansi Balik')->mergeCells('Q'.$row.':S'.$row)
                    ->getStyle('Q'.$row)->getAlignment()->setHorizontal('center');

                $baris = $row+=1;
                // echo 'A'.$baris;
                $sum1 = 0;$sum2 = 0;$sum3 = 0;$sum4 = 0;

                foreach ($data['jumlah'] as $key => $jumlah) {
                    $sum1 += $jumlah->jumlah;
                    $sum2 += $jumlah->keuangan;
                    $sum3 += $jumlah->belum;
                    // $sum4 += $jumlah->kwitansi;
                    $sheet->setCellValue('A'.$baris, $key+1)->getStyle('A'.$baris)
                        ->getAlignment()->setHorizontal('center');
                    $sheet->setCellValue('B'.$baris, $jumlah->program)->mergeCells('B'.$baris.':G'.$baris);
                    $sheet->setCellValue('H'.$baris, number_format($jumlah->jumlah,0,'.',','))->mergeCells('H'.$baris.':J'.$baris)
                        ->getStyle('H'.$baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('K'.$baris, number_format($jumlah->keuangan,0,'.',','))->mergeCells('K'.$baris.':M'.$baris)
                        ->getStyle('K'.$baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->setCellValue('N'.$baris, number_format($jumlah->belum,0,'.',','))->mergeCells('N'.$baris.':P'.$baris)
                        ->getStyle('N'.$baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    foreach ($this->mprogram->getKwitansi($jumlah->prog) as $a) {
                        $sum4 += $a->kwitansi;
                        $sheet->setCellValue('Q'.$baris, number_format($a->kwitansi,0,'.',','))->mergeCells('Q'.$baris.':S'.$baris)
                            ->getStyle('Q'.$baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    }

                    $baris++;
                    // echo $baris;
                }

                $baris1 = $row-=1;
                $sheet->getStyle('A'.$baris1.':S'.$baris)->applyFromArray($styleArray);

                $sheet->setCellValue('A'.$baris, ' - ')->getStyle('A'.$baris)
                    ->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('B'.$baris, 'JUMLAH')->mergeCells('B'.$baris.':G'.$baris)
                    ->getStyle('B'.$baris)->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('H'.$baris, number_format($sum1,0,'.',','))->mergeCells('H'.$baris.':J'.$baris)
                    ->getStyle('H'.$baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('K'.$baris, number_format($sum2,0,'.',','))->mergeCells('K'.$baris.':M'.$baris)
                    ->getStyle('K'.$baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('N'.$baris, number_format($sum3,0,'.',','))->mergeCells('N'.$baris.':P'.$baris)
                    ->getStyle('N'.$baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('Q'.$baris, number_format($sum4,0,'.',','))->mergeCells('Q'.$baris.':S'.$baris)
                    ->getStyle('Q'.$baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                $row = $baris+=6;

                $sheet->setCellValue('A'.$row, 'Ttd. Kasir')->mergeCells('A'.$row.':F'.$row)
                    ->getStyle('A'.$row)->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('G'.$row, 'Ttd. Manager Penghimp.')->mergeCells('G'.$row.':M'.$row)
                    ->getStyle('G'.$row)->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('N'.$row, 'Ttd. Petugas Lapangan')->mergeCells('N'.$row.':S'.$row)
                    ->getStyle('N'.$row)->getAlignment()->setHorizontal('center');

                $row = $row+=7;

                $sheet->setCellValue('A'.$row, '('.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp
                .$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.')')->mergeCells('A'.$row.':F'.$row)
                    ->getStyle('A'.$row)->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('G'.$row, '('.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp
                .$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.$nbsp.')')->mergeCells('G'.$row.':M'.$row)
                    ->getStyle('G'.$row)->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('N'.$row, '( '.$data['ptgs']->name.' )')->mergeCells('N'.$row.':S'.$row)
                    ->getStyle('N'.$row)->getAlignment()->setHorizontal('center');

                $writer = new Xlsx($spreadsheet);
                $filename = 'rekap_jungut';

                // download file
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                // $this->load->view('rekapxls', $data);
            }
        } else {
            redirect(base_url('report'));
        }
    }

    public function addUser() {
        if ($this->session->userdata('superadmin') == TRUE && $this->session->userdata('hak') == '0'){
            $sec_users = $this->mpage;
            $check = $this->mpage->getUsrid();
            // echo "<pre>";
            // print_r($check);
            // echo "<pre>";return;
            if ($check > 0) {
            //     // $data = $check->row_array();
                for ($x = 0, $y = count($check); $x<=$y; $x++) {
                    if ($this->input->post()) {
                        if ($check[$x]['usrid'] != $this->input->post('usrid')) {
                            if ($x == $y) {
                                $sec_users->addUser();
                                $this->session->set_flashdata('success', 'user berhasil ditambahkan');
                                redirect(base_url('user'));
                            }
                            continue;
                        } else if ($check[$x]['usrid'] == $this->input->post('usrid'))  {
                            $this->session->set_flashdata('error', 'user id telah digunakan!');
                            redirect(base_url('user'));
                        } else {
                            $this->session->set_flashdata('error', 'user id telah digunakan!');
                            redirect(base_url('user'));
                        }
                    }
                }
            } else {
                echo "error";
            }

            $data['cabang'] = $this->mpage->cekCabang();
            $this->load->view('add_user', $data);
        } else {
            redirect(base_url('dashboard'));
        }

    }

    public function deleteUser($id = null) {
        if (!isset($id)) show_404();

        if ($this->mpage->deleteUser($id)) {
            redirect(base_url('user'));
        }
    }

    public function updateUser($id = null) {
        if ($this->session->userdata('superadmin') == TRUE && $this->session->userdata('hak') == '0') {
            if (!isset($id)) redirect(base_url('user'));
            $sec_users = $this->mpage;
            if ($this->input->post()) {
                $sec_users->updateUser();
                redirect(base_url('user'));
            }
            $data['cabang'] = $this->mpage->cekCabang();
            $data['user'] = $this->mpage->getUserById($id);
            if (!$data['user']) redirect(base_url('user'));
            $this->load->view('edit_user', $data);
        } else {
            redirect(base_url('dashboard'));
        }

    }


}

/* End of file Page.php */
