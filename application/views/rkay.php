<!DOCTYPE html>
<html>

<head>
  <?php $this->load->view('partials/head') ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php $this->load->view('partials/header') ?>
    <!-- Left side column. contains the logo and sidebar -->
    <?php $this->load->view('partials/sidebar') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Rekap RKAY
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Rekap RKAY</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <div class="col-xs-12">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">RKAY</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal" action="<?php echo base_url('keuangan/rkay/rekap') ?>" method="post" target="_blank">
                <div class="box-body">
                  <div class="form-group">


                    <div class="col-sm-5">
                    <label for="cabang" class="control-label">Cabang<span style="color: red"> *</span></label>
                    <select class="form-control selectpicker" name="cabang" data-live-search="true">
                    <?php if ($this->session->userdata('superadmin') == TRUE  || $this->session->userdata('admin_grup') == TRUE) : ?>
                    <option name="cabang" value="-">SEMUA CABANG</option>
                    <?php endif; ?>
                      <?php foreach ($cabang as $cabang) : ?>
                        <option name="cabang" value="<?php echo $cabang->id_cab ?>"><?php echo $cabang->nm_cabang; ?></option>
                      <?php endforeach ?>
                    </select>
                    </div>

                  </div>
                  
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label for="pintu" class="control-label">Pintu<span style="color: red"> *</span></label>
                    <select id="pintu" class="form-control selectpicker" name="pintu" data-live-search="true">
                    <option value="-">SEMUA PINTU</option>
                    <?php foreach ($pintu as $pintu) : ?>
                      <option value="<?php echo $pintu->id_pintu_rtn; ?>"> <?php echo $pintu->kd_ptn." - ".$pintu->nm_pinturtn ?> </option>
                    <?php endforeach; ?>

                    </select>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label for="bulan" class="control-label">Bulan<span style="color: red"> *</span></label>
                    <select id="bulan" class="form-control selectpicker" name="bulan" data-live-search="true">
                        <option name="bulan" value="1">Januari</option>
                        <option name="bulan" value="2">Februari</option>
                        <option name="bulan" value="3">Maret</option>
                        <option name="bulan" value="4">April</option>
                        <option name="bulan" value="5">Mei</option>
                        <option name="bulan" value="6">Juni</option>
                        <option name="bulan" value="7">Juli</option>
                        <option name="bulan" value="8">Agustus</option>
                        <option name="bulan" value="9">September</option>
                        <option name="bulan" value="10">Oktober</option>
                        <option name="bulan" value="11">November</option>
                        <option name="bulan" value="12">Desember</option>
                    </select>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-md-12 pull-right">
                    <input type="submit" name="btnchart" class="btn btn-lg btn-danger" value="export to chart" />
                    <input type="submit" name="btnexcel" class="btn btn-lg btn-success" value="Export to excel" />
                    <input type="submit" name="btncetak" class="btn btn-lg btn-info" value="Cetak" />
                    </div>


                  </div>


                <!-- /.box-body -->
                <div class="box-footer">

                </div>
                <!-- /.box-footer -->
              </form>
            </div>
          </div>
          <!-- /.col -->

        </div>
        <!-- /.row (main row) -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view('partials/footer') ?>


  </div>
  <!-- ./wrapper -->

  <?php $this->load->view('partials/modal') ?>


</body>
<?php $this->load->view('partials/js') ?>
<script>
  // $(function () {
  //   $('#example1').DataTable()
  // })
  // var tahun = "<?php echo date('Y') ?>"
  var bulan = "<?php echo date('n') ?>"
  // $("select#tahun").val(tahun);
  $("select#bulan").val(bulan);
</script>

</html>
