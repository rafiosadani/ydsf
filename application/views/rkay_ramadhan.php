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
          Rekap RKAY Ramadhan
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Rekap RKAY Ramadhan</li>
        </ol>
      </section>
      
            <!-- Main content -->
            <section class="content">

<!-- /.row -->
<!-- Main row -->
<form action="<?php echo base_url('rkay-ramadhan/cetak') ?>" method="post" target="_blank" >
<div class="row">
  <div class="col-xs-12">
    <div class="box box-info">
      <div class="box-body">
      <div class="form-group">
        <div class="col-sm-12">
        <label for="pintu" class="control-label"><h4>Pintu : </h4></label>
        <select class="form-control selectpicker"  name="pintu" data-live-search="true">
        <option name="pintu" value="-">--SEMUA PINTU--</option>
				<?php
				foreach ($pintu as $tampil) {
					?>
					<option name="pintu" value="<?php echo $tampil->id_pintu."|".$tampil->nm_pintu?>"><?php echo $tampil->kd_pintu.' - '.$tampil->nm_pintu?></option>
					<?php
				}
				?>
        </select>
        </div>
        </div>

        <div class="form-group">
        <div class="col-sm-12">
        <label for="format" class="control-label"><h4>Format : </h4></label>
        <select class="form-control selectpicker" style="background-color:white;" name="format" data-live-search="true">
        <option name="format" value="html">HTML</option>
        <option name="format" value="excel">EXCEL</option>
        </select>
        </div>
      </div>

			<div class="form-group">
				<div class="col-sm-12" align="right" style="padding-top:49px;padding-bottom:7px;">
					<input type="submit" name="submit" value="Tampilkan" style="padding:5px;padding-left:13px;padding-right:13px;border-radius:5px;border:1px;background:#7460EE;color:white">
				</div>
			</div>
      </div>
    </div>
  </div>
<!-- /.row (main row) -->

</section>
<!-- /.content -->
      
      
      
      
      
      </div>
			</form>
    

    <!-- /.content-wrapper -->
    <?php $this->load->view('partials/footer') ?>


    </div>
    <!-- ./wrapper -->

    <?php $this->load->view('partials/modal') ?>


</body>
<?php $this->load->view('partials/js') ?>
</html>
