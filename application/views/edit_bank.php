<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view('partials/head') ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css">
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css"
        rel="stylesheet" />
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
                    Edit Slip Bank
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Edit Slip Bank</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-info">
                            <div class="box-header">
                                <h3 class="box-title">Filter Pencarian</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <form action="edit-slip-bank" method="post">
                                        <div class="form-group">
                                            <div class="col-sm-4" >
                                                <label for="No slip bank" class="control-label">No Slip Bank</label>
                                                <?php if($this->input->post('noslip')||$this->input->get('slip')){
                                                foreach($search as $tampil){
                                                ?>
                                                <input type="text" class="form-control" value="<?= $tampil->noslip?>" id="noslip" name="noslip" >
                                                <?php }}else{ 
                                                ?>
                                                <input type="text" class="form-control" id="noslip" name="noslip" >
                                                <?php }?>  

                                            </div>

                                            <div class="col-sm-1" style="padding-top:25px;padding-bottom:20px;" >
                                                <button id="btnsearch" type="submit" name="search" class="btn btn-block btn-success">
                                                    <span><i class="fa fa-search"></i></span>
                                                    Cari
                                                </button>
                                            </div>
                                    </form> 
                                    <form action="<?php echo base_url('Edit_bank/bank')?>" method="post"> 

                                            <div class="col-sm-4">
                                                <label for="bank" class="control-label">Bank</label>
                                                <select class="form-control selectpicker" id="bank" name="bank" data-live-search="true">
                                                    <?php foreach($bank as $tampil) : ?>
                                                    <option name="bank" value="<?php echo $tampil->BANK ?>"><?php echo $tampil->NM_BANK ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <?php foreach($search as $tampil) : ?>
                                            <input type="hidden" name="noslip" value="<?= $tampil->noslip?>">
                                            <?php endforeach; ?>
                                            <div class="col-sm-2" style="padding-top:25px;padding-bottom:20px;" >
                                                <button id="btnsave" type="submit" name="save" class="btn btn-block btn-success">
                                                    <span><i class="fa fa-check"></i></span>
                                                    Simpan
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- /.box-body -->
                            </div>
                            <!-- </form> -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->

                </div>
                <!-- /.row (main row) -->


                <?php if($this->input->post('noslip')||$this->input->get('slip')){ ?>
                <div class="row" id="divTable">
                    <div class="col-xs-12">
                        <div class="box box-info">
                            <div class="box-header">
                                <h3 class="box-title"></h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="table" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No Slip</th>
                                                <th>Bank</th>
                                                <th>Kodej</th>
                                                <th>Tanggal</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($search as $tampil){?>
                                            <tr>
                                                <td><?= $tampil->noslip ?></td>
                                                <td><?= $tampil->bank ?></td>
                                                <td><?= $tampil->entr_pegawai ?></td>
                                                <td><?= $tampil->tgl_setor ?></td>
                                                <td><?= number_format($tampil->jml,0,'.','.') ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->

                </div>
                <?php } ?>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php $this->load->view('partials/footer') ?>


    </div>
    <!-- ./wrapper -->

    <?php $this->load->view('partials/modal') ?>

    <!-- <script>
    function deleteConfirm(url) {
      $('#btn-delete').attr('href', url);
      // $('#Delete').modal();
    }
  </script> -->
</body>
<?php $this->load->view('partials/js') ?>
<script type="text/javascript"
    src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
<?php foreach($search as $tampil){ ?>
<script>
$('select#bank').selectpicker("val" , '<?php echo $tampil->id_bank ?>');
</script>
<?php } ?>
</html>