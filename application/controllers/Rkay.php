<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// Load library phpspreadsheet
require('./phpSpreadSheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class Rkay extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mrkay');
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
            $data['pintu'] = $this->mrkay->getPintu();
            $this->load->view('rkay', $data);
        } else {
            redirect(base_url());
        }
    }

    public function cetakRekap() {
        $bulan = $this->input->post('bulan');
        $cabang = $this->input->post('cabang');
        $pintu = $this->input->post('pintu');

        if ($this->input->post('btncetak')) {
            if ($cabang == '-') {
                if ($pintu == '-') {
                    if ($this->session->userdata('superadmin') == TRUE) {
                        $data['rkay'] = $this->mrkay->rkayAll2($bulan);
                    } else if ($this->session->userdata('admin_grup') == TRUE) {
                        $data['rkay'] = $this->mrkay->rkayGrupAll($bulan);
                    }
                } else {
                    if ($this->session->userdata('superadmin') == TRUE) {
                        $data['rkay'] = $this->mrkay->rkayAll($bulan,$pintu);
                    } else if ($this->session->userdata('admin_grup') == TRUE) {
                        $data['rkay'] = $this->mrkay->rkayGrup($bulan,$pintu);
                    }
                }
            } else {
                if ($pintu == '-') {
                    $data['rkay'] = $this->mrkay->rkay2($bulan,$cabang);
                } else {
                    $data['rkay'] = $this->mrkay->rkay($bulan,$cabang,$pintu);
                }
            }
            $this->load->view('rekap_rkay', $data);
        } else if ($this->input->post('btnchart')) {
            if ($cabang == '-') {
                if ($pintu == '-') {
                    if ($this->session->userdata('superadmin') == TRUE) {
                        $data['chartbanding'] = $this->mrkay->perbandinganAll2($bulan);
                        $data['chartoleh'] = $this->mrkay->perolehanAll2($bulan);
                        $data['thismonth'] = $this->mrkay->monthAll2($bulan);
                        $data['kumulatif'] = array();
                        $a = $b = $c = 0;
                        for ($x = 1;$x <= 12;$x++) {
                            $z = $this->mrkay->kumulatifAll2($x);
                            $a += $z->rkay2019;
                            $b += $z->per2019;
                            $c += $z->per2018;
                            $data['kumulatif'][] = [
                                "bulan" => $x,
                                "rkay2019" => $a,
                                "per2019" => $b,
                                "per2018" => $c
                            ];
                        }
                        // echo "<pre>";
                        // print_r($data['kumulatif']);
                        // echo "</pre>";
                        // return;
                    } else if ($this->session->userdata('admin_grup') == TRUE) {
                        $data['chartbanding'] = $this->mrkay->perbandinganGrup2($bulan);
                        $data['chartoleh'] = $this->mrkay->perolehanGrup2($bulan);
                        $data['thismonth'] = $this->mrkay->monthGrup2($bulan);
                        $data['kumulatif'] = array();
                        $a = $b = $c = 0;
                        for ($x = 1;$x <= 12;$x++) {
                            $z = $this->mrkay->kumulatifGrup2($x);
                            $a += $z->rkay2019;
                            $b += $z->per2019;
                            $c += $z->per2018;
                            $data['kumulatif'][] = [
                                "bulan" => $x,
                                "rkay2019" => $a,
                                "per2019" => $b,
                                "per2018" => $c
                            ];
                        }
                    }
                } else {
                    if ($this->session->userdata('superadmin') == TRUE) {
                        $data['chartbanding'] = $this->mrkay->perbandinganAll($bulan,$pintu);
                        $data['chartoleh'] = $this->mrkay->perolehanAll($bulan,$pintu);
                        $data['thismonth'] = $this->mrkay->monthAll($bulan,$pintu);
                        $data['kumulatif'] = array();
                        $a = $b = $c = 0;
                        for ($x = 1;$x <= 12;$x++) {
                            $z = $this->mrkay->kumulatifAll($x,$pintu);
                            $a += $z->rkay2019;
                            $b += $z->per2019;
                            $c += $z->per2018;
                            $data['kumulatif'][] = [
                                "bulan" => $x,
                                "rkay2019" => $a,
                                "per2019" => $b,
                                "per2018" => $c
                            ];
                        }
                    } else if ($this->session->userdata('admin_grup') == TRUE) {
                        $data['chartbanding'] = $this->mrkay->perbandinganGrup($bulan,$pintu);
                        $data['chartoleh'] = $this->mrkay->perolehanGrup($bulan,$pintu);
                        $data['thismonth'] = $this->mrkay->monthGrup($bulan,$pintu);
                        $data['kumulatif'] = array();
                        $a = $b = $c = 0;
                        for ($x = 1;$x <= 12;$x++) {
                            $z = $this->mrkay->kumulatifAll2($x,$pintu);
                            $a += $z->rkay2019;
                            $b += $z->per2019;
                            $c += $z->per2018;
                            $data['kumulatif'][] = [
                                "bulan" => $x,
                                "rkay2019" => $a,
                                "per2019" => $b,
                                "per2018" => $c
                            ];
                        }
                    }
                }
            } else {
                if ($pintu == '-') {
                    $data['chartbanding'] = $this->mrkay->perbandingan2($bulan,$cabang);
                    $data['chartoleh'] = $this->mrkay->perolehan2($bulan,$cabang);
                    $data['thismonth'] = $this->mrkay->month2($bulan,$cabang);
                    $data['kumulatif'] = array();
                    $a = $b = $c = 0;
                    for ($x = 1;$x <= 12;$x++) {
                        $z = $this->mrkay->kumulatif2($x,$cabang);
                        $a += $z->rkay2019;
                        $b += $z->per2019;
                        $c += $z->per2018;
                        $data['kumulatif'][] = [
                            "bulan" => $x,
                            "rkay2019" => $a,
                            "per2019" => $b,
                            "per2018" => $c
                        ];
                    }
                } else {
                    $data['chartbanding'] = $this->mrkay->perbandingan($bulan,$cabang,$pintu);
                    $data['chartoleh'] = $this->mrkay->perolehan($bulan,$cabang,$pintu);
                    $data['thismonth'] = $this->mrkay->month($bulan,$cabang,$pintu);
                    $data['kumulatif'] = array();
                    $a = $b = $c = 0;
                    for ($x = 1;$x <= 12;$x++) {
                        $z = $this->mrkay->kumulatif($x,$cabang,$pintu);
                        $a += $z->rkay2019;
                        $b += $z->per2019;
                        $c += $z->per2018;
                        $data['kumulatif'][] = [
                            "bulan" => $x,
                            "rkay2019" => $a,
                            "per2019" => $b,
                            "per2018" => $c
                        ];
                    }
                }
            }
            $this->load->view('chart_rkay', $data);
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

            if ($cabang == '-') {
                if ($pintu == '-') {
                    if ($this->session->userdata('superadmin') == TRUE) {
                        $data = $this->mrkay->rkayAll2($bulan);
                    } else if ($this->session->userdata('admin_grup') == TRUE) {
                        $data = $this->mrkay->rkayGrupAll($bulan);
                    }
                } else {
                    if ($this->session->userdata('superadmin') == TRUE) {
                        $data = $this->mrkay->rkayAll($bulan,$pintu);
                    } else if ($this->session->userdata('admin_grup') == TRUE) {
                        $data = $this->mrkay->rkayGrup($bulan,$pintu);
                    }
                }
            } else {
                if ($pintu == '-') {
                    $data = $this->mrkay->rkay2($bulan,$cabang);
                } else {
                    $data = $this->mrkay->rkay($bulan,$cabang,$pintu);
                }
            }

            $cbg = "";
            $grup = "";
            $data1 = $this->mrkay->getCabGrup();
            for($a = 0;$a < count($data1);$a++) {
                if ($data1[$a]->id_cab == $this->input->post('cabang')) {
                    $cbg = $data1[$a]->nm_cabang;
                    $grup = $data1[$a]->nm_group;
                }
            }

            $pnt = "";
            $data2 = $this->mrkay->getPintu();
            if ($this->input->post('pintu') == '-') {
                $pnt = "SEMUA PINTU";
            } else {
                for ($a = 0;$a < count($data2);$a++) {
                    if ($data2[$a]->id_pintu_rtn == $this->input->post('pintu')) {
                        $pnt = strtoupper($data2[$a]->nm_pinturtn);
                    }
                }
            }

            $data3 = array(
                0 => [
                    "id" => 1,
                    "bulan" => "Januari"
                ],
                1 => [
                    "id" => 2,
                    "bulan" => "Februari"
                ],
                2 => [
                    "id" => 3,
                    "bulan" => "Maret"
                ],
                3 => [
                    "id" => 4,
                    "bulan" => "April"
                ],
                4 => [
                    "id" => 5,
                    "bulan" => "Mei"
                ],
                5 => [
                    "id" => 6,
                    "bulan" => "Juni"
                ],
                6 => [
                    "id" => 7,
                    "bulan" => "Juli"
                ],
                7 => [
                    "id" => 8,
                    "bulan" => "Agustus"
                ],
                8 => [
                    "id" => 9,
                    "bulan" => "September"
                ],
                9 => [
                    "id" => 10,
                    "bulan" => "Oktober"
                ],
                10 => [
                    "id" => 11,
                    "bulan" => "November"
                ],
                11 => [
                    "id" => 12,
                    "bulan" => "Desember"
                ],
            );
            $bln = "";
            for ($a = 0;$a < count($data3);$a++) {
                if ($data3[$a]['id'] == $this->input->post('bulan')) {
                    $bln = $data3[$a]['bulan'];
                }
            }

            $sheet->setCellValue('A1', "REKAP RKAY")->mergeCells('A1:R1')
                ->getStyle('A1')->getAlignment()->setHorizontal('center');
            if ($this->input->post('cabang') == '-') {
                $sheet->setCellValue('A2', "SEMUA CABANG - PINTU ".$pnt)->mergeCells('A2:R2')
                    ->getStyle('A2')->getAlignment()->setHorizontal('center');
            } else {
                $sheet->setCellValue('A2', "YDSF ".$grup." CABANG ".$cbg." PINTU ".$pnt)->mergeCells('A2:R2')
                    ->getStyle('A2')->getAlignment()->setHorizontal('center');
            }
            $sheet->setCellValue('A3', "Nama Program")->mergeCells('A3:C4')
                ->getStyle('A3')->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->setCellValue('D3', "Bulan ".$bln)->mergeCells('D3:H3')
                ->getStyle('D3')->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('I3', "Bulan Januari sd ".$bln)->mergeCells('I3:M3')
                ->getStyle('I3')->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('N3', "Pencapaian Setahun")->mergeCells('N3:R3')
                ->getStyle('N3')->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('D4', "Rkay 2019(a)")->getStyle('D4')
                ->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('E4', "Perolehan 2019(b)")->getStyle('E4')
                ->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('F4', "Perolehan 2018(c)")->getStyle('F4')
                ->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('G4', "%(b vs a)")->getStyle('G4')
                ->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('H4', "%(b vs c)")->getStyle('H4')
                ->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('I4', "Rkay 2019(a)")->getStyle('I4')
                ->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('J4', "Perolehan 2019(b)")->getStyle('J4')
                ->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('K4', "Perolehan 2018(c)")->getStyle('K4')
                ->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('L4', "%(b vs a)")->getStyle('L4')
                ->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('M4', "%(b vs c)")->getStyle('M4')
                ->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('N4', "Rkay 2019(a)")->getStyle('N4')
                ->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('O4', "Perolehan 2019(b)")->getStyle('O4')
                ->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('P4', "Perolehan 2018(c)")->getStyle('P4')
                ->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('Q4', "%(b vs a)")->getStyle('Q4')
                ->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('R4', "%(b vs c)")->getStyle('R4')
                ->getAlignment()->setHorizontal('center');

            $row = 5;
            $sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = $sum7 = $sum8 = $sum9 = 0;
            foreach ($data as $value) {
                $sum1 += $value->rkay20191;
                $sum2 += $value->per20191;
                $sum3 += $value->per20181;
                $sum4 += $value->rkay20192;
                $sum5 += $value->per20192;
                $sum6 += $value->per20182;
                $sum7 += $value->rkay20193;
                $sum8 += $value->per20193;
                $sum9 += $value->per20183;

                $sheet->setCellValue('A'.$row, $value->rkay_2)->getStyle('A'.$row);
                $sheet->setCellValue('B'.$row, $value->rkay_1)->getStyle('B'.$row);
                $sheet->setCellValue('C'.$row, $value->nm_rkay)->getStyle('C'.$row);
                $sheet->setCellValue('D'.$row, number_format($value->rkay20191,0,'.',','))->getStyle('D'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('E'.$row, number_format($value->per20191,0,'.',','))->getStyle('E'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('F'.$row, number_format($value->per20181,0,'.',','))->getStyle('F'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                if ($value->per20191 == 0 || $value->rkay20191 == 0) {
                    $sheet->setCellValue('G'.$row, '0.00%')->getStyle('G'.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                } else if ($value->per20191 != 0 && $value->rkay20191 != 0) {
                    $sheet->setCellValue('G'.$row, round(100*($value->per20191/$value->rkay20191),2)."%")->getStyle('G'.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                }
                if ($value->per20191 == 0 || $value->per20181 == 0) {
                    $sheet->setCellValue('H'.$row, '0.00%')->getStyle('H'.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                } else if ($value->per20191 != 0 && $value->per20181 != 0) {
                    $sheet->setCellValue('H'.$row, round(100*($value->per20191/$value->per20181),2)."%")->getStyle('H'.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                }
                $sheet->setCellValue('I'.$row, number_format($value->rkay20192,0,'.',','))->getStyle('I'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('J'.$row, number_format($value->per20192,0,'.',','))->getStyle('J'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('K'.$row, number_format($value->per20182,0,'.',','))->getStyle('K'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                if ($value->per20192 == 0 || $value->rkay20192 == 0) {
                    $sheet->setCellValue('L'.$row, '0.00%')->getStyle('L'.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                } else if ($value->per20192 != 0 && $value->rkay20192 != 0) {
                    $sheet->setCellValue('L'.$row, round(100*($value->per20192/$value->rkay20192),2)."%")->getStyle('L'.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                }
                if ($value->per20192 == 0 || $value->per20182 == 0) {
                    $sheet->setCellValue('M'.$row, '0.00%')->getStyle('M'.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                } else if ($value->per20192 != 0 && $value->per20182 != 0) {
                    $sheet->setCellValue('M'.$row, round(100*($value->per20192/$value->per20182),2)."%")->getStyle('M'.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                }
                $sheet->setCellValue('N'.$row, number_format($value->rkay20193,0,'.',','))->getStyle('N'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('O'.$row, number_format($value->per20193,0,'.',','))->getStyle('O'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('P'.$row, number_format($value->per20183,0,'.',','))->getStyle('P'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                if ($value->per20193 == 0 || $value->rkay20193 == 0) {
                    $sheet->setCellValue('Q'.$row, '0.00%')->getStyle('Q'.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                } else if ($value->per20193 != 0 && $value->rkay20193 != 0) {
                    $sheet->setCellValue('Q'.$row, round(100*($value->per20193/$value->rkay20193),2)."%")->getStyle('Q'.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                }
                if ($value->per20193 == 0 || $value->per20183 == 0) {
                    $sheet->setCellValue('R'.$row, '0.00%')->getStyle('R'.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                } else if ($value->per20193 != 0 && $value->per20183 != 0) {
                    $sheet->setCellValue('R'.$row, round(100*($value->per20193/$value->per20183),2)."%")->getStyle('R'.$row)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                }
                $row++;
            }

            $sheet->setCellValue('A'.$row, "TOTAL JUMLAH")->mergeCells('A'.$row.':C'.$row)
                ->getStyle('A'.$row)->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->setCellValue('D'.$row, number_format($sum1,0,'.',','))->getStyle('D'.$row)
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('E'.$row, number_format($sum2,0,'.',','))->getStyle('E'.$row)
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('F'.$row, number_format($sum3,0,'.',','))->getStyle('F'.$row)
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            if ($sum2 == 0 || $sum1 == 0) {
                $sheet->setCellValue('G'.$row, '0.00%')->getStyle('G'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            } else if ($sum2 != 0 && $sum1 != 0 ) {
                $sheet->setCellValue('G'.$row, round(100*($sum2/$sum1),2)."%")->getStyle('G'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            }
            if ($sum2 == 0 || $sum3 == 0) {
                $sheet->setCellValue('H'.$row, '0.00%')->getStyle('H'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            } else if ($sum2 != 0 && $sum3 != 0 ) {
                $sheet->setCellValue('H'.$row, round(100*($sum2/$sum3),2)."%")->getStyle('H'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            }
            $sheet->setCellValue('I'.$row, number_format($sum4,0,'.',','))->getStyle('I'.$row)
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('J'.$row, number_format($sum5,0,'.',','))->getStyle('J'.$row)
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('K'.$row, number_format($sum6,0,'.',','))->getStyle('K'.$row)
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            if ($sum5 == 0 || $sum4 == 0) {
                $sheet->setCellValue('L'.$row, '0.00%')->getStyle('L'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            } else if ($sum5 != 0 && $sum4 != 0 ) {
                $sheet->setCellValue('L'.$row, round(100*($sum5/$sum4),2)."%")->getStyle('L'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            }
            if ($sum5 == 0 || $sum6 == 0) {
                $sheet->setCellValue('M'.$row, '0.00%')->getStyle('M'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            } else if ($sum5 != 0 && $sum6 != 0 ) {
                $sheet->setCellValue('M'.$row, round(100*($sum5/$sum6),2)."%")->getStyle('M'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            }
            $sheet->setCellValue('N'.$row, number_format($sum7,0,'.',','))->getStyle('N'.$row)
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('O'.$row, number_format($sum8,0,'.',','))->getStyle('O'.$row)
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('P'.$row, number_format($sum9,0,'.',','))->getStyle('P'.$row)
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            if ($sum8 == 0 || $sum7 == 0) {
                $sheet->setCellValue('Q'.$row, '0.00%')->getStyle('Q'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            } else if ($sum8 != 0 && $sum7 != 0 ) {
                $sheet->setCellValue('Q'.$row, round(100*($sum8/$sum7),2)."%")->getStyle('Q'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            }
            if ($sum8 == 0 || $sum9 == 0) {
                $sheet->setCellValue('R'.$row, '0.00%')->getStyle('R'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            } else if ($sum8 != 0 && $sum9 != 0 ) {
                $sheet->setCellValue('R'.$row, round(100*($sum8/$sum9),2)."%")->getStyle('R'.$row)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            }

            $sheet->getStyle('A3:R'.$row)->applyFromArray($styleArray); 

            for ($x = 'A';$x <= 'R';$x++) {
                $sheet->getColumnDimension($x)->setAutoSize(true);
            }
            
            $writer = new Xlsx($spreadsheet);
            $filename = 'rekap_rkay';
            
            // download file
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        }   
    }

}

/* End of file Rkay.php */
