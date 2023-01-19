<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php $this->load->view('partials/head') ?>
    <style type="text/css">
    body{
      margin-top: -9px;
      font-family: arial;
      font-size: 12px;
      margin-left: -10px;
      color: black;
    }
    table{
      margin-top: 0;
      width: 100%;
      margin: 0;
    }
    tr{
      border: 1px solid black;
      width: 100%;
      height: 18px;
    }
    td{
      border: 1px solid black;
      text-align: right;
      padding-left: 5px;
      padding-right: 5px;
    }
    span{
      padding-right: 10px;
      text-transform: uppercase;
    }
    </style>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="box-body table-responsive">
      <p style="text-align:center;width:100%;"><b>REKAP LAPORAN <br>
        <span><?php echo "WILAYAH : ".$wilayah; ?> </span> <span><?php echo "PROGRAM : ".$program; ?></span> <span>PERIODE : <?php echo $tahun; ?></span><span> TANGGAL CETAK : <?php date_default_timezone_set('Asia/Jakarta'); echo date("Y-m-d h:i:s");  ?></span> </b></p>
        <table>
          <tr>
            <td rowspan="2" style="text-align:left;">Bulan</td>
            <td colspan="2" style="text-align:left;">Target</td>
            <td colspan="2" style="text-align:left;">Perolehan</td>
            <td colspan="2" style="text-align:left;">%</td>
          </tr>
          <tr>
            <td style="text-align:left;">Donatur</td>
            <td style="text-align:left;">Donasi</td>
            <td style="text-align:left;">Donatur</td>
            <td style="text-align:left;">Donasi</td>
            <td style="text-align:left;">Donatur</td>
            <td style="text-align:left;">Donasi</td>
          </tr>
          <?php foreach ($perBln as $tampil) : ?>
          <tr>
            <td style="text-align:left;"><?php echo $tampil->BLN; ?></td>
            <td><?php echo number_format($tampil->T_DNT,0,'.',','); ?></td>
            <td><?php echo number_format($tampil->T_DNS,0,'.',','); ?></td>
            <td><?php echo number_format($tampil->H_DNT,0,'.',','); ?></td>
            <td><?php echo number_format($tampil->H_DNS,0,'.',','); ?></td>
            <td>
              <?php
              $target=0;$total=0;
              $target +=$tampil->T_DNT;
              $total +=$tampil->H_DNT;
              if ($target == '0') {
                echo "0%";
              }else {
              echo number_format(intval($total) / intval($target)*100,2,'.','.').'%';
            }?>
            </td>
            <td>
              <?php
              $target=0;$total=0;
              $target +=$tampil->T_DNS;
              $total +=$tampil->H_DNS;
              if ($target == '0') {
                echo "0%";
              }else {
              echo number_format(intval($total) / intval($target)*100,2 ,'.','.').'%';
            }
              ?>
            </td>
          </tr>
        <?php endforeach; ?>
        <tr>
          <td style="text-align:center;">JUMLAH</td>
          <td>
            <?php $tot=0; foreach($perBln as $tampil)
              $tot +=$tampil->T_DNT;
            echo number_format($tot,0,'.',',');
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($perBln as $tampil)
              $tot +=$tampil->T_DNS;
            echo number_format($tot,0,'.',',');
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($perBln as $tampil)
              $tot +=$tampil->H_DNT;
            echo number_format($tot,0,'.',',');
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($perBln as $tampil)
              $tot +=$tampil->H_DNS;
            echo number_format($tot,0,'.',',');
            ?>
          </td>
          <td>
            <?php $target=0;$total=0; foreach($perBln as $tampil){
              $target +=$tampil->T_DNT;
              $total +=$tampil->H_DNT;
            }
            if ($target == '0') {
              echo "0%";
            }else {
                echo number_format(intval($total)/intval($target)*100,2,'.','.').'%';
            }
            ?>
          </td>
          <td>
            <?php $target=0;$total=0; foreach($perBln as $tampil){
              $target +=$tampil->T_DNS;
              $total +=$tampil->H_DNS;
            }
            if ($target == '0') {
              echo  "0%";
            }else {
              echo number_format(intval($total)/intval($target)*100,2,'.','.').'%';
            }
            ?>
          </td>
        </tr>
        </table>
    </div>
  </body>
</html>
