<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mkwsn_nol extends CI_Model {

    public function getKawasanNol($kodej,$tgl1,$tgl2) {
        $bulan= substr($tgl1,5,2);
        $tahun= substr($tgl2,0,4);
        $bln= substr($tgl2,5,2);
        $hari= substr($tgl2,8,2);
        $day = $hari+1;
        $tgl2 = $tahun."-".$bln."-".$day;
        $query = $this->db->query("SELECT z.kwsn,SUM(jumlah) as jumlah,SUM(infaq) as infaq ,count(DISTINCT z.noid) as noid,x.kwsn,x.kwsn_lm,rk,ins_pk from (select a.noid_new AS noid,SUM(infaq) as infaq, a.kwsn FROM tagihandonatur a where Bulan=".$bulan." and kodej='".$kodej."' group by a.noid_new) z left join (SELECT noid,SUM(jumlah) as jumlah FROM report_tagih WHERE ((tanggal>= '".$tgl1."' and tanggal<= '".$tgl2."') OR tanggal like '".$tgl1."%' ) and (jenis='1' OR jenis='2' OR jenis='3' OR jenis='4' OR jenis='5' OR start!='') and kodej='".$kodej."' group by noid) y on y.noid= z.noid left join kawasan x on x.kwsn=z.kwsn WHERE jumlah IS NULL group by z.kwsn order by z.kwsn");
        return $query->result();
    }

    public function getDataDonatur($jungut,$tgl1,$tgl2,$kwsn){
      $bulan= substr($tgl1,5,2);
      $tahun= substr($tgl2,0,4);
      $bln= substr($tgl2,5,2);
      $hari= substr($tgl2,8,2);
      $day = $hari+1;
      $tgl2 = $tahun."-".$bln."-".$day;
      $query = $this->db->query("SELECT (z.noid) as noid,i.nama,i.almktr,i.telphp from (select a.noid_new AS noid,SUM(infaq) as infaq, a.kwsn FROM tagihandonatur a where Bulan=".$bulan." group by a.noid_new) z left join (SELECT noid,SUM(jumlah) as jumlah FROM report_tagih WHERE ((tanggal>= '".$tgl1."' and tanggal<= '".$tgl2."') OR tanggal like '".$tgl1."%' ) and (jenis='1' OR jenis='2' OR jenis='3' OR jenis='4' OR jenis='5' OR start!='') and kodej='".$jungut."' group by noid) y on y.noid= z.noid left join kawasan x on x.kwsn=z.kwsn left join donatur i on i.noid = z.noid WHERE jumlah IS NULL and x.kwsn = '".$kwsn."'");
      return $query->result();
    }
  }

 ?>
