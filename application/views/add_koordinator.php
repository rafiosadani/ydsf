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
          Add Koordinator
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="<?php echo base_url('data/koordinator') ?>">Koordinator</a></li>
          <li class="active">Koordinator baru</li>
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
                <h3 class="box-title">Add Koordinator Form</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <div class="container-fluid">
                <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-info" role="alert">
                  <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger" role="alert">
                    <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>
              </div>
              <form class="form-horizontal" action="<?php echo base_url("donatur/addKoor") ?>" method="post">
                <div class="box-body">
                  <div class="form-group">


                    <div class="col-sm-5">
                    <label for="nama" class="control-label">Nama<span style="color: red"> *</span></label>
                      <input type="text" class="form-control" name="nama" id="nama" placeholder="input Nama"
                        required>
                    </div>

                    <div class="col-sm-5">
                    <label for="tmplahir" class="control-label">Tempat Lahir<span style="color: red"> *</span></label>
                      <input type="text" class="form-control" name="tmplahir" id="tmplahir" placeholder="Tempat Lahir"
                        required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label for="tgllahir" class="control-label">Tanggal Lahir<span style="color: red"> *</span></label>
                      <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="tgllahir" class="form-control pull-right" id="tgllahir" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                </div> 
                    </div>

                    <div class="col-sm-5">
                    <label for="alamat" class="control-label">Alamat<span style="color: red"> *</span></label>
                      <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label for="hp" class="control-label">Handphone</label>
                      <input type="number" class="form-control" name="hp" id="hp" placeholder="input no handphone" min="0">
                    </div>

                    <div class="col-sm-5">
                    <label for="telp" class="control-label">Telp</label>
                      <input type="number" class="form-control" name="telp" id="telp" placeholder="input no telp" min="0">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                      <label for="pekerjaan" class="control-label">Pekerjaan</label>
                      <select class="form-control selectpicker" name="pekerjaan" data-live-search="true" required>
                      <?php foreach($pekerjaan as $kerja) : ?>  
                      <option name="kerja" value="<?php echo $kerja->PEKERJAAN ?>"><?php echo $kerja->NM_PEKERJAAN ?></option>
                      <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="col-sm-5">
                      <label for="jabatan" class="control-label">Jabatan</label>
                      <select class="form-control selectpicker" name="jabatan" data-live-search="true" required>
                      <?php foreach($jabatan as $jabatan) : ?>  
                      <option name="jabatan" value="<?php echo $jabatan->jabatan ?>"><?php echo $jabatan->nm_jabatan ?></option>
                      <?php endforeach; ?>
                      </select>
                    </div>

                    
                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                      <label for="hobby" class="control-label">Hobi</label>
                      <select class="form-control selectpicker" name="hobby" data-live-search="true" required>
                      <?php foreach($hobby as $hobi) : ?>  
                      <option name="hobby" value="<?php echo $hobi->hobby ?>"><?php echo $hobi->nm_hobby ?></option>
                      <?php endforeach; ?>
                      </select>

                    </div>
                    
                    <div class="col-sm-5">
                      <label for="pendidikan" class="control-label">Pendidikan</label>
                      <select class="form-control selectpicker" name="pendidikan" data-live-search="true" required>
                      <?php foreach($pendidikan as $pend) : ?>  
                      <option name="hobi" value="<?php echo $pend->PENDIDIKAN ?>"><?php echo $pend->NM_pendidikan ?></option>
                      <?php endforeach; ?>
                      </select>

                    </div>

                    
                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                      <label for="jupen" class="control-label">jupen</label>
                      <input type="number" class="form-control" name="jupen" id="jupen" placeholder="Input Jupen" min="0">
                    </div>
                    <div class="col-sm-5">
                      
                    </div>


                  </div>
                  <div class="form-group">
                      <div class="col-sm-5">
                      <table style="empty-cells: hide;">
                      <tr>
                        <td style="padding-right: 180px;display: none">nama jupen</td>
                      </tr>
                    </table>
                      </div>
                    </div>
                 
                </div>

                <!-- /.box-body -->
                <div class="box-footer">
                  <div class="col-md-8 col-md-offset-3">
                    <input type="submit" name="btnsave" class="btn btn-md btn-info pull-right" value="Simpan" />
                  </div>
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
<script>
  $(function () {
       //Date picker
    $('#tgllahir').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true
    });
    $('#tgllahir').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' });
  })
</script>

</html>