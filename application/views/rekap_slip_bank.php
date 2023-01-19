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
      width: 100.5%;
      margin: 0;
    }
    tr{
      border: 1px solid black;
      width: 100%;
      height: 18px;
    }
    td{
      border: 1px solid black;
      text-align: left;
      padding-left: 5px;
      padding-right: 5px;
    }
    </style>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">

    <div class="box-body table-responsive">
      <table>
        <tr>
          <td style="text-align:center;border-top-width: 2px;padding:2px;" colspan="2">REKAP TOTAL SLIP PER JUNGUT</td>
        </tr>
        <tr>
          <td style="text-align:center;padding:2px;"> PERIODE : <?php echo date('d-m-Y',strtotime($date['date_himp1'])); ?> s/d <?php echo date('d-m-Y',strtotime($date['date_himp2'])); ?></td>
          <td style="text-align:center;padding:2px;"> TANGGAL CETAK : <?php date_default_timezone_set('Asia/Jakarta'); echo date("Y-m-d h:i:s"); ?></td>
        </tr>
      </table>
      <table>
        <tr>
          <td style="width:3%;">No.</td>
          <td>Entry Pegawai</td>
          <td style="width:9%">Jumlah</td>
          <td style="width:9%">Infaq</td>
          <td style="width:9%">Pena Bangsa</td>
          <td style="width:9%">Zakat</td>
          <td style="width:9%">Rumah Cinta Yatim</td>
          <td style="width:9%">Cinta Guru Quran</td>
          <td style="width:9%">Lain-Lain</td>
        </tr>
        <?php foreach ($perJgt as $no => $slip) :
          $id = $slip->entr_pegawai;
          if ($id == "") {

          }else {
          ?>
        <tr>
          <td><?php echo $no+1; ?></td>
          <td><?php echo $id; echo " - "; echo $slip->name; ?></td>
          <td><?php echo number_format($slip->total,0,'.',',') ?></td>
          <td><?php echo number_format($slip->infaq,0,'.',',') ?></td>
          <td><?php echo number_format($slip->pena,0,'.',',') ?></td>
          <td><?php echo number_format($slip->zakat,0,'.',',') ?></td>
          <td><?php echo number_format($slip->RCY,0,'.',',') ?></td>
          <td><?php echo number_format($slip->CGQ,0,'.',',') ?></td>
          <td><?php echo number_format($slip->dll,0,'.',',') ?></td>
        </tr>
      <?php } endforeach; ?>
        <tr>
          <td colspan="2" style="text-align:center;">JUMLAH</td>
          <td>
            <?php $tot=0; foreach($perJgt as $slip)
              $tot +=$slip->total;
            echo number_format($tot,0,'.',',');
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($perJgt as $slip)
              $tot +=$slip->infaq;
            echo number_format($tot,0,'.',',');
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($perJgt as $slip)
              $tot +=$slip->pena;
            echo number_format($tot,0,'.',',');
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($perJgt as $slip)
              $tot +=$slip->zakat;
            echo number_format($tot,0,'.',',');
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($perJgt as $slip)
              $tot +=$slip->RCY;
            echo number_format($tot,0,'.',',');
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($perJgt as $slip)
              $tot +=$slip->CGQ;
            echo number_format($tot,0,'.',',');
            ?>
          </td>
          <td>
            <?php $tot=0; foreach($perJgt as $slip)
              $tot +=$slip->dll;
            echo number_format($tot,0,'.',',');
            ?>
          </td>
        </tr>
      </table>
    </div>

  </body>
</html>
