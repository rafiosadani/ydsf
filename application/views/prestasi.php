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
          Rekap Prestasi Per Kawasan
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Per Prestasi</li>
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
                <h3 class="box-title">Per Prestasi</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal" action="<?php echo base_url('report/prestasi/rekap') ?>" method="post" target="_blank">
                <div class="box-body">
                  <div class="form-group">


                    <div class="col-sm-5">
                    <label for="jungut" class="control-label">Jungut<span style="color: red"> *</span></label>
                    <select id="jungut" class="form-control selectpicker" name="jungut" data-live-search="true">
                    <?php if ($this->session->userdata('superadmin') == TRUE) : ?>
                    <?php endif; ?>
                      <?php foreach ($jungut as $jungut) : ?>
                        <option value="<?php echo $jungut->kodej ?>"><?php echo "$jungut->kodej - $jungut->name"?></option>
                      <?php endforeach ?>
                    </select>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label for="tahun" class="control-label">Tahun<span style="color: red"> *</span></label>
                    <select id="tahun" class="form-control selectpicker" name="tahun" data-live-search="true">
                    <?php
                      for ($thn=2014; $thn <= date('Y') ; $thn++) {
                    ?>
                      <option value="<?php echo $thn; ?>"> <?php echo $thn; ?> </option>
                    <?php
                      }
                     ?>

                    </select>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label for="bulan" class="control-label">Bulan<span style="color: red"> *</span></label>
                    <select class="form-control selectpicker" name="bulan" data-live-search="true">
                    <option name="bulan" value="01">Januari</option>
                    <option name="bulan" value="02">Februari</option>
                    <option name="bulan" value="03">Maret</option>
                    <option name="bulan" value="04">April</option>
                    <option name="bulan" value="05">Mei</option>
                    <option name="bulan" value="06">Juni</option>
                    <option name="bulan" value="07">Juli</option>
                    <option name="bulan" value="08">Agustus</option>
                    <option name="bulan" value="09">September</option>
                    <option name="bulan" value="10">Oktober</option>
                    <option name="bulan" value="11">November</option>
                    <option name="bulan" value="12">Desember</option>
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
