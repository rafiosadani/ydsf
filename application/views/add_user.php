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
          Add User
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="<?php echo base_url('user') ?>"> User</a></li>
          <li class="active">User Baru</li>
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
                <h3 class="box-title">Add User Form</h3>
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
              <form class="form-horizontal" action="<?php echo base_url("page/addUser") ?>" method="post">
                <div class="box-body">
                  <div class="form-group">


                    <div class="col-sm-5">
                      <label for="usrid" class="control-label">UserId<span style="color: red"> *</span></label>
                      <input type="number" class="form-control" id="usrid" name="usrid" placeholder="User id" min="0"
                        required>
                    </div>

                    <div class="col-sm-5">
                      <label for="username" class="control-label">Username<span style="color: red"> *</span></label>
                      <input type="text" class="form-control" name="username" id="username" placeholder="input your Username"
                        required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                      <label for="password" class="control-label">Passsword<span style="color: red"> *</span></label>
                      <input type="text" class="form-control" name="password" id="password" placeholder="input your Password"
                        required>
                    </div>

                    <div class="col-sm-5">
                      <label for="name" class="control-label">Name<span style="color: red"> *</span></label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="input your name"
                        required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                      <label for="email" class="control-label">Email<span style="color: red"> *</span></label>
                      <input type="email" class="form-control" name="email" id="email" placeholder="input your Email"
                        required>
                    </div>

                    <div class="col-sm-5">
                      <label for="active" class="control-label">Active</label>
                      <input type="text" class="form-control" name="active" id="active" placeholder="this account is active?">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                      <label for="activcode" class="control-label">Activation code</label>
                      <input type="text" class="form-control" name="activcode" id="activcode" placeholder="Activation Code">
                    </div>

                    <div class="col-sm-5">
                      <label for="priv_admin" class="control-label">Priv_admin</label>
                      <input type="text" class="form-control" name="privadmin" id="privadmin" placeholder="Y/N">
                    </div>

                    
                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                      <label for="idcabang" class="control-label">Id Cabang<span style="color: red"> *</span></label>

                      <select class="form-control selectpicker" name="idcabang" required data-live-search="true">
                        <!-- <option name="idcabang" value="" selected>Pilih Cabang</option> -->
                        <?php foreach ($cabang as $cabang) : ?>
                        <option name="idcabang" value="<?php echo $cabang->id_cab ?>">
                          <?php echo $cabang->nm_cabang ?>
                        </option>
                        <?php endforeach ?>
                      </select>

                    </div>
                    
                    <div class="col-sm-5">
                      <label for="idpusat" class="control-label">Id Pusat</label>
                      <select class="form-control selectpicker" name="idpusat" data-live-search="true">
                        <option name="idpusat">option 1</option>
                      </select>

                    </div>

                    
                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                      <label for="idgroup" class="control-label">Id group</label>
                      <select class="form-control selectpicker" name="idgroup" data-live-search="true">
                        <option name="idgroup">option 1</option>
                      </select>

                    </div>
                    <div class="col-sm-5">
                      <label for="kodej" class="control-label">Kode Jungut</label>
                      <input type="number" class="form-control" name="kodej" id="kodej" placeholder="Input kodej" min="0">
                    </div>


                  </div>
                  <div class="form-group">
                                        <div class="col-sm-5">
                      <label for="kodep" class="control-label">Kode Pusat</label>
                      <input type="number" class="form-control" name="kodep" id="kodep" placeholder="Input kodep" min="0">
                    </div>
                    <div class="col-sm-5">
                      <label for="level" class="control-label">Level</label>
                      <input type="text" class="form-control" name="level" id="level" placeholder="input user level"
                        min="0">
                    </div>

                    
                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                      <label for="tbh_akun" class="control-label">Tbh_akun<span style="color: red"> *</span></label>
                      <input type="text" class="form-control" name="tbh_akun" id="tbh_akun" placeholder="input tbh_akun"
                        required>
                    </div>
                    <div class="col-sm-5">
                      <label for="idpintu" class="control-label">Id pintu<span style="color: red"> *</span></label>
                      <input type="number" class="form-control" name="idpintu" id="idpintu" placeholder="input id pintu"
                        required min="0" max="99">
                    </div>

                    
                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                      <label for="idgerai" class="control-label">Id gerai<span style="color: red"> *</span></label>
                      <input type="number" class="form-control" name="idgerai" id="idgerai" placeholder="input id gerai"
                        required min="0" max="99">
                    </div>
                    <div class="col-sm-5">
                      <label for="hak" class="control-label">Hak</label>
                      <input type="number" class="form-control" name="hak" id="hak" placeholder="input hak user" min="0"
                        max="5">
                    </div>

                  </div>
                  <div class="form-group">
                    
                    <div class="col-sm-5">
                      <label for="salkodej" class="control-label">Sal_kodej<span style="color: red"> *</span></label>
                      <input type="number" class="form-control" name="salkodej" id="salkodej" placeholder="input sal_kodej"
                        required min="0">
                    </div>
                    <div class="col-sm-5">
                      <label for="nip" class="control-label">Nip<span style="color: red"> *</span></label>
                      <input type="number" class="form-control" name="nip" id="nip" placeholder="input nip user"
                        required min="0">
                    </div>

                    
                  </div>

                  <div class="form-group"><div class="col-sm-5">
                      <label for="lapangan" class="control-label">Lapangan<span style="color: red"> *</span></label>
                      <input type="text" class="form-control" name="lapangan" id="lapangan" placeholder="input lapangan"
                        required>
                    </div>
</div>
                </div>

                <!-- /.box-body -->
                <div class="box-footer">
                  <div class="col-md-8 col-md-offset-3">
                    <input type="submit" class="btn btn-md btn-info pull-right" value="Add User" />
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

</html>