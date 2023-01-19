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
      width: 100%;
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
    </style>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="box-body table-responsive">
      <p align="center"> <b>DATA DONATUR KAWASAN : <?php echo $_GET['kwsn']; ?> </b> </p>
      <table>
        <tr>
          <td style="width:5%;">No.</td>
          <td style="width:10%;">No Id.</td>
          <td style="width:25%;">Nama</td>
          <td style="width:50%;">Alamat</td>
          <td style="width:10%;">No Hp</td>
        </tr>
        <?php foreach ($kwsn_Nol as $no => $tampil) { ?>
          <tr>
            <td><?php echo $no+1 ?></td>
            <td><?php echo $tampil->noid ?></td>
            <td><?php echo $tampil->nama ?></td>
            <td><?php echo $tampil->almktr ?></td>
            <td><?php echo $tampil->telphp ?></td>
          </tr>
        <?php } ?>
      </table>
    </div>
  </body>
</html>
