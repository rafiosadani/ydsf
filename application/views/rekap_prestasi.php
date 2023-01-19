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
    }
    </style>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="box-body table-responsive">
      <p style="text-align:center;width:100%;"><b>REKAP PRESTASI TOTAL PER JUNGUT <br>
        <span>KODE JUNGUT : <?php echo $jungut; ?> </span><span>PERIODE : <?php echo $nm_bulan." ".$tahun; ?></span><span> TANGGAL CETAK : <?php date_default_timezone_set('Asia/Jakarta'); echo date("Y-m-d h:i:s");  ?></span> </b></p>
      <table>
        <tr>
          <td style="text-align:left;" rowspan="2">No</td>
          <td style="text-align:left;" rowspan="2">Kawasan</td>
          <td style="text-align:left;" colspan="2">Target</td>
          <td style="text-align:left;" rowspan="2">RK</td>
          <td style="text-align:left;" colspan="2">Hasil</td>
          <td style="text-align:left;" colspan="2">Gagal</td>
          <td style="text-align:left;" colspan="2">Donatur Baru</td>
          <td style="text-align:left;" colspan="2">Lebih</td>
          <td style="text-align:left;" colspan="2">Total</td>
          <td style="text-align:left;" colspan="2">%</td>
        </tr>
        <tr>
          <td style="text-align:left;">Donatur</td>
          <td style="text-align:left;">Donasi</td>
          <td style="text-align:left;">Donatur</td>
          <td style="text-align:left;">Donasi</td>
          <td style="text-align:left;">Donatur</td>
          <td style="text-align:left;">Donasi</td>
          <td style="text-align:left;">Donatur</td>
          <td style="text-align:left;">Donasi</td>
          <td style="text-align:left;">Donatur</td>
          <td style="text-align:left;">Donasi</td>
          <td style="text-align:left;">Donatur</td>
          <td style="text-align:left;">Donasi</td>
          <td style="text-align:left;">DNT</td>
          <td style="text-align:left;">DNS</td>
        </tr>
        <?php
         $no=1; foreach ($prestasi as $tampil) :?>
        <tr>
          <td style="text-align:left;"><?php echo $no; ?></td>
          <td style="text-align:left;"><?php echo $tampil->KWSN; ?></td>
          <td><?php echo $tampil->t_dnt; ?></td>
          <td><?php echo number_format($tampil->t_dns,0,'.',','); ?></td>
          <td style="text-align:left;"><?php echo $tampil->RK; ?></td>
          <td><?php echo $tampil->h_dnt; ?></td>
          <td><?php echo number_format($tampil->h_dns,0,'.',','); ?></td>
          <td><?php echo $tampil->g_dnt; ?></td>
          <td><?php echo number_format($tampil->g_dns,0,'.',','); ?></td>
          <td><?php echo $tampil->b_dnt; ?></td>
          <td><?php echo number_format($tampil->b_dns,0,'.',','); ?></td>
          <td><?php echo $tampil->l_dnt; ?></td>
          <td><?php echo number_format($tampil->l_dns,0,'.',','); ?></td>
          <td><?php echo $tampil->tt_dnt; ?></td>
          <td><?php echo number_format($tampil->tt_dns,0,'.',','); ?></td>
          <td>
            <?php
            $target=0;$total=0;
            $target +=$tampil->t_dnt;
            $total +=$tampil->tt_dnt;
            if ($target == '0') {
              echo "0%";
            }else {
            echo number_format(intval($total) / intval($target)*100,2,',',',').'%';
          }?>
          </td>
          <td>
            <?php
            $target=0;$total=0;
            $target +=$tampil->t_dns;
            $total +=$tampil->tt_dns;
            if ($target == '0') {
              echo "0%";
            }else {
            echo number_format(intval($total) / intval($target)*100,2 ,',',',').'%';
          }
            ?>
          </td>
        </tr>
      <?php $no++; endforeach ?>
        <tr>
          <td style="text-align:left;" colspan="2">JUMLAH</td>
          <td>
            <?php $tot=0; foreach($prestasi as $tampil)
              $tot +=$tampil->t_dnt;
            echo $tot;
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($prestasi as $tampil)
              $tot +=$tampil->t_dns;
            echo number_format($tot,0,'.',',');
            ?>
          </td>
          <td></td>
          <td>
            <?php $tot=0; foreach($prestasi as $tampil)
              $tot +=$tampil->h_dnt;
            echo $tot;
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($prestasi as $tampil)
              $tot +=$tampil->h_dns;
            echo number_format($tot,0,'.',',');
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($prestasi as $tampil)
              $tot +=$tampil->g_dnt;
            echo $tot;
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($prestasi as $tampil)
              $tot +=$tampil->g_dns;
            echo number_format($tot,0,'.',',');
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($prestasi as $tampil)
              $tot +=$tampil->b_dnt;
            echo $tot;
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($prestasi as $tampil)
              $tot +=$tampil->b_dns;
            echo number_format($tot,0,'.',',');
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($prestasi as $tampil)
              $tot +=$tampil->l_dnt;
            echo $tot;
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($prestasi as $tampil)
              $tot +=$tampil->l_dns;
            echo number_format($tot,0,'.',',');
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($prestasi as $tampil)
              $tot +=$tampil->tt_dnt;
            echo $tot;
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($prestasi as $tampil)
              $tot +=$tampil->tt_dns;
            echo number_format($tot,0,'.',',');
            ?>
          </td>
          <td>
            <?php $target=0;$total=0; foreach($prestasi as $tampil){
              $target +=$tampil->t_dnt;
              $total +=$tampil->tt_dnt;
            }
            if ($target == '0') {
              echo "0%";
            }else {
                echo number_format(intval($total)/intval($target)*100,2,',',',').'%';
            }
            ?>
          </td>
          <td>
            <?php $target=0;$total=0; foreach($prestasi as $tampil){
              $target +=$tampil->t_dns;
              $total +=$tampil->tt_dns;
            }
            if ($target == '0') {
              echo  "0%";
            }else {
              echo number_format(intval($total)/intval($target)*100,2,',',',').'%';
            }
            ?>
          </td>
        </tr>
      </table>
    </div>
  </body>
</html>
