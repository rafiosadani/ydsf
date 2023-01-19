<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('partials/head') ?>
    <style type="text/css">
      body{
        color: black;
      }
      td{
        padding-left:0.3%;
      }
      hr{
        border-color: #999999;
        width: 99%;
        padding: 0;
        margin-top: 7px;
        margin-bottom: 9px;
      }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">

    <?php
    $tgl = $_GET['tgl'];
    $tgl1= substr($tgl,0,10);
    $tgl2= substr($tgl,12,12);
     ?>
    <div class="box-body table-responsive">
    <table border=0 width="100%">
	<tr style="font-family:verdana;font-size:17px">
		<td align="center">REKAP PENGEMBALIAN PENGHIMPUNAN</td>
		<td rowspan="3">&nbsp;<img src="http://ydsf1.exploremybos.com/inventori/images/logo-ydsf.png" width="110px" height="37x" ></td>
  </tr>
	<tr style="font-family:verdana;font-size:17px;">
		<td align="center">ATAS KWITANSI GAGAL ZIS</td>
	</tr>
  <tr style="font-family:arial;font-size:15px;">
    <td align="center">Yayasan Dana Sosial Al-Falah</td>
  </tr>
  <tr style="font-family:arial;font-size:15px;">
    <td align="center">PERIODE : <?php echo $tgl1." s/d ".$tgl2; ?> </td>
  </tr>
</table>
<br><br>
<table  width="100%" style="border:1px solid #999999;" >
  <tr>
    <td style="width:20%;">Noslip</td>
    <td style="width:20%;">Nama Program</td>
    <td style="width:20%;">Belum Koreksi</td>
    <td style="width:20%;">Koreksi</td>
    <td style="width:20%;">Setelah Koreksi</td>
  </tr>
  <tr>
    <td colspan="5" style="padding:0;"> <hr> </td>
  </tr>
  <?php foreach ($ggKwitansi as $gg): $jml = $gg->jumlah-$gg->jmlh; ?>
    <tr>
    <td style="font-size:12px;font-family:arial;"><?php echo $gg->noslip; ?></td>
    <td style="font-size:12px;font-family:arial;"><?php echo $gg->nm_program; ?></td>
    <td style="font-size:12px;font-family:arial;"><?php echo number_format($gg->jumlah,0,'.','.'); ?></td>
    <td style="font-size:12px;font-family:arial;"><?php echo number_format($gg->jmlh,0,'.','.'); ?></td>
    <td style="font-size:12px;font-family:arial;"><?php echo number_format($jml,0,'.','.'); ?></td>
    </tr>
  <?php endforeach ?>
  <tr>
    <td colspan="5" style="padding:0;"> <hr> </td>
  </tr>
  <tr>
    <td colspan="2"> <b>Jumlah</b> </td>
    <?php $tot=0; foreach ($ggKwitansi as $gg){
      $tot = $gg->jumlah+$tot;
    }?>
    <td> <b><?php echo "<p>Rp. ".number_format($tot,0,'.','.')."</p>"; ?></b> </td>
    <?php $tot=0; foreach ($ggKwitansi as $gg){
      $tot = $gg->jmlh+$tot;
    }?>
    <td> <b><?php echo "<p>Rp. ".number_format($tot,0,'.','.')."</p>"; ?></b> </td>
    <?php $tot=0; foreach ($ggKwitansi as $gg){
      $tot = ($gg->jumlah-$gg->jmlh)+$tot;
    }?>
    <td> <b><?php echo "<p>Rp. ".number_format($tot,0,'.','.')."</p>"; ?></b> </td>
    </tr>
</table>
<br>
<table style="width: 100%;border:1px solid #999999;">
  <?php
  function penyebut($nilai) {
  $nilai = abs($nilai);
  $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  $temp = "";
  if ($nilai < 12) {
    $temp = " ". $huruf[$nilai];
  } else if ($nilai <20) {
    $temp = penyebut($nilai - 10). " belas";
  } else if ($nilai < 100) {
    $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
  } else if ($nilai < 200) {
    $temp = " seratus" . penyebut($nilai - 100);
  } else if ($nilai < 1000) {
    $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
  } else if ($nilai < 2000) {
    $temp = " seribu" . penyebut($nilai - 1000);
  } else if ($nilai < 1000000) {
    $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
  } else if ($nilai < 1000000000) {
    $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
  } else if ($nilai < 1000000000000) {
    $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
  } else if ($nilai < 1000000000000000) {
    $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
  }
  return $temp;
}

function terbilang($nilai) {
  if($nilai<0) {
    $hasil = "minus ". trim(penyebut($nilai));
  } else {
    $hasil = trim(penyebut($nilai));
  }
  return $hasil;
}

$tot=0; foreach ($ggKwitansi as $gg){$tot = ($gg->jumlah-$gg->jmlh)+$tot;}
$angka = $tot;
   ?>
  <tr>
    <td style="font-family:arial;font-size:12px;height:20px;width:7%;">Terbilang</td>
    <td style="font-family:arial;font-size:12px;height:20px;"> <i> : <?php echo  ucfirst(terbilang($angka)); ?> rupiah</i> </td>
  </tr>
</table>
<br>
<table style="width: 100%;border:1px solid #999999;">
  <tr>
    <td style="font-family:arial;font-size:12px;width:7%;">Keterangan</td>
    <td style="font-family:arial;font-size:12px;"> : </td>
  </tr>
  <tr>
    <td colspan="2"> <br> </td>
  </tr>
</table>
<br><br>
<table style="width: 100%;border:1px solid #999999;">
  <tr><td colspan="3"> <br> </td></tr>
  <tr><td colspan="3"> <br> </td></tr>
  <tr align="center">
    <td style="width:30%;"> Ttd. Kasir </td>
    <td style="width:30%;"> Ttd. Adm Penghimp. </td>
    <td style="width:30%;"> Ttd. Petugas Lapangan </td>
  </tr>
  <tr><td colspan="3"> <br> </td></tr>
  <tr><td colspan="3"> <br> </td></tr>
  <tr><td colspan="3"> <br> </td></tr>
  <tr><td colspan="3"> <br> </td></tr>
  <tr align="center">
    <td>()</td>
    <td>()</td>
    <td>(<?php echo $_GET['nm']; ?>)</td>
  </tr>
  <tr><td colspan="3"> <br> </td></tr>
  <tr><td colspan="3"> <br> </td></tr>
</table>



  </body>
</html>
