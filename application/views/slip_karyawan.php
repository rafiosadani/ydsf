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
          Rekap Slip Karyawan
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Slip Karyawan</li>
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
                <h3 class="box-title">Slip Karyawan</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal" action="<?php echo base_url('umum/slip-karyawan/rekap') ?>" method="post" target="_blank">
                <div class="box-body">
                  <div class="form-group">


                    <div class="col-sm-5">
                    <label for="cabang" class="control-label">Nama Slip<span style="color: red"> *</span></label>
                    <select id="slip" class="form-control selectpicker" name="slip" data-live-search="true">        
                      <?php foreach ($slip as $slip) : ?>
                        <option name="slip" value="<?php echo $slip->id_ggroup ?>"><?php echo $slip->nm_ggroup ?></option>
                      <?php endforeach ?>
                    </select>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label for="jungut" class="control-label">Nama Karyawan<span style="color: red"> *</span></label>
                    <select id="karyawan" class="form-control selectpicker" name="karyawan" data-live-search="true">        
                      <?php foreach ($karyawan as $karyawan) : ?>
                        <option name="karyawan" value="<?php echo $karyawan->nip ?>"><?php echo $karyawan->nama ?></option>
                      <?php endforeach ?>
                    </select>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label for="cabang" class="control-label">Tahun<span style="color: red"> *</span></label>
                    <select class="form-control selectpicker" name="tahun" data-live-search="true">
                      <?php foreach ($tahun as $tahun) : ?>
                        <option name="tahun" value="<?php echo $tahun['tahun'] ?>"><?php echo $tahun['tahun'] ?></option>
                      <?php endforeach ?>
                    </select>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label  class="control-label">Bulan<span style="color: red"> *</span></label>
                    <select class="form-control selectpicker" name="bulan" data-live-search="true">
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
                    <div class="col-md-10 pull-right">
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

</html>