<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('partials/head') ?>
    <style type="text/css">
      body{
        color: black;
      }
      td{
        border: 1px solid black;
        padding-left: 5px;
        padding-right: 5px;
        height: 14px;
      }
    </style>
</head>
  <body>
    <div class="box-body table-responsive">
      <p style="text-align:center;width:100%;"><b>REKAP SLIP NOSLIP : <?php echo $_GET['noslip'];; ?><br>
      <table style="width:100%;">
        <tr>
          <td style="width:40px;">No</td>
          <td style="width:20%;">Nama</td>
          <td style="width:38%;">Alamat</td>
          <td style="width:6%;">Kawasan</td>
          <td style="width:7%;">Kode Jungut</td>
          <td style="width:12%;">Program</td>
          <td style="width:7%;">Jumlah</td>
          <td style="width:6%;">Tanggal</td>
          <td>Gagal</td>
        </tr>
        <?php foreach ($ggKwitansi as $no => $tampil) : ?>
          <tr>
            <td><?php echo $no+1; ?></td>
            <td><?php echo $tampil->nama; ?></td>
            <td><?php echo $tampil->alamat; ?></td>
            <td align="center"><?php echo $tampil->kawasan ?></td>
            <td style="text-align:center;"><?php echo $tampil->kodej; ?></td>
            <td style="text-align:center;"><?php echo $tampil->prog; ?></td>
            <td align="center"><?php echo number_format($tampil->jumlah,0,'.','.'); ?></td>
            <td align="right"><?php echo substr($tampil->tanggal,0,10); ?></td>
            <td align="center"><?php echo $tampil->batal; ?></td>
          </tr>
        <?php endforeach; ?>
        <?php

        ?>
      </table>
    </div>
  </body>
</html>
