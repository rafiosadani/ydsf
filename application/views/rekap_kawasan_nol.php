<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php $this->load->view('partials/head') ?>
    <style type="text/css">
    body{
      margin-top: -9px;
      font-family: arial;
      font-size: 12px;
      color: black;
    }
    table{
      margin-top: 2%;
      width: 60%;
    }
    tr{
      border: 1px solid black;
      width: 100%;
      height: 18px;
    }
    td{
      border: 1px solid black;
      padding-left: 5px;
      padding-right: 5px;
    }
    span{
      padding-right: 10px;
      text-transform: uppercase;
    }
    .bawah td{
      border: none;
    }
    .bawah tr{
      border: none;
    }
    </style>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="box-body table-responsive">
      <?php $tgl = $_GET['tgl']; ?>
      <p align="center"><b> REKAP KAWASAN KURANG TARGET <br> <span> KODE JUNGUT : <?php echo $this->input->get('jungut'); ?> </span><span> PERIODE : <?php echo substr($tgl,0,10)." S/D ".substr($tgl,11,21); ?> </span><span>TANGGAL CETAK : <?php date_default_timezone_set('Asia/Jakarta'); echo date("Y-m-d h:i:s"); ?></span></b> </p>

      <table align="center">
        <tr>
          <td rowspan="2" style="width:4%;">No.</td>
          <td rowspan="2" style="width:20%;">Kawasan</td>
          <td rowspan="2">Nama Kawasan</td>
          <td colspan="2">Gagal Tagih</td>
          <td rowspan="2" style="width:4%;">RK</td>
        </tr>
        <tr>
          <td>Donatur</td>
          <td>Donasi</td>
        </tr>
        <?php foreach ($kwsnNol as $no => $tampil) : ?>
          <tr>
            <td><?php echo $no+1 ?></td>
            <td><?php echo $tampil->kwsn."/".$tampil->kwsn ?></td>
            <td><?php echo $tampil->ins_pk ?></td>
            <td align="right"><?php echo $tampil->noid ?></td>
            <td align="right"><?php echo number_format($tampil->infaq,0,'.','.') ?></td>
            <td align="right"><?php echo $tampil->rk ?></td>
          </tr>
        <?php endforeach; ?>
          <tr>
            <td colspan="3" align="center"> <b>TOTAL</b> </td>
            <?php $tot = 0; foreach($kwsnNol as $tampil){
              $tot = $tampil->noid+$tot;
            }?>
            <td align="right"><b><?php echo number_format($tot,0,'.','.') ?></b></td>
            <?php $tot = 0; foreach($kwsnNol as $tampil){
              $tot = $tampil->infaq+$tot;
            }?>
            <td align="right"><b><?php echo number_format($tot,0,'.','.') ?></b></td>
            <td></td>
          </tr>
      </table>
      <table align="center" class="bawah">
        <tr><td colspan="3"> <br> </td></tr>
        <tr><td colspan="3"> <br> </td></tr>
        <tr align="center">
          <td style="width:30%;"> Ttd. Kasir </td>
          <td style="width:30%;"> Ttd. Manager Penghimp. </td>
          <td style="width:30%;"> Ttd. Petugas Lapangan </td>
        </tr>
        <tr><td colspan="3"> <br> </td></tr>
        <tr><td colspan="3"> <br> </td></tr>
        <tr><td colspan="3"> <br> </td></tr>
        <tr><td colspan="3"> <br> </td></tr>
        <tr align="center">
          <td>( <span></span><span></span><span></span> )</td>
          <td>( <span></span><span></span><span></span> )</td>
          <td>(<?php echo " ".$_GET['nm']." "; ?>)</td>
        </tr>
        <tr><td colspan="3"> <br> </td></tr>
        <tr><td colspan="3"> <br> </td></tr>
      </table>
    </div>
  </body>
</html>
