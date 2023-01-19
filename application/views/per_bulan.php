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
          Rekap Laporan Per Bulan
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Per Bulan</li>
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
                <h3 class="box-title">Per Bulan</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal" action="<?php echo base_url('report/perbulan/rekap') ?>" method="post" target="_blank">
                <div class="box-body">
                  <div class="form-group">


                    <div class="col-sm-5">
                    <label for="cabang" class="control-label">Cabang<span style="color: red"> *</span></label>
                    <select class="form-control selectpicker" name="cabang" data-live-search="true">
                    <?php if ($this->session->userdata('superadmin') == TRUE) : ?>
                    <option name="cabang" value="-">SEMUA CABANG</option>
                    <?php endif; ?>
                      <?php foreach ($cabang as $cabang) : ?>
                        <option name="cabang" value="<?php echo $cabang->cabang."|".$cabang->nm_cabang; ?>"><?php echo $cabang->nm_cabang; ?></option>
                      <?php endforeach ?>
                    </select>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label for="program" class="control-label">Program<span style="color: red"> *</span></label>
                    <select id="program" class="form-control selectpicker" name="program" data-live-search="true">
                      <option name="program" value="--">SEMUA PROGRAM</option>
                      <?php foreach ($prog as $prog) : ?>
                        <option name="program" value="<?php echo $prog->PROG."|".$prog->NM_PROGRAM; ?>"><?php echo $prog->NM_PROGRAM; ?></option>
                      <?php endforeach ?>
                    </select>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label for="tahun" class="control-label">Tahun<span style="color: red"> *</span></label>
                    <select id="tahun" class="form-control selectpicker" name="tahun" data-live-search="true">
                    <?php
                      for ($thn=2014; $thn <= date('Y'); $thn++) {
                    ?>
                      <option value="<?php echo $thn; ?>"> <?php echo $thn; ?> </option>
                    <?php
                      }
                     ?>

                    </select>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-md-10 pull-right">
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
<!-- <script>
  $(function () {
    $('#example1').DataTable()
  })
</script> -->

</html>
