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
                    Edit User
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="<?php echo base_url('user') ?>"><i class="fa fa-user"></i> User</a></li>
                    <li class="active">Edit User</li>
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
                                <h3 class="box-title">Edit User Form</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <form class="form-horizontal" action="<?php echo base_url("page/updateUser/".$user->usrid)
                                ?>" method="post">
                                <div class="box-body">
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <label for="usrid" class="control-label">UserId<span style="color: red"> *</span></label>
                                            <input type="number" class="form-control" id="usrid" name="usrid"
                                                placeholder="User id" value="<?php echo $user->usrid ?>" min="0"
                                                required readonly>
                                        </div>
                                        <div class="col-sm-5">
                                            <label for="username" class="control-label">Username<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="username" id="username"
                                                placeholder="input your Username" value="<?php echo $user->login ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <label for="password" class="control-label">Passsword<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="password" id="password"
                                                placeholder="input your Password" required value="<?php echo $user->pswd ?>">
                                        </div>
                                        <div class="col-sm-5">
                                            <label for="name" class="control-label">Name<span style="color: red"> *</span></label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="input your name"
                                                required value="<?php echo $user->name ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <label for="email" class="control-label">Email<span style="color: red"> *</span></label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="input your Email" required value="<?php echo $user->email ?>">
                                        </div>
                                        <div class="col-sm-5">
                                            <label for="active" class="control-label">Active</label>
                                            <input type="text" class="form-control" name="active" id="active"
                                                placeholder="this account is active?" value="<?php echo $user->active ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <label for="activcode" class="control-label">Activation code</label>
                                            <input type="text" class="form-control" name="activcode" id="activcode"
                                                placeholder="Activation Code" value="<?php echo $user->activation_code ?>">
                                        </div>
                                        <div class="col-sm-5">
                                            <label for="privadmin" class="control-label">Priv_admin</label>
                                            <input type="text" class="form-control" name="privadmin" id="privadmin"
                                                placeholder="Y/N" value="<?php echo $user->priv_admin ?>">
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <label for="idcabang" class="control-label">Id Cabang<span style="color: red">*</span></label>
                                            <select class="form-control selectpicker" name="idcabang" required data-live-search="true">
                                                <?php foreach ($cabang as $cabang) : ?>
                                                <option name="idcabang" selected value="<?php echo $cabang->id_cab ?>">
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
                                        </div><div class="col-sm-5">
                                            <label for="kodej" class="control-label">Kode Jungut</label>
                                            <input type="number" class="form-control" name="kodej" id="kodej"
                                                placeholder="Input kodej" min="0" value="<?php echo $user->kodej ?>">
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <label for="kodep" class="control-label">Kode Pusat</label>
                                            <input type="number" class="form-control" name="kodep" id="kodep"
                                                placeholder="Input kodep" min="0" value="<?php echo $user->kodep ?>">
                                        </div>
                                        <div class="col-sm-5">
                                            <label for="level" class="control-label">Level</label>
                                            <input type="text" class="form-control" name="level" id="level" placeholder="input user level"
                                                min="0" value="<?php echo $user->level ?>">
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <label for="tbh_akun" class="control-label">Tbh_akun<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="tbh_akun" id="tbh_akun"
                                                placeholder="input tbh_akun" required value="<?php echo $user->tbh_akun ?>">
                                        </div><div class="col-sm-5">
                                            <label for="idpintu" class="control-label">Id pintu<span style="color: red">*</span></label>
                                            <input type="number" class="form-control" name="idpintu" id="idpintu"
                                                placeholder="input id pintu" required min="0" max="99" value="<?php echo $user->id_pintu ?>">
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <label for="idgerai" class="control-label">Id gerai<span style="color: red">*</span></label>
                                            <input type="number" class="form-control" name="idgerai" id="idgerai"
                                                placeholder="input id gerai" required min="0" max="99" value="<?php echo $user->id_gerai ?>">
                                        </div>
                                        <div class="col-sm-5">
                                            <label for="hak" class="control-label">Hak</label>
                                            <input type="number" class="form-control" name="hak" id="hak" placeholder="input hak user"
                                                min="0" max="5" value="<?php echo $user->hak ?>">
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <label for="salkodej" class="control-label">Sal_kodej<span style="color: red">*</span></label>
                                            <input type="number" class="form-control" name="salkodej" id="salkodej"
                                                placeholder="input sal_kodej" required value="<?php echo $user->sal_kodej ?>">
                                        </div>
                                        <div class="col-sm-5">
                                            <label for="nip" class="control-label">Nip<span style="color: red"> *</span></label>
                                            <input type="number" class="form-control" name="nip" id="nip" placeholder="input nip user"
                                                required value="<?php echo $user->nip ?>">
                                        </div>

                                    </div>
                                    <div class="form-group">                                        
                                        <div class="col-sm-5">
                                            <label for="lapangan" class="control-label">Lapangan<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="lapangan" id="lapangan"
                                                placeholder="input lapangan" required value="<?php echo $user->lapangan ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <div class="col-md-8 col-md-offset-3">
                                        <input type="submit" class="btn btn-md btn-info pull-right" value="Edit User" />
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